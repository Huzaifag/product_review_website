<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        if (config('settings.maintenance.status') && !authAdmin()) {
            return redirect()->route('maintenance');
        }

        return $next($request);
    }
}