@extends('themes.basic.business.layouts.app')
@section('container', 'dashboard-container-sm')
@section('title', d_trans('Checkout'))
@section('header_title', d_trans('Complete the payment'))
@section('breadcrumbs', Breadcrumbs::render('business.checkout', $trx))
@section('content')
    <div class="row g-3 row-cols-1">
        <div class="col">
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
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header fw-medium fs-5">{{ d_trans('Instructions') }}</div>
                <div class="card-body">
                    {!! $trx->paymentGateway->instructions !!}
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header fw-medium fs-5">{{ d_trans('Payment proof') }}</div>
                <div class="card-body">
                    <p class="mb-4">
                        {{ d_trans('Choose payment Proof (Receipt, Bank statement, etc..), allowed file types (jpg, jpeg, png, pdf) in max size 2MB.') }}
                    </p>
                    <form action="{{ route('payments.manual.bankwire') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="checkout_id" value="{{ hash_encode($trx->id) }}">
                        <div class="mb-4">
                            <input type="file" name="payment_proof" class="form-control form-control-md"
                                accept="image/jpg, image/jpeg, image/png, application/pdf" required>
                        </div>
                        <button class="btn btn-primary btn-md w-100">{{ d_trans('Submit') }}</button>
                    </form>
                    <a href="{{ route('business.checkout.index', hash_encode($trx->id)) }}"
                        class="btn btn-outline-primary btn-md w-100 mt-3">
                        {{ d_trans('Cancel Payment') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
