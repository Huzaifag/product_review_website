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
    
    // Calculate combined limits from all active subscriptions
    $subscriptionsList = $subscriptions ?? collect();
    $activeSubscriptions = $subscriptionsList->filter(function($sub) {
        return !$sub->isExpired();
    });
    
    $totalLimit = 0;
    $totalUnlimited = false;
    foreach ($activeSubscriptions as $sub) {
        if ($sub->plan && is_null($sub->plan->products_limit)) {
            $totalUnlimited = true;
            break;
        }
        if ($sub->plan && $sub->plan->products_limit) {
            $totalLimit += (int)$sub->plan->products_limit;
        }
    }
    
    $isUnlimited = $totalUnlimited;
    $limit = $isUnlimited ? 0 : $totalLimit;
    $pct = $limit > 0 ? min(100, round(($used / $limit) * 100, 1)) : 0;
    $remain = max($limit - $used, 0);

    $subscriptionStatus = null;
    $statusColor = 'success';
    $allExpired = $activeSubscriptions->isEmpty();
    $anyAboutToExpire = $activeSubscriptions->contains(function($sub) {
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
@endphp

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            {{-- <h4 class="fw-bold mb-1">{{ d_trans('My Plan') }}</h4> --}}
            <p class="text-muted mb-0">{{ d_trans('View your subscription and usage') }}</p>
        </div>
        <a href="{{ route('plans') }}" class="btn btn-primary">
            <i class="bi bi-box me-2"></i>{{ d_trans('Browse Plans') }}
        </a>
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
                        <div class="border rounded p-3 bg-light">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $sub->plan->trans->name ?? 'Plan' }}</h6>
                                    <small class="text-muted">{{ $sub->plan->getIntervalName() ?? 'N/A' }}</small>
                                </div>
                                <span class="badge bg-{{ $sub->isAboutToExpire() ? 'warning' : 'success' }}">{{ $sub->isAboutToExpire() ? d_trans('Expiring soon') : d_trans('Active') }}</span>
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
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Combined Usage Bar -->
    <div class="card mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="fw-bold mb-0">{{ d_trans('Combined Usage') }}</h6>
                <span class="badge bg-light text-dark">{{ $pct }}%</span>
            </div>
            <div class="progress mb-3" style="height: 24px;">
                <div class="progress-bar" role="progressbar" style="width: {{ $pct }}%">
                    <small class="fw-bold text-white ps-2">{{ $used }} / {{ $isUnlimited ? '∞' : $limit }}</small>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-4">
                    <small class="text-muted">{{ d_trans('Viewed') }}</small>
                    <div class="fw-bold">{{ $used }}</div>
                </div>
                <div class="col-4">
                    <small class="text-muted">{{ d_trans('Total Limit') }}</small>
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
                <i class="bi bi-exclamation-circle me-2"></i>{{ d_trans("You've reached your combined plan limit") }}
            </div>
            @endif
        </div>
    </div>

    <!-- Past Subscriptions -->
    @php
        $expiredSubscriptions = $subscriptionsList->filter(function($sub) {
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
                                <small class="text-muted">{{ $item->plan ? $item->plan->getIntervalName() : d_trans('N/A') }}</small>
                            </div>
                            <span class="badge bg-danger">{{ d_trans('Expired') }}</span>
                        </div>
                        <hr class="my-2">
                        <div class="small">
                            <div class="mb-2">
                                <span class="text-muted">{{ d_trans('Expired:') }}</span>
                                <strong>{{ $item->expiry_at ? dateFormat($item->expiry_at) : d_trans('N/A') }}</strong>
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
                            <div class="h5 mb-0">{{ $planItem->getFormatPrice() }}<small class="fs-6 text-muted">/{{ strtolower($planItem->getIntervalName()) }}</small></div>
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
                        <h5 class="fw-bold mb-1">{{ d_trans('Recently Viewed') }}</h5>
                        <p class="text-muted small mb-0">
                            {{ $used }} {{ Str::plural('product', $used) }} {{ d_trans('this period') }}
                        </p>
                    </div>

                    {{-- Add search box --}}
                    <form method="GET" action="" class="ms-md-auto">
                        <div>
                            <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search products...') }}">
                        </div>
                    </form>
                </div>
                @if (!$productViewed->isEmpty())
                <span class="badge bg-light text-dark border rounded-pill">
                    {{ $productViewed->count() }} {{ Str::plural('item', $productViewed->count()) }}
                </span>
                @endif
            </div>
        </div>
        <div class="card-body p-4">
            @if ($productViewed->isEmpty())
            <div class="empty-state text-center py-5">
                <div class="empty-icon mb-3">
                    <i class="bi bi-eye-slash fs-1 text-muted opacity-25"></i>
                </div>
                <h6 class="text-muted fw-semibold">{{ d_trans('No products viewed yet') }}</h6>
                <p class="text-muted small mb-0">{{ d_trans('Start exploring products to see them here') }}</p>
            </div>
            @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @php
                    // Apply search filter if query exists
                    if (request('search')) {
                        $searchTerm = strtolower(request('search'));
                        $productViewed = $productViewed->filter(function($product) use ($searchTerm) {
                            return str_contains(strtolower($product->name), $searchTerm);
                        });
                    }
                @endphp
                @foreach ($productViewed as $product)
                <div class="col" data-aos="fade-up" data-aos-duration="600" data-aos-delay="{{ $loop->index * 50 }}">
                    @include('themes.basic.partials.product', [
                        'product' => $product,
                        'item_footer' => true,
                    ])
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .progress {
        background-color: #e9ecef;
    }

    .progress-bar {
        background: linear-gradient(90deg, #007bff 0%, #0dcaf0 100%);
    }

    .card {
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
    }

    .card-body {
        padding: 1.25rem;
    }

    .badge {
        padding: 0.4rem 0.6rem;
        font-size: 0.75rem;
        font-weight: 600;
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