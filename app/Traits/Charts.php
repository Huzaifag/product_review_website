<?php

namespace App\Traits;

use App\Models\BusinessReview;
use App\Models\BusinessView;
use Carbon\Carbon;

trait Charts
{
    public function reviewsChart($startDate, $endDate, $business = null)
    {
        $chart['title'] = d_trans('Reviews');
        $dates = chartDates($startDate, $endDate);

        $reviews = BusinessReview::published();

        if ($business) {
            $reviews->where('business_id', $business->id);
        }

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
        $chart['title'] = d_trans('Views');
        $dates = chartDates($startDate, $endDate);

        $views = BusinessView::query();

        if ($business) {
            $views->where('business_id', $business->id);
        }

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
