@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('section', d_trans('Blog'))
@section('title', d_trans('Categories'))
@section('header_title', d_trans('Blog Categories'))
@section('create', route('admin.blog.categories.create'))
@section('content')
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET">
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
                <table class="table data-table">
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-hashtag"></i></th>
                            <th>{{ d_trans('Name') }}</th>
                            <th class="text-center">{{ d_trans('Articles') }}</th>
                            <th class="text-center">{{ d_trans('Views') }}</th>
                            <th class="text-center">{{ d_trans('Published date') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    <a href="{{ route('admin.blog.categories.edit', $category->id) }}" class="text-dark">
                                        <i class="fa-solid fa-tag me-2"></i>{{ $category->name }}
                                    </a>
                                </td>
                                <td class="text-center"><span class="badge bg-dark">{{ $category->articles_count }}</span>
                                </td>
                                <td class="text-center"><span class="badge bg-dark">{{ $category->views }}</span></td>
                                <td class="text-center">{{ dateFormat($category->created_at) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.blog.categories.edit', $category->id) }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>{{ d_trans('Edit') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ $category->getLink() }}"
                                                    target="_blank"><i
                                                        class="fa-solid fa-arrow-up-right-from-square"></i>{{ d_trans('Preview') }}</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.blog.articles.index', ['category' => $category->id]) }}">
                                                    <i class="fa-regular fa-file-lines"></i>{{ d_trans('Articles') }}
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.blog.categories.destroy', $category->id) }}"
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
                            @include('admin.partials.empty-table', ['colspan' => 5])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $categories->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/datatable/datatables.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/datatable/datatables.jq.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/datatable/datatables.min.js') }}"></script>
    @endpush
@endsection
