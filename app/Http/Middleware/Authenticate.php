<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                switch ($guard) {
                    case 'admin':
                        return redirect()->guest(route('admin.login'));
                        break;
                    case 'business_owner':
                        return redirect()->guest(route('business.login'));
                        break;
                    default:
                        return redirect()->guest(route('login'));
                }
            }
        }

        return $next($request);
    }
}