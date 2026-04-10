@if (!View::hasSection('hide_alerts'))
    @if (!$currentBusiness->hasDataCompleted())
        <div class="alert alert-warning">
            <div class="row g-3 row-cols-auto">
                <div class="col">
                    <i class="bi bi-info-circle fa-3x"></i>
                </div>
                <div class="col">
                    <h4 class="alert-heading">{{ d_trans('Complete your business details') }}</h4>
                    <p class="mb-2">
                        {{ d_trans('Complete your business details to help potential customers find you more easily and build trust in your brand.') }}
                    </p>
                    <a href="{{ route('business.settings.index') }}" class="btn btn-outline-warning px-4">
                        {{ d_trans('Complete Details') }}<i class="fas fa-arrow-right icon-rtl ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif
    @if (config('settings.kyc.actions.status') &&
            config('settings.business.actions.owners_kyc_required') &&
            !authBusinessOwner()->hasKycVerified())
        @include('themes.basic.partials.kyc-alerts', [
            'kyc_guard' => authBusinessOwner(),
            'kyc_url' => route('business.account.settings.kyc'),
        ])
    @endif
@endif
