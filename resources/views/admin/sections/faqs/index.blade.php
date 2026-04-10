@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Sections'))
@section('title', d_trans('FAQs'))
@section('header_title', d_trans('FAQs'))
@section('create', route('admin.sections.faqs.create'))
@section('content')
    <div class="card">
        @if ($faqs->count() > 0)
            <div class="dd nestable">
                <ol class="dd-list">
                    @foreach ($faqs as $faq)
                        <li class="dd-item" data-id="{{ $faq->id }}">
                            <div class="dd-handle py-3">
                                <span class="drag-indicator me-3 text-center">
                                    <i class="fa-solid fa-up-down-left-right fa-lg"></i>
                                </span>
                                <span class="fs-5">{{ $faq->title }}</span>
                                <div class="dd-nodrag ms-auto">
                                    <a href="{{ route('admin.sections.faqs.edit', $faq->id) }}" class="btn btn-soft">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form class="d-inline" action="{{ route('admin.sections.faqs.destroy', $faq->id) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger action-confirm"><i
                                                class="far fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>
        @else
            <div class="card-body col-lg-8 m-auto">
                @include('admin.partials.empty', ['empty_classes' => 'empty-lg'])
            </div>
        @endif
    </div>
    @if ($faqs->count() > 0)
        @push('top_scripts')
            <script>
                "use strict";
                const sortingRoute = "{{ route('admin.sections.faqs.nestable') }}";
                const nestableMaxDepth = 1;
            </script>
        @endpush
        @push('scripts_libs')
            <script src="{{ asset('vendor/libs/jquery/nestable/jquery.nestable.min.js') }}"></script>
        @endpush
    @endif
@endsection
