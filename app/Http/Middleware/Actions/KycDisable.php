<?php

namespace App\Http\Middleware\Actions;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KycDisable
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_if(!config('settings.kyc.actions.status'), 404);
        return $next($request);
    }
}
