@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Products'))
@section('title', d_trans('Lab Tests'))
@section('header_title', d_trans(':product_name Lab Tests', ['product_name' => $product->name]))
@section('back', route('admin.products.index'))
@section('content')
    @include('admin.products.includes.tabs')
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">{{ d_trans('Lab Test Results') }}</h5>
        </div>
        <div class="card-body">
            @php
                $lab = $product->labTestingResult;
                $concerns = $product->ingredientConcerns;
            @endphp
            <form action="{{ route('admin.products.lab-tests.update', $product->id) }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ d_trans('Mineral UV Filter') }}</label>
                        <input type="text" name="mineral_uv_filter" class="form-control form-control-md"
                            value="{{ old('mineral_uv_filter', $lab->mineral_uv_filter ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ d_trans('Lab Name') }}</label>
                        <input type="text" name="lab_name" class="form-control form-control-md"
                            value="{{ old('lab_name', $lab->lab_name ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">{{ d_trans('Ingredient Grade') }}</label>
                        <select name="ingredient_grade" class="form-select form-select-md">
                            <option value="">{{ d_trans('None') }}</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade }}" @selected(old('ingredient_grade', $lab->ingredient_grade ?? null) == $grade)>
                                    {{ str_replace('_', ' ', ucfirst($grade)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ d_trans('Defects Grade') }}</label>
                        <select name="defects_grade" class="form-select form-select-md">
                            <option value="">{{ d_trans('None') }}</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade }}" @selected(old('defects_grade', $lab->defects_grade ?? null) == $grade)>
                                    {{ str_replace('_', ' ', ucfirst($grade)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ d_trans('Overall Grade') }}</label>
                        <select name="overall_grade" class="form-select form-select-md">
                            <option value="">{{ d_trans('None') }}</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade }}" @selected(old('overall_grade', $lab->overall_grade ?? null) == $grade)>
                                    {{ str_replace('_', ' ', ucfirst($grade)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">{{ d_trans('Tested At') }}</label>
                        <input type="date" name="tested_at" class="form-control form-control-md"
                            value="{{ old('tested_at', isset($lab) && $lab?->tested_at ? $lab->tested_at->format('Y-m-d') : '') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ d_trans('Footnote Ref') }}</label>
                        <input type="text" name="footnote_ref" class="form-control form-control-md"
                            value="{{ old('footnote_ref', $lab->footnote_ref ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="concerning_uv_filter"
                                name="concerning_uv_filter" value="1" @checked(old('concerning_uv_filter', $lab->concerning_uv_filter ?? false))>
                            <label class="form-check-label"
                                for="concerning_uv_filter">{{ d_trans('Concerning UV Filter') }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="has_fragrance"
                                name="has_fragrance" value="1" @checked(old('has_fragrance', $lab->has_fragrance ?? false))>
                            <label class="form-check-label" for="has_fragrance">{{ d_trans('Has Fragrance') }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="plastic_compounds"
                                name="plastic_compounds" value="1" @checked(old('plastic_compounds', $lab->plastic_compounds ?? false))>
                            <label class="form-check-label"
                                for="plastic_compounds">{{ d_trans('Plastic Compounds') }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="further_concerns"
                                name="further_concerns" value="1" @checked(old('further_concerns', $lab->further_concerns ?? false))>
                            <label class="form-check-label"
                                for="further_concerns">{{ d_trans('Further Concerns') }}</label>
                        </div>
                        <input type="text" name="further_concerns_detail" class="form-control form-control-md mt-2"
                            placeholder="{{ d_trans('Further concerns detail') }}"
                            value="{{ old('further_concerns_detail', $lab->further_concerns_detail ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="further_defects"
                                name="further_defects" value="1" @checked(old('further_defects', $lab->further_defects ?? false))>
                            <label class="form-check-label"
                                for="further_defects">{{ d_trans('Further Defects') }}</label>
                        </div>
                        <input type="text" name="further_defects_detail" class="form-control form-control-md mt-2"
                            placeholder="{{ d_trans('Further defects detail') }}"
                            value="{{ old('further_defects_detail', $lab->further_defects_detail ?? '') }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Test Summary') }}</label>
                        <textarea name="test_summary" class="form-control form-control-md" rows="3">{{ old('test_summary', $lab->test_summary ?? '') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">{{ d_trans('Footnote Text') }}</label>
                        <textarea name="footnote_text" class="form-control form-control-md" rows="2">{{ old('footnote_text', $lab->footnote_text ?? '') }}</textarea>
                    </div>

                    <div class="col-12 mt-2">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">{{ d_trans('Ingredient Concerns') }}</h6>
                            <button type="button" class="btn btn-sm btn-success" id="add-concern-btn">
                                <i class="fa-solid fa-plus"></i> {{ d_trans('Add Ingredient') }}
                            </button>
                        </div>

                        <div class="row g-2" id="concerns-container">
                            @php
                                $oldConcerns = old('concerns');
                                $rows = is_array($oldConcerns)
                                    ? $oldConcerns
                                    : ($concerns->count()
                                        ? $concerns->toArray()
                                        : [[]]);
                            @endphp

                            @foreach ($rows as $index => $concern)
                                <div class="col-12 border rounded-3 p-3 concern-row bg-light">
                                    <div class="row g-3 align-items-end">
                                        <!-- Library Select -->
                                        <div class="col-md-2">
                                            <label
                                                class="form-label small text-muted mb-1">{{ d_trans('Library') }}</label>
                                            <select name="concerns[{{ $index }}][ingredient_library_id]"
                                                class="form-select form-select-md ingredient-library-select"
                                                data-index="{{ $index }}">
                                                <option value="">{{ d_trans('Select') }}</option>
                                                @foreach ($ingredientLibraries as $ingredient)
                                                    <option value="{{ $ingredient->id }}"
                                                        {{ ($concern['ingredient_library_id'] ?? '') == $ingredient->id ? 'selected' : '' }}
                                                        data-name="{{ $ingredient->name }}"
                                                        data-inci="{{ $ingredient->inci_name ?? '' }}">
                                                        {{ $ingredient->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Ingredient Name -->
                                        <div class="col-md-3">
                                            <label
                                                class="form-label small text-muted mb-1">{{ d_trans('Ingredient name') }}</label>
                                            <input type="text" name="concerns[{{ $index }}][ingredient_name]"
                                                class="form-control form-control-md ingredient-name"
                                                placeholder="{{ d_trans('Ingredient name') }}"
                                                value="{{ $concern['ingredient_name'] ?? '' }}">
                                        </div>

                                        <!-- Severity -->
                                        <div class="col-md-2">
                                            <label
                                                class="form-label small text-muted mb-1">{{ d_trans('Severity') }}</label>
                                            <select name="concerns[{{ $index }}][severity]"
                                                class="form-select form-select-md">
                                                <option value="">{{ d_trans('Severity') }}</option>
                                                <option value="avoid" @selected(($concern['severity'] ?? '') === 'avoid')>{{ d_trans('Avoid') }}
                                                </option>
                                                <option value="concern" @selected(($concern['severity'] ?? '') === 'concern')>
                                                    {{ d_trans('Concern') }}</option>
                                                <option value="caution" @selected(($concern['severity'] ?? '') === 'caution')>
                                                    {{ d_trans('Caution') }}</option>
                                            </select>
                                        </div>

                                        <!-- INCI Name -->
                                        <div class="col-md-3">
                                            <label
                                                class="form-label small text-muted mb-1">{{ d_trans('INCI name') }}</label>
                                            <input type="text" name="concerns[{{ $index }}][inci_name]"
                                                class="form-control form-control-md inci-name"
                                                placeholder="{{ d_trans('INCI name') }}"
                                                value="{{ $concern['inci_name'] ?? '' }}">
                                        </div>

                                        <!-- Concentration -->
                                        <div class="col-md-2">
                                            <label
                                                class="form-label small text-muted mb-1">{{ d_trans('Concentration') }}</label>
                                            <input type="number" step="0.0001" min="0"
                                                name="concerns[{{ $index }}][concentration]"
                                                class="form-control form-control-md"
                                                placeholder="{{ d_trans('Concentration') }}"
                                                value="{{ $concern['concentration'] ?? '' }}">
                                        </div>

                                        

                                        <!-- Delete Button -->
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm w-100 remove-concern-btn">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Description -->
                                        <div class="col-12">
                                            <label
                                                class="form-label small text-muted mb-1">{{ d_trans('Description') }}</label>
                                            <textarea name="concerns[{{ $index }}][description]" class="form-control form-control-md" rows="2"
                                                placeholder="{{ d_trans('Description') }}">{{ $concern['description'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <button class="btn btn-primary btn-md">{{ d_trans('Save Lab Tests') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const container = document.getElementById('concerns-container');
                const addBtn = document.getElementById('add-concern-btn');

                // Add new row
                addBtn?.addEventListener('click', function(e) {
                    e.preventDefault();
                    const rows = container.querySelectorAll('.concern-row');
                    const newIndex = rows.length;

                    const newRow = document.createElement('div');
                    newRow.className = 'col-12 border rounded-3 p-3 concern-row bg-light';
                    newRow.innerHTML = `
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label small text-muted mb-1">{{ d_trans('Library') }}</label>
                    <select name="concerns[${newIndex}][ingredient_library_id]" 
                            class="form-select form-select-md ingredient-library-select"
                            data-index="${newIndex}">
                        <option value="">{{ d_trans('Select') }}</option>
                        @foreach ($ingredientLibraries as $ingredient)
                            <option value="{{ $ingredient->id }}" 
                                    data-name="{{ $ingredient->name }}"
                                    data-inci="{{ $ingredient->inci_name ?? '' }}">
                                {{ $ingredient->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">{{ d_trans('Ingredient name') }}</label>
                    <input type="text" name="concerns[${newIndex}][ingredient_name]" 
                           class="form-control form-control-md ingredient-name" placeholder="{{ d_trans('Ingredient name') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted mb-1">{{ d_trans('Severity') }}</label>
                    <select name="concerns[${newIndex}][severity]" class="form-select form-select-md">
                        <option value="">{{ d_trans('Severity') }}</option>
                        <option value="avoid">{{ d_trans('Avoid') }}</option>
                        <option value="concern">{{ d_trans('Concern') }}</option>
                        <option value="caution">{{ d_trans('Caution') }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted mb-1">{{ d_trans('INCI name') }}</label>
                    <input type="text" name="concerns[${newIndex}][inci_name]" 
                           class="form-control form-control-md inci-name" placeholder="{{ d_trans('INCI name') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small text-muted mb-1">{{ d_trans('Concentration') }}</label>
                    <input type="number" step="0.0001" min="0" 
                           name="concerns[${newIndex}][concentration]" 
                           class="form-control form-control-md" placeholder="{{ d_trans('Concentration') }}">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm w-100 remove-concern-btn">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
                <div class="col-12">
                    <label class="form-label small text-muted mb-1">{{ d_trans('Description') }}</label>
                    <textarea name="concerns[${newIndex}][description]" 
                              class="form-control form-control-md" rows="2" 
                              placeholder="{{ d_trans('Description') }}"></textarea>
                </div>
            </div>
        `;

                    container.appendChild(newRow);
                    attachListeners(newRow);
                });

                // Auto-fill on library select
                function attachListeners(row) {
                    const select = row.querySelector('.ingredient-library-select');
                    if (select) {
                        select.addEventListener('change', function() {
                            const option = this.options[this.selectedIndex];
                            if (option.value) {
                                const parentRow = this.closest('.concern-row');
                                parentRow.querySelector('.ingredient-name').value = option.dataset.name || '';
                                parentRow.querySelector('.inci-name').value = option.dataset.inci || '';
                            }
                        });
                    }

                    // Remove button
                    const removeBtn = row.querySelector('.remove-concern-btn');
                    if (removeBtn) {
                        removeBtn.addEventListener('click', function() {
                            if (document.querySelectorAll('.concern-row').length > 1) {
                                row.remove();
                            } else {
                                alert('{{ d_trans('You must keep at least one ingredient concern') }}');
                            }
                        });
                    }
                }

                // Attach to existing rows
                document.querySelectorAll('.concern-row').forEach(row => attachListeners(row));
            });
        </script>
    @endpush
@endsection
