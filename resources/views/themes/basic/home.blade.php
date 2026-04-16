@extends('themes.basic.layouts.app')
@section('title', m_trans(config('settings.seo.title')))
@section('content')

{{-- ═══════════════════════════════════════════════════
     ÖKO-TEST KOSMETIK — HERO SECTION
     ═══════════════════════════════════════════════════ --}}

<header class="oeko-hero">
    <div class="oeko-hero-inner">

        {{-- ── LEFT SIDE: Authority Statement ── --}}
        <div class="oeko-hero-left" data-aos="fade-right" data-aos-duration="900">

            {{-- Trust label pill --}}
            <div class="oeko-trust-pill">
                <span class="oeko-trust-dot"></span>
                {{ d_trans('Independent Lab Testing Since 1985') }}
            </div>

            {{-- Main headline --}}
            <h1 class="oeko-hero-title">
                {{ d_trans("What's Really") }}<br>
                {{ d_trans('Inside Your') }}
                <span class="oeko-hero-star">&#10022;</span><br>
                {{ d_trans('Cosmetics?') }}
            </h1>

            {{-- Subtext --}}
            <p class="oeko-hero-subtext">
                {{ d_trans('735 cosmetics independently lab-tested. We find what the label won\'t tell you.') }}
            </p>

            {{-- Two trust badges --}}
            <div class="oeko-trust-badges">
                <div class="oeko-trust-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                    </svg>
                    {{ d_trans('Lab Verified Results') }}
                </div>
                <div class="oeko-trust-badge">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    {{ d_trans('Independent Since 1985') }}
                </div>
            </div>

            {{-- Primary CTA --}}
            <div class="oeko-hero-cta-group">
                <a href="{{ route('businesses.index') }}" class="oeko-btn-primary">
                    {{ d_trans('Explore Test Results') }}
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12 5 19 12 12 19"/>
                    </svg>
                </a>
                <a href="#how-we-test" class="oeko-btn-ghost">
                    {{ d_trans('How we test products') }}
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </a>
            </div>

            {{-- Search bar --}}
            <div class="oeko-hero-search" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <div class="header-search search home-search">
                    <form action="{{ route('products.index') }}"
                        data-ajax-action="{{ route('products.ajax-search') }}"
                        data-ajax-empty="{{ d_trans('No results found') }}"
                        method="GET">
                        <div class="search-input oeko-search-input">
                            <button aria-label="{{ d_trans('Search') }}" class="icon btn-danger" type="submit" style="background-color: #C62828">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"/>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                </svg>
                            </button>
                            <input type="text" name="search" class="form-control"
                                placeholder="{{ d_trans('Search product or brand... e.g. Weleda, Nivea') }}"
                                autocomplete="off">
                        </div>
                    </form>
                    <div class="search-results">
                        <div class="search-results-inner" data-simplebar>
                            <div></div>
                        </div>
                        <a href="{{ route('businesses.index') }}" class="search-action">
                            {{ d_trans('View All Test Results') }}
                        </a>
                    </div>
                </div>
            </div>

            {{-- Stats row --}}
            <div class="oeko-hero-stats" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
                <div class="oeko-stat">
                    <span class="oeko-stat-number">735</span>
                    <span class="oeko-stat-label">{{ d_trans('Products Tested') }}</span>
                </div>
                <div class="oeko-stat-divider"></div>
                <div class="oeko-stat">
                    <span class="oeko-stat-number">~500</span>
                    <span class="oeko-stat-label">{{ d_trans('Recommended') }}</span>
                </div>
                <div class="oeko-stat-divider"></div>
                <div class="oeko-stat">
                    <span class="oeko-stat-number">24</span>
                    <span class="oeko-stat-label">{{ d_trans('Categories') }}</span>
                </div>
                <div class="oeko-stat-divider"></div>
                <div class="oeko-stat">
                    <span class="oeko-stat-number">50+</span>
                    <span class="oeko-stat-label">{{ d_trans('Substances Tested') }}</span>
                </div>
            </div>

        </div>

        {{-- ── RIGHT SIDE: Editorial Visual ── --}}
        <div class="oeko-hero-right" data-aos="fade-left" data-aos-duration="900">

            {{-- Background blob --}}
            <div class="oeko-hero-blob"></div>

            {{-- Main editorial image --}}
            <div class="oeko-hero-image-wrap">
                <img src="{{ asset(config('theme.settings.home_page.header_background', 'themes/basic/img/hero-cosmetics.jpg')) }}"
                    alt="{{ d_trans('Independent cosmetics testing') }}"
                    class="oeko-hero-image">

                {{-- Floating result card TOP — Very Good product --}}
                <div class="oeko-float-card oeko-float-top"
                    data-aos="fade-left" data-aos-duration="800" data-aos-delay="400">
                    <div class="oeko-float-badge oeko-grade-very-good">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="3">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        {{ d_trans('Very Good') }}
                    </div>
                    <div class="oeko-float-content">
                        <p class="oeko-float-name">Weleda Skin Food Body Butter</p>
                        <p class="oeko-float-finding">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                stroke="#1B5E20" stroke-width="2.5">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            {{ d_trans('No ingredient concerns found') }}
                        </p>
                    </div>
                    <a href="{{ route('businesses.index') }}" class="oeko-float-link">
                        {{ d_trans('Read Test') }} →
                    </a>
                </div>

                {{-- Floating alert card BOTTOM — Poor product --}}
                <div class="oeko-float-card oeko-float-bottom oeko-float-alert"
                    data-aos="fade-right" data-aos-duration="800" data-aos-delay="600">
                    <div class="oeko-alert-header">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="#B71C1C" stroke-width="2.5">
                            <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                        <span>{{ d_trans('Ingredient Alert') }}</span>
                    </div>
                    <p class="oeko-alert-concern">{{ d_trans('Titanium Dioxide detected') }}</p>
                    <div class="oeko-alert-footer">
                        <span class="oeko-float-product-name">Labello Sun Protect SPF30</span>
                        <div class="oeko-float-badge oeko-grade-poor">{{ d_trans('Poor') }}</div>
                    </div>
                </div>

            </div>

            {{-- Decorative wavy line between cards --}}
            <svg class="oeko-wavy-line" viewBox="0 0 120 40" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M5 20 Q20 5 35 20 Q50 35 65 20 Q80 5 95 20 Q110 35 120 20"
                    stroke="#C62828" stroke-width="2" stroke-linecap="round" fill="none"
                    stroke-dasharray="4 3"/>
            </svg>

        </div>

    </div>
