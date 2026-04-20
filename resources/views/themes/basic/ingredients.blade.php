@extends('themes.basic.layouts.single')

@section('title', d_trans('Ingredient Guide'))
@section('header_title', d_trans('Ingredient Guide'))
@section('description', d_trans('Our A-Z reference covers every concerning cosmetic ingredient found in our lab tests — with plain English explanations of the risks.'))
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
                            <span style="color: var(--text-dark);">Titanium Dioxide</span>
                            <span class="text-muted-custom" style="font-size: 12px; font-weight: 500;">avoid</span>
                        </div>

                        <!-- Tag 2 (amber) -->
                        <div class="floating-tag" style="top: 45%; right: -5%;">
                            <span class="tag-icon" style="color: var(--badge-concern-bg);">&#9888;</span>
                            <span style="color: var(--text-dark);">Paraffinum Liquidum</span>
                            <span class="text-muted-custom" style="font-size: 12px; font-weight: 500;">concern</span>
                        </div>

                        <!-- Tag 3 (green) -->
                        <div class="floating-tag" style="bottom: 15%; left: 5%;">
                            <span class="tag-icon" style="color: var(--badge-safe-bg);">&#10003;</span>
                            <span style="color: var(--text-dark);">Shea Butter</span>
                            <span class="text-muted-custom" style="font-size: 12px; font-weight: 500;">safe</span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT SIDE: Text Content -->
                <div class="col-lg-6 offset-lg-1">
                    <span class="small-red-label">Ingredient Guide</span>
                    <h1 class="display-4 font-heading mb-4" style="line-height: 1.1;">
                        Know Every<br>Ingredient<br>In Your Products
                    </h1>
                    <p class="fs-5 text-body-custom mb-5" style="line-height: 1.6; max-width: 500px;">
                        Our A-Z reference covers every concerning cosmetic ingredient found in our 2023 lab tests — with
                        plain English explanations of the risks.
                    </p>

                    <!-- Search Bar -->
                    <div class="search-container mb-5" style="max-width: 550px;">
                        <input type="text" class="search-input" placeholder="Search ingredient name or INCI code...">
                        <button class="search-btn">Search</button>
                    </div>

                    <!-- Three Stat Cards -->
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <div class="stat-card h-100">
                                <i class="fa-solid fa-flask text-brand-red fs-4 mb-3"></i>
                                <div class="small-red-label" style="font-size: 10px; margin-bottom: 4px;">LAB TESTED</div>
                                <div class="font-weight-bold" style="color: var(--text-dark); font-weight: 700; font-size: 15px;">735 Products Analysed</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="stat-card h-100">
                                <i class="fa-solid fa-shield-halved text-brand-red fs-4 mb-3"></i>
                                <div class="small-red-label" style="font-size: 10px; margin-bottom: 4px;">SUBSTANCES FOUND</div>
                                <div class="font-weight-bold" style="color: var(--text-dark); font-weight: 700; font-size: 15px;">50+ Ingredients Flagged</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="stat-card h-100">
                                <i class="fa-solid fa-list text-brand-red fs-4 mb-3"></i>
                                <div class="small-red-label" style="font-size: 10px; margin-bottom: 4px;">SEVERITY LEVELS</div>
                                <div class="font-weight-bold" style="color: var(--text-dark); font-weight: 700; font-size: 15px;">Avoid / Concern / Caution</div>
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
                <div class="filter-pill active">All Ingredients</div>
                <div class="filter-pill pill-avoid">Avoid</div>
                <div class="filter-pill pill-concern">Concern</div>
                <div class="filter-pill pill-caution">Caution</div>
            </div>

            <!-- Sort -->
            <div>
                <select class="form-select rounded-pill shadow-none"
                    style="border-color: #E5D5C5; padding: 8px 36px 8px 16px; font-size: 14px; font-weight: 500; color: var(--text-body); cursor: pointer;">
                    <option selected>Sort by: Most Found in Products</option>
                    <option value="1">Sort by: Severity (High to Low)</option>
                    <option value="2">Sort by: Alphabetical (A-Z)</option>
                </select>
            </div>
        </div>

        <div class="mt-3">
            <span class="text-muted-custom" style="font-size: 13px;">Showing 47 ingredients — 12 flagged as Avoid</span>
        </div>
    </div>

    <!-- BLOCK 3 — INGREDIENT CARDS GRID -->
    <div style="padding: 80px 0 40px 0; margin-top: 40px;">
        @if(isset($ingredients) && $ingredients->count())
            <div class="row row-cols-1 row-cols-lg-3 g-4">
                @foreach($ingredients as $ingredient)
                    <div class="col">
                        <div class="card-custom">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge-severity badge-{{ strtolower($ingredient->severity) }}">
                                    {{ strtoupper($ingredient->severity) }}
                                </span>
                                <span class="text-muted-custom small">
                                    Found in {{ $ingredient->found_in_count }} products
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
                                    More details <span class="icon-arrow">&#8595;</span>
                                </a>
                                <div class="collapse mt-3" id="expandCard{{ $ingredient->id }}">
                                    <p class="small text-body-custom mb-2"><strong>Health Effects:</strong> {{ $ingredient->health_effects }}</p>
                                    <p class="small text-body-custom mb-2"><strong>Regulatory Status:</strong> {{ $ingredient->regulatory_status }}</p>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-end mt-auto pt-3 border-top" 
                                 style="border-color: rgba(0,0,0,0.05) !important;">
                                <div></div>
                                <a href="#" class="text-brand-red text-decoration-none small fw-bold">
                                    View affected products &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $ingredients->links() }}
        @else
            <p>No ingredients found.</p>
        @endif
    </div>

    <!-- BLOCK 5 — LOAD MORE -->
    <div class="pb-5 pt-2 text-center" style="padding: 20px 0 60px 0;">
        <p class="text-muted-custom mb-4" style="font-size: 14px;">Showing 9 of 47 ingredients</p>
        <a href="#" class="pill-btn pill-btn-dark">Load More Ingredients</a>
    </div>

    <!-- BLOCK 4 — SEVERITY GUIDE -->
    <div style="padding: 80px 0;">
        <div class="text-center mb-5">
            <span class="small-red-label">HOW WE CLASSIFY</span>
            <h2 class="font-heading display-6">What Each Severity Level Means</h2>
        </div>

        <div class="row g-4">
            <!-- Avoid -->
            <div class="col-12 col-lg-4">
                <div class="guide-card guide-card-avoid">
                    <div class="guide-inner-badge" style="color: var(--badge-avoid-bg); background-color: #FFEBEE;">AVOID</div>
                    <h3 class="font-heading h4 mb-3">Do Not Use</h3>
                    <p class="text-body-custom mb-4" style="font-size: 15px; line-height: 1.6;">
                        This ingredient has serious safety concerns backed by scientific evidence...
                    </p>
                    <p class="text-muted-custom small m-0 font-italic">e.g. Titanium Dioxide (nano) in lip products</p>
                </div>
            </div>

            <!-- Concern -->
            <div class="col-12 col-lg-4">
                <div class="guide-card guide-card-concern">
                    <div class="guide-inner-badge" style="color: var(--badge-concern-bg); background-color: #FFF3E0;">CONCERN</div>
                    <h3 class="font-heading h4 mb-3">Use With Caution</h3>
                    <p class="text-body-custom mb-4" style="font-size: 15px; line-height: 1.6;">
                        Scientific evidence suggests potential harm but further research is ongoing...
                    </p>
                    <p class="text-muted-custom small m-0 font-italic">e.g. Paraffinum Liquidum in body creams</p>
                </div>
            </div>

            <!-- Caution -->
            <div class="col-12 col-lg-4">
                <div class="guide-card guide-card-caution">
                    <div class="guide-inner-badge" style="color: var(--badge-caution-bg); background-color: #FFFDE7;">CAUTION</div>
                    <h3 class="font-heading h4 mb-3">Be Aware</h3>
                    <p class="text-body-custom mb-4" style="font-size: 15px; line-height: 1.6;">
                        This ingredient is not considered harmful at typical concentrations...
                    </p>
                    <p class="text-muted-custom small m-0 font-italic">e.g. PEG Compounds in face creams</p>
                </div>
            </div>
        </div>
    </div>

    <!-- BLOCK 6 — CTA BANNER -->
    <div style="background-color: var(--bg-dark-brown); color: white; padding: 80px 0; overflow: hidden;">
        <div style="max-width: 1280px; margin: 0 auto; position: relative;">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <span class="small-red-label" style="color: #FF8A8A;">SEARCH BY PRODUCT</span>
                    <h2 class="font-heading display-5 mb-4" style="color: white; line-height: 1.2;">
                        See Which Products<br>Contain These Ingredients
                    </h2>
                    <p class="fs-5 mb-5" style="color: #E5D5C5; max-width: 480px; line-height: 1.6;">
                        Search our database of 735 tested products...
                    </p>
                    <a href="#" class="pill-btn pill-btn-red">Search All Products &rarr;</a>
                </div>

                <!-- Right side (Decorative tags) -->
                <div class="col-lg-6 d-none d-lg-block position-relative" style="height: 300px;">
                    <div class="floating-tag" style="top: 20%; left: 10%; background: rgba(255,255,255,0.1); backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,0.2); color: white; box-shadow: none;">
                        <span style="color: #FF8A8A;">&#10007;</span> Titanium Dioxide
                    </div>
                    <div class="floating-tag" style="top: 60%; left: 30%; background: rgba(255,255,255,0.1); backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,0.2); color: white; box-shadow: none;">
                        <span style="color: #FFB74D;">&#9888;</span> Paraffinum Liquidum
                    </div>
                    <div class="floating-tag" style="top: 10%; right: 10%; background: rgba(255,255,255,0.1); backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,0.2); color: white; box-shadow: none;">
                        <span style="color: #81C784;">&#10003;</span> Shea Butter
                    </div>
                    <div class="floating-tag" style="bottom: 10%; right: 20%; background: rgba(255,255,255,0.1); backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,0.2); color: white; box-shadow: none;">
                        <span style="color: #FFD54F;">&#9653;</span> Microplastics
                    </div>
                    <div class="floating-tag" style="top: 40%; right: 30%; background: rgba(255,255,255,0.1); backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,0.2); color: white; box-shadow: none;">
                        <span style="color: #FF8A8A;">&#10007;</span> MI
                    </div>
                    <div class="floating-tag" style="bottom: 30%; left: 10%; background: rgba(255,255,255,0.1); backdrop-filter: blur(4px); border: 1px solid rgba(255,255,255,0.2); color: white; box-shadow: none;">
                        <span style="color: #FFB74D;">&#9888;</span> PEG Compounds
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Optional: Arrow rotation on collapse
        document.querySelectorAll('.card-expand-link').forEach(link => {
            link.addEventListener('click', function () {
                const icon = this.querySelector('.icon-arrow');
                if (icon) {
                    icon.style.transform = this.getAttribute('aria-expanded') === 'true' 
                        ? 'rotate(180deg)' 
                        : 'rotate(0deg)';
                }
            });
        });
    </script>

@endsection