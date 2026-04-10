@extends('themes.basic.business.layouts.app')
@section('container', 'dashboard-container-xl')
@section('title', d_trans('Checkout'))
@section('header_title', d_trans('Checkout'))
@section('breadcrumbs', Breadcrumbs::render('business.checkout', $trx))
@section('content')
    @if ($trx->isUnpaid())
        <livewire:business.checkout :trx="$trx" />
    @else
        <div class="card">
            <div class="card-body text-center p-5">
                <div class="py-5">
                    <div class="mb-4">
                        <i class="fa fa-check-circle text-primary fa-5x"></i>
                    </div>
                    <h2 class="mb-3">{{ d_trans('Payment Completed') }}</h2>
                    <p>
                        {{ d_trans('Payment has been completed and your subscription has been created successfully.') }}
                    </p>
                    <a href="{{ route('business.subscription.index') }}" class="btn btn-outline-primary btn-md mt-2">
                        <i class="fa-regular fa-gem me-1"></i>
                        <span>{{ d_trans('View My Subscription') }}</span>
                    </a>
                </div>
            </div>
        </div>
    @endif
@endsection
