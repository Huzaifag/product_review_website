<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @include('admin.includes.head')
</head>

<body class="bg-white">
    <div class="sign">
        <div class="sign-body">
            <a href="{{ route('admin.index') }}" class="logo">
                <img src="{{ asset(config('theme.settings.general.logo_dark')) }}"
                    alt="{{ m_trans(config('settings.general.site_name')) }}">
            </a>
            <div class="sign-box">
                @yield('content')
            </div>
            <div class="mt-4 text-center">
                @include('admin.partials.language-menu', [
                    'languageClasses' => 'mb-3',
                    'version' => 'v2',
                ])
                <p class="mb-0 text-muted">
                    &copy; <span data-year></span>
                    {{ m_trans(config('settings.general.site_name')) }} - {{ d_trans('All rights reserved') }}.
                </p>
            </div>
        </div>
    </div>
    @include('admin.includes.scripts')
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
    @endif
</body>

</html>
