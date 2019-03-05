<?php

namespace Modules\Delivery\Services;

use Modules\Delivery\Models\Delivery;

interface ShipperInterface
{
    /**
     * Send the delivery
     *
     * @param Delivery $delivery
     * @return ResponseInterface
     */
    public function send(Delivery $delivery);
}