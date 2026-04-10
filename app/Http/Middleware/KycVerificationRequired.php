<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KycVerificationRequired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = 'user'): Response
    {
        switch ($guard) {
            case 'business_owner':
                $guardAuth = authBusinessOwner();
                $key = 'settings.business.actions.owners_kyc_required';
                $redirect = route('business.account.settings.kyc');
                break;

            default:
                $guardAuth = authUser();
                $key = 'settings.user.actions.kyc_required';
                $redirect = $guardAuth ? $guardAuth->getKycLink() : '/';
                break;
        }

        if ($guardAuth && config('settings.kyc.actions.status') && config($key) && !$guardAuth->hasKycVerified()) {
            toastr()->info(d_trans('Please complete the KYC verification'));
            return redirect($redirect);
        }

        return $next($request);
    }
}