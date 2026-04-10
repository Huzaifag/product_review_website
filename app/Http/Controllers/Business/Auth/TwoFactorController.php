<?php

namespace App\Http\Controllers\Business\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class TwoFactorController extends Controller
{
    protected $redirectTo;

    public function __construct()
    {
        $this->redirectTo = config('system.business.path');
    }

    public function show2FaVerifyForm()
    {
        if (authBusinessOwner()->isTwoFactorDisabled() || session()->has('business_owner_2fa')
            && session('business_owner_2fa') == hash_encode(authBusinessOwner()->id)) {
            return redirect($this->redirectTo);
        }

        return theme_view('business.auth.2fa');
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
        $valid = $google2fa->verifyKey(authBusinessOwner()->two_factor_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(d_trans('Invalid OTP code'));
            return back();
        }

        session()->put('business_owner_2fa', hash_encode(authBusinessOwner()->id));
        return redirect($this->redirectTo);
    }
}