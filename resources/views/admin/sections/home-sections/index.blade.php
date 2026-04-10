@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Sections'))
@section('title', d_trans('Home Sections'))
@section('header_title', d_trans('Home Sections'))
@section('create', route('admin.sections.home-sections.create'))
@section('content')
    <div class="card">
        @if ($homeSections->count() > 0)
            <div class="dd nestable">
                <ol class="dd-list">
                    @foreach ($homeSections as $homeSection)
                        <li class="dd-item" data-id="{{ $homeSection->id }}">
                            <div class="dd-handle py-3">
                                <span class="drag-indicator me-3 text-center">
                                    <i class="fa-solid fa-up-down-left-right fa-lg"></i>
                                </span>
                                <span class="fs-5">{{ $homeSection->trans->name }}</span>
                                <div class="dd-nodrag ms-auto">
                                    <a href="{{ route('admin.sections.home-sections.edit', $homeSection->id) }}"
                                        class="btn btn-soft">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @if (!$homeSection->isPermanent())
                                        <form class="d-inline"
                                            action="{{ route('admin.sections.home-sections.destroy', $homeSection->id) }}"
                                            method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger action-confirm"><i
                                                    class="far fa-trash-alt"></i></button>
                                        </form>
                                    @endif
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
    @if ($homeSections->count() > 0)
        @push('top_scripts')
            <script>
                "use strict";
                const sortingRoute = "{{ route('admin.sections.home-sections.nestable') }}";
                const nestableMaxDepth = 1;
            </script>
        @endpush
        @push('scripts_libs')
            <script src="{{ asset('vendor/libs/jquery/nestable/jquery.nestable.min.js') }}"></script>
        @endpush
    @endif
@endsection
