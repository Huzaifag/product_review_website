<?php

namespace App\Http\Middleware\Business;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnerHasBusinesses
{
    public function handle(Request $request, Closure $next): Response
    {
        if (authBusinessOwner() && !authBusinessOwner()->hasBusinesses()) {
            return redirect()->route('business.setup.index');
        }

        return $next($request);
    }
}