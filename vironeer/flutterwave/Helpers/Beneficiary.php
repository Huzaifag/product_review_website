<?php

namespace Vironeer\Flutterwave\Helpers;

use Illuminate\Support\Facades\Http;

class Beneficiary
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

    public function create(array $data)
    {
        $beneficiary = Http::withToken($this->secretKey)->post(
            $this->baseUrl . '/beneficiaries',
            $data
        )->json();

        return $beneficiary;
    }

    public function fetchAll(array $data = [])
    {
        $beneficiaries = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/beneficiaries',
            $data
        )->json();

        return $beneficiaries;
    }

    public function fetch($id)
    {
        $beneficiary = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/beneficiaries/' . $id
        )->json();

        return $beneficiary;
    }

    public function destroy($id)
    {
        $beneficiary = Http::withToken($this->secretKey)->delete(
            $this->baseUrl . '/beneficiaries/' . $id
        )->json();

        return $beneficiary;
    }
}