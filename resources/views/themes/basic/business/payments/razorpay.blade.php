@extends('themes.basic.business.layouts.app')
@section('container', 'dashboard-container-sm')
@section('title', d_trans('Checkout'))
@section('header_title', d_trans('Complete the payment'))
@section('breadcrumbs', Breadcrumbs::render('business.checkout', $trx))
@section('content')
    <div class="card">
        <div class="card-header fw-medium fs-5">{{ d_trans('Payment details') }}</div>
        <ul class="list-group list-group-flush">
            @if ($trx->hasTax() || $trx->hasFees())
                <li class="list-group-item d-flex align-items-center justify-content-between p-3">
                    <h6 class="mb-0">{{ d_trans('SubTotal') }}</h6>
                    <span>{{ getAmount($trx->amount) }}</span>
                </li>
                @if ($trx->hasTax())
                    <li class="list-group-item d-flex align-items-center justify-content-between p-3">
                        <h6 class="mb-0">
                            {{ d_trans(':tax_name (:tax_rate%)', [
                                'tax_name' => m_trans($trx->tax->name),
                                'tax_rate' => $trx->tax->rate,
                            ]) }}
                        </h6>
                        <span>{{ getAmount($trx->tax->amount) }}</span>
                    </li>
                @endif
                @if ($trx->hasFees())
                    <li class="list-group-item d-flex align-items-center justify-content-between p-3">
                        <h6 class="mb-0">
                            {{ d_trans(':payment_gateway Fees (:percentage%)', [
                                'payment_gateway' => $trx->paymentGateway->trans->name,
                                'percentage' => $trx->paymentGateway->fees,
                            ]) }}
                        </h6>
                        <span>{{ getAmount($trx->fees) }}</span>
                    </li>
                @endif
            @endif
            <li class="list-group-item d-flex align-items-center justify-content-between p-3">
                <h4 class="mb-0">{{ d_trans('Total') }}</h4>
                <h4 class="mb-0">{{ getAmount($trx->total) }}</h4>
            </li>
        </ul>
        <div class="card-footer p-4">
            <form action="{{ route('payments.ipn.razorpay') }}" method="POST">
                @csrf
                <input type="hidden" name="trx_id" value="{{ hash_encode($trx->id) }}">
                <script src="https://checkout.razorpay.com/v1/checkout.js"
                    @foreach ($data as $key => $value) data-{{ $key }}="{{ $value }}" @endforeach></script>
            </form>
            <a href="{{ route('business.checkout.index', hash_encode($trx->id)) }}"
                class="btn btn-outline-primary btn-md w-100 mt-3">
                {{ d_trans('Cancel Payment') }}
            </a>
        </div>
    </div>
    @push('scripts')
        <script>
            "use strict";
            let razorpayPaymentButton = $('.razorpay-payment-button');
            razorpayPaymentButton.addClass('btn btn-primary btn-md w-100');
        </script>
    @endpush
@endsection
