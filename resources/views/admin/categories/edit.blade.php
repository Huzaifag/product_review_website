@extends('admin.layouts.app')
@section('container', 'dashboard-container-sm')
@section('section', d_trans('Categories'))
@section('title', d_trans('Main Categories'))
@section('header_title', d_trans('Edit Main Category'))
@section('back', route('admin.categories.index'))
@section('form', true)
@section('content')
    <div class="mb-3">
        <a class="btn btn-outline-secondary px-3" href="{{ $category->getLink() }}" target="_blank"><i
                class="fa-solid fa-arrow-up-right-from-square me-2"></i>{{ d_trans('Preview') }}</a>
    </div>
    <div class="card">
        <div class="card-body p-4">
            <form id="submittedForm" action="{{ route('admin.categories.update', $category->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-12">
                        <x-admin.image-uploader src="{{ $category->getImageLink() }}" width="100px" height="100px" />
                    </div>
                    <div class="col-12">
                        <label class="ui-label">{{ d_trans('Name') }}</label>
                        <input type="text" name="name" class="ui-input" value="{{ $category->name }}" required />
                    </div>

                    <div class="col-12">
                        <label class="ui-label">{{ d_trans('Slug') }}</label>
                        <input type="text" name="slug" class="ui-input" value="{{ $category->slug }}" required />
                    </div>

                    <div class="col-12">
                        <label class="ui-label">{{ d_trans('Title (Optional)') }}</label>
                        <input type="text" name="title" class="ui-input" value="{{ $category->title }}" />
                    </div>

                    <div class="col-12">
                        <label class="ui-label">{{ d_trans('Description (Optional)') }}</label>
                        <textarea name="description" class="ui-textarea" rows="6">{{ $category->description }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Guide Points') }}</label>

                        <div id="guide-wrapper">

                            @php
                                $guides = is_array($category->guide)
                                    ? $category->guide
                                    : json_decode($category->guide, true) ?? [];
                            @endphp

                            @if (!empty($guides))
                                @foreach ($guides as $guide)
                                    <div class="input-group mb-2">
                                        <input type="text" name="guide[]" class="ui-input" value="{{ $guide }}"
                                            placeholder="Enter guide point">

                                        <button type="button" class="btn btn-danger remove-guide">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group mb-2">
                                    <input type="text" name="guide[]" class="form-control"
                                        placeholder="Enter guide point">

                                    <button type="button" class="btn btn-danger remove-guide">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            @endif

                        </div>

                        <button type="button" class="btn btn-primary btn-sm mt-2" id="add-guide">
                            <i class="fa fa-plus"></i> Add Point
                        </button>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Keywords (Optional)') }}</label>
                        <div class="tagsinput tagsinput-md">
                            <input type="text" name="keywords" class="form-control form-control-md tags-input"
                                value="{{ $category->keywords }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('styles')
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

                /* Labels */
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

                .ui-label::before {
                    content: "";
                    width: 7px;
                    height: 7px;
                    border-radius: 999px;
                    background: var(--ui-primary);
                    box-shadow: 0 0 0 4px var(--ui-primary-soft);
                }

                /* Inputs */
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

                .ui-textarea {
                    min-height: 140px;
                    padding: 13px 14px;
                    resize: vertical;
                    line-height: 1.65;
                }

                .ui-input::placeholder,
                .ui-textarea::placeholder {
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

                /* File input */
                .ui-file-input {
                    width: 100%;
                    padding: 9px 12px;
                    border: 1px dashed rgba(220, 38, 38, 0.32);
                    border-radius: var(--ui-radius-md);
                    background: linear-gradient(135deg, #ffffff, #fff7f7);
                    color: var(--ui-text);
                    font-size: 0.875rem;
                    font-weight: 600;
                    cursor: pointer;
                    outline: none;
                    transition: all 0.2s ease;
                }

                .ui-file-input:hover,
                .ui-file-input:focus {
                    border-color: var(--ui-primary);
                    box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.09);
                }

                .ui-file-input::file-selector-button {
                    padding: 7px 14px;
                    margin-right: 12px;
                    background: var(--ui-primary-soft);
                    color: var(--ui-primary);
                    border: 1px solid rgba(220, 38, 38, 0.18);
                    border-radius: 9px;
                    font-size: 0.8rem;
                    font-weight: 800;
                    cursor: pointer;
                    transition: all 0.2s ease;
                }

                .ui-file-input::file-selector-button:hover {
                    background: var(--ui-primary);
                    color: #ffffff;
                }

                /* Hint text */
                .ui-hint {
                    display: block;
                    margin-top: 7px;
                    color: var(--ui-muted);
                    font-size: 0.78rem;
                    font-weight: 500;
                }

                /* Clear / secondary button */
                .ui-clear-btn {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    min-height: 32px;
                    padding: 5px 12px;
                    border: 1px solid var(--ui-border);
                    border-radius: 999px;
                    background: #ffffff;
                    color: var(--ui-muted);
                    font-size: 0.76rem;
                    font-weight: 800;
                    cursor: pointer;
                    transition: all 0.2s ease;
                }

                .ui-clear-btn:hover {
                    background: var(--ui-primary-soft);
                    color: var(--ui-primary);
                    border-color: rgba(220, 38, 38, 0.22);
                }

                /* Thumbnail */
                .ui-thumb-wrap {
                    position: relative;
                    width: 92px;
                    height: 92px;
                    border-radius: 16px;
                    overflow: hidden;
                    border: 1px solid var(--ui-border);
                    background: #ffffff;
                    box-shadow: var(--ui-shadow-sm);
                }

                .ui-thumb-wrap img {
                    width: 100%;
                    height: 100%;
                    object-fit: contain;
                    padding: 6px;
                }

                .ui-thumb-main {
                    border-color: rgba(220, 38, 38, 0.45);
                    box-shadow: 0 12px 26px rgba(220, 38, 38, 0.14);
                }

                .ui-thumb-badge {
                    position: absolute;
                    left: 8px;
                    right: 8px;
                    bottom: 8px;
                    padding: 4px 6px;
                    border-radius: 999px;
                    background: rgba(220, 38, 38, 0.92);
                    color: #ffffff;
                    font-size: 0.62rem;
                    font-weight: 900;
                    text-align: center;
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                }

                .ui-thumb-badge-gallery {
                    background: rgba(15, 23, 42, 0.72);
                }

                /* Toggle row */
                .ui-toggles-row {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 10px;
                    padding: 10px;
                    background: var(--ui-bg);
                    border: 1px solid var(--ui-border);
                    border-radius: var(--ui-radius-lg);
                }

                .ui-toggle-item {
                    flex: 1;
                    min-width: 170px;
                    padding: 14px 16px;
                    border: 1px solid var(--ui-border);
                    border-radius: var(--ui-radius-md);
                    background: #ffffff;
                    box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
                }

                .ui-toggle-label {
                    color: var(--ui-text);
                    font-size: 0.84rem;
                    font-weight: 700;
                    cursor: pointer;
                    user-select: none;
                }

                .ui-switch {
                    width: 16px;
                    height: 16px;
                    accent-color: var(--ui-primary);
                    cursor: pointer;
                }

                /* Save button */
                .ui-save-btn {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                    min-height: 44px;
                    padding: 10px 24px;
                    border: 0;
                    border-radius: 999px;
                    background: linear-gradient(135deg, var(--ui-primary), var(--ui-primary-dark));
                    color: #ffffff;
                    font-size: 0.9rem;
                    font-weight: 800;
                    cursor: pointer;
                    box-shadow: var(--ui-shadow-red);
                    transition: all 0.22s ease;
                }

                .ui-save-btn:hover {
                    color: #ffffff;
                    transform: translateY(-2px);
                    box-shadow: 0 18px 38px rgba(220, 38, 38, 0.26);
                }

                .ui-save-btn:active {
                    transform: translateY(0) scale(0.98);
                }

                /* Premium Bootstrap button overrides for this form */
                .btn-primary,
                #add-guide {
                    border: 0;
                    border-radius: 999px;
                    background: linear-gradient(135deg, var(--ui-primary), var(--ui-primary-dark));
                    color: #ffffff;
                    font-weight: 800;
                    box-shadow: 0 12px 26px rgba(220, 38, 38, 0.18);
                    transition: all 0.22s ease;
                }

                .btn-primary:hover,
                #add-guide:hover {
                    color: #ffffff;
                    transform: translateY(-2px);
                    box-shadow: 0 16px 34px rgba(220, 38, 38, 0.26);
                }

                .btn-danger.remove-guide {
                    border: 0;
                    border-radius: 12px;
                    background: rgba(220, 38, 38, 0.10);
                    color: var(--ui-primary);
                    font-weight: 800;
                    transition: all 0.2s ease;
                }

                .btn-danger.remove-guide:hover {
                    background: var(--ui-primary);
                    color: #ffffff;
                }

                .btn-outline-secondary {
                    min-height: 42px;
                    border-radius: 999px;
                    border-color: var(--ui-border);
                    background: #ffffff;
                    color: var(--ui-text);
                    font-weight: 800;
                    box-shadow: var(--ui-shadow-sm);
                    transition: all 0.22s ease;
                }

                .btn-outline-secondary:hover {
                    border-color: rgba(220, 38, 38, 0.22);
                    background: var(--ui-primary-soft);
                    color: var(--ui-primary);
                    transform: translateY(-2px);
                }

                /* Bootstrap form-control fallback */
                .form-control {
                    border-radius: var(--ui-radius-md);
                    border-color: var(--ui-border);
                    min-height: 44px;
                    font-size: 0.9rem;
                    font-weight: 500;
                    transition: all 0.2s ease;
                }

                textarea.form-control {
                    min-height: 140px;
                    line-height: 1.65;
                }

                .form-control:focus {
                    border-color: var(--ui-primary);
                    box-shadow:
                        0 0 0 4px rgba(220, 38, 38, 0.10),
                        0 10px 24px rgba(15, 23, 42, 0.07);
                }

                .form-label {
                    margin-bottom: 8px;
                    color: var(--ui-text);
                    font-size: 0.78rem;
                    font-weight: 800;
                    text-transform: uppercase;
                    letter-spacing: 0.06em;
                }

                .input-group {
                    border-radius: var(--ui-radius-md);
                    box-shadow: 0 8px 18px rgba(15, 23, 42, 0.04);
                }

                .input-group .form-control {
                    border-top-left-radius: var(--ui-radius-md);
                    border-bottom-left-radius: var(--ui-radius-md);
                }

                .input-group .btn {
                    border-top-right-radius: var(--ui-radius-md);
                    border-bottom-right-radius: var(--ui-radius-md);
                }

                /* Tags input */
                .tagsinput {
                    border-radius: var(--ui-radius-md);
                }

                .tagsinput .tag {
                    border-radius: 999px;
                    background: var(--ui-primary-soft) !important;
                    color: var(--ui-primary) !important;
                    font-weight: 800;
                }

                /* Select2 override */
                .select2-container {
                    width: 100% !important;
                }

                .select2-container--default .select2-selection--single {
                    height: 44px !important;
                    border: 1px solid var(--ui-border) !important;
                    border-radius: var(--ui-radius-md) !important;
                    padding: 0 !important;
                    background: #ffffff !important;
                }

                .select2-container--default .select2-selection--single .select2-selection__rendered {
                    line-height: 42px !important;
                    padding-left: 14px !important;
                    padding-right: 34px !important;
                    color: var(--ui-text) !important;
                    font-size: 0.9rem;
                    font-weight: 500;
                }

                .select2-container--default .select2-selection--single .select2-selection__placeholder {
                    color: #94a3b8 !important;
                }

                .select2-container--default .select2-selection--single .select2-selection__arrow {
                    height: 42px !important;
                    right: 8px !important;
                }

                .select2-container--default.select2-container--focus .select2-selection--single,
                .select2-container--default.select2-container--open .select2-selection--single {
                    border-color: var(--ui-primary) !important;
                    box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.10) !important;
                }
            </style>
        @endpush
    @endpush
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/tags-input/tags-input.min.js') }}"></script>
    @endpush
    @push('scripts')
        <script>
            $(document).ready(function() {

                $('#add-guide').on('click', function() {
                    $('#guide-wrapper').append(`
                        <div class="input-group mb-2">
                            <input type="text" name="guide[]" class="ui-input"
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
