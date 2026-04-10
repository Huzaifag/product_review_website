@php
    $businesses = $homeSection->getBusinesses();
@endphp
@if ($businesses->count() > 0)
    <section class="section">
        <div class="section-inner">
            <div class="container container-custom">
                <div class="section-header">
                    <div class="row align-items-center g-3">
                        <div class="col text-center text-lg-start">
                            <h4 class="section-title custom-title">{{ $homeSection->trans->name }}</h4>
                            @if ($homeSection->description)
                                <p class="section-text col-lg-8">{{ $homeSection->trans->description }}</p>
                            @endif
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <a href="{{ $homeSection->getCategory()->getLink() }}" class="btn btn-outline-primary">
                                {{ d_trans('View All') }}<i class="fa-solid fa-arrow-right icon-rtl ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 row-cols-xxl-4 g-3">
                        @foreach ($homeSection->getBusinesses() as $business)
                            <div class="col" data-aos="fade-up" data-aos-duration="1000">
                                @include('themes.basic.partials.business', ['business' => $business])
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-4 d-lg-none">
                        <a href="{{ $homeSection->getCategory()->getLink() }}"
                            class="btn btn-outline-primary btn-md px-5">
                            {{ d_trans('View All') }}<i class="fa-solid fa-arrow-right icon-rtl ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
