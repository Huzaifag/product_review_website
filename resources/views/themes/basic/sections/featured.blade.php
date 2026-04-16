@if ($featuredSection && $featuredProducts->count() > 0)
    <section class="section featured-luxe-section" id="featured-products">
        <div class="section-inner">
            <div class="container container-custom home-section-container">
                <div class="section-header featured-luxe-header">
                    <div class="row align-items-center g-3 featured-luxe-header-row">
                        <div class="col text-center text-lg-start featured-luxe-header-main">
                            <span class="mag-label">Browse Products</span>
                            <h2 class="mag-title">{{ $featuredSection->trans->name }}</h2>
                            @if ($featuredSection->description)
                                <p class="section-text col-lg-8 featured-luxe-text">
                                    {{ $featuredSection->trans->description }}</p>
                            @endif
                        </div>
                        <div class="col-auto d-none d-lg-flex align-items-center gap-3">
                            <span class="featured-luxe-count">{{ $featuredProducts->count() }} Curated</span>
                            <a href="#featured-products" class=" featured-luxe-btn">
                                {{ d_trans('Explore Products') }}<i class="fa-solid fa-arrow-right icon-rtl ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="section-body featured-luxe-body">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 row-cols-xxl-3 g-4 featured-luxe-grid">
                        @foreach ($featuredProducts as $product)
                            @php
                                $imagePath = $product->image ?: optional($product->images()->select('path')->first())->path;
                                $imageSrc = $imagePath ? asset($imagePath) : asset(config('theme.settings.general.social_image'));
                            @endphp
                            <div class="col" data-aos="fade-up" data-aos-duration="1000">
                                 @include('themes.basic.partials.product', [
                                    'product' => $product,
                                    'item_footer' => true,
                                ])
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-4 d-lg-none">
                        <a href="#featured-products" class="btn btn-outline-primary btn-md px-5 featured-luxe-btn">
                            {{ d_trans('Explore Products') }}<i class="fa-solid fa-arrow-right icon-rtl ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
