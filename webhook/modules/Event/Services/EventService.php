<?php

namespace Modules\Event\Services;

use Modules\App\Models\App;
use Modules\Event\Validators\EventValidator;
use Modules\Service;

class EventService implements EventServiceInterface
{
    /**
     * Make event publisher
     *
     * @param App $app
     * @return EventPublisher
     */
    public function publisher(App $app)
    {
        return new EventPublisher(Service::delivery(), $app);
    }

    /**
     * Make event validator
     *
     * @param array $input
     * @return EventValidator
     */
    public function eventValidator(array $input)
    {
        return new EventValidator($input);
    }
}