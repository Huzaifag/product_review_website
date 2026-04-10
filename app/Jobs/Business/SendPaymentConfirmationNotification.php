<?php

namespace App\Jobs\Business;

use App\Classes\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendPaymentConfirmationNotification implements ShouldQueue
{
    use Queueable;

    public $transaction;

    public function __construct($transaction)
    {
        $this->transaction = $transaction;
    }

    public function handle()
    {
        $transaction = $this->transaction;
        $owner = $transaction->owner;

        SendMail::send($owner->email, 'business_payment_confirmation', [
            'name' => $owner->getName(),
            'transaction_id' => $transaction->id,
            'transaction_subtotal' => getAmount($transaction->amount),
            'payment_method' => $transaction->paymentGateway->trans->name,
            'transaction_fees' => getAmount($transaction->fees),
            'transaction_total' => getAmount($transaction->total),
            'transaction_date' => dateFormat($transaction->created_at),
            'view_link' => route('business.subscription.transactions.show', $transaction->id),
            'website_name' => m_trans(config('settings.general.site_name')),
        ]);
    }
}