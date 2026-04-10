@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('section', d_trans('System'))
@section('title', d_trans('Maintenance'))
@section('header_title', d_trans('System Maintenance'))
@section('back', route('admin.system.index'))
@section('form', true)
@section('content')
    <div class="note note-warning mb-4">
        <strong>{{ d_trans('Note!') }}</strong>
        <span>{{ d_trans('As an admin, you can still view and control your website but the visitors will redirect to the maintenance page.') }}</span>
    </div>
    <form id="submittedForm" action="{{ route('admin.system.maintenance.update') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body p-4">
                <div class="row g-4 mb-2">
                    <div class="col-12">
                        <div class="col-lg-3">
                            <label class="form-label">{{ d_trans('Status') }}</label>
                            <input type="checkbox" name="maintenance[status]" data-toggle="toggle" data-height="40px"
                                {{ config('settings.maintenance.status') ? 'checked' : '' }}>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Title') }}</label>
                        <input name="maintenance[title]" class="form-control form-control-md"
                            value="{{ config('settings.maintenance.title') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Body') }}</label>
                        <textarea name="maintenance[body]" class="editor"">{{ config('settings.maintenance.body') }}</textarea>
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
        <script src="{{ asset('vendor/libs/nicEdit/nicEdit.min.js') }}"></script>
    @endpush
@endsection
