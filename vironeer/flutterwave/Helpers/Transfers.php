<?php

namespace Vironeer\Flutterwave\Helpers;

use Illuminate\Support\Facades\Http;

class Transfers
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

    public function initiate(array $data)
    {
        $transfer = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/transfers',
            $data
        )->json();

        return $transfer;
    }

    public function bulk(array $data)
    {
        $transfer = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/bulk-transfers',
            $data
        )->json();

        return $transfer;
    }

    public function retry($transferId)
    {
        $transfer = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/transfers/' . $transferId . '/retries'
        )->json();

        return $transfer;
    }

    public function fees(array $data)
    {
        $transfer = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/transfers/fee',
            $data
        )->json();

        $transfer['data'] = $transfer['data'][0];
        return $transfer;
    }

    public function fetchAll(array $data = [])
    {
        $transfers = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/transfers',
            $data
        )->json();

        return $transfers;
    }

    public function fetch($id)
    {
        $transfer = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/transfers/' . $id
        )->json();

        return $transfer;
    }

    public function fetchRetries($id)
    {
        $transfer = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/transfers/' . $id . '/retries'
        )->json();

        return $transfer;
    }

    public function getTransferRate(array $data)
    {
        $transfer = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/transfers/rates',
            $data
        )->json();

        $transfer['data'] = $transfer['data'][0];
        return $transfer;
    }

}