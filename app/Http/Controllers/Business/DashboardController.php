<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Traits\Charts;
use Carbon\Carbon;

class DashboardController extends Controller
{
    use Charts;

    public function index()
    {
        $business = currentBusiness();

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $reviewsChart = $this->reviewsChart($startDate, $endDate, $business);
        if (authBusinessOwner()->isAdminOfCurrentBusiness()) {
            $viewsChart = $this->viewsChart($startDate, $endDate, $business);
        } else {
            $viewsChart = null;
        }

        if (request()->filled('reviews_date')) {
            $period = request()->input('reviews_date');
            $startDate = Carbon::parse($period)->startOfMonth();
            $endDate = Carbon::parse($period)->endOfMonth();

            $reviewsChart = $this->reviewsChart($startDate, $endDate, $business);
        }

        if (authBusinessOwner()->isAdminOfCurrentBusiness()) {
            if (request()->filled('views_date')) {
                $period = request()->input('views_date');
                $startDate = Carbon::parse($period)->startOfMonth();
                $endDate = Carbon::parse($period)->endOfMonth();

                $viewsChart = $this->viewsChart($startDate, $endDate, $business);
            }
        }

        $latestReviews = $business->reviews()->published()
            ->limit(6)->get();

        $charts['reviews'] = $reviewsChart;
        $charts['views'] = $viewsChart;

        return theme_view('business.dashboard', [
            'latestReviews' => $latestReviews,
            'charts' => $charts,
        ]);
    }
}
