@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('title', d_trans('Settings'))
@section('header_title', d_trans('Settings'))
@section('page_search', true)
@section('content')
    <div class="sys-settings">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3">
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.general.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-gear"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('General Settings') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Manage general settings for your website.') }}
                        </p>
                    </div>
                </a>
            </div>
            @if (licenseType(2) && config('settings.subscription.status'))
                <div class="col page-search-element">
                    <a href="{{ route('admin.settings.financial.index') }}" class="box box-system v2">
                        <div class="box-system-icon">
                            <i class="bi bi-bank"></i>
                        </div>
                        <div class="box-system-info">
                            <h6 class="box-system-title">{{ d_trans('Financial Settings') }}</h6>
                            <p class="box-system-text">
                                {{ d_trans('Manage your website financial Settings.') }}
                            </p>
                        </div>
                    </a>
                </div>
            @endif
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.smtp.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-send"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('SMTP Settings') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Configure your email server settings.') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.user.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-person-gear"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('User Settings') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Manage and control the user settings.') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.business.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-briefcase"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('Business Settings') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Manage and control the business settings.') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.kyc.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('KYC Settings') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Manage KYC requirements and settings.') }}
                        </p>
                    </div>
                </a>
            </div>
            @if (licenseType(2))
                <div class="col page-search-element">
                    <a href="{{ route('admin.settings.subscription.index') }}" class="box box-system v2">
                        <div class="box-system-icon">
                            <i class="bi bi-gem"></i>
                        </div>
                        <div class="box-system-info">
                            <h6 class="box-system-title">{{ d_trans('Subscription Settings') }}</h6>
                            <p class="box-system-text">
                                {{ d_trans('Manage your subscription settings.') }}
                            </p>
                        </div>
                    </a>
                </div>
            @endif
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.languages.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-translate"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('Languages') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Manage language for your website.') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.mail-templates.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-envelope-open"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('Mail Templates') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Customize email templates for notifications.') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.themes.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-paint-bucket"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('Themes') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Select and manage your website themes.') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.pages.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('Pages') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Create and manage website pages.') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.oauth-providers.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('OAuth Providers') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Manage OAuth providers for social logins.') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.captcha-providers.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('Captcha Providers') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Set up captcha services to prevent bots.') }}
                        </p>
                    </div>
                </a>
            </div>
            <div class="col page-search-element">
                <a href="{{ route('admin.settings.extensions.index') }}" class="box box-system v2">
                    <div class="box-system-icon">
                        <i class="bi bi-puzzle"></i>
                    </div>
                    <div class="box-system-info">
                        <h6 class="box-system-title">{{ d_trans('Extensions') }}</h6>
                        <p class="box-system-text">
                            {{ d_trans('Install and manage website extensions.') }}
                        </p>
                    </div>
                </a>
            </div>
            @if (licenseType(2) && config('settings.subscription.status'))
                <div class="col page-search-element">
                    <a href="{{ route('admin.settings.taxes.index') }}" class="box box-system v2">
                        <div class="box-system-icon">
                            <i class="bi bi-percent"></i>
                        </div>
                        <div class="box-system-info">
                            <h6 class="box-system-title">{{ d_trans('Tax Settings') }}</h6>
                            <p class="box-system-text">
                                {{ d_trans('Configure and manage tax rates.') }}
                            </p>
                        </div>
                    </a>
                </div>
                <div class="col page-search-element">
                    <a href="{{ route('admin.settings.payment-gateways.index') }}" class="box box-system v2">
                        <div class="box-system-icon">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <div class="box-system-info">
                            <h6 class="box-system-title">{{ d_trans('Payment Gateways') }}</h6>
                            <p class="box-system-text">
                                {{ d_trans('Manage payment gateway integrations.') }}
                            </p>
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
