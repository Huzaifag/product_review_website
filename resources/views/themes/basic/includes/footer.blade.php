<footer class="footer">
    <div class="footer-upper">
        <div class="container-fluid">
            {{-- Utilizing Bootstrap's grid gaps (g-4) for clean spacing --}}
            <div class="row g-4 py-4 px-md-4">
                {{-- Newsletter Signup Column --}}
                <div class="col-12 col-lg-4 signup-col">
                    <h2 class="h4 fw-bold mb-3">{{ d_trans('Sign up for exclusive updates') }}</h2>
                    <p class="mb-3">
                        {{ d_trans('Be the first to know about new products, test results, and community updates.') }}
                    </p>
                    <livewire:newsletter.footer />
                </div>

                {{-- Navigation Column --}}
                <div class="col-12 col-sm-6 col-md-4 col-lg-2 nav-col">
                    <h4 class="text-uppercase fw-600 mb-3">{{ d_trans('Navigation') }}</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('products.index') }}"
                                class="text-decoration-none">{{ d_trans('All Products') }}</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}"
                                class="text-decoration-none">{{ d_trans('Categories') }}</a></li>
                        <li class="mb-2"><a href="/plans" class="text-decoration-none">{{ d_trans('Plans') }}</a>
                        </li>
                        <li class="mb-2"><a href="/ingredients"
                                class="text-decoration-none">{{ d_trans('Ingredient Guide') }}</a></li>
                        <li class="mb-2"><a href="{{ route('blog.index') }}"
                                class="text-decoration-none">{{ d_trans('Blog') }}</a></li>
                    </ul>
                </div>

                {{-- Address/Info Column --}}
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 addr-col">
                    <h4 class="text-uppercase fw-600 mb-3">{{ d_trans('About') }}</h4>
                    <p>{{ d_trans('Independent. Science-based. On your side since 1985.') }}</p>
                </div>

                {{-- Contact Column --}}
                <div class="col-12 col-md-4 col-lg-3 contact-col">
                    <h4 class="text-uppercase fw-600 mb-3">{{ d_trans('Contact') }}</h4>
                    <p class="mb-2"><a href="mailto:info@oko-test.com"
                            class="text-decoration-none">info@oko-test.com</a></p>
                    <p>{{ config('settings.contact_phone') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Brand Section --}}
    <div class="footer-brand text-center py-4">
        <div class="brand-name fw-bold mb-2">ÖKO • TEST</div>
        <p class="footer-credit mb-0">{{ d_trans('Independent. Laboratory Verified.') }}</p>
    </div>

    {{-- Footer Lower --}}
    <div class="footer-lower">
        <div class="container-fluid">
            <div class="footer-bottom-wrap px-md-4">

                <p class="footer-copyright mb-0">
                    &copy; {{ date('Y') }}
                    {{ m_trans(config('settings.general.site_name')) }}
                    &mdash; {{ d_trans('All rights reserved.') }}
                </p>

                {{-- Footer dev credit --}}
                <a href="https://cleovici.com/" target="_blank" rel="noopener noreferrer" class="cl-footer-dev">
                    <span class="cl-footer-dev__icon">
                        <i class="fa-solid fa-code" aria-hidden="true"></i>
                    </span>
                    <span class="cl-footer-dev__text">
                        <span class="cl-footer-dev__by">{{ d_trans('Developed by') }}</span>
                        <img src="{{ asset('images/developer/cleovici.png') }}" height="30" width="100" alt="Cleovici">
                    </span>
                </a>

                <p class="footer-copyright mb-0 footer-note">
                    {{ d_trans('All test results are independent and laboratory-verified.') }}
                </p>

            </div>
        </div>
    </div>
</footer>

