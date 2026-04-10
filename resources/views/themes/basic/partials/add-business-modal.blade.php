@if (config('settings.user.actions.adding_none_exists_business'))
    @if (
        !config('settings.business.actions.reviews_require_login') ||
            (config('settings.business.actions.reviews_require_login') && authUser()))
        <div class="modal fade" id="addBusinessModal" tabindex="-1" aria-labelledby="addBusinessModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-custom px-4">
                        <h1 class="modal-title fs-5" id="addBusinessModalLabel">{{ d_trans('Add Business') }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 pt-3">
                        <form action="{{ route('businesses.add') }}" method="POST">
                            @csrf
                            <p>{{ d_trans('Enter the URL of the business you want to review.') }}</p>
                            <div class="mb-3">
                                <input type="url" name="business_website" class="form-control form-control-md"
                                    value="{{ old('business_website') }}" placeholder="https://example.com" required>
                            </div>
                            <x-captcha />
                            <button class="btn btn-primary btn-md w-100">{{ d_trans('Add Business') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
