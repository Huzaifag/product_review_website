<section class="home-section-spacing py-5">
    <div class="container container-custom home-section-container">
        <h2 class="sr-only">
            {{ d_trans('OKO-TEST Kosmetik - trust and product discovery sections') }}
        </h2>

        <!-- Section 3: How It Works -->
        <div>
            <p class="mag-label" id="how-we-test">
                {{ d_trans('How we test products') }}
            </p>

            <h2 class="mag-title">
                {{ d_trans('Three steps from shelf to verdict') }}
            </h2>

            <div class="row g-3 mt-4">

                <div class="col-md-4" data-aos="fade-up" data-aos-duration="900">
                    <div class="trust-card trust-card-1 h-100">
                        <i class="fas fa-store trust-card-corner-icon" aria-hidden="true"></i>

                        <div class="badge-pill">
                            <span class="badge-dot"></span>{{ d_trans('Step 1') }}
                        </div>

                        <div class="card-title-text">
                            {{ d_trans('We buy anonymously') }}
                        </div>

                        <p class="card-desc">
                            {{ d_trans('We purchase every product anonymously from drugstores and pharmacies. No manufacturer is informed in advance — no special samples accepted.') }}
                        </p>

                        <div class="stat-row">
                            <span class="stat-num">01</span>
                            <span class="stat-label">
                                {{ d_trans('No manufacturer influence') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4" data-aos="fade-up" data-aos-duration="900" data-aos-delay="120">
                    <div class="trust-card trust-card-2 h-100">
                        <i class="fas fa-flask trust-card-corner-icon" aria-hidden="true"></i>

                        <div class="badge-pill">
                            <span class="badge-dot"></span>{{ d_trans('Step 2') }}
                        </div>

                        <div class="card-title-text">
                            {{ d_trans('Labs test for 50+ substances') }}
                        </div>

                        <p class="card-desc">
                            {{ d_trans('Accredited independent laboratories analyse every product for over 50 harmful substances — including contaminants that never appear on any label.') }}
                        </p>

                        <div class="stat-row">
                            <span class="stat-num">02</span>
                            <span class="stat-label">
                                {{ d_trans('Accredited lab analysis') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4" data-aos="fade-up" data-aos-duration="900" data-aos-delay="240">
                    <div class="trust-card trust-card-3 h-100">
                        <i class="fas fa-certificate trust-card-corner-icon" aria-hidden="true"></i>

                        <div class="badge-pill">
                            <span class="badge-dot"></span>{{ d_trans('Step 3') }}
                        </div>

                        <div class="card-title-text">
                            {{ d_trans('We publish an honest verdict') }}
                        </div>

                        <p class="card-desc">
                            {{ d_trans('Every product receives a grade from Very Good to Failing — based purely on lab findings, with full ingredient transparency and no commercial bias.') }}
                        </p>

                        <div class="stat-row">
                            <span class="stat-num">03</span>
                            <span class="stat-label">
                                {{ d_trans('Science-based verdict') }}
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Section 4: Final CTA -->
        <div class="cta-banner mt-5" data-aos="fade-up" data-aos-duration="1000">
            <div class="cta-left" data-aos="fade-right" data-aos-duration="1000">

                <p class="cta-eyebrow">
                    {{ d_trans('Stay informed') }}
                </p>

                <h2 class="cta-title">
                    {{ d_trans('Always know what is in your beauty products') }}
                </h2>

                <p class="cta-desc">
                    {{ d_trans('Track new lab test results, ingredient warnings, and category updates so you never miss a finding that could affect your daily routine.') }}
                </p>

                <a href="#" class="cta-btn">
                    {{ d_trans('See Latest Test Results') }} &nbsp;→
                </a>

                <div class="cta-perks">
                    <div class="perk">
                        <div class="perk-dot"></div>
                        {{ d_trans('Fresh lab results') }}
                    </div>

                    <div class="perk">
                        <div class="perk-dot"></div>
                        {{ d_trans('Ingredient alerts') }}
                    </div>

                    <div class="perk">
                        <div class="perk-dot"></div>
                        {{ d_trans('Weekly test updates') }}
                    </div>
                </div>
            </div>

            <div class="cta-right" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="150">
                <div class="cta-image">
                    <img src="{{ asset('images/frontend/cta-image.webp') }}"
                        alt="{{ d_trans('Safe beauty updates') }}" class="img-fluid">
                </div>
            </div>
        </div>

    </div>
</section>

<style>
    @media (min-width: 630px) and (max-width: 899.98px) {
        .cta-image {
            width: 230px !important;
            max-width: 230px;
        }
    }

    @media (min-width: 900px) {
        .cta-image {
            width: 100%;
            max-width: 900px;
        }
    }
</style>
