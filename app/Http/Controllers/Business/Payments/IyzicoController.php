<?php

namespace App\Http\Controllers\Business\Payments;

use App\Events\TransactionPaid;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\CheckoutForm;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Options;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;
use Iyzipay\Request\RetrieveCheckoutFormRequest;

class IyzicoController extends Controller
{
    private $paymentGateway;
    private $options;

    public function __construct()
    {
        $this->paymentGateway = paymentGateway('iyzico');
        $this->options = new Options();
        $this->options->setApiKey($this->paymentGateway->credentials->api_key);
        $this->options->setSecretKey($this->paymentGateway->credentials->secret_key);
        $this->options->setBaseUrl($this->paymentGateway->isSandboxMode() ?
            'https://sandbox-api.iyzipay.com' : 'https://api.iyzipay.com');
    }

    public function process($trx)
    {
        try {
            $owner = $trx->owner;
            $total = $this->paymentGateway->getChargeAmount($trx->total);

            $request = new CreateCheckoutFormInitializeRequest();
            $request->setLocale(Locale::EN);
            $request->setConversationId($trx->id);
            $request->setPrice($total);
            $request->setPaidPrice($total);
            $request->setBasketId($owner->id);
            $request->setPaymentGroup(PaymentGroup::PRODUCT);
            $request->setCurrency($this->paymentGateway->getCurrency());
            $request->setCallbackUrl(route('payments.ipn.iyzico', ['id' => hash_encode($trx->id)]));

            $buyer = new Buyer();
            $buyer->setId($owner->id);
            $buyer->setName($owner->firstname);
            $buyer->setSurname($owner->lastname);
            $buyer->setEmail($owner->email);
            $buyer->setIdentityNumber(hash_encode($owner->id));
            $buyer->setRegistrationAddress(@$owner->address->line_1 . ', ' . @$owner->address->line_2);
            $buyer->setCity(@$owner->address->city);
            $buyer->setCountry(@$owner->address->country);
            $buyer->setZipCode(@$owner->address->zip);
            $request->setBuyer($buyer);

            $shippingAddress = new Address();
            $shippingAddress->setContactName($owner->getName());
            $shippingAddress->setCity(@$owner->address->city);
            $shippingAddress->setCountry(@$owner->address->country);
            $shippingAddress->setAddress(@$owner->address->line_1 . ', ' . @$owner->address->line_2);
            $shippingAddress->setZipCode(@$owner->address->zip);
            $request->setShippingAddress($shippingAddress);

            $billingAddress = new Address();
            $billingAddress->setContactName($owner->getName());
            $billingAddress->setCity(@$owner->address->city);
            $billingAddress->setCountry(@$owner->address->country);
            $billingAddress->setAddress(@$owner->address->line_1 . ', ' . @$owner->address->line_2);
            $billingAddress->setZipCode(@$owner->address->zip);
            $request->setBillingAddress($billingAddress);

            $basketItem = new BasketItem();
            $basketItem->setId($trx->id);
            $basketItem->setName(d_trans('Payment for subscription #:number', ['number' => $trx->id]));
            $basketItem->setCategory1(m_trans(config('settings.general.site_name')));
            $basketItem->setItemType(BasketItemType::VIRTUAL);
            $basketItem->setPrice($total);

            $basketItems[0] = $basketItem;
            $request->setBasketItems($basketItems);

            $checkoutFormInitialize = CheckoutFormInitialize::create($request, $this->options);

            $trx->payment_id = $checkoutFormInitialize->getToken();
            $trx->update();

            $data['type'] = "success";
            $data['method'] = "redirect";
            $data['redirect_url'] = $checkoutFormInitialize->getPaymentPageUrl();
        } catch (\Exception $e) {
            $data['type'] = "error";
            $data['msg'] = $e->getMessage();
        }

        return json_encode($data);
    }

    public function ipn(Request $request)
    {
        $token = $request->token;

        $trx = Transaction::where('id', hash_decode($request->id))
            ->where('payment_id', $token)
            ->whereIn('status', [Transaction::STATUS_PAID, Transaction::STATUS_UNPAID])
            ->firstOrFail();

        $checkoutLink = route('business.checkout.index', hash_encode($trx->id));

        if ($trx->isPaid()) {
            return redirect($checkoutLink);
        }

        try {
            $request = new RetrieveCheckoutFormRequest();
            $request->setLocale(Locale::EN);
            $request->setConversationId($trx->id);
            $request->setToken($token);

            $checkoutForm = CheckoutForm::retrieve($request, $this->options);

            $status = $checkoutForm->getStatus();
            $paymentStatus = $checkoutForm->getPaymentStatus();

            if ($status != "success" || $paymentStatus != "SUCCESS") {
                toastr()->error(d_trans('Payment failed'));
                return redirect($checkoutLink);
            }

            $paymentId = $checkoutForm->getPaymentId();

            $trx->payment_id = $paymentId;
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
        try {
            $sigHeader = $request->header('x-iyz-signature');

            $payload = $request->all();
            if (!$payload) {
                return response('Invalid payload', 401);
            }

            $secretKey = $this->paymentGateway->credentials->secret_key;
            $eventType = $payload['iyziEventType'];
            $paymentId = $payload['iyziPaymentId'];

            $concatenatedString = $secretKey . $eventType . $paymentId;
            $sha1Hash = sha1($concatenatedString);
            $base64EncodedSignature = base64_encode($sha1Hash);

            if ($sigHeader != $base64EncodedSignature) {
                return response('Invalid signature', 401);
            }

            if ($payload['status'] == "SUCCESS") {
                $trx = Transaction::where('payment_id', $payload['token'])
                    ->unpaid()->first();

                if ($trx) {
                    $trx->payment_id = $payload['iyziPaymentId'];
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