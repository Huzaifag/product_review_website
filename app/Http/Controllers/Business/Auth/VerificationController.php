<?php

namespace App\Http\Controllers\Business\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class VerificationController extends Controller
{
    use VerifiesEmails;

    protected $redirectTo;

    public function __construct()
    {
        Auth::shouldUse('business_owner');
        $this->middleware('auth:business_owner')->except('logout');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
        $this->redirectTo = config('system.business.path');
    }

    public function show(Request $request)
    {
        if (!config('settings.business.actions.owners_email_verification')) {
            return redirect($this->redirectTo);
        } else {
            return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectTo)
            : theme_view('business.auth.verify');
        }
    }

    public function changeEmail(Request $request)
    {
        $businessOwner = authBusinessOwner();

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'max:100', 'block_patterns', 'indisposable', 'unique:business_owners,email,' . $businessOwner->id],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        if ($businessOwner->email != $request->email) {
            $update = $businessOwner->update(['email' => $request->email]);
            if ($update) {
                $businessOwner->sendEmailVerificationNotification();
                toastr()->success(d_trans('Email has been changed successfully'));
                return back();
            }
        }
        return back();
    }
}
