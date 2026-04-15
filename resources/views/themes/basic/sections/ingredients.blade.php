@push('styles')
    <style>
        .ingredients-section {
            background: linear-gradient(135deg, #f8f1e9 0%, #f4e6d8 100%);
        }

        .ingredients-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 80% 30%, rgba(255, 255, 255, 0.8) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .content-container {
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            gap: 84px;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .text-content {
            padding-left: 20px;
        }

        .text-content h2 {
            font-size: 2.8rem;
            line-height: 1.2;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 24px;
        }

        .text-content p {
            font-size: 1.1rem;
            color: #C62828;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .ingredient-badges {
            display: flex;
            flex-direction: row;
            gap: 18px;
            margin-top: 36px;
            flex-wrap: wrap;
        }

        .ingredient-badge {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 8px;
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            flex: 1;
            min-width: 140px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .ingredient-badge:hover {
            background: rgba(255, 255, 255, 0.9);
            border-color: rgba(255, 255, 255, 0.6);
            transform: translateX(4px);
        }

        .badge-icon {
            font-size: 1.6rem;
            color: #C62828;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .badge-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .badge-label {
            font-size: 0.75rem;
            color: #e23e3e;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-value {
            color: #1f2937;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .explore-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: #e5d4c0;
            color: #4b3f35;
            padding: 14px 32px;
            border-radius: 9999px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 1.05rem;
        }

        .explore-btn:hover {
            background: #d4b89a;
            transform: translateY(-2px);
        }

        .visual-container {
            position: relative;
            height: 560px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-left: -28px;
        }

        .bottle-wrapper {
            position: relative;
            width: 600px;
            height: 100%;
            z-index: 2;
            /* margin-left: 12px; */
        }

        .bottle {
            width: 100%;
            filter: drop-shadow(20px 30px 40px rgba(0, 0, 0, 0.15));
        }

        .label {
            position: absolute;
            background: white;
            padding: 10px 18px;
            border-radius: 9999px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            z-index: 10;
            backdrop-filter: blur(10px);
        }

        .label-paraben {
            top: 12%;
            right: -20%;
        }

        .label-fragrance {
            top: 48%;
            right: -18%;
        }

        .label-hyaluronic {
            bottom: 28%;
            left: -22%;
        }

        .leaf {
            position: absolute;
            width: 60px;
            filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.1));
        }

        .leaf1 {
            top: 18%;
            left: -10%;
            transform: rotate(-25deg);
        }

        .leaf2 {
            top: 55%;
            right: -25%;
            transform: rotate(35deg);
        }

        .leaf3 {
            bottom: 22%;
            left: 15%;
            transform: rotate(-45deg);
        }

        .bubble {
            position: absolute;
            background: rgba(255, 255, 255, 0.85);
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(165, 132, 96, 0.2);
            animation: float 6s infinite ease-in-out;
        }



        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-25px);
            }
        }

        /* media query for mobile  */
        @media (max-width: 991.98px) {
            .visual-container {
                height: 250px;
            }

            .bottle-wrapper {
                width: 250px;
            }
        }

        @media (max-width: 767.98px) {
            .ingredients-section {
                padding: 36px 0;
            }

            .content-container {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .visual-container {
                height: 220px;
                margin-left: 0;
                justify-content: center;
                order: 1;
            }

            .bottle-wrapper {
                width: min(100%, 320px);
                height: 100%;
                margin: 0 auto;
                background-position: center center !important;
            }

            .text-content {
                padding-left: 0;
                text-align: center;
                order: 2;
            }

            .text-content h2 {
                font-size: clamp(2rem, 8vw, 2.5rem);
                margin-bottom: 18px;
            }

            .text-content p {
                font-size: 1rem;
                margin-bottom: 24px;
            }

            .explore-btn {
                justify-content: center;
                width: 100%;
                max-width: 320px;
            }

            .ingredient-badges {
                justify-content: center;
                gap: 12px;
                margin-top: 28px;
            }

            .ingredient-badge {
                min-width: 0;
                width: 100%;
                flex: 1 1 100%;
                padding: 14px 16px;
            }
        }

        @media (max-width: 575.98px) {
            .ingredients-section {
                padding: 28px 0;
            }

            .content-container {
                gap: 24px;
            }

            .visual-container {
                height: 190px;
            }

            .bottle-wrapper {
                width: min(100%, 280px);
                background-size: contain !important;
            }

            .text-content h2 {
                font-size: 1.9rem;
                line-height: 1.15;
            }

            .text-content p {
                font-size: 0.95rem;
                line-height: 1.65;
            }

            .explore-btn {
                max-width: 100%;
                padding: 13px 22px;
                font-size: 0.98rem;
            }

            .ingredient-badges {
                margin-top: 22px;
            }

            .badge-icon {
                font-size: 1.4rem;
            }

            .badge-label {
                font-size: 0.7rem;
            }

            .badge-value {
                font-size: 0.9rem;
            }
        }
    </style>
@endpush

<section class="home-section-spacing py-5 ingredients-section">
    <div class="container container-custom home-section-container">

        <div class="row">
            <div class="visual-container col-lg-6" data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="150">
                <div class="bottle-wrapper"
                    style="background-image: url('{{ asset('/images/frontend/oil-dropper-bottle.webp') }}'); background-size: contain; background-position: center; background-repeat: no-repeat;">
                </div>
            </div>

            <!-- Right Text & Badges -->
            <div class="text-content col-lg-6" data-aos="fade-left" data-aos-duration="900">
                <h2>Not All <br> Ingredients Are <br>What They Seem</h2>
                <p>Some concerning ingredients never appear on the label.
                    We test every product in accredited laboratories and
                    publish the full findings — so you know exactly
                    what you are putting on your skin.</p>
                <a href="#" class="explore-btn">
                    Explore Ingredients
                    <span style="font-size: 1.4rem; line-height: 1;">→</span>
                </a>

                <!-- Ingredient Info Badges -->
                <div class="ingredient-badges">
                    <div class="ingredient-badge" data-aos="fade-up" data-aos-delay="100" data-aos-duration="800">
                        <i class="fas fa-flask badge-icon"></i>
                        <div class="badge-text">
                            <span class="badge-label">Lab Tested</span>
                            <span class="badge-value">50+ Substances</span>
                        </div>
                    </div>
                    <div class="ingredient-badge" data-aos="fade-up" data-aos-delay="200" data-aos-duration="800">
                        <i class="fas fa-check-circle badge-icon"></i>
                        <div class="badge-text">
                            <span class="badge-label">Safety Score</span>
                            <span class="badge-value">Science-Based</span>
                        </div>
                    </div>
                    <div class="ingredient-badge" data-aos="fade-up" data-aos-delay="300" data-aos-duration="800">
                        <i class="fas fa-chart-bar badge-icon"></i>
                        <div class="badge-text">
                            <span class="badge-label">Full Transparency</span>
                            <span class="badge-value">Complete Analysis</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
