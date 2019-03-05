<?php

namespace Modules\App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Modules\Service;

class AppServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(AppServiceInterface::class, AppService::class);
    }

    public function boot()
    {
        $this->app['auth']->viaRequest('app-token', function (Request $request) {
            $token = $request->bearerToken() ?: $request->get('token');

            return Service::app()->findByToken($token);
        });
    }

    public function provides()
    {
        return [AppServiceInterface::class];
    }
}