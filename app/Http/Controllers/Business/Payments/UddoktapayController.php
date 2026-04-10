<?php

namespace App\Http\Controllers\Business\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use UddoktaPay\LaravelSDK\Requests\CheckoutRequest;
use UddoktaPay\LaravelSDK\UddoktaPay;

class UddoktapayController extends Controller
{
    private $paymentGateway;
    private $uddoktaPay;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('uddoktapay');

        $this->uddoktaPay = UddoktaPay::make(
            $this->paymentGateway->credentials->api_key,
            $this->paymentGateway->credentials->base_url
        );
    }

    public function process($trx)
    {
        try {
            $checkoutRequest = CheckoutRequest::make()
                ->setFullName($trx->owner->getName())
                ->setEmail($trx->owner->email)
                ->setAmount(amountFormat($this->paymentGateway->getChargeAmount($trx->total)))
                ->addMetadata('trx_id', $trx->id)
                ->setRedirectUrl(route('payments.ipn.uddoktapay', ['id' => hash_encode($trx->id)]))
                ->setCancelUrl(route('business.checkout.index', hash_encode($trx->id)))
                ->setWebhookUrl(route('payments.webhooks.uddoktapay'));

            $response = $this->uddoktaPay->checkout($checkoutRequest);

            if ($response->failed()) {
                throw new Exception(d_trans('Payment failed'));
            }

            $paymentUrl = $response->paymentURL();
            $data['type'] = "success";
            $data['method'] = "redirect";
            $data['redirect_url'] = $paymentUrl;
        } catch (\Exception $e) {
            $data['type'] = "error";
            $data['msg'] = $e->getMessage();
        }

        return json_encode($data);
    }

    public function ipn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required'],
            'invoice_id' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return redirect()->route('business.subscription.plans.index');
        }

        $trx = Transaction::where('id', hash_decode($request->id))
            ->where('business_owner_id', authBusinessOwner()->id)
            ->whereIn('status', [Transaction::STATUS_PAID, Transaction::STATUS_UNPAID])
            ->firstOrFail();

        $checkoutLink = route('business.checkout.index', hash_encode($trx->id));

        if ($trx->isPaid()) {
            return redirect($checkoutLink);
        }

        try {
            $response = $this->uddoktaPay->verify($request);

            if (!$response->success()) {
                toastr()->error(d_trans('Payment failed'));
                return redirect($checkoutLink);
            }

            $data = $response->toArray();

            $trx->payer_id = $data['invoice_id'];
            $trx->payer_email = $data['email'];
            $trx->status = Transaction::STATUS_PAID;
            $trx->update();

            event(new TransactionPaid($trx));
            return redirect($checkoutLink);
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect($checkoutLink);
        }
    }

    public function webhook(Request $request)
    {
        $httpApiKey = $request->header('HTTP_RT_UDDOKTAPAY_API_KEY');

        try {
            if (!isset($httpApiKey) || !$httpApiKey || empty($httpApiKey)) {
                return response('Http API Key not found', 401);
            }

            if ($httpApiKey != $this->paymentGateway->credentials->api_key) {
                return response('Invalid Http API Key', 401);
            }

            $payload = json_decode($request->getContent(), true);

            if (!$payload) {
                return response('Invalid payload', 401);
            }

            $response = $this->uddoktaPay->verify($payload['invoice_id']);

            if ($response->success()) {
                $data = $response->toArray();

                $trx = Transaction::where('id', $data['metadata']['trx_id'])->unpaid()->first();
                if ($trx) {
                    $trx->payer_id = $data['invoice_id'];
                    $trx->payer_email = $data['email'];
                    $trx->status = Transaction::STATUS_PAID;
                    $trx->update();
                    event(new TransactionPaid($trx));
                }
            }

            return response('Webhook processed successfully', 200);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }
}