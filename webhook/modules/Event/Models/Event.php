<?php

namespace Modules\Event\Models;

use App\Base\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\App\Models\App;
use Modules\Delivery\Models\Delivery;

/**
 * Class Event
 *
 * @package Modules\Event\Models
 * @property App $app
 * @property Collection $deliveries
 */
class Event extends Model
{
    protected $table = 'events';

    public function app()
    {
        return $this->belongsTo(App::class, 'app_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'event_id', 'id');
    }
}