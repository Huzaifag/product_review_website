@php
    $languages = languages();
@endphp
@if ($languages->count() > 1)
    @php
        $currentLanguage = languages(getLocale());
    @endphp
    @if (isset($version) && $version == 'v2')
        <div class="dropdown language {{ $languageClasses ?? '' }}">
            <button class="btn btn-soft dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="flag-img" src="{{ $currentLanguage->getLogoLink() }}"
                    alt="{{ $currentLanguage->trans->name }}">
                <span class="small ms-1 fw-medium d-inline d-lg-none">{{ $currentLanguage->trans->code }}</span>
                <span class="small ms-1 fw-medium d-none d-lg-inline">{{ $currentLanguage->trans->name }}</span>
                <i class="bi bi-chevron-down ms-1 d-none d-lg-inline"></i>
            </button>
            <ul class="dropdown-menu">
                @foreach ($languages as $navLanguage)
                    <a href="{{ $navLanguage->getLocalizeUrl() }}"
                        class="dropdown-item {{ $navLanguage->code == getLocale() ? 'active' : '' }}">
                        <img class="flag-img me-2" src="{{ $navLanguage->getLogoLink() }}">
                        <span>{{ $navLanguage->trans->name }}</span>
                    </a>
                @endforeach
            </ul>
        </div>
    @else
        <div class="drop-down language {{ $languageClasses ?? '' }}" data-dropdown>
            <div class="drop-down-title btn">
                <img class="flag-img" src="{{ $currentLanguage->getLogoLink() }}"
                    alt="{{ $currentLanguage->trans->name }}">
                <span class="small ms-1 fw-medium d-inline d-lg-none">{{ $currentLanguage->trans->code }}</span>
                <span class="small ms-1 fw-medium d-none d-lg-inline">{{ $currentLanguage->trans->name }}</span>
                <i class="bi bi-chevron-down ms-1 d-none d-lg-inline"></i>
            </div>
            <div class="drop-down-menu">
                @foreach ($languages as $navLanguage)
                    <a href="{{ $navLanguage->getLocalizeUrl() }}"
                        class="drop-down-item d-flex align-items-center {{ $navLanguage->code == getLocale() ? 'active' : '' }}">
                        <img class="flag-img me-2" src="{{ $navLanguage->getLogoLink() }}">
                        <span>{{ $navLanguage->trans->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
@endif
