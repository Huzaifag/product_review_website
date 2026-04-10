<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->hasCookie('locale')) {
            App::setLocale($request->cookie('locale'));
            if (config('system.rtl') && $request->hasCookie('direction')) {
                Config::set('app.direction', $request->cookie('direction'));
            }
        } else {
            App::setLocale(config('app.locale'));
        }

        if (config('app.direction') == "rtl") {
            Config::set('toastr.options.positionClass', 'vironeer-toast-top-left');
        }

        return $next($request);
    }
}