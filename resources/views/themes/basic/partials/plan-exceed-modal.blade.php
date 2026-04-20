<style>
    .premium-modal-overlay {
        /* Full screen overlay with blur effect */
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.4);
        /* Semi-transparent dark background */
        backdrop-filter: blur(8px);
        /* Blurs everything behind the modal */
        -webkit-backdrop-filter: blur(8px);
        /* Safari support */
        z-index: 99999;
        /* Ensures it stays on top of all other elements */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .premium-modal-content {
        background: #ffffff;
        padding: 40px 30px;
        border-radius: 12px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        text-align: center;
        max-width: 450px;
        width: 90%;
        animation: modalPopIn 0.3s ease-out forwards;
    }

    .premium-modal-content h3 {
        margin-top: 0;
        margin-bottom: 16px;
        color: #111827;
        /* Dark gray for high contrast */
        font-size: 1.5rem;
        font-weight: bold;
    }

    .premium-modal-content p {
        color: #4b5563;
        /* Softer gray for paragraph text */
        margin-bottom: 24px;
        line-height: 1.6;
    }

    .premium-modal-content .btn-primary {
        /* Optional: Inline overrides just in case your bootstrap theme needs a boost */
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: transform 0.2s;
    }

    .premium-modal-content .btn-primary:hover {
        transform: scale(1.05);
    }

    /* Smooth pop-in animation */
    @keyframes modalPopIn {
        0% {
            opacity: 0;
            transform: scale(0.95) translateY(10px);
        }

        100% {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
</style>

<div class="premium-modal-overlay" id="limitModal">
    <div class="premium-modal-content">
        <h3>{{ d_trans('Product View and Search Limit Reached') }}</h3>
        <p>
            {{ d_trans('You have reached the maximum number of product views and searches allowed under your current plan. To continue, please upgrade your plan.') }}
        </p>

        <a href="{{ route('admin.plans.index') }}" class="btn btn-primary mt-3">
            {{ d_trans('Upgrade Plan') }}
        </a>
    </div>
</div>

<script>
    // Prevent interaction and scrolling on the rest of the page
    document.body.style.overflow = 'hidden';
</script>
