@extends('themes.basic.business.auth.layout')
@section('title', d_trans('Setup Your Business'))
@section('content')
    <div class="mb-4">
        <h2 class="sign-title">{{ d_trans('Setup Your Business') }}</h2>
        <p class="sign-text">{{ d_trans('Provide your business details to begin your journey.') }}</p>
    </div>
    <form action="{{ route('business.setup.store') }}" method="POST">
        @csrf
        <div class="row g-3 mb-3">
            <div class="col-12">
                <label class="form-label">{{ d_trans('Business Name') }}</label>
                <input type="text" name="business_name" class="form-control form-control-md"
                    value="{{ old('business_name') }}" autofocus required />
            </div>
            <div class="col-12">
                <label class="form-label">{{ d_trans('Website') }}</label>
                <input type="url" name="website" class="form-control form-control-md" placeholder="https://example.com"
                    value="{{ old('website') }}" required />
            </div>
            <div class="col-12">
                <label class="form-label">{{ d_trans('Category') }}</label>
                <select name="category" class="form-select form-select-md" required>
                    <option value="" disabled selected>{{ d_trans('Select Category') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category') == $category->id)>
                            {{ $category->trans->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12">
                <label class="form-label">{{ d_trans('Short Description') }}</label>
                <textarea name="short_description" class="form-control form-control-md"
                    placeholder="{{ d_trans('Between 30 to 60 character') }}" rows="2" minlength="30" maxlength="60" required>{{ old('short_description') }}</textarea>
            </div>
        </div>
        <button class="btn btn-primary btn-md w-100">{{ d_trans('Get Started') }}</button>
    </form>
    @include('themes.basic.business.partials.logout-divider')
@endsection
