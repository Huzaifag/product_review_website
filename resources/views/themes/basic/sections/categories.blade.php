@if ($categories->count() > 0)
<section class="section mag-section">
    <div class="section-inner">
        <div class="mag-header container container-custom">
            <div class="mag-header-left">
                <span class="mag-label">Browse by Topic</span>
                <h2 class="mag-title">{{ $homeSection->trans->name }}</h2>
                @if ($homeSection->description)
                    <p class="mag-desc">{{ $homeSection->trans->description }}</p>
                @endif
            </div>
            <div class="mag-header-meta d-none d-md-flex">
                <span class="mag-meta-pill">Editor's Selection</span>
                <span class="mag-meta-count">{{ $categories->count() }} Topics</span>
            </div>
            <div class="mag-nav-arrows d-none d-lg-flex">
                <div class="mag-arrow home-categories-swiper-prev">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"/>
                    </svg>
                </div>
                <div class="mag-arrow home-categories-swiper-next">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="section-body mag-grid-wrap">
            <div class="swiper home-categories-swiper" data-aos="zoom-in-up" data-aos-duration="1000">
                <div class="swiper-wrapper">
                    @foreach ($categories as $category)
                        <div class="swiper-slide h-auto">
                            <a href="{{ $category->getLink() }}" class="mag-card">
                                <div class="mag-card-accent"></div>
                                <span class="mag-card-index">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                                <div class="mag-icon-wrap">
                                    <img loading="lazy"
                                        src="{{ $category->getImageLink() }}"
                                        alt="{{ $category->slug }}" />
                                </div>
                                <span class="mag-card-name">{{ $category->trans->name }}</span>
                                @if (!empty($category->trans->description))
                                    <span class="mag-card-description">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($category->trans->description), 95) }}
                                    </span>
                                @endif
                                <span class="mag-card-link">
                                    {{ d_trans('Explore') }}
                                    <i class="bi bi-arrow-up-right"></i>
                                </span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mag-footer d-block d-lg-none">
            <a href="{{ route('categories.index') }}" class="mag-view-all">
                {{ d_trans('View All') }}
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"/>
                    <polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endif