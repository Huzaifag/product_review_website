<?php

namespace App\Livewire;

use App\Models\BusinessReview;
use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class ReviewLikes extends Component
{
    public $reviewId;
    public $likes = 0;
    public $liked = false;

    public function mount($reviewId)
    {
        $this->reviewId = $reviewId;

        $review = BusinessReview::published()->where('id', $reviewId)->firstOrFail();
        $this->likes = $review->likes ?? 0;

        $likedReviews = json_decode(Cookie::get('liked_reviews', '[]'), true);
        $this->liked = in_array($reviewId, $likedReviews);
    }

    public function toggleLike()
    {
        $review = BusinessReview::published()->where('id', $this->reviewId)->firstOrFail();

        $likedReviews = json_decode(Cookie::get('liked_reviews', '[]'), true);

        if ($this->liked) {
            $review->likes = max(0, $review->likes - 1);
            $likedReviews = array_diff($likedReviews, [$this->reviewId]);
            $this->liked = false;
        } else {
            $review->likes += 1;
            $likedReviews[] = $this->reviewId;
            $likedReviews = array_unique($likedReviews);
            $this->liked = true;
        }

        $review->save();
        $this->likes = $review->likes;

        Cookie::queue('liked_reviews', json_encode($likedReviews), 60 * 24 * 30);
    }

    public function render()
    {
        return theme_view('livewire.review-likes');
    }
}
