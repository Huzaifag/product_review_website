@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Products'))
@section('title', d_trans('Product Test'))
@section('header_title', d_trans(':product_name — Product Test', ['product_name' => $product->name]))
@section('back', route('admin.products.index'))
@section('content')

    @include('admin.products.includes.hero')
    @include('admin.products.includes.tabs')

    <div class="prod-detail-card mt-4">
        <div class="prod-detail-card-header">
            <i class="fa-solid fa-flask-vial prod-detail-header-icon"></i>
            <h6 class="prod-detail-card-title">{{ d_trans('Product Test') }}</h6>
        </div>
        <div class="prod-detail-card-body">
            <form action="{{ route('admin.products.lab-tests.update', $product->id) }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                <input type="hidden" name="sub_category_id" value="{{ $product->sub_category_id }}">

                <div class="row g-3">

                    {{-- Test Name --}}
                    <div class="col-md-8">
                        <label class="lab-label">{{ d_trans('Test Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="product_test_name" class="lab-input"
                            value="{{ old('product_test_name', $productTest->name ?? $product->name) }}" required>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4">
                        <label class="lab-label">{{ d_trans('Status') }}</label>
                        <select name="product_test_status" class="lab-select">
                            <option value="active"
                                {{ old('product_test_status', $productTest->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                {{ d_trans('Active') }}</option>
                            <option value="inactive"
                                {{ old('product_test_status', $productTest->status ?? 'active') === 'inactive' ? 'selected' : '' }}>
                                {{ d_trans('Inactive') }}</option>
                        </select>
                    </div>

                    {{-- Test Attributes --}}
                    <div class="col-12 mt-2">
                        <div class="lab-attr-header">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-list-check lab-attr-header-icon"></i>
                                <span class="lab-attr-header-title">{{ d_trans('Test Attributes') }}</span>
                            </div>
                            @if ($testAttributes->count())
                                <div class="d-flex gap-2 align-items-center">
                                    <select id="attr-picker" class="lab-attr-picker select2-attr-picker">
                                        <option value="">— {{ d_trans('Add Attribute') }} —</option>
                                        @foreach ($testAttributes as $attr)
                                            <option value="{{ $attr->id }}" data-type="{{ $attr->type }}"
                                                data-name="{{ $attr->name }}"
                                                data-options="{{ json_encode($attr->options ?? []) }}">
                                                {{ $attr->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" id="add-attr-btn" class="lab-add-btn">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <div id="attr-rows" class="row g-3 mt-1">
                            @if ($productTest && $productTest->data)
                                @foreach ($testAttributes as $attr)
                                    @php
                                        $savedValue = array_key_exists($attr->id, $productTest->data)
                                            ? $productTest->data[$attr->id]
                                            : '__MISSING__';
                                    @endphp
                                    @if ($savedValue !== '__MISSING__')
                                        <div class="col-md-6 attr-row" data-id="{{ $attr->id }}">
                                            <div class="lab-attr-card">
                                                <div class="lab-attr-card-header">
                                                    <span class="lab-attr-name">{{ $attr->name }}</span>
                                                    <button type="button" class="lab-remove-btn remove-attr-btn"
                                                        title="{{ d_trans('Remove') }}">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                </div>
                                                <div class="lab-attr-card-body">
                                                    @if ($attr->type === 'boolean')
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="test_attribute[{{ $attr->id }}]"
                                                                id="attr_{{ $attr->id }}" value="1"
                                                                {{ old('test_attribute.' . $attr->id, $savedValue) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="attr_{{ $attr->id }}">{{ d_trans('Yes') }}</label>
                                                        </div>
                                                    @elseif ($attr->type === 'select' && $attr->options)
                                                        <select name="test_attribute[{{ $attr->id }}]"
                                                            class="lab-select">
                                                            <option value="">{{ d_trans('Select') }}</option>
                                                            @foreach ($attr->options as $option)
                                                                <option value="{{ $option }}"
                                                                    {{ old('test_attribute.' . $attr->id, $savedValue) == $option ? 'selected' : '' }}>
                                                                    {{ $option }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @elseif ($attr->type === 'number')
                                                        <input type="number" step="any"
                                                            name="test_attribute[{{ $attr->id }}]" class="lab-input"
                                                            value="{{ $productTest->exists ? old('test_attribute.' . $attr->id, $savedValue) : old('test_attribute.' . $attr->id, '') }}">
                                                    @else
                                                        <input type="text" name="test_attribute[{{ $attr->id }}]"
                                                            class="lab-input"
                                                            value="{{ $productTest->exists ? old('test_attribute.' . $attr->id, $savedValue) : old('test_attribute.' . $attr->id, '') }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            <div id="no-attr-msg" class="col-12"
                                style="{{ $productTest && !empty($productTest->data) ? 'display:none' : '' }}">
                                <div class="lab-empty-msg">
                                    <i class="fa-solid fa-flask-vial lab-empty-icon"></i>
                                    <p>{{ d_trans('No attributes added yet. Use the dropdown above to add one.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Save --}}
                    <div class="col-12 mt-2">
                        <button type="submit" class="lab-save-btn">
                            <i class="fa-solid fa-floppy-disk me-2"></i>{{ d_trans('Save Product Test') }}
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('vendor/admin/css/select2.min.css') }}" rel="stylesheet">
        <style>
            :root {
                --prod-red: #dc2626;
                --prod-red-dark: #b91c1c;
                --prod-red-soft: rgba(220, 38, 38, 0.08);
                --prod-bg: rgb(249, 250, 251);
                --prod-border: rgba(0, 0, 0, 0.08);
                --prod-text: #1e293b;
                --prod-muted: #64748b;
            }

            /* Hero */
            .prod-hero {
                background: #fff;
                border: 1px solid var(--prod-border);
                border-radius: 14px;
                padding: 24px;
                display: flex;
                gap: 20px;
                align-items: flex-start;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
            }

            .prod-hero-image {
                width: 80px;
                height: 80px;
                min-width: 80px;
                border-radius: 12px;
                overflow: hidden;
                border: 1px solid var(--prod-border);
            }

            .prod-hero-image img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .prod-hero-placeholder {
                width: 100%;
                height: 100%;
                background: var(--prod-bg);
                display: flex;
                align-items: center;
                justify-content: center;
                color: rgba(220, 38, 38, 0.4);
                font-size: 1.6rem;
            }

            .prod-hero-info {
                flex: 1;
                min-width: 0;
            }

            .prod-hero-name {
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--prod-text);
                margin: 0 0 4px;
            }

            .prod-hero-slug {
                font-size: 0.8rem;
                color: var(--prod-muted);
            }

            .prod-status-pill {
                display: inline-flex;
                align-items: center;
                padding: 5px 12px;
                border-radius: 20px;
                font-size: 0.75rem;
                font-weight: 600;
            }

            .prod-status-active {
                background: rgba(22, 163, 74, 0.1);
                color: #15803d;
            }

            .prod-status-inactive {
                background: rgba(220, 38, 38, 0.1);
                color: #dc2626;
            }

            .prod-status-featured {
                background: rgba(245, 158, 11, 0.1);
                color: #b45309;
            }

            .prod-hero-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .prod-meta-chip {
                display: inline-flex;
                align-items: center;
                padding: 4px 12px;
                background: var(--prod-bg);
                border: 1px solid var(--prod-border);
                border-radius: 20px;
                font-size: 0.75rem;
                color: var(--prod-muted);
            }

            .prod-meta-grade {
                background: var(--prod-red-soft);
                color: var(--prod-red);
                border-color: rgba(220, 38, 38, 0.2);
            }

            /* Tabs */
            .dashboard-tabs {
                /* border-bottom: 2px solid var(--prod-border); */
                margin-bottom: 0;
                display: flex;
            }

            .dashboard-tabs-item {
                padding: 10px 20px;
                font-size: 0.875rem;
                font-weight: 500;
                color: var(--prod-muted);
                text-decoration: none;
                border-bottom: 2px solid transparent;
                margin-bottom: -2px;
                transition: color 0.18s, border-color 0.18s;
            }

            .dashboard-tabs-item:hover {
                color: var(--prod-red);
            }

            .dashboard-tabs-item.current {
                color: var(--prod-red);
                border-bottom-color: var(--prod-red);
                font-weight: 600;
            }

            /* Detail Card */
            .prod-detail-card {
                background: #fff;
                border: 1px solid var(--prod-border);
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
            }

            .prod-detail-card-header {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 16px 20px;
                border-bottom: 1px solid var(--prod-border);
                background: var(--prod-bg);
            }

            .prod-detail-header-icon {
                width: 32px;
                height: 32px;
                border-radius: 8px;
                background: var(--prod-red-soft);
                color: var(--prod-red);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.85rem;
            }

            .prod-detail-card-title {
                margin: 0;
                font-size: 0.9rem;
                font-weight: 600;
                color: var(--prod-text);
            }

            .prod-detail-card-body {
                padding: 24px;
            }

            /* Form inputs */
            .lab-label {
                display: block;
                font-size: 0.8rem;
                font-weight: 600;
                /* color: rgba(220, 38, 38, 0.6); */
                text-transform: uppercase;
                letter-spacing: 0.4px;
                margin-bottom: 6px;
            }

            .lab-input {
                width: 100%;
                padding: 9px 14px;
                border: 1px solid var(--prod-border);
                border-radius: 8px;
                font-size: 0.875rem;
                background: #fff;
                color: var(--prod-text);
                transition: border-color 0.18s, box-shadow 0.18s;
                outline: none;
            }

            .lab-input:focus {
                border-color: var(--prod-red);
                box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            }

            .lab-select {
                width: 100%;
                padding: 9px 14px;
                border: 1px solid var(--prod-border);
                border-radius: 8px;
                font-size: 0.875rem;
                background: #fff;
                color: var(--prod-text);
                outline: none;
                cursor: pointer;
                transition: border-color 0.18s;
            }

            .lab-select:focus {
                border-color: var(--prod-red);
            }

            /* Attributes section header */
            .lab-attr-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 14px 16px;
                background: var(--prod-bg);
                border: 1px solid var(--prod-border);
                border-radius: 10px;
                margin-bottom: 4px;
            }

            .lab-attr-header-icon {
                width: 28px;
                height: 28px;
                border-radius: 7px;
                background: var(--prod-red-soft);
                color: var(--prod-red);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 0.8rem;
            }

            .lab-attr-header-title {
                font-size: 0.875rem;
                font-weight: 600;
                color: var(--prod-text);
            }

            .lab-attr-picker {
                min-width: 240px;
                padding: 7px 12px;
                border: 1px solid var(--prod-border);
                border-radius: 8px;
                font-size: 0.875rem;
                background: #fff;
                color: var(--prod-text);
                outline: none;
            }

            .lab-add-btn {
                width: 36px;
                height: 36px;
                border-radius: 8px;
                background: var(--prod-red);
                color: #fff;
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.85rem;
                cursor: pointer;
                transition: background 0.18s;
                flex-shrink: 0;
            }

            .lab-add-btn:hover {
                background: var(--prod-red-dark);
            }

            /* Select2 override for picker */
            .select2-attr-picker+.select2-container {
                min-width: 240px;
            }

            .select2-container--default .select2-selection--single {
                height: 36px !important;
                border: 1px solid var(--prod-border) !important;
                border-radius: 8px !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 34px !important;
                padding-left: 12px !important;
                font-size: 0.875rem;
                color: var(--prod-text) !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 34px !important;
            }

            .select2-container--default.select2-container--focus .select2-selection--single,
            .select2-container--default.select2-container--open .select2-selection--single {
                border-color: var(--prod-red) !important;
                box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
            }

            /* Attribute cards */
            .lab-attr-card {
                background: #fff;
                border: 1px solid var(--prod-border);
                border-radius: 10px;
                overflow: hidden;
                height: 100%;
                transition: border-color 0.18s, box-shadow 0.18s;
            }

            .lab-attr-card:hover {
                border-color: rgba(220, 38, 38, 0.25);
                box-shadow: 0 2px 12px rgba(220, 38, 38, 0.06);
            }

            .lab-attr-card-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 14px;
                background: var(--prod-bg);
                border-bottom: 1px solid var(--prod-border);
            }

            .lab-attr-name {
                font-size: 0.8rem;
                font-weight: 600;
                color: rgba(220, 38, 38, 0.7);
            }

            .lab-remove-btn {
                width: 24px;
                height: 24px;
                border-radius: 6px;
                background: transparent;
                border: 1px solid rgba(220, 38, 38, 0.2);
                color: var(--prod-red);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.7rem;
                cursor: pointer;
                transition: background 0.18s;
            }

            .lab-remove-btn:hover {
                background: rgba(220, 38, 38, 0.1);
            }

            .lab-attr-card-body {
                padding: 12px 14px;
            }

            /* Empty state */
            .lab-empty-msg {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 8px;
                padding: 32px 20px;
                text-align: center;
                background: var(--prod-bg);
                border: 1px dashed rgba(220, 38, 38, 0.2);
                border-radius: 10px;
            }

            .lab-empty-icon {
                font-size: 1.5rem;
                color: rgba(220, 38, 38, 0.3);
            }

            .lab-empty-msg p {
                font-size: 0.85rem;
                color: var(--prod-muted);
                margin: 0;
            }

            /* Save button */
            .lab-save-btn {
                display: inline-flex;
                align-items: center;
                padding: 10px 24px;
                background: var(--prod-red);
                color: #fff;
                border: none;
                border-radius: 8px;
                font-size: 0.875rem;
                font-weight: 500;
                cursor: pointer;
                transition: background 0.18s;
            }

            .lab-save-btn:hover {
                background: var(--prod-red-dark);
            }
        </style>
    @endpush

    @push('scripts')
        <script src="{{ asset('vendor/admin/js/select2.min.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const $picker = $('#attr-picker');
                const addBtn = document.getElementById('add-attr-btn');
                const rows = document.getElementById('attr-rows');
                const noMsg = document.getElementById('no-attr-msg');

                $picker.select2({
                    placeholder: '— {{ d_trans('Add Attribute') }} —',
                    allowClear: true,
                    width: 'resolve',
                });

                function shownIds() {
                    return [...rows.querySelectorAll('.attr-row')].map(r => r.dataset.id);
                }

                function refreshPicker() {
                    const shown = shownIds();
                    $picker.find('option').each(function() {
                        if (!this.value) return;
                        $(this).prop('disabled', shown.includes(this.value));
                    });
                    $picker.val('').trigger('change');
                    noMsg.style.display = rows.querySelectorAll('.attr-row').length ? 'none' : '';
                }

                function buildInput(id, type, options) {
                    if (type === 'boolean') {
                        return `<div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox"
                                    name="test_attribute[${id}]" id="attr_${id}" value="1">
                                <label class="form-check-label" for="attr_${id}">{{ d_trans('Yes') }}</label>
                            </div>`;
                    }
                    if (type === 'select') {
                        const opts = options.map(o => `<option value="${o}">${o}</option>`).join('');
                        return `<select name="test_attribute[${id}]" class="lab-select">
                                <option value="">{{ d_trans('Select') }}</option>${opts}
                            </select>`;
                    }
                    if (type === 'number') {
                        return `<input type="number" step="any" name="test_attribute[${id}]" class="lab-input">`;
                    }
                    return `<input type="text" name="test_attribute[${id}]" class="lab-input">`;
                }

                addBtn?.addEventListener('click', function() {
                    const selectedId = $picker.val();
                    if (!selectedId) return;
                    const opt = $picker.find(`option[value="${selectedId}"]`)[0];
                    const id = opt.value;
                    const name = opt.dataset.name;
                    const type = opt.dataset.type;
                    const options = JSON.parse(opt.dataset.options || '[]');

                    const col = document.createElement('div');
                    col.className = 'col-md-6 attr-row';
                    col.dataset.id = id;
                    col.innerHTML = `
                    <div class="lab-attr-card">
                        <div class="lab-attr-card-header">
                            <span class="lab-attr-name">${name}</span>
                            <button type="button" class="lab-remove-btn remove-attr-btn" title="{{ d_trans('Remove') }}">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="lab-attr-card-body">
                            ${buildInput(id, type, options)}
                        </div>
                    </div>`;
                    rows.appendChild(col);
                    attachRemove(col);
                    refreshPicker();
                });

                function attachRemove(row) {
                    row.querySelector('.remove-attr-btn').addEventListener('click', function() {
                        row.remove();
                        refreshPicker();
                    });
                }

                rows.querySelectorAll('.attr-row').forEach(row => attachRemove(row));
                refreshPicker();
            });
        </script>
    @endpush

@endsection
