@extends('themes.basic.auth.layout')
@section('no_index', true)
@section('title', d_trans('Complete Details'))
@section('content')
    <div class="box">
        <div class="mb-4">
            <h2 class="sign-title">{{ d_trans('Complete Details') }}</h2>
            <p class="sign-text">
                {{ d_trans('You need to complete some basic details required to log in next time') }}
            </p>
        </div>
        <form action="{{ route('data.complete') }}" method="POST">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-lg-12">
                    <label class="form-label">{{ d_trans('Email address') }}</label>
                    <input type="email" name="email" class="form-control form-control-md" value="{{ authUser()->email }}"
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
            <button class="btn btn-primary btn-md w-100">{{ d_trans('Continue') }}</button>
        </form>
    </div>
@endsection
