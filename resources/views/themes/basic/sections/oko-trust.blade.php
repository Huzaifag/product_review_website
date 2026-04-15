<section class="oko-trust-section">
    <div class="container">
        <div class="section-header">
            <span class="small-label">WHY TRUST US</span>
            <h2 class="section-heading">Independent Testing<br>You Can Trust</h2>
        </div>

        <div class="pillars-grid">
            <div class="pillar-card">
                <div class="icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M10 2v7.31"></path>
                        <path d="M14 9.3V1.99"></path>
                        <path d="M8.5 2h7"></path>
                        <path d="M14 9.3a6.5 6.5 0 1 1-4 0"></path>
                        <path d="M5.52 16h12.96"></path>
                    </svg>
                </div>
                <h3 class="pillar-title">Anonymous Purchasing</h3>
                <p class="pillar-text">We buy every product from real stores without telling the brand. No special
                    samples ever accepted.</p>
            </div>

            <div class="pillar-card">
                <div class="icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path>
                        <path d="m9 12 2 2 4-4"></path>
                    </svg>
                </div>
                <h3 class="pillar-title">Accredited Laboratories</h3>
                <p class="pillar-text">Every product is tested by certified independent labs for over 50 harmful
                    substances.</p>
            </div>

            <div class="pillar-card">
                <div class="icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z">
                        </path>
                        <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path>
                        <path d="M12 17V7"></path>
                    </svg>
                </div>
                <h3 class="pillar-title">No Commercial Bias</h3>
                <p class="pillar-text">We accept no advertising from brands we test. Our verdict is 100% independent and
                    science-based.</p>
            </div>
        </div>
    </div>
</section>

@push('styles')
    <style>
        /* Base Section Styling */
        .oko-trust-section {
            background-color: var(--bg-light);
            padding: 6rem 1.5rem;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            position: relative;
            overflow: hidden;
        }

        /* Optional: Subtle background gradient/glow to make the glass effect pop */
        .oko-trust-section::before {
            content: '';
            position: absolute;
            top: -20%;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            height: 80%;
            background: radial-gradient(circle, rgba(194, 155, 126, 0.15) 0%, rgba(255, 255, 255, 0) 70%);
            z-index: 0;
            pointer-events: none;
        }

        .oko-trust-section .container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* Header Styling */
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .small-label {
            display: inline-block;
            color: var(--primary-accent);
            font-size: 0.875rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .section-heading {
            color: var(--text-dark);
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin: 0;
        }

        /* Pillars Grid */
        .pillars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2.5rem;
        }

        /* Premium Glassmorphism Card */
        .pillar-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .pillar-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
            border-color: rgba(186, 81, 29, 0.2);
        }

        /* Icon Styling */
        .icon-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 64px;
            height: 64px;
            margin: 0 auto 1.5rem auto;
            background-color: rgba(186, 81, 29, 0.08);
            color: var(--primary-accent);
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .pillar-card:hover .icon-wrapper {
            background-color: var(--primary-accent);
            color: #ffffff;
        }

        /* Text Content */
        .pillar-title {
            color: var(--text-dark);
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .pillar-text {
            color: var(--text-muted);
            font-size: 1rem;
            line-height: 1.6;
            margin: 0;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .oko-trust-section {
                padding: 4rem 1.25rem;
            }

            .section-heading {
                font-size: 2rem;
            }

            .pillar-card {
                padding: 2.5rem 1.5rem;
            }
        }
    </style>
@endpush
