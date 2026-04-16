@extends('admin.layouts.app')
@section('container', 'dashboard-container-xl')
@section('section', d_trans('Products'))
@section('title', d_trans('Edit Product'))
@section('header_title', d_trans('Edit :product_name', ['product_name' => $product->name]))
@section('back', route('admin.products.index'))
@section('content')
    @include('admin.products.includes.tabs')
    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">{{ d_trans('Edit Product') }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.products.partials.form', ['buttonLabel' => d_trans('Save Changes') , ['brands' => $brands, 'categories' => $categories, 'subcategories' => $subcategories]])
            </form>
        </div>
    </div>
@endsection
