<?php

namespace Vironeer\Flutterwave\Helpers;

use Illuminate\Support\Facades\Http;

class Bills
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
        return $data;
        $bill = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/bills',
            $data
        )->json();

        return $bill;
    }

    public function get_categories(array $data = [])
    {
        $bills_categories = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/bill-categories',
            $data
        )->json();

        return $bills_categories;
    }

    public function validate(string $item_code, array $data)
    {
        $validate = Http::withToken($this->secretKey)->get(
            $this->baseUrl . "/bill-items/$item_code/validate",
            $data
        )->json();

        return $validate;
    }

    public function fetchAll(array $data = [])
    {
        $bills = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/bills',
            $data
        )->json();

        return $bills;
    }

    public function fetch_status($reference)
    {
        $status = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/bills/' . $reference
        )->json();

        return $status;
    }

}