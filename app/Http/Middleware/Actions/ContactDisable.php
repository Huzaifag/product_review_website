<?php

namespace App\Http\Middleware\Actions;

use Closure;
use Illuminate\Http\Request;

class ContactDisable
{
    public function handle(Request $request, Closure $next)
    {
        abort_if(!config('settings.actions.contact_page') || !config('settings.general.contact_email'), 404);
        return $next($request);
    }
}
