<aside class="settings-side">
    <a href="{{ route('admin.members.admins.edit', $admin->id) }}"
        class="settings-link {{ request()->routeIs('admin.members.admins.edit') ? 'active' : '' }}">
        <span>{{ d_trans('Account details') }}</span>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
    <a href="{{ route('admin.members.admins.password.index', $admin->id) }}"
        class="settings-link {{ request()->routeIs('admin.members.admins.password.index') ? 'active' : '' }}">
        <span>{{ d_trans('Change password') }}</span>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
    <a href="{{ route('admin.members.admins.sendmail.index', $admin->id) }}"
        class="settings-link {{ request()->routeIs('admin.members.admins.sendmail.index') ? 'active' : '' }}">
        <span>{{ d_trans('Send mail') }}</span>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
    <a href="{{ route('admin.members.admins.actions.index', $admin->id) }}"
        class="settings-link {{ request()->routeIs('admin.members.admins.actions.index') ? 'active' : '' }}">
        <span>{{ d_trans('Actions') }}</span>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
</aside>
