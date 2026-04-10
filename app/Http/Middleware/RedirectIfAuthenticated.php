<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                switch ($guard) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                        break;
                    case 'business_owner':
                        return redirect()->route('business.dashboard');
                        break;
                    default:
                        return redirect(config('system.user.redirect_to'));
                }
            }
        }

        return $next($request);
    }
}