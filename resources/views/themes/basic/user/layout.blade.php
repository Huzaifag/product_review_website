<!DOCTYPE html>
<html lang="{{ getLocale() }}" dir="{{ getDirection() }}">

<head>
    @include('themes.basic.includes.head')
</head>

<body class="bg-custom">
    @include('themes.basic.includes.navbar')
    <header class="header header-sm bg-white border-bottom">
        <div class="container container-custom-xs d-flex flex-column flex-grow-1">
            <div class="header-inner text-lg-start py-4">
                @yield('breadcrumbs')
                <div class="user align-items-center flex-column flex-lg-row text-center text-lg-start gap-4">
                    <div class="user-avatar user-avatar-xl">
                        <img src="{{ $user->getAvatar() }}" alt="{{ $user->getName() }}">
                    </div>
                    <div class="user-info">
                        <h1 class="user-title justify-content-center justify-content-lg-start h4">
                            {{ $user->getName() }}
                            @if ($user->isBanned())
                                <span class="badge bg-danger p-1 ms-1"><i
                                        class="fas fa-user-slash me-1"></i>{{ d_trans('Banned') }}</span>
                            @elseif ($user->hasKycVerified())
                                <i class="bi bi-patch-check-fill verified-icon" data-bs-toggle="tooltip"
                                    data-bs-title="{{ d_trans('Identity Verified') }}"></i>
                            @endif
                        </h1>
                        <div class="meta justify-content-center justify-content-lg-start mt-2">
                            @if ($user->country)
                                <a href="{{ route('businesses.index', ['country' => $user->country]) }}"
                                    class="meta-item">
                                    <i class="bi bi-geo-alt me-2"></i>{{ $user->getCountry() }}
                                </a>
                            @endif
                            <div class="meta-item">
                                <i
                                    class="bi bi-star me-2"></i>{{ translate_choice(':count Review|:count Reviews', $user->total_reviews, ['count' => numberFormat($user->total_reviews)]) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @auth
        @if (authUser()->id == $user->id)
            <section class="section py-2 bg-white border-bottom">
                <div class="section-inner">
                    <div class="container container-custom-xs">
                        <div class="row row-cols-auto g-2">
                            <div class="col">
                                <a href="{{ $user->getProfileLink() }}"
                                    class="custom-tab {{ request()->routeIs('user.profile') ? 'current' : '' }}">
                                    <i class="bi bi-star"></i>
                                    <span>{{ d_trans('Reviews') }}</span>
                                </a>
                            </div>
                            <div class="col">
                                <a href="{{ $user->getSettingsLink() }}"
                                    class="custom-tab {{ request()->routeIs('user.settings.index') ? 'current' : '' }}">
                                    <i class="bi bi-gear"></i>
                                    <span>{{ d_trans('Settings') }}</span>
                                </a>
                            </div>
                            @if (config('settings.kyc.actions.status'))
                                <div class="col">
                                    <a href="{{ $user->getKycLink() }}"
                                        class="custom-tab {{ request()->routeIs('user.kyc.index') ? 'current' : '' }}">
                                        <i class="bi bi-shield-check"></i>
                                        <span>{{ d_trans('KYC Verification') }}</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endauth
    <section class="section py-5">
        <div class="section-inner">
            <div class="container container-custom-xs">
                <div class="section-body">
                    @if (!View::hasSection('hide_alerts'))
                        @auth
                            @if (config('settings.kyc.actions.status') &&
                                    config('settings.user.actions.kyc_required') &&
                                    !authUser()->hasKycVerified())
                                @include('themes.basic.partials.kyc-alerts', [
                                    'kyc_guard' => authUser(),
                                    'kyc_url' => authUser()->getKycLink(),
                                ])
                            @endif
                        @endauth
                    @endif
                    <h4 class="mb-3">@yield('header_title')</h4>
                    @yield('content')
                </div>
            </div>
        </div>
    </section>
    @include('themes.basic.includes.footer')
    @include('themes.basic.includes.scripts')
</body>

</html>
