<?php

namespace Modules\Event\Services;

use Illuminate\Support\Str;
use Modules\App\Models\App;
use Modules\Delivery\Services\DeliveryServiceInterface;
use Modules\Event\Models\Event;
use Modules\Webhook\Models\Webhook;
use Modules\Webhook\Services\WebhookStatus;

class EventPublisher implements EventPublisherInterface
{
    /**
     * @var DeliveryServiceInterface
     */
    protected $deliveries;

    /**
     * @var App
     */
    protected $app;

    /**
     * EventPublisher constructor
     *
     * @param DeliveryServiceInterface $deliveries
     * @param App $app
     */
    public function __construct(DeliveryServiceInterface $deliveries, App $app)
    {
        $this->deliveries = $deliveries;
        $this->app = $app;
    }

    /**
     * Publish the given event
     *
     * @param string $event
     * @param string $payload
     * @return Event
     */
    public function publish($event, $payload = '')
    {
        $event = $this->createEvent($event, $payload);
        
        foreach ($this->getSubscribers($event->type) as $webhook) {
            $this->deliveries->create($event, $webhook);
        }

        return $event;
    }

    /**
     * @param string $event
     * @param string $payload
     * @return Event
     */
    protected function createEvent($event, $payload)
    {
        return Event::create([
            'app_id' => $this->app->id,
            'type' => $event,
            'payload' => $payload,
        ]);
    }

    /**
     * Get the subscribes of given event
     * 
     * @param string $event
     * @return Webhook[]
     */
    public function getSubscribers($event)
    {
        return $this->app->webhooks->filter(function ($webhook) use ($event) {
            return (
                $webhook->status === WebhookStatus::ACTIVE
                && $this->isSubscribedEvent($event, $webhook->events ?: [])
            );
        })->all();
    }

    /**
     * @param string $event
     * @param array $subscribedEvents
     * @return bool
     */
    protected function isSubscribedEvent($event, array $subscribedEvents)
    {
        foreach ($subscribedEvents as $subscribedEvent) {
            if ($this->matchEvent($event, $subscribedEvent)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $event
     * @param string $pattern
     * @return bool
     */
    protected function matchEvent($event, $pattern)
    {
        return Str::contains($pattern, '*') ? Str::is($pattern, $event) : $event === $pattern;
    }
}