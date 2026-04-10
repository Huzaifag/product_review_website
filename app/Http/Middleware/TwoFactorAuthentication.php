<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwoFactorAuthentication
{
    public function handle(Request $request, Closure $next, $guard = 'web')
    {
        switch ($guard) {
            case 'admin':
                $sessionCookie = "admin_2fa";
                $route = route('admin.2fa.verify');
                break;
            case 'business_owner':
                $sessionCookie = "business_owner_2fa";
                $route = route('business.2fa.verify');
                break;
            default:
                $sessionCookie = "user_2fa";
                $route = route('2fa.verify');
        }

        if (Auth::guard($guard)->check() && Auth::guard($guard)->user()->isTwoFactorActive() &&
            !$request->session()->has($sessionCookie) &&
            session($sessionCookie) != encrypt(Auth::guard($guard)->user()->id)) {
            return redirect($route);
        }

        return $next($request);
    }
}