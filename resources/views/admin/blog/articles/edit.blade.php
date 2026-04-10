@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Blog'))
@section('title', d_trans('Articles'))
@section('header_title', d_trans('Edit Blog Article'))
@section('back', route('admin.blog.articles.index'))
@section('form', true)
@section('content')
    <div class="mb-3">
        <a class="btn btn-outline-secondary px-3" href="{{ $article->getLink() }}" target="_blank"><i
                class="fa-solid fa-arrow-up-right-from-square me-2"></i>{{ d_trans('Preview') }}</a>
    </div>
    <form id="submittedForm" action="{{ route('admin.blog.articles.update', $article->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Title') }} </label>
                                <input id="slugTitle" type="text" name="title" class="form-control form-control-md"
                                    value="{{ $article->title }}" data-url="{{ route('admin.blog.articles.slug') }}"
                                    required autofocus />
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Slug') }} </label>
                                <input id="slugInput" type="text" name="slug" class="form-control form-control-md"
                                    value="{{ $article->slug }}" required />
                            </div>
                            <div class="col-12 ckeditor-lg">
                                <label class="form-label">{{ d_trans('Body') }} </label>
                                <textarea name="body" class="editor">{{ $article->body }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <x-admin.image-uploader src="{{ $article->getImageLink() }}" />
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Category') }} </label>
                                <select id="articleCategories" name="category" class="selectpicker selectpicker-md"
                                    data-live-search="true" title="{{ d_trans('Category') }}" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected($category->id == $article->category->id)>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Description') }} </label>
                                <textarea name="description" rows="6" class="form-control form-control-md" required>{{ $article->description }}</textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Keywords (Optional)') }}</label>
                                <div class="tagsinput tagsinput-md">
                                    <input type="text" name="keywords" class="form-control form-control-md tags-input"
                                        value="{{ $article->keywords }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/nicEdit/nicEdit.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.js') }}"></script>
    @endpush
@endsection
