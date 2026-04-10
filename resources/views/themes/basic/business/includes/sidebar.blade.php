<aside class="dashboard-sidebar">
    <div class="overlay"></div>
    <div class="dashboard-sidebar-header">
        <a href="{{ route('business.index') }}" class="logo logo-xl">
            <img src="{{ asset(config('theme.settings.general.business_logo_light')) }}"
                alt="{{ m_trans(config('settings.general.site_name')) }}">
        </a>
    </div>
    <div class="dashboard-sidebar-inner" data-simplebar>
        <div class="dashboard-sidebar-content">
            <div class="dashboard-sidebar-body">
                @if ($sidebarBusinesses->count() > 1)
                    <div class="drop-down drop-down-scroll dashboard-sidebar-selective mb-3" data-dropdown>
                        <div class="drop-down-btn">
                            <div class="item-xs d-flex align-items-center gap-2 overflow-hidden py-2">
                                <div class="item-img flex-shrink-0">
                                    <img src="{{ $currentBusiness->getLogoLink() }}"
                                        alt="{{ $currentBusiness->trans->name }}">
                                </div>
                                <div class="item-info">
                                    <h6 class="item-title text-truncate">{{ $currentBusiness->trans->name }}</h6>
                                    <p class="item-meta small mb-0">
                                        {{ translate_choice(':count Review|:count Reviews', $currentBusiness->total_reviews, ['count' => numberFormat($currentBusiness->total_reviews)]) }}
                                    </p>
                                </div>
                            </div>
                            <i class="bi bi-chevron-down"></i>
                        </div>
                        <div class="drop-down-menu">
                            @foreach ($sidebarBusinesses as $sidebarBusiness)
                                <a href="{{ route('business.current', $sidebarBusiness->id) }}"
                                    class="drop-down-item {{ $sidebarBusiness->id == $currentBusiness->id ? 'active' : '' }} p-2">
                                    <div class="item-xs d-flex align-items-center gap-2 overflow-hidden">
                                        <div class="item-img flex-shrink-0">
                                            <img src="{{ $sidebarBusiness->getLogoLink() }}"
                                                alt="{{ $sidebarBusiness->trans->name }}">
                                        </div>
                                        <div class="item-info">
                                            <h6 class="item-title text-truncate">{{ $sidebarBusiness->trans->name }}
                                            </h6>
                                            <p class="item-meta text-muted mb-0">
                                                {{ translate_choice(':count Review|:count Reviews', $sidebarBusiness->total_reviews, ['count' => numberFormat($sidebarBusiness->total_reviews)]) }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="dashboard-sidebar-links">
                    <div class="dashboard-sidebar-link {{ currentLink('dashboard', 2) }}">
                        <a href="{{ route('business.dashboard') }}" class="dashboard-sidebar-link-title">
                            <i class="bi bi-grid"></i>
                            <span>{{ d_trans('Dashboard') }}</span>
                        </a>
                    </div>
                    <div class="dashboard-sidebar-link {{ currentLink('reviews', 2) }}">
                        <a href="{{ route('business.reviews.index') }}" class="dashboard-sidebar-link-title">
                            <i class="bi bi-star"></i>
                            <span>{{ d_trans('Reviews') }}</span>
                        </a>
                    </div>
                    @if (authBusinessOwner()->isAdminOfCurrentBusiness())
                        @if ($currentBusiness->hasFeature('employees'))
                            <div class="dashboard-sidebar-link {{ currentLink('employees', 2) }}">
                                <a href="{{ route('business.employees.index') }}" class="dashboard-sidebar-link-title">
                                    <i class="bi bi-people"></i>
                                    <span>{{ d_trans('Employees') }}</span>
                                </a>
                            </div>
                        @endif
                        @if ($currentBusiness->hasFeature('categories'))
                            <div class="dashboard-sidebar-link {{ currentLink('categories', 2) }}">
                                <a href="{{ route('business.categories.index') }}"
                                    class="dashboard-sidebar-link-title">
                                    <i class="bi bi-tags"></i>
                                    <span>{{ d_trans('Categories') }}</span>
                                </a>
                            </div>
                        @endif
                        <div class="dashboard-sidebar-link {{ currentLink('integration', 2) }}">
                            <a href="{{ route('business.integration') }}" class="dashboard-sidebar-link-title">
                                <i class="bi bi-code-slash"></i>
                                <span>{{ d_trans('Integration') }}</span>
                            </a>
                        </div>
                        <div class="dashboard-sidebar-link {{ currentLink('settings', 2) }}">
                            <a href="{{ route('business.settings.index') }}" class="dashboard-sidebar-link-title">
                                <i class="bi bi-gear"></i>
                                <span>{{ d_trans('Settings') }}</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="dashboard-sidebar-footer">
                @if (authBusinessOwner()->canCreateBusiness())
                    <button class="btn btn-outline-primary btn-md w-100" data-bs-toggle="modal"
                        data-bs-target="#addBusinessModal"><i
                            class="fa fa-plus me-2"></i>{{ d_trans('Add Business') }}</button>
                @endif
                @if (licenseType(2) && config('settings.subscription.status') && !authBusinessOwner()->isSubscribed())
                    <a href="{{ route('business.subscription.plans.index') }}"
                        class="btn btn-primary btn-md w-100 mt-3"><i
                            class="fa-regular fa-gem me-2"></i>{{ d_trans('Upgrade') }}</a>
                @endif
            </div>

        </div>
    </div>
</aside>
