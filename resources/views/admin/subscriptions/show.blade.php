@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Subscriptions'))
@section('title', d_trans('Subscription #:subscription_id', ['subscription_id' => $subscription->id]))
@section('header_title', d_trans('Subscription #:subscription_id', ['subscription_id' => $subscription->id]))
@section('back', route('admin.subscriptions.index'))
@section('content')
    @php
        $owner = $subscription->owner;
        $plan = $subscription->plan;
    @endphp
    <div class="card mb-3">
        <div class="list v2">
            <div class="list-header">
                <h6 class="list-title mb-0">{{ d_trans('Subscription Details') }}</h6>
            </div>
            <table class="table align-middle mb-0">
                <tbody>
                    <tr>
                        <td class="fw-medium">{{ d_trans('Subscription ID') }}</td>
                        <td>#{{ $subscription->id }}</td>
                    </tr>
                    <tr>
                        <td class="fw-medium">{{ d_trans('Business Owner') }}</td>
                        <td>
                            <a href="{{ route('admin.members.business-owners.edit', $owner->id) }}">
                                <i class="fa-regular fa-user me-2"></i>{{ $owner->getName() }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-medium">{{ d_trans('Plan') }}</td>
                        <td>
                            <a href="{{ route('admin.plans.edit', $plan->id) }}">
                                {{ d_trans(':plan_name (:plan_interval)', [
                                    'plan_name' => $plan->trans->name,
                                    'plan_interval' => $plan->getIntervalName(),
                                ]) }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-medium">{{ d_trans('Expiry Date') }}</td>
                        <td {{ $subscription->isExpired() ? 'class=text-danger' : '' }}>
                            @if ($plan->isLifetime())
                                <span>∞</span>
                            @else
                                {{ dateFormat($subscription->expiry_at) }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-medium">{{ d_trans('Date') }}</td>
                        <td>{{ dateFormat($subscription->created_at) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-header">{{ d_trans('Take Action') }}</div>
        <div class="card-body">
            <form action="{{ route('admin.subscriptions.destroy', $subscription->id) }}" method="POST">
                @csrf
                <button class="btn btn-outline-danger btn-md w-100 action-confirm">
                    <i class="fa-regular fa-circle-xmark me-1"></i>
                    {{ d_trans('Cancel Subscription') }}
                </button>
            </form>
        </div>
    </div>
@endsection
