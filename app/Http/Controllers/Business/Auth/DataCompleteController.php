<?php

namespace App\Http\Controllers\Business\Auth;

use App\Classes\ReCaptcha;
use App\Http\Controllers\Business\Auth\RegisterController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class DataCompleteController extends Controller
{
    protected $redirectTo;

    public function __construct()
    {
        $this->redirectTo = config('system.business.path');
    }

    public function showCompleteForm()
    {
        if (authBusinessOwner()->isDataCompleted()) {
            return redirect($this->redirectTo);
        }

        return theme_view('business.auth.complete');
    }

    public function complete(Request $request)
    {
        $businessOwner = authBusinessOwner();

        if ($businessOwner->isDataCompleted()) {
            return redirect($this->redirectTo);
        }

        $rules = [
            'firstname' => ['required', 'string', 'block_patterns', 'max:50'],
            'lastname' => ['required', 'string', 'block_patterns', 'max:50'],
            'username' => ['required', 'string', 'min:3', 'max:50', 'username', 'alpha_dash', 'block_patterns', 'unique:business_owners,username,' . $businessOwner->id],
            'email' => ['required', 'string', 'email', 'block_patterns', 'indisposable', 'max:100', 'unique:business_owners,email,' . $businessOwner->id],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ] + app(ReCaptcha::class)->validate();

        if (config('settings.links.terms_of_use_link')) {
            $rules['terms'] = ['required'];
        }

        if (config('settings.links.business_terms_link')) {
            $rules['business_terms'] = ['required'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $verify = (config('settings.business.actions.owners_email_verification') && $businessOwner->email != $request->email) ? true : false;

        $update = $businessOwner->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($update) {
            if ($verify) {
                $businessOwner->forceFill([
                    'email_verified_at' => null,
                ])->save();
                $businessOwner->sendEmailVerificationNotification();
            }
            RegisterController::adminNotify($businessOwner);
            return redirect($this->redirectTo);
        }
    }
}
