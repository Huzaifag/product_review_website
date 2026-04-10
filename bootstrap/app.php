<?php

use App\Http\Middleware\AccountStatusMiddleware;
use App\Http\Middleware\Actions\BlogDisable;
use App\Http\Middleware\Actions\ContactDisable;
use App\Http\Middleware\Actions\KycDisable;
use App\Http\Middleware\Actions\RegistrationDisable;
use App\Http\Middleware\Actions\SubscriptionDisable;
use App\Http\Middleware\AddonMiddleware;
use App\Http\Middleware\Admin\BusinessHasOwner;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\Business\BusinessAdmin;
use App\Http\Middleware\Business\BusinessHasCategory;
use App\Http\Middleware\Business\BusinessHasFeature;
use App\Http\Middleware\Business\BusinessViews;
use App\Http\Middleware\Business\CurrentBusiness;
use App\Http\Middleware\Business\DomainVerificationRequired;
use App\Http\Middleware\Business\OwnerHasBusinesses;
use App\Http\Middleware\DataCompleteMiddleware;
use App\Http\Middleware\DemoMode;
use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Middleware\KycVerificationRequired;
use App\Http\Middleware\LicenseMiddleware;
use App\Http\Middleware\Localization;
use App\Http\Middleware\MaintenanceMode;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\SmtpRequired;
use App\Http\Middleware\TwoFactorAuthentication;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            Route::middleware('uninstalled')->namespace('App\Http\Controllers')->group(function () {
                Route::middleware('web')
                    ->group(base_path('routes/global.php'));

                Route::middleware('web')
                    ->name('admin.')
                    ->prefix(config('system.admin.path'))
                    ->namespace('Admin')
                    ->group(base_path('routes/admin.php'));

                Route::middleware('web')
                    ->name('business.')
                    ->prefix(config('system.business.path'))
                    ->namespace('Business')
                    ->group(base_path('routes/business.php'));

                Route::middleware('web')
                    ->name('payments.')
                    ->prefix('payments')
                    ->namespace('Business\Payments')
                    ->group(base_path('routes/payments.php'));

                Route::middleware('web')
                    ->group(base_path('routes/web.php'));
            });
        },
        commands: __DIR__ . '/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(remove: [StartSession::class, ShareErrorsFromSession::class]);
        $middleware->append([StartSession::class, ShareErrorsFromSession::class, Localization::class]);
        $middleware->encryptCookies(except: ['locale', 'direction']);
        $middleware->validateCsrfTokens(except: ['payments/webhooks/*', 'payments/notifications/*', 'payments/ipn/iyzico']);
        $middleware->alias([
            'demo' => DemoMode::class,
            'addon' => AddonMiddleware::class,
            'license' => LicenseMiddleware::class,
            'auth' => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,
            'verified' => EnsureEmailIsVerified::class,
            'account.status' => AccountStatusMiddleware::class,
            'smtp' => SmtpRequired::class,
            '2fa' => TwoFactorAuthentication::class,
            'maintenance' => MaintenanceMode::class,
            'data.complete' => DataCompleteMiddleware::class,
            'registration.disable' => RegistrationDisable::class,
            'blog.disable' => BlogDisable::class,
            'contact.disable' => ContactDisable::class,
            'kyc.disable' => KycDisable::class,
            'kyc.required' => KycVerificationRequired::class,
            'subscription.disable' => SubscriptionDisable::class,
            'business.owner' => BusinessHasOwner::class,
            'has.businesses' => OwnerHasBusinesses::class,
            'business.feature' => BusinessHasFeature::class,
            'business.current' => CurrentBusiness::class,
            'business.domain.verify' => DomainVerificationRequired::class,
            'business.category' => BusinessHasCategory::class,
            'business.admin' => BusinessAdmin::class,
            'business.views' => BusinessViews::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
