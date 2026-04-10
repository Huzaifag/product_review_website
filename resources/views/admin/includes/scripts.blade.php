@stack('top_scripts')
<script src="{{ asset('vendor/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/libs/vironeer/toastr/js/vironeer-toastr.min.js') }}"></script>
@stack('scripts_libs')
<script src="{{ asset_with_version('vendor/admin/js/app.js') }}"></script>
@toastrRender
@stack('scripts')
