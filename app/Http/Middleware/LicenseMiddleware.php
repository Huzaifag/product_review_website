<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LicenseMiddleware
{
    public function handle(Request $request, Closure $next, $type = '1'): Response
    {
        abort_if(!licenseType($type), 404);
        return $next($request);
    }
}