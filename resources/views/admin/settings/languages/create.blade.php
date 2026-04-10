@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Settings'))
@section('title', d_trans('Languages'))
@section('header_title', d_trans('New Language'))
@section('back', route('admin.settings.languages.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.settings.languages.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body p-4">
                <div class="row g-4 mb-2">
                    <div class="col-12">
                        <x-admin.image-uploader name="logo" label="{{ d_trans('Choose Logo') }}" :required=true
                            width="60px" height="60px" />
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Name') }} </label>
                        <input type="text" name="name" class="form-control form-control-md"
                            value="{{ old('name') }}" required autofocus>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Code') }} </label>
                        <select name="code" class="selectpicker selectpicker-md" data-live-search="true" title="--"
                            required>
                            @foreach (\App\Models\Language::getAvailableLanguages() as $code => $name)
                                <option value="{{ $code }}" @selected(old('code') == $code)>
                                    {{ $name }} ({{ $code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Direction') }} </label>
                        <select name="direction" class="selectpicker selectpicker-md" data-live-search="true" title="--"
                            required>
                            @foreach (\App\Models\Language::getAvailableDirections() as $key => $value)
                                <option value="{{ $key }}" @selected(old('direction') == $key)>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
