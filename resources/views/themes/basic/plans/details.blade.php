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
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --premium-red: rgb(198, 40, 40);
            --premium-red-dark: #8f1717;
            --premium-red-soft: rgba(198, 40, 40, 0.08);
            --premium-red-soft-2: rgba(198, 40, 40, 0.12);
            --premium-red-border: rgba(198, 40, 40, 0.18);
            --premium-red-glow: rgba(198, 40, 40, 0.18);

            --premium-bg: #fff8f8;
            --premium-bg-2: #ffffff;
            --premium-card: rgba(255, 255, 255, 0.86);
            --premium-border: rgba(17, 24, 39, 0.08);

            --premium-text: #171717;
            --premium-muted: #6b7280;
            --premium-soft: #9ca3af;
            --premium-green: #16a34a;
        }



        .plan-detail-wrap {
            /* font-family: 'Inter', sans-serif; */
            max-width: 1180px;
            margin: 3rem auto 6rem;
            padding: 0 1rem;
            position: relative;
        }

        .plan-detail-wrap::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(198, 40, 40, 0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(198, 40, 40, 0.035) 1px, transparent 1px);
            background-size: 46px 46px;
            mask-image: linear-gradient(to bottom, black, transparent 75%);
            opacity: 0.8;
            z-index: 0;
        }

        .section {
            padding-top: 0px !important;
            padding-bottom: 0px !important;
            overflow: hidden;
        }

        .plan-detail-wrap>* {
            position: relative;
            z-index: 1;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--premium-muted);
            text-decoration: none;
            margin-bottom: 2rem;
            font-size: 14px;
            font-weight: 600;
            transition: 0.25s ease;
        }

        .back-link i {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: #fff;
            color: var(--premium-red);
            border: 1px solid var(--premium-red-border);
            box-shadow: 0 10px 28px rgba(198, 40, 40, 0.08);
        }

        .back-link:hover {
            color: var(--premium-red);
            text-decoration: none;
            transform: translateX(-2px);
        }

        .plan-hero {
            text-align: center;
            margin-bottom: 2.25rem;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid var(--premium-red-border);
            color: var(--premium-red);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            margin-bottom: 1rem;
            box-shadow: 0 16px 40px rgba(198, 40, 40, 0.1);
        }

        .hero-title {
            /* font-family: 'DM Serif Display', serif; */
            font-size: clamp(42px, 6vw, 78px);
            line-height: 0.95;
            color: var(--premium-text);
            margin-bottom: 1rem;
            letter-spacing: -0.04em;
        }

        .hero-subtitle {
            color: var(--premium-muted);
            font-size: 16px;
            line-height: 1.7;
            max-width: 650px;
            margin: 0 auto;
        }

        .plan-detail-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 370px;
            gap: 24px;
            align-items: start;
        }

        .plan-main-card,
        .sidebar-card,
        .sidebar-action-card {
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }

        .plan-main-card {
            position: relative;
            overflow: hidden;
            border-radius: 34px;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, 0.96), rgba(255, 248, 248, 0.92));
            border: 1px solid var(--premium-red-border);
            box-shadow:
                0 34px 90px rgba(198, 40, 40, 0.13),
                0 18px 45px rgba(17, 24, 39, 0.07),
                inset 0 1px 0 rgba(255, 255, 255, 0.95);
        }

        .plan-main-card::before {
            content: "";
            position: absolute;
            top: -170px;
            right: -170px;
            width: 380px;
            height: 380px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(198, 40, 40, 0.16), transparent 70%);
        }

        .plan-main-card::after {
            content: "";
            position: absolute;
            inset: 1px;
            border-radius: 33px;
            border: 1px solid rgba(255, 255, 255, 0.85);
            pointer-events: none;
        }

        .plan-main-card.is-featured {
            border-color: rgba(198, 40, 40, 0.36);
            box-shadow:
                0 38px 110px rgba(198, 40, 40, 0.18),
                0 0 0 1px rgba(198, 40, 40, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.95);
        }

        .plan-card-head {
            position: relative;
            padding: 3rem 3rem 2.4rem;
            z-index: 1;
        }

        .featured-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: linear-gradient(135deg, var(--premium-red), var(--premium-red-dark));
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            padding: 8px 14px;
            border-radius: 999px;
            margin-bottom: 1.4rem;
            box-shadow: 0 14px 34px rgba(198, 40, 40, 0.24);
        }

        .featured-pill::before {
            content: "✦";
            font-size: 12px;
        }

        .plan-label,
        .features-heading,
        .sidebar-section-label {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--premium-red);
            margin-bottom: 0.75rem;
        }

        .plan-name {
            /* font-family: 'DM Serif Display', serif; */
            font-size: clamp(40px, 5vw, 66px);
            line-height: 0.95;
            color: var(--premium-text);
            margin-bottom: 1.6rem;
            letter-spacing: -0.04em;
        }

        .plan-price-row {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            margin-bottom: 1.5rem;
        }

        .plan-amount {
            font-size: clamp(56px, 7vw, 92px);
            font-weight: 800;
            line-height: 0.9;
            letter-spacing: -0.08em;
            color: var(--premium-red);
            text-shadow: 0 18px 42px rgba(198, 40, 40, 0.13);
        }

        .plan-period {
            font-size: 15px;
            color: var(--premium-muted);
            font-weight: 600;
            padding-bottom: 9px;
        }

        .premium-mini-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 1.4rem;
        }

        .premium-mini-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 12px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid var(--premium-red-border);
            color: #4b5563;
            font-size: 12px;
            font-weight: 700;
            box-shadow: 0 10px 24px rgba(198, 40, 40, 0.07);
        }

        .premium-mini-badge i {
            color: var(--premium-red);
        }

        .plan-card-body {
            position: relative;
            z-index: 1;
            padding: 0 3rem 3rem;
        }

        .features-panel {
            border-radius: 26px;
            padding: 1.6rem;
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(198, 40, 40, 0.12);
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.95),
                0 18px 40px rgba(198, 40, 40, 0.07);
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 12px;
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px;
            border-radius: 18px;
            background: #fff;
            border: 1px solid rgba(198, 40, 40, 0.10);
            color: #4b5563;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.55;
            transition: 0.25s ease;
            box-shadow: 0 10px 24px rgba(17, 24, 39, 0.04);
        }

        .feature-item:hover {
            background: #fffafa;
            transform: translateY(-2px);
            border-color: var(--premium-red-border);
            box-shadow: 0 16px 34px rgba(198, 40, 40, 0.09);
        }

        .feature-icon {
            width: 25px;
            height: 25px;
            min-width: 25px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: var(--premium-red-soft);
            color: var(--premium-red);
            margin-top: -1px;
        }

        .feature-icon i {
            font-size: 13px;
        }

        .plan-sidebar {
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: sticky;
            top: 1.5rem;
        }

        .sidebar-action-card {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            padding: 1.6rem;
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.28), transparent 38%),
                linear-gradient(135deg, var(--premium-red), var(--premium-red-dark));
            border: 1px solid rgba(198, 40, 40, 0.28);
            box-shadow:
                0 26px 70px rgba(198, 40, 40, 0.22),
                inset 0 1px 0 rgba(255, 255, 255, 0.24);
        }

        .sidebar-action-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, 0.18), transparent 35%),
                radial-gradient(circle at bottom left, rgba(255, 255, 255, 0.12), transparent 42%);
            pointer-events: none;
        }

        .sidebar-action-card>* {
            position: relative;
            z-index: 1;
        }

        .action-title {
            color: #fff;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 0.5rem;
        }

        .sidebar-action-card p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.82);
            font-weight: 500;
            margin-bottom: 1.2rem;
            line-height: 1.65;
        }

        .cta-btn-white {
            position: relative;
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 15px 18px;
            border-radius: 16px;
            background: #fff;
            color: var(--premium-red);
            font-size: 14px;
            font-weight: 800;
            text-align: center;
            text-decoration: none;
            box-shadow:
                0 16px 45px rgba(0, 0, 0, 0.16),
                inset 0 1px 0 rgba(255, 255, 255, 0.95);
            transition: 0.25s ease;
        }

        .cta-btn-white:hover {
            color: var(--premium-red-dark);
            text-decoration: none;
            transform: translateY(-2px);
            box-shadow:
                0 22px 56px rgba(0, 0, 0, 0.18),
                inset 0 1px 0 rgba(255, 255, 255, 0.95);
        }

        .sidebar-card {
            border-radius: 26px;
            padding: 1.45rem;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(198, 40, 40, 0.12);
            box-shadow:
                0 22px 60px rgba(198, 40, 40, 0.09),
                0 12px 34px rgba(17, 24, 39, 0.04),
                inset 0 1px 0 rgba(255, 255, 255, 0.95);
        }

        .plan-meta-list {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .plan-meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 13px 0;
            font-size: 14px;
        }

        .plan-meta-key {
            color: var(--premium-muted);
            font-weight: 600;
        }

        .plan-meta-val {
            color: var(--premium-text);
            font-weight: 800;
            text-align: right;
        }

        .plan-meta-divider {
            height: 1px;
            background: rgba(198, 40, 40, 0.10);
        }

        .payment-method-single {
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid rgba(198, 40, 40, 0.12);
            border-radius: 18px;
            padding: 14px;
            font-size: 14px;
            color: #4b5563;
            font-weight: 700;
            background: #fff;
            box-shadow: 0 10px 26px rgba(17, 24, 39, 0.04);
        }

        .payment-method-single i {
            width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: var(--premium-red-soft);
            color: var(--premium-red);
            font-size: 18px;
            flex-shrink: 0;
        }

        .security-list {
            display: grid;
            gap: 10px;
            margin-top: 12px;
        }

        .security-item {
            display: flex;
            align-items: center;
            gap: 9px;
            color: var(--premium-muted);
            font-size: 13px;
            font-weight: 600;
        }

        .security-item i {
            color: var(--premium-green);
        }

        .premium-status {
            color: var(--premium-red) !important;
        }

        @media (max-width: 991px) {
            .plan-detail-layout {
                grid-template-columns: 1fr;
            }

            .plan-sidebar {
                position: static;
            }
        }

        @media (max-width: 576px) {
            .plan-detail-wrap {
                margin: 2rem auto 4rem;
                padding: 0 0.85rem;
            }

            .hero-title {
                font-size: 42px;
            }

            .hero-subtitle {
                font-size: 14px;
            }

            .plan-card-head,
            .plan-card-body {
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }

            .plan-card-head {
                padding-top: 2rem;
            }

            .plan-card-body {
                padding-bottom: 1.25rem;
            }

            .plan-main-card,
            .sidebar-card,
            .sidebar-action-card {
                border-radius: 24px;
            }

            .features-panel {
                padding: 1rem;
                border-radius: 20px;
            }

            .plan-price-row {
                align-items: flex-start;
                flex-direction: column;
                gap: 4px;
            }

            .plan-period {
                padding-bottom: 0;
            }
        }
    </style>
