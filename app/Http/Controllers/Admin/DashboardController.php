<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessOwner;
use App\Models\BusinessReview;
use App\Models\BusinessReviewReport;
use App\Models\Category;
use App\Models\KycVerification;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $counters['subscriptions'] = Subscription::count();
        $counters['earnings'] = Transaction::paid()->sum('total');
        $counters['transactions'] = Transaction::whereNot('status', Transaction::STATUS_UNPAID)->count();

        $counters['businesses'] = Business::count();
        $counters['reviews'] = BusinessReview::count();
        $counters['pending_reviews'] = BusinessReview::pending()->count();
        $counters['reported_reviews'] = BusinessReviewReport::count();

        // 1. Products 
        $counters['products'] = Product::active()->count();
        // 2. Categories
        $counters['categories'] = Category::count();

        // 3. SubCategories
        $counters['subcategories'] = SubCategory::count();

        //All Recently added Products 
        $products = Product::orderbyDesc('id')->limit(6)->get();

        $counters['kyc_verifications'] = KycVerification::count();
        $counters['pending_kyc_verifications'] = KycVerification::pending()->count();

        $counters['business_owners'] = BusinessOwner::count();
        $counters['users'] = User::count();

        $users = User::orderbyDesc('id')->limit(6)->get();
        $businesses = Business::orderbyDesc('id')->limit(6)->get();

        $charts['users'] = $this->generateUsersChartData();
        $charts['businesses'] = $this->generateBusinessesChartData();
        $charts['reviews'] = $this->generateReviewsChartData();

        return view('admin.dashboard', [
            'counters' => $counters,
            'charts' => $charts,
            'users' => $users,
            'businesses' => $businesses,
            'products' => $products,
        ]);
    }

    private function generateUsersChartData()
    {
        $chart['title'] = d_trans('Users');

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $dates = chartDates($startDate, $endDate);

        $usersRecord = User::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $usersRecordData = $dates->merge($usersRecord);

        $chart['labels'] = [];
        $chart['data'] = [];
        foreach ($usersRecordData as $date => $value) {
            $chart['labels'][] = Carbon::parse($date)->translatedFormat('d F');
            $chart['data'][] = $value;
        }

        $chart['max'] = (max($chart['data']) > 9) ? max($chart['data']) + 2 : 10;

        return $chart;
    }

    private function generateBusinessesChartData()
    {
        $chart['title'] = d_trans('Businesses');

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $dates = chartDates($startDate, $endDate);

        $businessesRecord = Business::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $businessesRecordData = $dates->merge($businessesRecord);

        $chart['labels'] = [];
        $chart['data'] = [];
        foreach ($businessesRecordData as $date => $value) {
            $chart['labels'][] = Carbon::parse($date)->translatedFormat('d F');
            $chart['data'][] = $value;
        }

        $chart['max'] = (max($chart['data']) > 9) ? max($chart['data']) + 2 : 10;

        return $chart;
    }

    private function generateReviewsChartData()
    {
        $chart['title'] = d_trans('Reviews');

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $dates = chartDates($startDate, $endDate);

        $reviewsRecord = BusinessReview::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $reviewsRecordData = $dates->merge($reviewsRecord);

        $chart['labels'] = [];
        $chart['data'] = [];
        foreach ($reviewsRecordData as $date => $value) {
            $chart['labels'][] = Carbon::parse($date)->translatedFormat('d F');
            $chart['data'][] = $value;
        }

        $chart['max'] = (max($chart['data']) > 9) ? max($chart['data']) + 2 : 10;

        return $chart;
    }
}
