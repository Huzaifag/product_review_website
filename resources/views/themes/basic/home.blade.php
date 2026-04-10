@extends('themes.basic.layouts.app')
@section('title', m_trans(config('settings.seo.title')))
@section('content')
    <header class="header header-image"
        style='background-image:url("{{ asset(config('theme.settings.home_page.header_background')) }}")'>
        <div class="container container-custom d-flex flex-column flex-grow-1">
            <div class="header-inner">
                <div class="col-12 col-lg-10 col-xl-9 col-xxl-8 mx-auto text-center px-2 px-xxl-0">
                    <div class="col-xl-11 mx-auto">
                        <h1 class="header-title" data-aos="fade-right" data-aos-duration="1000">
                            {{ d_trans('Rate and Find Trusted Businesses') }}
                        </h1>
                        <p class="header-text" data-aos="fade-left" data-aos-duration="1000">
                            {{ d_trans('Rate and review businesses based on your experiences, and explore trusted businesses to make informed decisions') }}
                        </p>
                    </div>
                </div>
                <div class="col-12 col-lg-10 col-xl-9 col-xxl-7 mx-auto text-center px-2 px-xxl-0">
                    <div class="header-search search home-search" data-aos="fade-up" data-aos-duration="1000">
                        <form action="{{ route('businesses.index') }}"
                            data-ajax-action="{{ route('businesses.ajax-search') }}"
                            data-ajax-empty="{{ d_trans('No results found') }}" method="GET">
                            <div class="search-input">
                                <button aria-label="{{ d_trans('Search') }}" class="icon">
                                    <i class="bi bi-search"></i>
                                </button>
                                <input type="text" name="search" class="form-control"
                                    placeholder="{{ d_trans('Search...') }}" required>
                            </div>
                        </form>
                        <div class="search-results">
                            <div class="search-results-inner" data-simplebar>
                                <div></div>
                            </div>
                            <a href="{{ route('businesses.index') }}" class="search-action">{{ d_trans('View All') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @foreach ($homeSections as $key => $homeSection)
        @php
            $alias = $homeSection->isPermanent() ? str($homeSection->alias)->replace('_', '-') : 'category';
        @endphp
        @include("themes.basic.sections.{$alias}", ['homeSection' => $homeSection])
        @if ($key == 0)
            <x-ad alias="home_page_top" @class('container') />
        @elseif ($key == 3)
            <x-ad alias="home_page_center" @class('container') />
        @endif
    @endforeach
    <x-ad alias="home_page_bottom" @class('container mb-5') />
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
@endsection
