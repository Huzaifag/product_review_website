@extends('admin.auth.layout')
@section('section', d_trans('Admin'))
@section('title', d_trans('Login'))
@section('content')
    <div class="mb-4">
        <h2 class="mb-2">{{ d_trans('Login') }}</h2>
        <p class="mb-0 text-muted">{{ d_trans('Log in to your account to continue.') }}</p>
    </div>
    <form action="{{ route('admin.login.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">{{ d_trans('Email or Username') }} </label>
            <input type="text" name="email_or_username" class="form-control form-control-md" value="{{ old('email') }}"
                required />
        </div>
        <div class="mb-3">
            <label class="form-label">{{ d_trans('Password') }} </label>
            <input type="password" name="password" class="form-control form-control-md" required />
        </div>
        <div class="row mb-3">
            <div class="col-auto">
                <label class="form-check mb-0">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                        class="form-check-input">
                    <span class="form-check-label">{{ d_trans('Remember me') }}</span>
                </label>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('admin.password.request') }}">{{ d_trans('Forgot password') }}?</a>
            </div>
        </div>
        <x-captcha />
        <button class="btn btn-primary btn-md d-block w-100">{{ d_trans('Login') }}</button>
    </form>
@endsection
