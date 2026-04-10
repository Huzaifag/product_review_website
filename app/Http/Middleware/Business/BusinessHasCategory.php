<?php

namespace App\Http\Middleware\Business;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusinessHasCategory
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!currentBusiness()->hasCategory()) {
            toastr()->info(d_trans('Main category is required before adding more categories'));
            return redirect()->route('business.settings.index');
        }

        return $next($request);
    }
}
