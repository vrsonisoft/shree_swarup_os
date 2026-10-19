<?php

namespace Modules\RestApi\Entities;

use App\Models\BaseModel;

/**
 * Modules\RestApi\Entities\FcmSetting
 * @property bool $delivery_partner_enabled
 * @property string|null $delivery_partner_credentials_path
 * @property bool $waiter_pos_enabled
 * @property string|null $waiter_pos_credentials_path
 */
class FcmSetting extends BaseModel
{
    protected $table = 'restapi_fcm_settings';

    protected $guarded = ['id'];

    protected $casts = [
        'delivery_partner_enabled' => 'boolean',
        'waiter_pos_enabled' => 'boolean',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([]);
    }

    public function isEnabledFor(string $appType): bool
    {
        return $appType === 'delivery_partner' ? $this->delivery_partner_enabled : $this->waiter_pos_enabled;
    }

    public function credentialsPathFor(string $appType): ?string
    {
        return $appType === 'delivery_partner' ? $this->delivery_partner_credentials_path : $this->waiter_pos_credentials_path;
    }
}