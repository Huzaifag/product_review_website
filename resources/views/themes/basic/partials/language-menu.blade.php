@php
    $languages = languages();
@endphp
@if ($languages->count() > 1)
    @php
        $currentLanguage = languages(getLocale());
    @endphp
    <div class="drop-down languages" data-dropdown>
        <div class="drop-down-btn {{ $language_classes ?? '' }}">
            <div class="language-img {{ isset($language_simple) ? 'me-0' : '' }}">
                <img src="{{ $currentLanguage->getLogoLink() }}" alt="{{ $currentLanguage->trans->name }}">
            </div>
            @if (!isset($language_simple))
                <span class="me-2">{{ $currentLanguage->trans->name }}</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            @endif
        </div>
        <div class="drop-down-menu">
            @foreach ($languages as $language)
                <a href="{{ $language->getLocalizeUrl() }}"
                    class="drop-down-item {{ $language->code == getLocale() ? 'active' : '' }}">
                    <div class="language-img">
                        <img src="{{ $language->getLogoLink() }}" alt="{{ $language->trans->name }}">
                    </div>
                    <span>{{ $language->trans->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
@endif
