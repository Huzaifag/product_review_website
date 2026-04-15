@if ($faqs->count() > 0)
    <section class="section home-modern-section home-faq-section">
        <div class="section-inner">
            <div class="container container-custom home-section-container">
                <div class="section-header text-center home-modern-header">
                    <p class="mag-label">{{ d_trans('Questions & Answers') }}</p>
                    <h4 class="mag-title">{{ $homeSection->trans->name }}</h4>
                    @if ($homeSection->description)
                        <p class="section-text col-lg-7 mx-auto home-modern-text">{{ $homeSection->trans->description }}</p>
                    @endif
                </div>
                <div class="section-body">
                    <div class="accordion accordion-custom home-modern-accordion" id="homeFaqAccordion">
                        <div class="row row-cols-1 g-3 justify-content-center">
                            @foreach ($faqs as $faq)
                                <div class="col col-xl-10" data-aos="fade-left"
                                    data-aos-duration="{{ ($loop->index + 1) * 100 }}">
                                    @include('themes.basic.partials.faq-accordion', [
                                        'faq' => $faq,
                                        'accordionId' => 'homeFaqAccordion',
                                    ])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="section-footer">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('faqs') }}" class="home-modern-btn">
                            {{ d_trans('View All') }}<i class="fa-solid fa-arrow-right icon-rtl ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
