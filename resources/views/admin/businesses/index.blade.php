@extends('admin.layouts.app')
@section('container', 'dashboard-container-xxl')
@section('title', d_trans('Businesses'))
@section('header_title', d_trans('Businesses'))
@section('content')
    <div class="row g-3 row-cols-md-2 row-cols-xxl-4 mb-4">
        <div class="col">
            <div class="vironeer-counter-card bg-success">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Active') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['active'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-danger">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-ban"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Suspended') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['suspended'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c-26">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Verified') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['verified'] }}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="vironeer-counter-card bg-c20">
                <div class="vironeer-counter-card-icon">
                    <i class="fa-regular fa-circle-xmark"></i>
                </div>
                <div class="vironeer-counter-card-meta">
                    <p class="vironeer-counter-card-title">{{ d_trans('Unverified') }}</p>
                    <p class="vironeer-counter-card-number">{{ $counters['unverified'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET">
                @if (request('owner'))
                    <input type="hidden" name="owner" value="{{ request('owner') }}">
                @endif
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if (request('sub_category'))
                    <input type="hidden" name="sub_category" value="{{ request('sub_category') }}">
                @endif
                @if (request('sub_sub_category'))
                    <input type="hidden" name="sub_sub_category" value="{{ request('sub_sub_category') }}">
                @endif
                <div class="row g-3">
                    <div class="col-12 col-lg-6">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="verification" class="selectpicker" title="{{ d_trans('Verification') }}">
                            @foreach (\App\Models\Business::getAvailableVerificationStatuses() as $key => $value)
                                <option value="{{ $key }}" @selected(request('verification') == "$key")>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <select name="status" class="selectpicker" title="{{ d_trans('Status') }}">
                            @foreach (\App\Models\Business::getAvailableStatuses() as $key => $value)
                                <option value="{{ $key }}" @selected(request('status') == "$key")>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary w-100"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col">
                        <a href="{{ url()->current() }}" class="btn btn-soft w-100">{{ d_trans('Reset') }}</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th><i class="fa-solid fa-hashtag"></i></th>
                        <th>{{ d_trans('Details') }}</th>
                        <th class="text-center">{{ d_trans('Rating / Reviews') }}</th>
                        <th class="text-center">{{ d_trans('Owner') }}</th>
                        <th class="text-center">{{ d_trans('Verification') }}</th>
                        <th class="text-center">{{ d_trans('Status') }}</th>
                        <th class="text-center">{{ d_trans('Added date') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($businesses as $business)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.businesses.show', $business->id) }}">
                                        <i class="fa-solid fa-hashtag me-1"></i>{{ $business->id }}
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="{{ route('admin.businesses.show', $business->id) }}"
                                            class="item-img item-img-sm">
                                            <img src="{{ $business->getLogoLink() }}" alt="{{ $business->trans->name }}">
                                        </a>
                                        <div>
                                            <a href="{{ route('admin.businesses.show', $business->id) }}"
                                                class="item-title d-block fw-normal mb-0">{{ $business->trans->name }}</a>
                                            <p class="item-text text-muted small mb-0">{{ $business->website }}</p>
                                        </div>
                                        @if ($business->isFeatured())
                                            <span class="badge bg-c21">{{ d_trans('Featured') }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <img src="{{ $business->getAvgRatingImageLink() }}" alt="{{ $business->avg_ratings }}"
                                        width="100px">
                                    <span class="ms-1"><strong>{{ $business->avg_ratings }}</strong>
                                        ({{ translate_choice(':count Review|:count Reviews', $business->total_reviews, ['count' => numberFormat($business->total_reviews)]) }})
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if ($business->hasOwner())
                                        <a href="{{ route('admin.members.business-owners.edit', $business->owner->id) }}"
                                            class="text-dark"><i
                                                class="fa fa-user me-2"></i>{{ $business->owner->getName() }}</a>
                                    @else
                                        <span>--</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($business->isVerified())
                                        <span class="badge bg-c-26">{{ $business->getVerificationStatusName() }}</span>
                                    @else
                                        <span class="badge bg-c20">{{ $business->getVerificationStatusName() }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($business->isActive())
                                        <span class="badge bg-success">{{ $business->getStatusName() }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $business->getStatusName() }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ dateFormat($business->created_at) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-xl dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton">
                                            @if ($business->isActive())
                                                <li>
                                                    <a class="dropdown-item" href="{{ $business->getLink() }}"
                                                        target="_blank">
                                                        <i class="fas fa-external-link-alt"></i>{{ d_trans('Preview') }}
                                                    </a>
                                                </li>
                                            @endif
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.businesses.show', $business->id) }}">
                                                    <i class="fas fa-desktop"></i>{{ d_trans('View Details') }}
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            @if ($business->isFeatured())
                                                <li>
                                                    <form
                                                        action="{{ route('admin.businesses.featured.remove', $business->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="action-confirm dropdown-item text-danger"><i
                                                                class="fa-solid fa-certificate"></i>{{ d_trans('Remove Featured') }}</button>
                                                    </form>
                                                </li>
                                            @else
                                                <li>
                                                    <form
                                                        action="{{ route('admin.businesses.featured.make', $business->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="action-confirm dropdown-item text-primary"><i
                                                                class="fa-solid fa-certificate"></i>{{ d_trans('Make Featured') }}</button>
                                                    </form>
                                                </li>
                                            @endif
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            @if ($business->isActive())
                                                <li>
                                                    <form action="{{ route('admin.businesses.suspend', $business->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="action-confirm dropdown-item text-danger"><i
                                                                class="fa-solid fa-ban"></i>{{ d_trans('Suspend') }}</button>
                                                    </form>
                                                </li>
                                            @else
                                                <li>
                                                    <form action="{{ route('admin.businesses.activate', $business->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="action-confirm dropdown-item text-success"><i
                                                                class="fa-solid fa-check"></i>{{ d_trans('Activate') }}</button>
                                                    </form>
                                                </li>
                                            @endif
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.businesses.destroy', $business->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="action-confirm dropdown-item text-danger"><i
                                                            class="far fa-trash-alt"></i>{{ d_trans('Delete') }}</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('admin.partials.empty-table', ['colspan' => 7])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $businesses->links() }}
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <h5 class="modal-header bg-primary text-white mb-0">{{ d_trans('Bulk Upload') }}</h5>
                <div class="modal-body p-4">
                    <div class="note note-warning mb-3">
                        <h6 class="mb-2"><strong>{{ d_trans('Required Columns') }}</strong></h6>
                        <ul class="mb-3">
                            <li class="mb-1">{{ d_trans('name') }}</li>
                            <li class="mb-1">{{ d_trans('website (Valid URL)') }}</li>
                        </ul>
                        <a href="{{ route('admin.businesses.download.csv') }}" class="btn btn-outline-warning"><i
                                class="bi bi-download me-2"></i>{{ d_trans('Download CSV File Example') }}</a>
                    </div>
                    <form action="{{ route('admin.businesses.bulk-upload') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">{{ d_trans('Businesses File (CSV)') }} </label>
                            <input type="file" name="businesses_file" class="form-control form-control-md"
                                accept=".csv" required>
                        </div>
                        <div class="row justify-content-center g-3">
                            <div class="col-12 col-lg">
                                <button type="button" class="btn btn-outline-primary btn-md w-100"
                                    data-bs-dismiss="modal" aria-label="Close">{{ d_trans('Close') }}</button>
                            </div>
                            <div class="col-12 col-lg">
                                <button class="btn btn-primary btn-md w-100">{{ d_trans('Upload') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <h5 class="modal-header mb-0">{{ d_trans('Add New Business') }}</h5>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.businesses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3 mb-4">
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
                        </div>
                        <div class="row justify-content-center g-3">
                            <div class="col-12 col-lg">
                                <button type="button" class="btn btn-outline-primary btn-md w-100"
                                    data-bs-dismiss="modal" aria-label="Close">{{ d_trans('Close') }}</button>
                            </div>
                            <div class="col-12 col-lg">
                                <button class="btn btn-primary btn-md w-100">{{ d_trans('Add') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/vironeer/counter-cards.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
