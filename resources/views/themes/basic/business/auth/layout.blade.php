<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @section('section', d_trans('Business'))
    @include('themes.basic.includes.head')
</head>

<body class="bg-body pt-0">
    <div class="sign-page">
        <div class="sign-page-content">
            <div class="sign-page-header">
                <div class="d-flex justify-content-between align-items-center gap-2">
                    <a href="{{ route('business.index') }}" class="logo">
                        <img src="{{ asset(config('theme.settings.general.business_logo_dark')) }}"
                            alt="{{ m_trans(config('settings.general.site_name')) }}">
                    </a>
                    @include('themes.basic.partials.language-menu')
                </div>
            </div>
            <div class="sign-page-form">
                <div class="sign @yield('sign_size')">
                    @yield('content')
                </div>
            </div>
        </div>
        <div class="sign-page-sidebar">
            <div class="sign-page-bg"
                style='background-image: url("{{ asset(config('theme.settings.business.authentication_pages_background')) }}");'>
            </div>
        </div>
    </div>
    @include('themes.basic.includes.scripts')
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}')
            @endforeach
        </script>
    @elseif(session('status'))
        <script>
            toastr.success('{{ session('status') }}')
        </script>
    @elseif(session('resent'))
        <script>
            toastr.success('{{ d_trans('Link has been resend Successfully') }}')
        </script>
    @endif
</body>

</html>
