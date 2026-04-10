@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Reported Reviews'))
@section('title', d_trans('Reported Reviews'))
@section('header_title', d_trans('Reported Review #:report_id', ['report_id' => $reportedReview->id]))
@section('back', route('admin.reported-reviews.index'))
@section('content')
    <div class="row row-cols-1 g-4">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span>{{ d_trans('Reported Review') }}</span>
                    <a href="{{ $reportedReview->review->getLink() }}" target="_blank" class="small"><i
                            class="fa-solid fa-arrow-up-right-from-square me-2"></i>{{ d_trans('View Review') }}</a>
                </div>
                <div class="card-body p-0">
                    @include('admin.partials.review', [
                        'review' => $reportedReview->review,
                        'review_only' => true,
                    ])
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">{{ d_trans('Report Reason') }}</div>
                <div class="card-body p-4">
                    <textarea class="form-control" rows="6" readonly>{{ $reportedReview->reason }}</textarea>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header">{{ d_trans('Take Action') }}</div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12 col-lg">
                            <form action="{{ route('admin.reported-reviews.delete-review', $reportedReview->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-md action-confirm w-100"><i
                                        class="bi bi-trash me-2"></i>{{ d_trans('Delete Review') }}</button>
                            </form>
                        </div>
                        <div class="col-12 col-lg">
                            <form action="{{ route('admin.reported-reviews.destroy', $reportedReview->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-md action-confirm w-100"><i
                                        class="bi bi-trash me-2"></i>{{ d_trans('Delete Report') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
