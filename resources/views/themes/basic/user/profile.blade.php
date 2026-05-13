@extends('themes.basic.user.layout')

@section('title', d_trans(':username Profile', ['username' => ucfirst($user->getName())]))
@section('header_title', d_trans('My Plan'))
@section('breadcrumbs', Breadcrumbs::render('user.profile', $user))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'user.profile', $user))

@push('styles')
    <style>
        .premium-page {
            position: relative;
        }

        .premium-hero {
            background: linear-gradient(135deg, #7f1d1d 0%, #b91c1c 45%, #ef4444 100%);
            border-radius: 26px;
            padding: 32px;
            color: #fff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 24px 70px rgba(17, 24, 39, .22);
        }

        .premium-hero::before {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            right: -80px;
            top: -90px;
            background: radial-gradient(circle, rgba(255, 255, 255, .22), rgba(255, 255, 255, 0));
            border-radius: 50%;
        }

        .premium-hero::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            left: 45%;
            bottom: -90px;
            background: radial-gradient(circle, rgba(99, 102, 241, .45), rgba(99, 102, 241, 0));
            border-radius: 50%;
        }

        .premium-hero-content {
            position: relative;
            z-index: 2;
        }

        .premium-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 13px;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 999px;
            background: rgba(255, 255, 255, .08);
            backdrop-filter: blur(12px);
            font-size: 13px;
            color: rgba(255, 255, 255, .86);
        }

        .premium-title {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -.04em;
            margin-top: 18px;
            margin-bottom: 8px;
        }

        .premium-subtitle {
            color: rgba(255, 255, 255, .72);
            max-width: 640px;
            margin-bottom: 0;
        }

        .premium-card {
            border: 1px solid rgba(15, 23, 42, .08);
            border-radius: 24px;
            background: rgba(255, 255, 255, .88);
            box-shadow: 0 18px 45px rgba(15, 23, 42, .08);
            overflow: hidden;
        }

        .premium-card-header {
            padding: 22px 24px;
            border-bottom: 1px solid rgba(15, 23, 42, .07);
            background: linear-gradient(180deg, #fff, #f8fafc);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .premium-card-title {
            font-weight: 800;
            font-size: 18px;
            letter-spacing: -.02em;
            margin: 0;
            color: #0f172a;
        }

        .premium-card-subtitle {
            color: #64748b;
            font-size: 13px;
            margin-top: 3px;
        }

        .premium-card-body {
            padding: 24px;
        }

        .subscription-card,
        .plan-card {
            height: 100%;
            border: 1px solid rgba(15, 23, 42, .08);
            border-radius: 22px;
            padding: 22px;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, .98), rgba(248, 250, 252, .92));
            box-shadow: 0 14px 35px rgba(15, 23, 42, .06);
            transition: .25s ease;
            position: relative;
            overflow: hidden;
        }

        .subscription-card::before,
        .plan-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(99, 102, 241, .11), transparent 38%);
            pointer-events: none;
        }

        .subscription-card:hover,
        .plan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 22px 55px rgba(15, 23, 42, .11);
            border-color: rgba(99, 102, 241, .24);
        }

        .card-inner {
            position: relative;
            z-index: 2;
        }

        .plan-icon {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            color: #4f46e5;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .plan-name {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .plan-interval {
            color: #64748b;
            font-size: 13px;
        }

        .premium-badge {
            border-radius: 999px;
            padding: 7px 11px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-soft-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-soft-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-soft-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-featured {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: #fff;
            box-shadow: 0 10px 24px rgba(79, 70, 229, .28);
        }

        .meta-list {
            margin-top: 20px;
            display: grid;
            gap: 12px;
        }

        .meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 16px;
            background: rgba(248, 250, 252, .85);
            border: 1px solid rgba(15, 23, 42, .05);
        }

        .meta-label {
            color: #64748b;
            font-size: 13px;
        }

        .meta-value {
            color: #0f172a;
            font-weight: 700;
            font-size: 13px;
            text-align: right;
        }

        .price-wrap {
            margin-top: 20px;
            padding: 18px;
            border-radius: 20px;
            background: linear-gradient(135deg, rgb(198, 40, 40), rgb(244, 63, 94));
            color: #fff;
        }

        .price {
            font-size: 34px;
            line-height: 1;
            font-weight: 900;
            letter-spacing: -.05em;
        }

        .price-cycle {
            color: rgba(255, 255, 255, .62);
            font-size: 13px;
            margin-left: 4px;
        }

        .feature-list {
            margin-top: 18px;
            display: grid;
            gap: 10px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            color: #334155;
            font-size: 14px;
        }

        .feature-value {
            font-weight: 800;
            color: #0f172a;
        }

        .empty-premium {
            border: 1px dashed rgba(15, 23, 42, .18);
            border-radius: 22px;
            background: #f8fafc;
            padding: 28px;
        }

        @media (max-width: 767px) {
            .premium-hero {
                padding: 24px;
                border-radius: 22px;
            }

            .premium-title {
                font-size: 26px;
            }

            .premium-card-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
@endpush

@section('content')
    <div class="premium-page">

        <div class="premium-hero mb-4">
            <div class="premium-hero-content">
                <div class="premium-eyebrow">
                    <i class="fa-solid fa-crown"></i>
                    {{ d_trans('Premium Membership Dashboard') }}
                </div>

                <h1 class="premium-title text-white mt-3">
                    {{ d_trans('Manage your plan with confidence') }}
                </h1>

                <p class="premium-subtitle">
                    {{ d_trans('Track your active plan, subscription history, product usage, and available upgrades from one refined dashboard.') }}
                </p>
            </div>
        </div>

        @if ($plan)
            <div class="premium-card mb-4">
                <div class="premium-card-header">
                    <div>
                        <h2 class="premium-card-title">{{ d_trans('Current Plan Usage') }}</h2>
                        <div class="premium-card-subtitle">
                            {{ d_trans('Your active plan benefits and product viewing usage.') }}
                        </div>
                    </div>

                    <span class="premium-badge badge-soft-success">
                        <i class="fa-solid fa-circle-check me-1"></i>
                        {{ d_trans('Active') }}
                    </span>
                </div>

                <div class="premium-card-body">
                    @include('themes.basic.plans.usage', [
                        'subscription' => $subscription,
                        'plan' => $plan,
                        'userProductViewCount' => $userProductViewCount,
                        'productViewed' => $productViewed,
                        'user' => $user,
                    ])
                </div>
            </div>
        @endif

        <div class="premium-card mt-4">
            <div class="premium-card-header">
                <div>
                    <h2 class="premium-card-title">{{ d_trans('My Subscriptions') }}</h2>
                    <div class="premium-card-subtitle">
                        {{ d_trans('Review your active, expired, and upcoming subscription status.') }}
                    </div>
                </div>
            </div>

            <div class="premium-card-body">
                @if ($subscriptions->isNotEmpty())
                    <div class="row g-4">
                        @foreach ($subscriptions as $item)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="subscription-card">
                                    <div class="card-inner">
                                        <div class="d-flex align-items-start justify-content-between gap-3">
                                            <div>
                                                <div class="plan-icon">
                                                    <i class="fa-solid fa-gem"></i>
                                                </div>

                                                <div class="plan-name">
                                                    {{ $item->plan?->trans->name ?? d_trans('Plan') }}
                                                </div>

                                                <div class="plan-interval">
                                                    {{ $item->plan ? $item->plan->getIntervalName() : d_trans('N/A') }}
                                                </div>
                                            </div>

                                            @if ($item->isExpired())
                                                <span class="premium-badge badge-soft-danger">
                                                    {{ d_trans('Expired') }}
                                                </span>
                                            @elseif ($item->isAboutToExpire())
                                                <span class="premium-badge badge-soft-warning">
                                                    {{ d_trans('About to expire') }}
                                                </span>
                                            @else
                                                <span class="premium-badge badge-soft-success">
                                                    {{ d_trans('Active') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="meta-list">
                                            <div class="meta-row">
                                                <span class="meta-label">{{ d_trans('Started') }}</span>
                                                <span class="meta-value">
                                                    {{ $item->started_at ? dateFormat($item->started_at) : d_trans('N/A') }}
                                                </span>
                                            </div>

                                            <div class="meta-row">
                                                <span class="meta-label">{{ d_trans('Expires') }}</span>
                                                <span class="meta-value">
                                                    @if ($item->plan && $item->plan->isLifetime())
                                                        {{ d_trans('Lifetime') }}
                                                    @else
                                                        {{ $item->expiry_at ? dateFormat($item->expiry_at) : d_trans('N/A') }}
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-premium text-center">
                        <div class="h5 mb-1">{{ d_trans('No subscriptions found') }}</div>
                        <div class="text-muted">
                            {{ d_trans('Your purchased plans will appear here once available.') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="premium-card mt-4">
            <div class="premium-card-header">
                <div>
                    <h2 class="premium-card-title">{{ d_trans('All Plans') }}</h2>
                    <div class="premium-card-subtitle">
                        {{ d_trans('Compare available plans and choose the one that fits your needs.') }}
                    </div>
                </div>
            </div>

            <div class="premium-card-body">
                @if ($plans->isNotEmpty())
                    <div class="row g-4">
                        @foreach ($plans as $planItem)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="plan-card">
                                    <div class="card-inner">
                                        <div class="d-flex align-items-start justify-content-between gap-3">
                                            <div>
                                                <div class="plan-icon">
                                                    <i class="fa-solid fa-layer-group"></i>
                                                </div>

                                                <div class="plan-name">
                                                    {{ $planItem->trans->name }}
                                                </div>

                                                <div class="plan-interval">
                                                    {{ $planItem->getIntervalName() }}
                                                </div>
                                            </div>

                                            @if ($planItem->isFeatured())
                                                <span class="premium-badge badge-featured">
                                                    {{ d_trans('Popular') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="price-wrap">
                                            <div class="d-flex align-items-end">
                                                <div class="price">
                                                    {{ $planItem->getFormatPrice() }}
                                                </div>
                                                <div class="price-cycle">
                                                    /{{ strtolower($planItem->getIntervalName()) }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="feature-list">
                                            <div class="feature-item">
                                                <span>{{ d_trans('Products') }}</span>
                                                <span class="feature-value">
                                                    @if (is_null($planItem->products_limit))
                                                        {{ d_trans('Unlimited') }}
                                                    @else
                                                        {{ $planItem->products_limit }}
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="feature-item">
                                                <span>{{ d_trans('Categories') }}</span>
                                                <span class="feature-value">
                                                    {{ $planItem->hasCategoriesFeature() ? d_trans('Included') : d_trans('No') }}
                                                </span>
                                            </div>

                                            <div class="feature-item">
                                                <span>{{ d_trans('Employees') }}</span>
                                                <span class="feature-value">
                                                    {{ $planItem->hasEmployeesFeature() ? d_trans('Included') : d_trans('No') }}
                                                </span>
                                            </div>
                                        </div>
                                        @php
                                            $userPlanIds = auth()->check()
                                                ? optional(auth()->user()->currentPlans())->pluck('id') ?? collect()
                                                : collect();
                                        @endphp
                                        @if (!auth()->check() || !$userPlanIds->contains($planItem->id))
                                            <a href="{{ route('plans.details', $planItem->slug) }}"
                                                class="{{ $planItem->isFeatured() ? 'btn btn-primary mt-2' : 'btn btn-outline-primary mt-2' }} w-100">
                                                {{ d_trans('Get started') }}
                                            </a>
                                        @else
                                            <a href="{{ route('user.profile', auth()->user()->username) }}"
                                                class="btn btn-success w-100 disabled mt-2">
                                                {{ d_trans('You are subscribed') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-premium text-center">
                        <div class="h5 mb-1">{{ d_trans('No plans available') }}</div>
                        <div class="text-muted">
                            {{ d_trans('Please check again later for available plans.') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
