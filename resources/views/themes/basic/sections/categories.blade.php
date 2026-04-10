@if ($categories->count() > 0)
    <section class="section">
        <div class="section-inner">
            <div class="section-header">
                <div class="container container-custom">
                    <div class="row align-items-center g-3">
                        <div class="col text-center text-lg-start">
                            <h4 class="section-title custom-title">{{ $homeSection->trans->name }}</h4>
                            @if ($homeSection->description)
                                <p class="section-text">{{ $homeSection->trans->description }}</p>
                            @endif
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <div class="swiper-actions d-flex gap-2">
                                <div class="swiper-button-prev home-categories-swiper-prev position-static"></div>
                                <div class="swiper-button-next home-categories-swiper-next position-static"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="swiper home-categories-swiper" data-aos="zoom-in-up" data-aos-duration="1000">
                    <div class="swiper-wrapper">
                        @foreach ($categories as $category)
                            <div class="swiper-slide h-auto">
                                <a href="{{ $category->getLink() }}"
                                    class="home-category home-category-primary box box-shadow">
                                    <div class="home-category-icon">
                                        <img loading="lazy" src="{{ $category->getImageLink() }}"
                                            alt="{{ $category->slug }}" />
                                    </div>
                                    <h5 class="home-category-title">{{ $category->trans->name }}</h5>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="section-footer d-block d-lg-none">
                <div class="d-flex justify-content-center">
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-primary btn-md px-5">
                        {{ d_trans('View All') }}<i class="fa-solid fa-arrow-right icon-rtl ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endif
