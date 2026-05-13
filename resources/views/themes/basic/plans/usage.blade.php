@extends('themes.basic.user.layout')
@section('no_index', true)
@section('title', d_trans('Plan Usage'))
@section('header_title', d_trans('Plan Usage'))
@section('breadcrumbs')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('user.settings', $user) }}
@endsection
@section('content')

    @php
        $used = $userProductViewCount?->products_viewed ?? 0;
        $subscriptionsList = $subscriptions ?? collect();
        $activeSubscriptions = $subscriptionsList->filter(function ($sub) {
            return !$sub->isExpired();
        });

        $isUnlimited = $plan && is_null($plan->products_limit);
        $limit = $isUnlimited ? 0 : (int) ($plan->products_limit ?? 0);
        $pct = $limit > 0 ? min(100, round(($used / $limit) * 100, 1)) : 0;
        $remain = max($limit - $used, 0);

        $subscriptionStatus = null;
        $statusColor = 'success';
        $allExpired = $activeSubscriptions->isEmpty();
        $anyAboutToExpire = $activeSubscriptions->contains(function ($sub) {
            return $sub->isAboutToExpire();
        });

        if ($allExpired) {
            $subscriptionStatus = d_trans('No Active Subscriptions');
            $statusColor = 'danger';
        } elseif ($anyAboutToExpire) {
            $subscriptionStatus = d_trans('About to expire');
            $statusColor = 'warning';
        } else {
            $subscriptionStatus = d_trans('Active');
            $statusColor = 'success';
        }

        $plansList = $plans ?? collect();
        $productViewedBySubscription = $productViewedBySubscription ?? collect();
        $viewCountsBySubscription = ($userProductViewCounts ?? collect())->keyBy('subscription_id');
    @endphp

    <div class="container-fluid">
        <!-- Header -->
        <div class="premium-page-header">
            <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap position-relative"
                style="z-index: 2;">
                <div>
                    <div class="d-inline-flex align-items-center gap-2 mb-3 px-3 py-2 rounded-pill"
                        style="background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.16);">
                        <i class="bi bi-stars"></i>
                        <span class="small fw-semibold">{{ d_trans('Membership Center') }}</span>
                    </div>

                    <h4 class="text-white">{{ d_trans('Your Premium Plan Dashboard') }}</h4>
                    <p>{{ d_trans('Track your subscriptions, usage, viewed products, and available upgrades in one place.') }}
                    </p>
                </div>

                <a href="{{ route('plans') }}" class="btn btn-primary premium-btn">
                    <i class="bi bi-box me-2"></i>{{ d_trans('Browse Plans') }}
                </a>
            </div>
        </div>

        <!-- Current Subscriptions -->
        @if ($activeSubscriptions->isNotEmpty())
            <div class="card mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="fw-bold mb-0">{{ d_trans('Active Plans') }}</h5>
                        </div>
                        <span class="badge bg-{{ $statusColor }} fs-6">{{ $subscriptionStatus }}</span>
                    </div>
                    <div class="row g-3">
                        @foreach ($activeSubscriptions as $sub)
                            <div class="col-12 col-md-6">
                                <div class="premium-plan-box">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="fw-bold mb-1">{{ $sub->plan->trans->name ?? 'Plan' }}</h6>
                                            <small class="text-muted">{{ $sub->plan->getIntervalName() ?? 'N/A' }}</small>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            @if ($subscription && $subscription->id === $sub->id)
                                                <span class="badge bg-primary">{{ d_trans('In use') }}</span>
                                            @endif
                                            <span
                                                class="badge bg-{{ $sub->isAboutToExpire() ? 'warning' : 'success' }}">{{ $sub->isAboutToExpire() ? d_trans('Expiring soon') : d_trans('Active') }}</span>
                                        </div>
                                    </div>
                                    <div class="small mt-2">
                                        <div class="mb-1">
                                            <span class="text-muted">{{ d_trans('Expires:') }}</span>
                                            <strong>
                                                @if ($sub->plan && $sub->plan->isLifetime())
                                                    {{ d_trans('Lifetime') }}
                                                @else
                                                    {{ $sub->expiry_at?->format('M d, Y') }}
                                                @endif
                                            </strong>
                                        </div>
                                        <div>
                                            <span class="text-muted">{{ d_trans('Limit:') }}</span>
                                            <strong>
                                                @if (is_null($sub->plan?->products_limit))
                                                    {{ d_trans('Unlimited') }}
                                                @else
                                                    {{ $sub->plan->products_limit }}
                                                @endif
                                            </strong>
                                        </div>
                                        <div class="mt-2">
                                            <span class="text-muted">{{ d_trans('Viewed:') }}</span>
                                            <strong>{{ $viewCountsBySubscription->get($sub->id)?->products_viewed ?? 0 }}</strong>
                                        </div>
                                        @php
                                            $subProducts = $productViewedBySubscription->get($sub->id, collect());
                                        @endphp
                                        {{-- <div class="mt-2">
                                    <span class="text-muted">{{ d_trans('Products viewed') }}</span>
                                    @if ($subProducts->isNotEmpty())
                                        <div class="small mt-1">
                                            {{ $subProducts->pluck('name')->take(5)->join(', ') }}
                                            @if ($subProducts->count() > 5)
                                                {{ d_trans('and :count more', ['count' => $subProducts->count() - 5]) }}
                                            @endif
                                        </div>
                                    @else
                                        <div class="small text-muted mt-1">{{ d_trans('No products viewed') }}</div>
                                    @endif
                                </div> --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @elseif ($plan)
            <!-- Fallback: Show default plan when no active subscriptions -->
            <div class="card mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="fw-bold mb-0">{{ d_trans('Current Plan') }}</h5>
                        </div>
                        <span class="badge bg-info fs-6">{{ d_trans('Default') }}</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="premium-plan-box">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $plan->trans->name ?? $plan->name }}</h6>
                                        <small class="text-muted">{{ $plan->getIntervalName() ?? 'N/A' }}</small>
                                    </div>
                                    <span class="badge bg-success">{{ d_trans('Active') }}</span>
                                </div>
                                <div class="small mt-2">
                                    <div class="mb-1">
                                        <span class="text-muted">{{ d_trans('Type:') }}</span>
                                        <strong>
                                            @if ($plan->isLifetime())
                                                {{ d_trans('Lifetime') }}
                                            @else
                                                {{ $plan->getIntervalName() }}
                                            @endif
                                        </strong>
                                    </div>
                                    <div>
                                        <span class="text-muted">{{ d_trans('Limit:') }}</span>
                                        <strong>
                                            @if (is_null($plan->products_limit))
                                                {{ d_trans('Unlimited') }}
                                            @else
                                                {{ $plan->products_limit }}
                                            @endif
                                        </strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Combined Usage Bar -->
        <div class="card mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="fw-bold mb-0">{{ d_trans('Usage') }}</h6>
                    <span class="badge bg-light text-dark">{{ $pct }}%</span>
                </div>
                <div class="progress mb-3" style="height: 24px;">
                    <div class="progress-bar" role="progressbar" style="width: {{ $pct }}%">
                        <small class="fw-bold text-white ps-2">{{ $used }} /
                            {{ $isUnlimited ? '∞' : $limit }}</small>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-4">
                        <small class="text-muted">{{ d_trans('Viewed') }}</small>
                        <div class="fw-bold">{{ $used }}</div>
                    </div>
                    <div class="col-4">
                        <small class="text-muted">{{ d_trans('Plan Limit') }}</small>
                        <div class="fw-bold">{{ $isUnlimited ? '∞' : $limit }}</div>
                    </div>
                    <div class="col-4">
                        <small class="text-muted">{{ d_trans('Remaining') }}</small>
                        <div class="fw-bold {{ $remain === 0 && !$isUnlimited ? 'text-danger' : '' }}">
                            {{ $isUnlimited ? '∞' : $remain }}
                        </div>
                    </div>
                </div>
                @if (!$isUnlimited && $used >= $limit && $limit > 0)
                    <div class="alert alert-danger mt-3 mb-0">
                        <i class="bi bi-exclamation-circle me-2"></i>{{ d_trans("You've reached your plan limit") }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Past Subscriptions -->
        @php
            $expiredSubscriptions = $subscriptionsList->filter(function ($sub) {
                return $sub->isExpired();
            });
        @endphp
        @if ($expiredSubscriptions->isNotEmpty())
            <h5 class="fw-bold mb-3">{{ d_trans('Past Subscriptions') }}</h5>
            <div class="row g-3 mb-4">
                @foreach ($expiredSubscriptions as $item)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 opacity-75">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $item->plan?->trans->name ?? d_trans('Plan') }}</h6>
                                        <small
                                            class="text-muted">{{ $item->plan ? $item->plan->getIntervalName() : d_trans('N/A') }}</small>
                                    </div>
                                    <span class="badge bg-danger">{{ d_trans('Expired') }}</span>
                                </div>
                                <hr class="my-2">
                                <div class="small">
                                    <div class="mb-2">
                                        <span class="text-muted">{{ d_trans('Expired:') }}</span>
                                        <strong>{{ $item->expiry_at ? dateFormat($item->expiry_at) : d_trans('N/A') }}</strong>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-muted">{{ d_trans('Viewed:') }}</span>
                                        <strong>{{ $viewCountsBySubscription->get($item->id)?->products_viewed ?? 0 }}</strong>
                                    </div>
                                    @php
                                        $subProducts = $productViewedBySubscription->get($item->id, collect());
                                    @endphp
                                    <div>
                                        <span class="text-muted">{{ d_trans('Products viewed') }}</span>
                                        @if ($subProducts->isNotEmpty())
                                            <div class="small mt-1">
                                                {{ $subProducts->pluck('name')->take(5)->join(', ') }}
                                                @if ($subProducts->count() > 5)
                                                    {{ d_trans('and :count more', ['count' => $subProducts->count() - 5]) }}
                                                @endif
                                            </div>
                                        @else
                                            <div class="small text-muted mt-1">{{ d_trans('No products viewed') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Available Plans -->
        @if ($plansList->isNotEmpty())
            <h5 class="fw-bold mb-3">{{ d_trans('Available Plans') }}</h5>
            <div class="row g-3 mb-4">
                @foreach ($plansList as $planItem)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $planItem->trans->name }}</h6>
                                        <small class="text-muted">{{ $planItem->getIntervalName() }}</small>
                                    </div>
                                    @if ($planItem->isFeatured())
                                        <span class="badge bg-primary">{{ d_trans('Popular') }}</span>
                                    @endif
                                </div>
                                <div class="my-3">
                                    <div class="h5 mb-0">{{ $planItem->getFormatPrice() }}<small
                                            class="fs-6 text-muted">/{{ strtolower($planItem->getIntervalName()) }}</small>
                                    </div>
                                </div>
                                <hr class="my-2">
                                <div class="small">
                                    <div class="mb-2">
                                        <span class="text-muted">{{ d_trans('Products:') }}</span>
                                        <strong>
                                            @if (is_null($planItem->products_limit))
                                                {{ d_trans('Unlimited') }}
                                            @else
                                                {{ $planItem->products_limit }}
                                            @endif
                                        </strong>
                                    </div>
                                    <div class="mb-2">
                                        <span class="text-muted">{{ d_trans('Categories:') }}</span>
                                        <strong>{{ $planItem->hasCategoriesFeature() ? d_trans('Yes') : d_trans('No') }}</strong>
                                    </div>
                                    <div>
                                        <span class="text-muted">{{ d_trans('Employees:') }}</span>
                                        <strong>{{ $planItem->hasEmployeesFeature() ? d_trans('Yes') : d_trans('No') }}</strong>
                                    </div>
                                </div>
                                <a href="{{ route('plans') }}" class="btn btn-primary btn-sm w-100 mt-3">
                                    {{ d_trans('View Details') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Viewed Products Section -->
        <div class="card border-0 shadow-sm products-card">
            <div class="card-header bg-transparent border-bottom-0 pt-4 px-4 pb-0">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-start justify-content-between gap-3 flex-wrap w-100">
                        <div>
                            <h5 class="fw-bold mb-1">{{ d_trans('Viewed History') }}</h5>
                            <p class="text-muted small mb-0">
                                {{ $used }} {{ Str::plural('product', $used) }} {{ d_trans('this period') }}
                            </p>
                        </div>

                        {{-- Add search box --}}
                        <form method="GET" action="" class="ms-md-auto">
                            <div>
                                <input type="text" name="search" class="form-control"
                                    placeholder="{{ d_trans('Search products...') }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body p-4">
                @php
                    $subscriptionsById = $subscriptionsList->keyBy('id');
                    $activeSubscriptionIds = $activeSubscriptions->pluck('id')->flip();
                    $historyItems = $productViewedBySubscription
                        ->filter(function ($items, $subscriptionId) use ($subscriptionsById) {
                            return $subscriptionsById->has($subscriptionId);
                        })
                        ->sortBy(function ($items, $subscriptionId) use ($activeSubscriptionIds, $subscriptionsById) {
                            $isActiveRank = $activeSubscriptionIds->has($subscriptionId) ? 0 : 1;
                            $startedAt = $subscriptionsById->get($subscriptionId)?->started_at?->timestamp ?? 0;
                            return [$isActiveRank, -$startedAt];
                        });
                @endphp

                @if ($historyItems->isEmpty())
                    <div class="empty-state text-center py-5">
                        <div class="empty-icon mb-3">
                            <i class="bi bi-eye-slash fs-1 text-muted opacity-25"></i>
                        </div>
                        <h6 class="text-muted fw-semibold">{{ d_trans('No products viewed yet') }}</h6>
                        <p class="text-muted small mb-0">{{ d_trans('Start exploring products to see them here') }}</p>
                    </div>
                @else
                    @foreach ($historyItems as $subscriptionId => $items)
                        @php
                            $sub = $subscriptionsById->get($subscriptionId);
                            $filteredItems = $items;
                            if (request('search')) {
                                $searchTerm = strtolower(request('search'));
                                $filteredItems = $filteredItems->filter(function ($product) use ($searchTerm) {
                                    return $product && str_contains(strtolower($product->name), $searchTerm);
                                });
                            }
                        @endphp
                        <div class="mb-4">
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                <div>
                                    <h6 class="fw-semibold mb-0">
                                        {{ $sub?->plan?->trans->name ?? d_trans('Plan') }}
                                    </h6>
                                    <small class="text-muted">
                                        {{ $sub?->started_at ? dateFormat($sub->started_at) : d_trans('N/A') }}
                                        -
                                        @if ($sub?->plan && $sub->plan->isLifetime())
                                            {{ d_trans('Lifetime') }}
                                        @else
                                            {{ $sub?->expiry_at ? dateFormat($sub->expiry_at) : d_trans('N/A') }}
                                        @endif
                                    </small>
                                </div>
                                <span class="badge bg-light text-dark border rounded-pill">
                                    {{ $items->count() }} {{ Str::plural('item', $items->count()) }}
                                </span>
                            </div>

                            @if ($filteredItems->isEmpty())
                                <div class="text-muted small">{{ d_trans('No products match your search') }}</div>
                            @else
                                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                                    @foreach ($filteredItems as $product)
                                        <div class="col" data-aos="fade-up" data-aos-duration="600"
                                            data-aos-delay="{{ $loop->index * 50 }}">
                                            @include('themes.basic.partials.product', [
                                                'product' => $product,
                                                'item_footer' => true,
                                            ])
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        :root {
            --premium-dark: #0f172a;
            --premium-soft: #f8fafc;
            --premium-border: rgba(15, 23, 42, .08);
            --premium-muted: #64748b;
            --premium-primary: #4f46e5;
            --premium-primary-2: #7c3aed;
            --premium-success: #16a34a;
            --premium-danger: #dc2626;
            --premium-warning: #d97706;
        }

        .container-fluid {
            position: relative;
        }

        .premium-page-header {
            background: radial-gradient(circle at top right, rgba(239, 68, 68, .28), transparent 35%),
            linear-gradient(135deg, #1f0f0f 0%, #3f1d1d 45%, #7f1d1d 100%);
            border-radius: 28px;
            padding: 30px;
            color: #fff;
            box-shadow: 0 24px 60px rgba(15, 23, 42, .22);
            margin-bottom: 28px;
            overflow: hidden;
            position: relative;
        }

        .premium-page-header::after {
            content: "";
            position: absolute;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            right: -70px;
            top: -80px;
        }

        .premium-page-header h4 {
            font-size: 30px;
            font-weight: 900;
            letter-spacing: -.04em;
            margin-bottom: 6px;
        }

        .premium-page-header p {
            color: rgba(255, 255, 255, .72) !important;
            margin-bottom: 0;
        }

        .premium-btn {
            border: 0;
            border-radius: 999px;
            padding: 11px 18px;
            font-weight: 700;
            box-shadow: 0 14px 30px rgba(79, 70, 229, .25);
            background: linear-gradient(135deg, var(--premium-primary), var(--premium-primary-2));
        }

        .card {
            border: 1px solid var(--premium-border) !important;
            border-radius: 24px !important;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .07);
            overflow: hidden;
            background: rgba(255, 255, 255, .94);
        }

        .card-body {
            padding: 1.6rem !important;
        }

        .premium-section-title {
            font-size: 20px;
            font-weight: 900;
            letter-spacing: -.03em;
            color: var(--premium-dark);
            margin-bottom: 14px;
        }

        .premium-plan-box {
            position: relative;
            border: 1px solid var(--premium-border) !important;
            border-radius: 22px !important;
            padding: 20px !important;
            background:
                radial-gradient(circle at top right, rgba(79, 70, 229, .12), transparent 38%),
                linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 12px 30px rgba(15, 23, 42, .06);
            transition: .25s ease;
            height: 100%;
        }

        .premium-plan-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 22px 50px rgba(15, 23, 42, .12);
            border-color: rgba(79, 70, 229, .25) !important;
        }

        .premium-plan-icon {
            width: 46px;
            height: 46px;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #eef2ff, #e0e7ff);
            color: var(--premium-primary);
            margin-bottom: 12px;
            font-size: 20px;
        }

        .premium-plan-name {
            font-size: 17px;
            font-weight: 900;
            color: var(--premium-dark);
            margin-bottom: 2px;
        }

        .premium-plan-meta {
            font-size: 13px;
            color: var(--premium-muted);
        }

        .badge {
            border-radius: 999px !important;
            padding: 7px 11px !important;
            font-size: 12px !important;
            font-weight: 800 !important;
        }

        .bg-success {
            background: #dcfce7 !important;
            color: #166534 !important;
        }

        .bg-danger {
            background: #fee2e2 !important;
            color: #991b1b !important;
        }

        .bg-warning {
            background: #fef3c7 !important;
            color: #92400e !important;
        }

        .bg-primary {
            background: linear-gradient(135deg, var(--premium-primary), var(--premium-primary-2)) !important;
            color: #fff !important;
        }

        .bg-info {
            background: #e0f2fe !important;
            color: #075985 !important;
        }

        .premium-info-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 11px 13px;
            border-radius: 15px;
            background: rgba(248, 250, 252, .9);
            border: 1px solid rgba(15, 23, 42, .05);
            margin-bottom: 9px;
        }

        .premium-info-row span {
            color: var(--premium-muted);
        }

        .premium-info-row strong {
            color: var(--premium-dark);
            font-weight: 900;
        }

        .usage-card {
            background:
                radial-gradient(circle at top right, rgba(14, 165, 233, .14), transparent 35%),
                linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        .usage-percent-badge {
            background: #eef2ff !important;
            color: #4338ca !important;
            border: 1px solid #c7d2fe;
        }

        .progress {
            height: 28px !important;
            border-radius: 999px;
            background: #e2e8f0 !important;
            overflow: hidden;
            box-shadow: inset 0 2px 6px rgba(15, 23, 42, .08);
        }

        .progress-bar {
            border-radius: 999px;
            background: linear-gradient(90deg, #4f46e5 0%, #06b6d4 100%) !important;
            box-shadow: 0 8px 20px rgba(79, 70, 229, .28);
        }

        .usage-stat {
            padding: 16px;
            border-radius: 18px;
            background: #fff;
            border: 1px solid var(--premium-border);
            box-shadow: 0 10px 24px rgba(15, 23, 42, .05);
        }

        .usage-stat small {
            color: var(--premium-muted);
            font-weight: 700;
        }

        .usage-stat .fw-bold {
            font-size: 22px;
            color: var(--premium-dark);
            margin-top: 4px;
        }

        .products-card {
            border-radius: 26px !important;
        }

        .products-card .card-header {
            background:
                linear-gradient(180deg, #ffffff 0%, #f8fafc 100%) !important;
            border-bottom: 1px solid var(--premium-border) !important;
        }

        .products-card h5 {
            font-size: 20px;
            font-weight: 900 !important;
            letter-spacing: -.03em;
        }

        .form-control {
            border-radius: 999px;
            border: 1px solid rgba(15, 23, 42, .11);
            padding: 11px 16px;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: rgba(79, 70, 229, .45);
            box-shadow: 0 0 0 .25rem rgba(79, 70, 229, .12);
        }

        .empty-state {
            border: 1px dashed rgba(15, 23, 42, .18);
            border-radius: 24px;
            background: #f8fafc;
        }

        .expired-card {
            opacity: .86;
            filter: grayscale(.15);
        }

        .available-plan-price {
            font-size: 26px;
            font-weight: 900;
            letter-spacing: -.04em;
            color: var(--premium-dark);
        }

        @media (max-width: 767px) {
            .premium-page-header {
                padding: 24px;
                border-radius: 22px;
            }

            .premium-page-header h4 {
                font-size: 24px;
            }

            .card-body {
                padding: 1.2rem !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Animate progress bar on page load
        document.addEventListener('DOMContentLoaded', function() {
            const progressBar = document.querySelector('.progress-bar-animated');
            if (progressBar) {
                const width = progressBar.style.width;
                progressBar.style.width = '0%';
                setTimeout(() => {
                    progressBar.style.width = width;
                }, 300);
            }
        });
    </script>
@endpush
