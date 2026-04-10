@php
    $addBusiness =
        (config('settings.user.actions.adding_none_exists_business') &&
            !config('settings.business.actions.reviews_require_login')) ||
        (config('settings.user.actions.adding_none_exists_business') &&
            config('settings.business.actions.reviews_require_login') &&
            authUser());
@endphp
<script>
    "use strict";
    const config = {!! json_encode([
        'url' => url('/'),
        'lang' => getLocale(),
        'direction' => getDirection(),
        'colors' => config('theme.settings.colors'),
        'add_business' => $addBusiness,
        'translates' => [
            'copied' => d_trans('Copied to clipboard'),
            'verified' => d_trans('Verified'),
            'actionConfirm' => d_trans('Are you sure?'),
            'noneSelectedText' => d_trans('Nothing selected'),
            'noneResultsText' => d_trans('No results match'),
            'countSelectedText' => d_trans('{0} of {1} selected'),
            'noneBusinessTitle' => d_trans("Can't find a business?"),
            'noneBusinessDescription' => d_trans(
                'It may not be listed yet. Add it now and be the first to leave a review.',
            ),
            'noneBusinessButtonText' => d_trans('Add Business'),
        ],
    ]) !!};
</script>
