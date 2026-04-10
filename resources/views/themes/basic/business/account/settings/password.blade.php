@extends('themes.basic.business.layouts.app')
@section('hide_alerts', true)
@section('title', d_trans('Account Settings'))
@section('header_title', d_trans('Account Settings'))
@section('breadcrumbs', Breadcrumbs::render('business.account.settings'))
@section('content')
    <div class="settings-box">
        @include('themes.basic.business.account.settings.includes.sidebar')
        <div class="settings-content">
            <div class="settings-content-header">
                <h5 class="settings-content-title">{{ d_trans('Change Password') }}</h5>
            </div>
            <div class="settings-content-body">
                <form action="{{ route('business.account.settings.password.update') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">{{ d_trans('Password') }}</label>
                            <input type="password" class="form-control form-control-md" name="current_password" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ d_trans('New Password') }}</label>
                            <input type="password" class="form-control form-control-md" name="new_password" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">{{ d_trans('Confirm New Password') }}</label>
                            <input type="password" class="form-control form-control-md" name="new_password_confirmation"
                                required>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary btn-md">{{ d_trans('Save Changes') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
