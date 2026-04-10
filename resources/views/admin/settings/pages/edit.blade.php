@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Settings'))
@section('title', d_trans('Pages'))
@section('header_title', d_trans('Edit Page'))
@section('back', route('admin.settings.pages.index'))
@section('form', true)
@section('content')
    <div class="mb-3">
        <a class="btn btn-outline-secondary px-3" href="{{ $page->getLink() }}" target="_blank"><i
                class="fa-solid fa-arrow-up-right-from-square me-2"></i>{{ d_trans('Preview') }}</a>
    </div>
    <form id="submittedForm" action="{{ route('admin.settings.pages.update', $page->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card h-100 p-2">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ d_trans('Title') }} </label>
                            <input type="text" name="title" class="form-control form-control-md"
                                value="{{ $page->title }}" data-url="{{ route('admin.settings.pages.slug') }}" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ d_trans('Slug') }} </label>
                            <input type="text" name="slug" class="form-control form-control-md"
                                value="{{ $page->slug }}" required />
                        </div>
                        <div class="editor-lg mb-2">
                            <label class="form-label">{{ d_trans('Body') }} </label>
                            <textarea name="body" class="editor">{{ $page->body }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">{{ d_trans('Description (Optional)') }} </label>
                            <textarea name="description" rows="6" class="form-control form-control-md">{{ $page->description }}</textarea>
                        </div>
                        <div>
                            <label class="form-label">{{ d_trans('Keywords (Optional)') }}</label>
                            <div class="tagsinput tagsinput-md">
                                <input type="text" name="keywords" class="form-control form-control-md tags-input"
                                    value="{{ $page->keywords }}">
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
