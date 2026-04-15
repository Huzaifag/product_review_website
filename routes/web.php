<?php

use Illuminate\Support\Facades\Route;


// optime-clear 

Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
    return 'Application cache cleared';
})->name('optimize.clear');

Route::middleware('maintenance')->group(function () {
    Auth::routes(['verify' => true]);
    Route::namespace('Auth')->group(function () {
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('logout');
        Route::middleware(['registration.disable'])->group(function () {
            Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
            Route::post('register', 'RegisterController@register');
        });
        Route::middleware(['auth', 'account.status'])->group(function () {
            Route::get('data/complete', 'DataCompleteController@showCompleteForm');
            Route::post('data/complete', 'DataCompleteController@complete')->name('data.complete');
        });
        Route::middleware('smtp')->group(function () {
            Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
            Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        });
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
        Route::middleware(['auth', 'account.status', 'data.complete'])->group(function () {
            Route::middleware('smtp')->group(function () {
                Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
                Route::post('email/verify/email/change', 'VerificationController@changeEmail')->name('change.email');
                Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
                Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
            });
            Route::middleware('verified')->group(function () {
                Route::get('2fa/verify', 'TwoFactorController@show2FaVerifyForm');
                Route::post('2fa/verify', 'TwoFactorController@verify2fa')->name('2fa.verify');
            });
        });
    });

    Route::middleware(['account.status', 'data.complete', 'verified', '2fa'])->group(function () {
        Route::get('/', 'GeneralController@home')->name('home');
        Route::name('categories.')->prefix('categories')->group(function () {
            Route::get('/', 'CategoryController@index')->name('index');
            Route::get('{category_slug}', 'CategoryController@category')->name('category');
            Route::get('{category_slug}/{sub_category_slug}', 'CategoryController@subCategory')->name('sub-category');
            Route::get('{category_slug}/{sub_category_slug}/{sub_sub_category_slug}', 'CategoryController@subSubCategory')->name('sub-sub-category');
        });
        Route::name('businesses.')->prefix('businesses')->group(function () {
            Route::get('/', 'BusinessController@index')->name('index');
            Route::get('embed/{id}', 'BusinessController@embed')->name('embed');
            Route::middleware('demo')->group(function () {
                Route::post('add', 'BusinessController@add')->name('add');
                Route::post('claim/{id}', 'BusinessController@claim')->name('claim');
            });
            Route::post('ajax-search', 'BusinessController@ajaxSearch')->name('ajax-search');
            Route::middleware('business.views')->group(function () {
                Route::get('{domain}', 'BusinessController@show')->name('show');
                Route::name('review.')->prefix('{domain}/review')->group(function () {
                    Route::get('/', 'BusinessController@reviewCreate')->name('create');
                    Route::post('/', 'BusinessController@reviewStore')->name('store')->middleware('kyc.required');
                    Route::post('ai-review-writer', 'AiReviewWriterController@write')->name('ai-review-writer')->middleware(['demo', 'addon:ai_review_writer']);
                    Route::get('{id}', 'BusinessController@reviewShow')->name('show');
                    Route::post('{id}/update', 'BusinessController@reviewUpdate')->name('update')->middleware(['demo', 'kyc.required']);
                    Route::post('{id}/report', 'BusinessController@reviewReport')->name('report')->middleware('auth');
                    Route::delete('{id}', 'BusinessController@reviewDelete')->name('delete')->middleware(['demo', 'kyc.required']);
                });
            });
        });
        Route::name('blog.')->prefix('blog')->middleware('blog.disable')->group(function () {
            Route::get('/', 'GeneralController@blog')->name('index');
            Route::get('category', function () {
                return redirect()->route('blog.index');
            });
            Route::get('category/{slug}', 'GeneralController@blogCategory')->name('category');
            Route::get('{slug}', 'GeneralController@blogArticle');
            Route::post('{slug}', 'GeneralController@blogComment')->name('article')->middleware('auth');
        });
        Route::name('products.')->prefix('products')->group(function () {
            Route::get('{slug}', 'ProductController@show')->name('show');
            Route::get('/products', 'ProductController@index')->name('index');
            Route::post('ajax-search', 'ProductController@ajaxSearch')->name('ajax-search');
        });
        Route::name('user.')->prefix('user')->group(function () {
            Route::get('{username}', 'UserController@profile')->name('profile');
            Route::middleware(['demo', 'auth'])->group(function () {
                Route::name('settings.')->prefix('{username}/settings')->group(function () {
                    Route::get('/', 'UserController@settings')->name('index');
                    Route::post('/', 'UserController@detailsUpdate')->name('update');
                    Route::post('password', 'UserController@passwordUpdate')->name('password.update');
                    Route::post('2fa/enable', 'UserController@towFactorEnable')->name('2fa.enable');
                    Route::post('2fa/disabled', 'UserController@towFactorDisable')->name('2fa.disable');
                });
                Route::name('kyc.')->prefix('{username}/kyc')->middleware('kyc.disable')->group(function () {
                    Route::get('/', 'UserController@kyc')->name('index');
                    Route::post('/', 'UserController@kycStore')->name('store');
                });
            });
        });
        Route::get('faqs', 'GeneralController@faqs')->name('faqs');
        Route::middleware(['contact.disable', 'smtp'])->group(function () {
            Route::get('contact-us', 'GeneralController@contact');
            Route::post('contact-us', 'GeneralController@contactSend')->name('contact');
        });
        Route::get('{slug}', 'GeneralController@page')->name('page');
    });
});
