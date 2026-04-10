<div class="dashboard-tabs">
    <a href="{{ route('admin.businesses.show', $business->id) }}"
        class="dashboard-tabs-item fs-6 {{ request()->routeIs('admin.businesses.show') ? 'current' : '' }}">
        <i class="bi bi-info-circle"></i><span class="ms-2">{{ d_trans('Details') }}</span>
    </a>
    @if ($business->hasOwner())
        <a href="{{ route('admin.businesses.categories', $business->id) }}"
            class="dashboard-tabs-item fs-6 {{ request()->routeIs('admin.businesses.categories') ? 'current' : '' }}">
            <i class="bi bi-tags"></i><span class="ms-2">{{ d_trans('Categories') }}</span>
        </a>
        <a href="{{ route('admin.businesses.employees', $business->id) }}"
            class="dashboard-tabs-item fs-6 {{ request()->routeIs('admin.businesses.employees') ? 'current' : '' }}">
            <i class="bi bi-people"></i><span class="ms-2">{{ d_trans('Employees') }}</span>
        </a>
    @endif
    <a href="{{ route('admin.businesses.reviews', $business->id) }}"
        class="dashboard-tabs-item fs-6 {{ request()->routeIs('admin.businesses.reviews') ? 'current' : '' }}">
        <i class="bi bi-star"></i><span class="ms-2">{{ d_trans('Reviews') }}</span>
    </a>
    <a href="{{ route('admin.businesses.statistics', $business->id) }}"
        class="dashboard-tabs-item fs-6 {{ request()->routeIs('admin.businesses.statistics') ? 'current' : '' }}">
        <i class="bi bi-bar-chart"></i><span class="ms-2">{{ d_trans('Statistics') }}</span>
    </a>
</div>
