@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Businesses'))
@section('title', d_trans('Business Statistics'))
@section('header_title', d_trans(':business_name Statistics', ['business_name' => $business->trans->name]))
@section('back', route('admin.businesses.index'))
@section('business_view', true)
@section('content')
    @include('admin.businesses.includes.tabs')
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-4 g-3 mb-4">
        <div class="col">
            <div class="card h-100 p-4 text-center">
                <h2 class="mb-3"><img src="{{ $business->getAvgRatingImageLink() }}" alt="{{ $business->avg_ratings }}"
                        width="150px"><span class="ms-2">{{ $business->avg_ratings }}</span></h2>
                <h5 class="fw-light mb-0">{{ d_trans('Average Rating') }}</h5>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 p-4 text-center">
                <h2 class="mb-3">{{ number_format($business->total_reviews) }}</h2>
                <h5 class="fw-light mb-0">{{ d_trans('Total Reviews') }}</h5>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 p-4 text-center">
                <h2 class="mb-3">{{ number_format($business->total_views) }}</h2>
                <h5 class="fw-light mb-0">{{ d_trans('Current Month Views') }}</h5>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 p-4 text-center">
                <h2 class="mb-3">{{ number_format($business->total_views) }}</h2>
                <h5 class="fw-light mb-0">{{ d_trans('Total Views') }}</h5>
            </div>
        </div>
    </div>
    <div class="box h-100 mb-4">
        <div class="box-header">
            <p class="box-header-title large mb-0">{{ d_trans('Reviews Statistics') }}</p>
            <div class="box-header-action">
                @include('admin.partials.period-select', [
                    'select_classes' => 'form-select-sm',
                    'select_date' => $business->created_at,
                    'select_key' => 'reviews_date',
                ])
            </div>
        </div>
        <div class="box-body">
            <div class="dashboard-chart">
                <canvas id="reviews-chart" class="chart"></canvas>
            </div>
        </div>
    </div>
    <div class="box h-100">
        <div class="box-header">
            <p class="box-header-title large mb-0">{{ d_trans('Views Statistics') }}</p>
            <div class="box-header-action">
                @include('admin.partials.period-select', [
                    'select_classes' => 'form-select-sm',
                    'select_date' => $business->created_at,
                    'select_key' => 'views_date',
                ])
            </div>
        </div>
        <div class="box-body">
            <div class="dashboard-chart">
                <canvas id="views-chart" class="chart"></canvas>
            </div>
        </div>
    </div>
    @push('top_scripts')
        <script>
            "use strict";
            const chartsConfig = @json($charts);
        </script>
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/chartjs/chart.min.js') }}"></script>
        <script src="{{ asset('vendor/admin/js/charts.js') }}"></script>
    @endpush
@endsection
