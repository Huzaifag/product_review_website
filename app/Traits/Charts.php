<?php

namespace App\Traits;

use App\Models\Product;
use App\Models\UserReview;
use Carbon\Carbon;

trait Charts
{
    public function reviewsChart($startDate, $endDate, $business = null)
    {
        $chart['title'] = d_trans('User Reviews');
        $dates = chartDates($startDate, $endDate);

        $reviews = UserReview::approved();

        $reviews = $reviews->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $reviewsData = $dates->merge($reviews);

        $chart['labels'] = [];
        $chart['data'] = [];
        foreach ($reviewsData as $date => $count) {
            $label = Carbon::parse($date)->translatedFormat('d M');
            $chart['labels'][] = $label;
            $chart['data'][] = $count;
        }

        $chart['max'] = (max($chart['data']) > 9) ? max($chart['data']) + 2 : 10;

        return $chart;
    }

    public function viewsChart($startDate, $endDate, $business = null)
    {
        $chart['title'] = d_trans('Products');
        $dates = chartDates($startDate, $endDate);

        $views = Product::query();

        $views = $views->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $viewsData = $dates->merge($views);

        $chart['labels'] = [];
        $chart['data'] = [];
        foreach ($viewsData as $date => $count) {
            $label = Carbon::parse($date)->translatedFormat('d M');
            $chart['labels'][] = $label;
            $chart['data'][] = $count;
        }

        $chart['max'] = (max($chart['data']) > 9) ? max($chart['data']) + 2 : 10;

        return $chart;
    }
}
