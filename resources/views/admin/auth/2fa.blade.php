@extends('admin.auth.layout')
@section('section', d_trans('Admin'))
@section('title', d_trans('2Fa Verification'))
@section('content')
    <div class="mb-4">
        <h2 class="mb-2">{{ d_trans('2Fa Verification') }}</h2>
        <p class="mb-0 text-muted">{{ d_trans('Please enter the OTP code to continue') }}</p>
    </div>
    <form action="{{ route('admin.2fa.verify') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">{{ d_trans('OTP Code') }} </label>
            <input type="text" name="otp_code" class="form-control form-control-md input-numeric" placeholder="• • • • • •"
                maxlength="6" required>
        </div>
        <button class="btn btn-primary btn-md d-block w-100">{{ d_trans('Continue') }}</button>
    </form>
@endsection
