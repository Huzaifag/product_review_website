<footer class="footer">
    <div class="footer-upper">
        <div class="container-fluid">
            <div class="row g-4 py-4 px-4">
                {{-- Newsletter Signup Column --}}
                <div class="col-12 col-lg-4 signup-col">
                    <h2 class="h4 fw-bold mb-3">{{ d_trans('Sign up for exclusive updates') }}</h2>
                    <p class="mb-3">
                        {{ d_trans('Be the first to know about new products, test results, and community updates.') }}
                    </p>
                    <livewire:newsletter.footer />
                </div>

                {{-- Navigation Column --}}
                <div class="col-12 col-lg-2 nav-col">
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
                <div class="col-12 col-lg-3 addr-col">
                    <h4 class="text-uppercase fw-600 mb-3">{{ d_trans('About') }}</h4>
                    <p>{{ d_trans('Independent. Science-based. On your side since 1985.') }}</p>
                </div>

                {{-- Contact Column --}}
                <div class="col-12 col-lg-3 contact-col">
                    <h4 class="text-uppercase fw-600 mb-3">{{ d_trans('Contact') }}</h4>
                    <p class="mb-2"><a href="mailto:info@oko-test.com"
                            class="text-decoration-none">info@oko-test.com</a></p>
                    <p>{{ config('settings.contact_phone') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Brand Section --}}
    <div class="footer-brand text-center py-2">
        <div class="brand-name fw-bold mb-2">ÖKO • TEST</div>
        <p class="footer-credit mb-0">{{ d_trans('Independent. Laboratory Verified.') }}</p>
    </div>

    {{-- Footer Lower --}}
    <div class="footer-lower">
        <div class="container-fluid">
            <div class="row py-3 px-4 align-items-center justify-content-center">
                <div class="col-12 col-md-auto">
                    <p class="footer-copyright mb-0">
                        &copy; <span data-year></span>
                        {{ m_trans(config('settings.general.site_name')) }}
                        &mdash; {{ d_trans('All rights reserved') }}.
                    </p>
                </div>
                <div class="col-12 col-md-auto">
                    <p class="footer-copyright mb-0 text-center text-md-end">
                        {{ d_trans('All test results are independent and laboratory-verified.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    :root {
        --primary_color: #C62828;
        --footer_border_color: 200, 40, 40;
    }

    .footer {
        background: var(--primary_color) !important;
        color: #ffffff !important;
        border-top: none !important;
    }

    .footer .footer-upper {
        position: relative;
        /* Reduced from 80px to fix spacing */
        padding-top: 30px; 
    }

    .footer h2 {
        color: #ffffff;
    }

    .footer h4 {
        /* Increased from 12px for better readability */
        font-size: 16px; 
        font-weight: 600;
        color: #ffffff !important;
        letter-spacing: 0.5px;
    }

    .footer p, 
    .footer a {
        /* Brightened text and increased size */
        color: #ffffff !important; 
        font-size: 16px;
    }

    .footer a:hover {
        opacity: 0.8;
        text-decoration: underline !important;
    }

    .footer-brand .brand-name {
        /* Slightly scaled down the giant text to reduce layout stretching */
        font-size: 8rem !important; 
        color: #ffffff;
        line-height: 1;
    }

    .footer-credit {
        /* Fixed invisible grey color */
        color: #ffffff !important; 
        font-size: 16px;
        letter-spacing: 0.5px;
        margin-top: 10px;
    }

    .footer .footer-copyright {
        color: #ffffff !important;
    }

    .footer .footer-lower {
        position: relative;
        padding-top: 15px;
        border-top: 1px solid rgba(var(--footer_border_color), 0.8);
    }
</style>