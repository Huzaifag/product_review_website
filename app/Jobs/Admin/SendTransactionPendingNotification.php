<?php

namespace App\Jobs\Admin;

use App\Classes\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendTransactionPendingNotification implements ShouldQueue
{
    use Dispatchable;

    public $admin;
    public $transaction;

    public function __construct($admin, $transaction)
    {
        $this->admin = $admin;
        $this->transaction = $transaction;
    }

    public function handle()
    {
        $admin = $this->admin;
        $transaction = $this->transaction;

        SendMail::send($admin->email, 'admin_transaction_pending', [
            'name' => $transaction->owner->getName(),
            'transaction_id' => $transaction->id,
            'transaction_subtotal' => getAmount($transaction->amount),
            'payment_method' => $transaction->paymentGateway->trans->name,
            'transaction_fees' => getAmount($transaction->fees),
            'transaction_total' => getAmount($transaction->total),
            'transaction_date' => dateFormat($transaction->created_at),
            'view_link' => route('admin.transactions.show', $transaction->id),
            "website_name" => m_trans(config('settings.general.site_name')),
        ]);
    }
}