<div class="plan box {{ $plan->isFeatured() ? 'featured' : '' }} h-100">
    @if ($plan->isFeatured())
        <div class="plan-badge">
            {{ d_trans('Featured') }}
        </div>
    @endif
    <div class="plan-header">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
            <h4 class="plan-title">{{ $plan->trans->name }}</h4>
        </div>
        <div class="plan-price d-flex align-items-end">
            <p class="mb-0">{{ $plan->getFormatPrice() }}</p>
            <span>/{{ strtolower($plan->getIntervalName()) }}</span>
        </div>
    </div>
    <div class="plan-body">
        <div class="row row-cols-1 g-3">
            <div class="col">
                <div class="feat-item d-flex align-items-center justify-content-between gap-2 text-muted">
                    @if ($plan->businesses)
                        <span>
                            {{ translate_choice(':count Business|:count Businesses', $plan->businesses, ['count' => $plan->businesses]) }}</span>
                    @else
                        <span>{{ d_trans('Unlimited businesses') }}</span>
                    @endif
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
            @if ($plan->categories)
                <div class="col">
                    <div class="feat-item d-flex align-items-center justify-content-between gap-2 text-muted">
                        <span>{{ d_trans('Category management') }}</span>
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            @endif
            @if ($plan->employees)
                <div class="col">
                    <div class="feat-item d-flex align-items-center justify-content-between gap-2 text-muted">
                        <span>{{ d_trans('Employee management') }}</span>
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            @endif
            @if (!empty($plan->custom_features))
                @foreach ($plan->custom_features as $feature)
                    <div class="col">
                        <div class="feat-item d-flex align-items-center justify-content-between gap-2 text-muted">
                            <span>{{ $feature }}</span>
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="plan-actions">
        <div class="row row-cols-1 g-3">
            <div class="col">
                @php
                    $authBusinessOwner = authBusinessOwner();
                    $subscription = $authBusinessOwner->subscription;
                @endphp
                <form action="{{ route('business.subscription.plans.subscribe', $plan->id) }}" method="POST">
                    @csrf
                    @if ($authBusinessOwner->subscribedToPlan($plan->id))
                        @php
                            $subscriptionPlan = $subscription->plan;
                        @endphp
                        @if ($subscription->isAboutToExpire())
                            <button
                                class="btn {{ $plan->isFeatured() ? 'btn-warning' : 'btn-outline-warning' }} btn-lg action-confirm w-100">
                                {{ d_trans('Renew') }}
                            </button>
                        @elseif($subscription->isExpired())
                            <button
                                class="btn {{ $plan->isFeatured() ? 'btn-danger' : 'btn-outline-danger' }} btn-lg action-confirm w-100">
                                {{ d_trans('Renew') }}
                            </button>
                        @else
                            <button
                                class="btn {{ $plan->isFeatured() ? 'btn-primary' : 'btn-outline-primary' }} btn-lg w-100"
                                disabled>
                                {{ d_trans('Subscribed') }}
                            </button>
                        @endif
                    @elseif ($subscription)
                        @php
                            $currentPrice = $subscription->plan->price;
                            $selectedPrice = $plan->price;
                        @endphp
                        @if ($selectedPrice > $currentPrice)
                            <button
                                class="btn {{ $plan->isFeatured() ? 'btn-success' : 'btn-outline-success' }} btn-lg action-confirm w-100">
                                {{ d_trans('Upgrade') }}
                            </button>
                        @elseif ($selectedPrice < $currentPrice)
                            <button
                                class="btn {{ $plan->isFeatured() ? 'btn-primary' : 'btn-outline-primary' }} btn-lg action-confirm w-100">
                                {{ d_trans('Downgrade') }}
                            </button>
                        @else
                            <button
                                class="btn {{ $plan->isFeatured() ? 'btn-primary' : 'btn-outline-primary' }} btn-lg action-confirm w-100">
                                {{ d_trans('Switch Plan') }}
                            </button>
                        @endif
                    @else
                        <button
                            class="btn {{ $plan->isFeatured() ? 'btn-primary' : 'btn-outline-primary' }} btn-lg action-confirm w-100">
                            {{ d_trans('Start Now') }}
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
