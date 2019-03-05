<?php

namespace Modules\Delivery\Services;

use Modules\Delivery\Jobs\DeliverEvent;
use Modules\Delivery\Models\Delivery;
use Modules\Event\Models\Event;
use Modules\Webhook\Models\Webhook;

class DeliveryService implements DeliveryServiceInterface
{
    /**
     * @var ShipperInterface
     */
    protected $shipper;

    /**
     * DeliveryService constructor
     *
     * @param ShipperInterface $shipper
     */
    public function __construct(ShipperInterface $shipper)
    {
        $this->shipper = $shipper;
    }

    /**
     * Get shipper instance
     *
     * @return ShipperInterface
     */
    public function shipper()
    {
        return $this->shipper;
    }

    /**
     * Create new delivery
     *
     * @param Event $event
     * @param Webhook $webhook
     * @return Delivery
     */
    public function create(Event $event, Webhook $webhook)
    {
        $delivery = Delivery::create([
            'app_id' => $webhook->app_id,
            'webhook_id' => $webhook->id,
            'event_id' => $event->id,
            'status' => DeliveryStatus::PENDING,
        ]);

        dispatch(new DeliverEvent($delivery->id));

        return $delivery;
    }
}