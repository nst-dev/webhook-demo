<?php

namespace Modules\Event\Validators;

use App\Base\Validator;

class EventValidator extends Validator
{
    /**
     * Get validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'event' => 'required|string',
            'payload' => 'required|string',
        ];
    }
}