@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Settings'))
@section('title', d_trans('Subscription'))
@section('header_title', d_trans('Subscription Settings'))
@section('back', route('admin.settings.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.settings.subscription.update') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="col-lg-4">
                                    <label class="form-label">{{ d_trans('Status') }}</label>
                                    <input type="checkbox" name="subscription[status]" data-toggle="toggle"
                                        data-height="40px" @checked(config('settings.subscription.status'))>
                                </div>
                            </div>
                            @if (config('settings.subscription.status'))
                                <div class="col-12">
                                    <label class="form-label">{{ d_trans('Before expiring reminder days') }}</label>
                                    <div class="input-group">
                                        <input type="number" name="subscription[before_expiring_reminder_days]"
                                            class="form-control form-control-md" placeholder="0"
                                            value="{{ config('settings.subscription.before_expiring_reminder_days') }}"
                                            required>
                                        <span class="input-group-text fs-6">{{ d_trans('Days') }}</span>
                                    </div>
                                    <div class="form-text">
                                        {{ d_trans('Number of days before expiration to send a reminder.') }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{ d_trans('After expiring reminder days') }}</label>
                                    <div class="input-group">
                                        <input type="number" name="subscription[after_expiring_reminder_days]"
                                            class="form-control form-control-md" placeholder="0"
                                            value="{{ config('settings.subscription.after_expiring_reminder_days') }}"
                                            required>
                                        <span class="input-group-text fs-6">{{ d_trans('Days') }}</span>
                                    </div>
                                    <div class="form-text">
                                        {{ d_trans('Number of days after expiration to send a follow-up reminder.') }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">{{ d_trans('After expiring data delete days') }}</label>
                                    <div class="input-group">
                                        <input type="number" name="subscription[data_delete_days]"
                                            class="form-control form-control-md" placeholder="0"
                                            value="{{ config('settings.subscription.data_delete_days') }}" required>
                                        <span class="input-group-text fs-6">{{ d_trans('Days') }}</span>
                                    </div>
                                    <div class="form-text">
                                        {{ d_trans('Number of days after expiration to automatically delete the data.') }}
                                    </div>
                                </div>
                            @endif
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
