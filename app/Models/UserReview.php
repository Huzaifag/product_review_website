<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserReview extends Model
{
	use SoftDeletes;

	//Rating scales

	const Failing = 1;
	const Poor = 2;
	const Average = 3;
	const Good = 4;
	const Excellent = 5;

	protected $fillable = [
		'product_id',
		'user_id',
		'title',
		'rating',
		'body',
		'is_helpful',
		'helpful_count',
		'is_approved',
		'is_flagged',
	];

	protected function casts(): array
	{
		return [
			'is_helpful' => 'boolean',
			'helpful_count' => 'integer',
			'is_approved' => 'boolean',
			'is_flagged' => 'boolean',
		];
	}

	public function scopeApproved($query)
	{
		return $query->where('is_approved', true);
	}

	public function scopeFlagged($query)
	{
		return $query->where('is_flagged', true);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}


	// based on this &#127775; render star rating in views
	public function renderStars()
	{
		$fullStars = floor($this->rating);
		$halfStar = $this->rating - $fullStars >= 0.5;
		$emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
		$starsHtml = str_repeat('<i class="fas fa-star text-warning"></i>', $fullStars);
		if ($halfStar) {
			$starsHtml .= '<i class="fas fa-star-half-alt text-warning"></i>';
		}
		$starsHtml .= str_repeat('<i class="far fa-star text-warning"></i>', $emptyStars);
		return $starsHtml;	
	}

	//getStatusName
	public function getStatusName()
	{
		if ($this->is_approved) {
			return 'Approved';
		} elseif ($this->is_flagged) {
			return 'Flagged';
		} else {
			return 'Pending';
		}
	}
}
