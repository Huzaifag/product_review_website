@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('title', d_trans('Transactions'))
@section('header_title', d_trans('Transactions'))
@section('content')
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-3 mb-4">
        <div class="col">
            <div class="vironeer-counter-card bg-warning">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-hourglass-half"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Pending') }}
                        ({{ numberFormat($counters['pending']['total']) }})</p>
                    <p class="vironeer-counter-card-number">{{ getAmount($counters['pending']['amount']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-success">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Paid') }}
                        ({{ numberFormat($counters['paid']['total']) }})</p>
                    <p class="vironeer-counter-card-number">{{ getAmount($counters['paid']['amount']) }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-danger">
                <div class="vironeer-counter-card-bg"></div>
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Cancelled') }}
                        ({{ numberFormat($counters['cancelled']['total']) }})</p>
                    <p class="vironeer-counter-card-number">{{ getAmount($counters['cancelled']['amount']) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET">
                @if (request('owner'))
                    <input type="hidden" name="owner" value="{{ request('owner') }}">
                @endif
                <div class="row g-3">
                    <div class="col-12">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        <input type="text" name="date_from" class="form-control text-secondary"
                            placeholder="{{ d_trans('From Date') }}" onfocus="(this.type='date')"
                            onblur="(this.type='text')" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        <input type="text" name="date_to" class="form-control text-secondary"
                            placeholder="{{ d_trans('To Date') }}" onfocus="(this.type='date')" onblur="(this.type='text')"
                            value="{{ request('date_to') }}">
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="payment_method" class="selectpicker" title="{{ d_trans('Payment Method') }}"
                            data-live-search="true">
                            @foreach ($paymentGateways as $paymentGateway)
                                <option value="{{ $paymentGateway->id }}" @selected(request('payment_method') == $paymentGateway->id)>
                                    {{ $paymentGateway->trans->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="selectpicker" title="{{ d_trans('Status') }}">
                            @foreach ($statuses as $statusKey => $statusValue)
                                <option value="{{ $statusKey }}" @selected($statusKey == request('status'))>
                                    {{ $statusValue }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="{{ url()->current() }}" class="btn btn-soft w-100">{{ d_trans('Reset') }}</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th><i class="fa-solid fa-hashtag"></i></th>
                        <th>{{ d_trans('Business Owner') }}</th>
                        <th class="text-center">{{ d_trans('SubTotal') }}</th>
                        <th class="text-center">{{ d_trans('Tax') }}</th>
                        <th class="text-center">{{ d_trans('Fees') }}</th>
                        <th class="text-center">{{ d_trans('Total') }}</th>
                        <th class="text-center">{{ d_trans('Status') }}</th>
                        <th class="text-center">{{ d_trans('Date') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $trx)
                            @php
                                $owner = $trx->owner;
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('admin.transactions.show', $trx->id) }}">
                                        <i class="fa-solid fa-hashtag me-1"></i>{{ $trx->id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.members.business-owners.edit', $owner->id) }}"
                                        class="text-dark">
                                        <i class="fa-regular fa-user me-2"></i>{{ $owner->getName() }}
                                    </a>
                                </td>
                                <td class="text-center text-dark">{{ getAmount($trx->amount) }}</td>
                                <td class="text-center text-dark">
                                    {{ getAmount($trx->hasTax() ? $trx->tax->amount : 0) }}
                                </td>
                                <td class="text-center text-dark">{{ getAmount($trx->fees) }}</td>
                                <td class="text-center text-dark"><strong>{{ getAmount($trx->total) }}</strong></td>
                                <td class="text-center">
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
                                </td>
                                <td class="text-center">{{ dateFormat($trx->created_at) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.transactions.show', $trx->id) }}"><i
                                                        class="fa-solid fa-desktop me-2"></i>{{ d_trans('Details') }}</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.transactions.destroy', $trx->id) }}"
                                                    method="POST">
                                                    @csrf @method('DELETE')
                                                    <button class="dropdown-item action-confirm text-danger"><i
                                                            class="far fa-trash-alt me-2"></i>{{ d_trans('Delete') }}</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('admin.partials.empty-table', ['colspan' => 9])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $transactions->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/counter-cards.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
