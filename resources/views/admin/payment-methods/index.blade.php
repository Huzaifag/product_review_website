@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('title', d_trans('Payment Methods'))
@section('header_title', d_trans('Payment Methods'))
@section('create', route('admin.payment-methods.create'))
@section('content')
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ request()->url() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-10">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
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
                        <th>{{ d_trans('Name') }}</th>
                        <th>{{ d_trans('Type') }}</th>
                        <th class="text-center">{{ d_trans('Environment') }}</th>
                        <th class="text-center">{{ d_trans('Status') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($paymentGateways as $method)
                            <tr data-id="{{ $method->id }}">
                                <td class="sortable-handle">
                                    <i class="fa-solid fa-up-down-left-right"></i>
                                </td>
                                <td>
                                    <a href="{{ route('admin.payment-methods.edit', $method->id) }}" class="text-dark">
                                        {{ $method->name }}
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-soft-info">{{ d_trans(ucfirst($method->alias ?? $method->name)) }}</span>
                                </td>
                                <td class="text-center">
                                    @if($method->mode === 'sandbox')
                                        <span class="badge bg-warning text-dark">{{ d_trans('Sandbox') }}</span>
                                    @else
                                        <span class="badge bg-success">{{ d_trans('Live') }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($method->isActive())
                                        <span class="badge bg-success">{{ d_trans('Active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ d_trans('Disabled') }}</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.payment-methods.edit', $method->id) }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>{{ d_trans('Edit') }}
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.payment-methods.destroy', $method->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="action-confirm dropdown-item text-danger">
                                                        <i class="far fa-trash-alt"></i>{{ d_trans('Delete') }}
                                                    </button>
                                                </form>
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
            const sortingRoute = "{{ route('admin.payment-methods.sortable') }}";
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