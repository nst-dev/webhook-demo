<?php

namespace Modules\Delivery\Services;

use Illuminate\Support\ServiceProvider;
use Modules\Service;

class DeliveryServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(ShipperInterface::class, function () {
            return $this->makeShipper();
        });

        $this->app->singleton(DeliveryServiceInterface::class, function () {
            return new DeliveryService($this->app->make(ShipperInterface::class));
        });
    }

    protected function makeShipper()
    {
        $shipper = new NullShipper(Service::log()->make('delivery'));
        $shipper->timeout = config('webhook.request_timeout');
        $shipper->responseLength = config('webhook.response_length');

        return $shipper;
    }

    public function provides()
    {
        return [
            DeliveryServiceInterface::class,
            ShipperInterface::class,
        ];
    }
}