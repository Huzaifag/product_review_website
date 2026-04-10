<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessOwner;
use App\Models\Plan;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function index()
    {
        $plans = Plan::all();

        $subscriptions = Subscription::query();

        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $subscriptions->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->orWhereHas('owner', function ($query) use ($searchTerm) {
                        $query->Where('firstname', 'like', $searchTerm)
                            ->OrWhere('lastname', 'like', $searchTerm)
                            ->OrWhere('username', 'like', $searchTerm)
                            ->OrWhere('email', 'like', $searchTerm)
                            ->OrWhere('address', 'like', $searchTerm);
                    });
            });
        }

        if (request()->filled('plan')) {
            $subscriptions->where('plan_id', request('plan'));
        }

        $subscriptions = $subscriptions->orderbyDesc('id')->paginate(50);
        $subscriptions->appends(request()->only(['search', 'plan']));

        return view('admin.subscriptions.index', [
            'plans' => $plans,
            'subscriptions' => $subscriptions,
        ]);
    }

    public function create()
    {
        $owners = BusinessOwner::all();
        $plans = Plan::all();
        return view('admin.subscriptions.create', [
            'owners' => $owners,
            'plans' => $plans,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'owner' => ['required', 'integer', 'exists:business_owners,id'],
            'plan' => ['required', 'integer', 'exists:plans,id'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $plan = Plan::findOrFail($request->plan);

        $expiryDate = !$plan->isLifetime() ? Carbon::now()->addDays($plan->getIntervalDays()) : null;

        $subscription = new Subscription();
        $subscription->business_owner_id = $request->owner;
        $subscription->plan_id = $request->plan;
        $subscription->expiry_at = $expiryDate;
        $subscription->save();

        toastr()->success(d_trans('Created Successfully'));
        return redirect()->route('admin.subscriptions.show', $subscription->id);
    }

    public function show(Subscription $subscription)
    {
        return view('admin.subscriptions.show', [
            'subscription' => $subscription,
        ]);
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        toastr()->success(d_trans('Cancelled Successfully'));
        return redirect()->route('admin.subscriptions.index');
    }
}