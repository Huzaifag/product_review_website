<div class="nav-bar nav-bar-bg">
    <div class="container container-custom">
        <div class="nav-bar-container">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset(config('theme.settings.general.logo_light')) }}"
                    alt="{{ m_trans(config('settings.general.site_name')) }}" />
            </a>
            <div class="nav-bar-menu desktop-nav">
                <div class="overlay"></div>
                <div class="nav-bar-menu-inner">
                    <div class="nav-bar-menu-header">
                        <button class="btn btn-reset nav-bar-menu-close ms-auto">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                    <div class="nav-bar-links">
                        
                        @foreach ($navbarLinks as $navbarLink)
                            @if ($navbarLink->children->count() > 0)
                                <div class="drop-down" data-dropdown>
                                    <div class="drop-down-btn">
                                        <span class="me-2">{{ $navbarLink->name }}</span>
                                        <i class="bi bi-chevron-down ms-auto"></i>
                                    </div>
                                    <div class="drop-down-menu">
                                        @foreach ($navbarLink->children as $child)
                                            <a href="{{ $child->link }}"
                                                {{ $child->isExternal() ? 'target=_blank' : '' }}
                                                class="drop-down-item">
                                                <span>{{ $child->name }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ $navbarLink->link }}" {{ $navbarLink->isExternal() ? 'target=_blank' : '' }}
                                    class="link {{ request()->url() == $navbarLink->link ? 'active' : '' }}">
                                    <div class="link-title">
                                        <span>{{ $navbarLink->name }}</span>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                        @include('themes.basic.partials.language-menu')
                    </div>
                    <div class="nav-bar-buttons">
                        @guest
                            <a href="{{ route('login') }}" class="link-btn">
                                <button class="btn btn-outline-primary px-3">
                                    <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>{{ d_trans('Sign In') }}
                                </button>
                            </a>
                            @if (config('settings.user.actions.registration'))
                                <a href="{{ route('register') }}" class="link-btn">
                                    <button class="btn btn-signup px-3">
                                        <i class="fa-solid fa-user-plus me-2"></i>{{ d_trans('Sign Up') }}
                                    </button>
                                </a>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
            <div class="nav-bar-actions">
                @auth
                    <div class="drop-down user-menu ms-3" data-dropdown data-dropdown-position="top">
                        <div class="drop-down-btn">
                            <img src="{{ authUser()->getAvatar() }}" alt="{{ authUser()->getName() }}" class="user-img">
                            <span class="user-name ms-2 text-dark">{{ authUser()->getName() }}</span>
                            <i class="fa fa-angle-down ms-2"></i>
                        </div>
                        <div class="drop-down-menu">
                            <a href="{{ authUser()->getProfileLink() }}" class="drop-down-item">
                                <i class="fa fa-user"></i>{{ d_trans('Profile') }}
                            </a>
                            <a href="{{ authUser()->getSettingsLink() }}" class="drop-down-item">
                                <i class="fa fa-cog"></i>{{ d_trans('Settings') }}
                            </a>
                            <a href="#" class="drop-down-item text-danger"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off"></i>{{ d_trans('Logout') }}
                            </a>
                        </div>
                    </div>
                    <form id="logout-form" class="d-inline" action="{{ route('logout') }}" method="POST">
                        @csrf
                    </form>
                @endauth
                <button class="btn btn-reset nav-bar-menu-btn mobile-nav-toggle ms-3 gradient-icon"
                    type="button" aria-label="Open menu">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="mobile-nav" aria-hidden="true">
    <div class="mobile-nav-overlay" data-mobile-nav-close></div>
    <div class="mobile-nav-panel" role="dialog" aria-modal="true" aria-label="Site menu">
        <div class="mobile-nav-header">
            <a href="{{ route('home') }}" class="logo logo-sm">
                <img src="{{ asset(config('theme.settings.general.logo_light')) }}"
                    alt="{{ m_trans(config('settings.general.site_name')) }}" />
            </a>
            <button class="btn btn-reset mobile-nav-close" type="button" data-mobile-nav-close
                aria-label="Close menu">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <nav class="mobile-nav-links">
            @foreach ($navbarLinks as $navbarLink)
                @if ($navbarLink->children->count() > 0)
                    <details class="mobile-nav-group">
                        <summary class="mobile-nav-link">
                            <span>{{ $navbarLink->name }}</span>
                            <i class="bi bi-chevron-down"></i>
                        </summary>
                        <div class="mobile-nav-children">
                            @foreach ($navbarLink->children as $child)
                                <a href="{{ $child->link }}" {{ $child->isExternal() ? 'target=_blank' : '' }}>
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    </details>
                @else
                    <a href="{{ $navbarLink->link }}" {{ $navbarLink->isExternal() ? 'target=_blank' : '' }}
                        class="mobile-nav-link">
                        {{ $navbarLink->name }}
                    </a>
                @endif
            @endforeach
            <div class="mobile-nav-language">
                @include('themes.basic.partials.language-menu', ['language_simple' => true])
            </div>
        </nav>
        <div class="mobile-nav-actions">
            @guest
                <a href="{{ route('login') }}" class="mobile-nav-action">
                    <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>{{ d_trans('Sign In') }}
                </a>
                @if (config('settings.user.actions.registration'))
                    <a href="{{ route('register') }}" class="mobile-nav-action">
                        <i class="fa-solid fa-user-plus me-2"></i>{{ d_trans('Sign Up') }}
                    </a>
                @endif
            @endguest
            @auth
                <a href="{{ authUser()->getProfileLink() }}" class="mobile-nav-action">
                    <i class="fa fa-user me-2"></i>{{ d_trans('Profile') }}
                </a>
                <a href="{{ authUser()->getSettingsLink() }}" class="mobile-nav-action">
                    <i class="fa fa-cog me-2"></i>{{ d_trans('Settings') }}
                </a>
                <a href="#" class="mobile-nav-action text-danger"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off me-2"></i>{{ d_trans('Logout') }}
                </a>
            @endauth
        </div>
    </div>
</div>
