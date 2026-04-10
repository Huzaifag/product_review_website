<div class="dashboard-tabs">
    <a href="{{ route('admin.categories.index') }}" class="dashboard-tabs-item {{ $active == 'main' ? 'current' : '' }}">
        <i class="fa-solid fa-tags"></i><span class="ms-2">{{ d_trans('Main Categories') }}</span>
    </a>
    <a href="{{ route('admin.categories.sub-categories.index') }}"
        class="dashboard-tabs-item {{ $active == 'sub' ? 'current' : '' }}">
        <i class="fa-solid fa-tags"></i><span class="ms-2">{{ d_trans('Sub Categories') }}</span>
    </a>
    <a href="{{ route('admin.categories.sub-sub-categories.index') }}"
        class="dashboard-tabs-item {{ $active == 'sub_sub' ? 'current' : '' }}">
        <i class="fa-solid fa-tags"></i><span class="ms-2">{{ d_trans('Sub Sub Categories') }}</span>
    </a>
</div>
