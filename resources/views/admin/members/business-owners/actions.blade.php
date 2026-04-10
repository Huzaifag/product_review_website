@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Members'))
@section('title', d_trans('Business Owners'))
@section('header_title', d_trans('Edit Business Owner :name', ['name' => $owner->getName()]))
@section('back', route('admin.members.business-owners.index'))
@section('content')
    @include('admin.members.business-owners.includes.widgets')
    <div class="settings-box v2">
        @include('admin.members.business-owners.includes.sidebar')
        <div class="settings-content">
            <div class="settings-card">
                <div class="settings-card-header">
                    <h5 class="settings-card-title">{{ d_trans('Actions') }}</h5>
                </div>
                <div class="settings-card-body">
                    <form action="{{ route('admin.members.business-owners.actions.update', $owner->id) }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="row row-cols-1 row-cols-lg-2 g-3">
                                    <div class="col">
                                        <label class="form-label">{{ d_trans('Account status') }} </label>
                                        <input type="checkbox" name="status" data-toggle="toggle"
                                            data-on="{{ d_trans('Active') }}" data-off="{{ d_trans('Banned') }}"
                                            @checked($owner->isActive())>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">{{ d_trans('Email status') }} </label>
                                        <input type="checkbox" name="email_status" data-toggle="toggle"
                                            data-on="{{ d_trans('Verified') }}" data-off="{{ d_trans('Unverified') }}"
                                            @checked($owner->isEmailVerified())>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">{{ d_trans('KYC Status') }} </label>
                                        <input type="checkbox" name="kyc_status" data-toggle="toggle"
                                            @checked($owner->hasKycVerified())>
                                    </div>
                                    <div class="col">
                                        <label class="form-label">{{ d_trans('Two-Factor Authentication') }} </label>
                                        <input id="2faCheckbox" type="checkbox" name="two_factor_status"
                                            data-toggle="toggle" @checked($owner->isTwoFactorActive())>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary btn-md">{{ d_trans('Save Changes') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
    @endpush
@endsection
