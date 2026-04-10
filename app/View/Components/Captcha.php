<?php

namespace App\View\Components;

use App\Classes\ReCaptcha;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Captcha extends Component
{
    public function render()
    {
        $captchaProvider = app(ReCaptcha::class)->getDefaultCaptchaProvider();

        if ($captchaProvider) {
            $class = Str::studly($captchaProvider->alias) . 'Service';
            $service = new ("App\\Services\\Captcha\\{$class}");
            $captcha = $service->render(getLocale());

            return view('components.captcha', [
                'captcha' => $captcha,
            ]);
        }
    }
}
