@extends('themes.basic.layouts.single')
@section('title', $product->name)
@section('header_title', $product->name)
@section('description', $product->description)
@section('keywords', $product->brand_name . ',' . $product->name)
@section('breadcrumbs', Breadcrumbs::render('products.show', $product))
@section('breadcrumbs_schema', Breadcrumbs::view('breadcrumbs::json-ld', 'products.show', $product))
@section('container', 'container-custom')
@section('header_v2', true)
@section('content')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="item-box box mb-4">
                <div class="item-box-body">
                    <div class="row g-4 align-items-start">
                        <div class="col-md-5">
                            <img src="{{ $product->getImageLink() }}" alt="{{ $product->name }}" class="img-fluid rounded-3">
                        </div>
                        <div class="col-md-7">
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge bg-primary">{{ d_trans('Product Details') }}</span>
                                @if ($product->is_featured)
                                    <span class="badge bg-success">{{ d_trans('Featured') }}</span>
                                @endif
                                @if ($product->lab_verified)
                                    <span class="badge bg-info">{{ d_trans('Lab Verified') }}</span>
                                @endif
                            </div>
                            <h2 class="h4 mb-3">{{ $product->name }}</h2>
                            <div class="row row-cols-1 row-cols-sm-2 g-3">
                                <div class="col">
                                    <small class="text-muted d-block">{{ d_trans('Brand') }}</small>
                                    <strong>{{ $product->brand_name ?? '-' }}</strong>
                                </div>
                                <div class="col">
                                    <small class="text-muted d-block">{{ d_trans('Category') }}</small>
                                    <strong>{{ $product->category->trans->name ?? d_trans('Uncategorized') }}</strong>
                                </div>
                                <div class="col">
                                    <small class="text-muted d-block">{{ d_trans('Sub Category') }}</small>
                                    <strong>{{ $product->subCategory->trans->name ?? '-' }}</strong>
                                </div>
                                <div class="col">
                                    <small class="text-muted d-block">{{ d_trans('Size') }}</small>
                                    <strong>{{ $product->product_size ?: '-' }}</strong>
                                </div>
                                <div class="col">
                                    <small class="text-muted d-block">{{ d_trans('Price') }}</small>
                                    <strong>
                                        @if ($product->price)
                                            {{ $product->currency }} {{ numberFormat($product->price) }}
                                        @else
                                            -
                                        @endif
                                    </strong>
                                </div>
                                <div class="col">
                                    <small class="text-muted d-block">{{ d_trans('Organic Certified') }}</small>
                                    <strong>{{ $product->organic_certified ? d_trans('Yes') : d_trans('No') }}</strong>
                                </div>
                                <div class="col">
                                    <small class="text-muted d-block">{{ d_trans('Overall Grade') }}</small>
                                    <strong>{{ $product->overall_grade ?: '-' }}</strong>
                                </div>
                                <div class="col">
                                    <small class="text-muted d-block">{{ d_trans('Total Reviews') }}</small>
                                    <strong>{{ numberFormat($product->approved_reviews_count) }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if ($product->description)
                <div class="item-box box mb-4">
                    <div class="item-box-header">
                        <h4 class="item-box-title mb-0">{{ d_trans('Description') }}</h4>
                    </div>
                    <div class="item-box-body">
                        <p class="mb-0 text-muted">{!! purifier($product->description) !!}</p>
                    </div>
                </div>
            @endif

            <div class="item-box box">
                <div class="item-box-header">
                    <h4 class="item-box-title mb-0">{{ d_trans('Ingredients') }}</h4>
                </div>
                <div class="item-box-body">
                    @if (count($product->getIngredientsList()) > 0)
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($product->getIngredientsList() as $ingredient)
                                <span class="badge text-bg-light border">{{ $ingredient }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">{{ d_trans('No ingredients listed') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @if ($relatedProducts->count() > 0)
                <div class="item-box box">
                    <div class="item-box-header">
                        <h4 class="item-box-title mb-0">{{ d_trans('Related Products') }}</h4>
                    </div>
                    <div class="item-box-body">
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                            @foreach ($relatedProducts as $relatedProduct)
                                <li>
                                    <a href="{{ $relatedProduct->getLink() }}"
                                        class="d-flex align-items-center gap-3 text-decoration-none">
                                        <img src="{{ $relatedProduct->getImageLink() }}"
                                            alt="{{ $relatedProduct->name }}" width="56" height="56"
                                            class="rounded-3 object-fit-cover">
                                        <div class="overflow-hidden">
                                            <h6 class="mb-1 text-truncate">{{ $relatedProduct->name }}</h6>
                                            <small class="text-muted d-block text-truncate">
                                                {{ $relatedProduct->brand_name }}
                                            </small>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
