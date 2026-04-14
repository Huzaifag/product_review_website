<div class="nav-bar nav-bar-bg">
    <div class="container container-custom">
        <div class="nav-bar-container">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ asset(config('theme.settings.general.logo_light')) }}"
                    alt="{{ m_trans(config('settings.general.site_name')) }}" />
            </a>
            <div class="nav-bar-menu">
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
                            <span class="user-name ms-2">{{ authUser()->getName() }}</span>
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
                <div class="nav-bar-menu-btn ms-3 gradient-icon">
                    <i class="fa-solid fa-bars fa-lg"></i>
                </div>
            </div>
        </div>
    </div>
</div>
