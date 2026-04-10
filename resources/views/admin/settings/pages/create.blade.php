@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Settings'))
@section('title', d_trans('Pages'))
@section('header_title', d_trans('New Page'))
@section('back', route('admin.settings.pages.index'))
@section('form', true)
@section('content')
    <form id="submittedForm" action="{{ route('admin.settings.pages.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card h-100 p-2">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ d_trans('Title') }} </label>
                            <input id="slugTitle" type="text" name="title" class="form-control form-control-md"
                                value="{{ old('title') }}" data-url="{{ route('admin.settings.pages.slug') }}" required
                                autofocus />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ d_trans('Slug') }} </label>
                            <input id="slugInput" type="text" name="slug" class="form-control form-control-md"
                                value="{{ old('slug') }}" required />
                        </div>
                        <div class="editor-lg mb-2">
                            <label class="form-label">{{ d_trans('Body') }} </label>
                            <textarea name="body" class="editor">{{ old('body') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ d_trans('Description (Optional)') }} </label>
                            <textarea name="description" rows="6" class="form-control form-control-md">{{ old('description') }}</textarea>
                        </div>
                        <div>
                            <label class="form-label">{{ d_trans('Keywords (Optional)') }}</label>
                            <div class="tagsinput tagsinput-md">
                                <input type="text" name="keywords" class="form-control form-control-md tags-input"
                                    value="{{ old('keywords') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/nicEdit/nicEdit.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.js') }}"></script>
    @endpush
@endsection
