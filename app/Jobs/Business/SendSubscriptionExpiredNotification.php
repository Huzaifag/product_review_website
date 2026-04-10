<?php

namespace App\Jobs\Business;

use App\Classes\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendSubscriptionExpiredNotification implements ShouldQueue
{
    use Queueable;

    public $subscription;

    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    public function handle(): void
    {
        $subscription = $this->subscription;
        $owner = $subscription->owner;

        SendMail::send($owner->email, 'business_subscription_expired', [
            'name' => $owner->getName(),
            'expiry_date' => dateFormat($subscription->expiry_at),
            'view_link' => route('business.subscription.index'),
            'website_name' => m_trans(config('settings.general.site_name')),
        ]);
    }
}