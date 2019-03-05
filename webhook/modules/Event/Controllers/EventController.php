<?php

namespace Modules\Event\Controllers;

use App\Base\ApiController;
use Modules\App\Models\App;
use Modules\Service;

class EventController extends ApiController
{
    /**
     * Publish event
     */
    public function publish()
    {
        $input = $this->request()->only(['event', 'payload']);
        $validator = Service::event()->eventValidator($input);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        $app = $this->getCurrentApp();

        $event = Service::event()
            ->publisher($app)
            ->publish($input['event'], $input['payload']);

        return $this->success(['eventId' => $event->id]);
    }

    /**
     * @return App
     */
    protected function getCurrentApp()
    {
        return app('auth')->guard('app')->user();
    }
}