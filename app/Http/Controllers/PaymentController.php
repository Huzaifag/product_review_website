<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\PaymentGateway;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\UserProductViewCount;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Stripe\Stripe;
use Stripe\Checkout\Session;


class PaymentController extends Controller
{
    public function checkout($slug)
    {
        $plan = Plan::active()->where('slug', $slug)->firstOrFail();
        $stripeGateway = PaymentGateway::where('alias', 'stripe')->active()->first();

        if (!$stripeGateway || empty($stripeGateway->credentials?->secret_key)) {
            toastr()->error(d_trans('Stripe payment gateway is not configured'));
            return redirect()->route('plans.details', $plan->slug);
        }

        Stripe::setApiKey($stripeGateway->credentials->secret_key);

        $chargeAmount = round($stripeGateway->getChargeAmount($plan->price) * 100);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => strtolower($stripeGateway->getCurrency()),
                        'product_data' => [
                            'name' => m_trans(config('settings.general.site_name')),
                            'description' => d_trans('Payment for :plan plan', ['plan' => $plan->trans->name]),
                        ],
                        'unit_amount' => max(1, $chargeAmount),
                    ],
                    'quantity' => 1,
                ]
            ],
            'metadata' => [
                'plan_slug' => $plan->slug,
            ],
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel', ['slug' => $plan->slug]),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request): RedirectResponse
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            toastr()->error(d_trans('Invalid payment session'));
            return redirect()->route('plans');
        }

        $stripeGateway = PaymentGateway::where('alias', 'stripe')->active()->first();

        if (!$stripeGateway || empty($stripeGateway->credentials?->secret_key)) {
            toastr()->error(d_trans('Stripe payment gateway is not configured'));
            return redirect()->route('plans');
        }

        try {
            Stripe::setApiKey($stripeGateway->credentials->secret_key);
            $session = Session::retrieve($sessionId);

            if ($session->payment_status !== 'paid') {
                toastr()->error(d_trans('Invalid payment session'));
                return redirect()->route('plans');
            }

            $plan = Plan::active()
                ->where('slug', $session->metadata->plan_slug ?? null)
                ->firstOrFail();

            $amount = ($session->amount_total ?? 0) / 100;
            $userId = auth()->id();
            $user = auth()->user();

            DB::transaction(function () use ($session, $plan, $amount, $userId, $user, $stripeGateway) {
                $transaction = Transaction::updateOrCreate(
                    ['payment_id' => $session->id],
                    [
                        'user_id' => $userId,
                        'plan_id' => $plan->id,
                        'payment_gateway_id' => $stripeGateway->id,
                        'amount' => $amount,
                        'fees' => 0,
                        'tax' => null,
                        'total' => $amount,
                        'payer_id' => (string) ($session->customer ?? ''),
                        'payer_email' => $user?->email,
                        'status' => Transaction::STATUS_PAID,
                    ]
                );

                // ✅ Always CREATE new subscription — old ones stay intact
                $subscription = Subscription::create([
                    'user_id' => $userId,
                    'plan_id' => $plan->id,
                    'expiry_at' => $plan->isLifetime() ? null : now()->addDays($plan->getIntervalDays()),
                    'started_at' => now(),
                    'last_notification_at' => null,
                ]);

                // Create a dedicated view counter per subscription
                UserProductViewCount::create([
                    'user_id' => $userId,
                    'subscription_id' => $subscription->id,
                    'session_id' => session()->getId(),
                    'ip_address' => request()->header('CF-Connecting-IP') ?: request()->ip(),
                    'product_ids' => [],
                    'products_viewed' => 0,
                ]);

                $subscription->sendSubscriptionEmailNotification();
                self::adminSubscriptionNotify($user, $plan, $subscription, $transaction);
            });

            toastr()->success(d_trans('Payment completed successfully'));
            return redirect()->route('user.profile', strtolower($user->username));

        } catch (ModelNotFoundException) {
            toastr()->error(d_trans('Selected plan could not be found'));
            return redirect()->route('plans');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->route('plans');
        }
    }

    public function cancel(Request $request)
    {
        toastr()->error(d_trans('Payment was cancelled'));

        $slug = $request->get('slug');
        if ($slug) {
            return redirect()->route('plans.details', $slug);
        }

        return redirect()->route('plans');
    }


    public static function adminSubscriptionNotify($user, $plan, $subscription, $transaction)
    {
        $title = d_trans(':username subscribed to :plan Plan', [
            'username' => $user->getName(),
            'plan' => $plan->name,
        ]);
        $image = $user->getAvatar();
        $link = route('admin.transactions.show', $transaction->id);
        return adminNotify($title, $image, $link);
    }
}
