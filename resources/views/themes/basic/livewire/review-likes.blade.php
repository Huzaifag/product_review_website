<button wire:click="toggleLike"
    class="btn {{ $liked ? 'btn-like' : '' }} btn-reset item-review-action d-flex align-items-center gap-2">
    <i class="bi {{ $liked ? 'bi-hand-thumbs-up-fill' : 'bi-hand-thumbs-up' }}"></i>
    <span>{{ d_trans('Useful (:likes)', ['likes' => $likes]) }}</span>
</button>
