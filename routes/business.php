<?php

use Illuminate\Support\Facades\Route;

Route::middleware('maintenance')->group(function () {
    Auth::routes(['verify' => true]);
    Route::get('invitation/{token}', 'GeneralController@employeeInvitation')->name('invitation');
    Route::get('/', function () {
        return redirect()->route('business.login');
    })->name('index');
    Route::namespace('Auth')->group(function () {
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->name('logout');
        Route::middleware(['registration.disable:business_owner'])->group(function () {
            Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
            Route::post('register', 'RegisterController@register');
        });
        Route::middleware(['auth:business_owner', 'account.status:business_owner'])->group(function () {
            Route::get('data/complete', 'DataCompleteController@showCompleteForm');
            Route::post('data/complete', 'DataCompleteController@complete')->name('data.complete');
        });
        Route::middleware('smtp')->group(function () {
            Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
            Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        });
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
        Route::middleware(['auth:business_owner', 'account.status:business_owner', 'data.complete:business_owner'])->group(function () {
            Route::middleware('smtp')->group(function () {
                Route::get('email/verify', 'VerificationController@show')->name('verification.notice');
                Route::post('email/verify/email/change', 'VerificationController@changeEmail')->name('change.email');
                Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify');
                Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');
            });
            Route::middleware('verified:business_owner')->group(function () {
                Route::get('2fa/verify', 'TwoFactorController@show2FaVerifyForm');
                Route::post('2fa/verify', 'TwoFactorController@verify2fa')->name('2fa.verify');
                Route::name('setup.')->prefix('setup')->middleware('2fa:business_owner')->group(function () {
                    Route::get('/', 'SetupController@index')->name('index');
                    Route::post('/', 'SetupController@store')->name('store');
                });
                Route::name('claim.')->prefix('claim')->group(function () {
                    Route::get('{id}', 'ClaimController@index')->name('index');
                    Route::post('{id}', 'ClaimController@verify')->name('verify');
                });
            });
        });
    });

    Route::middleware(['auth:business_owner', 'account.status:business_owner',
        'data.complete:business_owner', 'verified:business_owner', '2fa:business_owner', 'has.businesses', 'business.current'])->group(function () {
        Route::middleware('demo')->group(function () {
            Route::get('dashboard', 'DashboardController@index')->name('dashboard');
            Route::get('current/{id}', 'GeneralController@setDefaultBusiness')->name('current');
            Route::post('add', 'GeneralController@addBusiness')->name('add')->middleware('kyc.required:business_owner');
            Route::name('reviews.')->prefix('reviews')->group(function () {
                Route::get('/', 'ReviewController@index')->name('index');
                Route::middleware(['kyc.required:business_owner', 'business.domain.verify'])->group(function () {
                    Route::post('{id}/reply', 'ReviewController@reply')->name('reply');
                    Route::post('{id}/reply/update', 'ReviewController@replyUpdate')->name('reply.update');
                });
            });
            Route::middleware('business.admin')->group(function () {
                Route::name('employees.')->prefix('employees')->middleware('business.feature:employees')->group(function () {
                    Route::get('/', 'EmployeeController@index')->name('index');
                    Route::middleware(['kyc.required:business_owner', 'business.domain.verify'])->group(function () {
                        Route::post('store', 'EmployeeController@store')->name('store');
                        Route::delete('{id}', 'EmployeeController@destroy')->name('destroy');
                    });
                });
                Route::name('categories.')->prefix('categories')->middleware(['business.feature:categories', 'business.category'])->group(function () {
                    Route::get('/', 'CategoriesController@index')->name('index');
                    Route::middleware(['kyc.required:business_owner', 'business.domain.verify'])->group(function () {
                        Route::post('store', 'CategoriesController@store')->name('store');
                        Route::delete('{slug}', 'CategoriesController@destroy')->name('destroy');
                    });
                    Route::post('load/sub-categories', 'CategoriesController@loadSubCategories')->name('load.sub-categories');
                    Route::post('load/sub-sub-categories', 'CategoriesController@loadSubSubCategories')->name('load.sub-sub-categories');
                });
                Route::get('integration', 'GeneralController@integration')->middleware('business.domain.verify')->name('integration');
                Route::name('settings.')->prefix('settings')->group(function () {
                    Route::get('/', 'SettingsController@index')->name('index');
                    Route::post('details', 'SettingsController@detailsUpdate')->name('details.update');
                    Route::post('logo', 'SettingsController@logoUpdate')->name('logo.update');
                    Route::post('social-links', 'SettingsController@socialLinksUpdate')->name('social-links.update');
                    Route::post('address', 'SettingsController@addressUpdate')->name('address.update');
                    Route::post('verify', 'SettingsController@domainVerify')->name('verify');
                    Route::post('delete', 'SettingsController@businessDelete')->name('delete');
                });
            });
            Route::name('notifications.')->prefix('notifications')->group(function () {
                Route::get('/', 'NotificationController@index')->name('index');
                Route::get('{notification}/view', 'NotificationController@view')->name('view');
                Route::post('read-all', 'NotificationController@readAll')->name('read.all');
                Route::delete('delete-read', 'NotificationController@deleteRead')->name('delete.read');
            });
        });
        Route::name('subscription.')->prefix('subscription')->middleware(['license:2', 'subscription.disable'])->group(function () {
            Route::get('/', 'SubscriptionController@index')->name('index');
            Route::post('cancel', 'SubscriptionController@cancel')->name('cancel')->middleware('demo');
            Route::get('transactions/{id}', 'SubscriptionController@transactionsShow')->name('transactions.show');
            Route::get('transactions/{id}/invoice', 'SubscriptionController@transactionsInvoice')->name('transactions.invoice');
            Route::name('plans.')->prefix('plans')->group(function () {
                Route::get('/', 'SubscriptionController@plans')->name('index');
                Route::post('{id}/subscribe', 'SubscriptionController@subscribe')->name('subscribe')->middleware('kyc.required:business_owner');
            });
        });
        Route::name('checkout.')->prefix('checkout')->group(function () {
            Route::get('{id}', 'CheckoutController@index')->name('index');
            Route::post('{id}', 'CheckoutController@process')->name('process');
        });
        Route::name('account.settings.')->prefix('account/settings')->middleware('demo')->group(function () {
            Route::get('/', 'AccountSettingsController@index')->name('index');
            Route::post('/', 'AccountSettingsController@update')->name('update');
            Route::get('password', 'AccountSettingsController@password')->name('password');
            Route::post('password', 'AccountSettingsController@passwordUpdate')->name('password.update');
            Route::get('2fa', 'AccountSettingsController@twoFactor')->name('2fa');
            Route::post('2fa/enable', 'AccountSettingsController@towFactorEnable')->name('2fa.enable');
            Route::post('2fa/disabled', 'AccountSettingsController@towFactorDisable')->name('2fa.disable');
            Route::middleware('kyc.disable')->group(function () {
                Route::get('kyc', 'AccountSettingsController@kyc')->name('kyc');
                Route::post('kyc', 'AccountSettingsController@kycStore')->name('kyc.store');
            });
        });
    });
});
