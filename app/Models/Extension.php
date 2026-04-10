<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extension extends Model
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
