<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @include('themes.basic.includes.head')
</head>

<body>
    @include('themes.basic.includes.navbar')
    <section class="section my-auto">
        <div class="section-inner">
            <div class="container container-custom">
                <div class="section-body">
                    <div class="sign @yield('sign_size')">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('themes.basic.includes.footer')
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
