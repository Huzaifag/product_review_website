@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Settings'))
@section('title', d_trans('SMTP'))
@section('header_title', d_trans('SMTP Settings'))
@section('back', route('admin.settings.index'))
@section('form', true)
@section('content')
    <div class="card">
        <form id="submittedForm" action="{{ route('admin.settings.smtp.update') }}" method="POST">
            @csrf
            <div class="card-header">{{ d_trans('SMTP Details') }}</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ d_trans('Status') }}</strong></label>
                        </div>
                        <div class="col">
                            <div class="col-lg-3">
                                <input type="checkbox" name="smtp[status]" data-toggle="toggle" data-height="40px"
                                    @checked(config('settings.smtp.status'))>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ d_trans('Mail mailer') }}</strong></label>
                        </div>
                        <div class="col">
                            <select name="smtp[mailer]" class="form-select form-select-md">
                                <option value="smtp" @selected(config('settings.smtp.mailer') == 'smtp')>
                                    {{ d_trans('SMTP') }}
                                </option>
                                <option value="sendmail" @selected(config('settings.smtp.mailer') == 'sendmail')>
                                    {{ d_trans('SENDMAIL') }}
                                </option>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ d_trans('Mail Host') }}</strong></label>
                        </div>
                        <div class="col">
                            <input type="text" name="smtp[host]" class="remove-spaces form-control form-control-md"
                                value="{{ demo(config('settings.smtp.host')) }}"
                                placeholder="{{ d_trans('Enter mail host') }}">
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ d_trans('Mail Port') }}</strong></label>
                        </div>
                        <div class="col">
                            <input type="text" name="smtp[port]" class="remove-spaces form-control form-control-md"
                                value="{{ demo(config('settings.smtp.port')) }}"
                                placeholder="{{ d_trans('Enter mail port') }}">
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ d_trans('Mail username') }}</strong></label>
                        </div>
                        <div class="col">
                            <input type="text" name="smtp[username]" class="form-control form-control-md remove-spaces"
                                value="{{ demo(config('settings.smtp.username')) }}"
                                placeholder="{{ d_trans('Enter username') }}">
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ d_trans('Mail password') }}</strong></label>
                        </div>
                        <div class="col">
                            <input type="password" name="smtp[password]" class="form-control form-control-md"
                                value="{{ demo(config('settings.smtp.password')) }}"
                                placeholder="{{ d_trans('Enter password') }}">
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ d_trans('Mail encryption') }}</strong></label>
                        </div>
                        <div class="col">
                            <select name="smtp[encryption]" class="form-select form-select-md">
                                <option value="tls" @selected(config('settings.smtp.encryption') == 'tls')>
                                    {{ d_trans('TLS') }}
                                </option>
                                <option value="ssl" @selected(config('settings.smtp.encryption') == 'ssl')>
                                    {{ d_trans('SSL') }}
                                </option>
                            </select>
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ d_trans('From email') }}</strong></label>
                        </div>
                        <div class="col">
                            <input type="text" name="smtp[from_email]" class="remove-spaces form-control form-control-md"
                                value="{{ demo(config('settings.smtp.from_email')) }}"
                                placeholder="{{ d_trans('Enter from email') }}">
                        </div>
                    </div>
                </li>
                <li class="list-group-item p-4">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-2">
                            <label class="col-form-label"><strong>{{ d_trans('From name') }}</strong></label>
                        </div>
                        <div class="col">
                            <input type="text" name="smtp[from_name]" class="form-control form-control-md"
                                value="{{ demo(config('settings.smtp.from_name')) }}"
                                placeholder="{{ d_trans('Enter from name') }}">
                        </div>
                    </div>
                </li>
            </ul>
        </form>
    </div>
    @if (config('settings.smtp.status'))
        <div class="card mt-3">
            <div class="card-header">{{ d_trans('Testing') }}</div>
            <div class="card-body p-4">
                <form action="{{ route('admin.settings.smtp.test') }}" method="POST">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-lg-auto">
                            <label class="col-form-label"><strong>{{ d_trans('Email Address') }}</strong></label>
                        </div>
                        <div class="col">
                            <input type="email" name="email" class="form-control form-control-md"
                                placeholder="john@example.com" value="{{ authAdmin()->email }}">
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-primary btn-md">{{ d_trans('Send') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
    @endpush
@endsection
