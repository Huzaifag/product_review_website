@extends('admin.auth.layout')
@section('section', d_trans('Admin'))
@section('title', d_trans('Reset Password'))
@section('content')
    <div class="mb-4">
        <h2 class="mb-2">{{ d_trans('Reset Password') }}</h2>
        <p class="mb-0 text-muted">
            {{ d_trans('Enter the email address associated with your account and we will send a link to reset your password.') }}
        </p>
    </div>
    <form action="{{ route('admin.password.email') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">{{ d_trans('Email Address') }} </label>
            <input type="email" name="email" class="form-control form-control-md" required />
        </div>
        <x-captcha />
        <button class="btn btn-primary btn-md d-block w-100">{{ d_trans('Reset Password') }}</button>
    </form>
    <p class="mb-0 text-center text-muted mt-3">{{ d_trans('Remember your password') }}? <a
            href="{{ route('admin.login') }}">{{ d_trans('Login') }}</a></p>
@endsection
