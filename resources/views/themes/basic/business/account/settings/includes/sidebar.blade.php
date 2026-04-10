<aside class="settings-side">
    <a href="{{ route('business.account.settings.index') }}"
        class="settings-link {{ request()->routeIs('business.account.settings.index') ? 'active' : '' }}">
        <i class="fa fa-edit me-2"></i>{{ d_trans('Account details') }}
    </a>

    <a href="{{ route('business.account.settings.password') }}"
        class="settings-link {{ request()->routeIs('business.account.settings.password') ? 'active' : '' }}">
        <i class="fa fa-refresh me-2"></i>{{ d_trans('Change Password') }}
    </a>
    <a href="{{ route('business.account.settings.2fa') }}"
        class="settings-link {{ request()->routeIs('business.account.settings.2fa') ? 'active' : '' }}">
        <i class="fa-solid fa-shield-halved me-2"></i>{{ d_trans('2FA Authentication') }}
    </a>
    @if (config('settings.kyc.actions.status'))
        <a href="{{ route('business.account.settings.kyc') }}"
            class="settings-link {{ request()->routeIs('business.account.settings.kyc') ? 'active' : '' }}">
            <i class="fa-solid fa-user-check me-2"></i>{{ d_trans('KYC Verification') }}
        </a>
    @endif
</aside>
