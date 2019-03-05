<?php

namespace Modules\Webhook\Models;

use App\Base\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\App\Models\App;
use Modules\Delivery\Models\Delivery;

/**
 * Class Webhook
 *
 * @package Modules\Webhook\Models
 * @property App $app
 * @property Collection $deliveries
 */
class Webhook extends Model
{
    protected $table = 'webhooks';

    protected $hidden = ['secret'];

    protected $casts = [
        'events' => 'array',
    ];

    /**
     * @return BelongsTo
     */
    public function app()
    {
        return $this->belongsTo(App::class, 'app_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'webhook_id', 'id');
    }

    /**
     * @param string $value
     * @return string
     */
    public function getSecretAttribute($value)
    {
        return app('encrypter')->decrypt($value, false);
    }

    /**
     * @param string $value
     */
    public function setSecretAttribute($value)
    {
        $this->attributes['secret'] = app('encrypter')->encrypt($value, false);
    }
}