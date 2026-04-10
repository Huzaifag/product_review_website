@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('title', d_trans('Subscriptions'))
@section('header_title', d_trans('Subscriptions'))
@section('create', route('admin.subscriptions.create'))
@section('content')
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET">
                @if (request('owner'))
                    <input type="hidden" name="owner" value="{{ request('owner') }}">
                @endif
                <div class="row g-3">
                    <div class="col-12 col-lg-7">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="plan" class="selectpicker" title="{{ d_trans('Plan') }}" data-live-search="true">
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}" @selected(request('plan') == $plan->id)>
                                    {{ $plan->trans->name }}
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
                        <th class="text-center">{{ d_trans('Plan') }}</th>
                        <th class="text-center">{{ d_trans('Expiry date') }}</th>
                        <th class="text-center">{{ d_trans('Date') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($subscriptions as $subscription)
                            @php
                                $owner = $subscription->owner;
                                $plan = $subscription->plan;
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('admin.subscriptions.show', $subscription->id) }}">
                                        <i class="fa-solid fa-hashtag me-1"></i>{{ $subscription->id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.members.business-owners.edit', $owner->id) }}"
                                        class="text-dark">
                                        <i class="fa-regular fa-user me-2"></i>{{ $owner->getName() }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.plans.edit', $plan->id) }}" class="text-dark">
                                        {{ d_trans(':plan_name (:plan_interval)', [
                                            'plan_name' => $plan->trans->name,
                                            'plan_interval' => $plan->getIntervalName(),
                                        ]) }}
                                    </a>
                                </td>
                                <td class="text-center {{ $subscription->isExpired() ? 'text-danger' : '' }}">
                                    @if ($plan->isLifetime())
                                        <span>∞</span>
                                    @else
                                        {{ dateFormat($subscription->expiry_at) }}
                                    @endif
                                </td>
                                <td class="text-center">{{ dateFormat($subscription->created_at) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.subscriptions.show', $subscription->id) }}">
                                                    <i class="fas fa-desktop"></i>{{ d_trans('View details') }}
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
    {{ $subscriptions->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
