<div class="row g-3  mb-4">
    @if (licenseType(2) && config('settings.subscription.status') && $owner->isSubscribed())
        @php
            $plan = $owner->subscription->plan;
        @endphp
        <div class="col-12 col-lg">
            <div class="vironeer-counter-card bg-c22">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-gem"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Subscription') }}</p>
                    <p class="vironeer-counter-card-number">
                        <a href="{{ route('admin.plans.edit', $plan->id) }}" class="text-white">
                            {{ d_trans(':plan_name (:plan_interval)', [
                                'plan_name' => $plan->trans->name,
                                'plan_interval' => $plan->getIntervalName(),
                            ]) }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @endif
    <div class="col-12 col-lg">
        <div class="vironeer-counter-card bg-c19">
            <div class="vironeer-counter-card-icon">
                <i class="fa-solid fa-briefcase"></i>
            </div>
            <div class="vironeer-counter-card-meta">
                <p class="vironeer-counter-card-title">{{ d_trans('Total Businesses') }}</p>
                <p class="vironeer-counter-card-number">{{ $counters['total_businesses'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg">
        <div class="vironeer-counter-card bg-c18">
            <div class="vironeer-counter-card-icon">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div class="vironeer-counter-card-meta">
                <p class="vironeer-counter-card-title">{{ d_trans('Businesses employed at') }}</p>
                <p class="vironeer-counter-card-number">{{ $counters['businesses_employed_at'] }}</p>
            </div>
        </div>
    </div>
</div>
<div class="card mb-4">
    <div class="card-header">{{ d_trans('Quick Actions') }}</div>
    <div class="card-body p-4">
        <div class="row g-3">
            @if ($owner->isActive())
                <div class="col-12 col-lg-3">
                    <a class="btn btn-outline-primary btn-md w-100"
                        href="{{ route('admin.members.business-owners.login', $owner->id) }}" target="_blank">
                        <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>{{ d_trans('Login as Business') }}
                    </a>
                </div>
            @endif
            <div class="col-12 col-lg-3">
                <a class="btn btn-outline-secondary btn-md w-100"
                    href="{{ route('admin.kyc-verifications.index', ['owner' => $owner->id]) }}">
                    <i class="far fa-id-card me-2"></i>{{ d_trans('KYC Verifications') }}
                </a>
            </div>
            <div class="col-12 col-lg-3">
                <a class="btn btn-outline-secondary btn-md w-100"
                    href="{{ route('admin.businesses.index', ['owner' => $owner->id]) }}">
                    <i class="fa-solid fa-briefcase me-2"></i>{{ d_trans('Businesses') }}
                </a>
            </div>
            <div class="col-12 col-lg-3">
                <a class="btn btn-outline-secondary btn-md w-100"
                    href="{{ route('admin.businesses.index', ['employee' => $owner->id]) }}">
                    <i class="fa-solid fa-user-tie me-2"></i>{{ d_trans('Employed At') }}
                </a>
            </div>
            @if (licenseType(2) && config('settings.subscription.status') && $owner->isSubscribed())
                <div class="col-12 col-lg-6">
                    <a class="btn btn-outline-secondary btn-md w-100"
                        href="{{ route('admin.subscriptions.show', $owner->subscription->id) }}">
                        <i class="far fa-gem me-2"></i>{{ d_trans('Subscription') }}
                    </a>
                </div>
                <div class="col-12 col-lg-6">
                    <a class="btn btn-outline-secondary btn-md w-100"
                        href="{{ route('admin.transactions.index', ['owner' => $owner->id]) }}">
                        <i class="fas fa-receipt me-2"></i>{{ d_trans('Transactions') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@push('styles_libs')
    <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/counter-cards.min.css') }}">
@endpush
@push('scripts_libs')
    <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
@endpush
