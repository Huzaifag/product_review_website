@extends('themes.basic.layouts.single')

@section('title', $plan->trans->name)
@section('header_title', $plan->trans->name)
@section('description', d_trans('Plan details and included features.'))
@section('breadcrumbs')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('plans') }}
@endsection
@section('breadcrumbs_schema')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::view('breadcrumbs::json-ld', 'plans') }}
@endsection
@section('container', 'container-xl')
@section('header_v1', true)

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
    .plan-detail-wrap {
        font-family: 'DM Sans', sans-serif;
        max-width: 780px;
        margin: 3rem auto 5rem;
        padding: 0 1rem;
    }

    /* ── Back link ── */
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 400;
        color: #999;
        text-decoration: none;
        margin-bottom: 2.5rem;
        transition: color 0.15s;
    }
    .back-link:hover { color: #111; text-decoration: none; }
    .back-link .bi { font-size: 13px; }

    /* ── Layout ── */
    .plan-detail-layout {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 24px;
        align-items: start;
    }

    /* ── Main card ── */
    .plan-main-card {
        background: #fff;
        border: 0.5px solid #e8e8e8;
        border-radius: 20px;
        overflow: hidden;
        transition: box-shadow 0.2s;
    }
    .plan-main-card.is-featured {
        border: 2px solid #111;
    }

    .plan-card-head {
        padding: 2.5rem 2.25rem 2rem;
        position: relative;
    }
    .plan-card-head::after {
        content: '';
        position: absolute;
        bottom: 0; left: 2.25rem; right: 2.25rem;
        height: 0.5px;
        background: #f0f0f0;
    }

    .featured-pill {
        display: inline-block;
        background: #111;
        color: #fff;
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        padding: 4px 14px;
        border-radius: 100px;
        margin-bottom: 1.25rem;
    }

    .plan-label {
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.17em;
        text-transform: uppercase;
        color: #bbb;
        margin-bottom: 0.35rem;
    }
    .plan-name {
        font-size: 28px;
        font-weight: 400;
        color: #111;
        margin-bottom: 1.5rem;
    }

    .plan-price-row {
        display: flex;
        align-items: baseline;
        gap: 4px;
    }
    .plan-amount {
        font-size: 64px;
        font-weight: 400;
        line-height: 1;
        color: #111;
    }
    .plan-period {
        font-size: 14px;
        color: #bbb;
        font-weight: 300;
        margin-left: 2px;
        align-self: flex-end;
        padding-bottom: 6px;
    }

    /* ── Features ── */
    .plan-card-body {
        padding: 2rem 2.25rem 2.25rem;
    }

    .features-heading {
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.17em;
        text-transform: uppercase;
        color: #bbb;
        margin-bottom: 1.25rem;
    }

    .features-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .feature-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 14px;
        color: #555;
        font-weight: 300;
        line-height: 1.4;
    }
    .feature-item .bi-check-circle-fill {
        font-size: 14px;
        color: #34a853;
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* ── Sidebar ── */
    .plan-sidebar {
        display: flex;
        flex-direction: column;
        gap: 14px;
        position: sticky;
        top: 1.5rem;
    }

    .sidebar-card {
        background: #fff;
        border: 0.5px solid #e8e8e8;
        border-radius: 16px;
        padding: 1.5rem;
    }

    .sidebar-section-label {
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.17em;
        text-transform: uppercase;
        color: #bbb;
        margin-bottom: 1rem;
    }

    /* ── Payment method ── */
    .payment-method-single {
        display: flex;
        align-items: center;
        gap: 10px;
        border: 0.5px solid #ebebeb;
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 13px;
        color: #555;
        font-weight: 400;
    }
    .payment-method-single .bi {
        font-size: 18px;
        color: #888;
        flex-shrink: 0;
    }

    /* ── Plan meta ── */
    .plan-meta-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .plan-meta-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
    }
    .plan-meta-key {
        color: #aaa;
        font-weight: 300;
    }
    .plan-meta-val {
        color: #111;
        font-weight: 400;
    }
    .plan-meta-divider {
        height: 0.5px;
        background: #f0f0f0;
        margin: 4px 0;
    }

    /* ── Action ── */
    .sidebar-action-card {
        background: #111;
        border-radius: 16px;
        padding: 1.5rem;
        text-align: center;
    }
    .sidebar-action-card p {
        font-size: 13px;
        color: rgba(255,255,255,0.5);
        font-weight: 300;
        margin-bottom: 1rem;
        line-height: 1.5;
    }
    .cta-btn-white {
        display: block;
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        background: #fff;
        color: #111;
        font-size: 14px;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        transition: opacity 0.18s;
    }
    .cta-btn-white:hover { opacity: 0.88; color: #111; text-decoration: none; }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .plan-detail-layout {
            grid-template-columns: 1fr;
        }
        .plan-sidebar { position: static; }
        .plan-amount { font-size: 48px; }
    }
