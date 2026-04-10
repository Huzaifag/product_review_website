<?php

namespace App\Http\Controllers\Auth;

use App\Classes\ReCaptcha;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo;

    public function __construct()
    {
        $this->redirectTo = config('system.user.redirect_to');
    }

    public function showResetForm(Request $request)
    {
        $token = $request->route()->parameter('token');

        return theme_view('auth.passwords.reset')->with(
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
}
