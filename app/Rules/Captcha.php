<?php

namespace App\Rules;

use App\Classes\ReCaptcha;
use Illuminate\Contracts\Validation\Rule;

class Captcha implements Rule
{
    protected $service;

    public function __construct()
    {
        $this->service = app(ReCaptcha::class)->getService();
    }

    public function passes($attribute, $value)
    {
        if (empty($value)) {
            return false;
        }

        return $this->service->verify($value);
    }

    public function message()
    {
        return __('validation.captcha');
    }
}