</style>
@endpush

@section('content')
<div class="plan-detail-wrap">

    <a href="{{ route('plans') }}" class="back-link">
        <i class="bi bi-arrow-left"></i>
        {{ d_trans('All plans') }}
    </a>

    <div class="plan-detail-layout">

        {{-- Main card --}}
        <div class="plan-main-card {{ $plan->isFeatured() ? 'is-featured' : '' }}">
            <div class="plan-card-head">
                @if ($plan->isFeatured())
                    <div><span class="featured-pill">{{ d_trans('Most Popular') }}</span></div>
                @endif

                <p class="plan-label">{{ d_trans('Plan') }}</p>
                <h1 class="plan-name">{{ $plan->trans->name }}</h1>

                <div class="plan-price-row">
                    <span class="plan-amount">{{ $plan->getFormatPrice() }}</span>
                    <span class="plan-period">
                        /{{ $plan->isLifetime() ? strtolower(d_trans('lifetime')) : strtolower($plan->getIntervalName()) }}
                    </span>
                </div>
            </div>

            <div class="plan-card-body">
                <p class="features-heading">{{ d_trans('What\'s included') }}</p>
                <ul class="features-list">
                    <li class="feature-item">
                        <i class="bi bi-check-circle-fill"></i>
                        @if (is_null($plan->products_limit))
                            <span>{{ d_trans('Unlimited product views') }}</span>
                        @else
                            <span>{{ translate_choice(':count Product View|:count Product Views', $plan->products_limit, ['count' => $plan->products_limit]) }}</span>
                        @endif
                    </li>
                    @if (!empty($plan->custom_features))
                        @foreach ($plan->custom_features as $feature)
                            <li class="feature-item">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>{{ $feature }}</span>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="plan-sidebar">

            {{-- CTA — only for business owners --}}
            @if (authBusinessOwner())
                <div class="sidebar-action-card">
                    <p>{{ d_trans('You already have a subscription. Manage it anytime.') }}</p>
                    <a href="{{ route('business.subscription.plans.index') }}" class="cta-btn-white">
                        {{ d_trans('Manage subscription') }}
                    </a>
                </div>
            @elseif (authUser())
                <div class="sidebar-action-card">
                    <p>{{ d_trans('Ready to continue? Complete your payment securely with Stripe.') }}</p>
                    <a href="{{ route('payment.checkout', $plan->slug) }}" class="cta-btn-white">
                        {{ d_trans('Checkout with Stripe') }}
                    </a>
                </div>
            @else
                <div class="sidebar-action-card">
                    <p>{{ d_trans('Sign in to continue and pay securely with Stripe.') }}</p>
                    <a href="{{ route('login') }}" class="cta-btn-white">
                        {{ d_trans('Sign in to checkout') }}
                    </a>
                </div>
            @endif

            {{-- Plan meta --}}
            <div class="sidebar-card">
                <p class="sidebar-section-label">{{ d_trans('Plan details') }}</p>
                <div class="plan-meta-list">
                    <div class="plan-meta-row">
                        <span class="plan-meta-key">{{ d_trans('Billing') }}</span>
                        <span class="plan-meta-val">
                            {{ $plan->isLifetime() ? d_trans('One-time') : ucfirst(strtolower($plan->getIntervalName())) }}
                        </span>
                    </div>
                    <div class="plan-meta-divider"></div>
                    <div class="plan-meta-row">
                        <span class="plan-meta-key">{{ d_trans('Product views') }}</span>
                        <span class="plan-meta-val">
                            {{ is_null($plan->products_limit) ? d_trans('Unlimited') : number_format($plan->products_limit) }}
                        </span>
                    </div>
                    @if ($plan->isFeatured())
                        <div class="plan-meta-divider"></div>
                        <div class="plan-meta-row">
                            <span class="plan-meta-key">{{ d_trans('Status') }}</span>
                            <span class="plan-meta-val" style="color:#34a853;">{{ d_trans('Most popular') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Payment method --}}
            <div class="sidebar-card">
                <p class="sidebar-section-label">{{ d_trans('Accepted payments') }}</p>
                <div class="payment-method-single">
                    <i class="bi bi-credit-card"></i>
                    <span>{{ d_trans('Secure payment via Stripe') }}</span>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection