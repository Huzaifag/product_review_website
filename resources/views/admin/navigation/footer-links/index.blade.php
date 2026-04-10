@extends('admin.layouts.app')
@section('container', 'dashboard-container-md')
@section('section', d_trans('Navigation'))
@section('title', d_trans('Footer Links'))
@section('header_title', d_trans('Footer Links'))
@section('create', route('admin.navigation.footer-links.create'))
@section('content')
    <div class="card">
        @if ($footerLinks->count() > 0)
            <div class="dd nestable">
                <ol class="dd-list">
                    @foreach ($footerLinks as $footerLink)
                        <li class="dd-item" data-id="{{ $footerLink->id }}">
                            <div class="dd-handle">
                                <span class="drag-indicator">
                                    <i class="fa-solid fa-up-down-left-right"></i>
                                </span>
                                <span>{{ $footerLink->name }}</span>
                                <div class="dd-nodrag ms-auto">
                                    <a href="{{ route('admin.navigation.footer-links.edit', $footerLink->id) }}"
                                        class="btn btn-soft btn-sm px-2 small">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form class="d-inline"
                                        action="{{ route('admin.navigation.footer-links.destroy', $footerLink->id) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm px-2 small action-confirm"><i
                                                class="far fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </div>
                            @if ($footerLink->children->count() > 0)
                                <ol class="dd-list">
                                    @foreach ($footerLink->children as $child)
                                        <li class="dd-item" data-id="{{ $child->id }}">
                                            <div class="dd-handle">
                                                <span class="drag-indicator">
                                                    <i class="fa-solid fa-up-down-left-right"></i>
                                                </span>
                                                <span>{{ $child->name }}</span>
                                                <div class="dd-nodrag ms-auto">
                                                    <a href="{{ route('admin.navigation.footer-links.edit', $child->id) }}"
                                                        class="btn btn-soft btn-sm px-2 small">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form class="d-inline"
                                                        action="{{ route('admin.navigation.footer-links.destroy', $child->id) }}"
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
    @if ($footerLinks->count() > 0)
        @push('top_scripts')
            <script>
                "use strict";
                const sortingRoute = "{{ route('admin.navigation.footer-links.nestable') }}";
                const nestableMaxDepth = 2;
            </script>
        @endpush
        @push('scripts_libs')
            <script src="{{ asset('vendor/libs/jquery/nestable/jquery.nestable.min.js') }}"></script>
        @endpush
    @endif
@endsection
