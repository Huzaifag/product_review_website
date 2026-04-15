<footer class="footer">
    <div class="footer-upper">
        <div class="container container-custom">
            @php
                $facebook = config('settings.social_links.facebook');
                $x = config('settings.social_links.x');
                $linkedin = config('settings.social_links.linkedin');
                $youtube = config('settings.social_links.youtube');
                $instagram = config('settings.social_links.instagram');
                $pinterest = config('settings.social_links.pinterest');
                $hasSocialLinks = $facebook || $x || $linkedin || $youtube || $instagram || $pinterest;
            @endphp
            <div class="row g-5">
                @if ($hasSocialLinks || $newsletterFooterStatus)
                    <div class="col-12 col-lg-5 col-xxl-5">
                        <livewire:newsletter.footer hasSocialLinks="{{ $hasSocialLinks }}" />
                        @if ($hasSocialLinks)
                            <div>
                                <h6>{{ d_trans('Follow Us:') }}</h6>
                                <div class="socials">
                                    @if ($facebook)
                                        <a href="https://facebook.com/{{ $facebook }}" target="_blank"
                                            aria-label="{{ d_trans('Facebook') }}" class="social-btn">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    @endif
                                    @if ($x)
                                        <a href="https://x.com/{{ $x }}" target="_blank"
                                            aria-label="{{ d_trans('X') }}" class="social-btn">
                                            <i class="fab fa-x-twitter"></i>
                                        </a>
                                    @endif
                                    @if ($linkedin)
                                        <a href="https://linkedin.com/in/{{ $linkedin }}" target="_blank"
                                            aria-label="{{ d_trans('Linkedin') }}" class="social-btn">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                    @endif
                                    @if ($youtube)
                                        <a href="https://youtube.com/{{ '@' . $youtube }}" target="_blank"
                                            aria-label="{{ d_trans('Youtube') }}" class="social-btn">
                                            <i class="fab fa-youtube"></i>
                                        </a>
                                    @endif
                                    @if ($instagram)
                                        <a href="https://instagram.com/{{ $instagram }}" target="_blank"
                                            aria-label="{{ d_trans('Instagram') }}" class="social-btn">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    @endif
                                    @if ($pinterest)
                                        <a href="https://pinterest.com/{{ $pinterest }}" target="_blank"
                                            aria-label="{{ d_trans('Pinterest') }}" class="social-btn">
                                            <i class="fab fa-pinterest"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
                <div class="col-12 {{ $hasSocialLinks || $newsletterFooterStatus ? 'col-lg-7 col-xxl-7' : '' }}">
                    <div
                        class="row row-cols-2  {{ $hasSocialLinks || $newsletterFooterStatus ? 'row-cols-md-2 row-cols-xl-3' : 'row-cols-md-3 row-cols-xl-4' }} g-5">
                        @foreach ($footerLinks as $footerLink)
                            @if ($footerLink->children->count() > 0)
                                <div class="col">
                                    <a href="{{ $footerLink->link }}"
                                        {{ $footerLink->isExternal() ? 'target=_blank' : '' }} class="footer-title">
                                        <span class="h5">{{ $footerLink->name }}</span>
                                    </a>
                                    <ul class="footer-links list-unstyled mb-0">
                                        @foreach ($footerLink->children as $child)
                                            <li class="footer-link">
                                                <a href="{{ $child->link }}"
                                                    {{ $child->isExternal() ? 'target=_blank' : '' }}
                                                    class="footer-text">{{ $child->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <div class="col">
                                    <a href="{{ $footerLink->link }}"
                                        {{ $footerLink->isExternal() ? 'target=_blank' : '' }} class="footer-text">
                                        {{ $footerLink->name }}
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-lower">
        <div class="container container-custom">
            <div class="row row-cols-1 row-cols-sm-auto align-items-center justify-content-between g-3">
                <div class="col">
                    <p class="footer-copyright small mb-0">
                        &copy; <span data-year></span>
                        {{ m_trans(config('settings.general.site_name')) }} - {{ d_trans('All rights reserved') }}.
                    </p>
                </div>
                @if (config('theme.settings.footer.footer_payment_methods'))
                    <div class="col">
                        <div class="footer-payments">
                            <img src="{{ asset(config('theme.settings.footer.footer_payment_methods_image')) }}"
                                alt="{{ m_trans(config('settings.general.site_name')) }}">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</footer>
