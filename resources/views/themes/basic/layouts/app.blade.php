<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @include('themes.basic.includes.head')
    <x-ad alias="head_code" />
</head>

<body>
    @include('themes.basic.includes.navbar')
    @yield('content')
    @include('themes.basic.partials.add-business-modal')
    @include('themes.basic.includes.footer')
    @include('themes.basic.includes.scripts')
</body>

</html>
