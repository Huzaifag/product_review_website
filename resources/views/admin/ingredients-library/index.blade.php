@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Ingredient Library'))
@section('title', d_trans('Ingredient Library'))
@section('header_title', d_trans('Ingredient Library'))
@section('create', route('admin.ingredients-library.create'))
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
                        <tr>
                            <th><i class="fa-solid fa-hashtag"></i></th>
                            <th>{{ d_trans('Name') }}</th>
                            <th>{{ d_trans('INCI Name') }}</th>
                            <th class="text-center">{{ d_trans('Severity') }}</th>
                            <th class="text-center">{{ d_trans('Status') }}</th>
                            <th class="text-center">{{ d_trans('Published date') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ingredients as $ingredient)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ingredient->name }}</td>
                                <td>{{ $ingredient->inci_name ?? '-' }}</td>
                                <td class="text-center">
                                    @if ($ingredient->severity)
                                        @if ($ingredient->severity === 'avoid')
                                            <span class="badge bg-danger">{{ d_trans(ucfirst($ingredient->severity)) }}</span>
                                        @elseif ($ingredient->severity === 'concern')
                                            <span class="badge bg-warning">{{ d_trans(ucfirst($ingredient->severity)) }}</span>
                                        @else
                                            <span class="badge bg-info">{{ d_trans(ucfirst($ingredient->severity)) }}</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($ingredient->is_published)
                                        <span class="badge bg-success">{{ d_trans('Published') }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ d_trans('Draft') }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $ingredient->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-icon dropdown-toggle" type="button"
                                            id="dropdownMenuButton{{ $ingredient->id }}" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $ingredient->id }}">
                                            <li><a class="dropdown-item" href="{{ route('admin.ingredients-library.edit', $ingredient->id) }}">{{ d_trans('Edit') }}</a></li>
                                            <li><a class="dropdown-item" href="{{ route('admin.ingredients-library.show', $ingredient->id) }}">{{ d_trans('View') }}</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="{{ route('admin.ingredients-library.destroy', $ingredient->id) }}"
                                                onclick="event.preventDefault(); document.getElementById('delete-form-{{ $ingredient->id }}').submit();">
                                                {{ d_trans('Delete') }}
                                            </a></li>
                                        </ul>
                                    </div>
                                </td>
                                <form id="delete-form-{{ $ingredient->id }}" action="{{ route('admin.ingredients-library.destroy', $ingredient->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </tr>
                        @empty
                            @include('admin.partials.empty-table', ['colspan' => 7])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $ingredients->links() }}
@endsection
