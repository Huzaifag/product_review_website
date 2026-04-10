@extends('themes.basic.business.auth.layout')
@section('no_index', true)
@section('title', d_trans('Complete your information'))
@section('content')
    <div class="mb-4">
        <h2 class="sign-title">{{ d_trans('Complete your information') }}</h2>
        <p class="sign-text">
            {{ d_trans('You need to complete some basic information required to log in next time') }}
        </p>
    </div>
    <form action="{{ route('business.data.complete') }}" method="POST">
        @csrf
        <div class="row g-3 mb-3">
            <div class="col-lg-6">
                <label class="form-label">{{ d_trans('First Name') }}</label>
                <input type="text" name="firstname" class="form-control form-control-md"
                    value="{{ authBusinessOwner()->firstname }}" required />
            </div>
            <div class="col-lg-6">
                <label class="form-label">{{ d_trans('Last Name') }}</label>
                <input type="text" name="lastname" class="form-control form-control-md"
                    value="{{ authBusinessOwner()->lastname }}" required />
            </div>
            <div class="col-lg-12">
                <label class="form-label">{{ d_trans('Username') }}</label>
                <input type="text" name="username" class="form-control form-control-md" minlength="3"
                    value="{{ authBusinessOwner()->username }}"" required />
            </div>
            <div class="col-lg-12">
                <label class="form-label">{{ d_trans('Email address') }}</label>
                <input type="email" name="email" class="form-control form-control-md"
                    value="{{ authBusinessOwner()->email }}" required />
            </div>
            <div class="col-lg-12">
                <label class="form-label">{{ d_trans('Password') }}</label>
                <input type="password" name="password" class="form-control form-control-md" minlength="8" required>
            </div>
            <div class="col-lg-12">
                <label class="form-label">{{ d_trans('Confirm password') }}</label>
                <input type="password" name="password_confirmation" class="form-control form-control-md" minlength="8"
                    required>
            </div>
            @if (config('settings.links.terms_of_use_link') || config('settings.links.business_terms_link'))
                <div class="col-lg-12">
                    @if (config('settings.links.terms_of_use_link'))
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="terms" id="terms"
                                {{ old('terms') ? 'checked' : '' }}>
                            <label class="form-check-label" for="terms">
                                {{ d_trans('I agree to the') }}
                                <a href="{{ config('settings.links.terms_of_use_link') }}"
                                    class="link link-primary">{{ d_trans('Terms of service') }}</a>
                            </label>
                        </div>
                    @endif
                    @if (config('settings.links.business_terms_link'))
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="business_terms" id="businessTerms"
                                {{ old('business_terms') ? 'checked' : '' }}>
                            <label class="form-check-label" for="businessTerms">
                                {{ d_trans('I read and I agree to the') }}
                                <a href="{{ config('settings.links.business_terms_link') }}"
                                    class="link link-primary">{{ d_trans('Business terms') }}</a>
                            </label>
                        </div>
                    @endif
                </div>
            @endif
        </div>
        <x-captcha />
        <button class="btn btn-primary btn-md w-100">{{ d_trans('Continue') }}</button>
    </form>
    @include('themes.basic.business.partials.logout-divider')
@endsection
