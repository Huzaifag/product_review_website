<?php

namespace App\Listeners\Admin;

use App\Events\TransactionPending;
use App\Jobs\Admin\SendTransactionPendingNotification;
use App\Models\Admin;

class ProcessPendingTransaction
{
    public function handle(TransactionPending $event)
    {
        $transaction = $event->transaction;

        if ($transaction->isPending()) {
            $admins = Admin::all();
            foreach ($admins as $admin) {
                dispatch(new SendTransactionPendingNotification($admin, $transaction));
            }

            $title = d_trans('New Pending Transaction [#:transaction_id]', ['transaction_id' => $transaction->id]);
            $image = asset('images/notifications/transaction.png');
            $link = route('admin.transactions.show', $transaction->id);
            adminNotify($title, $image, $link);
        }
    }
}