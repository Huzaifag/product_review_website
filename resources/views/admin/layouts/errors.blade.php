<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/simplebar/simplebar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/icons/bootstrap-icons.min.css') }}">
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
                <div class="dashboard-container">
                    <div class="error">
                        <div class="box error-box">
                            <div class="error-type">@yield('code')</div>
                            <h2 class="error-title">@yield('title')</h2>
                            <p class="error-text">@yield('message')</p>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-md">
                                <i class="fa fa-arrow-left icon-rtl me-2"></i>{{ d_trans('Go to Dashboard') }}
                            </a>
                        </div>
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
