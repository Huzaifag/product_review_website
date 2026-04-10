<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DataCompleteMiddleware
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'business_owner':
                if (authBusinessOwner() && !authBusinessOwner()->isDataCompleted()) {
                    return redirect()->route('business.data.complete');
                }
                break;
            default:
                if (authUser() && !authUser()->isDataCompleted()) {
                    return redirect()->route('data.complete');
                }
                break;
        }

        return $next($request);
    }

}