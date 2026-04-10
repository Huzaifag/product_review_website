@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('section', d_trans('System'))
@section('title', d_trans('Admin Panel Style'))
@section('header_title', d_trans('Admin Panel Style'))
@section('back', route('admin.system.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.system.admin-panel-style.update') }}" method="POST">
        @csrf
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">{{ d_trans('Colors') }}</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    @foreach (config('settings.admin.colors') as $key => $value)
                        <div class="col-lg-6 col-xl-4">
                            <label class="form-label"> {{ d_trans(ucfirst(str_replace('_', ' ', $key))) }}</label>
                            <div class="colorpicker">
                                <input type="text" name="admin[colors][{{ $key }}]"
                                    class="form-control form-control-md coloris" value="{{ $value }}" required>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">{{ d_trans('Custom CSS') }}</h5>
            </div>
            <div class="card-body p-0">
                <textarea name="custom_css" id="css-editor">{{ $customCssFile }}</textarea>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/coloris/coloris.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/codemirror/codemirror.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/codemirror/monokai.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/coloris/coloris.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/codemirror/codemirror.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/codemirror/css.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/codemirror/sublime.min.js') }}"></script>
    @endpush
@endsection
