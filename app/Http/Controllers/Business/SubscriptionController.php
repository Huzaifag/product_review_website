<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Transaction;

class SubscriptionController extends Controller
{
    public function index()
    {
        $businessOwner = authBusinessOwner();

        $statuses = Transaction::getAvailableStatues();

        $transactions = Transaction::where('business_owner_id', $businessOwner->id)
            ->whereNot('status', Transaction::STATUS_UNPAID);

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $transactions->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->OrWhere('amount', 'like', $searchTerm)
                    ->OrWhere('fees', 'like', $searchTerm)
                    ->OrWhere('total', 'like', $searchTerm)
                    ->OrWhereHas('paymentGateway', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', $searchTerm);
                    });
            });
        }

        if (request()->filled('status')) {
            $transactions->where('status', request('status'));
        }

        $transactions = $transactions->with('paymentGateway')
            ->orderbyDesc('id')->paginate(20);
        $transactions->appends(request()->only(['search', 'status']));

        return theme_view('business.subscription.index', [
            'authBusinessOwner' => $businessOwner,
            'statuses' => $statuses,
            'transactions' => $transactions,
        ]);
    }

    public function transactionsShow($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('business_owner_id', authBusinessOwner()->id)
            ->whereNot('status', Transaction::STATUS_UNPAID)
            ->with('paymentGateway')
            ->firstOrFail();

        return theme_view('business.subscription.transaction', [
            'trx' => $transaction,
        ]);
    }

    public function transactionsInvoice($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('business_owner_id', authBusinessOwner()->id)
            ->paid()->firstOrFail();

        return theme_view('business.subscription.invoice', [
            'trx' => $transaction,
        ]);
    }

    public function plans()
    {
        $countPlans = Plan::active()->count();

        $weeklyPlans = Plan::weekly()->active()->get();
        $monthlyPlans = Plan::monthly()->active()->get();
        $yearlyPlans = Plan::yearly()->active()->get();
        $lifetimePlans = Plan::lifetime()->active()->get();

        return theme_view('business.subscription.plans', [
            'countPlans' => $countPlans,
            'weeklyPlans' => $weeklyPlans,
            'monthlyPlans' => $monthlyPlans,
            'yearlyPlans' => $yearlyPlans,
            'lifetimePlans' => $lifetimePlans,
        ]);
    }

    public function subscribe($id)
    {
        $plan = Plan::where('id', $id)->active()->firstOrFail();

        $businessOwner = authBusinessOwner();

        try {
            $subscription = $businessOwner->subscription;

            if ($subscription) {
                if ($subscription->plan->isLifetime()) {
                    toastr()->error(d_trans('You are in a lifetime plan it cannot be renewed'));
                    return back();
                }

                if ($subscription->plan->id == $plan->id) {
                    if (!$subscription->isAboutToExpire() && !$subscription->isExpired()) {
                        toastr()->error(d_trans('You have subscribed in this plan already'));
                        return back();
                    }

                    if ($subscription->plan->isFree()) {
                        if ($subscription->isExpired()) {
                            toastr()->error(d_trans('Your free plan has already expired and it cannot be renewed'));
                        }
                        return back();
                    }
                }
            }

            $transaction = new Transaction();
            $transaction->business_owner_id = $businessOwner->id;
            $transaction->amount = $plan->price;
            $transaction->total = $plan->price;
            $transaction->plan_id = $plan->id;
            $transaction->save();

            return redirect()->route('business.checkout.index', hash_encode($transaction->id));
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function cancel()
    {
        $businessOwner = authBusinessOwner();
        if ($businessOwner->isSubscribed()) {
            $subscription = $businessOwner->subscription;
            $subscription->delete();

            toastr()->success(d_trans('Your subscription has been cancelled'));
        }
        return back();
    }
}