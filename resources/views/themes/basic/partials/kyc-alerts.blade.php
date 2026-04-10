@if ($kyc_guard->hasKycPending())
    <div class="alert alert-warning">
        <div class="row g-3 row-cols-auto">
            <div class="col">
                <i class="bi bi-hourglass-split fa-3x"></i>
            </div>
            <div class="col">
                <h4 class="alert-heading">{{ d_trans('KYC Verification Pending') }}</h4>
                <p class="mb-2">
                    {{ d_trans('Your KYC verification is currently pending. We are processing your information, and you will be notified once the verification is complete.') }}
                </p>
                <a href="{{ $kyc_url }}" class="btn btn-outline-warning">{{ d_trans('View KYC Status') }}<i
                        class="fa-solid fa-arrow-right icon-rtl ms-2"></i></a>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-danger">
        <div class="row g-3 row-cols-auto">
            <div class="col">
                <i class="bi bi-exclamation-triangle fa-3x"></i>
            </div>
            <div class="col">
                <h4 class="alert-heading">{{ d_trans('KYC Verification Required') }}</h4>
                <p class="mb-2">
                    {{ d_trans('Your KYC verification is required to continue using our platform. Please complete the verification process as soon as possible.') }}
                </p>
                <a href="{{ $kyc_url }}" class="btn btn-danger">{{ d_trans('Complete KYC') }}<i
                        class="fa-solid fa-arrow-right icon-rtl ms-2"></i></a>
            </div>
        </div>
    </div>
@endif
