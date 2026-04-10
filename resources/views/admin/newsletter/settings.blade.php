@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Newsletter'))
@section('title', d_trans('Settings'))
@section('header_title', d_trans('Newsletter Settings'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.newsletter.settings.update') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">{{ d_trans('Actions') }}</div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-lg-6">
                        <label class="form-label">{{ d_trans('Newsletter Status') }}</label>
                        <input type="checkbox" name="newsletter[status]" data-toggle="toggle" @checked(config('settings.newsletter.status'))
                            data-height="40px">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ d_trans('Show Popup') }}</label>
                        <input type="checkbox" name="newsletter[popup_status]" data-toggle="toggle"
                            data-on="{{ d_trans('Yes') }}" data-off="{{ d_trans('No') }}" @checked(config('settings.newsletter.popup_status'))
                            data-height="40px">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ d_trans('Show Form In Footer') }}</label>
                        <input type="checkbox" name="newsletter[footer_status]" data-toggle="toggle"
                            data-on="{{ d_trans('Yes') }}" data-off="{{ d_trans('No') }}" @checked(config('settings.newsletter.footer_status'))
                            data-height="40px">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ d_trans('Register New Users') }}</label>
                        <input type="checkbox" name="newsletter[register_new_users]" data-toggle="toggle"
                            data-on="{{ d_trans('Yes') }}" data-off="{{ d_trans('No') }}" @checked(config('settings.newsletter.register_new_users'))
                            data-height="40px">
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">{{ d_trans('Popup') }}</div>
            <div class="card-body p-4">
                <div class="row g-3 mb-2">
                    <div class="col-12">
                        <x-admin.image-uploader version="v1" label="{{ d_trans('PopUp Image') }}"
                            name="newsletter[popup_image]" src="{{ asset(config('settings.newsletter.popup_image')) }}"
                            width="250px" height="150px" />
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('PopUp Reminder After') }}</label>
                        <div class="input-group input-group-md">
                            <input type="number" name="newsletter[popup_reminder_time]"
                                class="form-control form-control-md"
                                value="{{ config('settings.newsletter.popup_reminder_time') }}">
                            <span class="input-group-text ">{{ d_trans('Hours') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
    @endpush
@endsection
