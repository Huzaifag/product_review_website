<div class="accordion-item">
    <h2 class="accordion-header" id="heading{{ $faq->id }}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapse{{ $faq->id }}" aria-expanded="true" aria-controls="collapse{{ $faq->id }}">
            <span> {{ $faq->title }}</span>
            <div class="accordion-button-icon">
                <i class="bi bi-chevron-down"></i>
            </div>
        </button>
    </h2>
    <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="headingOne"
        data-bs-parent="#accordion">
        <div class="accordion-body">
            {!! $faq->body !!}
        </div>
    </div>
</div>
