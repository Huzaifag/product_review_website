<?php

namespace App\Http\Controllers\Auth;

use App\Classes\ReCaptcha;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class DataCompleteController extends Controller
{
    protected $redirectTo;

    public function __construct()
    {
        $this->redirectTo = config('system.user.redirect_to');
    }

    public function showCompleteForm()
    {
        if (authUser()->isDataCompleted()) {
            return redirect($this->redirectTo);
        }

        return theme_view('auth.complete');
    }

    public function complete(Request $request)
    {
        $user = authUser();

        $rules = [
            'email' => ['required', 'string', 'email', 'block_patterns', 'indisposable', 'max:100', 'unique:users,email,' . $user->id],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ] + app(ReCaptcha::class)->validate();

        if (config('settings.links.terms_of_use_link')) {
            $rules['terms'] = ['required'];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $verify = (config('settings.user.actions.email_verification') && $user->email != $request->email) ? true : false;

        $update = $user->update([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($update) {
            if ($verify) {
                $user->forceFill([
                    'email_verified_at' => null,
                ])->save();
                $user->sendEmailVerificationNotification();
            }
            RegisterController::adminNotify($user);
            return redirect($this->redirectTo);
        }
    }
}