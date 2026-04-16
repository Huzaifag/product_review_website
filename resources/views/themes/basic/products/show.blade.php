@extends('themes.basic.layouts.single')
@section('title', $product->name)
@section('header_title', $product->name)
@section('description', $product->description)
@section('keywords', $product->brand_name . ',' . $product->name)
@section('breadcrumbs', Breadcrumbs::render('products.show', $product))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'products.show', $product))
@section('container', 'container-custom')
@section('header_v2', true)
@section('content')
    @push('styles')
        <style>
            :root {
                --cream: #f5f0e8;
                --cream-dark: #ede8df;
                --green-dark: #2c3d2e;
                --green-mid: #3a5140;
                --tan: #c4a882;
                --text-dark: #1e2820;
                --text-mid: #4a5240;
                --text-light: #7a826e;
                --border: #ddd8ce;
                --grade-good: #16a34a;
                --grade-good-bg: #dcfce7;
                --grade-poor: #dc2626;
                --grade-poor-bg: #fee2e2;
                --grade-ok: #d97706;
                --grade-ok-bg: #fef3c7;
            }

            *,
            *::before,
            *::after {
                box-sizing: border-box;
            }

            .card-shell {
                background: var(--cream);
                border-radius: 16px;
                overflow: hidden;
                width: 100%;
                box-shadow: 0 8px 40px rgba(0, 0, 0, .12);
            }

            /* ── Two-column product body ── */
            .product-body {
                display: grid;
                grid-template-columns: 420px 1fr;
                min-height: 0;
            }

            /* LEFT */
            .img-col {
                background: var(--cream-dark);
                padding: 16px;
                display: flex;
                flex-direction: column;
                gap: 10px;
                border-right: 1px solid var(--border);
            }

            .img-main {
                width: 100%;
                aspect-ratio: 1/1;
                border-radius: 10px;
                overflow: hidden;
                background: #e8e0d0;
                flex-shrink: 0;
            }

            .img-main img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .img-thumbs {
                display: flex;
                gap: 8px;
            }

            .img-thumb {
                flex: 1;
                aspect-ratio: 1/1;
                border-radius: 8px;
                overflow: hidden;
                border: 2px solid transparent;
                cursor: pointer;
                padding: 0;
                transition: border-color .2s, transform .2s;
                background: #c8bfad;
            }

            .img-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .img-thumb.active {
                border-color: var(--green-dark);
                transform: translateY(-2px);
            }

            .img-view-all-btn {
                flex: 1;
                aspect-ratio: 1/1;
                border: 2px dashed var(--border);
                border-radius: 8px;
                background: rgba(44, 61, 46, .07);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.6rem;
                color: var(--text-mid);
                transition: all .2s;
            }

            .img-view-all-btn:hover {
                border-color: var(--green-dark);
                background: rgba(44, 61, 46, .12);
            }

            /* Left info boxes */
            .left-box {
                border: 1px solid var(--border);
                border-radius: 10px;
                background: #f8f2e8;
                padding: 10px 12px;
            }

            .left-box-title {
                font-size: .7rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .07em;
                color: var(--text-light);
                margin-bottom: 8px;
            }

            .concern-list {
                display: flex;
                flex-direction: column;
                gap: 6px;
                max-height: 220px;
                overflow-y: auto;
            }

            .concern-item {
                background: #fff;
                border: 1px solid var(--border);
                border-radius: 8px;
                padding: 8px 10px;
            }

            .concern-item h6 {
                font-size: .76rem;
                margin: 0 0 3px;
                color: var(--text-dark);
                display: flex;
                align-items: center;
                gap: 5px;
                flex-wrap: wrap;
            }

            .concern-item p {
                margin: 0;
                font-size: .71rem;
                color: var(--text-mid);
                line-height: 1.45;
            }

            .concern-meta {
                margin-top: 4px;
                font-size: .66rem;
                color: var(--text-light);
            }

            /* RIGHT */
            .detail-col {
                padding: 20px 22px;
                display: flex;
                flex-direction: column;
                gap: 14px;
                overflow-y: auto;
                min-height: 100vh;
            }

            .eyebrow {
                font-size: .62rem;
                letter-spacing: .12em;
                text-transform: uppercase;
                color: var(--text-light);
                margin: 0;
            }

            .product-title {
                font-size: 1.75rem;
                font-weight: 800;
                color: var(--text-dark);
                line-height: 1.1;
                margin: 0;
            }

            .product-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
                font-size: .72rem;
                color: var(--text-light);
                align-items: center;
            }

            .meta-sep {
                color: var(--border);
            }

            .product-desc {
                font-size: .8rem;
                line-height: 1.65;
                color: var(--text-mid);
                margin: 0;
            }

            /* Quick stats row */
            .quick-stats {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 8px;
            }

            .stat-box {
                border: 1px solid var(--border);
                border-radius: 9px;
                padding: 9px 10px;
                background: #f9f4eb;
            }

            .stat-label {
                font-size: .6rem;
                text-transform: uppercase;
                letter-spacing: .07em;
                color: var(--text-light);
                margin-bottom: 3px;
            }

            .stat-value {
                font-size: .82rem;
                font-weight: 700;
                color: var(--text-dark);
                line-height: 1.2;
            }

            /* Grade badge */
            .grade-badge {
                display: inline-block;
                padding: 2px 8px;
                border-radius: 999px;
                font-size: .72rem;
                font-weight: 700;
            }

            .grade-good {
                background: var(--grade-good-bg);
                color: var(--grade-good);
            }

            .grade-poor {
                background: var(--grade-poor-bg);
                color: var(--grade-poor);
            }

            .grade-ok {
                background: var(--grade-ok-bg);
                color: var(--grade-ok);
            }

            .grade-na {
                background: #f1f5f9;
                color: #94a3b8;
            }

            .bool-yes {
                color: var(--grade-good);
                font-weight: 700;
                font-size: .78rem;
            }

            .bool-no {
                color: var(--grade-poor);
                font-weight: 700;
                font-size: .78rem;
            }

            .bool-ok {
                color: var(--text-light);
                font-size: .78rem;
            }

            /* Mini brand/cat cards */
            .entity-row {
                display: flex;
                gap: 8px;
            }

            .entity-card {
                flex: 1;
                display: flex;
                align-items: center;
                gap: 8px;
                border: 1px solid var(--border);
                border-radius: 9px;
                padding: 8px 10px;
                background: #f9f4eb;
                text-decoration: none;
            }

            .entity-card img {
                width: 32px;
                height: 32px;
                object-fit: contain;
                border-radius: 5px;
                flex-shrink: 0;
                background: #fff;
            }

            .entity-info {}

            .entity-type {
                font-size: .58rem;
                text-transform: uppercase;
                letter-spacing: .07em;
                color: var(--text-light);
            }

            .entity-name {
                font-size: .76rem;
                font-weight: 600;
                color: var(--text-dark);
            }

            /* Tabs */
            .tab-bar {
                display: flex;
                border-bottom: 2px solid var(--border);
                gap: 0;
                margin: 0 -22px;
                padding: 0 22px;
            }

            .tab-btn {
                padding: 8px 14px;
                font-size: .75rem;
                font-weight: 600;
                color: var(--text-light);
                background: none;
                border: none;
                border-bottom: 2px solid transparent;
                margin-bottom: -2px;
                cursor: pointer;
                transition: color .2s, border-color .2s;
                letter-spacing: .01em;
            }

            .tab-btn.active {
                color: var(--green-dark);
                border-bottom-color: var(--green-dark);
            }

            .tab-btn:hover:not(.active) {
                color: var(--text-mid);
            }

            .tab-panel {
                display: none;
            }

            .tab-panel.active {
                display: block;
            }

            /* Lab snapshot */
            .lab-rows {
                display: flex;
                flex-direction: column;
                gap: 0;
            }

            .lab-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 7px 0;
                border-bottom: 1px dashed rgba(122, 130, 110, .25);
                gap: 10px;
            }

            .lab-row:last-child {
                border-bottom: none;
            }

            .lab-row-label {
                font-size: .71rem;
                color: var(--text-light);
                letter-spacing: .02em;
            }

            .lab-row-value {
                font-size: .76rem;
                font-weight: 600;
                color: var(--text-dark);
                text-align: right;
            }

            /* Details grid (complete test) */
            .details-2col {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0;
            }

            .drow {
                display: contents;
            }

            .drow>div {
                padding: 6px 4px;
                border-bottom: 1px dashed rgba(122, 130, 110, .2);
                font-size: .72rem;
            }

            .drow>div:first-child {
                color: var(--text-light);
                padding-right: 12px;
            }

            .drow>div:last-child {
                color: var(--text-dark);
                font-weight: 600;
                text-align: right;
            }

            /* Modal */
            .modal-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .7);
                z-index: 2000;
                align-items: center;
                justify-content: center;
            }

            .modal-overlay.active {
                display: flex;
            }

            .modal-content {
                background: #fff;
                border-radius: 14px;
                padding: 20px;
                max-width: 88vw;
                max-height: 88vh;
                overflow-y: auto;
                position: relative;
            }

            .modal-close {
                position: absolute;
                top: 10px;
                right: 10px;
                width: 30px;
                height: 30px;
                background: var(--cream-dark);
                border: none;
                border-radius: 50%;
                cursor: pointer;
                font-size: 1.1rem;
                color: var(--text-dark);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .modal-images-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
                gap: 10px;
                margin-top: 14px;
            }

            .modal-image {
                aspect-ratio: 1/1;
                border-radius: 10px;
                overflow: hidden;
                cursor: pointer;
                border: 2px solid transparent;
                transition: all .2s;
            }

            .modal-image:hover {
                border-color: var(--green-dark);
                transform: scale(1.04);
            }

            .modal-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            /* Lab badge (severity) */
            .lab-badge {
                display: inline-block;
                padding: 1px 6px;
                border-radius: 999px;
                font-size: .58rem;
                font-weight: 700;
                letter-spacing: .02em;
                background: rgba(44, 61, 46, .1);
                color: var(--green-dark);
            }

            .lab-badge.high {
                background: var(--grade-poor-bg);
                color: var(--grade-poor);
            }

            .lab-badge.medium {
                background: var(--grade-ok-bg);
                color: var(--grade-ok);
            }

            .lab-badge.low {
                background: var(--grade-good-bg);
                color: var(--grade-good);
            }

            /* Comparison table */
            .comparison-section {
                padding: 20px 20px 24px;
                border-top: 1px solid var(--border);
            }

            .comparison-section h3 {
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--text-dark);
                margin: 0 0 14px;
            }

            .comparison-wrap {
                overflow-x: auto;
                border: 1px solid var(--border);
                border-radius: 10px;
                background: #fff;
            }

            .comp-table {
                width: 100%;
                border-collapse: collapse;
                font-size: .79rem;
                min-width: 700px;
            }

            .comp-table th,
            .comp-table td {
                padding: 10px 12px;
                border-bottom: 1px solid var(--border);
                vertical-align: middle;
            }

            .comp-table thead tr {
                background: #f8f2e8;
            }

            .comp-table th:first-child,
            .comp-table td:first-child {
                font-weight: 600;
                color: var(--text-dark);
                border-right: 2px solid var(--border);
                min-width: 160px;
                background: #f8f2e8;
            }

            .comp-table th {
                text-align: center;
                font-weight: 600;
            }

            .comp-table td {
                text-align: center;
            }

            .comp-table .current-col {
                background: #f0f7f0;
            }

            .comp-table tbody tr:last-child td {
                border-bottom: none;
            }

            .comp-prod-img {
                width: 56px;
                height: 80px;
                object-fit: contain;
                display: block;
                margin: 0 auto 6px;
            }

            .comp-prod-name {
                font-weight: 700;
                font-size: .82rem;
                color: var(--text-dark);
            }

            .comp-prod-brand {
                font-size: .68rem;
                color: var(--text-mid);
                margin-top: 2px;
            }

            @media (max-width: 768px) {
                .product-body {
                    grid-template-columns: 1fr;
                }

                .detail-col {
                    max-height: none;
                }

                .quick-stats {
                    grid-template-columns: repeat(2, 1fr);
                }

                .entity-row {
                    flex-wrap: wrap;
                }

                .details-2col {
                    grid-template-columns: 1fr;
                }
            }
        </style>
    @endpush
    @php
        $productImageUrls = collect([$product->image])
            ->merge($product->images->pluck('path'))
            ->filter()
            ->map(function ($path) {
                return \Illuminate\Support\Str::startsWith($path, ['http://', 'https://']) ? $path : asset($path);
            })
            ->unique()
            ->values();

        if ($productImageUrls->isEmpty()) {
            $productImageUrls = collect([$product->getImageLink()]);
        }

        $lab = $product->labTestingResult;
        $concerns = $product->ingredientConcerns ?? collect();
    @endphp

    <div class="card-shell">
        <div class="product-body">

            {{-- ══ LEFT: Images + supplementary info ══ --}}
            <div class="img-col">
                <div class="img-main">
                    <img id="mainProductImage" src="{{ $productImageUrls->first() }}" alt="{{ $product->name }}">
                </div>

                <div class="img-thumbs">
                    @foreach ($productImageUrls->take(3) as $index => $imageUrl)
                        <button type="button" class="img-thumb {{ $index === 0 ? 'active' : '' }}"
                            onclick="selectPreview(this, '{{ $imageUrl }}')">
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                        </button>
                    @endforeach
                    @if ($productImageUrls->count() > 3)
                        <button type="button" class="img-view-all-btn" onclick="openImageModal()">+</button>
                    @endif
                </div>

                @if ($concerns->count() > 0)
                    <div class="left-box">
                        <div class="left-box-title">⚠ {{ d_trans('Ingredient Concerns') }}</div>
                        <div class="concern-list">
                            @foreach ($concerns as $concern)
                                <div class="concern-item">
                                    <h6>
                                        {{ $concern->ingredient_name }}
                                        <span
                                            class="lab-badge {{ strtolower($concern->severity) }}">{{ ucfirst($concern->severity) }}</span>
                                    </h6>
                                    <p>{{ $concern->description ?: d_trans('No description provided.') }}</p>
                                    @if ($concern->inci_name || $concern->concentration)
                                        <div class="concern-meta">
                                            @if ($concern->inci_name)
                                                <div>INCI: {{ $concern->inci_name }}</div>
                                            @endif
                                            @if ($concern->concentration)
                                                <div>{{ d_trans('Concentration') }}:
                                                    {{ number_format((float) $concern->concentration, 4) }}%</div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                
            </div>

            {{-- ══ RIGHT: Product details ══ --}}
            <div class="detail-col">
                <div>
                    <p class="eyebrow">{{ d_trans('Lab-Tested Product') }}</p>
                    <h1 class="product-title">{{ $product->name }}</h1>
                    <div class="product-meta" style="margin-top:6px;">
                        <span>{{ $product->brand?->name ?: d_trans('Unknown brand') }}</span>
                        <span class="meta-sep">·</span>
                        <span>{{ $product->category->trans->name ?? d_trans('Uncategorized') }}</span>
                        @if ($product->subCategory)
                            <span class="meta-sep">·</span>
                            <span>{{ $product->subCategory->trans->name }}</span>
                        @endif
                    </div>
                </div>

                <p class="product-desc">
                    {{ \Illuminate\Support\Str::limit(strip_tags($product->description ?: d_trans('No description available.')), 260) }}
                </p>

                {{-- Quick stats ──────────────────── --}}
                <div class="quick-stats">
                    <div class="stat-box">
                        <div class="stat-label">{{ d_trans('Overall Grade') }}</div>
                        <div class="stat-value">
                            @php $g = $product->overall_grade; @endphp
                            @if ($g)
                                <span
                                    class="grade-badge {{ str_contains($g, 'good') ? 'grade-good' : (str_contains($g, 'poor') ? 'grade-poor' : 'grade-ok') }}">
                                    {{ str_replace('_', ' ', ucfirst($g)) }}
                                </span>
                            @else
                                <span class="grade-badge grade-na">N/A</span>
                            @endif
                        </div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">{{ d_trans('Test Date') }}</div>
                        <div class="stat-value">{{ $product->test_date ? $product->test_date->format('M d, Y') : 'N/A' }}
                        </div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">{{ d_trans('Price') }}</div>
                        <div class="stat-value">
                            {{ $product->price ? $product->currency . ' ' . numberFormat($product->price) : 'N/A' }}</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-label">{{ d_trans('Size') }}</div>
                        <div class="stat-value">{{ $product->product_size ?: 'N/A' }}</div>
                    </div>
                </div>

                {{-- Brand / Category cards ──────── --}}
                <div class="entity-row">
                    <div class="entity-card">
                        <img src="{{ asset($product->brand?->logo) }}" alt="{{ $product->brand?->name }}">
                        <div class="entity-info">
                            <div class="entity-type">{{ d_trans('Brand') }}</div>
                            <div class="entity-name">{{ $product->brand?->name ?: 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="entity-card">
                        <img src="{{ asset($product->category->image) }}" alt="{{ $product->category->trans->name }}">>
                        <div class="entity-info">
                            <div class="entity-type">{{ d_trans('Category') }}</div>
                            <div class="entity-name">{{ $product->category->trans->name ?: 'N/A' }}</div>
                        </div>
                    </div>
                    @if ($product->subCategory)
                        <div class="entity-card">
                            <img src="{{ asset($product->subCategory->image) }}"
                                alt="{{ $product->subCategory->trans->name }}">
                            <div class="entity-info">
                                <div class="entity-type">{{ d_trans('Sub Category') }}</div>
                                <div class="entity-name">{{ $product->subCategory->trans->name }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Tabs ───────────────────────── --}}
                <div class="tab-bar">
                    <button class="tab-btn active"
                        onclick="switchTab(this,'tab-snapshot')">{{ d_trans('Lab Snapshot') }}</button>
                    <button class="tab-btn"
                        onclick="switchTab(this,'tab-details')">{{ d_trans('Full Test Details') }}</button>
                </div>

                {{-- Tab: Lab Snapshot --}}
                <div class="tab-panel active" id="tab-snapshot">
                    <div class="lab-rows">
                        @php
                            $snapRows = [
                                d_trans('Lab Name') => $lab?->lab_name ?: 'N/A',
                                d_trans('Ingredient Grade') => $lab?->ingredient_grade,
                                d_trans('Defects Grade') => $lab?->defects_grade,
                                d_trans('Overall Grade') => $lab?->overall_grade,
                                d_trans('Fragrance') => $lab ? ($lab->has_fragrance ? 'yes' : 'no') : null,
                                d_trans('Concerning UV Filter') => $lab
                                    ? ($lab->concerning_uv_filter
                                        ? 'yes'
                                        : 'no')
                                    : null,
                            ];
                        @endphp
                        @foreach ($snapRows as $label => $val)
                            <div class="lab-row">
                                <span class="lab-row-label">{{ $label }}</span>
                                <span class="lab-row-value">
                                    @if (is_null($val))
                                        <span class="bool-ok">N/A</span>
                                    @elseif ($val === 'yes')
                                        <span class="bool-yes">✓ Yes</span>
                                    @elseif ($val === 'no')
                                        <span class="bool-no">✗ No</span>
                                    @elseif (in_array($val, ['very_good', 'good']))
                                        <span
                                            class="grade-badge grade-good">{{ str_replace('_', ' ', ucfirst($val)) }}</span>
                                    @elseif (in_array($val, ['poor', 'bad']))
                                        <span
                                            class="grade-badge grade-poor">{{ str_replace('_', ' ', ucfirst($val)) }}</span>
                                    @else
                                        {{ is_string($val) ? str_replace('_', ' ', ucfirst($val)) : $val }}
                                    @endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                    @if ($lab?->test_summary)
                    <div class="left-box mt-4">
                        <div class="left-box-title">📋 {{ d_trans('Test Summary') }}</div>
                        <p style="margin:0;font-size:.74rem;color:var(--text-mid);line-height:1.55;">
                            {{ $lab->test_summary }}</p>
                    </div>
                @endif
                </div>

                {{-- Tab: Full Test Details --}}
                <div class="tab-panel" id="tab-details">
                    @php
                        $boolVal = fn($v) => $v ? 'yes' : 'no';
                        $rows = [
                            d_trans('Lab Verified') => $boolVal($product->lab_verified),
                            d_trans('Test Date') => $product->test_date?->format('M d, Y') ?: 'N/A',
                            d_trans('Test Year') => $product->test_year ?: 'N/A',
                            d_trans('Test Edition') => $product->test_edition ?: 'N/A',
                            d_trans('Magazine Page') => $product->magazine_page ?: 'N/A',
                            d_trans('Organic Certified') => $boolVal($product->organic_certified),
                            d_trans('Organic Certifier') => $product->organic_certifier ?: 'N/A',
                            d_trans('Lab Name') => $lab?->lab_name ?: 'N/A',
                            d_trans('Lab Tested At') => $lab?->tested_at?->format('M d, Y') ?: 'N/A',
                            d_trans('Mineral UV Filter') => $lab?->mineral_uv_filter ?: 'N/A',
                            d_trans('Concerning UV Filter') => $lab ? $boolVal($lab->concerning_uv_filter) : 'N/A',
                            d_trans('Has Fragrance') => $lab ? $boolVal($lab->has_fragrance) : 'N/A',
                            d_trans('Further Concerns') => $lab ? $boolVal($lab->further_concerns) : 'N/A',
                            d_trans('Further Concerns Detail') => $lab?->further_concerns_detail ?: 'N/A',
                            d_trans('Plastic Compounds') => $lab ? $boolVal($lab->plastic_compounds) : 'N/A',
                            d_trans('Further Defects') => $lab ? $boolVal($lab->further_defects) : 'N/A',
                            d_trans('Further Defects Detail') => $lab?->further_defects_detail ?: 'N/A',
                            d_trans('Ingredient Grade') => $lab?->ingredient_grade
                                ? str_replace('_', ' ', ucfirst($lab->ingredient_grade))
                                : 'N/A',
                            d_trans('Defects Grade') => $lab?->defects_grade
                                ? str_replace('_', ' ', ucfirst($lab->defects_grade))
                                : 'N/A',
                            d_trans('Overall Grade') => $lab?->overall_grade
                                ? str_replace('_', ' ', ucfirst($lab->overall_grade))
                                : 'N/A',
                            d_trans('Footnote Reference') => $lab?->footnote_ref ?: 'N/A',
                            d_trans('Footnote Text') => $lab?->footnote_text ?: 'N/A',
                        ];
                    @endphp
                    <div class="lab-rows">
                        @foreach ($rows as $label => $val)
                            <div class="lab-row">
                                <span class="lab-row-label">{{ $label }}</span>
                                <span class="lab-row-value">
                                    @if ($val === 'yes')
                                        <span class="bool-yes">✓ Yes</span>
                                    @elseif ($val === 'no')
                                        <span class="bool-no">✗ No</span>
                                    @else
                                        {{ $val }}
                                    @endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>{{-- /detail-col --}}
        </div>{{-- /product-body --}}

        {{-- ══ Comparison Table ══ --}}
        @if ($similarProducts->count())
            <div class="comparison-section mt-5">
                <h3>{{ d_trans('Compare with Similar Products') }}</h3>
                <div class="comparison-wrap">
                    <table class="comp-table">
                        <thead>
                            <tr>
                                <th style="text-align:left;">{{ d_trans('Attribute') }}</th>
                                <th class="current-col">
                                    <img class="comp-prod-img"
                                        src="{{ asset($product->image ?? 'images/placeholder.png') }}"
                                        alt="{{ $product->name }}">
                                    <div class="comp-prod-name">{{ $product->name }}</div>
                                    <div class="comp-prod-brand">{{ $product->brand?->name }}</div>
                                </th>
                                @foreach ($similarProducts as $sim)
                                    <th>
                                        <img class="comp-prod-img"
                                            src="{{ asset($sim->image ?? 'images/placeholder.png') }}"
                                            alt="{{ $sim->name }}">
                                        <div class="comp-prod-name">{{ $sim->name }}</div>
                                        <div class="comp-prod-brand">{{ $sim->brand?->name }}</div>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $gradeCell = function ($g) {
                                    if (!$g) {
                                        return '<span style="color:#94a3b8">N/A</span>';
                                    }
                                    $cls = str_contains($g, 'good')
                                        ? 'grade-good'
                                        : (str_contains($g, 'poor')
                                            ? 'grade-poor'
                                            : 'grade-ok');
                                    return '<span class="grade-badge ' .
                                        $cls .
                                        '">' .
                                        str_replace('_', ' ', ucfirst($g)) .
                                        '</span>';
                                };
                                $boolCell = fn($v) => $v
                                    ? '<span class="bool-yes">✓ Yes</span>'
                                    : '<span class="bool-no">✗ No</span>';
                            @endphp
                            <tr>
                                <td>{{ d_trans('Price') }}</td>
                                <td class="current-col" style="font-weight:700;">{{ $product->currency ?? '€' }}
                                    {{ numberFormat($product->price ?? 0) }}</td>
                                @foreach ($similarProducts as $sim)
                                    <td>{{ $sim->currency ?? '€' }} {{ numberFormat($sim->price ?? 0) }}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>{{ d_trans('Overall Grade') }}</td>
                                <td class="current-col">{!! $gradeCell($product->labTestingResult?->overall_grade) !!}</td>
                                @foreach ($similarProducts as $sim)
                                    <td>{!! $gradeCell($sim->labTestingResult?->overall_grade) !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>{{ d_trans('Ingredient Grade') }}</td>
                                <td class="current-col">{!! $gradeCell($product->labTestingResult?->ingredient_grade) !!}</td>
                                @foreach ($similarProducts as $sim)
                                    <td>{!! $gradeCell($sim->labTestingResult?->ingredient_grade) !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>{{ d_trans('Mineral UV Filter') }}</td>
                                <td class="current-col">{!! $boolCell($product->labTestingResult?->mineral_uv_filter) !!}</td>
                                @foreach ($similarProducts as $sim)
                                    <td>{!! $boolCell($sim->labTestingResult?->mineral_uv_filter) !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>{{ d_trans('Fragrance') }}</td>
                                <td class="current-col">{!! $boolCell($product->labTestingResult?->has_fragrance) !!}</td>
                                @foreach ($similarProducts as $sim)
                                    <td>{!! $boolCell($sim->labTestingResult?->has_fragrance) !!}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <td>{{ d_trans('Concerning UV Filter') }}</td>
                                <td class="current-col">{!! $boolCell($product->labTestingResult?->concerning_uv_filter) !!}</td>
                                @foreach ($similarProducts as $sim)
                                    <td>{!! $boolCell($sim->labTestingResult?->concerning_uv_filter) !!}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>{{-- /card-shell --}}

    <!-- Image Modal -->
    <div class="modal-overlay" id="imageModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeImageModal()">&times;</button>
            <h3 style="margin: 0 0 16px 0; color: var(--text-dark);">{{ d_trans('All Product Images') }}</h3>
            <div class="modal-images-grid">
                @foreach ($productImageUrls as $imageUrl)
                    <div class="modal-image" onclick="selectPreviewFromModal(this, '{{ $imageUrl }}')">
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const imageUrls = {!! json_encode($productImageUrls->values()->all()) !!};

            function selectRoast(el) {
                document.querySelectorAll('.roast-card').forEach(c => c.classList.remove('active'));
                el.classList.add('active');
            }

            function selectPreview(el, imageUrl) {
                const mainImage = document.getElementById('mainProductImage');
                if (mainImage) {
                    mainImage.src = imageUrl;
                }

                document.querySelectorAll('.img-thumb').forEach(t => t.classList.remove('active'));
                el.classList.add('active');
            }

            function openImageModal() {
                document.getElementById('imageModal').classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeImageModal() {
                document.getElementById('imageModal').classList.remove('active');
                document.body.style.overflow = 'auto';
            }

            function selectPreviewFromModal(el, imageUrl) {
                const mainImage = document.getElementById('mainProductImage');
                if (mainImage) {
                    mainImage.src = imageUrl;
                }
                closeImageModal();
            }

            // Close modal when clicking outside
            document.getElementById('imageModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeImageModal();
                }
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeImageModal();
                }
            });



            function selectRoast(el) {
                document.querySelectorAll('.roast-card').forEach(c => c.classList.remove('active'));
                el.classList.add('active');
            }

            function selectPreview(el, imageUrl) {
                document.getElementById('mainProductImage').src = imageUrl;
                document.querySelectorAll('.img-thumb').forEach(t => t.classList.remove('active'));
                el.classList.add('active');
            }

            function openImageModal() {
                document.getElementById('imageModal').classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeImageModal() {
                document.getElementById('imageModal').classList.remove('active');
                document.body.style.overflow = '';
            }

            function selectPreviewFromModal(el, imageUrl) {
                document.getElementById('mainProductImage').src = imageUrl;
                closeImageModal();
            }

            function switchTab(btn, panelId) {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById(panelId).classList.add('active');
            }

            document.getElementById('imageModal')?.addEventListener('click', function(e) {
                if (e.target === this) closeImageModal();
            });
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') closeImageModal();
            });
        </script>
    @endpush
@endsection
