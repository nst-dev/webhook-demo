<?php

namespace Modules\Delivery\Services;

use Modules\Delivery\Models\Delivery;
use Modules\Event\Models\Event;
use Modules\Webhook\Models\Webhook;

interface DeliveryServiceInterface
{
    /**
     * Create new delivery
     *
     * @param Event $event
     * @param Webhook $webhook
     * @return Delivery
     */
    public function create(Event $event, Webhook $webhook);

    /**
     * Get shipper instance
     *
     * @return ShipperInterface
     */
    public function shipper();
}