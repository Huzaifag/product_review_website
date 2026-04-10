@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Categories'))
@section('title', d_trans('Sub Sub Categories'))
@section('header_title', d_trans('Edit Sub Sub Category'))
@section('back', route('admin.categories.sub-sub-categories.index'))
@section('form', true)
@section('content')
    <div class="mb-3">
        <a class="btn btn-outline-secondary px-3" href="{{ $subSubCategory->getLink() }}" target="_blank"><i
                class="fa-solid fa-arrow-up-right-from-square me-2"></i>{{ d_trans('Preview') }}</a>
    </div>
    <div class="card">
        <div class="card-body p-4">
            <form id="submittedForm" action="{{ route('admin.categories.sub-sub-categories.update', $subSubCategory->id) }}"
                method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Sub Category') }} </label>
                        <select class="form-select form-select-md" disabled>
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" @selected($subCategory->id == $subSubCategory->subCategory->id)>
                                    {{ $subCategory->trans->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Name') }} </label>
                        <input type="text" name="name" class="form-control form-control-md"
                            value="{{ $subSubCategory->name }}" required />
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Slug') }} </label>
                        <input type="text" name="slug" class="form-control form-control-md"
                            value="{{ $subSubCategory->slug }}" required />
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Title (Optional)') }} </label>
                        <input type="text" name="title" class="form-control form-control-md"
                            value="{{ $subSubCategory->title }}" />
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Description (Optional)') }} </label>
                        <textarea name="description" class="form-control" rows="6">{{ $subSubCategory->description }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Keywords (Optional)') }}</label>
                        <div class="tagsinput tagsinput-md">
                            <input type="text" name="keywords" class="form-control form-control-md tags-input"
                                value="{{ $subSubCategory->keywords }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.js') }}"></script>
    @endpush
@endsection
