@extends('themes.basic.business.layouts.app')
@section('container', 'dashboard-container-md')
@section('title', d_trans('Transactions'))
@section('header_title', d_trans('Transaction #:number', ['number' => $trx->id]))
@section('breadcrumbs', Breadcrumbs::render('business.subscription.transaction', $trx))
@section('back', route('business.subscription.index'))
@section('content')
    <div class="card mb-3">
        <ul class="list-group list-group-flush">
            <li class="list-group-item  p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h6 class="mb-0">{{ d_trans('Transaction ID') }}</h6>
                    </div>
                    <div class="col-auto">
                        <span>#{{ $trx->id }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item  p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h6 class="mb-0">{{ d_trans('Transaction Date') }}</h6>
                    </div>
                    <div class="col-auto">
                        <span>{{ dateFormat($trx->created_at) }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h6 class="mb-0">{{ d_trans('Transaction Status') }}</h6>
                    </div>
                    <div class="col-auto">
                        @if ($trx->isPending())
                            <div class="badge bg-warning rounded-2 px-3 py-2">
                                {{ $trx->getStatusName() }}
                            </div>
                        @elseif($trx->isPaid())
                            <div class="badge bg-success rounded-2 px-3 py-2">
                                {{ $trx->getStatusName() }}
                            </div>
                        @elseif($trx->isCancelled())
                            <div class="badge bg-danger rounded-2 px-3 py-2">
                                {{ $trx->getStatusName() }}
                            </div>
                        @endif
                    </div>
                </div>
            </li>
            @if ($trx->isCancelled() && $trx->cancellation_reason)
                <li class="list-group-item p-4">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h6 class="mb-0">{{ d_trans('Cancellation reason') }}</h6>
                        </div>
                        <div class="col-auto">
                            <i class="text-muted">{{ $trx->cancellation_reason }}</i>
                        </div>
                    </div>
                </li>
            @endif
            <li class="list-group-item  p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h6 class="mb-0">{{ d_trans('Payment Method') }}</h6>
                    </div>
                    <div class="col-auto">
                        <span>{{ $trx->paymentGateway->trans->name }}</span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="card">
        <ul class="list-group list-group-flush">
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h6 class="mb-0">
                            {{ d_trans(':plan_name (:plan_interval)', [
                                'plan_name' => $trx->plan->trans->name,
                                'plan_interval' => $trx->plan->getIntervalName(),
                            ]) }}
                        </h6>
                    </div>
                    <div class="col-auto">
                        <div>{{ getAmount($trx->amount) }}</div>
                    </div>
                </div>
            </li>
            @if ($trx->hasFees() || $trx->hasTax())
                <li class="list-group-item  p-4">
                    <div class="row g-2 align-items-center">
                        <div class="col">
                            <h6 class="mb-0">{{ d_trans('SubTotal') }}</h6>
                        </div>
                        <div class="col-auto">
                            <h6 class="mb-0">{{ getAmount($trx->amount) }}</h6>
                        </div>
                    </div>
                </li>
                @if ($trx->hasTax())
                    <li class="list-group-item p-4">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <h6 class="mb-0">
                                    {{ d_trans(':tax_name (:tax_rate%)', [
                                        'tax_name' => m_trans($trx->tax->name),
                                        'tax_rate' => $trx->tax->rate,
                                    ]) }}
                                </h6>
                            </div>
                            <div class="col-auto">
                                <div>{{ getAmount($trx->tax->amount) }}</div>
                            </div>
                        </div>
                    </li>
                @endif
                @if ($trx->hasFees())
                    <li class="list-group-item p-4">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <h6 class="mb-0">
                                    {{ d_trans(':payment_gateway Fees (:percentage%)', [
                                        'payment_gateway' => $trx->paymentGateway->trans->name,
                                        'percentage' => $trx->paymentGateway->fees,
                                    ]) }}
                                </h6>
                            </div>
                            <div class="col-auto">
                                <div>{{ getAmount($trx->fees) }}</div>
                            </div>
                        </div>
                    </li>
                @endif
            @endif
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h4 class="mb-0">{{ d_trans('Total') }}</h4>
                    </div>
                    <div class="col-auto">
                        <h4 class="mb-0">{{ getAmount($trx->total) }}</h4>
                    </div>
                </div>
            </li>
        </ul>
    </div>
@endsection
