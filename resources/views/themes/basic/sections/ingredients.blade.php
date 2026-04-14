@push('styles')
<style>
    .ingredients-section {
        background: linear-gradient(135deg, #f8f1e9 0%, #f4e6d8 100%);
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }

    .ingredients-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 80% 30%, rgba(255,255,255,0.8) 0%, transparent 50%);
        pointer-events: none;
    }

    .content-container {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
        padding: 0 20px;
    }

    .text-content h1 {
        font-size: 3.2rem;
        line-height: 1.1;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 16px;
    }

    .text-content p {
        font-size: 1.25rem;
        color: #4b5563;
        margin-bottom: 32px;
        max-width: 380px;
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
        height: 520px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bottle-wrapper {
        position: relative;
        width: 280px;
        z-index: 2;
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

    .leaf1 { top: 18%; left: -10%; transform: rotate(-25deg); }
    .leaf2 { top: 55%; right: -25%; transform: rotate(35deg); }
    .leaf3 { bottom: 22%; left: 15%; transform: rotate(-45deg); }

    .bubble {
        position: absolute;
        background: rgba(255,255,255,0.85);
        border-radius: 50%;
        box-shadow: 0 4px 12px rgba(165, 132, 96, 0.2);
        animation: float 6s infinite ease-in-out;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-25px); }
    }
</style>
@endpush

<section class="ingredients-section">
    <div class="content-container">
        <!-- Left Text -->
        <div class="text-content">
            <h1>Not All<br>Ingredients Are<br>They Seem</h1>
            <p>We break down what’s really inside your cosmetics — so you can choose safer, smarter products.</p>
            <a href="#" class="explore-btn">
                Explore Ingredients 
                <span style="font-size: 1.4rem; line-height: 1;">→</span>
            </a>
        </div>

        <!-- Right Visual -->
        <div class="visual-container">
            <div class="bottle-wrapper">
                <!-- Main Bottle -->
                <img src="{{ asset('/images/frontend/dropper-bottle.webp') }}" 
                     alt="Dropper Bottle" 
                     class="bottle"
                     style="width: 280px;">

            </div>
        </div>
    </div>
</section>