@extends('admin.layouts.app')

@section('container', 'dashboard-container-sm')
@section('section', d_trans('Brands'))
@section('title', d_trans('Main Brands'))
@section('header_title', d_trans('New Main Brand'))
@section('back', route('admin.brands.index'))
@section('form', true)

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-4">
            <form id="submittedForm" action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <!-- Name -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Name') }} <span class="text-danger">*</span></label>
                        <input id="slugTitle" type="text" name="name" class="form-control form-control-md"
                            value="{{ old('name') }}" required autofocus />
                        {{-- error message  --}}
                        @error('name')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Slug') }} <span class="text-danger">*</span></label>
                        <input type="text" name="slug" class="form-control form-control-md"
                            value="{{ old('slug') }}" required />
                        @error('slug')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Website URL -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Website URL') }}</label>
                        <input type="url" name="website_url" class="form-control form-control-md"
                            value="{{ old('website_url') }}" placeholder="https://example.com" />
                        @error('website_url')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Description (Optional)') }}</label>
                        <textarea name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Logo (Optional) -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Logo (Optional)') }}</label>
                        <input type="file" name="logo" class="form-control" />
                        @error('logo')
                            <div class="text-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Status') }} <span class="text-danger">*</span></label>
                        <select name="status" class="form-select form-select-md" required>
                            <option value="">{{ d_trans('Select Status') }}</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">{{ d_trans('Save Brand') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles_libs')
    <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.css') }}">
@endpush

@push('scripts_libs')
    <script src="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.js') }}"></script>
@endpush
