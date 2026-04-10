@extends('themes.basic.business.auth.layout')
@section('title', d_trans('Claim Your Business'))
@section('sign_size', 'sign-lg')
@section('content')
    <div class="mb-3">
        <h2 class="sign-title">{{ d_trans('Claim Your Business') }}</h2>
        <p class="sign-text">
            {{ d_trans('To claim your business, we need to verify your domain, which will help us to know if you are the actual owner of that business.') }}
        </p>
    </div>
    <div>
        <p class="mb-1 fw-bold">{{ d_trans('To verify your domain, follow these steps:') }}</p>
        <ul class="mb-3 ps-3">
            <li>{{ d_trans('Go to your domain DNS settings.') }}</li>
            <li>{{ d_trans('Add a new TXT record with the following details:') }}</li>
        </ul>
        <div class="mb-3 bg-light p-3 rounded border text-dark">
            <p class="mb-1"><strong>{{ d_trans('Type:') }}</strong> TXT</p>
            <p class="mb-1"><strong>{{ d_trans('Name/Host:') }}</strong> @</p>
            <p class="mb-0"><strong>{{ d_trans('Value:') }}</strong>
                {{ $business->getDomainVerificationKey(hash_encode(authBusinessOwner()->id)) }}</p>
        </div>
        <p class="mb-3">
            {{ d_trans('Once added, click verify now to claim your business and please note that it may take a few minutes for changes to propagate.') }}
        </p>
        <form action="{{ route('business.claim.verify', hash_encode($business->id)) }}" method="POST">
            @csrf
            <button class="btn btn-primary btn-md action-confirm w-100">{{ d_trans('Verify Now') }}</button>
        </form>
        <div class="login-with mt-3">
            <div class="login-with-divider">
                <span>{{ d_trans('Or') }}</span>
            </div>
            <a href="{{ route('business.dashboard') }}"
                class="btn btn-outline-secondary btn-md w-100">{{ d_trans('Cancel') }}</a>
        </div>
    </div>
@endsection
