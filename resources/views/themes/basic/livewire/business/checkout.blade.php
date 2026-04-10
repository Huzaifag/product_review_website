<div>
    <div class="row g-3">
        <div class="col-12 col-xl-8 order-2 order-xl-1">
            <form id="checkoutForm" action="{{ route('business.checkout.process', hash_encode($trx->id)) }}"
                method="POST">
                @csrf
                <div class="box cp-4 mb-3">
                    <h5 class="fs-5 mb-4">{{ d_trans('Payments Method') }}</h5>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-3">
                        @foreach ($paymentGateways as $paymentGateway)
                            <div class="col">
                                <div class="payment-method">
                                    <div class="payment-img">
                                        <img src="{{ $paymentGateway->getLogoLink() }}"
                                            alt="{{ $paymentGateway->trans->name }}">
                                    </div>
                                    <input class="form-check-input" type="radio" name="payment_method"
                                        wire:model="payment_method" wire:change="updateSummary"
                                        value="{{ $paymentGateway->alias }}" id="{{ $paymentGateway->alias }}"
                                        @checked($payment_method == $paymentGateway->alias)>
                                    <label class="form-check-label" for="{{ $paymentGateway->alias }}"></label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="box cp-4">
                    <h5 class="mb-4">{{ d_trans('Billing address') }}</h5>
                    <div class="row mb-2 g-3">
                        <div class="col-lg-6">
                            <label class="form-label">{{ d_trans('First Name') }}</label>
                            <input type="text" class="form-control form-control-md"
                                value="{{ authBusinessOwner()->firstname }}" disabled>
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">{{ d_trans('Last Name') }}</label>
                            <input type="text" class="form-control form-control-md"
                                value="{{ authBusinessOwner()->lastname }}" disabled>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ d_trans('Address line 1') }}</label>
                            <input type="text" wire:model="address_line_1" name="address_line_1"
                                class="form-control form-control-md" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ d_trans('Address line 2') }}</label>
                            <input type="text" wire:model="address_line_2" name="address_line_2"
                                class="form-control form-control-md">
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">{{ d_trans('City') }}</label>
                                <input type="text" wire:model="city" name="city"
                                    class="form-control form-control-md" required>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">{{ d_trans('State') }}</label>
                            <input type="text" wire:model="state" name="state" class="form-control form-control-md"
                                required>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">{{ d_trans('Postal code') }}</label>
                            <input type="text" wire:model="zip" name="zip" class="form-control form-control-md"
                                required>
                        </div>
                        <div class="col-lg-12">
                            <label class="form-label">{{ d_trans('Country') }}</label>
                            <select wire:model="country" wire:change="updateSummary" name="country"
                                class="form-select form-select-md" required>
                                <option value="">--</option>
                                @foreach (countries() as $countryCode => $countryName)
                                    <option value="{{ $countryCode }}" @selected($countryCode == $country)>
                                        {{ $countryName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <div class="d-block d-xl-none mt-4">
                <div class="box cp-4 mt-4">
                    <div class="protect">
                        <i class="fas fa-shield-alt text-success"></i>
                        <div>
                            <span class="h5 mb-2 d-block"> {{ d_trans('SSL Secure Payment') }}</span>
                            <p class="text-muted mb-0">
                                {{ d_trans('Your information is protected by 256-bit SSL encryption') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-block d-xl-none mt-3">
                <button form="checkoutForm" class="btn btn-primary btn-md w-100">{{ d_trans('Continue') }}</button>
            </div>
        </div>
        <div class="col-12 col-xl-4 order-1 order-xl-2">
            <div class="box cp-4">
                <h5 class="mb-2">{{ d_trans('Order Summary') }}</h5>
                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                    <span>{{ d_trans(':plan_name (:plan_interval)', [
                        'plan_name' => $trx->plan->trans->name,
                        'plan_interval' => $trx->plan->getIntervalName(),
                    ]) }}</span>
                    <h6 class="mb-0">{{ getAmount($trx->amount) }}</h6>
                </div>
                @if ($summary['gateway'] || $summary['tax'])
                    <div class="border-bottom pb-3">
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span>{{ d_trans('SubTotal') }}</span>
                            <h6 class="mb-0">{{ getAmount($trx->amount) }}</h6>
                        </div>
                        @if ($summary['tax'])
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span>{{ d_trans(':tax_name (:tax_rate%)', [
                                    'tax_name' => $summary['tax']['name'],
                                    'tax_rate' => $summary['tax']['rate'],
                                ]) }}</span>
                                <h6 class="mb-0">{{ $summary['tax']['amount'] }}</h6>
                            </div>
                        @endif
                        @if ($summary['gateway'])
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span>{{ d_trans(':payment_gateway Fees (:percentage%)', [
                                    'payment_gateway' => $summary['gateway']['name'],
                                    'percentage' => $summary['gateway']['fees'],
                                ]) }}</span>
                                <h6 class="mb-0">{{ $summary['gateway']['amount'] }}</h6>
                            </div>
                        @endif
                    </div>
                @endif
                <div class="d-flex justify-content-between align-items-center pt-3">
                    <strong class="fs-5">{{ d_trans('Total') }}</strong>
                    <h6 class="mb-0 fs-5"><strong>{{ getAmount($summary['total']) }}</strong></h6>
                </div>
            </div>
            <div class="box cp-4 mt-3 d-none d-xl-flex">
                <div class="protect">
                    <i class="fas fa-shield-alt text-success"></i>
                    <div>
                        <span class="h5 mb-2 d-block"> {{ d_trans('SSL Secure Payment') }}</span>
                        <p class="text-muted mb-0">
                            {{ d_trans('Your information is protected by 256-bit SSL encryption') }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-3 d-none d-xl-block">
                <button form="checkoutForm" class="btn btn-primary btn-md w-100">{{ d_trans('Continue') }}</button>
            </div>
        </div>
    </div>
</div>
