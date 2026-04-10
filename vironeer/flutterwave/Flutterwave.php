<?php

namespace Vironeer\Flutterwave;

use Illuminate\Support\Facades\Http;
use Vironeer\Flutterwave\Helpers\Banks;
use Vironeer\Flutterwave\Helpers\Beneficiary;
use Vironeer\Flutterwave\Helpers\Bills;
use Vironeer\Flutterwave\Helpers\Payments;
use Vironeer\Flutterwave\Helpers\Transfers;

class Flutterwave
{
    protected $publicKey;
    protected $secretKey;
    protected $baseUrl;

    function __construct()
    {
        $this->publicKey = config('flutterwave.publicKey');
        $this->secretKey = config('flutterwave.secretKey');
        $this->secretHash = config('flutterwave.secretHash');
        $this->baseUrl = 'https://api.flutterwave.com/v3';
    }

    public function generateReference(String $transactionPrefix = null)
    {
        if ($transactionPrefix) {
            return $transactionPrefix . '_' . uniqid(time());
        }
        return 'flw_' . uniqid(time());
    }

    public function initializePayment(array $data)
    {

        $payment = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/payments',
            $data
        )->json();

        return $payment;
    }

    public function getTransactionIDFromCallback()
    {
        $transactionID = request()->transaction_id;

        if (!$transactionID) {
            $transactionID = json_decode(request()->resp)->data->id;
        }

        return $transactionID;
    }

    public function verifyTransaction($id)
    {
        $data = Http::withToken($this->secretKey)->get($this->baseUrl . "/transactions/" . $id . '/verify')->json();
        return $data;
    }

    public function verifyWebhook()
    {
        if (request()->header('verif-hash')) {
            $flutterwaveSignature = request()->header('verif-hash');

            if ($flutterwaveSignature == $this->secretHash) {
                return true;
            }
        }
        return false;
    }

    public function payments()
    {
        $payments = new Payments($this->publicKey, $this->secretKey, $this->baseUrl);
        return $payments;
    }

    public function banks()
    {
        $banks = new Banks($this->publicKey, $this->secretKey, $this->baseUrl);
        return $banks;
    }

    public function transfers()
    {
        $transfers = new Transfers($this->publicKey, $this->secretKey, $this->baseUrl);
        return $transfers;
    }

    public function beneficiaries()
    {
        $beneficiary = new Beneficiary($this->publicKey, $this->secretKey, $this->baseUrl);
        return $beneficiary;
    }

    public function bill()
    {
        $bills = new Bills($this->publicKey, $this->secretKey, $this->baseUrl);
        return $bills;
    }
}