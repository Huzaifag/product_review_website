<div class="row g-3 row-cols-1 row-cols-lg-3 mb-4">
    <div class="col">
        <div class="vironeer-counter-card bg-success">
            <div class="vironeer-counter-card-icon">
                <i class="bi bi-star-half"></i>
            </div>
            <div class="vironeer-counter-card-meta">
                <p class="vironeer-counter-card-title">{{ d_trans('Total Reviews') }}</p>
                <p class="vironeer-counter-card-number">{{ $counters['total_reviews'] }}</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="vironeer-counter-card bg-warning">
            <div class="vironeer-counter-card-icon">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="vironeer-counter-card-meta">
                <p class="vironeer-counter-card-title">{{ d_trans('Pending Reviews') }}</p>
                <p class="vironeer-counter-card-number">{{ $counters['total_pending_reviews'] }}</p>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="vironeer-counter-card bg-danger">
            <div class="vironeer-counter-card-icon">
                <i class="bi bi-flag"></i>
            </div>
            <div class="vironeer-counter-card-meta">
                <p class="vironeer-counter-card-title">{{ d_trans('Reported Reviews') }}</p>
                <p class="vironeer-counter-card-number">{{ $counters['total_review_reports'] }}</p>
            </div>
        </div>
    </div>
</div>
<div class="card mb-4">
    <div class="card-header">{{ d_trans('Quick Actions') }}</div>
    <div class="card-body p-4">
        <div class="row row-cols-1 row-cols-lg-4 row-cols-xl-5 g-3">
            @if ($user->isActive())
                <div class="col">
                    <a class="btn btn-outline-primary btn-md w-100"
                        href="{{ route('admin.members.users.login', $user->id) }}" target="_blank">
                        <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>{{ d_trans('Login as User') }}
                    </a>
                </div>
            @endif
            <div class="col">
                <a class="btn btn-outline-secondary btn-md w-100" href="{{ $user->getProfileLink() }}" target="_blank">
                    <i class="fas fa-external-link-alt me-2"></i>{{ d_trans('View Profile') }}
                </a>
            </div>
            <div class="col">
                <a class="btn btn-outline-secondary btn-md w-100"
                    href="{{ route('admin.kyc-verifications.index', ['user' => $user->id]) }}">
                    <i class="far fa-id-card me-2"></i>{{ d_trans('KYC Verifications') }}
                </a>
            </div>
            <div class="col">
                <a class="btn btn-outline-secondary btn-md w-100"
                    href="{{ route('admin.pending-reviews.index', ['user' => $user->id]) }}">
                    <i class="fa-regular fa-star me-2"></i>{{ d_trans('Pending Reviews') }}
                </a>
            </div>
            <div class="col">
                <a class="btn btn-outline-secondary btn-md w-100"
                    href="{{ route('admin.reported-reviews.index', ['user' => $user->id]) }}">
                    <i class="fa-regular fa-flag me-2"></i>{{ d_trans('Reported Reviews') }}
                </a>
            </div>
        </div>
    </div>
</div>
@push('styles_libs')
    <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/counter-cards.min.css') }}">
@endpush
@push('scripts_libs')
    <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
@endpush
