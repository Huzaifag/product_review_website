<?php

namespace App\Http\Controllers\Business;

use App\Classes\Country;
use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index($id)
    {
        $trx = Transaction::where('id', hash_decode($id))
            ->where('business_owner_id', authBusinessOwner()->id)
            ->whereIn('status', [Transaction::STATUS_UNPAID, Transaction::STATUS_PAID])
            ->firstOrFail();

        if ($trx->isUnpaid() && $trx->amount != $trx->plan->price) {
            $trx->delete();
            toastr()->info(d_trans('There has been a change in your transaction'));
            return redirect()->route('business.subscription.plans.index');
        }

        $paymentGateways = PaymentGateway::active()->count();
        if ($paymentGateways < 1) {
            $trx->delete();
            toastr()->info('No active payment gateways');
            return back();
        }

        return theme_view('business.checkout', [
            'trx' => $trx,
        ]);
    }

    public function process(Request $request, $id)
    {
        $businessOwner = authBusinessOwner();

        $trx = Transaction::where('id', hash_decode($id))
            ->where('business_owner_id', $businessOwner->id)
            ->unpaid()->firstOrFail();

        if ($trx->amount != $trx->plan->price) {
            $trx->delete();
            toastr()->info(d_trans('There has been a change in your transaction'));
            return redirect()->route('business.subscription.plans.index');
        }

        $validator = Validator::make($request->all(), [
            'payment_method' => ['required', 'string', 'exists:payment_gateways,alias'],
            'address_line_1' => ['required', 'string', 'max:255', 'block_patterns'],
            'address_line_2' => ['nullable', 'string', 'max:255', 'block_patterns'],
            'city' => ['required', 'string', 'max:150', 'block_patterns'],
            'state' => ['required', 'string', 'max:150', 'block_patterns'],
            'zip' => ['required', 'string', 'max:100', 'block_patterns'],
            'country' => ['required', 'string', 'in:' . implode(',', array_keys(Country::all()))],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        $paymentGateway = PaymentGateway::where('alias', $request->payment_method)
            ->active()->firstOrFail();

        $address = [
            'line_1' => $request->address_line_1,
            'line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
        ];

        $businessOwner->address = $address;
        $businessOwner->update();

        $trx->payment_gateway_id = $paymentGateway->id;
        $trx->payment_id = null;
        $trx->payer_id = null;
        $trx->payer_email = null;
        $trx->update();

        $trx->calculate();

        $alias = ucfirst(Str::studly($paymentGateway->alias));
        $processor = new ("App\\Http\\Controllers\\Business\\Payments\\{$alias}Controller");
        $response = json_decode($processor->process($trx));

        if ($response) {
            if ($response->type == "error") {
                toastr()->error($response->msg);
                return back();
            }

            if ($response->type == "success" && $response->method == "redirect") {
                return redirect($response->redirect_url);
            }

            if ($response->type == "success" && $response->method == "hosted") {
                $data = isset($response->body) ? $response->body : null;
                return theme_view("business.payments.{$response->view}", [
                    'trx' => $trx,
                    'data' => $data,
                ]);
            }
        }

        return back();
    }
}