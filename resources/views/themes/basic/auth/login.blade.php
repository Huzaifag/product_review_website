@extends('themes.basic.auth.layout')
@section('title', d_trans('Sign In'))
@section('content')
    <div class="box">
        <div class="mb-4">
            <h1 class="sign-title">{{ d_trans('Sign In') }}</h1>
            <p class="sign-text">{{ d_trans('Enter your account details to sign in') }}</p>
        </div>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ d_trans('Email or Username') }}</label>
                <input type="text" name="email_or_username" class="form-control form-control-md"
                    value="{{ old('email_or_username') }}" required />
            </div>
            <div class="mb-3">
                <div class="mb-2">
                    <div class="row row-cols-auto justify-content-between align-items-center g-2">
                        <div class="col">
                            <label class="form-label mb-0">{{ d_trans('Password') }}</label>
                        </div>
                        <div class="col">
                            <a href="{{ route('password.request') }}" class="d-block">
                                {{ d_trans('Forgot Your Password?') }}
                            </a>
                        </div>
                    </div>
                </div>
                <input type="password" name="password" class="form-control form-control-md" required />
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">{{ d_trans('Remember Me') }}</label>
                </div>
            </div>
            <x-captcha />
            <button class="btn btn-primary btn-md w-100">{{ d_trans('Sign In') }}</button>
        </form>
        <x-oauth-buttons />
    </div>
    @if (config('settings.user.actions.registration'))
        <div class="mt-4 text-center">{{ d_trans("You don't have an account?") }} <a href="{{ route('register') }}"
                class="link-primary">{{ d_trans('Sign Up') }}</a>
        </div>
    @endif
@endsection
