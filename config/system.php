<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Author details
    |--------------------------------------------------------------------------
    |
    | Set the details of the author.
    |
     */

    'author' => [
        'name' => 'Vironeer',
        'email' => 'support@vironeer.com',
        'website' => 'https://vironeer.com',
        'profile' => 'https://codecanyon.net/user/vironeer',
    ],

    /*
    |--------------------------------------------------------------------------
    | Item details
    |--------------------------------------------------------------------------
    |
    | Set the details of the item
    |
     */

    'item' => [
        'alias' => 'trustbob',
        'version' => '1.1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Demo Mode
    |--------------------------------------------------------------------------
    |
    | Enable or disable the system demo mode.
    |
     */

    'demo_mode' => env('SYSTEM_DEMO_MODE', false),

    /*
    |--------------------------------------------------------------------------
    | RTL Supported
    |--------------------------------------------------------------------------
    |
    | Check if system support RTL
    |
     */

    'rtl' => env('SYSTEM_RTL_SUPPORTED', false),

    /*
    |--------------------------------------------------------------------------
    | License Information
    |--------------------------------------------------------------------------
    |
    | Set the API endpoint and type for license validation.
    |
     */

    'license' => [
        'api' => 'https://license.vironeer.com/api/v1/license',
        'type' => env('SYSTEM_LICENSE_TYPE', 1),
    ],

    /*
    |--------------------------------------------------------------------------
    | Installation Settings
    |--------------------------------------------------------------------------
    |
    | Configure various installation settings.
    |
     */

    'install' => [
        'requirements' => env('INSTALL_REQUIREMENTS', false),
        'file_permissions' => env('INSTALL_FILE_PERMISSIONS', false),
        'license' => env('INSTALL_LICENSE', false),
        'database_info' => env('INSTALL_DATABASE_INFO', false),
        'database_import' => env('INSTALL_DATABASE_IMPORT', false),
        'complete' => env('INSTALL_COMPLETE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Configurations
    |--------------------------------------------------------------------------
    |
    | Control the admin side configurations
    |
     */

    'admin' => [
        'path' => env('SYSTEM_ADMIN_PATH', 'admin'),
        'colors' => 'vendor/admin/css/colors.css',
        'custom_css' => 'vendor/admin/css/custom.css',
    ],

    /*
    |--------------------------------------------------------------------------
    | Business Configurations
    |--------------------------------------------------------------------------
    |
    | Control the business side configurations
    |
     */

    'business' => [
        'path' => env('SYSTEM_BUSINESS_PATH', 'business'),
    ],

    /*
    |--------------------------------------------------------------------------
    | User Configurations
    |--------------------------------------------------------------------------
    |
    | Control the user side configurations
    |
     */

    'user' => [
        'redirect_to' => env('SYSTEM_USER_REDIRECT_TO', '/'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Recaptcha
    |--------------------------------------------------------------------------
    |
    | Specify the default recaptcha provider
    |
     */

    'recaptcha' => [
        'provider' => env('SYSTEM_RECAPTCHA_PROVIDER', 'google_recaptcha'),
    ],
];
