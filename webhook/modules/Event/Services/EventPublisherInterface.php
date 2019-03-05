<?php

namespace Modules\Event\Services;

use Modules\Event\Models\Event;
use Modules\Webhook\Models\Webhook;

interface EventPublisherInterface
{
    /**
     * Publish the given event
     *
     * @param string $event
     * @param string $payload
     * @return Event
     */
    public function publish($event, $payload = '');

    /**
     * Get the subscribes of given event
     *
     * @param string $event
     * @return Webhook[]
     */
    public function getSubscribers($event);
}