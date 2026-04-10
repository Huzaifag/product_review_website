<?php

namespace App\Http\Middleware\Business;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusinessHasFeature
{
    public function handle(Request $request, Closure $next, $feature): Response
    {
        abort_if(!currentBusiness()->hasFeature($feature), 404);
        return $next($request);
    }
}