<?php

namespace App\Models;

use App\BusinessRole;
use Illuminate\Database\Eloquent\Model;

class BusinessEmployee extends Model
{
    const STATUS_PENDING = 1;
    const STATUS_ACTIVE = 2;

    public function scopePending($query)
    {
        $query->where('status', self::STATUS_PENDING);
    }

    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
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
        'email',
        'role',
        'token',
        'status',
        'business_id',
        'business_owner_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'role' => BusinessRole::class,
        ];
    }

    public function getStatusName()
    {
        return self::getAvailableStatuses()[$this->status];
    }

    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_PENDING => d_trans('Pending'),
            self::STATUS_ACTIVE => d_trans('Active'),
        ];
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function owner()
    {
        return $this->belongsTo(BusinessOwner::class, 'business_owner_id');
    }

}
