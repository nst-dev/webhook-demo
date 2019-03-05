<?php

namespace Modules\Delivery\Services;

use Modules\Delivery\Models\Delivery;
use Psr\Log\LoggerInterface;

class NullShipper implements ShipperInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * NullShipper constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Send the delivery
     *
     * @param Delivery $delivery
     * @return ResponseInterface
     */
    public function send(Delivery $delivery)
    {
        $this->logger->debug('Deliver #' . $delivery->id, [
            'event' => $delivery->event->type,
            'payload' => $delivery->event->payload,
        ]);

        return new Response(Response::STATUS_SUCCESS, 'OK');
    }
}