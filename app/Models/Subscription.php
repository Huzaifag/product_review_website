<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Log;

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
        'plan_id',
        'user_id',
        'expiry_at',
        'started_at',
        'last_notification_at',
    ];

    protected function casts(): array
    {
        return [
            'expiry_at' => 'datetime',
            'started_at' => 'datetime',
            'last_notification_at' => 'datetime',
        ];
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    //active scope
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('expiry_at')
                ->orWhere('expiry_at', '>', Carbon::now());
        });
    }

    public function sendSubscriptionEmailNotification()
    {
        // send mail to user when he buys subscription

        if (!config('settings.smtp.status')) {
            Log::warning('SMTP is disabled. Cannot send subscription email notification.');
            return;
        }

        try {
            $email = $this->user->email;
            $subject = 'Subscription Activated: ' . $this->plan->name;
            $msg = '<p>Dear ' . $this->user->name . ',</p>
                    <p>Thank you for subscribing to our ' . $this->plan->name . ' plan!</p>
                    <p>Your subscription is now active and you can start enjoying the benefits of your plan.</p>
                    <p>If you have any questions or need assistance, please feel free to contact our support team.</p>
                    <p>Best regards,<br>' . config('app.name') . ' Team</p>';

            \Mail::send([], [], function ($message) use ($msg, $email, $subject) {
                $message->to($email)
                    ->subject($subject)
                    ->html($msg);
            });


        } catch (\Exception $e) {
            Log::error('Failed to send subscription email notification: ' . $e->getMessage());
        }
    }
}
