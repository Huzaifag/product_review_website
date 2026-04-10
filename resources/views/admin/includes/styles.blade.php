<x-bootstrap/>
<link rel="stylesheet" href="{{ asset('vendor/libs/fontawesome/fontawesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/icons/bootstrap-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/toastr/css/vironeer-toastr.min.css') }}">
@stack('styles_libs')
@adminColors
<link rel="stylesheet" href="{{ asset_with_version('vendor/admin/css/app.css') }}">
@if (getDirection() == 'rtl')
<link rel="stylesheet" href="{{ asset_with_version('vendor/admin/css/app.rtl.css') }}">
@endif
@stack('styles')
@adminCustomStyle
