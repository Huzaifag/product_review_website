<footer class="dashboard-footer">
    <p class="mb-0"> &copy; <span data-year></span> {{ m_trans(config('settings.general.site_name')) }} -
        {{ d_trans('All rights reserved.') }}</p>
    <p class="mb-0 ms-auto">
        {{ d_trans(':app_name v:version', [
            'app_name' => ucfirst(config('system.item.alias')),
            'version' => config('system.item.version'),
        ]) }}
    </p>
</footer>
