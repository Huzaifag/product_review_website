<?php

namespace Vironeer\Installer\App\Http\Middleware;

use Closure;

class UninstalledMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!config('system.install.complete')) {
            return redirect()->route('install.index');
        }

        return $next($request);
    }
}