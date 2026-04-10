@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Settings'))
@section('title', d_trans('Payment Gateways'))
@section('header_title', d_trans('Payment Gateways'))
@section('back', route('admin.settings.index'))
@section('content')
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-8">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="selectpicker" title="{{ d_trans('Status') }}">
                            @foreach (\App\Models\PaymentGateway::getAvailableStatues() as $key => $value)
                                <option value="{{ $key }}" @selected(request('status') == "$key")>
                                    {{ $value }}
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
                <table class="table sortable">
                    <thead>
                        <th><i class="fa-solid fa-hashtag"></i></th>
                        <th>{{ d_trans('Logo') }}</th>
                        <th>{{ d_trans('Name') }}</th>
                        <th class="text-center">{{ d_trans('Fees') }}</th>
                        <th class="text-center">{{ d_trans('Status') }}</th>
                        <th class="text-center">{{ d_trans('Last Update') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($paymentGateways as $paymentGateway)
                            <tr data-id="{{ $paymentGateway->id }}">
                                <td class="sortable-handle">
                                    <i class="fa-solid fa-up-down-left-right"></i>
                                </td>
                                <td>
                                    <a href="{{ route('admin.settings.payment-gateways.edit', $paymentGateway->id) }}">
                                        <img src="{{ $paymentGateway->getLogoLink() }}"
                                            alt="{{ $paymentGateway->trans->name }}" width="100px">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.settings.payment-gateways.edit', $paymentGateway->id) }}"
                                        class="text-dark">
                                        {{ $paymentGateway->trans->name }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $paymentGateway->fees }}%</td>
                                <td class="text-center">
                                    @if ($paymentGateway->isActive())
                                        <span class="badge bg-success">{{ $paymentGateway->getStatusName() }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $paymentGateway->getStatusName() }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ dateFormat($paymentGateway->created_at) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.settings.payment-gateways.edit', $paymentGateway->id) }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>{{ d_trans('Edit') }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('admin.partials.empty-table', ['colspan' => 6])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('top_scripts')
        <script>
            "use strict";
            const sortingRoute = "{{ route('admin.settings.payment-gateways.sortable') }}";
        </script>
    @endpush
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/sortable/sortable.min.js') }}"></script>
    @endpush
@endsection
