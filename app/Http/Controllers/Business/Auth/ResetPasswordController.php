<?php

namespace App\Http\Controllers\Business\Auth;

use App\Classes\ReCaptcha;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo;

    public function __construct()
    {
        $this->redirectTo = config('system.business.path');
    }

    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');

        return theme_view('business.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ] + app(ReCaptcha::class)->validate();
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