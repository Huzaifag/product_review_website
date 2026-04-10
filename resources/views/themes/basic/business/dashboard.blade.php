@extends('themes.basic.business.layouts.app')
@section('container', 'dashboard-container-xxl')
@section('title', d_trans('Dashboard'))
@section('header_title', d_trans('Dashboard'))
@section('breadcrumbs', Breadcrumbs::render('business.dashboard'))
@section('content')
    <div class="row row-cols-1 g-3">
        <div class="col">
            <div class="row g-3">
                <div class="col-12 col-md-6 col-lg">
                    <div class="box dashboard-box dashboard-counter d-flex align-items-center justify-content-between gap-3">
                        <div class="dashboard-counter-info d-flex flex-column">
                            <h6 class="dashboard-counter-title">{{ d_trans('Average Rating') }}</h6>
                            <div class="dashboard-counter-text ratings ratings-lg">
                                <img src="{{ $currentBusiness->getAvgRatingImageLink() }}"
                                    alt="{{ $currentBusiness->avg_ratings }}" />
                                <span class="small ms-1">{{ $currentBusiness->avg_ratings }}</span>
                            </div>
                        </div>
                        <div class="dashboard-counter-icon">
                            <i class="bi bi-star"></i>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg">
                    <div
                        class="box dashboard-box dashboard-counter d-flex align-items-center justify-content-between gap-3">
                        <div class="dashboard-counter-info d-flex flex-column">
                            <h6 class="dashboard-counter-title">{{ d_trans('Total Reviews') }}</h6>
                            <span class="dashboard-counter-text">{{ number_format($currentBusiness->total_reviews) }}</span>
                        </div>
                        <div class="dashboard-counter-icon">
                            <i class="bi bi-pencil"></i>
                        </div>
                    </div>
                </div>
                @if (authBusinessOwner()->isAdminOfCurrentBusiness())
                    <div class="col-12 col-md-12 col-lg">
                        <div
                            class="box dashboard-box dashboard-counter d-flex align-items-center justify-content-between gap-3">
                            <div class="dashboard-counter-info d-flex flex-column">
                                <h6 class="dashboard-counter-title">{{ d_trans('Total Visitors') }}</h6>
                                <span
                                    class="dashboard-counter-text">{{ numberFormat($currentBusiness->total_views) }}</span>
                            </div>
                            <div class="dashboard-counter-icon">
                                <i class="bi bi-eye"></i>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col">
            <div class="row g-3">
                <div class="col-12 col-xxl-8">
                    <div class="box dashboard-box dashboard-chart-box">
                        <div class="row align-items-center g-3 mb-3">
                            <div class="col">
                                <h5 class="mb-0">{{ d_trans('Reviews Statistics') }}</h5>
                            </div>
                            <div class="col-auto">
                                @include('themes.basic.business.partials.period-select', [
                                    'select_date' => $currentBusiness->created_at,
                                    'select_key' => 'reviews_date',
                                ])
                            </div>
                        </div>
                        <div class="dashboard-chart">
                            <canvas id="reviews-chart" class="chart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xxl-4">
                    <div class="box dashboard-box h-100">
                        <div class="row align-items-center g-3 mb-3">
                            <div class="col">
                                <h5 class="mb-0">{{ d_trans('Latest Reviews') }}</h5>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('business.reviews.index') }}" class="small">{{ d_trans('View All') }}<i
                                        class="fa-solid fa-angle-right icon-rtl ms-2"></i></a>
                            </div>
                        </div>
                        @if ($latestReviews->count() > 0)
                            <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
                                @foreach ($latestReviews as $latestReview)
                                    @php
                                        $reviewer = $latestReview->reviewer;
                                    @endphp
                                    <li>
                                        <a href="{{ $latestReview->getLink() }}" target="_blank"
                                            class="d-flex align-items-center justify-content-between gap-3">
                                            <div class="review-author review-author-sm mb-0">
                                                <div class="review-author-img">
                                                    <img src="{{ $reviewer->avatar }}" alt="{{ $reviewer->name }}" />
                                                </div>
                                                <div class="review-author-info">
                                                    <h6 class="review-author-title mb-1">{{ $reviewer->name }}</h6>
                                                    <p class="review-author-text small mb-0">
                                                        {{ $latestReview->created_at->diffforhumans() }}</p>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    class="text-muted">{{ number_format($latestReview->stars, 1) }}</span>
                                                <div class="ratings ratings-sm">
                                                    <img src="{{ $latestReview->getRatingImageLink() }}"
                                                        alt="{{ $latestReview->stars }}" />
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            @include('themes.basic.business.partials.empty')
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if (authBusinessOwner()->isAdminOfCurrentBusiness())
            <div class="col">
                <div class="box dashboard-box dashboard-chart-box">
                    <div class="row align-items-center g-3 mb-3">
                        <div class="col">
                            <h5 class="mb-0">{{ d_trans('Views Statistics') }}</h5>
                        </div>
                        <div class="col-auto">
                            @include('themes.basic.business.partials.period-select', [
                                'select_date' => $currentBusiness->created_at,
                                'select_key' => 'views_date',
                            ])
                        </div>
                    </div>
                    <div class="dashboard-chart">
                        <canvas id="views-chart"></canvas>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @push('top_scripts')
        <script>
            "use strict";
            const chartsConfig = @json($charts);
        </script>
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/chartjs/chart.min.js') }}"></script>
        <script src="{{ theme_asset_with_version('assets/js/charts.js') }}"></script>
    @endpush
@endsection
