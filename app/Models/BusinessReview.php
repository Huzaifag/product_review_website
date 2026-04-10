<?php

namespace App\Models;

use App\Classes\AvatarGenerator;
use Illuminate\Database\Eloquent\Model;

class BusinessReview extends Model
{
    const STATUS_PENDING = 1;
    const STATUS_PUBLISHED = 2;

    public static function booted()
    {
        static::saved(function ($review) {
            if ($review->isPublished()) {
                $review->business?->updateReviewStats();
                $review->user?->updateReviewStats();
            }
        });

        static::updated(function ($review) {
            if ($review->isPublished()) {
                $review->business?->updateReviewStats();
                $review->user?->updateReviewStats();
            }
        });

        static::deleted(function ($review) {
            if ($review->isPublished()) {
                $review->business?->updateReviewStats();
                $review->user?->updateReviewStats();
            }
        });
    }

    public function scopeSearch($query, $searchTerm, $searchTermStart)
    {
        return $query->where(function ($query) use ($searchTerm, $searchTermStart) {
            $query->where('title', 'like', $searchTermStart)
                ->orWhere('body', 'like', $searchTermStart)
                ->orWhere('name', 'like', $searchTermStart)
                ->orWhere(function ($query) use ($searchTerm, $searchTermStart) {
                    $query->where('title', 'like', $searchTermStart)
                        ->orWhere('body', 'like', $searchTermStart)
                        ->orWhere('name', 'like', $searchTermStart)
                        ->orWhere('email', 'like', $searchTermStart)
                        ->orWhereHas('reply', function ($query) use ($searchTerm) {
                            $query->where('body', 'like', $searchTerm);
                        })
                        ->orWhereHas('user', function ($query) use ($searchTerm) {
                            $query->where('firstname', 'like', $searchTerm)
                                ->orWhere('lastname', 'like', $searchTerm)
                                ->orWhere('username', 'like', $searchTerm);
                        });
                });
        });
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function isPublished()
    {
        return $this->status === self::STATUS_PUBLISHED;
    }

    public function scopeForCurrentUser($query)
    {
        $authUser = authUser();

        return $query->where(function ($q) use ($authUser) {
            if ($authUser) {
                $q->where('user_id', $authUser->id);
            } else {
                $q->whereNull('user_id')->where('ip_address', getIp());
            }
        });
    }

    public function isForCurrentUser()
    {
        if ($this->user) {
            $authUser = authUser();
            return $authUser && $this->user->id == $authUser->id;
        }

        return $this->ip_address == getIp();
    }

    public function hasReply()
    {
        return $this->reply ? true : false;
    }

    protected $fillable = [
        'title',
        'body',
        'experience_date',
        'stars',
        'name',
        'email',
        'likes',
        'status',
        'ip_address',
        'user_id',
        'business_id',
    ];

    protected function casts(): array
    {
        return [
            'experience_date' => 'datetime',
            'stars' => 'integer',
            'likes' => 'integer',
            'status' => 'integer',
        ];
    }

    public function getTransAttribute()
    {
        return (object) [
            'title' => m_trans($this->title),
            'body' => m_trans($this->body),
        ];
    }

    public function getLink()
    {
        return route('businesses.review.show', [$this->business->domain, $this->id]);
    }

    public function getRatingImageLink()
    {
        return $this->business->getAvgRatingImageLink($this->stars);
    }

    public function getReviewerAttribute()
    {
        $user = $this->user;

        $name = $user ? $user->getName() : $this->name;
        $email = $user ? $user->email : $this->email;
        $avatar = $user ? $user->getAvatar() : AvatarGenerator::uiAvatar($this->email);
        $profileLink = $user ? $user->getProfileLink() : null;

        return (object) [
            'name' => $name,
            'email' => $email,
            'avatar' => $avatar,
            'profile_link' => $profileLink,
        ];
    }

    public function getStatusName()
    {
        return self::getAvailableStatuses()[$this->status];
    }

    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_PENDING => d_trans('Pending'),
            self::STATUS_PUBLISHED => d_trans('Published'),
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function reply()
    {
        return $this->hasOne(BusinessReviewReply::class, 'business_review_id');
    }
}
