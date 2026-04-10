<?php

namespace App\Http\Controllers\Business;

use App\Classes\Country;
use App\Events\KycVerificationPending;
use App\Handlers\FileHandler;
use App\Http\Controllers\Controller;
use App\Models\BusinessOwner;
use App\Models\KycVerification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountSettingsController extends Controller
{
    public function index()
    {
        return theme_view('business.account.settings.index', ['businessOwner' => authBusinessOwner()]);
    }

    public function update(Request $request)
    {
        $businessOwner = authBusinessOwner();

        $validator = Validator::make($request->all(), [
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'firstname' => ['required', 'string', 'block_patterns', 'max:50'],
            'lastname' => ['required', 'string', 'block_patterns', 'max:50'],
            'username' => ['required', 'string', 'block_patterns', 'username', 'max:100', 'unique:business_owners,username,' . $businessOwner->id],
            'email' => ['required', 'string', 'block_patterns', 'email', 'max:100', 'unique:business_owners,email,' . $businessOwner->id],
            'address_line_1' => ['required', 'string', 'max:255', 'block_patterns'],
            'address_line_2' => ['nullable', 'string', 'max:255', 'block_patterns'],
            'city' => ['required', 'string', 'max:150', 'block_patterns'],
            'state' => ['required', 'string', 'max:150', 'block_patterns'],
            'zip' => ['required', 'string', 'max:100', 'block_patterns'],
            'country' => ['required', 'string', 'in:' . implode(',', array_keys(Country::all()))],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $verify = (config('settings.business.actions.owners_email_verification') && $businessOwner->email != $request->email) ? BusinessOwner::EMAIL_VERIFIED : BusinessOwner::EMAIL_UNVERIFIED;

        $country = $request->country ?? null;

        $address = [
            'line_1' => $request->address_line_1,
            'line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $country,
        ];

        try {
            if ($request->has('avatar')) {
                $avatar = FileHandler::upload($request->file('avatar'), [
                    'path' => 'images/avatars/business/',
                    'size' => '120x120',
                    'old_file' => $businessOwner->avatar,
                ]);
            } else {
                $avatar = $businessOwner->avatar;
            }
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }

        $businessOwner->firstname = $request->firstname;
        $businessOwner->lastname = $request->lastname;
        $businessOwner->username = $request->username;
        $businessOwner->email = $request->email;
        $businessOwner->address = $address;
        $businessOwner->avatar = $avatar;
        $businessOwner->update();

        if ($verify) {
            $businessOwner->forceFill(['email_verified_at' => null])->save();
            $businessOwner->sendEmailVerificationNotification();
        }

        toastr()->success(d_trans('Updated successfully'));
        return back();
    }

    public function password()
    {
        return theme_view('business.account.settings.password');
    }

    public function passwordUpdate(Request $request)
    {
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

        $user = authBusinessOwner();

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

    public function twoFactor()
    {
        return theme_view('business.account.settings.2fa', ['businessOwner' => authBusinessOwner()]);
    }

    public function towFactorEnable(Request $request)
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

        $businessOwner = authBusinessOwner();

        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($businessOwner->two_factor_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(d_trans('Invalid OTP code'));
            return back();
        }

        $businessOwner->two_factor_status = BusinessOwner::TWO_FACTOR_ACTIVE;
        $businessOwner->update();

        session()->put('business_owner_2fa', hash_encode($businessOwner->id));
        toastr()->success(d_trans('2FA Authentication has been enabled successfully'));
        return back();
    }

    public function towFactorDisable(Request $request)
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

        $businessOwner = authBusinessOwner();

        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($businessOwner->two_factor_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(d_trans('Invalid OTP code'));
            return back();
        }

        $businessOwner->two_factor_status = BusinessOwner::TWO_FACTOR_DISABLED;
        $businessOwner->update();

        if ($request->session()->has('business_owner_2fa')) {
            session()->forget('business_owner_2fa');
        }

        toastr()->success(d_trans('2FA Authentication has been disabled successfully'));
        return back();
    }

    public function kyc()
    {
        return theme_view('business.account.settings.kyc', ['businessOwner' => authBusinessOwner()]);
    }

    public function kycStore(Request $request)
    {
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

        $owner = authBusinessOwner();

        if ($owner->hasKycVerified() || $owner->hasKycPending()) {
            return back();
        }

        $documents = [
            'front_of_id' => null,
            'back_of_id' => null,
            'passport' => null,
            'selfie' => null,
        ];

        $hashId = strtolower(hash_encode($owner->id));

        try {
            if ($request->document_type == KycVerification::DOCUMENT_TYPE_NATIONAL_ID) {
                $documents['front_of_id'] = FileHandler::upload($request->file('front_of_id'), [
                    'disk' => 'private',
                    'path' => "docs/kyc/business-owners/{$hashId}/",
                ]);

                $documents['back_of_id'] = FileHandler::upload($request->file('back_of_id'), [
                    'disk' => 'private',
                    'path' => "docs/kyc/business-owners/{$hashId}/",
                ]);

            } elseif ($request->document_type == KycVerification::DOCUMENT_TYPE_PASSPORT) {
                $documents['passport'] = FileHandler::upload($request->file('passport'), [
                    'disk' => 'private',
                    'path' => "docs/kyc/business-owners/{$hashId}/",
                ]);
            }

            if (config('settings.kyc.actions.selfie_verification')) {
                $documents['selfie'] = FileHandler::upload($request->file('selfie'), [
                    'disk' => 'private',
                    'path' => "docs/kyc/business-owners/{$hashId}/",
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
        $kycVerification->business_owner_id = $owner->id;
        $kycVerification->save();

        event(new KycVerificationPending($kycVerification));

        toastr()->success(d_trans('Your documents has been submitted successfully'));
        return back();
    }
}
