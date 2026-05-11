
@if ($sub_categories->count() > 0)
    <div class="sub-categories my-4">
        <h4 class="sub-categories-title">{{ d_trans('Sub Categories') }}</h4>
    </div>
    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3 mb-4">
        @foreach ($sub_categories as $sub_category)
            <div class="col">
                <a href="{{ $sub_category->getLink() }}" class="sub-category-card h-100 d-block text-center p-2 border rounded">
                    <img src="{{ $sub_category->getImageLink() }}" alt="{{ $sub_category->trans->title ?? $sub_category->trans->name }}" class="sub-category-image mb-2">
                    <h5 class="sub-category-name mb-0">{{ $sub_category->trans->title ?? $sub_category->trans->name }}</h5>
                </a>
            </div>
        @endforeach
    </div>
@endif

@push('styles')
    <style>
        .sub-category-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .sub-category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .sub-category-image {
            width: 100%;
            height: auto;
            max-height: 80px;
            object-fit: contain;
        }
        .sub-category-name {
            font-size: 0.9rem;
            color: #333;
        }

    </style>
@endpush