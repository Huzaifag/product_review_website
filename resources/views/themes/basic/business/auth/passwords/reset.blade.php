@extends('themes.basic.business.auth.layout')
@section('no_index', true)
@section('title', d_trans('Reset Password'))
@section('content')
    <div class="mb-4">
        <h2 class="sign-title">{{ d_trans('Reset Password') }}</h2>
        <p class="sign-text">{{ d_trans('Enter a new password to continue.') }}</p>
    </div>
    <form action="{{ route('business.password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-3">
            <label class="form-label">{{ d_trans('Email address') }}</label>
            <input type="email" name="email" class="form-control form-control-md" value="{{ $email }}"
                readonly />
        </div>
        <div class="mb-3">
            <label class="form-label">{{ d_trans('Password') }}</label>
            <input type="password" name="password" class="form-control form-control-md" minlength="8" required>
        </div>
        <div class="mb-3">
            <label class="form-label">{{ d_trans('Confirm password') }}</label>
            <input type="password" name="password_confirmation" class="form-control form-control-md" minlength="8"
                required>
        </div>
        <x-captcha />
        <button class="btn btn-primary btn-md w-100">{{ d_trans('Reset') }}</button>
    </form>
@endsection
