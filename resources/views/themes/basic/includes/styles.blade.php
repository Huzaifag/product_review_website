<x-bootstrap/>
<link rel="stylesheet" href="{{ asset('vendor/libs/fontawesome/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/icons/bootstrap-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/toastr/css/vironeer-toastr.min.css') }}">
@stack('styles_libs')
@themeColors
<link rel="stylesheet" href="{{ theme_asset_with_version('assets/css/app.css') }}">
@if (config('system.rtl') && getDirection() == 'rtl')
<link rel="stylesheet" href="{{ theme_asset_with_version('assets/css/app.rtl.css') }}">
@endif
@stack('styles')
@themeCustomStyle
{!! config('theme.settings.extra_codes.head_code') !!}
@livewireStyles