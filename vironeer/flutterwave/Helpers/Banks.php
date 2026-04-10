<?php

namespace Vironeer\Flutterwave\Helpers;

use Illuminate\Support\Facades\Http;

class Banks
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

    public function nigeria()
    {
        $banks = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/banks/NG'
        )->json();

        usort($banks['data'], function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return $banks;
    }

    public function ghana()
    {
        $banks = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/banks/GH'
        )->json();

        usort($banks['data'], function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return $banks;
    }

    public function kenya()
    {
        $banks = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/banks/KE'
        )->json();

        usort($banks['data'], function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return $banks;
    }

    public function uganda()
    {
        $banks = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/banks/UG'
        )->json();

        usort($banks['data'], function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return $banks;
    }

    public function southAfrica()
    {
        $banks = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/banks/ZA'
        )->json();

        usort($banks['data'], function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return $banks;
    }

    public function tanzania()
    {
        $banks = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/banks/TZ'
        )->json();

        usort($banks['data'], function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return $banks;
    }

    public function branches($bankId)
    {
        $branches = Http::withToken($this->secretKey)->get(
            $this->baseUrl . '/banks/' . $bankId . '/branches'
        )->json();

        return $branches;
    }
}