</header>

{{-- ═══════════════════════════════════════════════════
     HOME SECTIONS (categories, featured tests etc.)
     ═══════════════════════════════════════════════════ --}}
@foreach ($homeSections as $key => $homeSection)
    @php
        $alias = $homeSection->isPermanent()
            ? str($homeSection->alias)->replace('_', '-')
            : 'category';
    @endphp
    @include("themes.basic.sections.{$alias}", ['homeSection' => $homeSection])
    @if ($key == 0)
        <x-ad alias="home_page_top" class="container" />
    @elseif ($key == 3)
        <x-ad alias="home_page_center" class="container" />
    @endif
@endforeach

<x-ad alias="home_page_bottom" class="container mb-5" />

@push('styles_libs')
    <link rel="stylesheet" href="{{ asset('vendor/libs/simplebar/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/libs/aos/aos.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/libs/swiper/swiper-bundle.min.css') }}">
@endpush

@push('scripts_libs')
    <script src="{{ asset('vendor/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('vendor/libs/aos/aos.min.js') }}"></script>
    <script src="{{ asset('vendor/libs/swiper/swiper-bundle.min.js') }}"></script>
@endpush

{{-- ═══════════════════════════════════════════════════
     ÖKO-TEST HERO STYLES
     ═══════════════════════════════════════════════════ --}}
@push('styles')
<style>
/* ── Fonts ── */
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400;1,700&family=DM+Sans:wght@400;500;600&display=swap');

/* ── Hero Wrapper ── */
.oeko-hero {
    background: #FDF8F4;
    min-height: 100vh;
    display: flex;
    align-items: center;
    padding: 80px 0 60px;
    overflow: visible;
    position: relative;
    z-index: 50;
}

.oeko-hero-inner {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0 40px;
    display: grid;
    grid-template-columns: 55% 45%;
    gap: 60px;
    align-items: center;
    width: 100%;
    overflow: visible;
}

/* ── Left Side ── */
.oeko-hero-left {
    display: flex;
    flex-direction: column;
    gap: 28px;
    overflow: visible;
}

/* Trust pill */
.oeko-trust-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #FFFFFF;
    border: 1px solid #EDE0D4;
    border-radius: 999px;
    padding: 6px 16px 6px 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: 12px;
    font-weight: 600;
    color: #C62828;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    width: fit-content;
    box-shadow: 0 2px 8px rgba(198,40,40,0.08);
}

.oeko-trust-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #C62828;
    flex-shrink: 0;
    animation: oeko-pulse 2s infinite;
}

@keyframes oeko-pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(0.85); }
}

/* Hero title */
.oeko-hero-title {
    font-size: clamp(48px, 5vw, 68px);
    font-weight: 700;
    color: #2C1A0E;
    line-height: 1.05;
    letter-spacing: -0.02em;
    margin: 0;
}

.oeko-hero-star {
    color: #B8860B;
    font-size: 0.85em;
    display: inline-block;
    animation: oeko-spin 20s linear infinite;
}

@keyframes oeko-spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Subtext */
.oeko-hero-subtext {
    font-family: 'DM Sans', sans-serif;
    font-size: 18px;
    color: #4A3728;
    line-height: 1.75;
    margin: 0;
    max-width: 480px;
}

/* Trust badges */
.oeko-trust-badges {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.oeko-trust-badge {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: #FFFFFF;
    border: 1px solid #EDE0D4;
    border-radius: 10px;
    padding: 8px 16px;
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 500;
    color: #4A3728;
    box-shadow: 0 2px 12px rgba(44,26,14,0.06);
}

.oeko-trust-badge svg {
    color: #C62828;
    flex-shrink: 0;
}

/* CTA group */
.oeko-hero-cta-group {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.oeko-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #2C1A0E;
    color: #FFFFFF !important;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 600;
    padding: 14px 32px;
    border-radius: 999px;
    text-decoration: none !important;
    transition: all 200ms ease;
    border: none;
    white-space: nowrap;
}

.oeko-btn-primary:hover {
    background: #C62828;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(198,40,40,0.25);
    color: #FFFFFF !important;
}

.oeko-btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    color: #C62828 !important;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    font-weight: 500;
    text-decoration: underline !important;
    text-underline-offset: 3px;
    transition: all 150ms ease;
}

.oeko-btn-ghost:hover {
    color: #8B0000 !important;
}

/* Search */
.oeko-hero-search {
    max-width: 520px;
    overflow: visible;
}

.oeko-search-input {
    border-radius: 14px !important;
    border: 1.5px solid #EDE0D4 !important;
    background: #FFFFFF !important;
    box-shadow: 0 4px 20px rgba(44,26,14,0.07) !important;
    overflow: visible;
    transition: all 200ms ease;
}

.oeko-search-input:focus-within {
    border-color: #C62828 !important;
    box-shadow: 0 0 0 3px rgba(198,40,40,0.10),
                0 4px 20px rgba(44,26,14,0.07) !important;
}

.oeko-search-input .form-control {
    font-family: 'DM Sans', sans-serif !important;
    font-size: 15px !important;
    color: #4A3728 !important;
    border: none !important;
    box-shadow: none !important;
}

.oeko-search-input .form-control::placeholder {
    color: #9C8878 !important;
}

.oeko-search-input .icon {
    color: #f1f1f1 !important;
}

.oeko-search-input .icon:hover {
    color: #C62828;
}

/* Stats row */
.oeko-hero-stats {
    display: flex;
    align-items: center;
    gap: 0;
    padding-top: 8px;
}

.oeko-stat {
    display: flex;
    flex-direction: column;
    padding: 0 20px;
}

.oeko-stat:first-child {
    padding-left: 0;
}

.oeko-stat-number {
    /* font-family: 'Playfair Display', serif; */
    font-size: 28px;
    font-weight: 700;
    color: #C62828;
    line-height: 1.1;
}

.oeko-stat-label {
    font-family: 'DM Sans', sans-serif;
    font-size: 12px;
    color: #9C8878;
    margin-top: 2px;
    white-space: nowrap;
}

.oeko-stat-divider {
    width: 1px;
    height: 36px;
    background: #EDE0D4;
    flex-shrink: 0;
}

/* ── Right Side ── */
.oeko-hero-right {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Background blob */
.oeko-hero-blob {
    position: absolute;
    width: 420px;
    height: 420px;
    background: #F5EFE8;
    border-radius: 60% 40% 55% 45% / 45% 55% 40% 60%;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 0;
    animation: oeko-blob 8s ease-in-out infinite;
}

@keyframes oeko-blob {
    0%, 100% { border-radius: 60% 40% 55% 45% / 45% 55% 40% 60%; }
    33%       { border-radius: 45% 55% 40% 60% / 60% 40% 55% 45%; }
    66%       { border-radius: 55% 45% 60% 40% / 40% 60% 45% 55%; }
}

/* Hero image */
.oeko-hero-image-wrap {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 480px;
}

.oeko-hero-image {
    width: 100%;
    height: 520px;
    object-fit: cover;
    border-radius: 40% 60% 50% 50% / 40% 40% 60% 60%;
    display: block;
}

/* Floating cards */
.oeko-float-card {
    position: absolute;
    background: #FFFFFF;
    border-radius: 16px;
    padding: 14px 16px;
    box-shadow: 0 12px 40px rgba(44,26,14,0.14);
    z-index: 2;
    min-width: 200px;
    max-width: 240px;
}

.oeko-float-top {
    top: 8%;
    right: -30px;
    animation: oeko-float 3s ease-in-out infinite;
}

.oeko-float-bottom {
    bottom: 10%;
    left: -30px;
    animation: oeko-float 3s ease-in-out infinite;
    animation-delay: 1.5s;
}

@keyframes oeko-float {
    0%, 100% { transform: translateY(0px); }
    50%       { transform: translateY(-8px); }
}

/* Grade badges inside floating cards */
.oeko-float-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 6px;
    font-family: 'DM Sans', sans-serif;
    font-size: 11px;
    font-weight: 700;
    color: #FFFFFF;
    margin-bottom: 8px;
    letter-spacing: 0.03em;
}

