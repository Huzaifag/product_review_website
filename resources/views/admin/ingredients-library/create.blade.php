@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Ingredient Library'))
@section('title', d_trans('Ingredient Library'))
@section('header_title', d_trans('New Ingredient'))
@section('back', route('admin.ingredients-library.index'))
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
            <form id="submittedForm" action="{{ route('admin.ingredients-library.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <!-- Name -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-md"
                            value="{{ old('name') }}" required autofocus />
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- INCI Name -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('INCI Name') }}</label>
                        <input type="text" name="inci_name" class="form-control form-control-md"
                            value="{{ old('inci_name') }}" />
                        @error('inci_name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- CAS Number -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('CAS Number') }}</label>
                        <input type="text" name="cas_number" class="form-control form-control-md"
                            value="{{ old('cas_number') }}" />
                        @error('cas_number')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Severity -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Severity') }}</label>
                        <select name="severity" class="form-select form-select-md">
                            <option value="">{{ d_trans('None') }}</option>
                            <option value="avoid" {{ old('severity') === 'avoid' ? 'selected' : '' }}>{{ d_trans('Avoid') }}</option>
                            <option value="concern" {{ old('severity') === 'concern' ? 'selected' : '' }}>{{ d_trans('Concern') }}</option>
                            <option value="caution" {{ old('severity') === 'caution' ? 'selected' : '' }}>{{ d_trans('Caution') }}</option>
                        </select>
                        @error('severity')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Concern Description -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Concern Description') }}</label>
                        <textarea name="concern_description" class="form-control" rows="4">{{ old('concern_description') }}</textarea>
                        @error('concern_description')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Health Effects -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Health Effects') }}</label>
                        <textarea name="health_effects" class="form-control" rows="4">{{ old('health_effects') }}</textarea>
                        @error('health_effects')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Regulatory Status -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Regulatory Status') }}</label>
                        <input type="text" name="regulatory_status" class="form-control form-control-md"
                            value="{{ old('regulatory_status') }}" />
                        @error('regulatory_status')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Published -->
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_published" value="1" id="is_published"
                                {{ old('is_published') ? 'checked' : '' }} />
                            <label class="form-check-label" for="is_published">
                                {{ d_trans('Publish this ingredient') }}
                            </label>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">{{ d_trans('Create') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
