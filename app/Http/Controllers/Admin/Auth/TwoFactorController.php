<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class TwoFactorController extends Controller
{
    protected $redirectTo;

    public function __construct()
    {
        $this->redirectTo = config('system.admin.path');
    }

    public function show2FaVerifyForm()
    {
        if (!authAdmin()->two_factor_status ||
            session()->has('admin_2fa') && session('admin_2fa') == hash_encode(authAdmin()->id)) {
            return redirect($this->redirectTo);
        }
        return view('admin.auth.2fa');
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
        $valid = $google2fa->verifyKey(authAdmin()->two_factor_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(d_trans('Invalid OTP code'));
            return back();
        }

        session()->put('admin_2fa', hash_encode(authAdmin()->id));
        return redirect($this->redirectTo);
    }
}