.oeko-grade-very-good { background: #1B5E20; }
.oeko-grade-good      { background: #2E7D32; }
.oeko-grade-satisfactory { background: #F57F17; }
.oeko-grade-adequate  { background: #E65100; }
.oeko-grade-poor      { background: #B71C1C; }
.oeko-grade-failing   { background: #4A0000; }

/* Float card content */
.oeko-float-content {
    margin-bottom: 8px;
}

.oeko-float-name {
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #2C1A0E;
    margin: 0 0 4px 0;
    line-height: 1.3;
}

.oeko-float-finding {
    display: flex;
    align-items: center;
    gap: 5px;
    font-family: 'DM Sans', sans-serif;
    font-size: 11px;
    color: #1B5E20;
    margin: 0;
    font-weight: 500;
}

.oeko-float-link {
    font-family: 'DM Sans', sans-serif;
    font-size: 12px;
    font-weight: 600;
    color: #C62828 !important;
    text-decoration: none !important;
    display: block;
    border-top: 1px solid #EDE0D4;
    padding-top: 8px;
    margin-top: 4px;
    transition: color 150ms ease;
}

.oeko-float-link:hover {
    color: #8B0000 !important;
}

/* Alert card */
.oeko-float-alert {
    border-left: 4px solid #B71C1C;
}

.oeko-alert-header {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 6px;
}

.oeko-alert-header span {
    font-family: 'DM Sans', sans-serif;
    font-size: 11px;
    font-weight: 700;
    color: #B71C1C;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}

.oeko-alert-concern {
    font-family: 'DM Sans', sans-serif;
    font-size: 13px;
    font-weight: 600;
    color: #2C1A0E;
    margin: 0 0 8px 0;
}

.oeko-alert-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    border-top: 1px solid #EDE0D4;
    padding-top: 8px;
    margin-top: 4px;
}

.oeko-float-product-name {
    font-family: 'DM Sans', sans-serif;
    font-size: 11px;
    color: #9C8878;
    flex: 1;
    line-height: 1.3;
}

/* Wavy decorative line */
.oeko-wavy-line {
    position: absolute;
    width: 120px;
    height: 40px;
    bottom: 22%;
    right: 0;
    z-index: 3;
    opacity: 0.7;
}

/* ── Responsive ── */
@media (max-width: 1024px) {
    .oeko-hero-inner {
        grid-template-columns: 1fr;
        gap: 48px;
        text-align: center;
    }

    .oeko-hero-left {
        align-items: center;
        text-align: center;
    }

    .oeko-trust-pill,
    .oeko-hero-cta-group {
        justify-content: center;
    }

    .oeko-trust-badges {
        justify-content: center;
    }

    .oeko-hero-subtext {
        max-width: 100%;
    }

    .oeko-hero-stats {
        justify-content: center;
    }

    .oeko-hero-search {
        max-width: 100%;
    }

    .oeko-hero-right {
        max-width: 480px;
        margin: 0 auto;
    }

    .oeko-float-top {
        right: -10px;
    }

    .oeko-float-bottom {
        left: -10px;
    }
}

@media (max-width: 640px) {
    .oeko-hero {
        min-height: auto;
        padding: 56px 0 32px;
        overflow-x: hidden;
    }

    .oeko-hero-inner {
        padding: 0 16px;
        gap: 32px;
    }

    .oeko-hero-left {
        gap: 20px;
    }

    .oeko-hero-title {
        font-size: clamp(34px, 11vw, 40px);
    }

    .oeko-hero-subtext {
        font-size: 15px;
        line-height: 1.65;
        max-width: 34rem;
    }

    .oeko-trust-pill {
        font-size: 11px;
        padding: 6px 12px 6px 10px;
    }

    .oeko-trust-badges {
        width: 100%;
    }

    .oeko-trust-badge {
        width: 100%;
        justify-content: center;
    }

    .oeko-hero-cta-group {
        width: 100%;
        gap: 12px;
    }

    .oeko-btn-primary,
    .oeko-btn-ghost {
        width: 100%;
        justify-content: center;
        text-align: center;
    }

    .oeko-hero-search {
        width: 100%;
        max-width: 100%;
    }

    .oeko-hero-search .header-search,
    .oeko-hero-search form {
        width: 100%;
    }

    .oeko-search-input {
        min-height: 56px;
    }

    .oeko-hero-stats {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        width: 100%;
        padding-top: 0;
    }

    .oeko-stat {
        padding: 14px 12px;
        align-items: center;
        text-align: center;
        border: 1px solid #EDE0D4;
        border-radius: 14px;
        background: #FFFFFF;
        box-shadow: 0 4px 18px rgba(44, 26, 14, 0.05);
    }

    .oeko-stat-divider {
        display: none;
    }

    .oeko-stat-label {
        white-space: normal;
    }

    .oeko-hero-right {
        width: 100%;
        max-width: 100%;
        flex-direction: column;
        align-items: center;
        gap: 14px;
    }

    .oeko-hero-image-wrap {
        width: 100%;
        max-width: 100%;
    }

    .oeko-float-top,
    .oeko-float-bottom {
        position: relative;
        top: auto;
        right: auto;
        bottom: auto;
        left: auto;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        margin-top: 16px;
        animation: none;
    }

    .oeko-hero-image {
        height: clamp(260px, 82vw, 340px);
    }

    .oeko-hero-blob {
        width: clamp(240px, 72vw, 300px);
        height: clamp(240px, 72vw, 300px);
    }

    .oeko-stat-number {
        font-size: 22px;
    }

    .oeko-float-card {
        min-width: 0;
        max-width: 100%;
    }

    .oeko-wavy-line {
        display: none;
    }
}

@media (max-width: 420px) {
    .oeko-hero {
        padding: 48px 0 28px;
    }

    .oeko-hero-inner {
        padding: 0 14px;
        gap: 28px;
    }

    .oeko-hero-title {
        font-size: 32px;
    }

    .oeko-hero-subtext {
        font-size: 14px;
    }

    .oeko-stat {
        padding: 12px 10px;
    }

    .oeko-stat-number {
        font-size: 20px;
    }

    .oeko-trust-badge {
        font-size: 12px;
    }
}
</style>
@endpush

@endsection