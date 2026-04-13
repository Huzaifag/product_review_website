<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.login');
    })->name('index');
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login.store');
    Route::post('logout', 'LoginController@logout')->name('logout');
    Route::middleware('smtp')->group(function () {
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    });
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
    Route::middleware('auth:admin')->group(function () {
        Route::get('2fa/verify', 'TwoFactorController@show2FaVerifyForm')->name('2fa.verify');
        Route::post('2fa/verify', 'TwoFactorController@verify2fa');
    });
});

Route::middleware(['auth:admin', '2fa:admin'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');
    });

    Route::name('businesses.')->prefix('businesses')->middleware('demo')->group(function () {
        Route::get('/', 'BusinessController@index')->name('index');
        Route::post('store', 'BusinessController@store')->name('store');
        Route::post('bulk-upload', 'BusinessController@bulkUpload')->name('bulk-upload');
        Route::get('download/csv', 'BusinessController@downloadCSV')->name('download.csv');
        Route::get('{business}', 'BusinessController@show')->name('show');
        Route::post('{business}/details', 'BusinessController@detailsUpdate')->name('details.update');
        Route::post('{business}/logo', 'BusinessController@logoUpdate')->name('logo.update');
        Route::post('{business}/social-links', 'BusinessController@socialLinksUpdate')->name('social-links.update');
        Route::post('{business}/address', 'BusinessController@addressUpdate')->name('address.update');
        Route::middleware('business.owner')->group(function () {
            Route::get('{business}/categories', 'BusinessController@categories')->name('categories');
            Route::delete('{business}/categories/{subCategory}', 'BusinessController@categoriesDelete')->name('categories.delete');
            Route::get('{business}/employees', 'BusinessController@employees')->name('employees');
            Route::delete('{business}/employees/{businessEmployee}', 'BusinessController@employeesDelete')->name('employees.delete');
        });
        Route::get('{business}/reviews', 'BusinessController@reviews')->name('reviews');
        Route::delete('{business}/reviews/{businessReview}', 'BusinessController@reviewsDelete')->name('reviews.delete');
        Route::delete('{business}/reviews/{businessReview}/reply/delete', 'BusinessController@reviewsReplyDelete')->name('reviews.reply.delete');
        Route::get('{business}/statistics', 'BusinessController@statistics')->name('statistics');
        Route::post('{business}/featured/make', 'BusinessController@makeFeatured')->name('featured.make');
        Route::post('{business}/featured/remove', 'BusinessController@removeFeatured')->name('featured.remove');
        Route::post('{business}/activate', 'BusinessController@activate')->name('activate');
        Route::post('{business}/suspend', 'BusinessController@suspend')->name('suspend');
        Route::delete('{business}', 'BusinessController@destroy')->name('destroy');
    });

    Route::resource('products', 'ProductController')->middleware('demo');

    Route::name('pending-reviews.')->prefix('pending-reviews')->group(function () {
        Route::get('/', 'ReviewController@pendingReviews')->name('index');
        Route::get('{businessReview}', 'ReviewController@pendingReviewsShow')->name('show');
        Route::post('{businessReview}/publish', 'ReviewController@pendingReviewsPublish')->name('publish');
        Route::post('{businessReview}/reject', 'ReviewController@pendingReviewsReject')->name('reject');
        Route::delete('{businessReview}', 'ReviewController@pendingReviewsDestroy')->name('destroy');
    });

    Route::name('reported-reviews.')->prefix('reported-reviews')->group(function () {
        Route::get('/', 'ReviewController@reportedReviews')->name('index');
        Route::get('{reportedReview}', 'ReviewController@reportedReviewsShow')->name('show');
        Route::delete('{reportedReview}/delete-review', 'ReviewController@reportedReviewsReviewDelete')->name('delete-review');
        Route::delete('{reportedReview}', 'ReviewController@reportedReviewsDestroy')->name('destroy');
    });

    Route::name('ai-reviewer.')->prefix('ai-reviewer')->middleware(['demo', 'addon:ai_reviewer'])->group(function () {
        Route::get('/', 'AiReviewerController@index')->name('index');
        Route::post('/', 'AiReviewerController@update')->name('update');
    });

    Route::name('ai-review-writer.')->prefix('ai-review-writer')->middleware(['demo', 'addon:ai_review_writer'])->group(function () {
        Route::get('/', 'AiReviewWriterController@index')->name('index');
        Route::post('/', 'AiReviewWriterController@update')->name('update');
    });

    Route::name('members.')->prefix('members')->namespace('Members')->middleware('demo')->group(function () {
        Route::name('users.')->prefix('users')->group(function () {
            Route::get('{user}/login', 'UserController@login')->name('login')->middleware('demo:GET');
            Route::get('{user}/sendmail', 'UserController@sendMail')->name('sendmail.index');
            Route::post('{user}/sendmail', 'UserController@sendMailSend')->name('sendmail.send');
            Route::get('{user}/actions', 'UserController@actions')->name('actions.index');
            Route::post('{user}/actions', 'UserController@actionsUpdate')->name('actions.update');
            Route::get('{user}/password', 'UserController@password')->name('password.index');
            Route::post('{user}/password', 'UserController@passwordUpdate')->name('password.update');
            Route::get('{user}/logs', 'UserController@logs')->name('logs.index');
            Route::delete('{user}/logs/{userLoginLog}', 'UserController@logDelete')->name('logs.delete');
        });
        Route::resource('users', 'UserController')->except(['show']);

        Route::name('business-owners.')->prefix('business-owners')->group(function () {
            Route::get('{businessOwner}/login', 'BusinessOwnerController@login')->name('login')->middleware('demo:GET');
            Route::get('{businessOwner}/sendmail', 'BusinessOwnerController@sendMail')->name('sendmail.index');
            Route::post('{businessOwner}/sendmail', 'BusinessOwnerController@sendMailSend')->name('sendmail.send');
            Route::get('{businessOwner}/actions', 'BusinessOwnerController@actions')->name('actions.index');
            Route::post('{businessOwner}/actions', 'BusinessOwnerController@actionsUpdate')->name('actions.update');
            Route::get('{businessOwner}/password', 'BusinessOwnerController@password')->name('password.index');
            Route::post('{businessOwner}/password', 'BusinessOwnerController@passwordUpdate')->name('password.update');
            Route::get('{businessOwner}/logs', 'BusinessOwnerController@logs')->name('logs.index');
            Route::delete('{businessOwner}/logs/{businessOwnerLoginLog}', 'BusinessOwnerController@logDelete')->name('logs.delete');
        });
        Route::resource('business-owners', 'BusinessOwnerController')->except(['show']);

        Route::name('admins.')->prefix('admins')->group(function () {
            Route::get('{admin}/sendmail', 'AdminController@sendMail')->name('sendmail.index');
            Route::post('{admin}/sendmail', 'AdminController@sendMailSend')->name('sendmail.send');
            Route::get('{admin}/actions', 'AdminController@actions')->name('actions.index');
            Route::post('{admin}/actions', 'AdminController@actionsUpdate')->name('actions.update');
            Route::get('{admin}/password', 'AdminController@password')->name('password.index');
            Route::post('{admin}/password', 'AdminController@passwordUpdate')->name('password.update');
        });
        Route::resource('admins', 'AdminController')->except(['show']);
    });

    Route::name('kyc-verifications.')->prefix('kyc-verifications')->middleware('kyc.disable')->group(function () {
        Route::get('/', 'KycVerificationController@index')->name('index');
        Route::get('{kycVerification}', 'KycVerificationController@show')->name('show');
        Route::post('{kycVerification}/reject', 'KycVerificationController@reject')->name('reject');
        Route::post('{kycVerification}/approve', 'KycVerificationController@approve')->name('approve');
        Route::get('{kycVerification}/{document}/view', 'KycVerificationController@document')->name('document');
        Route::post('{kycVerification}/{document}/download', 'KycVerificationController@download')->name('download');
        Route::delete('{kycVerification}', 'KycVerificationController@destroy')->name('destroy')->middleware('demo');
    });

    Route::middleware('demo')->group(function () {
        Route::namespace('Categories')->group(function () {
            Route::get('categories/slug', 'CategoryController@slug')->name('categories.slug');
            Route::post('categories/sortable', 'CategoryController@sortable')->name('categories.sortable');
            Route::resource('categories', 'CategoryController')->except(['show']);
            Route::name('categories.')->prefix('categories')->group(function () {
                Route::post('sub-categories/load', 'SubCategoryController@load')->name('sub-categories.load');
                Route::get('sub-categories/slug', 'SubCategoryController@slug')->name('sub-categories.slug');
                Route::post('sub-categories/sortable', 'SubCategoryController@sortable')->name('sub-categories.sortable');
                Route::resource('sub-categories', 'SubCategoryController')->except(['show']);
                Route::post('sub-sub-categories/load', 'SubSubCategoryController@load')->name('sub-sub-categories.load');
                Route::get('sub-sub-categories/slug', 'SubSubCategoryController@slug')->name('sub-sub-categories.slug');
                Route::post('sub-sub-categories/sortable', 'SubSubCategoryController@sortable')->name('sub-sub-categories.sortable');
                Route::resource('sub-sub-categories', 'SubSubCategoryController')->except(['show']);
            });
        });

        Route::name('advertisements.')->prefix('advertisements')->group(function () {
            Route::get('/', 'AdvertisementController@index')->name('index');
            Route::get('{advertisement}/edit', 'AdvertisementController@edit')->name('edit');
            Route::post('{advertisement}', 'AdvertisementController@update')->name('update');
        });

        Route::middleware(['license:2', 'subscription.disable'])->group(function () {
            Route::post('plans/sortable', 'PlanController@sortable')->name('plans.sortable');
            Route::resource('plans', 'PlanController')->except(['show']);
            Route::resource('subscriptions', 'SubscriptionController')->except(['edit', 'update']);
            Route::name('transactions.')->prefix('transactions')->group(function () {
                Route::get('/', 'TransactionController@index')->name('index');
                Route::get('{transaction}', 'TransactionController@show')->name('show');
                Route::get('{transaction}/payment-proof/view', 'TransactionController@paymentProof')->name('payment-proof');
                Route::post('{transaction}/paid', 'TransactionController@paid')->name('paid');
                Route::post('{transaction}/cancel', 'TransactionController@cancel')->name('cancel');
                Route::delete('{transaction}', 'TransactionController@destroy')->name('destroy')->middleware('demo');
            });
        });

        Route::name('newsletter.')->prefix('newsletter')->group(function () {
            Route::get('settings', 'NewsletterController@settings')->name('settings');
            Route::post('settings', 'NewsletterController@settingsUpdate')->name('settings.update');
            Route::name('subscribers.')->prefix('subscribers')->group(function () {
                Route::get('/', 'NewsletterController@index')->name('index');
                Route::get('sendmail', 'NewsletterController@sendMail');
                Route::post('sendmail', 'NewsletterController@sendMailSend')->name('sendmail');
                Route::post('export', 'NewsletterController@export')->name('export');
                Route::delete('{newsletterSubscriber}', 'NewsletterController@destroy')->name('destroy');
            });
        });

        Route::name('blog.')->prefix('blog')->namespace('Blog')->middleware('blog.disable')->group(function () {
            Route::get('categories/slug', 'CategoryController@slug')->name('categories.slug');
            Route::resource('categories', 'CategoryController')->except(['show']);
            Route::get('articles/slug', 'ArticleController@slug')->name('articles.slug');
            Route::resource('articles', 'ArticleController')->except(['show']);
            Route::resource('comments', 'CommentController')->except(['create', 'store']);
        });

        Route::name('navigation.')->prefix('navigation')->namespace('Navigation')->group(function () {
            Route::post('navbar-links/nestable', 'NavbarLinkController@nestable')->name('navbar-links.nestable');
            Route::resource('navbar-links', 'NavbarLinkController')->except(['show']);
            Route::post('footer-links/nestable', 'FooterLinkController@nestable')->name('footer-links.nestable');
            Route::resource('footer-links', 'FooterLinkController')->except(['show']);
        });

        Route::name('sections.')->prefix('sections')->namespace('Sections')->group(function () {
            Route::post('home-sections/nestable', 'HomeSectionController@nestable')->name('home-sections.nestable');
            Route::resource('home-sections', 'HomeSectionController')->except(['show']);
            Route::post('faqs/nestable', 'FaqController@nestable')->name('faqs.nestable');
            Route::resource('faqs', 'FaqController')->except(['show']);
        });

        Route::name('settings.')->prefix('settings')->namespace('Settings')->group(function () {
            Route::get('/', 'SettingsController@index')->name('index');

            Route::name('general.')->prefix('general')->group(function () {
                Route::get('/', 'SettingsController@general')->name('index');
                Route::post('/', 'SettingsController@generalUpdate')->name('update');
            });

            Route::name('financial.')->prefix('financial')->middleware(['license:2', 'subscription.disable'])->group(function () {
                Route::get('/', 'SettingsController@financial')->name('index');
                Route::post('/', 'SettingsController@financialUpdate')->name('update');
            });

            Route::name('smtp.')->prefix('smtp')->group(function () {
                Route::get('/', 'SettingsController@smtp')->name('index');
                Route::post('/', 'SettingsController@smtpUpdate')->name('update');
                Route::post('/test', 'SettingsController@smtpTest')->name('test');
            });

            Route::name('user.')->prefix('user')->group(function () {
                Route::get('/', 'SettingsController@user')->name('index');
                Route::post('/', 'SettingsController@userUpdate')->name('update');
            });

            Route::name('business.')->prefix('business')->group(function () {
                Route::get('/', 'SettingsController@business')->name('index');
                Route::post('/', 'SettingsController@businessUpdate')->name('update');
            });

            Route::name('subscription.')->prefix('subscription')->middleware(['license:2'])->group(function () {
                Route::get('/', 'SettingsController@subscription')->name('index');
                Route::post('/', 'SettingsController@subscriptionUpdate')->name('update');
            });

            Route::name('languages.')->prefix('languages')->group(function () {
                Route::post('sortable', 'LanguageController@sortable')->name('sortable');
                Route::post('{language}', 'LanguageController@makeDefault')->name('default');
                Route::get('{language}/translates', 'LanguageController@translates')->name('translates');
                Route::get('{language}/translates/{type}', 'LanguageController@translates')->name('translates.type');
                Route::post('{language}/translates/store', 'LanguageController@translatesStore')->name('translates.store');
                Route::post('{language}/translates', 'LanguageController@translatesUpdate')->name('translates.update');
                Route::delete('{language}/translates/{translate}', 'LanguageController@translatesDestroy')->name('translates.destroy');
            });
            Route::resource('languages', 'LanguageController')->except(['show']);

            Route::name('themes.')->prefix('themes')->group(function () {
                Route::get('/', 'ThemeController@index')->name('index');
                Route::post('upload', 'ThemeController@upload')->name('upload');
                Route::post('{theme}/active', 'ThemeController@makeActive')->name('active');
                Route::name('settings.')->prefix('{theme}/theme-settings')->group(function () {
                    Route::get('/', 'ThemeController@settings')->name('index');
                    Route::get('{group}', 'ThemeController@settings')->name('group');
                    Route::post('{group}', 'ThemeController@settingsUpdate')->name('update');
                });
                Route::name('custom-css.')->prefix('{theme}/custom-css')->group(function () {
                    Route::get('/', 'ThemeController@customCss')->name('index');
                    Route::post('/', 'ThemeController@customCssUpdate')->name('update');
                });
            });

            Route::get('pages/slug', 'PageController@slug')->name('pages.slug');
            Route::resource('pages', 'PageController')->except(['show']);

            Route::resource('taxes', 'TaxController')->except(['show'])->middleware(['license:2', 'subscription.disable']);

            Route::name('mail-templates.')->prefix('mail-templates')->group(function () {
                Route::get('/', 'MailTemplateController@index')->name('index');
                Route::get('{group}', 'MailTemplateController@index')->name('group');
                Route::get('{mailTemplate}/edit', 'MailTemplateController@edit')->name('edit');
                Route::post('{mailTemplate}', 'MailTemplateController@update')->name('update');
            });

            Route::group(['except' => ['create', 'store', 'show', 'destroy']], function () {
                Route::resource('oauth-providers', 'OAuthProviderController');
                Route::resource('captcha-providers', 'CaptchaProviderController');
                Route::resource('extensions', 'ExtensionController');
                Route::resource('payment-gateways', 'PaymentGatewayController')->middleware(['license:2', 'subscription.disable']);
            });
            Route::post('captcha-providers/{captchaProvider}/default', 'CaptchaProviderController@makeDefault')->name('captcha-providers.default');
            Route::post('payment-gateways/sortable', 'PaymentGatewayController@sortable')
                ->name('payment-gateways.sortable')->middleware(['license:2', 'subscription.disable']);

            Route::name('kyc.')->prefix('kyc')->group(function () {
                Route::get('/', 'SettingsController@kyc')->name('index');
                Route::post('/', 'SettingsController@kycUpdate')->name('update');
            });
        });

        Route::name('system.')->prefix('system')->group(function () {
            Route::get('/', 'SystemController@index')->name('index');

            Route::name('information.')->prefix('information')->group(function () {
                Route::get('/', 'SystemController@information')->name('index');
                Route::get('cache', 'SystemController@cache')->name('cache')->middleware('demo:GET');
            });

            Route::name('maintenance.')->prefix('maintenance')->group(function () {
                Route::get('/', 'SystemController@maintenance')->name('index');
                Route::post('/', 'SystemController@maintenanceUpdate')->name('update');
            });

            Route::name('addons.')->prefix('addons')->group(function () {
                Route::get('/', 'SystemController@addons')->name('index');
                Route::post('/', 'SystemController@addonsUpload')->name('upload');
                Route::post('{addon}/update', 'SystemController@addonsUpdate')->name('update');
            });

            Route::name('admin-panel-style.')->prefix('admin-panel-style')->group(function () {
                Route::get('/', 'SystemController@adminPanelStyle')->name('index');
                Route::post('/', 'SystemController@adminPanelStyleUpdate')->name('update');
            });

            Route::name('editor-images.')->prefix('editor-images')->group(function () {
                Route::get('/', 'SystemController@editorImages')->name('index');
                Route::delete('{editorImage}', 'SystemController@editorImagesDestroy')->name('destroy');
            });

            Route::name('cronjob.')->prefix('cronjob')->group(function () {
                Route::get('/', 'SystemController@cronjob')->name('index');
                Route::post('key-generate', 'SystemController@cronjobKeyGenerate')->name('key-generate');
                Route::post('key-remove', 'SystemController@cronjobKeyRemove')->name('key-remove');
            });
        });

        Route::post('image/upload', 'ImageUploadController@upload');

        Route::name('notifications.')->prefix('notifications')->group(function () {
            Route::get('/', 'NotificationController@index')->name('index');
            Route::get('{notification}/view', 'NotificationController@view')->name('view');
            Route::post('read-all', 'NotificationController@readAll')->name('read.all');
            Route::delete('delete-read', 'NotificationController@deleteRead')->name('delete.read');
        });

        Route::name('account.settings.')->prefix('account/settings')->group(function () {
            Route::get('/', 'AccountController@index')->name('index');
            Route::post('details', 'AccountController@detailsUpdate')->name('details');
            Route::post('password', 'AccountController@passwordUpdate')->name('password');
            Route::post('2fa/enable', 'AccountController@twoFactorEnable')->name('2fa.enable');
            Route::post('2fa/disable', 'AccountController@twoFactorDisable')->name('2fa.disable');
        });
    });
});
