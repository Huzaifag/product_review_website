<?php

namespace App\Http\Controllers\Business\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadopagoController extends Controller
{
    private $paymentGateway;
    private $preferenceClient;
    private $paymentClient;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('mercadopago');
        MercadoPagoConfig::setAccessToken($this->paymentGateway->credentials->access_token);
        $this->preferenceClient = new PreferenceClient();
        $this->paymentClient = new PaymentClient();
    }

    public function process($trx)
    {
        $owner = $trx->owner;

        try {
            $request = $this->createPreferenceRequest($trx, [
                [
                    "id" => $trx->id,
                    "title" => d_trans('Payment for subscription #:number', [
                        'number' => $trx->id,
                    ]),
                    "quantity" => 1,
                    "currency_id" => $this->paymentGateway->getCurrency(),
                    "unit_price" => $this->paymentGateway->getChargeAmount($trx->total),
                ],
            ], [
                "name" => $owner->firstname,
                "surname" => $owner->lastname,
                "email" => $owner->email,
            ]);

            $preference = $this->preferenceClient->create($request);

            $trx->payment_id = $preference->id;
            $trx->update();

            $data['type'] = "success";
            $data['method'] = "redirect";
            $data['redirect_url'] = $preference->init_point;
        } catch (\Exception $e) {
            $data['type'] = "error";
            $data['msg'] = $e->getMessage();
        }

        return json_encode($data);
    }

    public function ipn(Request $request)
    {
        $trx = Transaction::where('id', hash_decode($request->id))
            ->where('business_owner_id', authBusinessOwner()->id)
            ->whereIn('status', [Transaction::STATUS_PAID, Transaction::STATUS_UNPAID])
            ->firstOrFail();

        $checkoutLink = route('business.checkout.index', hash_encode($trx->id));

        if ($trx->isPaid()) {
            return redirect($checkoutLink);
        }

        try {
            $preference = $this->preferenceClient->get($request->preference_id);
            $payment = $this->paymentClient->get($request->payment_id);
            if (!$preference || !$payment) {
                toastr()->error(d_trans('Payment failed'));
                return redirect($checkoutLink);
            }

            $preference = json_decode(json_encode($preference));
            abort_if($preference->external_reference != $trx->id, 404);

            $payment = json_decode(json_encode($payment));

            if ($payment->status != "approved") {
                toastr()->error(d_trans('Payment failed'));
                return redirect($checkoutLink);
            }

            if (isset($payment->payer) && $payment->payer) {
                $trx->payer_id = isset($payment->payer->id) && $payment->payer->id ? $payment->payer->id : null;
                $trx->payer_email = isset($payment->payer->email) && $payment->payer->email ? $payment->payer->email : null;
            }

            $trx->payment_id = $payment->id;
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
        $payload = $request->all();
        if (!$payload) {
            return response('Invalid payload', 401);
        }

        try {
            $signature = $this->verifySignature($request);
            if (!$signature) {
                return response('Invalid signature', 401);
            }

            if ($payload['action'] == "payment.created") {
                $payment = $this->paymentClient->get($payload['data']['id']);
                $payment = json_decode(json_encode($payment));

                if ($payment->status == "approved") {
                    $trx = Transaction::where('id', $payment->external_reference)->unpaid()->first();
                    if ($trx) {
                        if (isset($payment->payer) && $payment->payer) {
                            $trx->payer_id = isset($payment->payer->id) && $payment->payer->id ? $payment->payer->id : null;
                            $trx->payer_email = isset($payment->payer->email) && $payment->payer->email ? $payment->payer->email : null;
                        }
                        $trx->payment_id = $payment->id;
                        $trx->status = Transaction::STATUS_PAID;
                        $trx->update();
                        event(new TransactionPaid($trx));
                    }
                }
            }

            return response('Webhook processed successfully', 200);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    private function createPreferenceRequest($trx, $items, $payer)
    {
        $request = [
            "items" => $items,
            "payer" => $payer,
            "payment_methods" => [
                "excluded_payment_methods" => [],
                "installments" => 12,
                "default_installments" => 1,
            ],
            "back_urls" => [
                'success' => route('payments.ipn.mercadopago', ['id' => hash_encode($trx->id)]),
                'failure' => route('business.checkout.index', hash_encode($trx->id)),
            ],
            "statement_descriptor" => d_trans('Payment for subscription #:number', [
                'number' => $trx->id,
            ]),
            "external_reference" => $trx->id,
            "expires" => false,
            "auto_return" => 'approved',
        ];

        return $request;
    }

    public function verifySignature($request)
    {
        $xSignature = $request->header('x-signature');
        $xRequestId = $request->header('x-request-id');
        $content = $request->all();

        $dataId = isset($content['data']['id']) ? $content['data']['id'] : '';
        $parts = explode(',', $xSignature);

        $ts = null;
        $hash = null;

        foreach ($parts as $part) {
            $keyValue = explode('=', $part, 2);
            if (count($keyValue) == 2) {
                $key = trim($keyValue[0]);
                $value = trim($keyValue[1]);
                if ($key === "ts") {
                    $ts = $value;
                } elseif ($key === "v1") {
                    $hash = $value;
                }
            }
        }

        $manifest = "id:$dataId;request-id:$xRequestId;ts:$ts;";

        $sha = hash_hmac('sha256', $manifest, $this->paymentGateway->credentials->webhook_secret_signature);
        if ($sha === $hash) {
            return true;
        }

        return false;
    }
}