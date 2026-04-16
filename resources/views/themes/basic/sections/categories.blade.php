@if ($categories->count() > 0)
<section class="section mag-section">
    @push('styles')
        <style>
            .mag-grid-wrap .mag-card {
                padding: 0.2rem 0.2rem 0.05rem;
            }

            .mag-grid-wrap .mag-icon-wrap {
                width: 82px;
                height: 82px;
                margin-bottom: 0.45rem;
            }

            .mag-grid-wrap .mag-card-name {
                font-size: 0.95rem;
                line-height: 1.15;
            }

            .mag-section .section-inner {
                position: relative;
            }

            .mag-section .mag-header {
                padding-bottom: 1rem;
            }

            /* Custom Cursor Styling */
            .mag-section .section-inner.cursor-left {
                cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='44' height='44' viewBox='0 0 44 44'%3E%3Ccircle cx='22' cy='22' r='21' fill='white' stroke='%23e5e7eb' stroke-width='1'/%3E%3Cpolyline points='24 28 18 22 24 16' fill='none' stroke='black' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") 22 22, auto;
            }

            .mag-section .section-inner.cursor-right {
                cursor: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='44' height='44' viewBox='0 0 44 44'%3E%3Ccircle cx='22' cy='22' r='21' fill='white' stroke='%23e5e7eb' stroke-width='1'/%3E%3Cpolyline points='20 28 26 22 20 16' fill='none' stroke='black' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") 22 22, auto;
            }

            /* Keep standard pointer on actual category links so users know they are clickable */
            .mag-section .section-inner .mag-card {
                cursor: pointer;
            }

            @media (min-width: 992px) {
                .mag-grid-wrap .row {
                    --bs-gutter-x: 1rem;
                    --bs-gutter-y: 1rem;
                }
            }
        </style>
    @endpush

    <div class="section-inner" id="mag-interactive-section">
        <div class="mag-header container container-custom">
            <div class="container mag-header-left">
                <span class="mag-label">Browse by Topic</span>
                <h2 class="mag-title">{{ $homeSection->trans->name }}</h2>
                @if ($homeSection->description)
                    <p class="mag-desc">{{ $homeSection->trans->description }}</p>
                @endif
            </div>
            
            @if ($categories->count() > 5)
            <div class="mag-header-meta d-none d-md-flex">
                <span class="mag-meta-pill">Editor's Selection</span>
                <span class="mag-meta-count">{{ $categories->count() }} Topics</span>
            </div>
            @endif
        </div>

        <div class="container section-body mag-grid-wrap">
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-2 justify-content-center" data-aos="zoom-in-up" data-aos-duration="1000">
                @foreach ($categories->take(12) as $category)
                    <div class="col">
                        <a href="{{ $category->getLink() }}" class="mag-card h-100">
                            <div class="mag-icon-wrap">
                                <img loading="lazy"
                                    src="{{ $category->getImageLink() }}"
                                    alt="{{ $category->slug }}" />
                            </div>
                            <span class="mag-card-name">{{ $category->trans->name }}</span>
                        </a>
                    </div>
                @endforeach
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const interactiveSection = document.getElementById('mag-interactive-section');

        if (interactiveSection) {
            // 1. Change cursor based on mouse position
            interactiveSection.addEventListener('mousemove', function(e) {
                const rect = interactiveSection.getBoundingClientRect();
                const mouseX = e.clientX - rect.left;

                // Check if mouse is on the left half or right half
                if (mouseX < rect.width / 2) {
                    interactiveSection.classList.remove('cursor-right');
                    interactiveSection.classList.add('cursor-left');
                } else {
                    interactiveSection.classList.remove('cursor-left');
                    interactiveSection.classList.add('cursor-right');
                }
            });

            // Clean up classes when mouse leaves the section entirely
            interactiveSection.addEventListener('mouseleave', function() {
                interactiveSection.classList.remove('cursor-left', 'cursor-right');
            });

            // 2. Handle the custom click actions since you removed the buttons
            interactiveSection.addEventListener('click', function(e) {
                // Ignore clicks if the user is actually clicking a category card
                if (e.target.closest('.mag-card') || e.target.closest('.mag-view-all')) {
                    return; 
                }

                const rect = interactiveSection.getBoundingClientRect();
                const mouseX = e.clientX - rect.left;

                if (mouseX < rect.width / 2) {
                    // LEFT SIDE CLICKED
                    // Insert your logic to slide left here. Example:
                    // swiperInstance.slidePrev();
                    console.log('Sliding Left'); 
                } else {
                    // RIGHT SIDE CLICKED
                    // Insert your logic to slide right here. Example:
                    // swiperInstance.slideNext();
                    console.log('Sliding Right');
                }
            });
        }
    });
</script>
@endpush
@endif