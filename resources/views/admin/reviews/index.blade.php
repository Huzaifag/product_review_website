@extends('admin.layouts.app')
@section('container', 'dashboard-container-xxl')
@section('title', d_trans('All Reviews'))
@section('header_title', d_trans('All Reviews'))
@section('content')
    <div class="card">
        <div class="card-header border-bottom">
            <form action="{{ url()->current() }}" method="GET">
                @if (request('user'))
                    <input type="hidden" name="user" value="{{ request('user') }}">
                @endif

                <div class="row g-3 align-items-center">

                    <!-- Search -->
                    <div class="col-12 col-lg-4">
                        <input type="text" name="search" class="form-control" placeholder="{{ d_trans('Search...') }}"
                            value="{{ request('search') }}">
                    </div>

                    <!-- Status -->
                    <div class="col-6 col-lg-2">
                        <select name="status" class="form-select">
                            <option value="">{{ d_trans('Status') }}</option>
                            <option value="approved"> {{ d_trans('Approved') }}</option>
                            <option value="rejected"> {{ d_trans('Rejected') }}</option>
                        </select>
                    </div>

                    <!-- Rating -->
                    <div class="col-6 col-lg-2">
                        <select name="rating" class="form-select">
                            <option value="">{{ d_trans('All Ratings') }}</option>
                            <option value="5">5 {{ d_trans('Stars') }}</option>
                            <option value="4">4 {{ d_trans('Stars') }}</option>
                            <option value="3">3 {{ d_trans('Stars') }}</option>
                            <option value="2">2 {{ d_trans('Stars') }}</option>
                            <option value="1">1 {{ d_trans('Star') }}</option>
                        </select>
                    </div>

                    <!-- Search Button -->
                    <div class="col-3 col-lg-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>

                    <!-- Reset Button -->
                    <div class="col-3 col-lg-2">
                        <a href="{{ url()->current() }}" class="btn btn-soft w-100">
                            {{ d_trans('Reset') }}
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </div>
    </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <th><i class="fa-solid fa-hashtag"></i></th>
                    <th>{{ d_trans('Product') }}</th>
                    <th>{{ d_trans('Submitted by') }}</th>
                    <th class="text-center">{{ d_trans('Rating') }}</th>
                    <th class="text-center">{{ d_trans('Status') }}</th>
                    <th class="text-center">{{ d_trans('Submitted date') }}</th>
                    <th></th>
                </thead>
                <tbody>
                    @forelse ($reviews as $review)
                        @php
                            $user = $review->user;
                            $reviewer = $review->reviewer;
                            $product = $review->product;
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ route('admin.reviews.show', $review->id) }}">
                                    <i class="fa-solid fa-hashtag me-1"></i>{{ $review->id }}
                                </a>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <a href="{{ route('admin.products.show', $product->id) }}"
                                        class="item-img item-img-sm">
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                    </a>
                                    <div>
                                        <a href="{{ route('admin.products.show', $product->id) }}"
                                            class="item-title d-block fw-normal mb-0">
                                            {{ \Illuminate\Support\Str::words($product->name, 3, '...') }}
                                        </a>
                                        {{-- <p class="item-text text-muted small mb-0">
                                                {{ \Illuminate\Support\Str::words($product->description, 5, '...') }}
                                            </p> --}}
                                    </div>
                                    @if ($product->isFeatured())
                                        <span class="badge bg-c21">{{ d_trans('Featured') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if ($user)
                                    <div class="d-flex align-items-center gap-3">
                                        <a href="{{ route('admin.members.users.edit', $user->id) }}"
                                            class="item-img item-img-sm">
                                            <img src="{{ $user->getAvatar() }}" alt="{{ $user->getName() }}">
                                        </a>
                                        <div>
                                            <a href="{{ route('admin.members.users.edit', $user->id) }}"
                                                class="item-title d-block fw-normal mb-0">{{ $user->getName() }}</a>
                                            <p class="item-text text-muted small mb-0">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="item-img item-img-sm">
                                            <img src="{{ $reviewer->avatar }}" alt="{{ $reviewer->name }}">
                                        </div>
                                        <div>
                                            <div class="item-title d-block fw-normal mb-0">{{ $reviewer->name }}</div>
                                            <p class="item-text text-muted small mb-0">{{ $reviewer->email }}</p>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                {!! $review->renderStars() !!}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-warning">{{ $review->getStatusName() }}</span>
                            </td>
                            <td class="text-center">{{ dateFormat($review->created_at) }}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button class="dropdown-btn" type="button" id="dropdownMenuButton"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.reviews.show', $review->id) }}">
                                                <i class="fas fa-desktop"></i>{{ d_trans('Details') }}
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider" />
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.reviews.destroy', $review->id) }}"
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
    {{ $reviews->links() }}
@endsection
