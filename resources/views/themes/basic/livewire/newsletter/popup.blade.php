<div>
    @if ($newsletterPopupStatus)
        <div wire:ignore.self class="modal fade" id="newsletterModal" tabindex="-1" aria-labelledby="newsletterModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content p-0 border-0 rounded-3 shadow-lg">
                    <div class="modal-body p-0">
                        <div class="row g-0">
                            <div class="col-lg-6 d-none d-lg-block">
                                <img src="{{ asset(config('settings.newsletter.popup_image')) }}"
                                    class="img-fluid w-100 h-100 rounded-start object-fit-cover newsletter-popup-image"
                                    alt="{{ d_trans('Subscribe to Our Newsletter') }}">
                            </div>
                            <div class="col-lg-6 p-5 d-flex flex-column justify-content-center">
                                <h2 class="mb-4 fw-bold text-primary">{{ d_trans('Subscribe to Our Newsletter') }}
                                </h2>
                                <p class="mb-4 text-muted">
                                    {{ d_trans('Stay tuned for the latest news, updates and best rated businesses, delivered right to your inbox!') }}
                                </p>
                                <form wire:submit.prevent="subscribe">
                                    <div class="mb-3">
                                        <label class="form-label">{{ d_trans('Your Email') }}</label>
                                        <input type="email" wire:model.defer="email"
                                            class="form-control form-control-lg" placeholder="name@example.com"
                                            value="{{ authUser() ? authUser()->email : '' }}" required>
                                    </div>
                                    <button class="btn btn-primary btn-lg w-100">{{ d_trans('Subscribe') }}</button>
                                </form>
                                <button class="btn btn-outline-primary btn-lg mt-3 w-100"
                                    wire:click="remindLater">{{ d_trans('Remind me later') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @push('scripts')
            <script>
                "use strict";
                document.addEventListener("DOMContentLoaded", function() {
                    var newsletterModal = new bootstrap.Modal(document.getElementById('newsletterModal'));
                    newsletterModal.show();
                });
            </script>
        @endpush
    @endif
</div>
