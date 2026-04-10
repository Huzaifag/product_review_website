<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @section('no_index', true)
    @section('section', d_trans('Business'))
    @include('themes.basic.includes.head')
</head>

<body class="body-dashboard">
    <div class="dashboard">
        @include('themes.basic.business.includes.sidebar')
        <div class="dashboard-body">
            @include('themes.basic.business.includes.navbar')
            <div class="dashboard-container @yield('container')">
                <div class="mb-4">
                    <div class="row row-cols-auto g-2 justify-content-between align-items-center">
                        <div class="col">
                            <h3>@yield('header_title')</h3>
                            @yield('breadcrumbs')
                        </div>
                    </div>
                </div>
                <div class="row my-5">
                    <div class="col-lg-8 m-auto">
                        <div class="error-card my-5">
                            <h1 class="error-code">@yield('code')</h1>
                            <h2 class="error-title">@yield('title')</h2>
                            <div class="col-lg-9 m-auto">
                                <p class="error-message">@yield('message')</p>
                            </div>
                            <a href="{{ route('home') }}" class="btn btn-primary btn-md px-5"><i
                                    class="fa fa-home me-1"></i>{{ d_trans('Back to home') }}</a>
                        </div>
                    </div>
                </div>
            </div>
            @include('themes.basic.business.includes.footer')
        </div>
    </div>
    @include('themes.basic.business.partials.add-business-modal')
    @include('themes.basic.includes.scripts')
</body>

</html>
