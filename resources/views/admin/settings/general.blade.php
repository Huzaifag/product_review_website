@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('section', d_trans('Settings'))
@section('title', d_trans('General'))
@section('header_title', d_trans('General Settings'))
@section('back', route('admin.settings.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.settings.general.update') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ d_trans('General Details') }}</div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-2">
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Site Name') }}</label>
                                <input type="text" name="general[site_name]" class="form-control form-control-md"
                                    value="{{ m_trans(config('settings.general.site_name')) }}" required>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Site URL') }}</label>
                                <input type="text" name="general[site_url]" class="form-control form-control-md"
                                    value="{{ config('settings.general.site_url') }}" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Contact Email') }}</label>
                                <input type="text" name="general[contact_email]" class="form-control form-control-md"
                                    value="{{ config('settings.general.contact_email') }}">
                                <div class="form-text">
                                    {{ d_trans('This email is required to receive emails from contact page') }}
                                    <a href="{{ route('contact') }}" target="_blank">{{ route('contact') }}</a>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label">{{ d_trans('Date format') }}</label>
                                <select name="general[date_format]" class="selectpicker selectpicker-md"
                                    data-live-search="true" title="{{ d_trans('Date format') }}">
                                    @foreach (\App\Models\Setting::getAvailableDateFormats() as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $key == config('settings.general.date_format') ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::now()->format($value) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label">{{ d_trans('Timezone') }}</label>
                                <select name="general[timezone]" class="selectpicker selectpicker-md"
                                    data-live-search="true" title="{{ d_trans('Timezone') }}">
                                    @foreach (\App\Models\Setting::getAvailableTimezones() as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $key == config('settings.general.timezone') ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ d_trans('SEO Details (Optional)') }}</div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Home title') }}</label>
                                <input type="text" name="seo[title]" class="form-control form-control-md"
                                    value="{{ config('settings.seo.title') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Description') }}</label>
                                <textarea name="seo[description]" class="form-control" rows="3">{{ config('settings.seo.description') }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Keywords') }}</label>
                                <div class="tagsinput tagsinput-md">
                                    <input type="text" name="seo[keywords]"
                                        class="form-control form-control-md tags-input"
                                        value="{{ config('settings.seo.keywords') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ d_trans('Links') }}</div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            @foreach (config('settings.links') as $key => $link)
                                <div class="col-lg-6">
                                    <label class="form-label">
                                        {{ d_trans(ucfirst(str_replace('_', ' ', $key))) }}</label>
                                    <input type="text" name="links[{{ $key }}]"
                                        class="form-control form-control-md" value="{{ $link }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ d_trans('Social Media Links') }}</div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            @foreach (config('settings.social_links') as $key => $socialLink)
                                <div class="col-lg-4">
                                    <label class="form-label">
                                        {{ d_trans(ucfirst(str_replace('_', ' ', $key))) }}</label>
                                    <input type="text" name="social_links[{{ $key }}]"
                                        class="form-control form-control-md" value="{{ $socialLink }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ d_trans('Actions') }}</div>
                    <div class="card-body p-4">
                        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 g-3">
                            @foreach (config('settings.actions') as $key => $value)
                                <div class="col">
                                    <label class="form-label">
                                        {{ d_trans(ucfirst(str_replace('_', ' ', $key))) }}</label>
                                    <input type="checkbox" name="actions[{{ $key }}]" data-toggle="toggle"
                                        data-height="40px" @checked($value)>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.js') }}"></script>
    @endpush
@endsection
