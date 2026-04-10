<script>
    "use strict";
    const config = {!! json_encode([
        'url' => url('/'),
        'admin_url' => adminUrl(),
        'lang' => getLocale(),
        'direction' => getDirection(),
        'colors' => config('settings.admin.colors'),
        'translates' => [
            'copied' => d_trans('Copied to clipboard'),
            'actionConfirm' => d_trans('Are you sure?'),
            'emptyTable' => d_trans('No data available in table'),
            'searchPlaceholder' => d_trans('Start typing to search...'),
            'sLengthMenu' => d_trans('Rows per page _MENU_'),
            'info' => d_trans('Showing page _PAGE_ of _PAGES_'),
            'infoEmpty' => d_trans('Showing 0 to 0 of 0 entries'),
            'infoFiltered' => d_trans('(filtered from _MAX_ total entries)'),
            'zeroRecords' => d_trans('No matching records found'),
            'paginate' => [
                'first' => d_trans('First'),
                'previous' => d_trans('Previous'),
                'next' => d_trans('Next'),
                'last' => d_trans('Last'),
            ],
            'on' => d_trans('Active'),
            'off' => d_trans('Disabled'),
            'noneSelectedText' => d_trans('Nothing selected'),
            'noneResultsText' => d_trans('No results match'),
            'countSelectedText' => d_trans('{0} of {1} selected'),
        ],
    ]) !!}
</script>
