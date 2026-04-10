<nav class="dashboard-navbar">
    <div class="dashboard-sidebar-toggle navbar-btn">
        <i class="fa fa-bars fa-lg"></i>
    </div>
    <div class="navbar-actions">
        <div class="row row-cols-auto align-items-center g-2 g-sm-3 flex-nowrap">
            <div class="col">
                <a href="{{ route('admin.system.information.cache') }}" class="btn btn-outline-danger action-confirm">
                    <i class="fa-solid fa-broom icon-rtl"></i><span
                        class="d-none d-lg-inline ms-2">{{ d_trans('Clear Cache') }}</span>
                </a>
            </div>
            <div class="col">
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-dark">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i><span
                        class="d-none d-lg-inline ms-2">{{ d_trans('Preview') }}</span>
                </a>
            </div>
            @if (languages()->count() > 1)
                <div class="col">
                    @include('admin.partials.language-menu')
                </div>
            @endif
            <div class="col">
                <div class="notifications drop-down" data-dropdown>
                    <div class="notifications-title drop-down-title navbar-btn">
                        <i class="fa-{{ $navbarNotifications['unread'] ? 'solid' : 'regular' }} fa-bell"></i>
                        @if ($navbarNotifications['unread'])
                            <div class="counter flash-hit">
                                {{ $navbarNotifications['unread'] > 9 ? '+9' : $navbarNotifications['unread'] }}</div>
                        @endif
                    </div>
                    <div class="notifications-menu drop-down-menu py-0">
                        <div class="notifications-header">
                            <p class="notifications-header-title mb-0">
                                {{ d_trans('Notifications (:count)', ['count' => $navbarNotifications['unread']]) }}
                            </p>
                            @if ($navbarNotifications['unread'] > 0)
                                <div class="ms-auto">
                                    <form action="{{ route('admin.notifications.read.all') }}" method="POST">
                                        @csrf
                                        <button
                                            class="notifications-header-button p-0 action-confirm">{{ d_trans('Mark All as Read') }}</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="notifications-body" data-simplebar>
                            @forelse ($navbarNotifications['list'] as $navbarNotification)
                                @if ($navbarNotification->link)
                                    <a class="notification {{ !$navbarNotification->status ? 'unread' : '' }}"
                                        href="{{ route('admin.notifications.view', $navbarNotification->id) }}">
                                        <div class="notification-icon">
                                            <img src="{{ $navbarNotification->image }}"
                                                alt="{{ $navbarNotification->title }}">
                                        </div>
                                        <div class="notification-info">
                                            <p class="notification-title mb-0">{{ $navbarNotification->title }}</p>
                                            <p class="notification-text mb-0">
                                                {{ $navbarNotification->created_at->diffforhumans() }}</p>
                                        </div>
                                    </a>
                                @else
                                    <div class="notification {{ !$navbarNotification->status ? 'unread' : '' }}">
                                        <div class="notification-icon">
                                            <img src="{{ $navbarNotification->image }}"
                                                alt="{{ $navbarNotification->title }}">
                                        </div>
                                        <div class="notification-info">
                                            <p class="notification-title mb-0">{{ $navbarNotification->title }}</p>
                                            <p class="notification-text mb-0">
                                                {{ $navbarNotification->created_at->diffforhumans() }}</p>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="text-center py-5">
                                    <small class="text-muted mb-0">{{ d_trans('No notifications found') }}</small>
                                </div>
                            @endforelse
                        </div>
                        <a href="{{ route('admin.notifications.index') }}"
                            class="notifications-footer">{{ d_trans('View All') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="drop-down user-menu" data-dropdown>
            <div class="drop-down-title user">
                <div class="user-avatar">
                    <img src="{{ authAdmin()->getAvatar() }}" alt="{{ authAdmin()->getName() }}" />
                </div>
                <div class="user-info d-none d-md-block">
                    <p class="user-title mb-0">{{ shorterText(authAdmin()->getName(), 20) }}</p>
                    <p class="user-text mb-0">{{ shorterText(authAdmin()->email, 20) }}</p>
                </div>
            </div>
            <div class="drop-down-menu">
                <a class="drop-down-item" href="{{ route('admin.account.settings.index') }}">
                    <i class="bi bi-gear"></i>{{ d_trans('Settings') }}
                </a>
                <a class="drop-down-item text-danger" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-left"></i>{{ d_trans('Logout') }}
                </a>
            </div>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                @csrf
            </form>
        </div>
    </div>
</nav>
