<?php

namespace App\Console\Commands\Subscriptions;

use App\Jobs\Business\SendSubscriptionExpiredNotification;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SubscriptionExpiredNotification extends Command
{
    protected $signature = 'app:subscription-expired-notification';

    protected $description = 'Send an email to the business owner after subscription expired';

    public function handle()
    {
        $subscriptions = Subscription::expired()->get();
        foreach ($subscriptions as $subscription) {
            if (!$subscription->last_notification_at ||
                Carbon::parse($subscription->last_notification_at)->lt(Carbon::now()->subDays(config('settings.subscription.after_expiring_reminder_days')))) {
                dispatch(new SendSubscriptionExpiredNotification($subscription));

                $subscription->last_notification_at = Carbon::now();
                $subscription->save();
            }
        }

        $this->info('Expired subscription notification sent successfully');
    }
}