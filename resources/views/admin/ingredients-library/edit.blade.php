@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Ingredient Library'))
@section('title', d_trans('Ingredient Library'))
@section('header_title', d_trans('Edit Ingredient'))
@section('back', route('admin.ingredients-library.index'))
@section('form', true)
@section('content')

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="submittedForm" action="{{ route('admin.ingredients-library.update', $ingredient->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- Left / Main Column --}}
            <div class="col-12 col-lg-8">

                {{-- Identity Card --}}
                <div class="ing-form-card mb-4">
                    <div class="ing-form-card-header">
                        <i class="fa-solid fa-flask me-2"></i>{{ d_trans('Identity') }}
                    </div>
                    <div class="ing-form-card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="ing-label">{{ d_trans('Name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="ing-input @error('name') is-invalid @enderror"
                                    value="{{ old('name', $ingredient->name) }}" required>
                                @error('name')
                                    <div class="ing-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="ing-label">{{ d_trans('INCI Name') }}</label>
                                <input type="text" name="inci_name" class="ing-input @error('inci_name') is-invalid @enderror"
                                    value="{{ old('inci_name', $ingredient->inci_name) }}">
                                @error('inci_name')
                                    <div class="ing-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="ing-label">{{ d_trans('CAS Number') }}</label>
                                <input type="text" name="cas_number" class="ing-input @error('cas_number') is-invalid @enderror"
                                    value="{{ old('cas_number', $ingredient->cas_number) }}" placeholder="e.g. 50-00-0">
                                @error('cas_number')
                                    <div class="ing-error">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="ing-label">{{ d_trans('Regulatory Status') }}</label>
                                <input type="text" name="regulatory_status" class="ing-input @error('regulatory_status') is-invalid @enderror"
                                    value="{{ old('regulatory_status', $ingredient->regulatory_status) }}" placeholder="e.g. EU Banned">
                                @error('regulatory_status')
                                    <div class="ing-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Safety Card --}}
                <div class="ing-form-card mb-4">
                    <div class="ing-form-card-header">
                        <i class="fa-solid fa-shield-halved me-2"></i>{{ d_trans('Safety Information') }}
                    </div>
                    <div class="ing-form-card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="ing-label">{{ d_trans('Description') }}</label>
                                <textarea name="description" class="ing-textarea @error('description') is-invalid @enderror"
                                    rows="3" placeholder="{{ d_trans('General description of this ingredient...') }}">{{ old('description', $ingredient->description) }}</textarea>
                                @error('description')<div class="ing-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="ing-label">{{ d_trans('Concern Description') }}</label>
                                <textarea name="concern_description" class="ing-textarea @error('concern_description') is-invalid @enderror"
                                    rows="4" placeholder="{{ d_trans('Describe the concern related to this ingredient...') }}">{{ old('concern_description', $ingredient->concern_description) }}</textarea>
                                @error('concern_description')<div class="ing-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="ing-label">{{ d_trans('Health Effects') }}</label>
                                <textarea name="health_effects" class="ing-textarea @error('health_effects') is-invalid @enderror"
                                    rows="4" placeholder="{{ d_trans('Describe known health effects...') }}">{{ old('health_effects', $ingredient->health_effects) }}</textarea>
                                @error('health_effects')<div class="ing-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="ing-label">{{ d_trans('Hazard Score') }} <span class="ing-hint-text">(0–10)</span></label>
                                <input type="number" name="hazard_score" min="0" max="10"
                                    class="ing-input @error('hazard_score') is-invalid @enderror"
                                    value="{{ old('hazard_score', $ingredient->hazard_score) }}" placeholder="0">
                                @error('hazard_score')<div class="ing-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="ing-label">{{ d_trans('Source') }}</label>
                                <input type="text" name="source"
                                    class="ing-input @error('source') is-invalid @enderror"
                                    value="{{ old('source', $ingredient->source) }}" placeholder="e.g. EWG, PubChem">
                                @error('source')<div class="ing-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="ing-label">{{ d_trans('Image') }}</label>

                                @if ($ingredient->image_url)
                                    <div class="ing-img-preview mb-2">
                                        <img src="{{ asset($ingredient->image_url) }}"
                                            alt="{{ $ingredient->name }}" id="edit-img-preview">
                                    </div>
                                @else
                                    <img src="" alt="" id="edit-img-preview" class="ing-img-preview mb-2" style="display:none">
                                @endif

                                <div class="ing-file-wrap @error('image_url') is-invalid @enderror">
                                    <input type="file" name="image_url" id="image_url_edit"
                                        class="ing-file-input" accept="image/jpg,image/jpeg,image/png,image/webp">
                                    <label for="image_url_edit" class="ing-file-label">
                                        <i class="fa-solid fa-cloud-arrow-up me-2"></i>
                                        <span id="edit-file-name">{{ d_trans('Replace image…') }}</span>
                                    </label>
                                </div>
                                <p class="ing-hint-text mt-1">JPG, PNG, WEBP — max 4 MB. {{ d_trans('Leave empty to keep current image.') }}</p>
                                @error('image_url')<div class="ing-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Concerns Array Card --}}
                <div class="ing-form-card mb-4">
                    <div class="ing-form-card-header">
                        <i class="fa-solid fa-circle-exclamation me-2"></i>{{ d_trans('Concerns') }}
                    </div>
                    <div class="ing-form-card-body">
                        <div id="concerns-wrapper">
                            @php $existingConcerns = old('concerns', $ingredient->concerns ?? []); @endphp
                            @foreach ($existingConcerns as $ci => $c)
                                <div class="concern-row row g-2 mb-3 align-items-start">
                                    <div class="col-12 col-md-4">
                                        <input type="text" name="concerns[{{ $ci }}][category]" class="ing-input"
                                            value="{{ $c['category'] ?? '' }}" placeholder="{{ d_trans('Category') }}">
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <input type="text" name="concerns[{{ $ci }}][concern_text]" class="ing-input"
                                            value="{{ $c['concern_text'] ?? '' }}" placeholder="{{ d_trans('Concern text') }}">
                                    </div>
                                    <div class="col-10 col-md-2">
                                        <input type="text" name="concerns[{{ $ci }}][reference_org]" class="ing-input"
                                            value="{{ $c['reference_org'] ?? '' }}" placeholder="{{ d_trans('Ref. org') }}">
                                    </div>
                                    <div class="col-2 col-md-1 d-flex align-items-center">
                                        <button type="button" class="concern-remove-btn" title="{{ d_trans('Remove') }}">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-concern" class="ing-add-row-btn mt-1">
                            <i class="fa-solid fa-plus me-1"></i>{{ d_trans('Add Concern') }}
                        </button>
                    </div>
                </div>

                {{-- Concern Flags Card --}}
                <div class="ing-form-card mb-4">
                    <div class="ing-form-card-header">
                        <i class="fa-solid fa-flag me-2"></i>{{ d_trans('Concern Flags') }}
                        <span class="ing-hint-text ms-1">(e.g. Cancer → Low)</span>
                    </div>
                    <div class="ing-form-card-body">
                        <div id="flags-wrapper">
                            @php $existingFlags = old('concern_flags', $ingredient->concern_flags ?? []); @endphp
                            @foreach ($existingFlags as $fk => $fv)
                                <div class="flag-row row g-2 mb-2">
                                    <div class="col-5">
                                        <input type="text" name="concern_flag_keys[]" class="ing-input"
                                            value="{{ $fk }}" placeholder="{{ d_trans('Flag name') }}">
                                    </div>
                                    <div class="col-5">
                                        <input type="text" name="concern_flag_values[]" class="ing-input"
                                            value="{{ $fv }}" placeholder="{{ d_trans('Level') }}">
                                    </div>
                                    <div class="col-2 d-flex align-items-center">
                                        <button type="button" class="flag-remove-btn" title="{{ d_trans('Remove') }}">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-flag" class="ing-add-row-btn mt-1">
                            <i class="fa-solid fa-plus me-1"></i>{{ d_trans('Add Flag') }}
                        </button>
                    </div>
                </div>

                {{-- Functions & Synonyms --}}
                <div class="ing-form-card">
                    <div class="ing-form-card-header">
                        <i class="fa-solid fa-tags me-2"></i>{{ d_trans('Functions & Synonyms') }}
                    </div>
                    <div class="ing-form-card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="ing-label">{{ d_trans('Functions') }}
                                    <span class="ing-hint-text">{{ d_trans('One per line') }}</span>
                                </label>
                                <textarea name="functions" class="ing-textarea @error('functions') is-invalid @enderror"
                                    rows="3">{{ old('functions', implode("\n", $ingredient->functions ?? [])) }}</textarea>
                                @error('functions')<div class="ing-error">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="ing-label">{{ d_trans('Synonyms / Aliases') }}
                                    <span class="ing-hint-text">{{ d_trans('One per line') }}</span>
                                </label>
                                <textarea name="synonyms" class="ing-textarea @error('synonyms') is-invalid @enderror"
                                    rows="3">{{ old('synonyms', implode("\n", $ingredient->synonyms ?? [])) }}</textarea>
                                @error('synonyms')<div class="ing-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right / Sidebar --}}
            <div class="col-12 col-lg-4">

                {{-- Severity Card --}}
                <div class="ing-form-card mb-4">
                    <div class="ing-form-card-header">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ d_trans('Severity') }}
                    </div>
                    <div class="ing-form-card-body">
                        <div class="ing-severity-grid">
                            @foreach (['none' => ['label' => 'None', 'icon' => 'fa-circle-check', 'cls' => 'sev-none'], 'caution' => ['label' => 'Caution', 'icon' => 'fa-circle-exclamation', 'cls' => 'sev-caution'], 'concern' => ['label' => 'Concern', 'icon' => 'fa-triangle-exclamation', 'cls' => 'sev-concern'], 'avoid' => ['label' => 'Avoid', 'icon' => 'fa-ban', 'cls' => 'sev-avoid']] as $val => $sev)
                                <label class="ing-severity-option {{ $sev['cls'] }}">
                                    <input type="radio" name="severity" value="{{ $val }}"
                                        {{ old('severity', $ingredient->severity ?? 'none') === $val ? 'checked' : '' }} hidden>
                                    <i class="fa-solid {{ $sev['icon'] }}"></i>
                                    <span>{{ d_trans($sev['label']) }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('severity')
                            <div class="ing-error mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Publish Card --}}
                <div class="ing-form-card mb-4">
                    <div class="ing-form-card-header">
                        <i class="fa-solid fa-globe me-2"></i>{{ d_trans('Visibility') }}
                    </div>
                    <div class="ing-form-card-body">
                        <label class="ing-toggle-wrap">
                            <div class="ing-toggle-info">
                                <span class="ing-toggle-label">{{ d_trans('Publish this ingredient') }}</span>
                                <span class="ing-toggle-hint">{{ d_trans('Visible to users when published') }}</span>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="is_published" value="1"
                                    id="is_published" {{ old('is_published', $ingredient->is_published) ? 'checked' : '' }}>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Flags Card --}}
                <div class="ing-form-card mb-4">
                    <div class="ing-form-card-header">
                        <i class="fa-solid fa-shield-check me-2"></i>{{ d_trans('Flags') }}
                    </div>
                    <div class="ing-form-card-body">
                        <label class="ing-toggle-wrap mb-3">
                            <div class="ing-toggle-info">
                                <span class="ing-toggle-label">{{ d_trans('OKO Verified') }}</span>
                                <span class="ing-toggle-hint">{{ d_trans('Reviewed and verified by OKO') }}</span>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="oko_verified" value="1"
                                    id="oko_verified" {{ old('oko_verified', $ingredient->oko_verified) ? 'checked' : '' }}>
                            </div>
                        </label>
                        <label class="ing-toggle-wrap">
                            <div class="ing-toggle-info">
                                <span class="ing-toggle-label">{{ d_trans('Inhalation Risk') }}</span>
                                <span class="ing-toggle-hint">{{ d_trans('Poses inhalation risk when aerosolized') }}</span>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" name="inhalation_risk_flag" value="1"
                                    id="inhalation_risk_flag" {{ old('inhalation_risk_flag', $ingredient->inhalation_risk_flag) ? 'checked' : '' }}>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Meta Info Card --}}
                <div class="ing-form-card">
                    <div class="ing-form-card-header">
                        <i class="fa-solid fa-circle-info me-2"></i>{{ d_trans('Meta') }}
                    </div>
                    <div class="ing-form-card-body">
                        <div class="ing-meta-row">
                            <span class="ing-meta-key">{{ d_trans('Found in Products') }}</span>
                            <span class="ing-meta-val">{{ $ingredient->found_in_count ?? 0 }}</span>
                        </div>
                        <div class="ing-meta-row">
                            <span class="ing-meta-key">{{ d_trans('Created') }}</span>
                            <span class="ing-meta-val">{{ $ingredient->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="ing-meta-row">
                            <span class="ing-meta-key">{{ d_trans('Updated') }}</span>
                            <span class="ing-meta-val">{{ $ingredient->updated_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Submit --}}
            <div class="col-12">
                <div class="d-flex gap-2">
                    <button type="submit" class="ing-btn-submit">
                        <i class="fa-solid fa-floppy-disk me-2"></i>{{ d_trans('Save Changes') }}
                    </button>
                    <a href="{{ route('admin.ingredients-library.show', $ingredient->id) }}" class="ing-btn-cancel">
                        {{ d_trans('Cancel') }}
                    </a>
                </div>
            </div>

        </div>
    </form>

    @push('styles')
        <style>
            :root {
                --ing-red: #dc2626; --ing-red-dark: #b91c1c;
                --ing-red-soft: rgba(220,38,38,0.08);
                --ing-bg: rgb(249,250,251);
                --ing-border: rgba(0,0,0,0.08);
                --ing-text: #1e293b; --ing-muted: #64748b;
            }

            .ing-form-card { background: #fff; border: 1px solid var(--ing-border); border-radius: 12px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.04); }
            .ing-form-card-header { padding: 14px 20px; border-bottom: 1px solid var(--ing-border); background: var(--ing-bg); font-size: 0.82rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--ing-muted); }
            .ing-form-card-body { padding: 20px; }

            .ing-label { display: block; font-size: 0.82rem; font-weight: 600; color: var(--ing-text); margin-bottom: 6px; }
            .ing-hint-text { font-size: 0.75rem; font-weight: 400; color: var(--ing-muted); }
            .ing-input, .ing-textarea {
                width: 100%; padding: 9px 14px;
                border: 1px solid var(--ing-border); border-radius: 8px;
                font-size: 0.875rem; background: #fff; color: var(--ing-text);
                transition: border-color 0.18s, box-shadow 0.18s; outline: none;
            }
            .ing-textarea { resize: vertical; }
            .ing-input:focus, .ing-textarea:focus { border-color: var(--ing-red); box-shadow: 0 0 0 3px rgba(220,38,38,0.1); }
            .ing-error { font-size: 0.8rem; color: #dc2626; margin-top: 4px; }

            .ing-severity-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
            .ing-severity-option {
                display: flex; align-items: center; gap: 8px;
                padding: 10px 14px; border-radius: 10px; border: 2px solid transparent;
                cursor: pointer; font-size: 0.82rem; font-weight: 600;
                transition: all 0.18s; background: var(--ing-bg);
            }
            .ing-severity-option i { font-size: 1rem; }
            .sev-none    { color: #64748b; } .sev-none:has(input:checked)    { border-color: #64748b; background: rgba(100,116,139,0.08); }
            .sev-caution { color: #a16207; } .sev-caution:has(input:checked) { border-color: #ca8a04; background: rgba(202,138,4,0.08); }
            .sev-concern { color: #ea580c; } .sev-concern:has(input:checked) { border-color: #ea580c; background: rgba(234,88,12,0.08); }
            .sev-avoid   { color: #dc2626; } .sev-avoid:has(input:checked)   { border-color: #dc2626; background: rgba(220,38,38,0.08); }
            .ing-severity-option:hover { transform: translateY(-1px); box-shadow: 0 2px 8px rgba(0,0,0,0.06); }

            .ing-toggle-wrap { display: flex; align-items: center; justify-content: space-between; gap: 12px; cursor: pointer; }
            .ing-toggle-label { display: block; font-size: 0.875rem; font-weight: 600; color: var(--ing-text); }
            .ing-toggle-hint  { display: block; font-size: 0.78rem; color: var(--ing-muted); margin-top: 2px; }
            .form-check-input { width: 40px; height: 22px; cursor: pointer; }
            .form-check-input:checked { background-color: var(--ing-red); border-color: var(--ing-red); }
            .form-check-input:focus { box-shadow: 0 0 0 3px rgba(220,38,38,0.15); }

            .ing-meta-row { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid var(--ing-border); }
            .ing-meta-row:last-child { border-bottom: none; }
            .ing-meta-key { font-size: 0.8rem; color: var(--ing-muted); }
            .ing-meta-val { font-size: 0.82rem; font-weight: 600; color: var(--ing-text); }

            .ing-btn-submit {
                display: inline-flex; align-items: center;
                padding: 10px 24px; background: var(--ing-red); color: #fff;
                border: none; border-radius: 8px; font-size: 0.9rem; font-weight: 600;
                cursor: pointer; text-decoration: none; transition: background 0.18s;
            }
            .ing-btn-submit:hover { background: var(--ing-red-dark); }
            .ing-btn-cancel {
                display: inline-flex; align-items: center;
                padding: 10px 20px; background: transparent; color: var(--ing-muted);
                border: 1px solid var(--ing-border); border-radius: 8px;
                font-size: 0.9rem; font-weight: 500; cursor: pointer; text-decoration: none;
                transition: background 0.18s, color 0.18s;
            }
            .ing-btn-cancel:hover { background: var(--ing-red-soft); color: var(--ing-red); }

            .ing-add-row-btn {
                display: inline-flex; align-items: center; gap: 6px;
                padding: 7px 14px; background: var(--ing-bg); color: var(--ing-muted);
                border: 1px dashed var(--ing-border); border-radius: 8px;
                font-size: 0.82rem; font-weight: 600; cursor: pointer; transition: all 0.18s;
            }
            .ing-add-row-btn:hover { border-color: var(--ing-red); color: var(--ing-red); }
            .concern-remove-btn, .flag-remove-btn {
                background: none; border: none; color: #94a3b8; cursor: pointer;
                padding: 4px 8px; border-radius: 6px; transition: color 0.15s;
            }
            .concern-remove-btn:hover, .flag-remove-btn:hover { color: #dc2626; }

            /* File input */
            .ing-file-wrap { position: relative; }
            .ing-file-input { position: absolute; inset: 0; opacity: 0; width: 100%; cursor: pointer; z-index: 2; }
            .ing-file-label {
                display: flex; align-items: center; width: 100%;
                padding: 9px 14px; border: 1px dashed var(--ing-border); border-radius: 8px;
                font-size: 0.875rem; color: var(--ing-muted); background: #fff;
                cursor: pointer; transition: border-color 0.18s, color 0.18s;
            }
            .ing-file-wrap:hover .ing-file-label,
            .ing-file-input:focus + .ing-file-label { border-color: var(--ing-red); color: var(--ing-red); }

            /* Image preview */
            .ing-img-preview { border-radius: 8px; overflow: hidden; border: 1px solid var(--ing-border); display: inline-block; max-width: 100%; }
            .ing-img-preview img { display: block; max-height: 160px; max-width: 100%; object-fit: contain; }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Show selected filename and live-preview the chosen image
            document.getElementById('image_url_edit').addEventListener('change', function () {
                const label   = document.getElementById('edit-file-name');
                const preview = document.getElementById('edit-img-preview');
                if (this.files[0]) {
                    label.textContent = this.files[0].name;
                    const reader = new FileReader();
                    reader.onload = e => {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            let concernIdx = {{ count(old('concerns', $ingredient->concerns ?? [])) }};
            document.getElementById('add-concern').addEventListener('click', function () {
                const wrapper = document.getElementById('concerns-wrapper');
                wrapper.insertAdjacentHTML('beforeend', `
                    <div class="concern-row row g-2 mb-3 align-items-start">
                        <div class="col-12 col-md-4">
                            <input type="text" name="concerns[${concernIdx}][category]" class="ing-input" placeholder="{{ d_trans('Category') }}">
                        </div>
                        <div class="col-12 col-md-5">
                            <input type="text" name="concerns[${concernIdx}][concern_text]" class="ing-input" placeholder="{{ d_trans('Concern text') }}">
                        </div>
                        <div class="col-10 col-md-2">
                            <input type="text" name="concerns[${concernIdx}][reference_org]" class="ing-input" placeholder="{{ d_trans('Ref. org') }}">
                        </div>
                        <div class="col-2 col-md-1 d-flex align-items-center">
                            <button type="button" class="concern-remove-btn"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>`);
                concernIdx++;
            });
            document.getElementById('concerns-wrapper').addEventListener('click', function (e) {
                if (e.target.closest('.concern-remove-btn')) e.target.closest('.concern-row').remove();
            });

            document.getElementById('add-flag').addEventListener('click', function () {
                const wrapper = document.getElementById('flags-wrapper');
                wrapper.insertAdjacentHTML('beforeend', `
                    <div class="flag-row row g-2 mb-2">
                        <div class="col-5"><input type="text" name="concern_flag_keys[]" class="ing-input" placeholder="{{ d_trans('Flag name') }}"></div>
                        <div class="col-5"><input type="text" name="concern_flag_values[]" class="ing-input" placeholder="{{ d_trans('Level') }}"></div>
                        <div class="col-2 d-flex align-items-center">
                            <button type="button" class="flag-remove-btn"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>`);
            });
            document.getElementById('flags-wrapper').addEventListener('click', function (e) {
                if (e.target.closest('.flag-remove-btn')) e.target.closest('.flag-row').remove();
            });
        </script>
    @endpush

@endsection