<style>
    :root {
        --primary_color: 198, 40, 40;
        --footer_border_color: 200, 40, 40;
        --footer-text: #ffffff;
    }

    .footer {
        background: rgb(var(--primary_color)) !important;
        color: var(--footer-text) !important;
        font-size: clamp(14px, 1.2vw, 16px);
        animation: footerFadeIn 0.4s ease-out;
    }

    .footer .footer-upper {
        padding: clamp(20px, 4vw, 40px) 0;
    }

    .footer h2 {
        color: var(--footer-text);
        font-size: clamp(1.25rem, 3vw, 1.5rem);
        line-height: 1.3;
    }

    .footer h4 {
        font-size: clamp(0.95rem, 2.5vw, 1rem);
        font-weight: 600;
        color: var(--footer-text) !important;
        letter-spacing: 0.3px;
        margin-bottom: 1rem !important;
        text-transform: uppercase;
    }

    .footer p,
    .footer a {
        color: var(--footer-text) !important;
        font-size: clamp(0.9rem, 2vw, 1rem);
        line-height: 1.5;
    }

    .footer a {
        transition: opacity 0.2s ease;
    }

    .footer a:hover {
        opacity: 0.85;
        /* text-decoration: underline !important; */
    }

    /* Brand Section */
    .footer-brand {
        background: rgba(0, 0, 0, 0.1);
        padding: clamp(20px, 4vw, 30px) 15px;
    }

    .footer-brand .brand-name {
        font-size: clamp(2.5rem, 8vw, 8rem) !important;
        color: var(--footer-text);
        line-height: 0.9;
        letter-spacing: -2px;
        word-wrap: break-word;
    }

    .footer-credit {
        color: var(--footer-text) !important;
        font-size: clamp(0.85rem, 2vw, 1.1rem);
        letter-spacing: 0.5px;
        opacity: 0.9;
    }

    /* Footer Lower */
    .footer .footer-lower {
        padding: 18px 0;
        border-top: 1px solid rgba(var(--footer_border_color), 0.8);
    }

    .footer-bottom-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        flex-wrap: wrap;
    }

    .footer-copyright {
        color: #fff !important;
        font-size: 15px !important;
        font-weight: 600;
        line-height: 1.5;
        margin: 0;
        opacity: 1 !important;
    }

    .footer-note {
        text-align: right;
    }

    /* Developer Badge */
    .dev-badge {
        display: inline-flex !important;
        align-items: center;
        gap: 9px;
        padding: 8px 18px 8px 10px !important;
        border-radius: 999px;
        color: #fff !important;
        text-decoration: none !important;
        font-size: 15px !important;
        font-weight: 600;
        line-height: 1;
        white-space: nowrap;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.22);
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, 0.18),
            0 8px 20px rgba(0, 0, 0, 0.18);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        transition: all 0.3s ease;
    }

    /* .dev-badge:hover {
        color: #fff !important;
        text-decoration: none !important;
        transform: translateY(-2px);
        box-shadow:
            inset 0 1px 0 rgba(255, 255, 255, 0.2),
            0 12px 28px rgba(0, 0, 0, 0.28);
    } */

    .dev-icon {
        width: 28px;
        height: 28px;
        min-width: 28px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.12);
    }

    .dev-icon i {
        font-size: 12px;
    }

    /* Mobile */
    @media (max-width: 991px) {
        .footer .footer-upper {
            text-align: center;
        }

        .footer .nav-col ul {
            display: inline-block;
            text-align: center;
        }

        .footer .nav-col a {
            display: block;
            padding: 8px 0;
        }

        .footer .addr-col p,
        .footer .contact-col p {
            margin-inline: auto;
            max-width: 400px;
        }

        .footer-bottom-wrap {
            justify-content: center;
            text-align: center;
        }

        .footer-note {
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .footer-bottom-wrap {
            flex-direction: column;
            gap: 12px;
        }

        .dev-badge {
            font-size: 13px !important;
            padding: 7px 16px !important;
        }

        .footer-copyright {
            font-size: 13px !important;
        }
    }

    @keyframes footerFadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }



    .cl-footer-dev {
        justify-self: end;
        display: inline-flex;
        align-items: center;
        gap: 13px;
        padding: 12px 20px;
        color: rgba(255, 255, 255, 0.65);
        text-decoration: none;
        position: relative;
        transition: color 0.3s ease;
    }

    .cl-footer-dev::before,
    .cl-footer-dev::after {
        content: '';
        position: absolute;
        width: 12px;
        height: 12px;
        opacity: 0.5;
        transition: width 0.38s cubic-bezier(0.23, 1, 0.32, 1),
            height 0.38s cubic-bezier(0.23, 1, 0.32, 1),
            border-color 0.3s ease,
            opacity 0.3s ease;
    }

    .cl-footer-dev::before {
        top: 0;
        left: 0;
        border-top: 2px solid rgba(255, 255, 255, 0.55);
        border-left: 2px solid rgba(255, 255, 255, 0.55);
    }

    .cl-footer-dev::after {
        bottom: 0;
        right: 0;
        border-bottom: 2px solid rgba(255, 255, 255, 0.55);
        border-right: 2px solid rgba(255, 255, 255, 0.55);
    }

    .cl-footer-dev__icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        border-radius: 6px;
        background: rgba(197, 160, 89, 0.12);
        border: 1px solid rgba(197, 160, 89, 0.25);
        color: var(--cl-accent);
        font-size: 13px;
        flex-shrink: 0;
        transition: background 0.3s ease,
            border-color 0.3s ease,
            color 0.3s ease,
            transform 0.3s ease;
    }

    .cl-footer-dev__text {
        display: flex;
        flex-direction: column;
        gap: 4px;
        line-height: 1;
    }

    .cl-footer-dev__by {
        font-size: 0.62rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #f1f1f1;
        transition: color 0.3s ease;
    }

    .cl-footer-dev__text img {
        display: block;
        height: 22px;
        width: auto;
        opacity: 0.75;
        transition: opacity 0.3s ease, filter 0.3s ease;
        filter: brightness(0) invert(1);
    }

    .cl-footer-dev:hover::before,
    .cl-footer-dev:hover::after {
        width: 100%;
        height: 100%;
        border-color: var(--cl-accent);
        opacity: 1;
    }

    .cl-footer-dev:hover .cl-footer-dev__icon {
        background: rgba(197, 160, 89, 0.22);
        border-color: rgba(197, 160, 89, 0.55);
        color: var(--cl-accent);
        transform: rotate(-8deg) scale(1.08);
    }

    .cl-footer-dev:hover .cl-footer-dev__by {
        color: rgba(197, 160, 89, 0.8);
    }

    .cl-footer-dev:hover .cl-footer-dev__text img {
        opacity: 1;
        filter: brightness(0) invert(69%) sepia(50%) saturate(497%) hue-rotate(5deg) brightness(92%) contrast(89%);
    }
</style>

{{-- Script to dynamically set the year without extra JS files --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('span[data-year]').forEach(function (el) {
            el.setAttribute('data-year', new Date().getFullYear());
        });
    });
</script>