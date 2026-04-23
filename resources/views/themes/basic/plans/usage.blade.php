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
    $isUnlimited = is_null($plan->products_limit);
    $limit = $isUnlimited ? 0 : (int) $plan->products_limit;
    $pct = $limit > 0 ? min(100, round(($used / $limit) * 100)) : 0;
    $remain = max($limit - $used, 0);
    $circumference = 2 * M_PI * 58;
    $dashFill = ($pct / 100) * $circumference;
    $dashGap = $circumference - $dashFill;

    $subscriptionStatus = null;
    $statusColor = 'success';
    if (!empty($subscription)) {
        if ($subscription->isExpired()) {
            $subscriptionStatus = d_trans('Expired');
            $statusColor = 'danger';
        } elseif ($subscription->isAboutToExpire()) {
            $subscriptionStatus = d_trans('About to expire');
            $statusColor = 'warning';
        } else {
            $subscriptionStatus = d_trans('Active');
            $statusColor = 'success';
        }
    }
@endphp

<div class="container-fluid px-0">
    <!-- Header Section -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">{{ d_trans('Plan Usage Dashboard') }}</h4>
                <p class="text-muted mb-0">{{ d_trans('Monitor your subscription and usage metrics') }}</p>
            </div>
            <a href="{{ route('plans') }}" class="btn btn-primary btn-lg px-4">
                <i class="bi bi-arrow-up-circle me-2"></i>{{ d_trans('Upgrade Plan') }}
            </a>
        </div>
    </div>

    <!-- Subscription Status Banner -->
    @if ($subscription)
    <div class="subscription-banner mb-4 position-relative overflow-hidden">
        <div class="subscription-banner-bg"></div>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 position-relative">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="subscription-icon bg-{{ $statusColor }}-subtle rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-shield-check text-{{ $statusColor }} fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">{{ $subscription->plan->trans->name ?? $subscription->plan->name }}</h5>
                                <span class="badge bg-{{ $statusColor }}-subtle text-{{ $statusColor }} rounded-pill px-3 py-2">
                                    <i class="bi bi-circle-fill me-1 small"></i>{{ $subscriptionStatus }}
                                </span>
                            </div>
                        </div>
                        <div class="subscription-details d-flex flex-wrap gap-4 mt-3">
                            <div class="detail-item">
                                <span class="text-muted small text-uppercase tracking-wide">{{ d_trans('Started') }}</span>
                                <div class="fw-semibold">{{ $subscription->started_at?->format('M d, Y') }}</div>
                            </div>
                            @if ($subscription->expiry_at)
                            <div class="detail-item">
                                <span class="text-muted small text-uppercase tracking-wide">{{ d_trans('Expires') }}</span>
                                <div class="fw-semibold">{{ $subscription->expiry_at?->format('M d, Y') }}</div>
                            </div>
                            @endif
                            <div class="detail-item">
                                <span class="text-muted small text-uppercase tracking-wide">{{ d_trans('Billing') }}</span>
                                <div class="fw-semibold text-capitalize">{{ $plan->interval }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                        @if ($subscription->isAboutToExpire())
                        <div class="alert alert-warning border-0 mb-0 d-inline-block">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{ d_trans('Renew soon to avoid interruption') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Usage Overview Cards -->
    <div class="row g-4 mb-4">
        <!-- Main Usage Card -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm usage-card">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-1">{{ d_trans('Usage Overview') }}</h5>
                            <p class="text-muted small mb-0">{{ d_trans('Current billing period') }}</p>
                        </div>
                        @if (!$isUnlimited)
                        <div class="usage-badge">
                            <span class="badge bg-light text-dark border rounded-pill px-3">
                                {{ $remain }} {{ Str::plural('remaining', $remain) }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-5 text-center mb-4 mb-md-0">
                            <div class="modern-donut position-relative d-inline-block">
                                <svg viewBox="0 0 140 140" class="donut-svg">
                                    <defs>
                                        <linearGradient id="donutGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" style="stop-color:var(--bs-primary);stop-opacity:1" />
                                            <stop offset="100%" style="stop-color:var(--bs-info);stop-opacity:1" />
                                        </linearGradient>
                                        <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                                            <feGaussianBlur stdDeviation="2" result="blur" />
                                            <feComposite in="SourceGraphic" in2="blur" operator="over" />
                                        </filter>
                                    </defs>
                                    <circle class="donut-track" cx="70" cy="70" r="58" />
                                    <circle class="donut-fill" cx="70" cy="70" r="58" 
                                        style="stroke-dasharray: {{ $dashFill }} {{ $dashGap }};" />
                                </svg>
                                <div class="donut-center-content">
                                    <div class="donut-percentage">{{ $pct }}%</div>
                                    <div class="donut-label">{{ d_trans('Used') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="usage-stats">
                                <div class="stat-row mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">{{ d_trans('Products Viewed ') }}</span>
                                        <span class="fw-bold fs-5 ms-2">{{ $used }}</span>
                                    </div>
                                    <div class="progress progress-modern" style="height: 8px;">
                                        <div class="progress-bar progress-bar-animated" role="progressbar" 
                                             style="width: {{ $pct }}%" 
                                             aria-valuenow="{{ $pct }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="stat-box bg-light rounded-3 p-3">
                                            <div class="text-muted small mb-1">{{ d_trans('Limit') }}</div>
                                            <div class="fw-bold fs-5">
                                                {{ $isUnlimited ? d_trans('∞') : $limit }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="stat-box bg-light rounded-3 p-3">
                                            <div class="text-muted small mb-1">{{ d_trans('Remaining') }}</div>
                                            <div class="fw-bold fs-5 {{ $remain === 0 && !$isUnlimited ? 'text-danger' : 'text-success' }}">
                                                {{ $isUnlimited ? d_trans('∞') : $remain }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if (!$isUnlimited && $used >= $limit && $limit > 0)
                                <div class="alert alert-modern alert-danger mt-3 mb-0 d-flex align-items-center">
                                    <i class="bi bi-exclamation-octagon-fill fs-5 me-3"></i>
                                    <div>
                                        <div class="fw-semibold">{{ d_trans("You've reached your plan limit") }}</div>
                                        <div class="small">{{ d_trans('Upgrade now to continue viewing products') }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plan Info Card -->
        <div class="col-xl-4">
            <div class="card h-100 border-0 shadow-sm plan-info-card">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold mb-0">{{ d_trans('Plan Details') }}</h5>
                </div>
                <div class="card-body p-4">
                    <div class="plan-highlight text-center mb-4 p-4 bg-primary bg-opacity-10 rounded-3">
                        <div class="plan-name fw-bold fs-4 text-white mb-1">
                            {{ $plan->trans->name ?? $plan->name }}
                        </div>
                        <div class="plan-interval text-muted text-capitalize">{{ $plan->interval }}</div>
                    </div>

                    @if (!empty($plan->custom_features))
                    <div class="features-list">
                        <h6 class="fw-semibold text-muted text-uppercase small tracking-wide mb-3">
                            {{ d_trans('Included Features') }}
                        </h6>
                        <ul class="list-unstyled mb-0">
                            @foreach ($plan->custom_features as $feature)
                            <li class="feature-item d-flex align-items-start gap-3 mb-3">
                                <div class="feature-check flex-shrink-0 mt-1">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                </div>
                                <span class="text-dark">{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-stars fs-1 mb-2 d-block text-muted opacity-25"></i>
                        <p class="mb-0">{{ d_trans('Basic plan features') }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Viewed Products Section -->
    <div class="card border-0 shadow-sm products-card">
        <div class="card-header bg-transparent border-bottom-0 pt-4 px-4 pb-0">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="fw-bold mb-1">{{ d_trans('Recently Viewed') }}</h5>
                    <p class="text-muted small mb-0">
                        {{ $used }} {{ Str::plural('product', $used) }} {{ d_trans('this period') }}
                    </p>
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
    /* Modern Base Styles */
    .page-header {
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    /* Subscription Banner */
    .subscription-banner .card {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-radius: 1rem;
    }
    
    .subscription-banner-bg {
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, var(--bs-primary-bg-subtle) 0%, transparent 70%);
        opacity: 0.5;
        pointer-events: none;
    }

    .subscription-icon {
        width: 56px;
        height: 56px;
    }

    .tracking-wide {
        letter-spacing: 0.05em;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .detail-item {
        min-width: 120px;
    }

    /* Modern Donut Chart */
    .modern-donut {
        width: 180px;
        height: 180px;
    }

    .donut-svg {
        width: 100%;
        height: 100%;
        transform: rotate(-90deg);
    }

    .donut-track {
        fill: none;
        stroke: #f1f5f9;
        stroke-width: 10;
    }

    .donut-fill {
        fill: none;
        stroke: url(#donutGradient);
        stroke-width: 10;
        stroke-linecap: round;
        transition: stroke-dasharray 1s cubic-bezier(0.4, 0, 0.2, 1);
        filter: url(#glow);
    }

    .donut-center-content {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .donut-percentage {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1;
        color: var(--bs-dark);
    }

    .donut-label {
        font-size: 0.875rem;
        color: var(--bs-secondary);
        margin-top: 0.25rem;
        font-weight: 500;
    }

    /* Progress Bar Modern */
    .progress-modern {
        background-color: #f1f5f9;
        border-radius: 100px;
        overflow: hidden;
    }

    .progress-bar-animated {
        background: linear-gradient(90deg, var(--bs-primary) 0%, var(--bs-info) 100%);
        border-radius: 100px;
        transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .progress-bar-animated::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,0.3),
            transparent
        );
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* Stat Boxes */
    .stat-box {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    /* Modern Alert */
    .alert-modern {
        border-radius: 0.75rem;
        border: none;
        background-color: rgba(var(--bs-danger-rgb), 0.08);
        color: var(--bs-danger);
    }

    .alert-modern.alert-danger i {
        color: var(--bs-danger);
    }

    /* Plan Info Card */
    .plan-info-card .plan-highlight {
        border: 2px dashed var(--bs-primary-border-subtle);
    }

    .feature-item {
        transition: transform 0.2s ease;
    }

    .feature-item:hover {
        transform: translateX(4px);
    }

    .feature-check {
        width: 20px;
        height: 20px;
    }

    /* Products Card */
    .products-card {
        border-radius: 1rem;
    }

    .empty-state {
        padding: 3rem 1rem;
    }

    /* Card Hover Effects */
    .usage-card, .plan-info-card, .products-card {
        transition: box-shadow 0.3s ease;
        border-radius: 1rem;
    }

    .usage-card:hover, .plan-info-card:hover {
        box-shadow: 0 10px 40px rgba(0,0,0,0.08) !important;
    }

    /* Responsive Adjustments */
    @media (max-width: 767.98px) {
        .modern-donut {
            width: 140px;
            height: 140px;
        }
        
        .donut-percentage {
            font-size: 1.5rem;
        }
        
        .subscription-banner-bg {
            display: none;
        }
    }

    /* Smooth animations for AOS */
    [data-aos] {
        pointer-events: none;
    }
    [data-aos].aos-animate {
        pointer-events: auto;
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