<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusinessHasOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_if(!$request->route('business')->hasOwner(), 404);
        return $next($request);
    }
}
