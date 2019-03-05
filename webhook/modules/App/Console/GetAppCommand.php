<?php

namespace Modules\App\Console;

use Illuminate\Console\Command;
use Modules\App\Models\App;
use Modules\Service;

class GetAppCommand extends Command
{
    protected $signature = 'app:get {name? : Application name}';

    protected $description = 'List applications';

    public function handle()
    {
        $filter = array_filter([
            'name' => $this->argument('name'),
        ]);

        $params = ['id', 'name', 'token', 'status', 'created_at'];

        $apps = Service::app()->lists($filter)->map(function (App $app) use ($params) {
            return array_merge($app->only($params), [
                'token' => base64_decode(base64_encode(Service::app()->generateToken($app))),
            ]);
        });

        $this->table($params, $apps);
    }
}