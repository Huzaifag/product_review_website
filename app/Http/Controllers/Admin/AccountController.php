<?php

namespace App\Http\Controllers\Admin;

use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index()
    {
        return view('admin.account', ['admin' => authAdmin()]);
    }

    public function detailsUpdate(Request $request)
    {
        $admin = authAdmin();

        $validator = Validator::make($request->all(), [
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'firstname' => ['required', 'string', 'block_patterns', 'max:255'],
            'lastname' => ['required', 'string', 'block_patterns', 'max:255'],
            'username' => ['required', 'string', 'min:3', 'max:50', 'alpha_dash', 'block_patterns', 'unique:admins,username,' . $admin->id],
            'email' => ['required', 'string', 'email', 'block_patterns', 'indisposable', 'unique:admins,email,' . $admin->id],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        try {
            if ($request->has('avatar')) {
                $avatar = FileHandler::upload($request->file('avatar'), [
                    'path' => 'images/avatars/admins/',
                    'size' => '120x120',
                    'old_file' => $admin->avatar,
                ]);
            } else {
                $avatar = $admin->avatar;
            }

        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

        $admin->avatar = $avatar;
        $admin->firstname = $request->firstname;
        $admin->lastname = $request->lastname;
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function passwordUpdate(Request $request)
    {
        $admin = authAdmin();

        $validator = Validator::make($request->all(), [
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
            'new_password_confirmation' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if (!(Hash::check($request->get('current_password'), $admin->password))) {
            toastr()->error(d_trans('Your current password does not matches with the password you provided.'));
            return back();
        }

        if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
            toastr()->error(d_trans('New Password cannot be same as your current password. Please choose a different password.'));
            return back();
        }

        $admin->password = Hash::make($request->get('new_password'));
        $admin->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function twoFactorEnable(Request $request)
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

        $admin = authAdmin();

        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($admin->two_factor_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(d_trans('Invalid OTP code'));
            return back();
        }

        $admin->two_factor_status = Admin::TWO_FACTOR_ACTIVE;
        $admin->update();

        session()->put('admin_2fa', hash_encode($admin->id));
        toastr()->success(d_trans('2FA Authentication has been enabled successfully'));
        return back();
    }

    public function twoFactorDisable(Request $request)
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

        $admin = authAdmin();

        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($admin->two_factor_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(d_trans('Invalid OTP code'));
            return back();
        }

        $admin->two_factor_status = Admin::TWO_FACTOR_DISABLED;
        $admin->update();

        if ($request->session()->has('admin_2fa')) {
            session()->forget('admin_2fa');
        }

        toastr()->success(d_trans('2FA Authentication has been disabled successfully'));
        return back();
    }
}