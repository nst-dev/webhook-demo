<?php

namespace Modules\App\Models;

use App\Base\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Webhook\Models\Webhook;

/**
 * Class App
 *
 * @package Modules\App\Models
 * @property Collection $webhooks
 */
class App extends Model
{
    protected $table = 'apps';

    protected $hidden = ['secret'];

    /**
     * @return HasMany
     */
    public function webhooks()
    {
        return $this->hasMany(Webhook::class, 'app_id', 'id');
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