@extends('admin.layouts.app')

@section('container', 'dashboard-container-sm')
@section('section', d_trans('Test Attributes'))
@section('title', d_trans('Test Attributes'))
@section('header_title', d_trans('New Test Attribute'))
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
            <form id="submittedForm" action="{{ route('admin.test-attributes.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    <!-- Name -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Name') }} <span class="text-danger">*</span></label>
                        <input id="slugTitle" type="text" name="name" class="form-control form-control-md"
                            value="{{ old('name') }}" autofocus />
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Type') }} <span class="text-danger">*</span></label>
                        <select id="typeSelect" name="type" class="form-select form-select-md" required>
                            <option value="">{{ d_trans('Select Type') }}</option>
                            <option value="select" {{ old('type') == 'select' ? 'selected' : '' }}>Select</option>
                            <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                        </select>
                    </div>

                    <!-- Options -->
                    <div class="col-12" id="optionsField" style="display: none;">
                        <label class="form-label">{{ d_trans('Options') }} <span class="text-danger">*</span></label>
                        <input type="text" name="options" class="form-control form-control-md"
                            value="{{ old('options') }}" />
                        <small class="text-muted">
                            Enter options separated by commas (e.g., Yes, No)
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
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        {{ d_trans('Save Attribute') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleOptionsField() {
            let type = document.getElementById('typeSelect').value;
            let optionsField = document.getElementById('optionsField');

            if (type === 'select') {
                optionsField.style.display = 'block';
            } else {
                optionsField.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleOptionsField();
        });

        document.getElementById('typeSelect').addEventListener('change', toggleOptionsField);
    </script>
@endpush
