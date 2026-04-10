<?php

namespace App\Models;

use App\Models\Scopes\SortableScope;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    public $timestamps = false;

    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;

    const MODE_SANDBOX = 'sandbox';
    const MODE_LIVE = 'live';

    const TYPE_AUTO = 0;
    const TYPE_MANUAL = 1;

    protected static function booted()
    {
        static::addGlobalScope(new SortableScope);
    }

    public function scopeDisabled($query)
    {
        return $query->where('status', self::STATUS_DISABLED);
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function isDisabled()
    {
        return $this->status == self::STATUS_DISABLED;
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isManual()
    {
        return $this->type == self::TYPE_MANUAL;
    }

    public function isSandboxMode()
    {
        return $this->mode == self::MODE_SANDBOX;
    }

    public function isLiveMode()
    {
        return $this->mode == self::MODE_LIVE;
    }

    protected $fillable = [
        'name',
        'logo',
        'fees',
        'currency',
        'rate',
        'credentials',
        'mode',
        'instructions',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'parameters' => 'object',
            'credentials' => 'object',
            'status' => 'boolean',
            'fees' => 'integer',
            'type' => 'boolean',
        ];
    }

    public function getTransAttribute()
    {
        return (object) [
            'name' => m_trans($this->name),
        ];
    }

    public function getLogoLink()
    {
        return asset($this->logo);
    }

    public function getCurrency()
    {
        if ($this->currency && $this->rate) {
            return $this->currency;
        }

        return config('settings.currency.code');
    }

    public function getChargeAmount($amount)
    {
        if ($this->currency && $this->rate) {
            return ($amount * $this->rate);
        }

        return round($amount, 2);
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

    public static function getAvailableModes()
    {
        return [
            self::MODE_SANDBOX => d_trans(self::MODE_SANDBOX),
            self::MODE_LIVE => d_trans(self::MODE_LIVE),
        ];
    }
}
