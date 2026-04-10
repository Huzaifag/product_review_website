<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccountStatusMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        switch ($guard) {
            case 'business_owner':
                if (authBusinessOwner() && authBusinessOwner()->isBanned()) {
                    Auth::guard('business_owner')->logout();
                    toastr()->error(d_trans('Your account has been banned'));
                    return redirect()->route('business.login');
                }
                break;
            default:
                if (authUser() && authUser()->isBanned()) {
                    Auth::logout();
                    toastr()->error(d_trans('Your account has been banned'));
                    return redirect()->route('login');
                }
        }

        return $next($request);
    }
}