<aside class="settings-side">
    <a href="{{ route('admin.members.users.edit', $user->id) }}"
        class="settings-link {{ request()->routeIs('admin.members.users.edit') ? 'active' : '' }}">
        <span>{{ d_trans('Account details') }}</span>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
    <a href="{{ route('admin.members.users.password.index', $user->id) }}"
        class="settings-link {{ request()->routeIs('admin.members.users.password.index') ? 'active' : '' }}">
        <span>{{ d_trans('Change password') }}</span>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
    <a href="{{ route('admin.members.users.logs.index', $user->id) }}"
        class="settings-link {{ request()->routeIs('admin.members.users.logs.index') ? 'active' : '' }}">
        <span>{{ d_trans('Login logs') }}</span>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
    <a href="{{ route('admin.members.users.sendmail.index', $user->id) }}"
        class="settings-link {{ request()->routeIs('admin.members.users.sendmail.index') ? 'active' : '' }}">
        <span>{{ d_trans('Send mail') }}</span>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
    <a href="{{ route('admin.members.users.actions.index', $user->id) }}"
        class="settings-link {{ request()->routeIs('admin.members.users.actions.index') ? 'active' : '' }}">
        <span>{{ d_trans('Actions') }}</span>
        <i class="fa-solid fa-chevron-right"></i>
    </a>
</aside>
