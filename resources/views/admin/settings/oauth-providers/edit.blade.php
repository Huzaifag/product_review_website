@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Settings'))
@section('title', d_trans('Captcha Providers'))
@section('header_title', d_trans('Edit Captcha Provider'))
@section('back', route('admin.settings.oauth-providers.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.settings.oauth-providers.update', $oauthProvider->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-4">
                        <x-admin.image-uploader class="mb-4" :upload=false src="{{ $oauthProvider->getLogoLink() }}"
                            width="100px" height="100px" />
                        <div class="row g-4 mb-2">
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Name') }} </label>
                                <input class="form-control form-control-md" value="{{ d_trans($oauthProvider->name) }}"
                                    disabled>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">{{ d_trans('Status') }} </label>
                                <input type="checkbox" name="status" data-toggle="toggle" data-height="45px"
                                    @checked($oauthProvider->isActive())>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($oauthProvider->parameters)
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">{{ d_trans('Parameters') }}</div>
                        <div class="card-body p-4">
                            <div class="row g-3 mb-2">
                                @foreach ($oauthProvider->parameters as $key => $parameter)
                                    <div class="col-lg-12">
                                        <label class="form-label capitalize">{{ d_trans($parameter->label) }}</label>
                                        @if ($parameter->type == 'route')
                                            <div class="input-group">
                                                <input id="input-link-{{ $key }}" type="text"
                                                    value="{{ url($parameter->content) }}"
                                                    class="form-control form-control-md" readonly>
                                                <button type="button" class="btn btn-soft px-3 btn-copy"
                                                    data-clipboard-target="#input-link-{{ $key }}"><i
                                                        class="far fa-clone"></i></button>
                                            </div>
                                        @else
                                            <div class="input-group">
                                                <input id="input-text-{{ $key }}" type="text"
                                                    value="{{ $parameter->content }}" class="form-control form-control-md"
                                                    readonly>
                                                <button type="button" class="btn btn-soft px-3 btn-copy"
                                                    data-clipboard-target="#input-text-{{ $key }}"><i
                                                        class="far fa-clone"></i></button>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ d_trans('Credentials') }}</div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-2">
                            @foreach ($oauthProvider->credentials as $key => $value)
                                <div class="col-lg-12">
                                    <label class="form-label capitalize">
                                        {{ d_trans(str_replace('_', ' ', $key)) }}
                                    </label>
                                    <input type="text" name="credentials[{{ $key }}]"
                                        value="{{ demo($value) }}" class="form-control form-control-md">
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
        <script src="{{ asset('vendor/libs/clipboard/clipboard.min.js') }}"></script>
    @endpush
@endsection
