@extends('admin.layouts.app')
@section('container', 'dashboard-container-xxl')
@section('title', d_trans('Reported Reviews'))
@section('header_title', d_trans('Reported Reviews'))
@section('content')
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET">
                @if (request('user'))
                    <input type="hidden" name="user" value="{{ request('user') }}">
                @endif
                <div class="row g-3">
                    <div class="col-12 col-lg-10">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
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
                        <th>{{ d_trans('Review ID') }}</th>
                        <th>{{ d_trans('Reported by') }}</th>
                        <th>{{ d_trans('Reason') }}</th>
                        <th class="text-center">{{ d_trans('Report date') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($reportedReviews as $reportedReview)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.reported-reviews.show', $reportedReview->id) }}">
                                        <i class="fa-solid fa-hashtag me-1"></i>{{ $reportedReview->id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.businesses.reviews', $reportedReview->business->id) }}"
                                        class="text-dark">
                                        <i class="fa-solid fa-hashtag me-1"></i>{{ $reportedReview->review->id }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.members.users.edit', $reportedReview->user->id) }}"
                                        class="text-dark">
                                        <i class="fa-regular fa-user me-2"></i>{{ $reportedReview->user->getName() }}
                                    </a>
                                </td>
                                <td>
                                    <textarea class="form-control" rows="3" readonly>{{ $reportedReview->reason }}</textarea>
                                </td>
                                <td class="text-center">{{ dateFormat($reportedReview->created_at) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.reported-reviews.show', $reportedReview->id) }}">
                                                    <i class="fas fa-desktop"></i>{{ d_trans('View details') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ $reportedReview->review->getLink() }}"
                                                    target="_blank">
                                                    <i
                                                        class="fa-solid fa-arrow-up-right-from-square"></i>{{ d_trans('View Review') }}
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form
                                                    action="{{ route('admin.reported-reviews.delete-review', $reportedReview->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="action-confirm dropdown-item text-danger"><i
                                                            class="far fa-trash-alt"></i>{{ d_trans('Delete Review') }}</button>
                                                </form>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form
                                                    action="{{ route('admin.reported-reviews.destroy', $reportedReview->id) }}"
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
                            @include('admin.partials.empty-table', ['colspan' => 6])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $reportedReviews->links() }}
@endsection
