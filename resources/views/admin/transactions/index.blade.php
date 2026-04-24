@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('title', d_trans('Transactions'))
@section('header_title', d_trans('Transactions'))
@section('content')
    <div class="row g-3 row-cols-md-2 row-cols-xxl-3 mb-4">

        <!-- Pending -->
        <div class="col">
            <div class="split-stat-card theme-brand-copper">
                <div class="split-card-content">
                    <p class="split-card-title">
                        {{ d_trans('Pending') }}
                        ({{ numberFormat($counters['pending']['total']) }})
                    </p>
                    <h3 class="split-card-number">
                        {{ getAmount($counters['pending']['amount']) }}
                    </h3>
                </div>
                <div class="split-card-icon">
                    <i class="fa-regular fa-hourglass-half"></i>
                </div>
            </div>
        </div>

        <!-- Paid -->
        <div class="col">
            <div class="split-stat-card theme-brand-base">
                <div class="split-card-content">
                    <p class="split-card-title">
                        {{ d_trans('Paid') }}
                        ({{ numberFormat($counters['paid']['total']) }})
                    </p>
                    <h3 class="split-card-number">
                        {{ getAmount($counters['paid']['amount']) }}
                    </h3>
                </div>
                <div class="split-card-icon">
                    <i class="fa-solid fa-check"></i>
                </div>
            </div>
        </div>

        <!-- Cancelled -->
        <div class="col">
            <div class="split-stat-card theme-brand-sienna">
                <div class="split-card-content">
                    <p class="split-card-title">
                        {{ d_trans('Cancelled') }}
                        ({{ numberFormat($counters['cancelled']['total']) }})
                    </p>
                    <h3 class="split-card-number">
                        {{ getAmount($counters['cancelled']['amount']) }}
                    </h3>
                </div>
                <div class="split-card-icon">
                    <i class="fa-solid fa-xmark"></i>
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
                        <th>{{ d_trans('Customer') }}</th>
                        <th>{{ d_trans('Plan') }}</th>
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
                            <tr>
                                <td class="text-dark">
                                    <i class="fa-solid fa-hashtag me-1"></i>{{ $trx->id }}
                                </td>
                                <td>
                                    <a href="{{ $trx->user_id ? route('admin.members.users.edit', $trx->user_id) : '#' }}"
                                        class="text-dark">
                                        <i class="fa-regular fa-user me-2"></i>
                                        {{ $trx->user?->getName() ?? ($trx->payer_email ?? d_trans('Unknown')) }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.plans.edit', $trx->plan_id) }}" class="text-dark">
                                        <i class="fa-solid fa-cubes me-2"></i>{{ $trx->plan->name }}
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
                                        <div class="badge bg-warning">{{ $trx->getStatusName() }}</div>
                                    @elseif ($trx->isPaid())
                                        <div class="badge bg-success">{{ $trx->getStatusName() }}</div>
                                    @elseif ($trx->isCancelled())
                                        <div class="badge bg-danger">{{ $trx->getStatusName() }}</div>
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
                                                    href="{{ route('admin.transactions.show', $trx->id) }}">
                                                    <i class="fa-solid fa-desktop me-2"></i>{{ d_trans('Details') }}
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.transactions.destroy', $trx->id) }}"
                                                    method="POST">
                                                    @csrf @method('DELETE')
                                                    <button class="dropdown-item action-confirm text-danger">
                                                        <i class="far fa-trash-alt me-2"></i>{{ d_trans('Delete') }}
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('admin.partials.empty-table', ['colspan' => 10])
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

         <style>
            /* --- Split Layout Stat Cards --- */

            .split-stat-card {
                position: relative;
                display: flex;
                align-items: center;
                border-radius: 8px;
                padding: 24px 20px;
                color: #ffffff;
                overflow: hidden;
                min-height: 110px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .split-stat-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            /* Left Content */
            .split-card-content {
                position: relative;
                z-index: 2;
                flex: 1;
            }

            .split-card-title {
                font-size: 13px;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin: 0 0 8px 0;
                opacity: 0.95;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            }

            .split-card-number {
                font-size: 28px;
                font-weight: 700;
                margin: 0;
                line-height: 1;
                text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            }

            /* Right Curved Shape */
            .split-card-icon {
                position: absolute;
                right: 0;
                top: 0;
                height: 100%;
                width: 35%;
                /* Adjusts how wide the curve section is */
                background-color: var(--shape-color);
                border-top-left-radius: 120px;
                /* Creates the curve */
                border-bottom-left-radius: 120px;
                /* Creates the curve */
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 32px;
                z-index: 1;
                transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Optional hover effect on the shape */
            .split-stat-card:hover .split-card-icon {
                width: 38%;
            }

            /* --- 8 Unique Color Themes --- */

            /* 1. Base Brand Color */
            .theme-brand-base {
                background: linear-gradient(120deg, #ba511d 0%, #d4724a 100%);
                --shape-color: #8a3a12;
            }

            /* 2. Soft Blush Copper */
            .theme-brand-copper {
                background: linear-gradient(120deg, #c96340 0%, #dea080 100%);
                --shape-color: #9a4228;
            }

            /* 3. Warm Peach Clay */
            .theme-brand-clay {
                background: linear-gradient(120deg, #d4845a 0%, #e8b595 100%);
                --shape-color: #ba511d;
            }

            /* 4. Dusty Rose Sienna */
            .theme-brand-sienna {
                background: linear-gradient(120deg, #c05535 0%, #d98870 100%);
                --shape-color: #8f3820;
            }

            /* 5. Soft Amber Gold */
            .theme-brand-gold {
                background: linear-gradient(120deg, #c97a2a 0%, #e0aa6a 100%);
                --shape-color: #9a5518;
            }

            /* 6. Linen Sand */
            .theme-brand-sand {
                background: linear-gradient(120deg, #d4a07a 0%, #e8c9aa 100%);
                --shape-color: #b07045;
            }

            /* 7. Soft Brick */
            .theme-brand-brick {
                background: linear-gradient(120deg, #b84535 0%, #d08070 100%);
                --shape-color: #8a2e20;
            }

            /* 8. Warm Mist Mahogany */
            .theme-brand-mahogany {
                background: linear-gradient(120deg, #9a4020 0%, #c07a5a 100%);
                --shape-color: #6e2a12;
            }
        </style>
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
