<?php

namespace App\Http\Controllers;

use App\Classes\Country;
use App\Events\KycVerificationPending;
use App\Handlers\FileHandler;
use App\Models\KycVerification;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function profile($username)
    {
        $user = User::where('username', $username)
            ->whereDataCompleted()
            ->firstOrFail();

        $reviews = $user->reviews()->published()
            ->orderbyDesc('id')->paginate(20);

        return theme_view('user.profile', [
            'user' => $user,
            'reviews' => $reviews,
        ]);
    }

    public function settings($username)
    {
        $user = $this->getCurrentUser($username);
        return theme_view('user.settings', ['user' => $user]);
    }

    public function detailsUpdate(Request $request, $username)
    {
        $user = $this->getCurrentUser($username);

        $validator = Validator::make($request->all(), [
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'firstname' => ['nullable', 'string', 'block_patterns', 'max:50'],
            'lastname' => ['nullable', 'string', 'block_patterns', 'max:50'],
            'username' => ['required', 'string', 'username', 'min:3', 'max:50', 'alpha_dash', 'block_patterns', 'unique:users,username,' . $user->id],
            'email' => ['required', 'email', 'string', 'block_patterns', 'indisposable', 'max:100', 'unique:users,email,' . $user->id],
            'country' => ['nullable', 'string', 'block_patterns', 'in:' . implode(',', array_keys(Country::all()))],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $verify = (config('settings.user.actions.email_verification') && $user->email != $request->email) ? User::EMAIL_VERIFIED : User::EMAIL_UNVERIFIED;

        try {
            if ($request->has('avatar')) {
                $avatar = FileHandler::upload($request->file('avatar'), [
                    'path' => 'images/avatars/users/',
                    'size' => '120x120',
                    'old_file' => $user->avatar,
                ]);
            } else {
                $avatar = $user->avatar;
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->avatar = $avatar;
        $user->update();

        if ($verify) {
            $user->forceFill(['email_verified_at' => null])->save();
            $user->sendEmailVerificationNotification();
        }

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function passwordUpdate(Request $request, $username)
    {
        $user = $this->getCurrentUser($username);

        $validator = Validator::make($request->all(), [
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            'new_password_confirmation' => ['required'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if (!(Hash::check($request->get('current_password'), $user->password))) {
            toastr()->error(d_trans('Your current password does not matches with the password you provided'));
            return back();
        }

        if (strcmp($request->get('current_password'), $request->get('new_password')) == 0) {
            toastr()->error(d_trans('New Password cannot be same as your current password. Please choose a different password'));
            return back();
        }

        $user->password = Hash::make($request->get('new_password'));
        $user->update();

        toastr()->success(d_trans('Updated Successfully'));
        return back();
    }

    public function towFactorEnable(Request $request, $username)
    {
        $user = $this->getCurrentUser($username);

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
        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(d_trans('Invalid OTP code'));
            return back();
        }

        $user->two_factor_status = User::TWO_FACTOR_ACTIVE;
        $user->update();

        session()->put('user_2fa', hash_encode($user->id));
        toastr()->success(d_trans('2FA Authentication has been enabled successfully'));
        return back();
    }

    public function towFactorDisable(Request $request, $username)
    {
        $user = $this->getCurrentUser($username);

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
        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(d_trans('Invalid OTP code'));
            return back();
        }

        $user->two_factor_status = User::TWO_FACTOR_DISABLED;
        $user->update();

        if ($request->session()->has('user_2fa')) {
            session()->forget('user_2fa');
        }

        toastr()->success(d_trans('2FA Authentication has been disabled successfully'));
        return back();
    }

    public function kyc($username)
    {
        $user = $this->getCurrentUser($username);
        return theme_view('user.kyc', ['user' => $user]);
    }

    public function kycStore(Request $request, $username)
    {
        $user = $this->getCurrentUser($username);

        $rules = [
            'document_type' => ['required', 'string', 'in:' . implode(',', array_keys(KycVerification::getAvailableDocumentTypes()))],
        ];

        if (config('settings.kyc.actions.selfie_verification')) {
            $rules['selfie'] = ['required', 'image', 'mimes:jpeg,jpg,png', 'max:4096'];
        }

        if ($request->document_type == KycVerification::DOCUMENT_TYPE_NATIONAL_ID) {
            $rules['front_of_id'] = ['required', 'image', 'mimes:jpeg,jpg,png', 'max:4096'];
            $rules['back_of_id'] = ['required', 'image', 'mimes:jpeg,jpg,png', 'max:4096'];
            $rules['national_id_number'] = ['required', 'string', 'block_patterns', 'max:30'];
            $documentNumber = $request->national_id_number;
        } elseif ($request->document_type == KycVerification::DOCUMENT_TYPE_PASSPORT) {
            $rules['passport'] = ['required', 'image', 'mimes:jpeg,jpg,png', 'max:4096'];
            $rules['passport_number'] = ['required', 'string', 'block_patterns', 'max:30'];
            $documentNumber = $request->passport_number;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if ($user->hasKycVerified() || $user->hasKycPending()) {
            return back();
        }

        $documents = [
            'front_of_id' => null,
            'back_of_id' => null,
            'passport' => null,
            'selfie' => null,
        ];

        $hashId = strtolower(hash_encode($user->id));

        try {
            if ($request->document_type == KycVerification::DOCUMENT_TYPE_NATIONAL_ID) {
                $documents['front_of_id'] = FileHandler::upload($request->file('front_of_id'), [
                    'disk' => 'private',
                    'path' => "docs/kyc/users/{$hashId}/",
                ]);

                $documents['back_of_id'] = FileHandler::upload($request->file('back_of_id'), [
                    'disk' => 'private',
                    'path' => "docs/kyc/users/{$hashId}/",
                ]);

            } elseif ($request->document_type == KycVerification::DOCUMENT_TYPE_PASSPORT) {
                $documents['passport'] = FileHandler::upload($request->file('passport'), [
                    'disk' => 'private',
                    'path' => "docs/kyc/users/{$hashId}/",
                ]);
            }

            if (config('settings.kyc.actions.selfie_verification')) {
                $documents['selfie'] = FileHandler::upload($request->file('selfie'), [
                    'disk' => 'private',
                    'path' => "docs/kyc/users/{$hashId}/",
                ]);
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

        $kycVerification = new KycVerification();
        $kycVerification->document_type = $request->document_type;
        $kycVerification->document_number = $documentNumber;
        $kycVerification->documents = $documents;
        $kycVerification->user_id = $user->id;
        $kycVerification->save();

        event(new KycVerificationPending($kycVerification));

        toastr()->success(d_trans('Your documents has been submitted successfully'));
        return back();
    }

    public function getCurrentUser($username)
    {
        return User::where('id', authUser()->id)->where('username', $username)
            ->whereDataCompleted()
            ->firstOrFail();
    }
}