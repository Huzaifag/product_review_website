@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Pending Reviews'))
@section('title', d_trans('Pending Reviews'))
@section('header_title', d_trans('Pending Review #:review_id', ['review_id' => $review->id]))
@section('back', route('admin.pending-reviews.index'))
@section('content')
    <div class="row row-cols-1 g-4">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span>{{ d_trans('Pending Review') }}</span>
                </div>
                <div class="card-body p-0">
                    @include('admin.partials.review', [
                        'review' => $review,
                        'review_only' => true,
                    ])
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span>{{ d_trans('Take Action') }}</span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <form action="{{ route('admin.pending-reviews.publish', $review->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-md action-confirm w-100"><i
                                        class="bi bi-check-circle me-2"></i>{{ d_trans('Publish') }}</button>
                            </form>
                        </div>
                        <div class="col-lg-6">
                            <form action="{{ route('admin.pending-reviews.reject', $review->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-md action-confirm w-100"><i
                                        class="bi bi-x-circle me-2"></i>{{ d_trans('Reject') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
