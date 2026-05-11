@extends('admin.layouts.app')

@section('container', 'dashboard-container-sm')
@section('section', d_trans('Test Attributes'))
@section('title', d_trans('Test Attributes'))
@section('header_title', d_trans('Edit Test Attribute'))
@section('back', route('admin.test-attributes.index'))
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
            <form id="submittedForm" action="{{ route('admin.test-attributes.update', $attribute->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <!-- Name -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-md"
                            value="{{ old('name', $attribute->name) }}" autofocus />
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Type') }} <span class="text-danger">*</span></label>
                        <select id="typeSelect" name="type" class="form-select form-select-md" required>
                            <option value="">{{ d_trans('Select Type') }}</option>
                            <option value="text" {{ old('type', $attribute->type) == 'text' ? 'selected' : '' }}>{{ d_trans('Text') }}</option>
                            <option value="number" {{ old('type', $attribute->type) == 'number' ? 'selected' : '' }}>{{ d_trans('Number') }}</option>
                            <option value="boolean" {{ old('type', $attribute->type) == 'boolean' ? 'selected' : '' }}>{{ d_trans('Boolean') }}</option>
                            <option value="select" {{ old('type', $attribute->type) == 'select' ? 'selected' : '' }}>{{ d_trans('Select') }}</option>
                        </select>
                        @error('type')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Options (shown only for select type) -->
                    <div class="col-12" id="optionsField" style="display: none;">
                        <label class="form-label">{{ d_trans('Options') }}</label>
                        <input type="text" name="options" class="form-control form-control-md"
                            value="{{ old('options', $attribute->options ? implode(', ', $attribute->options) : '') }}" />
                        <small class="text-muted">
                            {{ d_trans('Enter options separated by commas (e.g., Yes, No)') }}
                        </small>
                        @error('options')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Status') }} <span class="text-danger">*</span></label>
                        <select name="status" class="form-select form-select-md" required>
                            <option value="">{{ d_trans('Select Status') }}</option>
                            <option value="active" {{ old('status', $attribute->status) == 'active' ? 'selected' : '' }}>{{ d_trans('Active') }}</option>
                            <option value="inactive" {{ old('status', $attribute->status) == 'inactive' ? 'selected' : '' }}>{{ d_trans('Inactive') }}</option>
                        </select>
                        @error('status')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ d_trans('Update Attribute') }}
                    </button>
                    <a href="{{ route('admin.test-attributes.index') }}" class="btn btn-soft ms-2">
                        {{ d_trans('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleOptionsField() {
            const type = document.getElementById('typeSelect').value;
            const optionsField = document.getElementById('optionsField');
            optionsField.style.display = (type === 'select') ? 'block' : 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleOptionsField();
        });

        document.getElementById('typeSelect').addEventListener('change', toggleOptionsField);
    </script>
@endpush
