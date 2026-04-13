@extends('themes.basic.layouts.app')
@section('title', m_trans(config('settings.seo.title')))

@section('content')
    <header class="hero-premium" style='background-image:url("{{ asset(config('theme.settings.home_page.header_background')) }}")'>
        <div class="hero-overlay"></div>
        
        <div class="container container-custom hero-content d-flex flex-column flex-grow-1 justify-content-center">
            <div class="row w-100 mx-auto">
                <div class="col-12 col-lg-10 col-xl-8 mx-auto text-center mb-5">
                    <h1 class="hero-title" data-aos="fade-down" data-aos-duration="1000">
                        {{ d_trans('Know What You Put On Your Skin') }}
                    </h1>
                    <p class="hero-subtitle" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
                        {{ d_trans('Independent lab results for 735 beauty products — honest ratings you can trust.') }}
                    </p>
                </div>

                <div class="col-12 col-md-10 col-xl-8 mx-auto position-relative">
                    <div class="search-container" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="200">
                        <form action="{{ route('businesses.index') }}"
                              data-ajax-action="{{ route('businesses.ajax-search') }}"
                              data-ajax-empty="{{ d_trans('No results found') }}" 
                              method="GET" 
                              class="premium-search-form">
                            
                            <div class="search-input-group">
                                <span class="search-icon-wrapper">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" 
                                       name="search" 
                                       class="premium-search-input"
                                       placeholder="{{ d_trans('What are you looking for today?') }}" 
                                       required
                                       autocomplete="off">
                                <button type="submit" class="premium-search-btn">
                                    {{ d_trans('Search') }}
                                </button>
                            </div>
                        </form>

                        <div class="premium-search-results">
                            <div class="search-results-inner" data-simplebar>
                                <div></div>
                            </div>
                            <div class="search-results-footer">
                                <a href="{{ route('businesses.index') }}" class="search-action-link">
                                    {{ d_trans('View All Results') }} <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content-wrapper">
        @php
            $renderedSections = 0;
        @endphp

        @foreach ($homeSections as $homeSection)
            @php
                $alias = $homeSection->isPermanent() ? str($homeSection->alias)->replace('_', '-') : 'category';
                $sectionContent = view("themes.basic.sections.{$alias}", ['homeSection' => $homeSection])->render();
            @endphp

            @if (trim($sectionContent) !== '')
                @php
                    $renderedSections++;
                @endphp

                <section class="home-section-block">
                    {!! $sectionContent !!}
                </section>

                @if ($renderedSections === 1)
                    <div class="ad-container" data-aos="fade-up">
                        <x-ad alias="home_page_top" class="container" />
                    </div>
                @elseif ($renderedSections === 4)
                    <div class="ad-container" data-aos="fade-up">
                        <x-ad alias="home_page_center" class="container" />
                    </div>
                @endif
            @endif
        @endforeach

        <div class="ad-container mb-5">
            <x-ad alias="home_page_bottom" class="container" />
        </div>
    </main>

    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/simplebar/simplebar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/aos/aos.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/swiper/swiper-bundle.min.css') }}">
        
        <style>
            /* Colors & Typography System */
            :root {
                --primary-accent: rgb(186 81 29);
                --primary-hover: rgb(186 81 29 / 0.8);
                --text-dark: #111827;
                --text-muted: #6B7280;
                --glass-bg: rgba(255, 255, 255, 0.95);
            }

            /* Hero Section */
            .hero-premium {
                position: relative;
                min-height: 100vh;
                display: flex;
                align-items: center;
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                width: 100%;
            }


            .hero-content {
                position: relative;
                z-index: 2;
                padding-top: 5rem;
                padding-bottom: 5rem;
            }

            .hero-title {
                color: var(--primary-accent);
                font-size: clamp(2.5rem, 5vw, 4rem);
                font-weight: 800;
                letter-spacing: -0.025em;
                line-height: 1.1;
                margin-bottom: 1.25rem;
                text-shadow: 0 4px 20px rgba(0,0,0,0.2);
            }

            .hero-subtitle {
                color: var(--text-muted);
                font-size: clamp(1.125rem, 2vw, 1.25rem);
                font-weight: 400;
                line-height: 1.6;
                max-width: 800px;
                margin: 0 auto;
            }

            /* Search Bar UI */
            .search-container {
                position: relative;
                z-index: 10;
            }

            .premium-search-form {
                background: var(--glass-bg);
                border-radius: 99px;
                padding: 0.5rem;
                box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.25), 
                            0 0 0 1px rgba(255, 255, 255, 0.1) inset;
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
                backdrop-filter: blur(10px);
            }

            .premium-search-form:focus-within {
                transform: translateY(-2px);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35), 
                            0 0 0 3px rgba(79, 70, 229, 0.3);
            }

            .search-input-group {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .search-icon-wrapper {
                padding-left: 1.5rem;
                color: var(--text-muted);
                font-size: 1.25rem;
            }

            .premium-search-input {
                flex: 1;
                border: none;
                background: transparent;
                padding: 1rem 0.5rem;
                font-size: 1.125rem;
                color: var(--text-dark);
                outline: none;
                font-weight: 500;
            }

            .premium-search-input::placeholder {
                color: #9CA3AF;
                font-weight: 400;
            }

            .premium-search-btn {
                background-color: var(--primary-accent);
                color: white;
                border: none;
                border-radius: 99px;
                padding: 0.875rem 2rem;
                font-size: 1rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .premium-search-btn:hover {
                background-color: var(--primary-hover);
                box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
            }

            /* Search Results Dropdown (Glassmorphism + SaaS Card) */
            .premium-search-results {
                position: absolute;
                top: calc(100% + 1rem);
                left: 0;
                right: 0;
                background: #ffffff;
                border-radius: 1rem;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 
                            0 4px 6px -4px rgba(0, 0, 0, 0.1);
                border: 1px solid rgba(0, 0, 0, 0.05);
                opacity: 0;
                visibility: hidden;
                transform: translateY(-10px);
                transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                overflow: hidden;
            }

            /* Note: Add 'show' class via your JS when search is active */
            .search-container.active .premium-search-results {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }

            .search-results-inner {
                max-height: 400px;
                padding: 1rem;
            }

            .search-results-footer {
                padding: 1rem;
                background: #F9FAFB;
                border-top: 1px solid #E5E7EB;
                text-align: center;
            }

            .search-action-link {
                color: var(--primary-accent);
                font-weight: 600;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                transition: color 0.2s ease;
            }

            .search-action-link:hover {
                color: var(--primary-hover);
            }

            /* Main Layout Spacing */
            .home-section-block:nth-child(even) {
                background: #FFFFFF;
            }
            .ad-container {
                margin: 2rem auto;
            }

            /* Responsive Adjustments */
            @media (max-width: 768px) {
                .hero-premium { min-height: 60vh; }
                .premium-search-form { flex-direction: column; border-radius: 1rem; padding: 1rem; }
                .search-icon-wrapper { display: none; }
                .premium-search-btn { width: 100%; border-radius: 0.5rem; margin-top: 0.5rem; }
            }
        </style>
    @endpush

    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/aos/aos.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/swiper/swiper-bundle.min.js') }}"></script>
        <script>
            // Simple logic to toggle the dropdown state for the animation
            document.addEventListener('DOMContentLoaded', () => {
                const searchInput = document.querySelector('.premium-search-input');
                const searchContainer = document.querySelector('.search-container');
                
                searchInput.addEventListener('input', (e) => {
                    if(e.target.value.length > 1) {
                        searchContainer.classList.add('active');
                    } else {
                        searchContainer.classList.remove('active');
                    }
                });
            });
        </script>
    @endpush
@endsection