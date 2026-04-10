@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('section', d_trans('Sections'))
@section('title', d_trans('Home Sections'))
@section('header_title', d_trans('New Home Section'))
@section('back', route('admin.sections.home-sections.index'))
@section('form', true)
@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form id="submittedForm" action="{{ route('admin.sections.home-sections.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <div class="col-lg-3">
                            <label class="form-label">{{ d_trans('Status') }}</label>
                            <input type="checkbox" name="status" data-toggle="toggle" data-height="40" checked>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Name') }}</label>
                        <input type="text" name="name" class="form-control form-control-md"
                            value="{{ old('name') }}" required />
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Description') }}</label>
                        <textarea name="description" class="form-control" rows="7">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Load content from') }}</label>
                        <div class="bg-light border rounded-3 p-4">
                            <div class="row g-2">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="content_from" value="category"
                                            id="radio1" @checked(old('content_from') == 'category')>
                                        <label class="form-check-label" for="radio1">{{ d_trans('Category') }}</label>
                                    </div>
                                </div>
                                <div id="category"
                                    class="col-12 category-select {{ old('content_from') != 'category' ? 'd-none' : '' }}">
                                    <select name="category" class="selectpicker selectpicker-md"
                                        title="{{ d_trans('Choose') }}" data-live-search="true">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected($category->id == old('category'))>
                                                {{ $category->trans->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="content_from"
                                            value="sub_category" id="radio2" @checked(old('content_from') == 'sub_category')>
                                        <label class="form-check-label"
                                            for="radio2">{{ d_trans('Sub Category') }}</label>
                                    </div>
                                </div>
                                <div id="sub_category"
                                    class="col-12 category-select {{ old('content_from') != 'sub_category' ? 'd-none' : '' }}">
                                    <select name="sub_category" class="selectpicker selectpicker-md"
                                        title="{{ d_trans('Choose') }}" data-live-search="true">
                                        @foreach ($subCategories as $subCategory)
                                            <option value="{{ $subCategory->id }}" @selected($subCategory->id == old('sub_category'))>
                                                {{ $subCategory->trans->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="content_from"
                                            value="sub_sub_category" id="radio3" @checked(old('content_from') == 'sub_sub_category')>
                                        <label class="form-check-label"
                                            for="radio3">{{ d_trans('Sub Sub Category') }}</label>
                                    </div>
                                </div>
                                <div id="sub_sub_category"
                                    class="col-12 category-select {{ old('content_from') != 'sub_sub_category' ? 'd-none' : '' }}">
                                    <select name="sub_sub_category" class="selectpicker selectpicker-md"
                                        title="{{ d_trans('Choose') }}" data-live-search="true">
                                        @foreach ($subSubCategories as $subSubCategory)
                                            <option value="{{ $subSubCategory->id }}" @selected($subSubCategory->id == old('sub_sub_category'))>
                                                {{ $subSubCategory->trans->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Items Number') }}</label>
                        <input type="number" name="items_number" class="form-control form-control-md" min="1"
                            max="100" value="{{ old('items_number') }}" required>
                        <div class="form-text">{{ d_trans('Between 1 to 100 maximum') }}</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Cache Expiry time') }}</label>
                        <div class="input-group">
                            <input type="number" class="form-control form-control-md" name="cache_expiry_time"
                                min="1" max="525600" value="{{ old('cache_expiry_time') }}" required>
                            <span class="input-group-text">
                                <i class="fa-regular fa-clock me-2"></i>{{ d_trans('Minutes') }}</span>
                        </div>
                        <div class="form-text">{{ d_trans('From 1 to 525600 minutes') }}</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/toggle-master/bootstrap-toggle.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
    @push('scripts')
        <script>
            "use strict";
            let categoryRadio = $('input[name=content_from]');
            categoryRadio.on('click', function() {
                let value = $(this).attr('value'),
                    categorySelect = $('.category-select');
                categorySelect.addClass('d-none');
                $('#' + value).removeClass('d-none');
            });
        </script>
    @endpush
@endsection
