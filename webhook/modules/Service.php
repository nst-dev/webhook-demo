<?php

namespace Modules;

use Modules\App\Services\AppServiceInterface;
use Modules\Delivery\Services\DeliveryServiceInterface;
use Modules\Event\Services\EventServiceInterface;
use Modules\Log\Services\LoggerFactoryInterface;

class Service
{
    /**
     * @return LoggerFactoryInterface
     */
    public static function log()
    {
        return app(LoggerFactoryInterface::class);
    }

    /**
     * @return AppServiceInterface
     */
    public static function app()
    {
        return app(AppServiceInterface::class);
    }

    /**
     * @return DeliveryServiceInterface
     */
    public static function delivery()
    {
        return app(DeliveryServiceInterface::class);
    }

    /**
     * @return EventServiceInterface
     */
    public static function event()
    {
        return app(EventServiceInterface::class);
    }
}