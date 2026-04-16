@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Products'))
@section('title', d_trans('Create Product'))
@section('header_title', d_trans('Create Product'))
@section('back', route('admin.products.index'))
@section('content')
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">{{ d_trans('New Product') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.products.partials.form', [
                    'buttonLabel' => d_trans('Create Product'),
                    'brands' => $brands,
                    'categories' => $categories,
                    'subcategories' => $subCategories,
                    'ingredientLibraries' => $ingredientLibraries,
                    'grades' => $grades
                ])
            </form>
        </div>
    </div>
@endsection
