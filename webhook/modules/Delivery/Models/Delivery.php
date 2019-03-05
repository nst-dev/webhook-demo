<?php

namespace Modules\Delivery\Models;

use App\Base\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\App\Models\App;
use Modules\Event\Models\Event;
use Modules\Webhook\Models\Webhook;

/**
 * Class Delivery
 *
 * @package Modules\Delivery\Models
 * @property App $app
 * @property Webhook $webhook
 * @property Event $event
 */
class Delivery extends Model
{
    protected $table = 'deliveries';

    protected $casts = [
        'request_time' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function app()
    {
        return $this->belongsTo(App::class, 'app_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function webhook()
    {
        return $this->belongsTo(Webhook::class, 'webhook_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}