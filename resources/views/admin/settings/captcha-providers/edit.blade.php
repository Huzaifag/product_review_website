@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Settings'))
@section('title', d_trans('Captcha Providers'))
@section('header_title', d_trans('Edit Captcha Provider'))
@section('back', route('admin.settings.captcha-providers.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.settings.captcha-providers.update', $captchaProvider->id) }}"
        method="POST">
        @csrf
        @method('PUT')
        <div class="card mb-4">
            <div class="card-body p-4">
                <x-admin.image-uploader class="mb-4" :upload=false src="{{ $captchaProvider->getLogoLink() }}" width="100px"
                    height="100px" />
                <div class="row g-4 mb-2">
                    <div class="col-lg-6">
                        <label class="form-label">{{ d_trans('Name') }} </label>
                        <input class="form-control form-control-md" value="{{ d_trans($captchaProvider->name) }}" disabled>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label">{{ d_trans('Status') }} </label>
                        <input type="checkbox" name="status" data-toggle="toggle" data-height="45px"
                            @checked($captchaProvider->isActive())>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">{{ d_trans('Credentials') }}</div>
            <div class="card-body p-4">
                <div class="row g-3 mb-2">
                    @foreach ($captchaProvider->credentials as $key => $value)
                        <div class="col-lg-12">
                            <label class="form-label capitalize">
                                {{ d_trans(str_replace('_', ' ', $key)) }}
                            </label>
                            <input type="text" name="credentials[{{ $key }}]" value="{{ demo($value) }}"
                                class="form-control form-control-md">
                        </div>
                    @endforeach
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
