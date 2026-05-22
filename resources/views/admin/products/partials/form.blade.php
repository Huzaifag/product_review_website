<div class="row g-3 mb-4">

    {{-- Images --}}
    <div class="col-12">
        <label class="lab-label">{{ d_trans('Images') }}</label>
        <input id="productImagesInput" type="file" name="images[]" class="lab-file-input"
            accept="image/png, image/jpg, image/jpeg, image/webp" multiple>
        <small
            class="lab-hint d-block mt-1">{{ d_trans('You can select multiple images at once or pick more images again before saving.') }}</small>
        <small
            class="lab-hint d-block">{{ d_trans('The first uploaded image will be saved as the main product image.') }}</small>
        <div class="d-flex align-items-center gap-2 mt-2">
            <small id="selectedImagesInfo" class="lab-hint"></small>
            <button id="clearSelectedImagesBtn" type="button"
                class="lab-clear-btn d-none">{{ d_trans('Clear selected') }}</button>
        </div>
        @php
            $currentProduct = $product ?? null;
            $mainImagePath = null;
            $galleryImages = collect();
            if ($currentProduct) {
                $mainImagePath = $currentProduct->image ?: optional($currentProduct->images->first())->path;
                $galleryImages = $currentProduct->images->reject(fn($img) => $img->path === $mainImagePath);
            }
        @endphp
        @if ($mainImagePath || $galleryImages->count() > 0)
            <div class="mt-3 d-flex flex-wrap gap-3">
                @if ($mainImagePath)
                    <div class="lab-thumb-wrap lab-thumb-main">
                        <img src="{{ asset($mainImagePath) }}" alt="{{ $currentProduct->name ?? '' }}">
                        <span class="lab-thumb-badge">{{ d_trans('Main') }}</span>
                    </div>
                @endif
                @foreach ($galleryImages as $image)
                    <div class="lab-thumb-wrap">
                        <img src="{{ asset($image->path) }}" alt="{{ $currentProduct->name ?? '' }}">
                        <span class="lab-thumb-badge lab-thumb-badge-gallery">{{ d_trans('Gallery') }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Name & Slug --}}
    <div class="col-lg-6">
        <label class="lab-label">{{ d_trans('Name') }}</label>
        <input id="slugTitle" type="text" name="name" class="lab-input"
            value="{{ old('name', d_trans($product->name ?? '') ?? '') }}" required>
    </div>
    <div class="col-lg-6">
        <label class="lab-label">{{ d_trans('Slug') }}</label>
        <input id="slugInput" type="text" name="slug" class="lab-input"
            value="{{ old('slug', $product->slug ?? '') }}">
    </div>

    {{-- Brand & Size --}}
    <div class="col-lg-6">
        <label class="lab-label">{{ d_trans('Brand') }}</label>
        <select name="brand_id" class="select2-brand lab-select" required>
            <option value="">{{ d_trans('Select Brand') }}</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id ?? null) == $brand->id)>
                    {{ $brand->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-6">
        <label class="lab-label">{{ d_trans('Product Size') }}</label>
        <input type="text" name="product_size" class="lab-input"
            value="{{ old('product_size', $product->product_size ?? '') }}">
    </div>

    {{-- Category & Sub Category --}}
    <div class="col-lg-6">
        <label class="lab-label">{{ d_trans('Category') }}</label>
        <select name="category_id" class="select2-category lab-select" required>
            <option value="">{{ d_trans('Select Category') }}</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? null) == $category->id)>
                    {{ $category->trans->name ?? $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-6">
        <label class="lab-label">{{ d_trans('Sub Category') }}</label>
        <select name="sub_category_id" class="select2-sub-category lab-select">
            <option value="">{{ d_trans('None') }}</option>
            @foreach ($subCategories as $subCategory)
                <option value="{{ $subCategory->id }}" @selected(old('sub_category_id', $product->sub_category_id ?? null) == $subCategory->id)>
                    {{ $subCategory->trans->name ?? $subCategory->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Price, Currency, Grade --}}
    <div class="col-lg-4">
        <label class="lab-label">{{ d_trans('Price') }}</label>
        <input type="number" step="0.01" min="0" name="price" class="lab-input"
            value="{{ old('price', $product->price ?? '') }}">
    </div>
    <div class="col-lg-4">
        <label class="lab-label">{{ d_trans('Currency') }}</label>
        <input type="text" maxlength="3" name="currency" class="lab-input"
            value="{{ old('currency', $product->currency ?? 'GBP') }}">
    </div>
    <div class="col-lg-4">
        <label class="lab-label">{{ d_trans('Overall Grade') }}</label>
        <select name="overall_grade" class="lab-select">
            <option value="">{{ d_trans('None') }}</option>
            @foreach ($grades as $grade)
                <option value="{{ $grade }}" @selected(old('overall_grade', $product->overall_grade ?? null) == $grade)>
                    {{ str_replace('_', ' ', ucfirst($grade)) }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Test Date, Year, Edition --}}
    <div class="col-lg-4">
        <label class="lab-label">{{ d_trans('Test Date') }}</label>
        <input type="date" name="test_date" class="lab-input"
            value="{{ old('test_date', isset($product) && $product->test_date ? $product->test_date->format('Y-m-d') : '') }}">
    </div>
    <div class="col-lg-4">
        <label class="lab-label">{{ d_trans('Test Year') }}</label>
        <input type="text" maxlength="4" name="test_year" class="lab-input"
            value="{{ old('test_year', $product->test_year ?? '') }}">
    </div>
    <div class="col-lg-4">
        <label class="lab-label">{{ d_trans('Edition') }}</label>
        <input type="text" name="test_edition" class="lab-input"
            value="{{ old('test_edition', $product->test_edition ?? '') }}">
    </div>

    {{-- Magazine Page & Organic Certifier --}}
    <div class="col-lg-6">
        <label class="lab-label">{{ d_trans('Magazine Page') }}</label>
        <input type="number" min="1" name="magazine_page" class="lab-input"
            value="{{ old('magazine_page', $product->magazine_page ?? '') }}">
    </div>
    <div class="col-lg-6">
        <label class="lab-label">{{ d_trans('Organic Certifier') }}</label>
        <input type="text" name="organic_certifier" class="lab-input"
            value="{{ old('organic_certifier', $product->organic_certifier ?? '') }}">
    </div>

    {{-- Description --}}
    <div class="col-12">
        <label class="lab-label">{{ d_trans('Description') }}</label>
        <textarea name="description" class="lab-input lab-textarea" rows="4">{{ old('description', d_trans($product->description ?? '') ?? '') }}</textarea>
    </div>

    {{-- Ingredients INCI --}}
    <div class="col-12">
        <label class="lab-label">{{ d_trans('Ingredients INCI') }}</label>
        <textarea name="ingredients_inci" class="lab-input lab-textarea" rows="4">{{ old('ingredients_inci', $product->ingredients_inci ?? '') }}</textarea>
    </div>

    {{-- Toggles --}}
    <div class="col-12">
        <div class="lab-toggles-row">
            <div class="lab-toggle-item">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input lab-switch" type="checkbox" role="switch" id="organic_certified"
                        name="organic_certified" value="1" @checked(old('organic_certified', $product->organic_certified ?? false))>
                    <label class="lab-toggle-label"
                        for="organic_certified">{{ d_trans('Organic Certified') }}</label>
                </div>
            </div>
            <div class="lab-toggle-item">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input lab-switch" type="checkbox" role="switch" id="lab_verified"
                        name="lab_verified" value="1" @checked(old('lab_verified', $product->lab_verified ?? false))>
                    <label class="lab-toggle-label" for="lab_verified">{{ d_trans('Lab Verified') }}</label>
                </div>
            </div>
            <div class="lab-toggle-item">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input lab-switch" type="checkbox" role="switch" id="is_featured"
                        name="is_featured" value="1" @checked(old('is_featured', $product->is_featured ?? false))>
                    <label class="lab-toggle-label" for="is_featured">{{ d_trans('Featured') }}</label>
                </div>
            </div>
            <div class="lab-toggle-item">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input lab-switch" type="checkbox" role="switch" id="is_active"
                        name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))>
                    <label class="lab-toggle-label" for="is_active">{{ d_trans('Active') }}</label>
                </div>
            </div>
        </div>
    </div>

