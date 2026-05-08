@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('title', d_trans('Settings'))
@section('header_title', d_trans('Settings'))
@section('page_search', true)
@section('content')
    <div class="sys-settings">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3">
            <!-- General Settings -->
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.general.index') }}" class="premium-card">
                    <div class="card-glow"></div>
                    <div class="premium-card-body">
                        <div class="icon-wrapper bg-soft-primary">
                            <i class="bi bi-gear-fill"></i>
                        </div>
                        <div class="content-wrapper">
                            <h6 class="card-title">{{ d_trans('General Settings') }}</h6>
                            <p class="card-description">{{ d_trans('Manage general settings for your website.') }}</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right arrow-hint"></i>
                </a>
            </div>

            @if (licenseType(2) && config('settings.subscription.status'))
                <!-- Financial Settings -->
                <div class="col page-search-element">
                    <a href="{{ route('admin.settings.financial.index') }}" class="premium-card">
                        <div class="card-glow"></div>
                        <div class="premium-card-body">
                            <div class="icon-wrapper bg-soft-success">
                                <i class="bi bi-bank"></i>
                            </div>
                            <div class="content-wrapper">
                                <h6 class="card-title">{{ d_trans('Financial Settings') }}</h6>
                                <p class="card-description">{{ d_trans('Manage your website financial Settings.') }}</p>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right arrow-hint"></i>
                    </a>
                </div>
            @endif

            <!-- SMTP Settings -->
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.smtp.index') }}" class="premium-card">
                    <div class="card-glow"></div>
                    <div class="premium-card-body">
                        <div class="icon-wrapper bg-soft-info">
                            <i class="bi bi-send"></i>
                        </div>
                        <div class="content-wrapper">
                            <h6 class="card-title">{{ d_trans('SMTP Settings') }}</h6>
                            <p class="card-description">{{ d_trans('Configure your email server settings.') }}</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right arrow-hint"></i>
                </a>
            </div>

            <!-- User Settings -->
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.user.index') }}" class="premium-card">
                    <div class="card-glow"></div>
                    <div class="premium-card-body">
                        <div class="icon-wrapper bg-soft-warning">
                            <i class="bi bi-person-gear"></i>
                        </div>
                        <div class="content-wrapper">
                            <h6 class="card-title">{{ d_trans('User Settings') }}</h6>
                            <p class="card-description">{{ d_trans('Manage and control the user settings.') }}</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right arrow-hint"></i>
                </a>
            </div>

            {{-- <div class="col page-search-element">
            <a href="{{ route('admin.settings.business.index') }}" class="premium-card">
                <div class="card-glow"></div>
                <div class="premium-card-body">
                    <div class="icon-wrapper bg-soft-secondary">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <div class="content-wrapper">
                        <h6 class="card-title">{{ d_trans('Business Settings') }}</h6>
                        <p class="card-description">{{ d_trans('Manage and control the business settings.') }}</p>
                    </div>
                </div>
                <i class="bi bi-chevron-right arrow-hint"></i>
            </a>
        </div> --}}

            <!-- Payment Methods -->
            <div class="col page-search-element">
                <a href="{{ route('admin.payment-methods.index') }}" class="premium-card">
                    <div class="card-glow"></div>
                    <div class="premium-card-body">
                        <div class="icon-wrapper bg-soft-primary">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <div class="content-wrapper">
                            <h6 class="card-title">{{ d_trans('Payment Methods') }}</h6>
                            <p class="card-description">{{ d_trans('Manage available payment methods.') }}</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right arrow-hint"></i>
                </a>
            </div>

            <!-- KYC Settings -->
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.kyc.index') }}" class="premium-card">
                    <div class="card-glow"></div>
                    <div class="premium-card-body">
                        <div class="icon-wrapper bg-soft-danger">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <div class="content-wrapper">
                            <h6 class="card-title">{{ d_trans('KYC Settings') }}</h6>
                            <p class="card-description">{{ d_trans('Manage KYC requirements and settings.') }}</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right arrow-hint"></i>
                </a>
            </div>

            @if (licenseType(2))
                <!-- Subscription Settings -->
                <div class="col page-search-element">
                    <a href="{{ route('admin.settings.subscription.index') }}" class="premium-card">
                        <div class="card-glow"></div>
                        <div class="premium-card-body">
                            <div class="icon-wrapper bg-soft-secondary">
                                <i class="bi bi-gem"></i>
                            </div>
                            <div class="content-wrapper">
                                <h6 class="card-title">{{ d_trans('Subscription Settings') }}</h6>
                                <p class="card-description">{{ d_trans('Manage your subscription settings.') }}</p>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right arrow-hint"></i>
                    </a>
                </div>
            @endif

            <!-- Languages -->
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.languages.index') }}" class="premium-card">
                    <div class="card-glow"></div>
                    <div class="premium-card-body">
                        <div class="icon-wrapper bg-soft-info">
                            <i class="bi bi-translate"></i>
                        </div>
                        <div class="content-wrapper">
                            <h6 class="card-title">{{ d_trans('Languages') }}</h6>
                            <p class="card-description">{{ d_trans('Manage language for your website.') }}</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right arrow-hint"></i>
                </a>
            </div>

            <!-- Mail Templates -->
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.mail-templates.index') }}" class="premium-card">
                    <div class="card-glow"></div>
                    <div class="premium-card-body">
                        <div class="icon-wrapper bg-soft-warning">
                            <i class="bi bi-envelope-open"></i>
                        </div>
                        <div class="content-wrapper">
                            <h6 class="card-title">{{ d_trans('Mail Templates') }}</h6>
                            <p class="card-description">{{ d_trans('Customize email templates for notifications.') }}</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right arrow-hint"></i>
                </a>
            </div>

            <!-- Themes -->
            {{-- <div class="col page-search-element">
                <a href="{{ route('admin.settings.themes.index') }}" class="premium-card">
                    <div class="card-glow"></div>
                    <div class="premium-card-body">
                        <div class="icon-wrapper bg-soft-danger">
                            <i class="bi bi-paint-bucket"></i>
                        </div>
                        <div class="content-wrapper">
                            <h6 class="card-title">{{ d_trans('Themes') }}</h6>
                            <p class="card-description">{{ d_trans('Select and manage your website themes.') }}</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right arrow-hint"></i>
                </a>
            </div> --}}

            <!-- Pages -->
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.pages.index') }}" class="premium-card">
                    <div class="card-glow"></div>
                    <div class="premium-card-body">
                        <div class="icon-wrapper bg-soft-success">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <div class="content-wrapper">
                            <h6 class="card-title">{{ d_trans('Pages') }}</h6>
                            <p class="card-description">{{ d_trans('Create and manage website pages.') }}</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right arrow-hint"></i>
                </a>
            </div>

            <!-- OAuth Providers -->
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.oauth-providers.index') }}" class="premium-card">
                    <div class="card-glow"></div>
                    <div class="premium-card-body">
                        <div class="icon-wrapper bg-soft-primary">
                            <i class="bi bi-box-arrow-in-right"></i>
                        </div>
                        <div class="content-wrapper">
                            <h6 class="card-title">{{ d_trans('OAuth Providers') }}</h6>
                            <p class="card-description">{{ d_trans('Manage OAuth providers for social logins.') }}</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right arrow-hint"></i>
                </a>
            </div>

            <!-- Captcha Providers -->
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.captcha-providers.index') }}" class="premium-card">
                    <div class="card-glow"></div>
                    <div class="premium-card-body">
                        <div class="icon-wrapper bg-soft-danger">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <div class="content-wrapper">
                            <h6 class="card-title">{{ d_trans('Captcha Providers') }}</h6>
                            <p class="card-description">{{ d_trans('Set up captcha services to prevent bots.') }}</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right arrow-hint"></i>
                </a>
            </div>

            <!-- Extensions -->
            {{-- <div class="col page-search-element">
                <a href="{{ route('admin.settings.extensions.index') }}" class="premium-card">
                    <div class="card-glow"></div>
                    <div class="premium-card-body">
                        <div class="icon-wrapper bg-soft-secondary">
                            <i class="bi bi-puzzle"></i>
                        </div>
                        <div class="content-wrapper">
                            <h6 class="card-title">{{ d_trans('Extensions') }}</h6>
                            <p class="card-description">{{ d_trans('Install and manage website extensions.') }}</p>
                        </div>
                    </div>
                    <i class="bi bi-chevron-right arrow-hint"></i>
                </a>
            </div> --}}

            @if (licenseType(2) && config('settings.subscription.status'))
                <!-- Tax Settings -->
                <div class="col page-search-element">
                    <a href="{{ route('admin.settings.taxes.index') }}" class="premium-card">
                        <div class="card-glow"></div>
                        <div class="premium-card-body">
                            <div class="icon-wrapper bg-soft-info">
                                <i class="bi bi-percent"></i>
                            </div>
                            <div class="content-wrapper">
                                <h6 class="card-title">{{ d_trans('Tax Settings') }}</h6>
                                <p class="card-description">{{ d_trans('Configure and manage tax rates.') }}</p>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right arrow-hint"></i>
                    </a>
                </div>

                <!-- Payment Gateways -->
                <div class="col page-search-element">
                    <a href="{{ route('admin.settings.payment-gateways.index') }}" class="premium-card">
                        <div class="card-glow"></div>
                        <div class="premium-card-body">
                            <div class="icon-wrapper bg-soft-success">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <div class="content-wrapper">
                                <h6 class="card-title">{{ d_trans('Payment Gateways') }}</h6>
                                <p class="card-description">{{ d_trans('Manage payment gateway integrations.') }}</p>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right arrow-hint"></i>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <style>
        :root {
            --card-bg: #ffffff;
            --card-radius: 16px;
            --primary-color: #4361ee;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sys-settings-wrapper {
            padding: 10px 0;
        }

        .premium-card {
            position: relative;
            display: block;
            background: var(--card-bg);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: var(--card-radius);
            padding: 1.5rem;
            text-decoration: none !important;
            overflow: hidden;
            height: 100%;
            transition: var(--transition);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
        }

        .premium-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            border-color: rgba(67, 97, 238, 0.2);
        }

        .premium-card-body {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            position: relative;
            z-index: 2;
        }

        /* Icon Styling */
        .icon-wrapper {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.5rem;
            flex-shrink: 0;
            transition: var(--transition);
        }

        .premium-card:hover .icon-wrapper {
            transform: scale(1.1) rotate(-5deg);
        }

        /* Color Variations */
        .bg-soft-primary {
            background: #eef2ff;
            color: #4361ee;
        }

        .bg-soft-success {
            background: #ecfdf5;
            color: #10b981;
        }

        .bg-soft-info {
            background: #f0f9ff;
            color: #0ea5e9;
        }

        .bg-soft-warning {
            background: #fffbeb;
            color: #f59e0b;
        }

        /* Text Content */
        .card-title {
            color: var(--text-main);
            font-weight: 700;
            margin-bottom: 0.25rem;
            font-size: 1.05rem;
        }

        .card-description {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-bottom: 0;
            line-height: 1.4;
        }

        /* Decorative Arrow */
        .arrow-hint {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%) translateX(10px);
            opacity: 0;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .premium-card:hover .arrow-hint {
            opacity: 1;
            transform: translateY(-50%) translateX(0);
        }

        /* The "Glow" Effect */
        .card-glow {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at top right, rgba(67, 97, 238, 0.05), transparent);
            pointer-events: none;
        }
    </style>
@endsection
