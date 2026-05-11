<div class="{{ $search_params_classes ?? '' }}">
    <div class="d-none d-lg-block">
        <button class="btn btn-primary w-100 mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#searchFilters"
            aria-expanded="false" aria-controls="searchFilters">
            <i class="bi bi-funnel me-2"></i>{{ d_trans('Show Filters') }}
        </button>
    </div>
    <div id="searchFilters" class="collapse d-lg-block">
        <div class="row row-cols-1 g-3">
            <div class="col">
                <div class="item-box box">
                    @if (collect(request()->query())->except('page')->count() > 0)
                        <a href="{{ request()->url() }}" class="btn btn-outline-primary w-100 mb-3">
                            <i class="bi bi-arrow-repeat me-2"></i>{{ d_trans('Reset All') }}
                        </a>
                    @endif

                    <p class="fw-medium">{{ d_trans('Search') }}</p>
                    <form class="search-form" method="GET">
                        <div class="form-search form-search-reverse mb-4">
                            <button type="button" class="icon search-submit-btn">
                                <i class="bi bi-search"></i>
                            </button>
                            <input type="text" name="search" placeholder="{{ d_trans('Search...') }}"
                                class="form-control form-control-md search-param" value="{{ request('search') ?? '' }}">
                        </div>
                    </form>

                    <p class="fw-medium">{{ d_trans('Category') }}</p>
                    <div class="mb-3">
                        <select name="category" class="selectpicker selectpicker-md search-select"
                            title="{{ d_trans('Category') }}" data-size="10" data-live-search="true">
                            <option value="">{{ d_trans('All') }}</option>
                            @if (isset($search_categories) && $search_categories->count() > 0)
                                @foreach ($search_categories as $category)
                                    <option value="{{ $category->slug }}" @selected(request('category') == $category->slug)>
                                        {{ $category->trans->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <p class="fw-medium">{{ d_trans('Brand') }}</p>
                    <div class="mb-4">
                        <select name="brand" class="selectpicker selectpicker-md search-select"
                            title="{{ d_trans('Brand') }}" data-size="10" data-live-search="true">
                            <option value="">{{ d_trans('All') }}</option>
                            @foreach ($search_brands as $brand)
                                <option value="{{ $brand->slug }}" @selected(request('brand') == $brand->slug)>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <p class="fw-medium">{{ d_trans('Price Range') }}</p>
                    <div class="row row-cols-1 g-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="minPrice" class="form-label text-muted">{{ d_trans('Min Price') }}</label>
                                <input type="number" name="min_price" placeholder="0" step="0.01"
                                    class="form-control form-control-md search-param"
                                    value="{{ request('min_price') ?? '' }}">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="maxPrice" class="form-label text-muted">{{ d_trans('Max Price') }}</label>
                                <input type="number" name="max_price" placeholder="0" step="0.01"
                                    class="form-control form-control-md search-param"
                                    value="{{ request('max_price') ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="item-box box">
                    <p class="fw-medium">{{ d_trans('Certification') }}</p>
                    <div class="row row-cols-1 g-3">
                        <div class="col">
                            <div class="form-check d-flex align-items-center gap-2">
                                <input type="checkbox" name="organic_certified" value="1"
                                    class="form-check-input search-param my-0" id="certified1" />
                                <label class="form-check-label text-muted"
                                    for="certified1">{{ d_trans('Organic Certified') }}</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-check d-flex align-items-center gap-2">
                                <input type="checkbox" name="organic_certified" value="0"
                                    class="form-check-input search-param my-0" id="certified2" />
                                <label class="form-check-label text-muted"
                                    for="certified2">{{ d_trans('Not Certified') }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="item-box box">
                    <p class="fw-medium">{{ d_trans('Product Size') }}</p>
                    <div class="row row-cols-1 g-3">
                        <div class="col">
                            <input type="text" name="product_size"
                                placeholder="{{ d_trans('Enter product size') }}"
                                class="form-control form-control-md search-param"
                                value="{{ request('product_size') ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Mobile Filters (Offcanvas) --}}
<div id="searchFiltersMenu" class="d-block d-lg-none">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasLabel">{{ d_trans('Filters') }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row row-cols-1 g-3">

                <div class="col">
                    <div class="item-box box">
                        @if (collect(request()->query())->except('page')->count() > 0)
                            <a href="{{ request()->url() }}" class="btn btn-outline-primary w-100 mb-3">
                                <i class="bi bi-arrow-repeat me-2"></i>{{ d_trans('Reset All') }}
                            </a>
                        @endif

                        <p class="fw-medium">{{ d_trans('Search') }}</p>
                        <form class="search-form" method="GET">
                            <div class="form-search form-search-reverse mb-4">
                                <button type="button" class="icon search-submit-btn">
                                    <i class="bi bi-search"></i>
                                </button>
                                <input type="text" name="search" placeholder="{{ d_trans('Search...') }}"
                                    class="form-control form-control-md search-param" value="{{ request('search') ?? '' }}">
                            </div>
                        </form>

                        <p class="fw-medium">{{ d_trans('Category') }}</p>
                        <div class="mb-3">
                            <select name="category" class="selectpicker selectpicker-md search-select"
                                title="{{ d_trans('Category') }}" data-size="10" data-live-search="true">
                                <option value="">{{ d_trans('All') }}</option>
                                @if (isset($search_categories) && $search_categories->count() > 0)
                                    @foreach ($search_categories as $category)
                                        <option value="{{ $category->slug }}" @selected(request('category') == $category->slug)>
                                            {{ $category->trans->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <p class="fw-medium">{{ d_trans('Brand') }}</p>
                        <div class="mb-4">
                            <select name="brand" class="selectpicker selectpicker-md search-select"
                                title="{{ d_trans('Brand') }}" data-size="10" data-live-search="true">
                                <option value="">{{ d_trans('All') }}</option>
                                @foreach ($search_brands as $brand)
                                    <option value="{{ $brand->slug }}" @selected(request('brand') == $brand->slug)>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <p class="fw-medium">{{ d_trans('Price Range') }}</p>
                        <div class="row row-cols-1 g-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="minPrice2"
                                        class="form-label text-muted">{{ d_trans('Min Price') }}</label>
                                    <input type="number" id="minPrice2" name="min_price" placeholder="0"
                                        step="0.01" class="form-control form-control-md search-param"
                                        value="{{ request('min_price') ?? '' }}">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="maxPrice2"
                                        class="form-label text-muted">{{ d_trans('Max Price') }}</label>
                                    <input type="number" id="maxPrice2" name="max_price" placeholder="0"
                                        step="0.01" class="form-control form-control-md search-param"
                                        value="{{ request('max_price') ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="item-box box">
                        <p class="fw-medium">{{ d_trans('Certification') }}</p>
                        <div class="row row-cols-1 g-3">
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input type="checkbox" name="organic_certified" value="1"
                                        class="form-check-input search-param my-0" id="certified1m" />
                                    <label class="form-check-label text-muted"
                                        for="certified1m">{{ d_trans('Organic Certified') }}</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input type="checkbox" name="organic_certified" value="0"
                                        class="form-check-input search-param my-0" id="certified2m" />
                                    <label class="form-check-label text-muted"
                                        for="certified2m">{{ d_trans('Not Certified') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="item-box box">
                        <p class="fw-medium">{{ d_trans('Product Size') }}</p>
                        <div class="row row-cols-1 g-3">
                            <div class="col">
                                <input type="text" name="product_size"
                                    placeholder="{{ d_trans('Enter product size') }}"
                                    class="form-control form-control-md search-param"
                                    value="{{ request('product_size') ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('styles_libs')
    <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
@endpush
@push('scripts_libs')
    <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterInputs = document.querySelectorAll('.search-select');

            // Select dropdowns - submit immediately on change
            filterInputs.forEach(select => {
                select.addEventListener('change', function() {
                    submitFilters();
                });
            });

            // Prevent native form submission from refreshing the page unexpectedly.
            document.querySelectorAll('.search-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    submitFilters();
                });
            });

            document.querySelectorAll('.search-submit-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    submitFilters();
                });
            });

            const enterSubmitInputs = document.querySelectorAll(
                '.search-param:not([type="checkbox"])'
            );
            enterSubmitInputs.forEach(input => {
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        submitFilters();
                    }
                });
            });

            // Checkboxes
            const checkboxes = document.querySelectorAll('input[type="checkbox"].search-param');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', submitFilters);
            });

            function submitFilters() {
                const formData = new FormData();

                // Collect all filter values
                document.querySelectorAll('.search-param, .search-select').forEach(input => {
                    if (input.type === 'checkbox') {
                        if (input.checked) {
                            formData.append(input.name, input.value);
                        }
                    } else if (input.value) {
                        formData.append(input.name, input.value);
                    }
                });

                // Get current URL and update with new params
                const params = new URLSearchParams(formData);
                const url = new URL(window.location);

                // Clear existing params except those we want to keep
                url.search = '';

                // Add filtered params
                for (let [key, value] of params) {
                    url.searchParams.append(key, value);
                }

                // Navigate to new URL
                window.location.href = url.toString();
            }
        });
    </script>
@endpush
