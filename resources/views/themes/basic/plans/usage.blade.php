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
        $circumference = 2 * M_PI * 44;
        $dashFill = ($pct / 100) * $circumference;
        $dashGap = $circumference - $dashFill;

        $subscriptionStatus = null;
        if (!empty($subscription)) {
            if ($subscription->isExpired()) {
                $subscriptionStatus = d_trans('Expired');
            } elseif ($subscription->isAboutToExpire()) {
                $subscriptionStatus = d_trans('About to expire');
            } else {
                $subscriptionStatus = d_trans('Active');
            }
        }
    @endphp

    {{-- Subscription --}}

    @if ($subscription)
        <div class="alert alert-info mb-4 plan-subscription-alert" role="alert">
            {{ d_trans('You are currently on the') }}
            <strong>{{ $subscription->plan->trans->name ?? $subscription->plan->name }}</strong>
            {{ d_trans('plan') }}.
            <div class="mt-2">
                <p class="mb-1">{{ d_trans('Subscription Status') }}: <strong>{{ $subscriptionStatus }}</strong></p>
                <p class="mb-1">{{ d_trans('Started At') }}:
                    <strong>{{ $subscription->created_at?->format('M d, Y') }}</strong></p>
                @if ($subscription->expiry_at)
                    <p class="mb-1">{{ d_trans('Expiry At') }}:
                        <strong>{{ $subscription->expiry_at?->format('M d, Y') }}</strong></p>
                @endif
            </div>
        </div>

    @endif


    <div class="card mb-4">
        <div class="card-header fw-medium">{{ d_trans('Plan Overview') }}</div>
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-4">
                <div>
                    <div class="fw-semibold">{{ $plan->trans->name ?? $plan->name }}</div>
                    <div class="text-muted small">{{ ucfirst($plan->interval) }}</div>
                </div>
                <div class="d-flex align-items-center gap-3 usage-ring-wrap">
                    <div class="donut-chart" aria-label="{{ $pct }}%">
                        <svg viewBox="0 0 120 120" role="img" aria-hidden="true">
                            <circle class="donut-track" cx="60" cy="60" r="44"></circle>
                            <circle class="donut-fill" cx="60" cy="60" r="44"
                                style="stroke-dasharray: {{ $dashFill }} {{ $dashGap }};"></circle>
                        </svg>
                        <div class="donut-center">
                            <div class="donut-pct">{{ $pct }}%</div>
                            <div class="donut-label">{{ d_trans('Used') }}</div>
                        </div>
                    </div>
                    <div class="text-muted small">
                        @if ($isUnlimited)
                            {{ $used }} {{ Str::plural('product', $used) }} {{ d_trans('viewed') }}
                        @else
                            {{ $used }} / {{ $limit }} {{ Str::plural('product', $limit) }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar" role="progressbar" style="width: {{ $pct }}%;"
                        aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex flex-wrap gap-2 justify-content-between mt-2 text-muted small">
                    <span>{{ d_trans('Used') }}: {{ $used }}</span>
                    <span>{{ d_trans('Remaining') }}: {{ $isUnlimited ? d_trans('Unlimited') : $remain }}</span>
                    <span>{{ d_trans('Limit') }}: {{ $isUnlimited ? d_trans('Unlimited') : $limit }}</span>
                </div>
            </div>
            @if (!$isUnlimited && $used >= $limit && $limit > 0)
                <div class="alert alert-warning mt-3 mb-0" role="alert">
                    {{ d_trans("You've hit your plan limit.") }}
                    <a href="{{ route('plans') }}" class="alert-link">{{ d_trans('Upgrade your plan') }}</a>
                </div>
            @endif
        </div>
    </div>

    @if (!empty($plan->custom_features))
        <div class="card mb-4">
            <div class="card-header fw-medium">{{ d_trans('Plan Features') }}</div>
            <div class="card-body p-4">
                <div class="row g-2">
                    @foreach ($plan->custom_features as $feature)
                        <div class="col-12 col-md-6">{{ $feature }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header fw-medium">{{ d_trans('Viewed Products') }}</div>
        <div class="card-body p-4">
            <p class="text-muted mb-4">
                {{ $used }} {{ Str::plural('product', $used) }} {{ d_trans('viewed this period') }}
            </p>
            @if ($productViewed->isEmpty())
                <p class="text-muted mb-0">{{ d_trans('No products viewed yet.') }}</p>
            @else
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 row-cols-xxl-3 g-4 featured-luxe-grid">
                    @foreach ($productViewed as $product)
                        <div class="col" data-aos="fade-up" data-aos-duration="1000">
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
@endsection

@push('styles')
    <style>
        .donut-chart {
            position: relative;
            width: 96px;
            height: 96px;
            flex: 0 0 96px;
        }

        .donut-chart svg {
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
        }

        .donut-track {
            fill: none;
            stroke: #e9ecef;
            stroke-width: 12;
        }

        .donut-fill {
            fill: none;
            stroke: var(--bs-primary);
            stroke-width: 12;
            stroke-linecap: round;
            transition: stroke-dasharray 0.6s ease;
        }

        .donut-center {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }

        .donut-pct {
            font-weight: 700;
            font-size: 16px;
            line-height: 1;
        }

        .donut-label {
            font-size: 11px;
            color: #6c757d;
        }

        .plan-subscription-alert p {
            line-height: 1.35;
        }

        @media (max-width: 575.98px) {
            .usage-ring-wrap {
                width: 100%;
                justify-content: flex-start;
            }

            .card-body.p-4 {
                padding: 1rem !important;
            }
        }
    </style>
@endpush
