<?php

use Illuminate\Support\Facades\Route;

Route::get('maintenance', 'GeneralController@maintenance')->name('maintenance');
Route::get('cronjob', 'GeneralController@cronjob')->name('cronjob')->middleware('demo:GET');
Route::get('localize/{code}', 'GeneralController@localize')->name('localize')->where('code', '[a-zA-Z]{2}');
Route::middleware('maintenance')->group(function () {
    Route::post('cookie/accept', 'GeneralController@cookie');
    Route::name('oauth.')->prefix('oauth')->group(function () {
        Route::middleware('demo:GET')->group(function () {
            Route::get('{provider}/{guard}/login', 'OAuthController@redirectToProvider')->name('login');
            Route::get('{provider}/callback', 'OAuthController@handleProviderCallback')->name('callback');
        });
    });
});
