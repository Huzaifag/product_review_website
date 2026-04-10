<?php

namespace App\Listeners\Business;

use App\Events\TransactionPaid;
use App\Jobs\Business\SendPaymentConfirmationNotification;
use App\Models\Subscription;
use Carbon\Carbon;

class ProcessPaidTransaction
{
    public function handle(TransactionPaid $event)
    {
        $trx = $event->transaction;

        try {
            $owner = $trx->owner;
            $subscription = $owner->subscription;
            $plan = $trx->plan;

            if ($trx->isPaid()) {

                $expiryDate = null;

                if (!$plan->isLifetime()) {
                    if ($subscription) {
                        if ($plan->id == $subscription->plan->id) {
                            $expiryDate = $subscription->isExpired()
                            ? Carbon::now()->addDays($plan->getIntervalDays())
                            : Carbon::parse($subscription->expiry_at)->addDays($plan->getIntervalDays());
                        } else {
                            $expiryDate = Carbon::now()->addDays($plan->getIntervalDays());
                        }
                    } else {
                        $expiryDate = Carbon::now()->addDays($plan->getIntervalDays());
                    }
                }

                $subscription = $owner->subscription()->updateOrCreate(['business_owner_id' => $owner->id],
                    [
                        'plan_id' => $plan->id,
                        'expiry_at' => $expiryDate,
                        'last_notification_at' => null,
                    ]
                );

                dispatch(new SendPaymentConfirmationNotification($trx));
            }

        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }
    }
}