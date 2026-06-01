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
                        <label class="ui-label">{{ d_trans('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="ui-input"
                            value="{{ old('name', $attribute->name) }}" autofocus />
                        @error('name')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div class="col-12">
                        <label class="ui-label">{{ d_trans('Type') }} <span class="text-danger">*</span></label>
                        <select id="typeSelect" name="type" class="ui-select" required>
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
                        <label class="ui-label">{{ d_trans('Options') }}</label>
                        <input type="text" name="options" class="ui-input"
                            value="{{ old('options', $attribute->options ? implode(', ', $attribute->options) : '') }}" />
                        <small class="ui-hint">
                            {{ d_trans('Enter options separated by commas (e.g., Yes, No)') }}
                        </small>
                        @error('options')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-12">
                        <label class="ui-label">{{ d_trans('Status') }} <span class="text-danger">*</span></label>
                        <select name="status" class="ui-select" required>
                            <option value="">{{ d_trans('Select Status') }}</option>
                            <option value="active" {{ old('status', $attribute->status) == 'active' ? 'selected' : '' }}>{{ d_trans('Active') }}</option>
                            <option value="inactive" {{ old('status', $attribute->status) == 'inactive' ? 'selected' : '' }}>{{ d_trans('Inactive') }}</option>
                        </select>
                        @error('status')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="mt-4 d-flex flex-wrap gap-2">
                    <button type="submit" class="ui-save-btn">
                        <i class="fa fa-save"></i>
                        {{ d_trans('Update Attribute') }}
                    </button>
                    <a href="{{ route('admin.test-attributes.index') }}" class="ui-cancel-btn">
                        {{ d_trans('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        :root {
            --ui-primary: #dc2626;
            --ui-primary-dark: #b91c1c;
            --ui-primary-soft: rgba(220, 38, 38, 0.08);
            --ui-primary-soft-2: rgba(220, 38, 38, 0.14);
            --ui-bg: rgb(249, 250, 251);
            --ui-card: #ffffff;
            --ui-border: rgba(15, 23, 42, 0.10);
            --ui-border-strong: rgba(15, 23, 42, 0.14);
            --ui-text: #1e293b;
            --ui-muted: #64748b;
            --ui-light: #f8fafc;
            --ui-radius-sm: 8px;
            --ui-radius-md: 12px;
            --ui-radius-lg: 18px;
            --ui-shadow-sm: 0 8px 18px rgba(15, 23, 42, 0.06);
            --ui-shadow-md: 0 16px 36px rgba(15, 23, 42, 0.08);
            --ui-shadow-red: 0 14px 30px rgba(220, 38, 38, 0.18);
        }

        body {
            background: var(--ui-bg);
        }

        .card {
            border: 1px solid var(--ui-border);
            border-radius: var(--ui-radius-lg);
            box-shadow: var(--ui-shadow-md);
            overflow: hidden;
        }

        .card-body {
            background:
                radial-gradient(circle at top right, rgba(220, 38, 38, 0.045), transparent 35%),
                #ffffff;
        }

        .ui-label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            color: var(--ui-text);
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .ui-input,
        .ui-select,
        .ui-textarea {
            width: 100%;
            border: 1px solid var(--ui-border);
            border-radius: var(--ui-radius-md);
            background: #ffffff;
            color: var(--ui-text);
            font-size: 0.9rem;
            font-weight: 500;
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
            box-shadow: 0 1px 0 rgba(15, 23, 42, 0.03);
        }

        .ui-input,
        .ui-select {
            min-height: 44px;
            padding: 10px 14px;
        }

        .ui-input::placeholder {
            color: #94a3b8;
            font-weight: 500;
        }

        .ui-input:hover,
        .ui-select:hover,
        .ui-textarea:hover {
            border-color: var(--ui-border-strong);
            background: #ffffff;
        }

        .ui-input:focus,
        .ui-select:focus,
        .ui-textarea:focus {
            border-color: var(--ui-primary);
            box-shadow:
                0 0 0 4px rgba(220, 38, 38, 0.10),
                0 10px 24px rgba(15, 23, 42, 0.07);
        }

        .ui-select {
            cursor: pointer;
        }

        .ui-hint {
            display: block;
            margin-top: 7px;
            color: var(--ui-muted);
            font-size: 0.78rem;
            font-weight: 500;
        }

        .ui-save-btn,
        .ui-cancel-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 10px 24px;
            border-radius: 999px;
            font-size: 0.9rem;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.22s ease;
        }

        .ui-save-btn {
            gap: 8px;
            border: 0;
            background: linear-gradient(135deg, var(--ui-primary), var(--ui-primary-dark));
            color: #ffffff;
            box-shadow: var(--ui-shadow-red);
        }

        .ui-save-btn:hover {
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 18px 38px rgba(220, 38, 38, 0.26);
        }

        .ui-save-btn:active {
            transform: translateY(0) scale(0.98);
        }

        .ui-cancel-btn {
            border: 1px solid var(--ui-border);
            background: #ffffff;
            color: var(--ui-text);
            box-shadow: var(--ui-shadow-sm);
        }

        .ui-cancel-btn:hover {
            border-color: rgba(220, 38, 38, 0.22);
            background: var(--ui-primary-soft);
            color: var(--ui-primary);
            transform: translateY(-2px);
        }

        .form-label {
            margin-bottom: 8px;
            color: var(--ui-text);
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .form-control,
        .form-select {
            border-radius: var(--ui-radius-md);
            border-color: var(--ui-border);
            min-height: 44px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--ui-primary);
            box-shadow:
                0 0 0 4px rgba(220, 38, 38, 0.10),
                0 10px 24px rgba(15, 23, 42, 0.07);
        }
    </style>
@endpush

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
