<?php

namespace App\Http\Controllers\Business\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Stripe\Webhook;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;

class XenditController extends Controller
{
    private $paymentGateway;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('xendit');
        Configuration::setXenditKey($this->paymentGateway->credentials->api_secret_key);
    }

    public function process($trx)
    {
        $owner = $trx->owner;

        $body = [
            'external_id' => "$trx->id",
            'description' => d_trans('Payment for subscription #:number', [
                'number' => $trx->id,
            ]),
            'amount' => $this->paymentGateway->getChargeAmount($trx->total),
            'currency' => $this->paymentGateway->getCurrency(),
            'reminder_time' => 1,
            'customer' => [
                'given_names' => $owner->firstname,
                'surname' => $owner->lastname,
                'email' => $owner->email,
            ],
            'success_redirect_url' => route('payments.ipn.xendit', ['id' => hash_encode($trx->id)]),
            'failure_redirect_url' => route('business.checkout.index', hash_encode($trx->id)),
        ];

        try {
            $request = new CreateInvoiceRequest($body);

            $apiInstance = new InvoiceApi();
            $response = $apiInstance->createInvoice($request);

            $trx->payment_id = $response['id'];
            $trx->update();

            $data['type'] = "success";
            $data['method'] = "redirect";
            $data['redirect_url'] = $response['invoice_url'];
        } catch (\Exception $e) {
            $data['type'] = "error";
            $data['msg'] = $e->getMessage();
        }

        return json_encode($data);
    }

    public function ipn(Request $request)
    {
        $maxAttempts = 10;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            $trx = Transaction::where('id', hash_decode($request->id))
                ->where('business_owner_id', authBusinessOwner()->id)
                ->whereIn('status', [Transaction::STATUS_PAID, Transaction::STATUS_UNPAID])
                ->firstOrFail();

            if ($trx->isPaid()) {
                return redirect()->route('business.checkout.index', hash_encode($trx->id));
            }

            sleep(5);
            $attempt++;
        }

        toastr()->warning(d_trans("Your payment is being processed and you will get email notification when it's completed"));
        return redirect()->route('business.subscription.plans.index');
    }

    public function webhook(Request $request)
    {
        $webhookVerificationToken = $this->paymentGateway->credentials->webhook_verification_token;
        $incomingVerificationTokenHeader = $request->header('x-callback-token');

        try {
            if ($incomingVerificationTokenHeader != $webhookVerificationToken) {
                return response('Invalid verification token', 401);
            }

            $payload = $request->all();
            if (!$payload) {
                return response('Invalid payload', 401);
            }

            if ($payload['status'] == "PAID") {
                $trx = Transaction::where('payment_id', $payload['id'])
                    ->unpaid()->first();

                if ($trx) {
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