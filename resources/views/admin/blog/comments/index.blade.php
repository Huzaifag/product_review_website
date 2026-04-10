@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Blog'))
@section('title', d_trans('Comments'))
@section('header_title', d_trans('Blog Comments'))
@section('content')
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET">
                <div class="row g-3">
                    @if (request('article'))
                        <input type="hidden" name="article" value="{{ request('article') }}">
                    @endif
                    <div class="col-12 col-lg-7">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-lg-3">
                        <select name="status" class="selectpicker" title="{{ d_trans('Status') }}">
                            @foreach (\App\Models\BlogComment::getAvailableStatuses() as $key => $value)
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
                        <th>{{ d_trans('Posted by') }}</th>
                        <th>{{ d_trans('Article') }}</th>
                        <th class="text-center">{{ d_trans('Status') }}</th>
                        <th class="text-center">{{ d_trans('Posted date') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse ($comments as $comment)
                            <tr>
                                <td>{{ $comment->id }}</td>
                                <td>
                                    <a href="{{ route('admin.members.users.edit', $comment->user->id) }}"
                                        class="text-dark">
                                        <i class="fa fa-user me-2"></i>{{ $comment->user->getName() }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.blog.comments.show', $comment->id) }}" class="text-dark"><i
                                            class="fa-solid fa-file-lines me-2"></i>{{ shorterText($comment->article->title, 30) }}</a>
                                </td>
                                <td class="text-center">
                                    @if ($comment->isPublished())
                                        <span class="badge bg-success">{{ $comment->getStatusName() }}</span>
                                    @else
                                        <span class="badge bg-warning">{{ $comment->getStatusName() }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ dateFormat($comment->created_at) }}</td>
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
                                                    href="{{ route('admin.blog.comments.show', $comment->id) }}">
                                                    <i class="fa-regular fa-eye"></i>{{ d_trans('View') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.blog.articles.edit', $comment->article->id) }}"
                                                    target="_blank"><i
                                                        class="fa-solid fa-arrow-up-right-from-square"></i>{{ d_trans('View Article') }}</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider" />
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.blog.comments.destroy', $comment->id) }}"
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
    {{ $comments->links() }}
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
    @endpush
@endsection
