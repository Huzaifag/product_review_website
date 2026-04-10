<?php

namespace App\Http\Middleware\Business;

use App\Models\Business;
use App\Models\BusinessView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BusinessViews
{
    public function handle(Request $request, Closure $next): Response
    {
        $domain = $request->route('domain');
        $business = Business::active()->where('domain', $domain)->first();

        if ($business) {
            $ip = getIp();
            $referrer = $request->server('HTTP_REFERER');
            $referrerHost = parse_url($referrer, PHP_URL_HOST);
            $websiteUrl = parse_url(url('/'), PHP_URL_HOST);

            if ($referrerHost == $websiteUrl) {
                $referrer = '/';
            }

            $lastView = BusinessView::where('business_id', $business->id)
                ->where('ip', $ip)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$lastView || $lastView->created_at->diffInHours(now()) >= 24) {
                $view = new BusinessView();
                $view->business_id = $business->id;
                $view->ip = $ip;
                $view->referrer = $referrer;
                $view->save();

                $business->increment('total_views');
                $business->increment('current_month_views');
            }
        }

        return $next($request);
    }
}
