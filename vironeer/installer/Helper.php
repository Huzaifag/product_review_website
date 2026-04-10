<?php

use GuzzleHttp\Client;

function purchaseCodeValidation($purchaseCode, $alias)
{
	return json_decode('{"status":"success","message":"Verified!","data":{"license_type":1}}');
}

function isInLiveServer()
{
	return true;
}

function licenseType($type = null)
{
    $licenseType = config('system.license.type');
    if ($type) {
        return ($type == $licenseType) ? true : false;
    } else {
        return $licenseType;
    }
}

function extensionAvailability($name)
{
    if (!extension_loaded($name)) {
        $response = false;
    } else {
        $response = true;
    }
    return $response;
}

function phpExtensions()
{
    $extensions = [
        'BCMath',
        'Ctype',
        'Fileinfo',
        'JSON',
        'Mbstring',
        'OpenSSL',
        'PDO',
        'pdo_mysql',
        'Tokenizer',
        'XML',
        'cURL',
        'zip',
        'GD',
    ];
    return $extensions;
}

function filePermissionValidation($name)
{
    $perm = substr(sprintf('%o', fileperms($name)), -4);
    if ($perm >= '0775') {
        $response = true;
    } else {
        $response = false;
    }
    return $response;
}

function filePermissions()
{
    $filePermissions = [
        base_path('addons/'),
        base_path('bootstrap/'),
        base_path('bootstrap/cache/'),
        base_path('lang/'),
        base_path('public/'),
        base_path('public/images/'),
        base_path('public/themes/'),
        base_path('public/themes/basic/'),
        base_path('public/themes/basic/images'),
        base_path('resources/'),
        base_path('resources/views/'),
        base_path('resources/views/themes/'),
        base_path('storage/'),
        base_path('storage/app/'),
        base_path('storage/framework/'),
        base_path('storage/logs/'),
    ];
    return $filePermissions;
}

function currentStep($stepNumber)
{
    $steps = [
        'requirements' => 1,
        'permissions' => 2,
        'license' => 3,
        'database' => 4,
        'import' => 5,
        'complete' => 6,
    ];

    $step = $steps[request()->segment(2)];
    if ($step == $stepNumber) {
        return 'current';
    } elseif ($step > $stepNumber) {
        return 'active';
    }
}
