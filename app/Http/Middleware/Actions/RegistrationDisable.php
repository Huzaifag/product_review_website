<?php

namespace App\Http\Middleware\Actions;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationDisable
{
    public function handle(Request $request, Closure $next, $guard = "user"): Response
    {
        switch ($guard) {
            case 'business_owner':
                $key = 'settings.business.actions.owners_registration';
                break;

            default:
                $key = 'settings.user.actions.registration';
                break;
        }

        abort_if(!config($key), 404);

        return $next($request);
    }
}
