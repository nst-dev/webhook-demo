<?php

namespace Modules\Event\Services;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(EventServiceInterface::class, EventService::class);
    }

    public function provides()
    {
        return [EventServiceInterface::class];
    }
}