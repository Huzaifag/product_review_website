@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('System'))
@section('title', d_trans('Editor Images'))
@section('header_title', d_trans('Editor Images'))
@section('back', route('admin.system.index'))
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
                <table class="table">
                    <thead>
                        <th>{{ d_trans('ID') }}</th>
                        <th>{{ d_trans('Details') }}</th>
                        <th class="text-center">{{ d_trans('Uploaded Date') }}</th>
                        <th class="text-end">{{ d_trans('Action') }}</th>
                    </thead>
                    <tbody>
                        @forelse ($editorImages as $editorImage)
                            <tr>
                                <td>{{ $editorImage->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="item-img item-img-sm">
                                            <img src="{{ $editorImage->getLink() }}">
                                        </div>
                                        <div>
                                            <div class="item-title fw-normal mb-0">
                                                {{ shorterText($editorImage->name, 40) }}</div>
                                            <p class="item-text text-muted small mb-0">
                                                {{ $editorImage->getLink() }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ dateFormat($editorImage->created_at) }}</td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <form
                                                    action="{{ route('admin.system.editor-images.destroy', $editorImage->id) }}"
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
                            @include('admin.partials.empty-table', ['colspan' => 4])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
