@if ($faqs->count() > 0)
    <section class="section">
        <div class="section-inner">
            <div class="container container-custom">
                <div class="section-header text-center">
                    <h4 class="section-title custom-title">{{ $homeSection->trans->name }}</h4>
                    @if ($homeSection->description)
                        <p class="section-text col-lg-7 mx-auto">{{ $homeSection->trans->description }}</p>
                    @endif
                </div>
                <div class="section-body">
                    <div class="accordion accordion-custom" id="accordion">
                        <div class="row row-cols-1 row-cols-xl-2 g-3">
                            @foreach ($faqs as $faq)
                                <div class="col" data-aos="fade-left"
                                    data-aos-duration="{{ ($loop->index + 1) * 100 }}">
                                    @include('themes.basic.partials.faq-accordion', ['faq' => $faq])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="section-footer">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('faqs') }}" class="btn btn-outline-primary btn-md px-5">
                            {{ d_trans('View All') }}<i class="fa-solid fa-arrow-right icon-rtl ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
