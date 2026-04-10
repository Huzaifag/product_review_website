@extends('themes.basic.auth.layout')
@section('title', d_trans('Sign Up'))
@section('content')
    <div class="box">
        <div class="mb-4">
            <h2 class="sign-title">{{ d_trans('Sign Up') }}</h2>
            <p class="sign-text">{{ d_trans('Enter your details to create an account.') }}</p>
        </div>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-lg-12">
                    <label class="form-label">{{ d_trans('Email address') }}</label>
                    <input type="email" name="email" class="form-control form-control-md" value="{{ old('email') }}"
                        required />
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
                @if (config('settings.links.terms_of_use_link'))
                    <div class="col-lg-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="terms" id="terms"
                                {{ old('terms') ? 'checked' : '' }}>
                            <label class="form-check-label" for="terms">
                                {{ d_trans('I agree to the') }}
                                <a href="{{ config('settings.links.terms_of_use_link') }}"
                                    class="link link-primary">{{ d_trans('Terms of service') }}</a>
                            </label>
                        </div>
                    </div>
                @endif
            </div>
            <x-captcha />
            <button class="btn btn-primary btn-md w-100">{{ d_trans('Sign Up') }}</button>
        </form>
        <x-oauth-buttons />
    </div>
    <div class="mt-4 text-center">{{ d_trans('You an account already?') }} <a href="{{ route('login') }}"
            class="link-primary">{{ d_trans('Sign In') }}</a>
    </div>
@endsection
