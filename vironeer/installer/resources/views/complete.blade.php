@extends('installer::layouts.app')
@section('title', d_trans('Complete'))
@section('content')
    <div class="vironeer-steps-body">
        <p class="vironeer-form-info-text">
            {{ d_trans('Enter your website and admin access details, make sure you remember the admin access path.') }}
        </p>
        <form id="completeForm" action="{{ route('install.complete') }}" method="POST">
            @csrf
            <div class="row row-cols-1 g-3 mb-4">
                <div class="col">
                    <label class="form-label">{{ d_trans('Website name') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                        <input type="text" name="website_name" value="{{ old('website_name') }}"
                            class="form-control form-control-md" placeholder="{{ d_trans('Website name') }}"
                            autocomplete="off" required>
                    </div>
                </div>
                <div class="col">
                    <label class="form-label">{{ d_trans('Website URL') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-link"></i></span>
                        <input type="text" name="website_url" value="{{ old('website_url') ?? url('/') }}"
                            class="form-control form-control-md remove-spaces" placeholder="{{ d_trans('Website URL') }}"
                            required>
                    </div>
                </div>
                <div class="col">
                    <label class="form-label">{{ d_trans('Business path') }}
                        <small class="text-muted">({{ d_trans('Letters and numbers only') }})</small>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-globe me-2"></i>{{ url('/') }}/</span>
                        <input type="text" name="business_path" value="{{ old('business_path') ?? 'business' }}"
                            class="form-control form-control-md custom-input remove-spaces"
                            placeholder="{{ d_trans('admin') }}" required>
                    </div>
                </div>
                <div class="col">
                    <label class="form-label">{{ d_trans('Admin panel path') }}
                        <small class="text-muted">({{ d_trans('Letters and numbers only') }})</small>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-globe me-2"></i>{{ url('/') }}/</span>
                        <input type="text" name="admin_path" value="{{ old('admin_path') ?? 'admin' }}"
                            class="form-control form-control-md custom-input remove-spaces"
                            placeholder="{{ d_trans('admin') }}" required>
                    </div>
                </div>
                <div class="col">
                    <label class="form-label">{{ d_trans('Admin Username') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="username" minlength="3" value="{{ old('username') ?? 'admin' }}"
                            class="form-control form-control-md" placeholder="john" autocomplete="off" required>
                    </div>
                </div>
                <div class="col">
                    <label class="form-label">{{ d_trans('Admin email') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-control form-control-md" placeholder="admin@example.com" autocomplete="off"
                            required>
                    </div>
                </div>
                <div class="col">
                    <label class="form-label">{{ d_trans('Admin password') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        <input type="password" name="password" class="form-control form-control-md"
                            placeholder="{{ d_trans('Password') }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="col">
                    <label class="form-label">{{ d_trans('Confirm admin password') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        <input type="password" name="password_confirmation" class="form-control form-control-md"
                            placeholder="{{ d_trans('Confirm password') }}" autocomplete="off" required>
                    </div>
                </div>
            </div>
        </form>
        <div class="d-flex justify-content-between align-items-center">
            <form action="{{ route('install.complete.back') }}" method="POST">
                @csrf
                <button class="btn btn-dark btn-md"><i class="fas fa-arrow-left me-2"></i>{{ d_trans('Back') }}</button>
            </form>
            <button form="completeForm" class="btn btn-primary btn-md">{{ d_trans('Finish') }}<i
                    class="fas fa-arrow-right ms-2"></i></button>
        </div>
    </div>
    @push('scripts')
        <script>
            $(".custom-input").on('input', function() {
                $(this).val($(this).val().replace(/[^a-zA-Z0-9 _]/g, ""));
            });
        </script>
    @endpush
@endsection
