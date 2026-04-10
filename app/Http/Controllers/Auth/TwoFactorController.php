<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class TwoFactorController extends Controller
{
    protected $redirectTo;

    public function __construct()
    {
        $this->redirectTo = config('system.user.redirect_to');
    }

    public function show2FaVerifyForm()
    {
        if (authUser()->isTwoFactorDisabled() || session()->has('user_2fa')
            && session('user_2fa') == hash_encode(authUser()->id)) {
            return redirect($this->redirectTo);
        }

        return theme_view('auth.2fa');
    }

    public function verify2fa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp_code' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey(authUser()->two_factor_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(d_trans('Invalid OTP code'));
            return back();
        }

        session()->put('user_2fa', hash_encode(authUser()->id));
        return redirect($this->redirectTo);
    }
}
