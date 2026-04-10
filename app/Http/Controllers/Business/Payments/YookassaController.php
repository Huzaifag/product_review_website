<?php

namespace App\Http\Controllers\Business\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use YooKassa\Client;

class YookassaController extends Controller
{
    private $paymentGateway;
    private $client;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('yookassa');

        $this->client = new Client();
        $this->client->setAuth(
            $this->paymentGateway->credentials->shop_id,
            $this->paymentGateway->credentials->secret_key
        );
    }

    public function process($trx)
    {
        $body = [
            'amount' => [
                'value' => amountFormat($this->paymentGateway->getChargeAmount($trx->total)),
                'currency' => $this->paymentGateway->getCurrency(),
            ],
            'confirmation' => [
                'type' => 'redirect',
                'locale' => 'en_US',
                'return_url' => route('payments.ipn.yookassa', ['id' => hash_encode($trx->id)]),
            ],
            'capture' => true,
            'description' => d_trans('Payment for subscription #:number', [
                'number' => $trx->id,
            ]),
            'metadata' => [
                'trx_id' => $trx->id,
            ],
            'receipt' => [
                'customer' => [
                    'full_name' => $trx->owner->getName(),
                    'email' => $trx->owner->email,
                ],
            ],
        ];

        try {
            $response = $this->client->createPayment($body, uniqid('', true));

            $trx->payment_id = $response->id;
            $trx->update();

            $data['type'] = "success";
            $data['method'] = "redirect";
            $data['redirect_url'] = $response->getConfirmation()->getConfirmationUrl();
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
        try {
            $payload = $request->all();
            if (!$payload) {
                return response('Invalid payload', 401);
            }

            if ($payload['event'] == "payment.succeeded" && $payload['object']['status'] == "succeeded") {
                $trx = Transaction::where('id', $payload['object']['metadata']['trx_id'])
                    ->where('payment_id', $payload['object']['id'])
                    ->unpaid()
                    ->first();

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