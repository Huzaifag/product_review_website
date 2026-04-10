<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/simplebar/simplebar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/colors.min.css') }}">
    @endpush
    @include('admin.includes.head')
</head>

<body>
    <div class="dashboard">
        @include('admin.includes.sidebar')
        <div class="dashboard-content">
            @include('admin.includes.navbar')
            <div class="dashboard-body">
                <div class="dashboard-container @yield('container')">
                    @include('admin.includes.header')
                    <div class="mb-4">
                        @yield('content')
                    </div>
                </div>
            </div>
            @include('admin.includes.footer')
        </div>
    </div>
    @include('admin.includes.config')
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/simplebar/simplebar.min.js') }}"></script>
    @endpush
    @include('admin.includes.scripts')
</body>

</html>
