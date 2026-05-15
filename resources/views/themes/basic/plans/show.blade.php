@extends('themes.basic.layouts.single')

@section('title', d_trans('Pricing plans'))
@section('header_title', d_trans('Pricing plans'))
@section('description', d_trans('Choose the plan that fits your business needs.'))
@section('breadcrumbs')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::render('plans') }}
@endsection
@section('breadcrumbs_schema')
    {{ \Diglactic\Breadcrumbs\Breadcrumbs::view('breadcrumbs::json-ld', 'plans') }}
@endsection
@section('container', 'container-custom')
@section('header_v1', true)

@push('styles')
    <style>
        .pricing-section {
            padding: 1rem 0 3rem;
        }


        /* Plan card */
        .plan-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            background: var(--bs-body-bg);
            border: 1px solid var(--bs-border-color);
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            position: relative;
        }

        .plan-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
            border-color: var(--bs-primary);
        }

        .plan-card.is-featured {
            border: 2px solid var(--bs-primary);
            box-shadow: 0 8px 32px rgba(var(--bs-primary-rgb), 0.18);
        }

        .plan-card.is-featured:hover {
            box-shadow: 0 16px 48px rgba(var(--bs-primary-rgb), 0.25);
        }

        /* Featured ribbon */
        .featured-ribbon {
            position: absolute;
            top: 14px;
            right: -28px;
            background: var(--bs-primary);
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 4px 36px;
            transform: rotate(45deg);
            transform-origin: center;
            white-space: nowrap;
            z-index: 2;
            pointer-events: none;
        }

        /* Card header */
        .plan-card-header {
            padding: 1.75rem 1.75rem 1.25rem;
            border-bottom: 1px solid var(--bs-border-color);
            background: var(--bs-secondary-bg);
        }

        .plan-card.is-featured .plan-card-header {
            background: linear-gradient(135deg, rgba(var(--bs-primary-rgb), 0.08), rgba(var(--bs-primary-rgb), 0.03));
        }

        .plan-name {
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: -0.01em;
            margin-bottom: 0.75rem;
            color: var(--bs-body-color);
        }

        .plan-price-wrap {
            display: flex;
            align-items: baseline;
            gap: 4px;
        }

        .plan-price {
            font-size: 2.4rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1;
            color: var(--bs-body-color);
        }

        .plan-price-interval {
            font-size: 0.85rem;
            color: var(--bs-secondary-color);
            font-weight: 500;
        }

        /* Card body */
        .plan-card-body {
            padding: 1.5rem 1.75rem;
            flex: 1;
        }

        .plan-features {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 0.7rem;
        }

        .plan-features li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.875rem;
            color: var(--bs-body-color);
            line-height: 1.4;
        }

        .plan-features li .feature-icon {
            flex-shrink: 0;
            margin-top: 1px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: rgba(var(--bs-success-rgb), 0.12);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .plan-features li .feature-icon i {
            font-size: 0.65rem;
            color: var(--bs-success);
        }

        /* Card footer */
        .plan-card-footer {
            padding: 1.25rem 1.75rem 1.75rem;
        }

        .plan-card-footer .btn {
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.65rem 1rem;
            letter-spacing: 0.01em;
            transition: all 0.18s ease;
        }

        /* Empty state */
        .pricing-empty {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--bs-secondary-color);
        }

        .pricing-empty i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: block;
            opacity: 0.4;
        }
    </style>
@endpush

@section('content')
    @php
        $plansCollection = collect($plans);
        $hasAnyPlan = $plansCollection->isNotEmpty();
    @endphp

    <div class="pricing-section">
        @if (!$hasAnyPlan)
            <div class="pricing-empty">
                <i class="bi bi-tags"></i>
                <p class="mb-0">{{ d_trans('No pricing plans are available right now.') }}</p>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3">
                @foreach ($plansCollection as $plan)
                    <div class="col">
                        <div class="plan-card {{ $plan->isFeatured() ? 'is-featured' : '' }}">

                            @if ($plan->isFeatured())
                                <div class="overflow-hidden position-absolute top-0 end-0" style="width:80px;height:80px;">
                                    <span class="featured-ribbon">{{ d_trans('Featured') }}</span>
                                </div>
                            @endif

                            {{-- Header --}}
                            <div class="plan-card-header">
                                <div class="plan-name">{{ d_trans($plan->name) }}</div>
                                <div class="plan-price-wrap">
                                    <span class="plan-price">{{ $plan->getFormatPrice() }}</span>
                                    @if (!$plan->isLifetime())
                                        <span class="plan-price-interval">/{{ strtolower(d_trans($plan->getIntervalName())) }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Features --}}
                            <div class="plan-card-body">
                                <ul class="plan-features">
                                    <li>
                                        <span class="feature-icon">
                                            <i class="bi bi-check-lg"></i>
                                        </span>
                                        <span>
                                            @if (is_null($plan->products_limit))
                                                {{ d_trans('Unlimited product views') }}
                                            @else
                                                {{ d_trans(':count Product View|:count Product Views', ['count' => $plan->products_limit]) }}
                                            @endif
                                        </span>
                                    </li>

                                    @if (!empty($plan->custom_features))
                                        @foreach ($plan->custom_features as $feature)
                                            <li>
                                                <span class="feature-icon">
                                                    <i class="bi bi-check-lg"></i>
                                                </span>
                                                <span>{{ d_trans($feature) }}</span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            {{-- CTA --}}
                            <div class="plan-card-footer">
                                @if ($plan->price > 0)
                                    {{-- if user has not already subscribed to this plan, show the button --}}

                                    @php
                                        $userPlanIds = auth()->check()
                                            ? (optional(auth()->user()->currentPlans())->pluck('id') ?? collect())
                                            : collect();
                                    @endphp
                                    @if (!auth()->check() || !$userPlanIds->contains($plan->id))
                                        <a href="{{ route('plans.details', $plan->slug) }}"
                                            class="{{ $plan->isFeatured() ? 'btn btn-primary' : 'btn btn-outline-primary' }} w-100">
                                            {{ d_trans('Get started') }}
                                        </a>
                                    @else
                                        <a href="{{ route('user.profile', auth()->user()->username) }}"
                                            class="btn btn-success w-100">
                                            {{ d_trans('You are subscribed') }}
                                        </a>
                                    @endif
                                @endif
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
