@extends('admin.auth.layout')
@section('section', d_trans('Admin'))
@section('title', d_trans('Login'))
@section('content')
    <div class="auth-head mb-4">
        <span class="auth-badge">
            <i class="bi bi-shield-lock"></i> {{ d_trans('Admin') }}
        </span>
        <h2 class="mb-2">{{ d_trans('Login') }}</h2>
        <p class="mb-0 text-muted">{{ d_trans('Log in to your account to continue.') }}</p>
    </div>

    <form action="{{ route('admin.login.store') }}" method="POST">
        @csrf

        <div class="mb-3 field-anim" style="--d:.06s">
            <label class="form-label">{{ d_trans('Email or Username') }}</label>
            <div class="input-icon-wrap">
                <i class="bi bi-person input-icon"></i>
                <input type="text" name="email_or_username"
                    class="form-control form-control-md has-icon"
                    value="{{ old('email') }}" required />
            </div>
        </div>

        <div class="mb-3 field-anim" style="--d:.12s">
            <label class="form-label">{{ d_trans('Password') }}</label>
            <div class="input-icon-wrap">
                <i class="bi bi-lock input-icon"></i>
                <input type="password" name="password" id="passwordInput"
                    class="form-control form-control-md has-icon" required />
                <button type="button" class="toggle-pass" tabindex="-1"
                    aria-label="{{ d_trans('Show password') }}"
                    onclick="(function(b){var i=document.getElementById('passwordInput'),e=b.querySelector('i');if(i.type==='password'){i.type='text';e.className='bi bi-eye-slash';}else{i.type='password';e.className='bi bi-eye';}})(this)">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <div class="row mb-3 field-anim" style="--d:.18s">
            <div class="col-auto">
                <label class="form-check mb-0">
                    <input type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }} class="form-check-input">
                    <span class="form-check-label">{{ d_trans('Remember me') }}</span>
                </label>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('admin.password.request') }}" class="auth-link">{{ d_trans('Forgot password') }}?</a>
            </div>
        </div>

        <div class="field-anim" style="--d:.24s">
            <x-captcha />
        </div>

        <button class="btn btn-primary btn-md d-block w-100 btn-auth field-anim" style="--d:.3s">
            <span>{{ d_trans('Login') }}</span>
            <i class="bi bi-arrow-right ms-2"></i>
        </button>
    </form>
@endsection