@extends('themes.basic.auth.layout')
@section('no_index', true)
@section('title', d_trans('Reset Password'))
@section('content')
    <div class="box">
        <div class="mb-4">
            <h2 class="sign-title">{{ d_trans('Reset Password') }}</h2>
            <p class="sign-text">{{ d_trans('You will receive an email with a link to reset your password') }}</p>
        </div>
        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ d_trans('Email address') }}</label>
                <input type="email" name="email" class="form-control form-control-md" value="{{ old('email') }}"
                    required />
            </div>
            <x-captcha />
            <button class="btn btn-primary btn-md w-100">{{ d_trans('Reset') }}</button>
        </form>
    </div>
    <div class="mt-4 text-center">{{ d_trans('You remembered the password?') }} <a href="{{ route('login') }}"
            class="link-primary">{{ d_trans('Sign In') }}</a>
    </div>
@endsection
