@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Navigation'))
@section('title', d_trans('Navbar Links'))
@section('header_title', d_trans('Navbar Links'))
@section('create', route('admin.navigation.navbar-links.create'))
@section('content')
    <div class="card">
        @if ($navbarLinks->count() > 0)
            <div class="dd nestable">
                <ol class="dd-list">
                    @foreach ($navbarLinks as $navbarLink)
                        <li class="dd-item" data-id="{{ $navbarLink->id }}">
                            <div class="dd-handle">
                                <span class="drag-indicator">
                                    <i class="fa-solid fa-up-down-left-right"></i>
                                </span>
                                <span>{{ $navbarLink->name }}</span>
                                <div class="dd-nodrag ms-auto">
                                    <a href="{{ route('admin.navigation.navbar-links.edit', $navbarLink->id) }}"
                                        class="btn btn-soft btn-sm px-2 small">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form class="d-inline"
                                        action="{{ route('admin.navigation.navbar-links.destroy', $navbarLink->id) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm px-2 small action-confirm"><i
                                                class="far fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </div>
                            @if ($navbarLink->children->count() > 0)
                                <ol class="dd-list">
                                    @foreach ($navbarLink->children as $child)
                                        <li class="dd-item" data-id="{{ $child->id }}">
                                            <div class="dd-handle">
                                                <span class="drag-indicator">
                                                    <i class="fa-solid fa-up-down-left-right"></i>
                                                </span>
                                                <span>{{ $child->name }}</span>
                                                <div class="dd-nodrag ms-auto">
                                                    <a href="{{ route('admin.navigation.navbar-links.edit', $child->id) }}"
                                                        class="btn btn-soft btn-sm px-2 small">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form class="d-inline"
                                                        action="{{ route('admin.navigation.navbar-links.destroy', $child->id) }}"
                                                        method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn btn-danger btn-sm px-2 small action-confirm"><i
                                                                class="far fa-trash-alt"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ol>
                            @endif
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
    @if ($navbarLinks->count() > 0)
        @push('top_scripts')
            <script>
                "use strict";
                const sortingRoute = "{{ route('admin.navigation.navbar-links.nestable') }}";
                const nestableMaxDepth = 2;
            </script>
        @endpush
        @push('scripts_libs')
            <script src="{{ asset('vendor/libs/jquery/nestable/jquery.nestable.min.js') }}"></script>
        @endpush
    @endif
@endsection
