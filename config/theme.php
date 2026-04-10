<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Active Theme
    |--------------------------------------------------------------------------
    |
    | This option determines the active theme for your application.
    | You can change the default theme by setting THEME_ACTIVE in your .env file.
    |
     */
    'active' => env('THEME_ACTIVE', 'basic'),

    /*
    |--------------------------------------------------------------------------
    | Stylesheets
    |--------------------------------------------------------------------------
    |
    | Define the stylesheets for your themes. These paths are relative to the public/themes/theme.
    |
     */
    'style' => [
        'colors' => 'assets/css/colors.css',
        'custom_css' => 'assets/css/custom.css',
    ],
];