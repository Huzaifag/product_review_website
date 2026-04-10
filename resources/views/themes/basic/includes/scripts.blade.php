<livewire:newsletter.popup />
<x-partials />
@include('themes.basic.includes.config')
@stack('top_scripts')
<script src="{{ asset('vendor/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/libs/vironeer/toastr/js/vironeer-toastr.min.js') }}"></script>
@livewireScripts
@stack('scripts_libs')
<script src="{{ theme_asset_with_version('assets/js/app.js') }}"></script>
@stack('scripts')
@toastrRender
{!! config('theme.settings.extra_codes.footer_code') !!}
