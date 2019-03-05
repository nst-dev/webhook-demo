<?php

namespace Modules\Event\Services;

use Modules\App\Models\App;
use Modules\Event\Validators\EventValidator;

interface EventServiceInterface
{
    /**
     * Make event publisher
     *
     * @param App $app
     * @return EventPublisherInterface
     */
    public function publisher(App $app);

    /**
     * Make event validator
     *
     * @param array $input
     * @return EventValidator
     */
    public function eventValidator(array $input);
}