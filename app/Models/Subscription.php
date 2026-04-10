<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public function scopeAboutToExpire($query)
    {
        return $query->whereHas('plan', function ($q) {
            $q->whereNot('interval', Plan::INTERVAL_LIFETIME);
        })
            ->whereNotNull('expiry_at')
            ->where('expiry_at', '>', Carbon::now())
            ->whereRaw('DATEDIFF(expiry_at, NOW()) <= ?', [config('settings.subscription.before_expiring_reminder_days')]);
    }

    public function isAboutToExpire()
    {
        if ($this->plan->isLifetime()) {
            return false;
        }

        if (is_null($this->expiry_at)) {
            return false;
        }

        $expiryDate = Carbon::parse($this->expiry_at);
        $today = Carbon::now();

        if ($this->isExpired()) {
            return false;
        }

        $daysLeft = $today->diffInDays($expiryDate, false);
        return $daysLeft <= config('settings.subscription.before_expiring_reminder_days') && $daysLeft >= 0;
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('expiry_at')
            ->where('expiry_at', '<', Carbon::now());
    }

    public function isExpired()
    {
        if (is_null($this->expiry_at)) {
            return false;
        }
        return $this->expiry_at->isPast();
    }

    protected $fillable = [
        'business_owner_id',
        'plan_id',
        'expiry_at',
        'last_notification_at',
    ];

    protected function casts(): array
    {
        return [
            'expiry_at' => 'datetime',
            'last_notification_at' => 'datetime',
        ];
    }

    public function owner()
    {
        return $this->belongsTo(BusinessOwner::class, 'business_owner_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
