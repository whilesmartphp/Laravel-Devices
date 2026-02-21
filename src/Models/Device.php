<?php

namespace Whilesmart\UserDevices\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Notifications\Notifiable;

class Device extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'type',
        'token',
        'deviceable_id',
        'deviceable_type',
        'type',
        'identifier',
        'platform',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('user-devices.db_table_name', 'devices');
    }

    public function deviceable(): MorphTo
    {
        return $this->morphTo();
    }

    public function routeNotificationForFcm()
    {
        // @phpstan-ignore-next-line
        logger()->info('sending push notification to device with token ' . $this->token);
        // @phpstan-ignore-next-line
        return $this->token;
    }
}
