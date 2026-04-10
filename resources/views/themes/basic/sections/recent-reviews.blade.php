@if ($recentReviewsSection && $recentReviews->count() > 0)
    <section class="section">
        <div class="section-inner">
            <div class="container container-custom">
                <div class="section-header">
                    <div class="row row-cols-lg-auto justify-content-between g-3">
                        <div class="col text-center text-lg-start">
                            <h4 class="section-title custom-title">{{ $recentReviewsSection->trans->name }}</h4>
                            @if ($recentReviewsSection->description)
                                <p class="section-text col-lg-8">{{ $recentReviewsSection->trans->description }}</p>
                            @endif
                        </div>
                        <div class="col d-none d-lg-block">
                            <div class="swiper-actions d-flex gap-2">
                                <div class="swiper-button-prev reviews-swiper-prev position-static"></div>
                                <div class="swiper-button-next reviews-swiper-next position-static"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="swiper reviews-swiper">
                        <div class="swiper-wrapper" data-aos="fade-up" data-aos-duration="1000">
                            @foreach ($recentReviews as $recentReview)
                                <div class="swiper-slide h-auto">
                                    @include('themes.basic.partials.review-box', [
                                        'review' => $recentReview,
                                        'review_box_footer' => true,
                                    ])
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="swiper-actions d-flex d-lg-none justify-content-end gap-2 mt-4">
                        <div class="swiper-button-prev reviews-swiper-prev position-static"></div>
                        <div class="swiper-button-next reviews-swiper-next position-static"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
