<?php

namespace App\Http\Controllers\Business\Auth;

use App\Classes\ReCaptcha;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return theme_view('business.auth.passwords.email');
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email'] + app(ReCaptcha::class)->validate());
    }

    protected function guard()
    {
        return Auth::guard('business_owner');
    }

    public function broker()
    {
        return Password::broker('business_owners');
    }
}