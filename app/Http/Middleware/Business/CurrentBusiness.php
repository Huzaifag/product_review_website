<?php

namespace App\Http\Middleware\Business;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class CurrentBusiness
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasCookie('current_business')) {
            $business = authBusinessOwner()->businesses()->active()->first();
            if ($business) {
                Cookie::queue('current_business', $business->id, 1440 * 30);
            }
        }

        return $next($request);
    }
}