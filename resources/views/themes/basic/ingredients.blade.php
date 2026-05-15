@extends('themes.basic.layouts.single')

@section('title', d_trans('Ingredient Guide'))
@section('header_title', d_trans('Ingredient Guide'))
@section('description', d_trans('Our A-Z reference covers every concerning cosmetic ingredient found in our lab tests —
    with plain English explanations of the risks.'))
@section('keywords', d_trans('ingredient guide, cosmetics, product safety, ingredient database, health effects'))
@section('breadcrumbs', Breadcrumbs::render('ingredients'))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'ingredients'))
@section('container', 'container-custom')
@section('header_v1', true)

@section('content')

    <!-- BLOCK 1 — PAGE HERO -->
    <div class="mt-5" style="padding-top: 40px;">
        <div style="max-width: 1280px; margin: 0 auto;">
            <div class="row align-items-center flex-column-reverse flex-lg-row">

                <!-- LEFT SIDE: Illustration -->
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="hero-illustration">
                        <img src="{{ asset('images/frontend/hero-bottle.webp') }}" alt="hero ingredient" class="img-fluid">

                        <!-- Tag 1 (red) -->
                        <div class="floating-tag" style="top: 10%; left: 0;">
                            <span class="tag-icon" style="color: var(--badge-avoid-bg);">&#10007;</span>
                            <span style="color: var(--text-dark);">{{ d_trans('Titanium Dioxide') }}</span>
                            <span class="text-muted-custom" style="font-size: 12px; font-weight: 500;">{{ d_trans('avoid') }}</span>
                        </div>

                        <!-- Tag 2 (amber) -->
                        <div class="floating-tag" style="top: 45%; right: -5%;">
                            <span class="tag-icon" style="color: var(--badge-concern-bg);">&#9888;</span>
                            <span style="color: var(--text-dark);">{{ d_trans('Paraffinum Liquidum') }}</span>
                            <span class="text-muted-custom" style="font-size: 12px; font-weight: 500;">{{ d_trans('Concern') }}</span>
                        </div>

                        <!-- Tag 3 (green) -->
                        <div class="floating-tag" style="bottom: 15%; left: 5%;">
                            <span class="tag-icon" style="color: var(--badge-safe-bg);">&#10003;</span>
                            <span style="color: var(--text-dark);">{{ d_trans('Shea Butter') }}</span>
                            <span class="text-muted-custom" style="font-size: 12px; font-weight: 500;">{{ d_trans('Safe') }}</span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE: Text Content -->
                <div class="col-lg-6 offset-lg-1">
                    <span class="small-red-label">{{ d_trans('Ingredient Guide') }}</span>
                    <h1 class="display-4 font-heading mb-4" style="line-height: 1.1;">
                        {!! d_trans('Know Every<br>Ingredient<br>In Your Products') !!}
                    </h1>
                    <p class="fs-5 text-body-custom mb-5" style="line-height: 1.6; max-width: 500px;">
                        {{ d_trans('Our A-Z reference covers every concerning cosmetic ingredient found in our 2023 lab tests — with plain English explanations of the risks.') }}
                    </p>

                    <!-- Search Bar -->
                    <div class="search-container mb-5" style="max-width: 550px;">
                        <input type="text" class="search-input" placeholder="{{ d_trans('Search ingredient name or INCI code...') }}">
                        <button class="search-btn">{{ d_trans('Search') }}</button>
                    </div>

                    <!-- Three Stat Cards -->
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <div class="stat-card h-100">
                                <i class="fa-solid fa-flask text-brand-red fs-4 mb-3"></i>
                                <div class="small-red-label" style="font-size: 10px; margin-bottom: 4px;">{{ d_trans('LAB TESTED') }}</div>
                                <div class="font-weight-bold"
                                    style="color: var(--text-dark); font-weight: 700; font-size: 15px;">{{ d_trans('735 Products Analysed') }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="stat-card h-100">
                                <i class="fa-solid fa-shield-halved text-brand-red fs-4 mb-3"></i>
                                <div class="small-red-label" style="font-size: 10px; margin-bottom: 4px;">{{ d_trans('SUBSTANCES FOUND') }}</div>
                                <div class="font-weight-bold"
                                    style="color: var(--text-dark); font-weight: 700; font-size: 15px;">{{ d_trans('50+ Ingredients Flagged') }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="stat-card h-100">
                                <i class="fa-solid fa-list text-brand-red fs-4 mb-3"></i>
                                <div class="small-red-label" style="font-size: 10px; margin-bottom: 4px;">{{ d_trans('SEVERITY LEVELS') }}</div>
                                <div class="font-weight-bold"
                                    style="color: var(--text-dark); font-weight: 700; font-size: 15px;">{{ d_trans('Avoid / Concern / Caution') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BLOCK 2 — FILTER AND SEARCH BAR -->
    <div class="bg-white p-4 border-top border-bottom shadow-sm"
        style="border-color: rgba(0,0,0,0.05) !important; margin-top: 40px; border-radius: 15px;">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <!-- Filters -->
            <div class="d-flex flex-wrap gap-2">
                <div class="filter-pill active">{{ d_trans('All Ingredients') }}</div>
                <div class="filter-pill pill-avoid">{{ d_trans('Avoid') }}</div>
                <div class="filter-pill pill-concern">{{ d_trans('Concern') }}</div>
                <div class="filter-pill pill-caution">{{ d_trans('Caution') }}</div>
            </div>

            <!-- Sort -->
            <div>
                <select class="form-select rounded-pill shadow-none"
                    style="border-color: #E5D5C5; padding: 8px 36px 8px 16px; font-size: 14px; font-weight: 500; color: var(--text-body); cursor: pointer;">
                    <option selected>{{ d_trans('Sort by: Most Found in Products') }}</option>
                    <option value="1">{{ d_trans('Sort by: Severity (High to Low)') }}</option>
                    <option value="2">{{ d_trans('Sort by: Alphabetical (A-Z)') }}</option>
                </select>
            </div>
        </div>

        <div class="mt-3">
            <span class="text-muted-custom" style="font-size: 13px;">{{ d_trans('Showing 47 ingredients — 12 flagged as Avoid') }}</span>
        </div>
    </div>

    <!-- BLOCK 3 — INGREDIENT CARDS GRID -->
    <div style="padding: 80px 0 40px 0; margin-top: 40px;">
        @if (isset($ingredients) && $ingredients->count())
            <div class="row row-cols-1 row-cols-lg-3 g-4">
                @foreach ($ingredients as $ingredient)
                    <div class="col">
                        <div class="card-custom">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge-severity badge-{{ strtolower($ingredient->severity) }}">
                                    {{ strtoupper($ingredient->severity) }}
                                </span>
                                <span class="text-muted-custom small">
                                    {{ d_trans('Found in') }} {{ $ingredient->found_in_count }} {{ d_trans('products') }}
                                </span>
                            </div>
                            <h3 class="font-heading fs-4 mb-1">{{ $ingredient->name }}</h3>
                            <div class="font-mono text-muted-custom mb-3" style="font-size: 12px;">
                                {{ $ingredient->inci_name }}
                            </div>
                            <p class="text-body-custom" style="font-size: 14px; flex-grow: 1;">
                                {{ $ingredient->concern_description }}
                            </p>

                            <div class="mb-4">
                                <a class="card-expand-link" data-bs-toggle="collapse"
                                    href="#expandCard{{ $ingredient->id }}" role="button" aria-expanded="false">
                                    {{ d_trans('More details') }} <span class="icon-arrow">&#8595;</span>
                                </a>
                                <div class="collapse mt-3" id="expandCard{{ $ingredient->id }}">
                                    <p class="small text-body-custom mb-2"><strong>{{ d_trans('Health Effects:') }}</strong>
                                        {{ $ingredient->health_effects }}</p>
                                    <p class="small text-body-custom mb-2"><strong>{{ d_trans('Regulatory Status:') }}</strong>
                                        {{ $ingredient->regulatory_status }}</p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-end mt-auto pt-3 border-top"
                                style="border-color: rgba(0,0,0,0.05) !important;">
                                <div></div>
                                <a href="#" class="text-brand-red text-decoration-none small fw-bold">
                                    {{ d_trans('View affected products') }} &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $ingredients->links() }}
        @else
            <p>{{ d_trans('No ingredients found.') }}</p>
        @endif
    </div>

    <!-- BLOCK 5 — LOAD MORE -->
    <div class="pb-5 pt-2 text-center" style="padding: 20px 0 60px 0;">
        <p class="text-muted-custom mb-4" style="font-size: 14px;">{{ d_trans('Showing 9 of 47 ingredients') }}</p>
        <a href="#" class="pill-btn pill-btn-dark">{{ d_trans('Load More Ingredients') }}</a>
    </div>

    <!-- BLOCK 4 — SEVERITY GUIDE -->
    <div style="padding: 80px 0;">
        <div class="text-center mb-5">
            <span class="small-red-label">{{ d_trans('HOW WE CLASSIFY') }}</span>
            <h2 class="font-heading display-6">{{ d_trans('What Each Severity Level Means') }}</h2>
        </div>

        <div class="row g-4">
            <!-- Avoid -->
            <div class="col-12 col-lg-4">
                <div class="guide-card guide-card-avoid">
                    <div class="guide-inner-badge" style="color: var(--badge-avoid-bg); background-color: #FFEBEE;">{{ d_trans('AVOID') }}</div>
                    <h3 class="font-heading h4 mb-3">{{ d_trans('Do Not Use') }}</h3>
                    <p class="text-body-custom mb-4" style="font-size: 15px; line-height: 1.6;">
                        {{ d_trans('This ingredient has serious safety concerns backed by scientific evidence...') }}
                    </p>
                    <p class="text-muted-custom small m-0 font-italic">{{ d_trans('e.g. Titanium Dioxide (nano) in lip products') }}</p>
                </div>
            </div>

            <!-- Concern -->
            <div class="col-12 col-lg-4">
                <div class="guide-card guide-card-concern">
                    <div class="guide-inner-badge" style="color: var(--badge-concern-bg); background-color: #FFF3E0;">{{ d_trans('CONCERN') }}</div>
                    <h3 class="font-heading h4 mb-3">{{ d_trans('Use With Caution') }}</h3>
                    <p class="text-body-custom mb-4" style="font-size: 15px; line-height: 1.6;">
                        {{ d_trans('Scientific evidence suggests potential harm but further research is ongoing...') }}
                    </p>
                    <p class="text-muted-custom small m-0 font-italic">{{ d_trans('e.g. Paraffinum Liquidum in body creams') }}</p>
                </div>
            </div>

            <!-- Caution -->
            <div class="col-12 col-lg-4">
                <div class="guide-card guide-card-caution">
                    <div class="guide-inner-badge" style="color: var(--badge-caution-bg); background-color: #FFFDE7;">{{ d_trans('CAUTION') }}</div>
                    <h3 class="font-heading h4 mb-3">{{ d_trans('Be Aware') }}</h3>
                    <p class="text-body-custom mb-4" style="font-size: 15px; line-height: 1.6;">
                        {{ d_trans('This ingredient is not considered harmful at typical concentrations...') }}
                    </p>
                    <p class="text-muted-custom small m-0 font-italic">{{ d_trans('e.g. PEG Compounds in face creams') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- BLOCK 6 — CTA BANNER -->
    <div
        style="background-color: var(--bg-dark-brown); color: white; padding: 80px 40px; border-radius: 12px; overflow: hidden;">
        <div style="max-width: 1280px; margin: 0 auto; position: relative;">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <span class="small-red-label" style="color: #FF8A8A;">{{ d_trans('SEARCH BY PRODUCT') }}</span>
                    <h2 class="font-heading display-5 mb-4" style="color: white; line-height: 1.2;">
                        {!! d_trans('See Which Products<br>Contain These Ingredients') !!}
                    </h2>
                    <p class="fs-5 mb-5" style="color: #E5D5C5; max-width: 480px; line-height: 1.6;">
                        {{ d_trans('Search our database of 735 tested products...') }}
                    </p>
                    <a href="{{ route('products.index') }}" class="pill-btn pill-btn-red">{{ d_trans('Search All Products') }} &rarr;</a>
                </div>

                <!-- Right side (Decorative tags) -->
                <div class="col-lg-6 d-none d-lg-block position-relative" style="height: 300px;">

                    <img src="{{ asset('images/frontend/cta-image.webp') }}" alt="{{ d_trans('Safe beauty updates') }}"
                        class="img-fluid">
                </div>

            </div>
        </div>
    </div>

    <script>
        // Optional: Arrow rotation on collapse
        document.querySelectorAll('.card-expand-link').forEach(link => {
            link.addEventListener('click', function() {
                const icon = this.querySelector('.icon-arrow');
                if (icon) {
                    icon.style.transform = this.getAttribute('aria-expanded') === 'true' ?
                        'rotate(180deg)' :
                        'rotate(0deg)';
                }
            });
        });
    </script>

@endsection
