<div id="searchFilters" class="d-none d-lg-block {{ $search_params_classes ?? '' }}">
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
                        <button class="icon">
                            <i class="bi bi-search"></i>
                        </button>
                        <input type="text" name="search" placeholder="{{ d_trans('Search...') }}"
                            class="form-control form-control-md" value="{{ request('search') ?? '' }}">
                    </div>
                </form>
                <p class="fw-medium">{{ d_trans('Location') }}</p>
                <div class="mb-3">
                    <select name="country" class="selectpicker selectpicker-md search-select"
                        title="{{ d_trans('Country') }}" data-size="10" data-live-search="true">
                        <option value="">{{ d_trans('All') }}</option>
                        @foreach (countries() as $countryCode => $countryName)
                            <option value="{{ $countryCode }}" @selected(request('country') == $countryCode)>
                                {{ $countryName }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <form class="search-form" method="GET">
                    <div class="form-search form-search-reverse mb-4">
                        <button class="icon">
                            <i class="bi bi-search"></i>
                        </button>
                        <input type="text" name="city_zip" placeholder="{{ d_trans('City or ZIP code') }}"
                            class="form-control form-control-md" value="{{ request('city_zip') ?? '' }}">
                    </div>
                </form>
                <p class="fw-medium">{{ d_trans('Rating') }}</p>
                <div class="row row-cols-1 g-3">
                    <div class="col">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input id="rating5" type="checkbox" name="stars"
                                class="form-check-input search-param my-0" value="5" />
                            <label
                                class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                for="rating5">
                                <span class="text-muted">{{ d_trans('Excellent') }}</span>
                                <div class="ratings">
                                    <img src="{{ asset(config('theme.settings.stars.stars_5')) }}"
                                        alt="{{ d_trans('Excellent') }}">
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input id="rating4" type="checkbox" name="stars"
                                class="form-check-input search-param my-0" value="4" />
                            <label
                                class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                for="rating4">
                                <span class="text-muted">{{ d_trans('Great') }}</span>
                                <div class="ratings">
                                    <img src="{{ asset(config('theme.settings.stars.stars_4')) }}"
                                        alt="{{ d_trans('Great') }}">
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input id="rating3" type="checkbox" name="stars"
                                class="form-check-input search-param my-0" value="3" />
                            <label
                                class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                for="rating3">
                                <span class="text-muted">{{ d_trans('Average') }}</span>
                                <div class="ratings">
                                    <img src="{{ asset(config('theme.settings.stars.stars_3')) }}"
                                        alt="{{ d_trans('Average') }}">
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input id="rating2" type="checkbox" name="stars"
                                class="form-check-input search-param my-0" value="2" />
                            <label
                                class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                for="rating2">
                                <span class="text-muted">{{ d_trans('Fair') }}</span>
                                <div class="ratings">
                                    <img src="{{ asset(config('theme.settings.stars.stars_2')) }}"
                                        alt="{{ d_trans('Fair') }}">
                                </div>
                            </label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input id="rating1" type="checkbox" name="stars"
                                class="form-check-input search-param my-0" value="1" />
                            <label
                                class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                for="rating1">
                                <span class="text-muted">{{ d_trans('Poor') }}</span>
                                <div class="ratings">
                                    <img src="{{ asset(config('theme.settings.stars.stars_1')) }}"
                                        alt="{{ d_trans('Poor') }}">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="item-box box">
                <p class="fw-medium">{{ d_trans('Verification') }}</p>
                <div class="row row-cols-1 g-3">
                    <div class="col">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input type="checkbox" name="verified" value="1"
                                class="form-check-input search-param my-0" id="verified1" />
                            <label class="form-check-label text-muted"
                                for="verified1">{{ d_trans('Verified') }}</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input type="checkbox" name="verified" value="0"
                                class="form-check-input search-param my-0" id="verified2" />
                            <label class="form-check-label text-muted"
                                for="verified2">{{ d_trans('Unverified') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="item-box box">
                <p class="fw-medium">{{ d_trans('Status') }}</p>
                <div class="row row-cols-1 g-3">
                    <div class="col">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input type="checkbox" name="trending" value="1"
                                class="form-check-input search-param my-0" id="trending" />
                            <label class="form-check-label text-muted"
                                for="trending">{{ d_trans('Trending') }}</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input type="checkbox" name="best_rating" value="1"
                                class="form-check-input search-param my-0" id="best_rating" />
                            <label class="form-check-label text-muted"
                                for="best_rating">{{ d_trans('Best Rating') }}</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input type="checkbox" name="featured" value="1"
                                class="form-check-input search-param my-0" id="featured" />
                            <label class="form-check-label text-muted"
                                for="featured">{{ d_trans('Featured') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="item-box box">
                <p class="fw-medium">{{ d_trans('Review Time') }}</p>
                <div class="row row-cols-1 g-3">
                    <div class="col">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input type="checkbox" name="review_time" value=""
                                class="form-check-input search-param my-0" id="reviewTime1" />
                            <label class="form-check-label text-muted"
                                for="reviewTime1">{{ d_trans('Any time') }}</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input type="checkbox" name="review_time" value="this_month"
                                class="form-check-input search-param my-0" id="reviewTime2" />
                            <label class="form-check-label text-muted"
                                for="reviewTime2">{{ d_trans('This month') }}</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input type="checkbox" name="review_time" value="last_month"
                                class="form-check-input search-param my-0" id="reviewTime3" />
                            <label class="form-check-label text-muted"
                                for="reviewTime3">{{ d_trans('Last month') }}</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input type="checkbox" name="review_time" value="this_year"
                                class="form-check-input search-param my-0" id="reviewTime4" />
                            <label class="form-check-label text-muted"
                                for="reviewTime4">{{ d_trans('This year') }}</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-check d-flex align-items-center gap-2">
                            <input type="checkbox" name="review_time" value="last_year"
                                class="form-check-input search-param my-0" id="reviewTime5" />
                            <label class="form-check-label text-muted"
                                for="reviewTime5">{{ d_trans('Last year') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (isset($search_categories) && $search_categories->count() > 0)
            <div class="col">
                <div class="item-box box">
                    <p class="fw-medium">{{ $search_categories_title ?? d_trans('Categories') }}</p>
                    <ul class="list-group list-group-flush">
                        @foreach ($search_categories as $search_category)
                            <a href="{{ $search_category->getLink(request()->all()) }}"
                                class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 {{ !$loop->last ? 'mb-2' : '' }}">
                                <span>{{ $search_category->trans->name }}</span>
                                <i class="bi bi-tag"></i>
                            </a>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>
<div id="searchFiltersMenu" class="d-block d-lg-none">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvas" aria-labelledby="offcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">{{ d_trans('Filters') }}</h5>
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
                                <button class="icon">
                                    <i class="bi bi-search"></i>
                                </button>
                                <input type="text" name="search" placeholder="{{ d_trans('Search...') }}"
                                    class="form-control form-control-md" value="{{ request('search') ?? '' }}">
                            </div>
                        </form>
                        <p class="fw-medium">{{ d_trans('Location') }}</p>
                        <div class="mb-3">
                            <select name="country" class="selectpicker selectpicker-md search-select"
                                title="{{ d_trans('Country') }}" data-size="10" data-live-search="true">
                                <option value="">{{ d_trans('All') }}</option>
                                @foreach (countries() as $countryCode => $countryName)
                                    <option value="{{ $countryCode }}" @selected(request('country') == $countryCode)>
                                        {{ $countryName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <form class="search-form" method="GET">
                            <div class="form-search form-search-reverse mb-4">
                                <button class="icon">
                                    <i class="bi bi-search"></i>
                                </button>
                                <input type="text" name="city_zip"
                                    placeholder="{{ d_trans('City or ZIP code') }}"
                                    class="form-control form-control-md" value="{{ request('city_zip') ?? '' }}">
                            </div>
                        </form>
                        <p class="fw-medium">{{ d_trans('Rating') }}</p>
                        <div class="row row-cols-1 g-3">
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input id="rating55" type="checkbox" name="stars"
                                        class="form-check-input search-param my-0" value="5" />
                                    <label
                                        class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                        for="rating55">
                                        <span class="text-muted">{{ d_trans('Excellent') }}</span>
                                        <div class="ratings">
                                            <img src="{{ asset(config('theme.settings.stars.stars_5')) }}"
                                                alt="{{ d_trans('Excellent') }}">
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input id="rating44" type="checkbox" name="stars"
                                        class="form-check-input search-param my-0" value="4" />
                                    <label
                                        class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                        for="rating44">
                                        <span class="text-muted">{{ d_trans('Great') }}</span>
                                        <div class="ratings">
                                            <img src="{{ asset(config('theme.settings.stars.stars_4')) }}"
                                                alt="{{ d_trans('Great') }}">
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input id="rating33" type="checkbox" name="stars"
                                        class="form-check-input search-param my-0" value="3" />
                                    <label
                                        class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                        for="rating33">
                                        <span class="text-muted">{{ d_trans('Average') }}</span>
                                        <div class="ratings">
                                            <img src="{{ asset(config('theme.settings.stars.stars_3')) }}"
                                                alt="{{ d_trans('Average') }}">
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input id="rating22" type="checkbox" name="stars"
                                        class="form-check-input search-param my-0" value="2" />
                                    <label
                                        class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                        for="rating22">
                                        <span class="text-muted">{{ d_trans('Fair') }}</span>
                                        <div class="ratings">
                                            <img src="{{ asset(config('theme.settings.stars.stars_2')) }}"
                                                alt="{{ d_trans('Fair') }}">
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input id="rating11" type="checkbox" name="stars"
                                        class="form-check-input search-param my-0" value="1" />
                                    <label
                                        class="form-check-label d-flex align-items-center justify-content-between flex-grow-1 gap-2"
                                        for="rating11">
                                        <span class="text-muted">{{ d_trans('Poor') }}</span>
                                        <div class="ratings">
                                            <img src="{{ asset(config('theme.settings.stars.stars_1')) }}"
                                                alt="{{ d_trans('Poor') }}">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="item-box box">
                        <p class="fw-medium">{{ d_trans('Verification') }}</p>
                        <div class="row row-cols-1 g-3">
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input type="checkbox" name="verified" value="1"
                                        class="form-check-input search-param my-0" id="verified1" />
                                    <label class="form-check-label text-muted"
                                        for="verified1">{{ d_trans('Verified') }}</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input type="checkbox" name="verified" value="0"
                                        class="form-check-input search-param my-0" id="verified2" />
                                    <label class="form-check-label text-muted"
                                        for="verified2">{{ d_trans('Unverified') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="item-box box">
                        <p class="fw-medium">{{ d_trans('Status') }}</p>
                        <div class="row row-cols-1 g-3">
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input type="checkbox" name="trending" value="1"
                                        class="form-check-input search-param my-0" id="trending1" />
                                    <label class="form-check-label text-muted"
                                        for="trending1">{{ d_trans('Trending') }}</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input type="checkbox" name="best_rating" value="1"
                                        class="form-check-input search-param my-0" id="best_rating1" />
                                    <label class="form-check-label text-muted"
                                        for="best_rating1">{{ d_trans('Best Rating') }}</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input type="checkbox" name="featured" value="1"
                                        class="form-check-input search-param my-0" id="featured1" />
                                    <label class="form-check-label text-muted"
                                        for="featured1">{{ d_trans('Featured') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="item-box box">
                        <p class="fw-medium">{{ d_trans('Review Time') }}</p>
                        <div class="row row-cols-1 g-3">
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input type="checkbox" name="review_time" value=""
                                        class="form-check-input search-param my-0" id="reviewTime11" />
                                    <label class="form-check-label text-muted"
                                        for="reviewTime11">{{ d_trans('Any time') }}</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input type="checkbox" name="review_time" value="this_month"
                                        class="form-check-input search-param my-0" id="reviewTime22" />
                                    <label class="form-check-label text-muted"
                                        for="reviewTime22">{{ d_trans('This month') }}</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input type="checkbox" name="review_time" value="last_month"
                                        class="form-check-input search-param my-0" id="reviewTime33" />
                                    <label class="form-check-label text-muted"
                                        for="reviewTime33">{{ d_trans('Last month') }}</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input type="checkbox" name="review_time" value="this_year"
                                        class="form-check-input search-param my-0" id="reviewTime44" />
                                    <label class="form-check-label text-muted"
                                        for="reviewTime44">{{ d_trans('This year') }}</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check d-flex align-items-center gap-2">
                                    <input type="checkbox" name="review_time" value="last_year"
                                        class="form-check-input search-param my-0" id="reviewTime55" />
                                    <label class="form-check-label text-muted"
                                        for="reviewTime55">{{ d_trans('Last year') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (isset($search_categories) && $search_categories->count() > 0)
                    <div class="col">
                        <div class="item-box box">
                            <p class="fw-medium">{{ $search_categories_title ?? d_trans('Categories') }}</p>
                            <ul class="list-group list-group-flush">
                                @foreach ($search_categories as $search_category)
                                    <a href="{{ $search_category->getLink(request()->all()) }}"
                                        class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 {{ !$loop->last ? 'mb-2' : '' }}">
                                        <span>{{ $search_category->trans->name }}</span>
                                        <i class="bi bi-tag"></i>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@push('styles_libs')
    <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
@endpush
@push('scripts_libs')
    <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
@endpush
