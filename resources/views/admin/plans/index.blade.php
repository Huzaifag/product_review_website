@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('title', d_trans('Pricing plans'))
@section('header_title', d_trans('Pricing Plans'))
@section('create', route('admin.plans.create'))
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
                        <th>{{ d_trans('Interval') }}</th>
                        <th class="text-center">{{ d_trans('Price') }}</th>
                        <th class="text-center">{{ d_trans('Downloads') }}</th>
                        <th class="text-center">{{ d_trans('Status') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($plans as $plan)
                            <tr data-id="{{ $plan->id }}">
                                <td class="sortable-handle">
                                    <i class="fa-solid fa-up-down-left-right"></i>
                                </td>
                                <td>
                                    <a href="{{ route('admin.plans.edit', $plan->id) }}" class="text-dark">
                                        {{ $plan->trans->name }}
                                        @if ($plan->isFeatured())
                                            <span class="badge bg-primary ms-2">{{ d_trans('Featured') }}</span>
                                        @endif
                                    </a>
                                </td>
                                <td>{{ $plan->getIntervalName() }}</td>
                                <td class="text-center">
                                    {{ getAmount($plan->price) }}</td>
                                <td class="text-center">
                                    {{ !$plan->businesses ? d_trans('Unlimited') : number_format($plan->businesses) }}
                                </td>
                                <td class="text-center">
                                    @if ($plan->isActive())
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
                                                <a class="dropdown-item" href="{{ route('admin.plans.edit', $plan->id) }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>{{ d_trans('Edit') }}
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.plans.destroy', $plan->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="action-confirm dropdown-item text-danger"><i
                                                            class="far fa-trash-alt"></i>{{ d_trans('Delete') }}</button>
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
            const sortingRoute = "{{ route('admin.plans.sortable') }}";
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
