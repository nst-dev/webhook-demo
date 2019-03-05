<?php

use Illuminate\Database\Seeder;
use Modules\Webhook\Models\Webhook;
use Modules\Webhook\Services\WebhookContentType;
use Modules\Webhook\Services\WebhookStatus;

class WebhooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Webhook::count()) {
            return;
        }

        Webhook::create([
            'app_id' => 1,
            'payload_url' => 'http://webhook.com/webhook',
            'secret' => '123123',
            'content_type' => WebhookContentType::FORM,
            'status' => WebhookStatus::ACTIVE,
            'events' => ['*'], // Listen every events
        ]);
    }
}
