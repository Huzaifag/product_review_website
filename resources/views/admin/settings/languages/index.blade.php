@extends('admin.layouts.app')
@section('container', 'dashboard-container-lg')
@section('section', d_trans('Settings'))
@section('title', d_trans('Languages'))
@section('header_title', d_trans('Languages'))
@section('back', route('admin.settings.index'))
@section('create', route('admin.settings.languages.create'))
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
                <table class="table sortable">
                    <thead>
                        <th><i class="fa-solid fa-hashtag"></i></th>
                        <th>{{ d_trans('Logo') }}</th>
                        <th>{{ d_trans('Name') }}</th>
                        <th>{{ d_trans('Code') }}</th>
                        <th class="text-center">{{ d_trans('Direction') }}</th>
                        <th class="text-center">{{ d_trans('Created date') }}</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @forelse($languages as $language)
                            <tr data-id="{{ $language->id }}">
                                <td class="sortable-handle">
                                    <i class="fa-solid fa-up-down-left-right"></i>
                                </td>
                                <td>
                                    <a href="{{ route('admin.settings.languages.translates', $language->id) }}">
                                        <img src="{{ $language->getLogoLink() }}" alt="{{ $language->trans->name }}"
                                            width="30px" height="30px">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.settings.languages.translates', $language->id) }}"
                                        class="text-dark">
                                        {{ $language->trans->name }}
                                        @if ($language->isDefault())
                                            <span>{{ d_trans('(Default)') }}</span>
                                        @endif
                                    </a>
                                </td>
                                <td>{{ strtoupper($language->code) }}</td>
                                <td class="text-center">{{ $language->getDirection() }}</td>
                                <td class="text-center">{{ dateFormat($language->created_at) }}</td>
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
                                                    href="{{ route('admin.settings.languages.edit', $language->id) }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>{{ d_trans('Edit') }}
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.settings.languages.translates', $language->id) }}">
                                                    <i class="bi bi-translate"></i>{{ d_trans('Translates') }}
                                                </a>
                                            </li>
                                            @if (!$language->isDefault())
                                                <li class="dropdown-divider"></li>
                                                <li>
                                                    <form
                                                        action="{{ route('admin.settings.languages.default', $language->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button class="action-confirm dropdown-item text-success">
                                                            <i
                                                                class="fa-regular fa-bookmark"></i>{{ d_trans('Make Default') }}
                                                        </button>
                                                    </form>
                                                </li>
                                                <li class="dropdown-divider"></li>
                                                <li>
                                                    <form
                                                        action="{{ route('admin.settings.languages.destroy', $language->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="action-confirm dropdown-item text-danger">
                                                            <i class="far fa-trash-alt"></i>{{ d_trans('Delete') }}
                                                        </button>
                                                    </form>
                                                </li>
                                            @endif
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
    @push('top_scripts')
        <script>
            "use strict";
            const sortingRoute = "{{ route('admin.settings.languages.sortable') }}";
        </script>
    @endpush
    @push('styles_libs')
        <link rel="stylesheet" href="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.css') }}">
    @endpush
    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/bootstrap/select/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('vendor/libs/sortable/sortable.min.js') }}"></script>
    @endpush
@endsection
