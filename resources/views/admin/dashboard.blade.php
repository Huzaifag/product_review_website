@extends('admin.layouts.app')
@section('title', d_trans('Dashboard'))
@section('header_title', d_trans('Dashboard'))
@section('content')
    {{-- @if (!config('settings.cronjob.last_execution'))
        <div class="note note-danger p-4 mb-4">
            <div class="row row-cols-auto g-4">
                <div class="col">
                    <i class="bi bi-exclamation-triangle fa-4x"></i>
                </div>
                <div class="col">
                    <h4>{{ d_trans('Cron Job Not Working') }}</h4>
                    <p class="mb-2">
                        {{ d_trans("It seems that your Cron Job isn't set up correctly, which might be causing it not to work as expected. Please double-check and ensure that your Cron Job is properly configured.") }}
                    </p>
                    <p class="mb-3">
                        {{ d_trans('Cron Job is required by multiple things to be run (Emails, Refresh businesses, Cache, Sitemap, etc...)') }}
                    </p>
                    <a href="{{ route('admin.system.cronjob.index') }}"
                        class="btn btn-outline-danger">{{ d_trans('Setup Cron Job') }}<i
                            class="fa-solid fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    @endif --}}
    @if (!config('settings.smtp.status'))
        <div class="alert alert-warning border border-warning p-4 mb-4">
            <div class="row row-cols-auto g-4">
                <div class="col">
                    <i class="bi bi-info-circle fa-4x"></i>
                </div>
                <div class="col">
                    <h4>{{ d_trans('SMTP Is Not Enabled') }}</h4>
                    <p class="mb-3">
                        {{ d_trans('SMTP is not enabled, set it now to be able to recover the password and use all the features that needs to send an email.') }}
                    </p>
                    <a href="{{ route('admin.settings.smtp.index') }}"
                        class="btn btn-outline-dark">{{ d_trans('Setup SMTP') }}<i
                            class="fa-solid fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    @endif
    @if (licenseType(2) && config('settings.subscription.status'))
        <div class="row g-3 mb-3">
            <div class="col-12 col-xxl-4">
                <div class="vironeer-counter-card bg-success">
                    <div class="vironeer-counter-card-icon">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ d_trans('Earnings') }}</p>
                        <p class="vironeer-counter-card-number">{{ getAmount($counters['earnings']) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xxl-4">
                <div class="vironeer-counter-card bg-c-56">
                    <div class="vironeer-counter-card-icon">
                        <i class="bi bi-gem"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ d_trans('Subscriptions') }}</p>
                        <p class="vironeer-counter-card-number">{{ $counters['subscriptions'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xxl-4">
                <div class="vironeer-counter-card bg-c-65">
                    <div class="vironeer-counter-card-icon">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div class="vironeer-counter-card-meta">
                        <p class="vironeer-counter-card-title">{{ d_trans('Transactions') }}</p>
                        <p class="vironeer-counter-card-number">{{ $counters['transactions'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-xxl-4 mb-4">
        <div class="col">
            <div class="vironeer-counter-card bg-c-42">
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-briefcase"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Total Products') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['products'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-primary">
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Total Categories') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['categories'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c-72">
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-star"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Total SubCategories') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['subcategories'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c-41">
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-flag"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Reported Reviews') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['reported_reviews'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c5">
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-person-circle"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Business Owners') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['business_owners'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c-11">
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Users') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['users'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c-38">
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('KYC Verifications') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['kyc_verifications'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c-24">
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('KYC Pending') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['pending_kyc_verifications'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-12 col-lg-7 col-xxl-8">
            <div class="box h-100">
                <div class="box-header">
                    <p class="box-header-title large mb-0">{{ d_trans('Users Statistics For This Month') }}</p>
                    <div class="box-header-action">
                        <div class="drop-down" data-dropdown>
                            <button class="drop-down-title btn btn-reset btn-sm">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="drop-down-menu">
                                <a class="drop-down-item"
                                    href="{{ route('admin.members.users.index') }}">{{ d_trans('View All') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="dashboard-chart">
                        <canvas id="users-chart" class="chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5 col-xxl-4">
            <div class="box h-100 p-0">
                <div class="box-header border-bottom mb-0 cp-2">
                    <p class="box-header-title large mb-0">{{ d_trans('Recently registered users') }}</p>
                    <div class="box-header-action">
                        <div class="drop-down" data-dropdown>
                            <button class="drop-down-title btn btn-reset btn-sm">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="drop-down-menu">
                                <a class="drop-down-item"
                                    href="{{ route('admin.members.users.index') }}">{{ d_trans('View All') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    @if ($users->count() > 0)
                        <div class="items">
                            @foreach ($users as $user)
                                <div class="item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('admin.members.users.edit', $user->id) }}"
                                            class="item-img me-3">
                                            <img src="{{ $user->getAvatar() }}" alt="{{ $user->getName() }}">
                                        </a>
                                        <div>
                                            <a href="{{ route('admin.members.users.edit', $user->id) }}"
                                                class="item-title d-block fw-500 mb-1">{{ $user->getName() }}</a>
                                            <p class="item-text text-muted small mb-0">
                                                {{ $user->created_at->diffforhumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <a href="{{ route('admin.members.users.edit', $user->id) }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-5">
                            @include('admin.partials.empty')
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5 col-xxl-4">
            <div class="box h-100 p-0">
                <div class="box-header border-bottom mb-0 cp-2">
                    <p class="box-header-title large mb-0">{{ d_trans('Recently added products') }}</p>
                    <div class="box-header-action">
                        <div class="drop-down" data-dropdown>
                            <button class="drop-down-title btn btn-reset btn-sm">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="drop-down-menu">
                                <a class="drop-down-item"
                                    href="{{ route('admin.products.index') }}">{{ d_trans('View All') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    @if ($products->count() > 0)
                        <div class="items">
                            @foreach ($products as $product)
                                <div class="item d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('admin.products.show', $product->id) }}"
                                            class="item-img me-3">
                                            <img src="{{ asset($product->getImageLink()) }}"
                                                alt="{{ $product->name }}">
                                        </a>
                                        <div>
                                            <a href="{{ route('admin.products.show', $product->id) }}"
                                                class="item-title d-block fw-500 mb-1">{{ $product->name }}</a>
                                            <p class="item-text text-muted small mb-0">
                                                {{ $product->created_at->diffforhumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    {{-- <div class="ms-3">
                                        <a href="{{ route('admin.products.show', $product->id) }}">
                                            <img src="{{ $product->getAvgRatingImageLink() }}"
                                                alt="{{ $product->avg_rating }}" width="120px" />
                                        </a>
                                    </div> --}}
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-5">
                            @include('admin.partials.empty')
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-7 col-xxl-8">
            <div class="box h-100">
                <div class="box-header">
                    <p class="box-header-title large mb-0">{{ d_trans('Product Statistics For This Month') }}</p>
                    <div class="box-header-action">
                        <div class="drop-down" data-dropdown>
                            <button class="drop-down-title btn btn-reset btn-sm">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <div class="drop-down-menu">
                                <a class="drop-down-item"
                                    href="{{ route('admin.products.index') }}">{{ d_trans('View All') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="dashboard-chart">
                        <canvas id="products-chart" class="chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="box h-100">
                <div class="box-header">
                    <p class="box-header-title large mb-0">{{ d_trans('Reviews Statistics For This Month') }}</p>
                </div>
                <div class="box-body">
                    <div class="dashboard-chart">
                        <canvas id="reviews-chart" class="chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('top_scripts')
        <script>
            "use strict";
            const chartsConfig = @json($charts);
        </script>
    @endpush
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/counter-cards.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/chartjs/chart.min.js') }}"></script>
        <script src="{{ asset_with_version('vendor/admin/js/charts.js') }}"></script>
    @endpush
@endsection