</div>

<button class="lab-save-btn">
    <i class="fa-solid fa-floppy-disk me-2"></i>{{ $buttonLabel ?? d_trans('Save') }}
</button>

@once
    @push('styles')
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

            /* Labels */
            .lab-label {
                display: block;
                font-size: 0.78rem;
                font-weight: 700;
                /* color: rgba(220, 38, 38, 0.6); */
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-bottom: 6px;
            }

            /* Text / number / date inputs */
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
                box-sizing: border-box;
            }

            .lab-input:focus {
                border-color: var(--prod-red);
                box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            }

            .lab-textarea {
                resize: vertical;
                height: auto;
            }

            /* Select */
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
                box-sizing: border-box;
            }

            .lab-select:focus {
                border-color: var(--prod-red);
            }

            /* File input */
            .lab-file-input {
                width: 100%;
                padding: 7px 12px;
                border: 1px solid var(--prod-border);
                border-radius: 8px;
                font-size: 0.875rem;
                background: var(--prod-bg);
                color: var(--prod-text);
                cursor: pointer;
                outline: none;
            }

            .lab-file-input:focus {
                border-color: var(--prod-red);
            }

            .lab-file-input::file-selector-button {
                padding: 5px 12px;
                margin-right: 12px;
                background: var(--prod-red-soft);
                color: var(--prod-red);
                border: 1px solid rgba(220, 38, 38, 0.2);
                border-radius: 6px;
                font-size: 0.8rem;
                font-weight: 600;
                cursor: pointer;
                transition: background 0.18s;
            }

            .lab-file-input::file-selector-button:hover {
                background: rgba(220, 38, 38, 0.14);
            }

            /* Hint text */
            .lab-hint {
                font-size: 0.78rem;
                color: var(--prod-muted);
            }

            /* Clear button */
            .lab-clear-btn {
                padding: 3px 10px;
                font-size: 0.75rem;
                font-weight: 500;
                background: transparent;
                border: 1px solid var(--prod-border);
                border-radius: 6px;
                color: var(--prod-muted);
                cursor: pointer;
                transition: background 0.18s, color 0.18s;
            }

            .lab-clear-btn:hover {
                background: var(--prod-red-soft);
                color: var(--prod-red);
                border-color: rgba(220, 38, 38, 0.2);
            }

            /* Image thumbnails */
            .lab-thumb-wrap {
                position: relative;
                width: 88px;
                height: 88px;
                border-radius: 10px;
                overflow: hidden;
                border: 2px solid var(--prod-border);
            }

            .lab-thumb-wrap img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .lab-thumb-main {
                border-color: rgba(220, 38, 38, 0.4);
            }

            .lab-thumb-badge {
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(220, 38, 38, 0.85);
                color: #fff;
                font-size: 0.6rem;
                font-weight: 700;
                text-align: center;
                padding: 3px;
                text-transform: uppercase;
                letter-spacing: 0.4px;
            }

            .lab-thumb-badge-gallery {
                background: rgba(0, 0, 0, 0.5);
            }

            /* Toggle row */
            .lab-toggles-row {
                display: flex;
                flex-wrap: wrap;
                gap: 0;
                background: var(--prod-bg);
                border: 1px solid var(--prod-border);
                border-radius: 10px;
                overflow: hidden;
            }

            .lab-toggle-item {
                flex: 1;
                min-width: 160px;
                padding: 14px 18px;
                border-right: 1px solid var(--prod-border);
            }

            .lab-toggle-item:last-child {
                border-right: none;
            }

            .lab-toggle-label {
                font-size: 0.83rem;
                font-weight: 500;
                color: var(--prod-text);
                cursor: pointer;
                user-select: none;
            }

            .lab-switch {
                accent-color: var(--prod-red);
                cursor: pointer;
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

            /* Select2 override — match lab-input height & red focus */
            .select2-container {
                width: 100% !important;
            }

            .select2-container--default .select2-selection--single {
                height: 38px !important;
                border: 1px solid var(--prod-border) !important;
                border-radius: 8px !important;
                padding: 0 !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 36px !important;
                padding-left: 14px !important;
                padding-right: 32px !important;
                color: var(--prod-text) !important;
                font-size: 0.875rem;
            }

            .select2-container--default .select2-selection--single .select2-selection__placeholder {
                color: var(--prod-muted) !important;
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 36px !important;
                right: 6px !important;
            }

            .select2-container--default.select2-container--focus .select2-selection--single,
            .select2-container--default.select2-container--open .select2-selection--single {
                border-color: var(--prod-red) !important;
                box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
            }
        </style>
    @endpush

    @push('styles_libs')
        <link href="{{ asset('vendor/admin/css/select2.min.css') }}" rel="stylesheet" />
    @endpush

    @push('scripts_libs')
        <script src="{{ asset('vendor/admin/js/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/admin/js/select2.min.js') }}"></script>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.select2-brand').select2({
                    placeholder: "{{ d_trans('Select Brand') }}",
                    allowClear: true,
                    width: '100%'
                });
                $('.select2-category').select2({
                    placeholder: "{{ d_trans('Select Category') }}",
                    allowClear: true,
                    width: '100%'
                });
                $('.select2-sub-category').select2({
                    placeholder: "{{ d_trans('None') }}",
                    allowClear: true,
                    width: '100%'
                });
            });

            (function() {
                const input = document.getElementById('productImagesInput');
                const info = document.getElementById('selectedImagesInfo');
                const clearBtn = document.getElementById('clearSelectedImagesBtn');

                if (!input || input.dataset.multiUploadReady === '1') return;
                input.dataset.multiUploadReady = '1';

                const dataTransfer = new DataTransfer();

                function fileKey(file) {
                    return `${file.name}-${file.size}-${file.lastModified}`;
                }

                function syncPreview() {
                    if (!info || !clearBtn) return;
                    const files = Array.from(dataTransfer.files);
                    if (!files.length) {
                        info.textContent = '';
                        clearBtn.classList.add('d-none');
                        return;
                    }
                    info.textContent = `${files.length} {{ d_trans('image(s) selected') }}`;
                    clearBtn.classList.remove('d-none');
                }

                input.addEventListener('change', function() {
                    const existingKeys = new Set(Array.from(dataTransfer.files).map(fileKey));
                    Array.from(input.files).forEach(file => {
                        const key = fileKey(file);
                        if (!existingKeys.has(key)) {
                            dataTransfer.items.add(file);
                            existingKeys.add(key);
                        }
                    });
                    input.files = dataTransfer.files;
                    syncPreview();
                });

                if (clearBtn) {
                    clearBtn.addEventListener('click', function() {
                        while (dataTransfer.items.length > 0) dataTransfer.items.remove(0);
                        input.value = '';
                        input.files = dataTransfer.files;
                        syncPreview();
                    });
                }
            })
            ();
        </script>
    @endpush
@endonce
