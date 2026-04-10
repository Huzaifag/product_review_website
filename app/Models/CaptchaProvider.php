<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaptchaProvider extends Model
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;

    public function scopeDisabled($query)
    {
        $query->where('status', self::STATUS_DISABLED);
    }

    public function isDisabled()
    {
        return $this->status == self::STATUS_DISABLED;
    }

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function scopeDefault($query)
    {
        $query->where('alias', config('system.recaptcha.provider'));
    }

    public function isDefault()
    {
        return $this->alias == config('system.recaptcha.provider');
    }

    protected $fillable = [
        'credentials',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'credentials' => 'object',
            'status' => 'boolean',
        ];
    }

    public function getLogoLink()
    {
        return asset($this->logo);
    }

    public static function getAvailableStatues()
    {
        return [
            self::STATUS_ACTIVE => d_trans('Active'),
            self::STATUS_DISABLED => d_trans('Disabled'),
        ];
    }

    public function getStatusName()
    {
        return self::getAvailableStatues()[$this->status];
    }
}
