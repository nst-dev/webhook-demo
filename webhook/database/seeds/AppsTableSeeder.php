<?php

use Illuminate\Database\Seeder;
use Modules\App\Models\App;
use Modules\App\Services\AppStatus;

class AppsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::count()) {
            return;
        }

        App::create([
            'name' => 'app_1',
            'secret' => '123123',
            'status' => AppStatus::ACTIVE,
        ]);
    }
}
