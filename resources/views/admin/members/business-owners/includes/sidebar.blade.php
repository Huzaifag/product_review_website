<aside class="settings-side">
    <a href="{{ route('admin.members.business-owners.edit', $owner->id) }}"
        class="settings-link {{ request()->routeIs('admin.members.business-owners.edit') ? 'active' : '' }}">
        <span>{{ d_trans('Account details') }}</span>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
    <a href="{{ route('admin.members.business-owners.password.index', $owner->id) }}"
        class="settings-link {{ request()->routeIs('admin.members.business-owners.password.index') ? 'active' : '' }}">
        <span>{{ d_trans('Change password') }}</span>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
    <a href="{{ route('admin.members.business-owners.logs.index', $owner->id) }}"
        class="settings-link {{ request()->routeIs('admin.members.business-owners.logs.index') ? 'active' : '' }}">
        <span>{{ d_trans('Login logs') }}</span>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
    <a href="{{ route('admin.members.business-owners.sendmail.index', $owner->id) }}"
        class="settings-link {{ request()->routeIs('admin.members.business-owners.sendmail.index') ? 'active' : '' }}">
        <span>{{ d_trans('Send mail') }}</span>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
    <a href="{{ route('admin.members.business-owners.actions.index', $owner->id) }}"
        class="settings-link {{ request()->routeIs('admin.members.business-owners.actions.index') ? 'active' : '' }}">
        <span>{{ d_trans('Actions') }}</span>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
</aside>
