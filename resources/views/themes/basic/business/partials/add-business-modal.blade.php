@if (authBusinessOwner()->canCreateBusiness())
    <div class="modal fade" id="addBusinessModal" tabindex="-1" aria-labelledby="addBusinessModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4">
                <div class="modal-header border-0 p-0 mb-4">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ d_trans('Add Business') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <form action="{{ route('business.add') }}" method="POST">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Business Name') }}</label>
                                <input type="text" name="business_name" class="form-control form-control-md"
                                    value="{{ old('business_name') }}" required />
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Website') }}</label>
                                <input type="url" name="website" class="form-control form-control-md"
                                    placeholder="https://example.com" value="{{ old('website') }}" required />
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Category') }}</label>
                                <select name="category" class="form-select form-select-md" required>
                                    <option value="" disabled selected>{{ d_trans('Select Category') }}</option>
                                    @foreach ($modalCategories as $modalCategory)
                                        <option value="{{ $modalCategory->id }}" @selected(old('category') == $modalCategory->id)>
                                            {{ $modalCategory->trans->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">{{ d_trans('Short Description') }}</label>
                                <textarea name="short_description" class="form-control form-control-md"
                                    placeholder="{{ d_trans('Between 30 to 60 character') }}" rows="2" minlength="30" maxlength="60" required>{{ old('short_description') }}</textarea>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-md w-100">{{ d_trans('Add') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
