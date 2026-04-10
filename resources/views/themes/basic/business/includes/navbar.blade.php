<nav class="dashboard-nav">
    <div class="dashboard-nav-btn dashboard-btn dashboard-toggle-btn">
        <i class="fa fa-bars"></i>
    </div>
    <a href="{{ route('business.index') }}" class="logo logo-xl logo-toggle ms-3">
        <img src="{{ asset(config('theme.settings.general.business_logo_dark')) }}"
            alt="{{ m_trans(config('settings.general.site_name')) }}">
    </a>
    <div class="d-flex align-items-center gap-3 ms-auto">
        <a href="{{ $currentBusiness->getLink() }}" target="_blank" class="dashboard-nav-btn dashboard-btn">
            <i class="fas fa-external-link-alt icon-rtl"></i>
        </a>
        @include('themes.basic.partials.language-menu', [
            'language_classes' => 'dashboard-nav-btn dashboard-btn',
            'language_simple' => true,
        ])
        <div class="drop-down drop-down-lg" data-dropdown>
            <div class="drop-down-btn nav-btn noti-btn dashboard-nav-btn dashboard-btn">
                <i class="fa-{{ $navbarNotifications['unread'] ? 'solid' : 'regular' }} fa-bell"></i>
                @if ($navbarNotifications['unread'])
                    <div class="noti-counter">
                        {{ $navbarNotifications['unread'] > 9 ? '+9' : $navbarNotifications['unread'] }}</div>
                @endif
            </div>
            <div class="drop-down-menu p-0">
                <div class="noti">
                    <div class="noti-header">
                        <h6 class="mb-0">
                            {{ d_trans('Notifications (:count)', ['count' => $navbarNotifications['unread']]) }}</h6>
                        @if ($navbarNotifications['unread'] > 0)
                            <div class="ms-auto">
                                <form action="{{ route('business.notifications.read.all') }}" method="POST">
                                    @csrf
                                    <button class="action-confirm">{{ d_trans('Mark All as Read') }}</button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <div class="noti-body" data-simplebar>
                        <div class="d-flex flex-column">
                            @forelse ($navbarNotifications['list'] as $navbarNotification)
                                @if ($navbarNotification->link)
                                    <a href="{{ route('business.notifications.view', $navbarNotification->id) }}"
                                        class="noti-item {{ !$navbarNotification->status ? 'unread' : '' }}">
                                        <div class="noti-item-img">
                                            <img src="{{ $navbarNotification->image }}"
                                                alt="{{ $navbarNotification->title }}" />
                                        </div>
                                        <div class="noti-item-info">
                                            <p class="noti-item-text mb-0">{{ $navbarNotification->title }}</p>
                                            <span
                                                class="noti-item-time">{{ $navbarNotification->created_at->diffforhumans() }}</span>
                                        </div>
                                    </a>
                                @else
                                    <div class="noti-item {{ !$navbarNotification->status ? 'unread' : '' }}">
                                        <div class="noti-item-img">
                                            <img src="{{ $navbarNotification->image }}"
                                                alt="{{ $navbarNotification->title }}" />
                                        </div>
                                        <div class="noti-item-info">
                                            <p class="noti-item-text mb-0">{{ $navbarNotification->title }}</p>
                                            <span
                                                class="noti-item-time">{{ $navbarNotification->created_at->diffforhumans() }}</span>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="text-center py-5">
                                    <small class="text-muted mb-0">{{ d_trans('No notifications found') }}</small>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="noti-footer">
                        <a
                            href="{{ route('business.notifications.index') }}">{{ d_trans('View All Notifications') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="drop-down drop-down-md user-menu" data-dropdown>
            <div class="drop-down-btn">
                <img src="{{ authBusinessOwner()->getAvatar() }}" alt="{{ authBusinessOwner()->getName() }}"
                    class="user-img me-0">
                <span class="user-name ms-2">{{ authBusinessOwner()->getName() }}</span>
                <i class="fa fa-angle-down ms-2"></i>
            </div>
            <div class="drop-down-menu">
                <a href="{{ route('business.account.settings.index') }}" class="drop-down-item">
                    <i class="bi bi-gear"></i>{{ d_trans('Account Settings') }}
                </a>
                @if (licenseType(2) && config('settings.subscription.status'))
                    <a href="{{ route('business.subscription.index') }}" class="drop-down-item">
                        <i class="bi bi-gem"></i>{{ d_trans('Subscription') }}
                    </a>
                @endif
                <a href="#" class="drop-down-item text-danger"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off"></i>{{ d_trans('Logout') }}
                </a>
            </div>
            <form id="logout-form" class="d-inline" action="{{ route('business.logout') }}" method="POST">
                @csrf
            </form>
        </div>
    </div>
</nav>
