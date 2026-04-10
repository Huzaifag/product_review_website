@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Blog'))
@section('title', d_trans('Articles'))
@section('header_title', d_trans('Blog Articles'))
@section('create', route('admin.blog.articles.create'))
@section('content')
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-lg-7">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="category" class="selectpicker" title="{{ d_trans('Category') }}"
                            data-live-search="true">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($category->id == request('category'))>
                                    {{ $category->name }}
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
                        <th>{{ d_trans('Article') }}</th>
                        <th class="text-center">{{ d_trans('Category') }}</th>
                        <th class="text-center">{{ d_trans('Comments') }}</th>
                        <th class="text-center">{{ d_trans('Views') }}</th>
                        <th class="text-center">{{ d_trans('Published date') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($articles as $article)
                            <tr>
                                <td>{{ $article->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="{{ route('admin.blog.articles.edit', $article->id) }}"
                                            class="item-img item-img-sm">
                                            <img src="{{ $article->getImageLink() }}" alt="{{ $article->title }}">
                                        </a>
                                        <div>
                                            <a href="{{ route('admin.blog.articles.edit', $article->id) }}"
                                                class="item-title d-block fw-normal mb-0">{{ shorterText($article->title, 40) }}</a>
                                            <p class="item-text text-muted small mb-0">
                                                {{ shorterText($article->description, 50) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.blog.categories.edit', $article->category->id) }}">
                                        <span class="badge bg-primary">{{ $article->category->name }}</span>
                                    </a>
                                </td>
                                <td class="text-center"><span class="badge bg-dark">{{ $article->comments_count }}</span>
                                </td>
                                <td class="text-center"><span class="badge bg-dark">{{ $article->views }}</span></td>
                                <td class="text-center">{{ dateFormat($article->created_at) }}</td>
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
                                                    href="{{ route('admin.blog.articles.edit', $article->id) }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>{{ d_trans('Edit') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ $article->getLink() }}"
                                                    target="_blank"><i
                                                        class="fa-solid fa-arrow-up-right-from-square"></i>{{ d_trans('Preview') }}</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.blog.comments.index', ['article' => $article->id]) }}"><i
                                                        class="fa-regular fa-comments"></i>{{ d_trans('Comments') }}</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.blog.articles.destroy', $article->id) }}"
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
    {{ $articles->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
