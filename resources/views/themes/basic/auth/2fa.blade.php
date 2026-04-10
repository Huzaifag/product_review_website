@extends('themes.basic.auth.layout')
@section('no_index', true)
@section('title', d_trans('2Fa Verification'))
@section('content')
    <div class="box">
        <div class="mb-4">
            <h2 class="sign-title">{{ d_trans('2Fa Verification') }}</h2>
            <p class="sign-text">{{ d_trans('Please enter the OTP code to continue') }}</p>
        </div>
        <form action="{{ route('2fa.verify') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" name="otp_code" class="form-control form-control-md input-numeric" maxlength="6"
                    required placeholder="• • • • • •" autofocus>
            </div>
            <button class="btn btn-primary btn-md w-100">{{ d_trans('Continue') }}</button>
        </form>
    </div>
@endsection
