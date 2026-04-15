@push('styles')
    <style>
        .main-section {
            
            background-color: var(--bg-color);
            /* Subtle radial pattern for background */
            background-image: radial-gradient(#e5e7eb 1px, transparent 1px);
            background-size: 20px 20px;
        }

        /* --- Left Text Section --- */
        .text-content {
            padding-right: 40px;
        }

        .small-label {
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--primary-accent);
            margin-bottom: 8px;
        }

        .main-heading {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.15;
            color: var(--text-dark);
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        .heading-underline {
            width: 65px;
            height: 4px;
            background-color: var(--primary-accent);
            margin-bottom: 40px;
            border-radius: 2px;
        }

        .btn-custom {
            display: inline-block;
            background-color: var(--primary-accent);
            color: #ffffff;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 20px 4px 20px 4px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: var(--primary-hover);
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: var(--accent-shadow);
        }

        /* --- Right Cards Section (3 Pillars) --- */
        .cards-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .cards-container {
            width: 100%;
            max-width: 960px;
            display: flex;
            gap: 28px;
            justify-content: center;
        }

        .feature-card {
            flex: 1;
            max-width: 300px;
            padding: 42px 32px;
            background-color: var(--glass-bg);
            border-radius: 45px 6px 45px 6px;
            box-shadow: var(--card-shadow);
            position: relative;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
            z-index: 1;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            z-index: 10;
        }

        .card-orange {
            background-color: var(--primary-accent);
            color: #ffffff;
            box-shadow: var(--accent-shadow);
        }

        /* Card Typography */
        .card-icon {
            width: 46px;
            height: 46px;
            margin-bottom: 24px;
        }

        .card-title {
            font-size: 1.15rem;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 14px;
        }

        .card-orange .card-title {
            color: #ffffff;
        }

        .card-text {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.65;
            margin: 0;
            font-weight: 400;
        }

        .card-orange .card-text {
            color: rgba(255, 255, 255, 0.92);
        }

        /* --- Responsive Layout --- */
        @media (max-width: 991px) {
            .text-content {
                padding-right: 0;
                text-align: center;
                margin-bottom: 60px;
            }

            .heading-underline {
                margin: 20px auto 40px;
            }

            .cards-container {
                gap: 20px;
            }

            .feature-card {
                padding: 36px 26px;
            }

            .main-heading {
                font-size: 2.6rem;
            }
        }

        @media (max-width: 767px) {
            .main-heading {
                font-size: 2.25rem;
            }

            .cards-container {
                flex-direction: column;
                align-items: center;
            }

            .feature-card {
                max-width: 420px;
                width: 100%;
            }
        }

        @media (max-width: 500px) {
            .main-heading {
                font-size: 1.9rem;
            }

            .feature-card {
                padding: 32px 24px;
            }
        }
    </style>
@endpush

<section class="home-section-spacing main-section py-5">
    <div class="container container-custom home-section-container">
        <div class="row align-items-center">

            <!-- Left Text Column -->
            <div class="col-lg-5 col-md-12">
                <div class="text-content">
                    <p class="small-label">WHY TRUST US</p>
                    <h2 class="main-heading">Independent Testing<br>You Can Trust</h2>
                    <div class="heading-underline"></div>
                    <a href="#" class="btn-custom">Our Methodology</a>
                </div>
            </div>

            <!-- Right Cards Column - 3 Pillars -->
            <div class="col-lg-7 col-md-12">
                <div class="cards-wrapper">
                    <div class="cards-container">

                        <!-- Card 1: Rigorous Lab Testing -->
                        <div class="feature-card" data-aos="fade-up" data-aos-duration="900" data-aos-delay="100">
                            <div class="card-icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M9 3H15M10 3V10L5 20H19L14 10V3M5 20C5 21.1046 5.89543 22 7 22H17C18.1046 22 19 21.1046 19 20"
                                        stroke="var(--primary-accent)" stroke-width="1.6" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M7 16H17" stroke="var(--primary-accent)" stroke-width="1.6"
                                        stroke-linecap="round" />
                                    <circle cx="12" cy="19" r="1" fill="var(--primary-accent)" />
                                </svg>
                            </div>
                            <h3 class="card-title">Rigorous Lab<br>Testing</h3>
                            <p class="card-text">Every product undergoes strict hands-on evaluation in our independent
                                labs.</p>
                        </div>

                        <!-- Card 2: 100% Independent (Orange) -->
                        <div class="feature-card card-orange" data-aos="fade-up" data-aos-duration="900"
                            data-aos-delay="200">
                            <div class="card-icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="white"
                                        stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M9 12l2 2 4-4" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </div>
                            <h3 class="card-title">100%<br>Independent</h3>
                            <p class="card-text">We buy our own test units. No sponsored reviews, ever.</p>
                        </div>

                        <!-- Card 3: No Commercial Bias -->
                        <div class="feature-card" data-aos="fade-up" data-aos-duration="900" data-aos-delay="300">
                            <div class="card-icon">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="var(--primary-accent)"
                                        stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                                    <circle cx="12" cy="13" r="3" fill="none"
                                        stroke="var(--primary-accent)" stroke-width="1.8" />
                                    <path d="M9 9L15 15M15 9L9 15" stroke="var(--primary-accent)" stroke-width="1.6"
                                        stroke-linecap="round" />
                                </svg>
                            </div>
                            <h3 class="card-title">No Commercial<br>Bias</h3>
                            <p class="card-text">Zero affiliate pressure. Zero manufacturer influence. Pure, honest
                                testing.</p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