@endpush

@section('content')
    <div class="plan-detail-wrap">

        <a href="{{ route('plans') }}" class="back-link">
            <i class="bi bi-arrow-left"></i>
            {{ d_trans('All plans') }}
        </a>

        <div class="plan-hero">
            {{-- <div class="hero-eyebrow">
                <i class="bi bi-stars"></i>
                {{ d_trans('Premium Membership') }}
            </div>

            <h1 class="hero-title">{{ $plan->trans->name }}</h1>

            <p class="hero-subtitle">
                {{ d_trans('Unlock more product insights with a secure, premium subscription designed for serious buyers and businesses.') }}
            </p> --}}
        </div>

        <div class="plan-detail-layout">

            {{-- Main card --}}
            <div class="plan-main-card {{ $plan->isFeatured() ? 'is-featured' : '' }}">
                <div class="plan-card-head">
                    @if ($plan->isFeatured())
                        <div>
                            <span class="featured-pill">{{ d_trans('Most Popular') }}</span>
                        </div>
                    @endif

                    <p class="plan-label">{{ d_trans('Selected Plan') }}</p>

                    <h2 class="plan-name">{{ $plan->trans->name }}</h2>

                    <div class="plan-price-row">
                        <span class="plan-amount">{{ $plan->getFormatPrice() }}</span>
                        <span class="plan-period">
                            /{{ $plan->isLifetime() ? strtolower(d_trans('lifetime')) : strtolower($plan->getIntervalName()) }}
                        </span>
                    </div>

                    <div class="premium-mini-row">
                        <span class="premium-mini-badge">
                            <i class="bi bi-shield-check"></i>
                            {{ d_trans('Secure checkout') }}
                        </span>

                        <span class="premium-mini-badge">
                            <i class="bi bi-lightning-charge"></i>
                            {{ d_trans('Instant access') }}
                        </span>

                        <span class="premium-mini-badge">
                            <i class="bi bi-credit-card"></i>
                            {{ d_trans('Stripe powered') }}
                        </span>
                    </div>
                </div>

                <div class="plan-card-body">
                    <div class="features-panel">
                        <p class="features-heading">{{ d_trans('What’s included') }}</p>

                        <ul class="features-list">
                            <li class="feature-item">
                                <span class="feature-icon">
                                    <i class="bi bi-check-lg"></i>
                                </span>

                                @if (is_null($plan->products_limit))
                                    <span>{{ d_trans('Unlimited product views') }}</span>
                                @else
                                    <span>{{ translate_choice(':count Product View|:count Product Views', $plan->products_limit, ['count' => $plan->products_limit]) }}</span>
                                @endif
                            </li>

                            @if (!empty($plan->custom_features))
                                @foreach ($plan->custom_features as $feature)
                                    <li class="feature-item">
                                        <span class="feature-icon">
                                            <i class="bi bi-check-lg"></i>
                                        </span>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            @endif

                            <li class="feature-item">
                                <span class="feature-icon">
                                    <i class="bi bi-check-lg"></i>
                                </span>
                                <span>{{ d_trans('Premium access activated immediately after successful payment.') }}</span>
                            </li>

                            <li class="feature-item">
                                <span class="feature-icon">
                                    <i class="bi bi-check-lg"></i>
                                </span>
                                <span>{{ d_trans('Designed for faster product research and better buying decisions.') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="plan-sidebar">

                {{-- CTA --}}
                @if (authBusinessOwner())
                    <div class="sidebar-action-card">
                        <h3 class="action-title">{{ d_trans('Subscription active') }}</h3>

                        <p>{{ d_trans('You already have a subscription. Manage your plan and billing anytime from your account.') }}
                        </p>

                        <a href="{{ route('business.subscription.plans.index') }}" class="cta-btn-white">
                            {{ d_trans('Manage subscription') }}
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                @elseif (authUser())
                    <div class="sidebar-action-card">
                        <h3 class="action-title">{{ d_trans('Ready to upgrade?') }}</h3>

                        <p>{{ d_trans('Complete your payment securely with Stripe and unlock your plan instantly.') }}</p>

                        <a href="{{ route('payment.checkout', $plan->slug) }}" class="cta-btn-white">
                            {{ d_trans('Checkout with Stripe') }}
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                @else
                    <div class="sidebar-action-card">
                        <h3 class="action-title">{{ d_trans('Start securely') }}</h3>

                        <p>{{ d_trans('Sign in to continue and complete your payment securely with Stripe.') }}</p>

                        <a href="{{ route('login') }}" class="cta-btn-white">
                            {{ d_trans('Sign in to checkout') }}
                            <i class="bi bi-arrow-right"></i>
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

                        <div class="plan-meta-divider"></div>

                        <div class="plan-meta-row">
                            <span class="plan-meta-key">{{ d_trans('Access') }}</span>
                            <span class="plan-meta-val">{{ d_trans('Instant') }}</span>
                        </div>

                        @if ($plan->isFeatured())
                            <div class="plan-meta-divider"></div>

                            <div class="plan-meta-row">
                                <span class="plan-meta-key">{{ d_trans('Status') }}</span>
                                <span class="plan-meta-val premium-status">{{ d_trans('Most popular') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Payment method --}}
                <div class="sidebar-card">
                    <p class="sidebar-section-label">{{ d_trans('Accepted payments') }}</p>

                    <div class="payment-method-single">
                        <i class="bi bi-credit-card-2-front"></i>
                        <span>{{ d_trans('Secure payment via Stripe') }}</span>
                    </div>

                    <div class="security-list">
                        <div class="security-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ d_trans('Encrypted payment processing') }}</span>
                        </div>

                        <div class="security-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ d_trans('No card details stored on our server') }}</span>
                        </div>

                        <div class="security-item">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ d_trans('Fast and secure checkout') }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
