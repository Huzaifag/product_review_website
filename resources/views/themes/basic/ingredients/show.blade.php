@extends('themes.basic.layouts.single')
@section('title', d_trans($ingredient->name) . ' — OKO Ingredient Profile')
@section('header_title', d_trans($ingredient->name))
@section('description', d_trans($ingredient->description ?? $ingredient->concern_description ?? ''))
@section('breadcrumbs', Breadcrumbs::render('ingredients.show', $ingredient))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'ingredients.show', $ingredient))
@section('container', 'container-custom')
@section('header_v2', true)
@section('content')

    @push('styles')
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

            :root {
                --ig-bg: #FAF7F2;
                --ig-card: #FFFFFF;
                --ig-soft: #F5EFE7;
                --ig-border: #E8DED2;
                --ig-text: #171717;
                --ig-muted: #6B7280;
                --ig-red: #C62828;
                --ig-red-dark: #8F1D1D;
                --ig-green: #16A34A;
                --ig-gold: #B88746;
                --ig-amber: #D97706;
                --ig-warning: #D99A21;
                --ig-s1: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
                --ig-s2: 0 4px 16px rgba(0,0,0,.08), 0 2px 6px rgba(0,0,0,.05);
                --ig-s3: 0 20px 60px rgba(0,0,0,.12), 0 4px 16px rgba(0,0,0,.07);
            }

            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

            .ig-shell {
                font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            /* ── HERO CARD ──────────────────────────────── */
            .ig-hero {
                background: #1a1a1a;
                background-image:
                    radial-gradient(ellipse at 85% 30%, rgba(184,147,90,.18) 0%, transparent 55%),
                    radial-gradient(ellipse at 5% 90%, rgba(198,40,40,.1) 0%, transparent 50%);
                border-radius: 24px;
                padding: 36px 40px;
                display: flex;
                align-items: flex-start;
                gap: 32px;
                box-shadow: var(--ig-s3), 0 0 0 1px rgba(255,255,255,.06);
                overflow: hidden;
                position: relative;
            }

            .ig-hero::before {
                content: '';
                position: absolute;
                inset: 0;
                background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.015'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
                pointer-events: none;
            }

            .ig-hero-left {
                display: flex;
                flex-direction: column;
                gap: 14px;
                flex: 1;
                min-width: 0;
                position: relative;
            }

            .ig-hero-eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                font-size: .67rem;
                letter-spacing: .18em;
                text-transform: uppercase;
                color: var(--ig-gold);
                font-weight: 700;
            }

            .ig-hero-eyebrow::before {
                content: '';
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: var(--ig-gold);
                flex-shrink: 0;
            }

            .ig-hero-name {
                font-size: 2rem;
                font-weight: 800;
                color: #fff;
                line-height: 1.12;
                letter-spacing: -.035em;
            }

            .ig-hero-inci {
                font-size: .82rem;
                color: rgba(255,255,255,.45);
                font-weight: 500;
                letter-spacing: .04em;
                text-transform: uppercase;
            }

            .ig-hero-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-top: 4px;
            }

            .ig-sev-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 6px 16px;
                border-radius: 999px;
                font-size: .76rem;
                font-weight: 700;
                letter-spacing: .02em;
            }

            .ig-sev-badge::before {
                content: '';
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: currentColor;
                opacity: .7;
            }

            .ig-sev-avoid   { background: rgba(198,40,40,.15); color: #FF6B6B; border: 1px solid rgba(198,40,40,.3); }
            .ig-sev-concern { background: rgba(217,119,6,.15);  color: #FBB040; border: 1px solid rgba(217,119,6,.3); }
            .ig-sev-caution { background: rgba(217,154,33,.15); color: #F9D46C; border: 1px solid rgba(217,154,33,.3); }
            .ig-sev-none    { background: rgba(22,163,74,.15);  color: #4ADE80; border: 1px solid rgba(22,163,74,.3); }

            .ig-hero-right {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 14px;
                flex-shrink: 0;
                position: relative;
            }

            /* OKO Stamp area */
            .ig-stamp-wrap {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 6px;
            }

            .ig-stamp-img {
                width: 80px;
                height: auto;
                object-fit: contain;
                filter: drop-shadow(0 4px 12px rgba(0,0,0,.35));
            }

            .ig-stamp-lbl {
                font-size: .55rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .1em;
                color: rgba(255,255,255,.6);
                text-align: center;
                line-height: 1.3;
            }

            .ig-stamp-verified .ig-stamp-lbl { color: var(--ig-gold); }

            /* Hazard score circle in hero */
            .ig-hero-score {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 4px;
            }

            .ig-score-circle {
                width: 64px;
                height: 64px;
                border-radius: 50%;
                background: var(--score-color, #374151);
                color: #fff;
                font-size: 1.6rem;
                font-weight: 800;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 0 0 3px rgba(255,255,255,.15), 0 0 0 6px var(--score-color, #374151), 0 8px 24px rgba(0,0,0,.3);
                letter-spacing: -.03em;
            }

            .ig-score-label {
                font-size: .6rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .1em;
                color: rgba(255,255,255,.5);
                text-align: center;
            }

            /* ── CONTENT GRID ───────────────────────────── */
            .ig-grid {
                display: grid;
                grid-template-columns: 300px 1fr;
                gap: 20px;
            }

            /* ── LEFT SIDEBAR ───────────────────────────── */
            .ig-sidebar {
                display: flex;
                flex-direction: column;
                gap: 16px;
            }

            .ig-card {
                background: var(--ig-card);
                border: 1px solid var(--ig-border);
                border-radius: 18px;
                overflow: hidden;
                box-shadow: var(--ig-s1);
            }

            .ig-card-header {
                padding: 14px 18px;
                border-bottom: 1px solid var(--ig-border);
                background: var(--ig-soft);
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .ig-card-header-title {
                font-size: .65rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .12em;
                color: var(--ig-muted);
            }

            .ig-card-body {
                padding: 16px 18px;
            }

            /* Hazard meter (sidebar) */
            .ig-meter-card {
                overflow: visible;
            }

            .ig-meter-wrap {
                padding: 18px;
            }

            .ig-meter-label {
                font-size: .62rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .12em;
                color: var(--ig-muted);
                margin-bottom: 14px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .ig-meter-label::after {
                content: '';
                flex: 1;
                height: 1px;
                background: var(--ig-border);
            }

            .ig-meter-scale {
                display: flex;
                align-items: center;
                gap: 6px;
                justify-content: center;
                flex-wrap: nowrap;
                overflow-x: auto;
                padding: 6px 8px 4px;
            }

            .ig-meter-num {
                width: 26px;
                height: 26px;
                border-radius: 50%;
                background: var(--hc);
                color: #fff;
                font-size: .72rem;
                font-weight: 700;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                user-select: none;
                transition: transform .15s;
            }

            .ig-meter-num.ig-meter-active {
                font-size: 1rem;
                font-weight: 800;
                box-shadow: 0 0 0 3px #fff, 0 0 0 5px var(--hc), 0 6px 18px rgba(0,0,0,.2);
                position: relative;
                transform: scale(1.45);
                z-index: 2;
            }

            .ig-meter-edges {
                display: flex;
                justify-content: space-between;
                margin-top: 10px;
            }

            .ig-meter-edge {
                font-size: .6rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: .06em;
                color: var(--ig-muted);
            }

            .ig-meter-concern {
                text-align: center;
                margin-top: 10px;
                font-size: .74rem;
                font-weight: 700;
                padding: 6px 12px;
                border-radius: 8px;
            }

            .ig-meter-concern.mc-low    { background: #DCFCE7; color: var(--ig-green); }
            .ig-meter-concern.mc-medium { background: #FEF3C7; color: var(--ig-amber); }
            .ig-meter-concern.mc-high   { background: #FEE2E2; color: var(--ig-red); }
            .ig-meter-concern.mc-na     { background: var(--ig-soft); color: var(--ig-muted); }

            /* Meta rows */
            .ig-meta-row {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                padding: 10px 0;
                border-bottom: 1px solid rgba(0,0,0,.06);
                gap: 12px;
            }

            .ig-meta-row:last-child { border-bottom: none; }

            .ig-meta-lbl {
                font-size: .76rem;
                color: var(--ig-muted);
                font-weight: 500;
                flex-shrink: 0;
            }

            .ig-meta-val {
                font-size: .8rem;
                font-weight: 700;
                color: var(--ig-text);
                text-align: right;
                word-break: break-word;
            }

            /* Synonyms */
            .ig-synonyms {
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
            }

            .ig-synonym-chip {
                font-size: .7rem;
                font-weight: 600;
                color: var(--ig-muted);
                background: var(--ig-soft);
                border: 1px solid var(--ig-border);
                border-radius: 999px;
                padding: 3px 10px;
            }

            /* ── MAIN CONTENT ───────────────────────────── */
            .ig-main {
                display: flex;
                flex-direction: column;
                gap: 16px;
            }

            /* Description card */
            .ig-desc {
                font-size: .92rem;
                line-height: 1.78;
                color: #374151;
            }

            /* Function pills */
            .ig-fn-section {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .ig-fn-pills {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .ig-fn-pill {
                font-size: .76rem;
                font-weight: 600;
                color: var(--ig-red-dark);
                background: #fff;
                border: 1px solid rgba(143,29,29,.22);
                border-radius: 999px;
                padding: 6px 16px;
                box-shadow: 0 1px 3px rgba(0,0,0,.06);
                transition: background .14s, box-shadow .14s, transform .14s;
            }

            .ig-fn-pill:hover {
                background: #FFF0F0;
                box-shadow: 0 3px 10px rgba(0,0,0,.1);
                transform: translateY(-1px);
            }

            /* Concerns section */
            .ig-concerns {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            .ig-concern-card {
                background: var(--ig-card);
                border: 1px solid var(--ig-border);
                border-radius: 14px;
                padding: 16px 20px;
                display: flex;
                gap: 16px;
                align-items: flex-start;
                box-shadow: var(--ig-s1);
            }

            .ig-concern-stripe {
                width: 4px;
                border-radius: 3px;
                align-self: stretch;
                flex-shrink: 0;
                min-height: 32px;
            }

            .ig-concern-body { flex: 1; min-width: 0; }

            .ig-concern-cat {
                font-size: .72rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .1em;
                color: var(--ig-muted);
                margin-bottom: 5px;
            }

            .ig-concern-text {
                font-size: .88rem;
                color: #374151;
                line-height: 1.7;
            }

            .ig-concern-ref {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                font-size: .65rem;
                font-weight: 600;
                color: var(--ig-muted);
                background: var(--ig-soft);
                border: 1px solid var(--ig-border);
                border-radius: 5px;
                padding: 2px 8px;
                margin-top: 7px;
                text-transform: uppercase;
                letter-spacing: .04em;
            }

            /* Regulatory / health effects */
            .ig-info-section p {
                font-size: .9rem;
                line-height: 1.75;
                color: #374151;
            }

            /* Section heading */
            .ig-section-heading {
                font-size: .62rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .14em;
                color: var(--ig-muted);
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 14px;
            }

            .ig-section-heading::after {
                content: '';
                flex: 1;
                height: 1px;
                background: var(--ig-border);
            }

            /* Flags row */
            .ig-flags {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .ig-flag-chip {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 7px 14px;
                border-radius: 10px;
                font-size: .76rem;
                font-weight: 700;
                border: 1px solid currentColor;
            }

            .ig-flag-chip i { font-size: .72rem; }

            .ig-flag-warn  { color: var(--ig-amber); background: #FEF3C7; border-color: #FDE68A; }
            .ig-flag-safe  { color: var(--ig-green); background: #DCFCE7; border-color: #BBF7D0; }
            .ig-flag-info  { color: #3B82F6; background: #EFF6FF; border-color: #BFDBFE; }

            /* Related products */
            .ig-products-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 12px;
            }

            .ig-product-card {
                background: var(--ig-card);
                border: 1px solid var(--ig-border);
                border-radius: 14px;
                padding: 14px;
                text-decoration: none;
                display: flex;
                flex-direction: column;
                gap: 10px;
                transition: box-shadow .15s, transform .15s;
                box-shadow: var(--ig-s1);
            }

            .ig-product-card:hover {
                box-shadow: var(--ig-s2);
                transform: translateY(-2px);
            }

            .ig-product-img {
                width: 100%;
                aspect-ratio: 1/1;
                border-radius: 10px;
                object-fit: contain;
                background: var(--ig-soft);
                border: 1px solid var(--ig-border);
                padding: 8px;
            }

            .ig-product-brand {
                font-size: .65rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: .08em;
                color: var(--ig-muted);
            }

            .ig-product-name {
                font-size: .86rem;
                font-weight: 700;
                color: var(--ig-text);
                line-height: 1.35;
            }

            /* Responsive */
            @media (max-width: 900px) {
                .ig-grid { grid-template-columns: 1fr; }
                .ig-hero { flex-direction: column; padding: 28px 24px; }
                .ig-hero-right { flex-direction: row; justify-content: flex-start; }
                .ig-products-grid { grid-template-columns: repeat(2, 1fr); }
            }

            @media (max-width: 560px) {
                .ig-hero { padding: 22px 20px; }
                .ig-hero-name { font-size: 1.5rem; }
                .ig-products-grid { grid-template-columns: 1fr 1fr; }
            }
        </style>
    @endpush

    @php
        $hs = $ingredient->hazard_score;
        $hsColor = is_null($hs) ? '#6B7280'
            : ($hs <= 2 ? '#16A34A' : ($hs <= 6 ? '#D97706' : '#C62828'));
        $hsConcernLabel = is_null($hs) ? d_trans('Not Rated')
            : ($hs <= 2 ? d_trans('Low Concern') : ($hs <= 6 ? d_trans('Medium Concern') : d_trans('High Concern')));
        $hsConcernClass = is_null($hs) ? 'mc-na'
            : ($hs <= 2 ? 'mc-low' : ($hs <= 6 ? 'mc-medium' : 'mc-high'));

        $sev = $ingredient->severity ?? 'none';
        $sevLabel = match($sev) {
            'avoid'   => d_trans('Avoid'),
            'concern' => d_trans('Concern'),
            'caution' => d_trans('Caution'),
            default   => d_trans('Generally Safe'),
        };
        $sevClass = 'ig-sev-' . ($sev ?: 'none');
    @endphp

    <div class="ig-shell">

        {{-- HERO --}}
        <div class="ig-hero">
            <div class="ig-hero-left">
                <span class="ig-hero-eyebrow">{{ d_trans('OKO Ingredient Profile') }}</span>
                <h1 class="ig-hero-name">{{ d_trans($ingredient->name) }}</h1>

                @if ($ingredient->inci_name)
                    <div class="ig-hero-inci">INCI: {{ strtoupper($ingredient->inci_name) }}</div>
                @endif

                <div class="ig-hero-meta">
                    <span class="{{ $sevClass }} ig-sev-badge">{{ $sevLabel }}</span>
                    @if ($ingredient->oko_verified)
                        <span class="ig-sev-badge" style="background:rgba(184,147,90,.18);color:#F0C060;border:1px solid rgba(184,147,90,.35);">
                            <i class="fas fa-check-circle" style="font-size:.7rem;margin-right:2px;"></i>
                            {{ d_trans('OKO Verified') }}
                        </span>
                    @endif
                    @if ($ingredient->cas_number)
                        <span class="ig-sev-badge" style="background:rgba(255,255,255,.07);color:rgba(255,255,255,.5);border:1px solid rgba(255,255,255,.12);font-size:.68rem;">
                            CAS: {{ $ingredient->cas_number }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="ig-hero-right">
                {{-- OKO stamp --}}
                <div class="ig-stamp-wrap {{ $ingredient->oko_verified ? 'ig-stamp-verified' : '' }}">
                    <img src="{{ asset('images/oko/stamp-verification.webp') }}" alt="OKO" class="ig-stamp-img"
                         style="{{ !$ingredient->oko_verified ? 'filter:grayscale(1) opacity(.4) drop-shadow(0 2px 8px rgba(0,0,0,.35))' : 'filter:drop-shadow(0 4px 12px rgba(0,0,0,.35))' }}">
                    <span class="ig-stamp-lbl">{{ $ingredient->oko_verified ? d_trans("OKO\nVERIFIED") : d_trans("NOT\nVERIFIED") }}</span>
                </div>

                {{-- Hazard score circle --}}
                @if (!is_null($hs))
                    <div class="ig-hero-score">
                        <div class="ig-score-circle" style="--score-color: {{ $hsColor }}">{{ $hs }}</div>
                        <div class="ig-score-label">{{ d_trans('/ 10 Hazard') }}</div>
                    </div>
                @endif
            </div>
        </div>

        {{-- GRID --}}
        <div class="ig-grid">

            {{-- SIDEBAR --}}
            <div class="ig-sidebar">

                {{-- Hazard Meter --}}
                <div class="ig-card ig-meter-card">
                    <div class="ig-meter-wrap">
                        <div class="ig-meter-label">{{ d_trans('Hazard Score') }}</div>
                        @if (!is_null($hs))
                            <div class="ig-meter-scale">
                                @for ($i = 1; $i <= 10; $i++)
                                    @php $iColor = $i <= 2 ? '#16a34a' : ($i <= 6 ? '#ea580c' : '#dc2626'); @endphp
                                    <div class="ig-meter-num {{ $hs == $i ? 'ig-meter-active' : '' }}"
                                         style="--hc: {{ $iColor }}">{{ $i }}</div>
                                @endfor
                            </div>
                            <div class="ig-meter-edges">
                                <span class="ig-meter-edge">{{ d_trans('Best') }}</span>
                                <span class="ig-meter-edge">{{ d_trans('Worst') }}</span>
                            </div>
                            <div class="ig-meter-concern {{ $hsConcernClass }}">{{ $hsConcernLabel }}</div>
                        @else
                            <div class="ig-meter-concern mc-na" style="text-align:center;">{{ d_trans('No hazard score available') }}</div>
                        @endif
                    </div>
                </div>

                {{-- Quick Facts --}}
                <div class="ig-card">
                    <div class="ig-card-header">
                        <span class="ig-card-header-title">{{ d_trans('Quick Facts') }}</span>
                    </div>
                    <div class="ig-card-body">
                        @if ($ingredient->cas_number)
                            <div class="ig-meta-row">
                                <span class="ig-meta-lbl">CAS #</span>
                                <span class="ig-meta-val">{{ $ingredient->cas_number }}</span>
                            </div>
                        @endif
                        @if ($ingredient->source)
                            <div class="ig-meta-row">
                                <span class="ig-meta-lbl">{{ d_trans('Source') }}</span>
                                <span class="ig-meta-val">{{ $ingredient->source }}</span>
                            </div>
                        @endif
                        @if ($ingredient->found_in_count)
                            <div class="ig-meta-row">
                                <span class="ig-meta-lbl">{{ d_trans('Found In') }}</span>
                                <span class="ig-meta-val">{{ $ingredient->found_in_count }} {{ d_trans('products') }}</span>
                            </div>
                        @endif
                        <div class="ig-meta-row">
                            <span class="ig-meta-lbl">{{ d_trans('OKO Verified') }}</span>
                            <span class="ig-meta-val" style="color:{{ $ingredient->oko_verified ? 'var(--ig-green)' : 'var(--ig-muted)' }}">
                                {{ $ingredient->oko_verified ? '✓ ' . d_trans('Yes') : '✗ ' . d_trans('No') }}
                            </span>
                        </div>
                        <div class="ig-meta-row">
                            <span class="ig-meta-lbl">{{ d_trans('Severity') }}</span>
                            <span class="ig-meta-val">{{ $sevLabel }}</span>
                        </div>
                    </div>
                </div>

                {{-- Synonyms --}}
                @if (!empty($ingredient->synonyms))
                    <div class="ig-card">
                        <div class="ig-card-header">
                            <span class="ig-card-header-title">{{ d_trans('Also Known As') }}</span>
                        </div>
                        <div class="ig-card-body">
                            <div class="ig-synonyms">
                                @foreach ($ingredient->synonyms as $syn)
                                    <span class="ig-synonym-chip">{{ $syn }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Flags --}}
                @php $flags = $ingredient->concern_flags ?? []; @endphp
                @if (!empty($flags) || $ingredient->inhalation_risk_flag)
                    <div class="ig-card">
                        <div class="ig-card-header">
                            <span class="ig-card-header-title">{{ d_trans('Safety Flags') }}</span>
                        </div>
                        <div class="ig-card-body">
                            <div class="ig-flags">
                                @if ($ingredient->inhalation_risk_flag)
                                    <span class="ig-flag-chip ig-flag-warn">
                                        <i class="fas fa-wind"></i> {{ d_trans('Inhalation Risk') }}
                                    </span>
                                @endif
                                @foreach ($flags as $flag)
                                    <span class="ig-flag-chip ig-flag-warn">
                                        <i class="fas fa-exclamation-triangle"></i> {{ $flag }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            </div>{{-- /sidebar --}}

            {{-- MAIN --}}
            <div class="ig-main">

                {{-- Description --}}
                @if ($ingredient->description)
                    <div class="ig-card">
                        <div class="ig-card-header">
                            <span class="ig-card-header-title">{{ d_trans('About This Ingredient') }}</span>
                        </div>
                        <div class="ig-card-body ig-info-section">
                            <p>{{ d_trans($ingredient->description) }}</p>
                        </div>
                    </div>
                @endif

                {{-- Functions --}}
                @if (!empty($ingredient->functions))
                    <div class="ig-card">
                        <div class="ig-card-header">
                            <span class="ig-card-header-title">{{ d_trans('Function(s) in Cosmetics') }}</span>
                        </div>
                        <div class="ig-card-body">
                            <div class="ig-fn-pills">
                                @foreach ($ingredient->functions as $fn)
                                    <span class="ig-fn-pill">{{ $fn }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Concerns --}}
                @if (!empty($ingredient->concerns) || $ingredient->concern_description)
                    <div class="ig-card">
                        <div class="ig-card-header">
                            <span class="ig-card-header-title">{{ d_trans('Known Concerns') }}</span>
                        </div>
                        <div class="ig-card-body" style="padding:16px 18px;">
                            <div class="ig-concerns">
                                @if (!empty($ingredient->concerns))
                                    @foreach ($ingredient->concerns as $c)
                                        @if (!empty($c['concern_text']))
                                            @php
                                                $cleanText = preg_replace('/^(low|medium|high|moderate|none)\s+concern[.:,]?\s*/i', '', $c['concern_text']);
                                                $cSev = strtolower($c['severity'] ?? '');
                                                $stripeColor = $cSev === 'high' ? 'var(--ig-red)' : ($cSev === 'medium' ? 'var(--ig-amber)' : 'var(--ig-green)');
                                            @endphp
                                            <div class="ig-concern-card">
                                                <div class="ig-concern-stripe" style="background:{{ $stripeColor }}"></div>
                                                <div class="ig-concern-body">
                                                    @if (!empty($c['category']))
                                                        <div class="ig-concern-cat">{{ $c['category'] }}</div>
                                                    @endif
                                                    <div class="ig-concern-text">{{ $cleanText }}</div>
                                                    @if (!empty($c['reference_org']))
                                                        <div class="ig-concern-ref">{{ $c['reference_org'] }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="ig-concern-card">
                                        <div class="ig-concern-stripe" style="background:var(--ig-amber)"></div>
                                        <div class="ig-concern-body">
                                            <div class="ig-concern-text">{{ d_trans($ingredient->concern_description) }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Health Effects --}}
                @if ($ingredient->health_effects)
                    <div class="ig-card">
                        <div class="ig-card-header">
                            <span class="ig-card-header-title">{{ d_trans('Health Effects') }}</span>
                        </div>
                        <div class="ig-card-body ig-info-section">
                            <p>{{ d_trans($ingredient->health_effects) }}</p>
                        </div>
                    </div>
                @endif

                {{-- Regulatory Status --}}
                @if ($ingredient->regulatory_status)
                    <div class="ig-card">
                        <div class="ig-card-header">
                            <span class="ig-card-header-title"><i class="fas fa-gavel" style="font-size:.7rem;margin-right:4px;"></i>{{ d_trans('Regulatory Status') }}</span>
                        </div>
                        <div class="ig-card-body ig-info-section">
                            <p>{{ d_trans($ingredient->regulatory_status) }}</p>
                        </div>
                    </div>
                @endif

                {{-- Related Products --}}
                @if ($relatedProducts->count() > 0)
                    <div class="ig-card">
                        <div class="ig-card-header">
                            <span class="ig-card-header-title">{{ d_trans('Found In These Products') }}</span>
                        </div>
                        <div class="ig-card-body">
                            <div class="ig-products-grid">
                                @foreach ($relatedProducts as $rp)
                                    <a href="{{ $rp->getLink() }}" class="ig-product-card">
                                        <img class="ig-product-img"
                                             src="{{ $rp->image ? (\Illuminate\Support\Str::startsWith($rp->image, ['http://', 'https://']) ? $rp->image : asset($rp->image)) : $rp->getImageLink() }}"
                                             alt="{{ d_trans($rp->name) }}">
                                        <div>
                                            @if ($rp->brand)
                                                <div class="ig-product-brand">{{ $rp->brand->name }}</div>
                                            @endif
                                            <div class="ig-product-name">{{ d_trans($rp->name) }}</div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

            </div>{{-- /main --}}

        </div>{{-- /grid --}}

    </div>{{-- /shell --}}

@endsection
