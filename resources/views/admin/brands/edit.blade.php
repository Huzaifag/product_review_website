@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Brands'))
@section('title', d_trans('Main Brands'))
@section('header_title', d_trans('Edit Main Brand'))
@section('back', route('admin.brands.index'))
@section('form', true)
@section('content')
    <div class="mb-3">
        <a class="btn btn-outline-secondary px-3" href="{{ $brand->getLink() }}" target="_blank">
            <i class="fa-solid fa-arrow-up-right-from-square me-2"></i>{{ d_trans('Preview') }}
        </a>
    </div>
    <div class="card">
        <div class="card-body p-4">
            <form id="submittedForm" action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Logo (Optional)') }}</label>
                        <input type="file" name="logo" class="form-control" />
                        @if($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="Logo" width="100" height="100" class="mt-2" />
                        @endif
                        @error('logo')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Name') }}</label>
                        <input type="text" name="name" class="form-control form-control-md" value="{{ $brand->name }}" required />
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Slug') }}</label>
                        <input type="text" name="slug" class="form-control form-control-md" value="{{ $brand->slug }}" required />
                        @error('slug')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Website URL') }}</label>
                        <input type="url" name="website_url" class="form-control form-control-md" value="{{ $brand->website_url }}" placeholder="https://example.com" />
                        @error('website_url')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Description (Optional)') }}</label>
                        <textarea name="description" class="form-control" rows="6">{{ $brand->description }}</textarea>
                        @error('description')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Status') }}</label>
                        <select name="status" class="form-select form-select-md" required>
                            <option value="active" {{ $brand->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $brand->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">{{ d_trans('Update Brand') }}</button>
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