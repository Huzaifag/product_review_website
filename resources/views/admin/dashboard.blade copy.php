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
    <div class="row g-3 row-cols-1 row-cols-md-2 row-cols-xxl-4 mb-4 dashboard-premium-counters">
        <div class="col">
            <div class="vironeer-counter-card premium-counter-card premium-counter-tone-1">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-briefcase"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Total Products') }}</p>
                    <p class="vironeer-counter-card-number">{{ numberFormat($counters['products']) }}</p>
                    <p class="premium-counter-footnote">{{ d_trans('Active inventory') }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card premium-counter-card premium-counter-tone-2">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Total Categories') }}</p>
                    <p class="vironeer-counter-card-number">{{ numberFormat($counters['categories']) }}</p>
                    <p class="premium-counter-footnote">{{ d_trans('Main groupings') }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card premium-counter-card premium-counter-tone-3">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-diagram-3"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Total SubCategories') }}</p>
                    <p class="vironeer-counter-card-number">{{ numberFormat($counters['subcategories']) }}</p>
                    <p class="premium-counter-footnote">{{ d_trans('Nested collections') }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card premium-counter-card premium-counter-tone-4">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-flag"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Brands') }}</p>
                    <p class="vironeer-counter-card-number">{{ numberFormat($counters['brands']) }}</p>
                    <p class="premium-counter-footnote">{{ d_trans('Published brands') }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card premium-counter-card premium-counter-tone-5">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-chat-quote"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('User Reviews') }}</p>
                    <p class="vironeer-counter-card-number">{{ numberFormat($counters['reviews']) }}</p>
                    <p class="premium-counter-footnote">{{ d_trans('Customer opinions') }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card premium-counter-card premium-counter-tone-6">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Users') }}</p>
                    <p class="vironeer-counter-card-number">{{ numberFormat($counters['users']) }}</p>
                    <p class="premium-counter-footnote">{{ d_trans('Registered accounts') }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card premium-counter-card premium-counter-tone-7">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('KYC Verifications') }}</p>
                    <p class="vironeer-counter-card-number">{{ numberFormat($counters['kyc_verifications']) }}</p>
                    <p class="premium-counter-footnote">{{ d_trans('Approved profiles') }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card premium-counter-card premium-counter-tone-8">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('KYC Pending') }}</p>
                    <p class="vironeer-counter-card-number">{{ numberFormat($counters['pending_kyc_verifications']) }}</p>
                    <p class="premium-counter-footnote">{{ d_trans('Waiting for review') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-12 col-lg-7 col-xxl-8">
            <div class="box h-100">
                <div class="box-header">
                    <p class="box-header-title large mb-0">{{ d_trans('New users registered each day during this month') }}</p>
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
                    <p class="box-header-title large mb-0">{{ d_trans('User reviews submitted each day during this month') }}</p>
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
            .dashboard-premium-counters .premium-counter-card {
                position: relative;
                overflow: hidden;
                border-radius: 18px;
                border: 1px solid rgba(255, 255, 255, 0.3);
                box-shadow: 0 16px 30px -14px rgba(5, 10, 25, 0.45);
                min-height: 160px;
                transition: transform 0.25s ease, box-shadow 0.25s ease;
                isolation: isolate;
            }

            .dashboard-premium-counters .premium-counter-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 24px 34px -18px rgba(5, 10, 25, 0.6);
            }

            .dashboard-premium-counters .premium-counter-card .vironeer-counter-card-bg {
                position: absolute;
                inset: auto -42px -42px auto;
                width: 170px;
                height: 170px;
                border-radius: 999px;
                background: linear-gradient(145deg, rgba(255, 255, 255, 0.35), rgba(255, 255, 255, 0.03));
                opacity: 0.55;
                z-index: -1;
            }


            .dashboard-premium-counters .premium-counter-card .vironeer-counter-card-icon {
                position: absolute;
                inset: auto 32px 28px auto;
                width: auto;
                height: auto;
                display: flex;
                align-items: center;
                justify-content: center;
                background: none;
                box-shadow: none;
                border: none !important;
                z-index: 0;
            }

            .dashboard-premium-counters .premium-counter-card .vironeer-counter-card-icon i {
                font-size: 2.8rem;
                color: rgba(255, 255, 255, 0.4);
            }

            .dashboard-premium-counters .premium-counter-card .vironeer-counter-card-meta {
                position: relative;
                z-index: 1;
            }

            .dashboard-premium-counters .premium-counter-card .vironeer-counter-card-title {
                opacity: 0.95;
                font-size: 0.84rem;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                margin-bottom: 5px;
            }

            .dashboard-premium-counters .premium-counter-card .vironeer-counter-card-number {
                font-size: 1.95rem;
                font-weight: 700;
                line-height: 1.1;
                margin-bottom: 6px;
            }

            .dashboard-premium-counters .premium-counter-badge {
                position: absolute;
                top: 12px;
                right: 14px;
                border-radius: 999px;
                padding: 3px 10px;
                font-size: 0.68rem;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                font-weight: 600;
                color: rgba(255, 255, 255, 0.95);
                background: rgba(0, 0, 0, 0.18);
            }

            .dashboard-premium-counters .premium-counter-footnote {
                margin-bottom: 0;
                font-size: 0.78rem;
                color: rgba(255, 255, 255, 0.85);
            }

            .dashboard-premium-counters .premium-counter-tone-1 {
                background: linear-gradient(135deg, #273d7f 0%, #385fca 60%, #53b0f7 100%);
            }

            .dashboard-premium-counters .premium-counter-tone-2 {
                background: linear-gradient(135deg, #21455e 0%, #2f7a9f 60%, #3eb9cf 100%);
            }

            .dashboard-premium-counters .premium-counter-tone-3 {
                background: linear-gradient(135deg, #462774 0%, #6e3cb8 60%, #9e61dc 100%);
            }

            .dashboard-premium-counters .premium-counter-tone-4 {
                background: linear-gradient(135deg, #4d3158 0%, #8b4376 60%, #dd6088 100%);
            }

            .dashboard-premium-counters .premium-counter-tone-5 {
                background: linear-gradient(135deg, #29425a 0%, #326881 60%, #4eb8bb 100%);
            }

            .dashboard-premium-counters .premium-counter-tone-6 {
                background: linear-gradient(135deg, #3e3054 0%, #5d3f84 60%, #8f5ab6 100%);
            }

            .dashboard-premium-counters .premium-counter-tone-7 {
                background: linear-gradient(135deg, #1f514e 0%, #2e7c67 60%, #52b583 100%);
            }

            .dashboard-premium-counters .premium-counter-tone-8 {
                background: linear-gradient(135deg, #5a2f37 0%, #a84b4f 60%, #e08457 100%);
            }

            @media (max-width: 575.98px) {
                .dashboard-premium-counters .premium-counter-card {
                    min-height: 146px;
                }

                .dashboard-premium-counters .premium-counter-card .vironeer-counter-card-number {
                    font-size: 1.7rem;
                }
            }
        </style>
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/chartjs/chart.min.js') }}"></script>
        <script src="{{ asset_with_version('vendor/admin/js/charts.js') }}"></script>
    @endpush
@endsection
