<?php

namespace Modules\RestApi\Entities;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $table = 'ai_device_tokens';

    protected $guarded = ['id'];

    public const APP_DELIVERY_PARTNER = 'delivery_partner';
    public const APP_WAITER_POS = 'waiter_pos';
}
