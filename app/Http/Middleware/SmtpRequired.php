<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SmtpRequired
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!config('settings.smtp.status')) {
            die(d_trans('SMTP is not enabled, please enable the smtp from admin settings'));
        }

        return $next($request);
    }
}
