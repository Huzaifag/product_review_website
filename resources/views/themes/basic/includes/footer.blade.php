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
                        <li class="mb-2"><a href="{{ route('businesses.index') }}"
                                class="text-decoration-none">{{ d_trans('All Test Results') }}</a></li>
                        <li class="mb-2"><a href="{{ route('businesses.index') }}"
                                class="text-decoration-none">{{ d_trans('Product Search') }}</a></li>
                        <li class="mb-2"><a href="/#how-we-test"
                                class="text-decoration-none">{{ d_trans('Rating System') }}</a></li>
                        <li class="mb-2"><a href="#"
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
            <div class="row py-3 px-md-4 align-items-center justify-content-between text-center text-md-start">
                <div class="col-12 col-md-auto mb-2 mb-md-0">
                    <p class="footer-copyright mb-0">
                        &copy; <span data-year></span>
                        {{ m_trans(config('settings.general.site_name')) }}
                        &mdash; {{ d_trans('All rights reserved. Developed by team Bitlogicx') }}.
                    </p>
                </div>
                <div class="col-12 col-md-auto">
                    <p class="footer-copyright mb-0 text-md-end">
                        {{ d_trans('All test results are independent and laboratory-verified.') }}
                    </p>
                </div>
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
        padding-top: clamp(20px, 4vw, 40px);
        padding-bottom: clamp(20px, 4vw, 40px);
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
        display: inline-block;
        padding: 2px 0;
        transition: opacity 0.2s ease;
    }

    .footer a:hover {
        opacity: 0.85;
        text-decoration: underline !important;
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
        overflow-wrap: break-word;
    }

    .footer-credit {
        color: var(--footer-text) !important;
        font-size: clamp(0.85rem, 2vw, 1.1rem);
        letter-spacing: 0.5px;
        opacity: 0.9;
    }

    /* Lower Footer */
    .footer .footer-lower {
        padding: clamp(15px, 2vw, 20px) 0;
        border-top: 1px solid rgba(var(--footer_border_color), 0.8);
    }

    .footer .footer-copyright {
        color: var(--footer-text) !important;
        font-size: clamp(0.8rem, 2vw, 0.95rem);
        opacity: 0.9;
    }

    /* Mobile Enhancements */
    @media (max-width: 767px) {
        .footer .footer-upper {
            text-align: center;
        }

        .footer .nav-col ul {
            display: inline-block;
            text-align: center;
        }

        /* Improved touch targets for mobile nav links */
        .footer .nav-col a {
            padding: 8px 0;
            display: block;
        }

        .footer .addr-col p,
        .footer .contact-col p {
            margin-left: auto;
            margin-right: auto;
            max-width: 400px;
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

    /* Make sure inline JS variables work */
    span[data-year]::before {
        content: attr(data-year);
    }
</style>

{{-- Script to dynamically set the year without extra JS files --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('span[data-year]').forEach(function(el) {
            el.setAttribute('data-year', new Date().getFullYear());
        });
    });
</script>
