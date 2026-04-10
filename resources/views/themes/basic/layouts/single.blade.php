<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @include('themes.basic.includes.head')
    <x-ad alias="head_code" />
</head>

<body class="bg-custom">
    @include('themes.basic.includes.navbar')
    @hasSection('header_v1')
        <header class="header header-sm">
            <div class="container @yield('container') d-flex flex-column flex-grow-1">
                <div class="header-inner">
                    <div class="d-flex justify-content-center">
                        @yield('breadcrumbs')
                    </div>
                    <h1 class="header-title text-center mb-0">@yield('header_title')</h1>
                </div>
            </div>
        </header>
    @endif
    @hasSection('header_v2')
        <header class="header header-sm">
            <div class="container @yield('container') d-flex flex-column flex-grow-1">
                <div class="header-inner text-start">
                    @yield('breadcrumbs')
                    <h1 class="header-title mb-0">@yield('header_title')</h1>
                </div>
            </div>
        </header>
    @endif
    @hasSection('header_v3')
        <header class="header header-sm">
            <div class="container container-custom d-flex flex-column flex-grow-1">
                <div class="header-inner text-start">
                    <div class="row row-cols-1 row-cols-sm-auto justify-content-between align-items-center g-4">
                        <div class="col">
                            @yield('breadcrumbs')
                            <h1 class="header-title mb-0">@yield('header_title')</h1>
                        </div>
                        <div class="col-md-5 col-lg-4 col-xxl-3">
                            <form action="{{ url()->current() }}" method="GET">
                                <div class="form-search form-search-reverse">
                                    <button class="icon">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <input type="text" name="search" placeholder="{{ d_trans('Search...') }}"
                                        class="form-control form-control-md" value="{{ request('search') ?? '' }}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
    @endif
    <section class="section @yield('section_classes')">
        <div class="container @yield('container')">
            <div class="section-inner">
                <div class="section-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>
    @include('themes.basic.partials.add-business-modal')
    @include('themes.basic.includes.footer')
    @include('themes.basic.includes.scripts')
</body>

</html>
