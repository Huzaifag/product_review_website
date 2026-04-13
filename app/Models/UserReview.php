<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserReview extends Model
{
	use SoftDeletes;

	protected $fillable = [
		'product_id',
		'user_id',
		'title',
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
}
