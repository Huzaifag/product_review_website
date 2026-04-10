@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('title', d_trans('Transactions'))
@section('header_title', d_trans('Transaction #:transaction_id', ['transaction_id' => $trx->id]))
@section('back', route('admin.transactions.index'))
@section('content')
    @if (!$trx->isCancelled())
        <div class="card mb-3">
            <div class="card-body p-4">
                <div class="row g-3">
                    @if ($trx->isPending())
                        <div class="col">
                            <form action="{{ route('admin.transactions.paid', $trx->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-outline-success btn-md action-confirm w-100">
                                    <i class="fa-solid fa-check me-1"></i>
                                    <span>{{ d_trans('Paid') }}</span>
                                </button>
                            </form>
                        </div>
                    @endif
                    <div class="col">
                        <button id="trxCancelButton" type="button" class="btn btn-outline-danger btn-md w-100">
                            <i class="fa-solid fa-xmark me-1"></i>
                            <span>{{ d_trans('Cancel') }}</span>
                        </button>
                    </div>
                    <div id="trxCancelForm" class="col-12" style="display: none;">
                        <form action="{{ route('admin.transactions.cancel', $trx->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">{{ d_trans('Cancellation Reason') }}</label>
                                <textarea name="cancellation_reason" class="form-control" rows="6" required></textarea>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="email_notification" class="form-check-input">
                                <label class="form-check-label">{{ d_trans('Send Email Notification') }}</label>
                            </div>
                            <button class="btn btn-danger btn-lg px-5 action-confirm">
                                <span>{{ d_trans('Submit') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($trx->payment_proof)
        <div class="card mb-3">
            <div class="card-body p-4">
                <a href="{{ route('admin.transactions.payment-proof', $trx->id) }}" target="_blank"
                    class="btn btn-outline-primary btn-md w-100">
                    <i class="fa-solid fa-arrow-up-right-from-square me-1"></i>
                    {{ d_trans('View Payment Proof') }}
                </a>
            </div>
        </div>
    @endif
    <div class="card mb-3">
        <ul class="list-group list-group-flush">
            <li class="list-group-item  p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ d_trans('Business Owner') }}</strong>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.members.business-owners.edit', $trx->owner->id) }}" class="text-dark">
                            <i class="fa fa-user me-2"></i>{{ $trx->owner->getName() }}
                        </a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="card mb-3">
        <ul class="list-group list-group-flush">
            <li class="list-group-item  p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ d_trans('Transaction ID') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>#{{ $trx->id }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item  p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ d_trans('Transaction Date') }}</strong>
                    </div>
                    <div class="col-auto">
                        <span>{{ dateFormat($trx->created_at) }}</span>
                    </div>
                </div>
            </li>
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ d_trans('Transaction Status') }}</strong>
                    </div>
                    <div class="col-auto">
                        @if ($trx->isPending())
                            <div class="badge bg-warning">
                                {{ $trx->getStatusName() }}
                            </div>
                        @elseif($trx->isPaid())
                            <div class="badge bg-success">
                                {{ $trx->getStatusName() }}
                            </div>
                        @elseif($trx->isCancelled())
                            <div class="badge bg-danger">
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
                            <strong>{{ d_trans('Cancellation reason') }}</strong>
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
                        <strong>{{ d_trans('Payment Gateway') }}</strong>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.settings.payment-gateways.edit', $trx->paymentGateway->id) }}"
                            class="text-dark">
                            <span>{{ $trx->paymentGateway->trans->name }}</span>
                        </a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="card mb-3">
        <ul class="list-group list-group-flush">
            <li class="list-group-item p-4">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <strong>{{ d_trans(':plan_name (:plan_interval)', [
                            'plan_name' => $trx->plan->trans->name,
                            'plan_interval' => $trx->plan->getIntervalName(),
                        ]) }}</strong>
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
                            <strong>{{ d_trans('SubTotal') }}</strong>
                        </div>
                        <div class="col-auto">
                            <div>{{ getAmount($trx->amount) }}</div>
                        </div>
                    </div>
                </li>
                @if ($trx->hasTax())
                    <li class="list-group-item p-4">
                        <div class="row g-2 align-items-center">
                            <div class="col">
                                <strong>{{ d_trans(':tax_name (:tax_rate%)', [
                                    'tax_name' => m_trans($trx->tax->name),
                                    'tax_rate' => $trx->tax->rate,
                                ]) }}</strong>
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
                                <strong>{{ d_trans(':payment_gateway Fees (:percentage%)', [
                                    'payment_gateway' => $trx->paymentGateway->trans->name,
                                    'percentage' => $trx->paymentGateway->fees,
                                ]) }}</strong>
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
    @push('scripts')
        <script>
            "use strict";
            let trxCancelButton = $('#trxCancelButton'),
                trxCancelForm = $('#trxCancelForm');
            trxCancelButton.on('click', function() {
                trxCancelForm.toggle();
            })
        </script>
    @endpush
@endsection
