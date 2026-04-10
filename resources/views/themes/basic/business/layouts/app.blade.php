<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @section('no_index', true)
    @section('section', d_trans('Business'))
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/simplebar/simplebar.min.css') }}">
    @endpush
    @include('themes.basic.includes.head')
</head>

<body class="body-dashboard">
    <div class="dashboard">
        @include('themes.basic.business.includes.sidebar')
        <div class="dashboard-body">
            @include('themes.basic.business.includes.navbar')
            <div {{ request()->routeIs('business.reviews.index') ? 'id=searchPage' : '' }}
                class="dashboard-container @yield('container')">
                @include('themes.basic.business.includes.header')
                @yield('content')
            </div>
            @include('themes.basic.business.includes.footer')
        </div>
    </div>
    @include('themes.basic.business.partials.add-business-modal')
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/simplebar/simplebar.min.js') }}"></script>
    @endpush
    @include('themes.basic.includes.scripts')
</body>

</html>
