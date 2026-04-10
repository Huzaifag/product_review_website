@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('section', d_trans('Settings'))
@section('title', d_trans('Business'))
@section('header_title', d_trans('Business Settings'))
@section('back', route('admin.settings.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.settings.business.update') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ d_trans('Actions') }}</div>
                    <div class="card-body p-4">
                        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3 g-3">
                            @foreach (config('settings.business.actions') as $key => $value)
                                <div class="col">
                                    <label class="form-label">
                                        {{ d_trans(ucfirst(str_replace('_', ' ', $key))) }}</label>
                                    <input type="checkbox" name="business[actions][{{ $key }}]"
                                        data-toggle="toggle" data-height="40px" data-on="{{ d_trans('Enabled') }}"
                                        @checked($value)>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ d_trans('Default Settings') }}</div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Total Businesses') }}</label>
                                <input type="number" name="business[default][businesses]"
                                    class="form-control form-control-md" placeholder="0"
                                    value="{{ config('settings.business.default.businesses') }}">
                                <div class="form-text">{{ d_trans('Leave the field empty for unlimited businesses.') }}
                                </div>
                            </div>
                            <div class="col-12 col-lg">
                                <label class="form-label">{{ d_trans('Employees') }}</label>
                                <input type="checkbox" name="business[default][employees]" data-toggle="toggle"
                                    data-height="40px" data-on="{{ d_trans('Enabled') }}" @checked(config('settings.business.default.employees'))>
                            </div>
                            <div class="col-12 col-lg">
                                <label class="form-label">{{ d_trans('Categories') }}</label>
                                <input type="checkbox" name="business[default][categories]" data-toggle="toggle"
                                    data-height="40px" data-on="{{ d_trans('Enabled') }}" @checked(config('settings.business.default.categories'))>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ d_trans('Trending And Best Rating') }}</div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Trending Businesses Number') }}</label>
                                <input type="number" class="form-control" name="business[trending_number]" min="1"
                                    value="{{ config('settings.business.trending_number') }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Best Rating Businesses Number') }}</label>
                                <input type="number" class="form-control" name="business[best_rating_number]"
                                    min="1" value="{{ config('settings.business.best_rating_number') }}" required>
                            </div>
                        </div>
                        @if (!config('settings.cronjob.last_execution'))
                            <div class="alert alert-warning mb-0 mt-3">
                                <i class="fa-regular fa-circle-question me-1"></i>
                                <span>{{ d_trans('You must setup the cron job to refresh the businesses every 24 hours.') }}</span>
                                <a href="{{ route('admin.system.cronjob.index') }}">{{ d_trans('Setup Cron Job') }}<i
                                        class="fa-solid fa-arrow-right icon-rtl ms-2"></i></a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ d_trans('Media') }}</div>
                    <div class="card-body p-4">
                        <div class="row row-cols-1 g-3">
                            @foreach (config('settings.business.media') as $key => $value)
                                <div class="col">
                                    <x-admin.image-uploader version="v1"
                                        label="{{ d_trans(ucfirst(str_replace('_', ' ', $key))) }}"
                                        name="business[media][{{ $key }}]" src="{{ asset($value) }}"
                                        width="150px" height="150px" accept=".png,.jpg,.jpeg,.webp" />
                                </div>
                            @endforeach
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
