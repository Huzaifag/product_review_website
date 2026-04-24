<style>
    /* --- Premium Navbar Styles --- */
    :root {
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(226, 232, 240, 0.6);
        --shadow-sm: 0 2px 10px rgba(0, 0, 0, 0.02);
        --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.08);
        --shadow-hover: 0 10px 25px rgba(0, 0, 0, 0.12);
        --transition-snappy: all 0.25s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .dashboard-navbar-premium {
        background: var(--glass-bg);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-bottom: 1px solid var(--glass-border);
        box-shadow: var(--shadow-sm);
        padding: 0.875rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 1020;
    }

    /* Action Buttons */
    .btn-premium {
        border-radius: 50rem;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        font-size: 0.875rem;
        letter-spacing: 0.3px;
        transition: var(--transition-snappy);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid transparent;
    }

    .btn-premium-danger {
        background-color: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.2);
    }

    .btn-premium-danger:hover {
        background-color: #ef4444;
        color: #fff;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
    }

    .btn-premium-dark {
        background-color: #f1f5f9;
        color: #334155;
        border-color: #e2e8f0;
    }

    .btn-premium-dark:hover {
        background-color: #1e293b;
        color: #fff;
        border-color: #1e293b;
        box-shadow: 0 4px 15px rgba(30, 41, 59, 0.2);
    }

    /* Icon Buttons (Sidebar toggle & Notifications) */
    .icon-btn-premium {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f8fafc;
        border: 1px solid var(--glass-border);
        color: #475569;
        cursor: pointer;
        transition: var(--transition-snappy);
        position: relative;
    }

    .icon-btn-premium:hover {
        background: #fff;
        color: #0f172a;
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }

    /* Notification Badge */
    .counter-premium {
        position: absolute;
        top: -2px;
        right: -2px;
        background: #ef4444;
        color: white;
        font-size: 0.65rem;
        font-weight: 700;
        height: 20px;
        min-width: 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #fff;
        box-shadow: 0 2px 5px rgba(239, 68, 68, 0.4);
    }

    /* User Menu */
    .user-menu-premium {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding-left: 1.25rem;
        border-left: 1px solid #e2e8f0;
        cursor: pointer;
    }

    .user-avatar-premium img {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #fff;
        box-shadow: var(--shadow-sm);
        transition: var(--transition-snappy);
    }

    .user-menu-premium:hover .user-avatar-premium img {
        box-shadow: var(--shadow-hover);
    }

    .user-info-premium .user-name {
        font-weight: 600;
        color: #0f172a;
        font-size: 0.9rem;
    }

    .user-info-premium .user-role {
        font-size: 0.75rem;
        color: #64748b;
    }

    /* Dropdowns */
    .dropdown-menu-premium {
        border: 1px solid var(--glass-border);
        box-shadow: var(--shadow-md);
        border-radius: 12px;
        overflow: hidden;
        padding: 0.5rem 0;
        min-width: 240px;
    }
    
    .dropdown-item-premium {
        padding: 0.6rem 1.25rem;
        font-size: 0.875rem;
        color: #334155;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .dropdown-item-premium:hover {
        background: #f8fafc;
        color: #0f172a;
        padding-left: 1.5rem; /* Slide effect on hover */
    }

    /* Notification Dropdown Specifics */
    .notifications-dropdown-premium {
        width: 340px;
    }

    .notifications-header-premium {
        padding: 1rem 1.25rem;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .notification-item-premium {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        gap: 1rem;
        transition: background 0.2s;
    }

    .notification-item-premium:hover {
        background: #f8fafc;
    }

    .notification-item-premium.unread {
        background: #f0fdf4; /* Subtle green/blue tint for unread */
    }

    .notification-item-premium img {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        object-fit: cover;
    }
</style>

<nav class="dashboard-navbar-premium w-100">
    <div class="dashboard-sidebar-toggle icon-btn-premium">
        <i class="fa fa-bars fa-lg"></i>
    </div>

    <div class="navbar-actions d-flex align-items-center gap-3">
        
        <div class="d-none d-md-flex gap-2">
            <a href="{{ route('admin.system.information.cache') }}" class="btn-premium btn-premium-danger action-confirm">
                <i class="fa-solid fa-broom"></i>
                <span>{{ d_trans('Clear Cache') }}</span>
            </a>
            
            <a href="{{ route('home') }}" target="_blank" class="btn-premium btn-premium-dark">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                <span>{{ d_trans('Preview') }}</span>
            </a>
        </div>

        @if (languages()->count() > 1)
            <div class="language-switcher">
                @include('admin.partials.language-menu')
            </div>
        @endif

        <div class="notifications drop-down" data-dropdown>
            <div class="icon-btn-premium drop-down-title">
                <i class="fa-{{ $navbarNotifications['unread'] ? 'solid text-primary' : 'regular' }} fa-bell"></i>
                @if ($navbarNotifications['unread'])
                    <div class="counter-premium flash-hit">
                        {{ $navbarNotifications['unread'] > 9 ? '+9' : $navbarNotifications['unread'] }}
                    </div>
                @endif
            </div>

            <div class="dropdown-menu-premium notifications-dropdown-premium drop-down-menu py-0">
                <div class="notifications-header-premium">
                    <p class="mb-0 fw-bold text-dark">
                        {{ d_trans('Notifications (:count)', ['count' => $navbarNotifications['unread']]) }}
                    </p>
                    @if ($navbarNotifications['unread'] > 0)
                        <form action="{{ route('admin.notifications.read.all') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-link text-primary p-0 text-decoration-none small fw-semibold action-confirm">
                                {{ d_trans('Mark All as Read') }}
                            </button>
                        </form>
                    @endif
                </div>

                <div class="notifications-body" data-simplebar style="max-height: 300px; overflow-y: auto;">
                    @forelse ($navbarNotifications['list'] as $navbarNotification)
                        @php $isUnread = !$navbarNotification->status ? 'unread' : ''; @endphp
                        
                        @if ($navbarNotification->link)
                            <a class="notification-item-premium text-decoration-none {{ $isUnread }}" href="{{ route('admin.notifications.view', $navbarNotification->id) }}">
                        @else
                            <div class="notification-item-premium {{ $isUnread }}">
                        @endif
                            
                            <img src="{{ $navbarNotification->image }}" alt="Icon" class="flex-shrink-0">
                            <div class="notification-info">
                                <p class="mb-1 text-dark fw-semibold small lh-sm">{{ $navbarNotification->title }}</p>
                                <p class="mb-0 text-muted small" style="font-size: 0.75rem;">
                                    <i class="fa-regular fa-clock me-1"></i>{{ $navbarNotification->created_at->diffforhumans() }}
                                </p>
                            </div>

                        @if ($navbarNotification->link) </a> @else </div> @endif
                    @empty
                        <div class="text-center py-5">
                            <div class="text-muted mb-2"><i class="fa-regular fa-bell-slash fa-2x"></i></div>
                            <small class="text-muted fw-medium">{{ d_trans('No notifications found') }}</small>
                        </div>
                    @endforelse
                </div>
                
                <a href="{{ route('admin.notifications.index') }}" class="d-block text-center py-2 bg-light text-decoration-none text-primary fw-bold small border-top">
                    {{ d_trans('View All Notifications') }}
                </a>
            </div>
        </div>

        <div class="drop-down" data-dropdown>
            <div class="user-menu-premium drop-down-title">
                <div class="user-info-premium d-none d-md-block text-end">
                    <p class="user-name mb-0">{{ shorterText(authAdmin()->getName(), 20) }}</p>
                    <p class="user-role mb-0">{{ shorterText(authAdmin()->email, 20) }}</p>
                </div>
                <div class="user-avatar-premium">
                    <img src="{{ authAdmin()->getAvatar() }}" alt="{{ authAdmin()->getName() }}" />
                </div>
            </div>

            <div class="dropdown-menu-premium drop-down-menu mt-2">
                <a class="dropdown-item-premium text-decoration-none" href="{{ route('admin.account.settings.index') }}">
                    <i class="bi bi-gear text-secondary"></i> {{ d_trans('Settings') }}
                </a>
                <div class="dropdown-divider my-1 border-light"></div>
                <a class="dropdown-item-premium text-danger text-decoration-none" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-left"></i> {{ d_trans('Logout') }}
                </a>
            </div>

            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
        
    </div>
</nav>