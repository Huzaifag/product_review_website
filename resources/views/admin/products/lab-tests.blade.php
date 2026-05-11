@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Products'))
@section('title', d_trans('Product Test'))
@section('header_title', d_trans(':product_name — Product Test', ['product_name' => $product->name]))
@section('back', route('admin.products.index'))
@section('content')
    @include('admin.products.includes.tabs')

    <div class="card mt-4">
        <div class="card-header border-bottom">
            <h5 class="mb-0">{{ d_trans('Product Test') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.lab-tests.update', $product->id) }}" method="POST">
                @csrf

                {{-- Hidden: product_id, category_id, sub_category_id --}}
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                <input type="hidden" name="sub_category_id" value="{{ $product->sub_category_id }}">

                <div class="row g-3">

                    {{-- Name --}}
                    <div class="col-md-8">
                        <label class="form-label">{{ d_trans('Test Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="product_test_name" class="form-control form-control-md"
                            value="{{ old('product_test_name', $productTest->name ?? $product->name) }}" required>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-4">
                        <label class="form-label">{{ d_trans('Status') }}</label>
                        <select name="product_test_status" class="form-select form-select-md">
                            <option value="active"
                                {{ old('product_test_status', $productTest->status ?? 'active') === 'active' ? 'selected' : '' }}>
                                {{ d_trans('Active') }}
                            </option>
                            <option value="inactive"
                                {{ old('product_test_status', $productTest->status ?? 'active') === 'inactive' ? 'selected' : '' }}>
                                {{ d_trans('Inactive') }}
                            </option>
                        </select>
                    </div>

                    {{-- ── Test Attributes ── --}}
                    <div class="col-12 mt-2">
                        <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                            <h6 class="mb-0">{{ d_trans('Test Attributes') }}</h6>

                            @if ($testAttributes->count())
                                <div class="d-flex gap-2 align-items-center">
                                    <select id="attr-picker" class="form-select form-select-sm select2-attr-picker"
                                        style="min-width:250px;">
                                        <option value="">— {{ d_trans('Add Attribute') }} —</option>
                                        @foreach ($testAttributes as $attr)
                                            <option value="{{ $attr->id }}" data-type="{{ $attr->type }}"
                                                data-name="{{ $attr->name }}"
                                                data-options="{{ json_encode($attr->options ?? []) }}">
                                                {{ $attr->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" id="add-attr-btn" class="btn btn-sm btn-success">
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <div id="attr-rows" class="row g-3">
                            {{-- If a product test exists (either for this product or a template) --}}
                            @if ($productTest && $productTest->data)
                                @foreach ($testAttributes as $attr)
                                    @php
                                        $savedValue = array_key_exists($attr->id, $productTest->data)
                                            ? $productTest->data[$attr->id]
                                            : '__MISSING__';
                                    @endphp

                                    {{-- Only render if the attribute was in the test data --}}
                                    @if ($savedValue !== '__MISSING__')
                                        <div class="col-md-6 attr-row" data-id="{{ $attr->id }}">
                                            <div class="card h-100 border">
                                                <div class="card-body p-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <label
                                                            class="form-label mb-0 fw-semibold">{{ $attr->name }}</label>
                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger remove-attr-btn"
                                                            title="{{ d_trans('Remove') }}">
                                                            <i class="fa-solid fa-xmark"></i>
                                                        </button>
                                                    </div>

                                                    @if ($attr->type === 'boolean')
                                                        <div class="form-check form-switch mt-1">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="test_attribute[{{ $attr->id }}]"
                                                                id="attr_{{ $attr->id }}" value="1"
                                                                {{-- For templates, don't check old values --}}
                                                                {{ old('test_attribute.' . $attr->id, $savedValue) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="attr_{{ $attr->id }}">
                                                                {{ d_trans('Yes') }}
                                                            </label>
                                                        </div>
                                                    @elseif ($attr->type === 'select' && $attr->options)
                                                        <select name="test_attribute[{{ $attr->id }}]"
                                                            class="form-select form-select-md">
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
                                                            name="test_attribute[{{ $attr->id }}]"
                                                            class="form-control form-control-md"
                                                            value="{{ $productTest->exists ? old('test_attribute.' . $attr->id, $savedValue) : old('test_attribute.' . $attr->id, '') }}">
                                                    @else
                                                        <input type="text" name="test_attribute[{{ $attr->id }}]"
                                                            class="form-control form-control-md"
                                                            value="{{ $productTest->exists ? old('test_attribute.' . $attr->id, $savedValue) : old('test_attribute.' . $attr->id, '') }}">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            {{-- Placeholder shown when no rows --}}
                            <div id="no-attr-msg" class="col-12 text-muted fst-italic"
                                style="{{ $productTest && !empty($productTest->data) ? 'display:none' : '' }}">
                                {{ d_trans('No attributes added yet. Use the dropdown above to add one.') }}
                            </div>
                        </div>
                    </div>

                    {{-- Save --}}
                    <div class="col-12 mt-2">
                        <button type="submit" class="btn btn-primary btn-md">
                            {{ d_trans('Save Product Test') }}
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    @push('styles')
        <link href="{{ asset('vendor/admin/css/select2.min.css') }}" rel="stylesheet">
        <style>
            .select2-attr-picker+.select2-container {
                min-width: 250px;
            }

            .select2-container--default .select2-selection--single {
                height: 38px;
                border: 1px solid #ced4da;
                border-radius: 6px;
                display: flex;
                align-items: center;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 38px;
                padding-left: 12px;
                color: #495057;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 36px;
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

                // Initialize Select2
                $picker.select2({
                    placeholder: '— {{ d_trans('Add Attribute') }} —',
                    allowClear: true,
                    width: 'resolve',
                });

                // Track which IDs are currently shown
                function shownIds() {
                    return [...rows.querySelectorAll('.attr-row')].map(r => r.dataset.id);
                }

                // Refresh picker: disable/hide already-shown options then refresh Select2
                function refreshPicker() {
                    const shown = shownIds();
                    $picker.find('option').each(function() {
                        if (!this.value) return;
                        $(this).prop('disabled', shown.includes(this.value));
                    });
                    $picker.val('').trigger('change'); // reset selection
                    // Update no-message visibility
                    noMsg.style.display = rows.querySelectorAll('.attr-row').length ? 'none' : '';
                }

                // Build an input HTML string for a given type
                function buildInput(id, type, options) {
                    if (type === 'boolean') {
                        return `
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox"
                                    name="test_attribute[${id}]"
                                    id="attr_${id}" value="1">
                                <label class="form-check-label" for="attr_${id}">{{ d_trans('Yes') }}</label>
                            </div>`;
                    }
                    if (type === 'select') {
                        const opts = options.map(o => `<option value="${o}">${o}</option>`).join('');
                        return `<select name="test_attribute[${id}]" class="form-select form-select-md">
                                    <option value="">{{ d_trans('Select') }}</option>
                                    ${opts}
                                </select>`;
                    }
                    if (type === 'number') {
                        return `<input type="number" step="any" name="test_attribute[${id}]" class="form-control form-control-md">`;
                    }
                    return `<input type="text" name="test_attribute[${id}]" class="form-control form-control-md">`;
                }

                // Add a new attribute row dynamically
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
                        <div class="card h-100 border">
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label mb-0 fw-semibold">${name}</label>
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-attr-btn" title="{{ d_trans('Remove') }}">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                                ${buildInput(id, type, options)}
                            </div>
                        </div>`;

                    rows.appendChild(col);
                    attachRemove(col);
                    refreshPicker();
                });

                // Attach remove listener to a row
                function attachRemove(row) {
                    row.querySelector('.remove-attr-btn').addEventListener('click', function() {
                        row.remove();
                        refreshPicker();
                    });
                }

                // Attach to pre-rendered rows
                rows.querySelectorAll('.attr-row').forEach(row => attachRemove(row));

                // Initial picker state
                refreshPicker();
            });
        </script>
    @endpush
@endsection
