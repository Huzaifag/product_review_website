<?php

namespace Vironeer\Flutterwave\Helpers;

use Illuminate\Support\Facades\Http;

class Payments
{
    protected $publicKey;
    protected $secretKey;
    protected $baseUrl;

    function __construct(String $publicKey, String $secretKey, String $baseUrl)
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
        $this->baseUrl = $baseUrl;
    }

    public function ACH(array $data)
    {
        $payment = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/charges?type=ach_payment',
            $data
        )->json();

        return $payment;
    }

    public function nigeriaBankTransfer(array $data)
    {
        $data['is_permanent'] = false;

        $payment = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/virtual-account-numbers',
            $data
        )->json();
        return $payment;
    }

    public function momoGH(array $data)
    {
        $data['currency'] = 'GHS';
        $payment = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/charges?type=mobile_money_ghana',
            $data
        )->json();

        if ($payment['status'] === 'success') {
            return [
                'status' => $payment['status'],
                'message' => $payment['message'],
                'data' => $payment['meta']['authorization'],
            ];
        }

        return $payment;
    }

    public function momoRW(array $data)
    {
        $data['currency'] = 'RWF';
        $payment = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/charges?type=mobile_money_rwanda',
            $data
        )->json();

        if ($payment['status'] === 'success') {
            return [
                'status' => $payment['status'],
                'message' => $payment['message'],
                'data' => $payment['meta']['authorization'],
            ];
        }

        return $payment;
    }

    public function momoUG(array $data)
    {
        $data['currency'] = 'UGX';
        $payment = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/charges?type=mobile_money_uganda',
            $data
        )->json();

        if ($payment['status'] === 'success') {
            return [
                'status' => $payment['status'],
                'message' => $payment['message'],
                'data' => $payment['meta']['authorization'],
            ];
        }

        return $payment;
    }

    public function momoZambia(array $data)
    {
        $data['currency'] = 'ZMW';
        $payment = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/charges?type=mobile_money_zambia',
            $data
        )->json();

        if ($payment['status'] === 'success') {
            return [
                'status' => $payment['status'],
                'message' => $payment['message'],
                'data' => $payment['meta']['authorization'],
            ];
        }

        return $payment;
    }

    public function mpesa(array $data)
    {
        $data['currency'] = 'KES';
        $payment = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/charges?type=mpesa',
            $data
        )->json();

        return $payment;
    }

    public function voucher(array $data)
    {
        $data['currency'] = 'ZAR';
        $payment = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/charges?type=voucher_payment',
            $data
        )->json();

        return $payment;
    }

    public function momoFranc(array $data)
    {
        $payment = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/charges?type=mobile_money_franco',
            $data
        )->json();

        return $payment;
    }
}