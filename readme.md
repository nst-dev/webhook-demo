## Webhook System Demo

Webhook is system that allows publisher publish messages to consumers

### Features
- Publish event (via api)
- Deliver event to webhook (view delivery logs in `webhook/storage/logs/delivery-<date>.log`)

### Install
- Clone project & up docker:
  ```sh
  git clone git@github.com:nst-dev/webhook-demo.git \
    && cd webhook-demo/docker \
    && docker-compose -p webhook up -d
  ```
- Create database
  ```sh
  $ docker exec -it webhook_mysql_1 bash
  $ mysql -u root -p
  $ Enter password: 123123
  mysql> CREATE DATABASE webhook; exit;
  ```
- Initialize project
  ```sh
  docker exec webhook_webhook_worker_1 sh -c "chown -R www-data:www-data ." \
    && docker exec -u www-data webhook_webhook_worker_1 sh -c "\
      cp .env.example .env \
      && php composer install \
      && php artisan migrate \
      && php artisan db:seed" \
    && docker restart webhook_webhook_worker_1
  ```

### Api Document
- **Publish events**
  - URL: http://localhost:8081/events
  - Method: POST
  - Header:
    - Authorization: Bearer <app_token> (The application's access token)
  - Post data:
    - event (string): The event name
    - payload (string): The event payload
  - Example:
  ```sh
  curl -X POST http://localhost:8081/events \
    -H "Authorization: Bearer MS05NmNhZTM1Y2U4YTliMDI0NDE3OGJmMjhlNDk2NmMyY2UxYjgzODU3MjNhOTZhNmI4Mzg4NThjZGQ2Y2EwYTFl" \
    -d 'event=ORDER.CREATED&payload={"orderId":123,"customer":"username"}'
  ```