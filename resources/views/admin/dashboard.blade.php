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
    <div class="row g-4 row-cols-1 row-cols-md-2 row-cols-xxl-4 mb-4">
        <div class="col">
            <div class="split-stat-card theme-brand-base">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('Total Products') }}</p>
                    <h3 class="split-card-number">{{ $counters['products'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="bi bi-briefcase"></i>
                </div>
            </div>
        </div>


        <div class="col">
            <div class="split-stat-card theme-brand-mahogany">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('Total Tests') }}</p>
                    <h3 class="split-card-number">{{ $counters['product_tests'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="bi bi-clipboard-data"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="split-stat-card theme-brand-copper">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('Total Categories') }}</p>
                    <h3 class="split-card-number">{{ $counters['categories'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="bi bi-star-fill"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="split-stat-card theme-brand-clay">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('Total SubCategories') }}</p>
                    <h3 class="split-card-number">{{ $counters['subcategories'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="bi bi-star"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="split-stat-card theme-brand-sienna">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('Brands') }}</p>
                    <h3 class="split-card-number">{{ $counters['brands'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="bi bi-flag"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="split-stat-card theme-brand-gold">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('User Reviews') }}</p>
                    <h3 class="split-card-number">{{ $counters['reviews'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="bi bi-chat-right-quote"></i>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="split-stat-card theme-brand-sand">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('Users') }}</p>
                    <h3 class="split-card-number">{{ $counters['users'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="bi bi-people"></i>
                </div>
            </div>
        </div>

        

        <div class="col">
            <div class="split-stat-card theme-brand-brick">
                <div class="split-card-content">
                    <p class="split-card-title">{{ d_trans('KYC Verifications') }}</p>
                    <h3 class="split-card-number">{{ $counters['kyc_verifications'] }}</h3>
                </div>
                <div class="split-card-icon">
                    <i class="bi bi-person-check"></i>
                </div>
            </div>
        </div>

        
    </div>
    <div class="row g-3">
        <div class="col-12 col-lg-7 col-xxl-8">
            <div class="box h-100">
                <div class="box-header">
                    <p class="box-header-title large mb-0">
                        {{ d_trans('New users registered each day during this month') }}</p>
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
                                        <a href="{{ route('admin.products.show', $product->id) }}" class="item-img me-3">
                                            <img src="{{ asset($product->getImageLink()) }}" alt="{{ $product->name }}">
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
                    <p class="box-header-title large mb-0">{{ d_trans('Products added each day during this month') }}</p>
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
                    <p class="box-header-title large mb-0">
                        {{ d_trans('User reviews submitted each day during this month') }}</p>
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
        <style>
            /* --- Split Layout Stat Cards --- */

            .split-stat-card {
                position: relative;
                display: flex;
                align-items: center;
                border-radius: 8px;
                padding: 24px 20px;
                color: #ffffff;
                overflow: hidden;
                min-height: 110px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .split-stat-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            /* Left Content */
            .split-card-content {
                position: relative;
                z-index: 2;
                flex: 1;
            }

            .split-card-title {
                font-size: 13px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin: 0 0 8px 0;
                opacity: 0.95;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            }

            .split-card-number {
                font-size: 28px;
                font-weight: 700;
                margin: 0;
                line-height: 1;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            }

            /* Right Curved Shape */
            .split-card-icon {
                position: absolute;
                right: 0;
                top: 0;
                height: 100%;
                width: 35%;
                /* Adjusts how wide the curve section is */
                background-color: var(--shape-color);
                border-top-left-radius: 120px;
                /* Creates the curve */
                border-bottom-left-radius: 120px;
                /* Creates the curve */
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 32px;
                z-index: 1;
                transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Optional hover effect on the shape */
            .split-stat-card:hover .split-card-icon {
                width: 38%;
            }

            /* --- 8 Unique Color Themes --- */

            /* 1. Base Brand Color */
            .theme-brand-base {
                background: linear-gradient(120deg, #ba511d 0%, #d4724a 100%);
                --shape-color: #8a3a12;
            }

            /* 2. Soft Blush Copper */
            .theme-brand-copper {
                background: linear-gradient(120deg, #c96340 0%, #dea080 100%);
                --shape-color: #9a4228;
            }

            /* 3. Warm Peach Clay */
            .theme-brand-clay {
                background: linear-gradient(120deg, #d4845a 0%, #e8b595 100%);
                --shape-color: #ba511d;
            }

            /* 4. Dusty Rose Sienna */
            .theme-brand-sienna {
                background: linear-gradient(120deg, #c05535 0%, #d98870 100%);
                --shape-color: #8f3820;
            }

            /* 5. Soft Amber Gold */
            .theme-brand-gold {
                background: linear-gradient(120deg, #c97a2a 0%, #e0aa6a 100%);
                --shape-color: #9a5518;
            }

            /* 6. Linen Sand */
            .theme-brand-sand {
                background: linear-gradient(120deg, #d4a07a 0%, #e8c9aa 100%);
                --shape-color: #b07045;
            }

            /* 7. Soft Brick */
            .theme-brand-brick {
                background: linear-gradient(120deg, #b84535 0%, #d08070 100%);
                --shape-color: #8a2e20;
            }

            /* 8. Warm Mist Mahogany */
            .theme-brand-mahogany {
                background: linear-gradient(120deg, #9a4020 0%, #c07a5a 100%);
                --shape-color: #6e2a12;
            }
        </style>
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/chartjs/chart.min.js') }}"></script>
        <script src="{{ asset_with_version('vendor/admin/js/charts.js') }}"></script>
    @endpush
@endsection
