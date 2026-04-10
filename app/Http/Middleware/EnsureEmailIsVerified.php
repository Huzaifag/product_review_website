<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class EnsureEmailIsVerified
{
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'business_owner':
                Auth::shouldUse('business_owner');
                if (authBusinessOwner() && config('settings.business.actions.owners_email_verification')) {
                    if (!$request->user() ||
                        ($request->user() instanceof MustVerifyEmail &&
                            !$request->user()->hasVerifiedEmail())) {
                        return $request->expectsJson()
                        ? abort(403, d_trans('Your email address is not verified.'))
                        : Redirect::guest(URL::route('business.verification.notice'));
                    }
                }
                break;
            default:
                if (authUser() && config('settings.user.actions.email_verification')) {
                    if (!$request->user() ||
                        ($request->user() instanceof MustVerifyEmail &&
                            !$request->user()->hasVerifiedEmail())) {
                        return $request->expectsJson()
                        ? abort(403, d_trans('Your email address is not verified.'))
                        : Redirect::guest(URL::route('verification.notice'));
                    }
                }
        }

        return $next($request);
    }
}
