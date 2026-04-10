<?php

namespace App\Http\Middleware\Business;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DomainVerificationRequired
{
    public function handle(Request $request, Closure $next): Response
    {
        if (currentBusiness()->isUnverified()) {
            toastr()->warning(d_trans('Domain verification required'));
            return redirect(route('business.settings.index'))->with('accordion_id', 'accordion5');
        }

        return $next($request);
    }
}
