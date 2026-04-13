<div class="row g-3 mb-4">
    <div class="col-12">
        <label class="form-label">{{ d_trans('Image') }}</label>
        <input type="file" name="image" class="form-control form-control-md" accept="image/png, image/jpg, image/jpeg, image/webp">
        @if (!empty($product?->image))
            <div class="mt-2">
                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="border rounded-3 p-1" width="80" height="80">
            </div>
        @endif
    </div>

    <div class="col-lg-6">
        <label class="form-label">{{ d_trans('Name') }}</label>
        <input type="text" name="name" class="form-control form-control-md" value="{{ old('name', $product->name ?? '') }}" required>
    </div>
    <div class="col-lg-6">
        <label class="form-label">{{ d_trans('Slug') }}</label>
        <input type="text" name="slug" class="form-control form-control-md" value="{{ old('slug', $product->slug ?? '') }}">
    </div>

    <div class="col-lg-6">
        <label class="form-label">{{ d_trans('Brand Name') }}</label>
        <input type="text" name="brand_name" class="form-control form-control-md" value="{{ old('brand_name', $product->brand_name ?? '') }}" required>
    </div>
    <div class="col-lg-6">
        <label class="form-label">{{ d_trans('Product Size') }}</label>
        <input type="text" name="product_size" class="form-control form-control-md" value="{{ old('product_size', $product->product_size ?? '') }}">
    </div>

    <div class="col-lg-6">
        <label class="form-label">{{ d_trans('Category') }}</label>
        <select name="category_id" class="form-select form-select-md" required>
            <option value="">{{ d_trans('Select Category') }}</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? null) == $category->id)>
                    {{ $category->trans->name ?? $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-lg-6">
        <label class="form-label">{{ d_trans('Sub Category') }}</label>
        <select name="sub_category_id" class="form-select form-select-md">
            <option value="">{{ d_trans('None') }}</option>
            @foreach ($subCategories as $subCategory)
                <option value="{{ $subCategory->id }}" @selected(old('sub_category_id', $product->sub_category_id ?? null) == $subCategory->id)>
                    {{ $subCategory->trans->name ?? $subCategory->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-4">
        <label class="form-label">{{ d_trans('Price') }}</label>
        <input type="number" step="0.01" min="0" name="price" class="form-control form-control-md" value="{{ old('price', $product->price ?? '') }}">
    </div>
    <div class="col-lg-4">
        <label class="form-label">{{ d_trans('Currency') }}</label>
        <input type="text" maxlength="3" name="currency" class="form-control form-control-md" value="{{ old('currency', $product->currency ?? 'GBP') }}">
    </div>
    <div class="col-lg-4">
        <label class="form-label">{{ d_trans('Overall Grade') }}</label>
        <select name="overall_grade" class="form-select form-select-md">
            <option value="">{{ d_trans('None') }}</option>
            @foreach ($grades as $grade)
                <option value="{{ $grade }}" @selected(old('overall_grade', $product->overall_grade ?? null) == $grade)>
                    {{ str_replace('_', ' ', ucfirst($grade)) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-4">
        <label class="form-label">{{ d_trans('Test Date') }}</label>
        <input type="date" name="test_date" class="form-control form-control-md" value="{{ old('test_date', isset($product) && $product->test_date ? $product->test_date->format('Y-m-d') : '') }}">
    </div>
    <div class="col-lg-4">
        <label class="form-label">{{ d_trans('Test Year') }}</label>
        <input type="text" maxlength="4" name="test_year" class="form-control form-control-md" value="{{ old('test_year', $product->test_year ?? '') }}">
    </div>
    <div class="col-lg-4">
        <label class="form-label">{{ d_trans('Edition') }}</label>
        <input type="text" name="test_edition" class="form-control form-control-md" value="{{ old('test_edition', $product->test_edition ?? '') }}">
    </div>

    <div class="col-lg-6">
        <label class="form-label">{{ d_trans('Magazine Page') }}</label>
        <input type="number" min="1" name="magazine_page" class="form-control form-control-md" value="{{ old('magazine_page', $product->magazine_page ?? '') }}">
    </div>
    <div class="col-lg-6">
        <label class="form-label">{{ d_trans('Organic Certifier') }}</label>
        <input type="text" name="organic_certifier" class="form-control form-control-md" value="{{ old('organic_certifier', $product->organic_certifier ?? '') }}">
    </div>

    <div class="col-12">
        <label class="form-label">{{ d_trans('Description') }}</label>
        <textarea name="description" class="form-control form-control-md" rows="4">{{ old('description', $product->description ?? '') }}</textarea>
    </div>
    <div class="col-12">
        <label class="form-label">{{ d_trans('Ingredients INCI') }}</label>
        <textarea name="ingredients_inci" class="form-control form-control-md" rows="4">{{ old('ingredients_inci', $product->ingredients_inci ?? '') }}</textarea>
    </div>

    <div class="col-md-3">
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" role="switch" id="organic_certified" name="organic_certified" value="1"
                @checked(old('organic_certified', $product->organic_certified ?? false))>
            <label class="form-check-label" for="organic_certified">{{ d_trans('Organic Certified') }}</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" role="switch" id="lab_verified" name="lab_verified" value="1"
                @checked(old('lab_verified', $product->lab_verified ?? false))>
            <label class="form-check-label" for="lab_verified">{{ d_trans('Lab Verified') }}</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1"
                @checked(old('is_featured', $product->is_featured ?? false))>
            <label class="form-check-label" for="is_featured">{{ d_trans('Featured') }}</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-check form-switch mt-2">
            <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1"
                @checked(old('is_active', $product->is_active ?? true))>
            <label class="form-check-label" for="is_active">{{ d_trans('Active') }}</label>
        </div>
    </div>
</div>

<button class="btn btn-primary btn-md">{{ $buttonLabel ?? d_trans('Save') }}</button>
