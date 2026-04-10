@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('section', d_trans('Settings'))
@section('title', d_trans('KYC'))
@section('header_title', d_trans('KYC Settings'))
@section('back', route('admin.settings.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.settings.kyc.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ d_trans('Actions') }}</div>
                    <div class="card-body p-4">
                        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 g-3">
                            @foreach (config('settings.kyc.actions') as $key => $value)
                                <div class="col">
                                    <label class="form-label">
                                        {{ d_trans(ucfirst(str_replace('_', ' ', $key))) }}</label>
                                    <input type="checkbox" name="kyc[actions][{{ $key }}]" data-toggle="toggle"
                                        data-height="40px" data-on="{{ d_trans('Enabled') }}" @checked($value)>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">{{ d_trans('Media') }}</div>
                    <div class="card-body p-4">
                        <div class="row row-cols-1 row-cols-lg-2 g-3">
                            @foreach (config('settings.kyc.media') as $key => $value)
                                <div class="col">
                                    <x-admin.image-uploader version="v1"
                                        label="{{ d_trans(ucfirst(str_replace('_', ' ', $key))) }}"
                                        name="kyc[media][{{ $key }}]" src="{{ asset($value) }}" width="200px"
                                        accept=".png,.jpg,.jpeg,.svg" />
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
