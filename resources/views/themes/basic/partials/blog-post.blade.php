<div class="blog-post">
    <div class="blog-post-header">
        <a href="{{ $blogArticle->getLink() }}" class="d-block">
            <img loading="lazy" src="{{ $blogArticle->getImageLink() }}" alt="{{ $blogArticle->title }}"
                class="blog-post-img">
        </a>
    </div>
    <div class="blog-post-body">
        <div class="blog-post-meta">
            <div class="row align-items-center gx-3 gy-2">
                <div class="col d-flex align-items-center text-muted small">
                    <i class="fa-regular fa-calendar me-2"></i>
                    <span>{{ dateFormat($blogArticle->created_at) }}</span>
                </div>
                <div class="col-auto">
                    @php
                        $blogCategory = $blogArticle->category;
                    @endphp
                    <a href="{{ $blogCategory->getLink() }}" class="blog-post-category">
                        {{ $blogCategory->name }}
                    </a>
                </div>
            </div>
        </div>
        <h4 class="blog-post-title">
            <a href="{{ $blogArticle->getLink() }}">{{ $blogArticle->title }}</a>
        </h4>
        <div class="blog-post-text mb-0">
            {{ $blogArticle->description }}
            <a href="{{ $blogArticle->getLink() }}">{{ d_trans('[Read more...]') }}</a>
        </div>
    </div>
</div>
