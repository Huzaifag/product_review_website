@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Categories'))
@section('title', d_trans('Main Categories'))
@section('header_title', d_trans('New Main Category'))
@section('back', route('admin.categories.index'))
@section('form', true)
@section('content')
    <div class="card">
        <div class="card-body p-4">
            <form id="submittedForm" action="{{ route('admin.categories.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <x-admin.image-uploader width="100px" height="100px" :required=true />
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Name') }} </label>
                        <input id="slugTitle" type="text" name="name" class="form-control form-control-md"
                            value="{{ old('name') }}" data-url="{{ route('admin.categories.slug') }}" required
                            autofocus />
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Slug') }} </label>
                        <input id="slugInput" type="text" name="slug" class="form-control form-control-md"
                            value="{{ old('slug') }}" required />
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Title (Optional)') }} </label>
                        <input type="text" name="title" class="form-control form-control-md"
                            value="{{ old('title') }}" />
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Description (Optional)') }} </label>
                        <textarea name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Guide Points') }}</label>

                        <div id="guide-wrapper">
                            <div class="input-group mb-2">
                                <input type="text" name="guide[]" class="form-control" placeholder="Enter guide point">

                                <button type="button" class="btn btn-danger remove-guide">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary btn-sm mt-2" id="add-guide">
                            <i class="fa fa-plus"></i> Add Point
                        </button>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Keywords (Optional)') }}</label>
                        <div class="tagsinput tagsinput-md">
                            <input type="text" name="keywords" class="form-control form-control-md tags-input"
                                value="{{ old('keywords') }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.js') }}"></script>
        <script></script>
    @endpush
    @push('scripts')
        <script>
            $(document).ready(function() {

                $('#add-guide').on('click', function() {

                    $('#guide-wrapper').append(`
                <div class="input-group mb-2">
                    <input type="text" name="guide[]" class="form-control"
                        placeholder="Enter guide point">

                    <button type="button" class="btn btn-danger remove-guide">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            `);
                });

                $(document).on('click', '.remove-guide', function() {
                    $(this).closest('.input-group').remove();
                });

            });
        </script>
    @endpush
@endsection
