<div>
    @if ($newsletterFooterStatus)
        <div class="footer-subscribe {{ $hasSocialLinks ? 'mb-5' : '' }} pe-lg-5">
            <h3 class="mb-3">{{ d_trans('Subscribe to Our Newsletter') }}</h3>
            <p class="mb-4">
                {{ d_trans("We'll keep you updated with the latest news and updates.") }}
            </p>
            <form wire:submit.prevent="subscribe">
                @csrf
                <div class="input-group input-group-absolute">
                    <input type="email" wire:model.defer="email" class="form-control form-control-lg"
                        placeholder="{{ d_trans('Enter your email') }}" value="{{ authUser() ? authUser()->email : '' }}"
                        required>
                    <button class="btn btn-primary btn-md">
                        {{ d_trans('Subscribe') }}<i class="bi bi-send-fill icon-rtl ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
