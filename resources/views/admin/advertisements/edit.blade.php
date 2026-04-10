@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Advertisements'))
@section('title', d_trans('Edit Advertisement'))
@section('header_title', d_trans('Edit Advertisement'))
@section('back', route('admin.advertisements.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.advertisements.update', $advertisement->id) }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><strong>{{ d_trans($advertisement->position) }}</strong> {!! $advertisement->size ? '- (' . $advertisement->size . ')' : '' !!}</span>
                <span class="col-3">
                    <input type="checkbox" name="status" data-toggle="toggle" @checked($advertisement->isActive())>
                </span>
            </div>
            <div class="card-body">
                <div class="mb-0">
                    <textarea id="html-editor" name="code" class="form-control" rows="10">{{ demo($advertisement->code) }}</textarea>
                </div>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/codemirror/codemirror.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/codemirror/monokai.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/codemirror/codemirror.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/codemirror/htmlmixed.js') }}"></script>
        <script src="{{ asset('vendor/libs/codemirror/xml.js') }}"></script>
        <script src="{{ asset('vendor/libs/codemirror/javascript.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/codemirror/sublime.min.js') }}"></script>
    @endpush
@endsection
