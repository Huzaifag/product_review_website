@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Settings'))
@section('title', d_trans('Languages'))
@section('header_title', d_trans('Edit Language'))
@section('back', route('admin.settings.languages.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.settings.languages.update', $language->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body p-4">
                <div class="row g-4 mb-2">
                    <div class="col-12">
                        <x-admin.image-uploader name="logo" label="{{ d_trans('Choose Logo') }}"
                            src="{{ $language->getLogoLink() }}" width="60px" height="60px" />
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Name') }} </label>
                        <input type="text" name="name" class="form-control form-control-md"
                            value="{{ $language->name }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Code') }} </label>
                        <select class="form-select form-select-md" disabled>
                            @foreach (\App\Models\Language::getAvailableLanguages() as $code => $name)
                                <option value="{{ $code }}" @selected($language->code == $code)>
                                    {{ $name }} ({{ $code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Direction') }} </label>
                        <select name="direction" class="form-select form-select-md" required>
                            @foreach (\App\Models\Language::getAvailableDirections() as $key => $value)
                                <option value="{{ $key }}" @selected($language->direction == $key)>
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
