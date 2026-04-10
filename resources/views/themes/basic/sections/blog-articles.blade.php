@if (config('settings.actions.blog') && $blogArticles->count() > 0)
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
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3">
                        @foreach ($blogArticles as $blogArticle)
                            <div class="col" data-aos="fade-right" data-aos-duration="1000"
                                data-aos-delay="{{ ($loop->index + 1) * 100 }}">
                                @include('themes.basic.partials.blog-post', [
                                    'blogArticle' => $blogArticle,
                                ])
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="section-footer">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('blog.index') }}" class="btn btn-outline-primary btn-md px-5">
                            {{ d_trans('View All') }}<i class="fa-solid fa-arrow-right icon-rtl ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
