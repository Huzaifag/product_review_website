<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Validator;

class VerificationController extends Controller
{
    use VerifiesEmails;

    protected $redirectTo;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
        $this->redirectTo = config('system.user.redirect_to');
    }

    public function show(Request $request)
    {
        if (!config('settings.user.actions.email_verification')) {
            return redirect($this->redirectTo);
        } else {
            return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectTo)
            : theme_view('auth.verify');
        }
    }

    public function changeEmail(Request $request)
    {
        $user = authUser();

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:100', 'block_patterns', 'indisposable', 'unique:users,email,' . $user->id],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if ($user->email != $request->email) {
            $update = $user->update(['email' => $request->email]);
            if ($update) {
                $user->sendEmailVerificationNotification();
                toastr()->success(d_trans('Email has been changed successfully'));
                return back();
            }
        }
        return back();
    }
}