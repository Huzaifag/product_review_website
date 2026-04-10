@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="{{ asset(config('theme.settings.general.logo_dark')) }}" class="logo"
                alt="{{ m_trans(config('settings.general.site_name')) }}">
        </a>
    </td>
</tr>
