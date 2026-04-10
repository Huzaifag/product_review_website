<?php

namespace App\Models;

use App\Handlers\FileHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Business extends Model
{
    const UNVERIFIED = 0;
    const VERIFIED = 1;

    const NOT_TRENDING = 0;
    const TRENDING = 1;

    const NOT_BEST_RATING = 0;
    const BEST_RATING = 1;

    const NOT_FEATURED = 0;
    const FEATURED = 1;

    const STATUS_SUSPENDED = 0;
    const STATUS_ACTIVE = 1;

    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($business) {
            FileHandler::delete($business->logo);
        });
    }

    public function scopeSearch($query, $searchTerm, $searchTermStart)
    {
        return $query->where(function ($query) use ($searchTerm, $searchTermStart) {
            $query->where('name', 'like', $searchTermStart)
                ->orWhere('website', 'like', $searchTermStart)
                ->orWhere('domain', 'like', $searchTermStart)
                ->orWhere('email', 'like', $searchTermStart)
                ->orWhere('phone', 'like', $searchTermStart)
                ->orWhere('short_description', 'like', $searchTermStart)
                ->orWhere('description', 'like', $searchTermStart)
                ->orWhere('tags', 'like', $searchTermStart)
                ->orWhere(function ($query) use ($searchTerm) {
                    $query->where('name', 'like', $searchTerm)
                        ->orWhere('website', 'like', $searchTerm)
                        ->orWhere('domain', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm)
                        ->orWhere('phone', 'like', $searchTerm)
                        ->orWhere('short_description', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm)
                        ->orWhere('tags', 'like', $searchTerm)
                        ->orWhereHas('category', function ($query) use ($searchTerm) {
                            $query->where('name', 'like', $searchTerm)
                                ->orWhere('slug', 'like', $searchTerm)
                                ->orWhere('title', 'like', $searchTerm)
                                ->orWhere('description', 'like', $searchTerm)
                                ->orWhere('keywords', 'like', $searchTerm);
                        })
                        ->orWhereHas('subSubCategories.subCategory', function ($query) use ($searchTerm) {
                            $query->where('sub_categories.name', 'like', $searchTerm)
                                ->orWhere('sub_categories.slug', 'like', $searchTerm)
                                ->orWhere('sub_categories.title', 'like', $searchTerm)
                                ->orWhere('sub_categories.description', 'like', $searchTerm)
                                ->orWhere('sub_categories.keywords', 'like', $searchTerm);
                        })
                        ->orWhereHas('subSubCategories', function ($query) use ($searchTerm) {
                            $query->where('sub_sub_categories.name', 'like', $searchTerm)
                                ->orWhere('sub_sub_categories.slug', 'like', $searchTerm)
                                ->orWhere('sub_sub_categories.title', 'like', $searchTerm)
                                ->orWhere('sub_sub_categories.description', 'like', $searchTerm)
                                ->orWhere('sub_sub_categories.keywords', 'like', $searchTerm);
                        });
                });
        });
    }

    public function scopeVerified($query)
    {
        $query->where('is_verified', self::VERIFIED);
    }

    public function isVerified()
    {
        return $this->is_verified == self::VERIFIED;
    }

    public function scopeUnverified($query)
    {
        $query->where('is_verified', self::UNVERIFIED);
    }

    public function isUnverified()
    {
        return $this->is_verified == self::UNVERIFIED;
    }

    public function scopeSuspended($query)
    {
        $query->where('status', self::STATUS_SUSPENDED);
    }

    public function isSuspended()
    {
        return $this->status == self::STATUS_SUSPENDED;
    }

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function scopeClaimed($query)
    {
        $query->whereHas('owner');
    }

    public function isClaimed()
    {
        return $this->owner ? true : false;
    }

    public function scopeUnclaimed($query)
    {
        $query->whereDoesntHave('owner');
    }

    public function scopeTrending($query)
    {
        $query->where('is_trending', self::TRENDING);
    }

    public function isTrending()
    {
        return $this->is_trending == self::TRENDING;
    }

    public function scopeBestRating($query)
    {
        $query->where('is_best_rating', self::BEST_RATING);
    }

    public function isBestRating()
    {
        return $this->is_best_rating == self::BEST_RATING;
    }

    public function scopeFeatured($query)
    {
        $query->where('is_featured', self::FEATURED);
    }

    public function isFeatured()
    {
        return $this->is_featured == self::FEATURED;
    }

    public function hasOwner()
    {
        return $this->owner ? true : false;
    }

    public function hasCategory()
    {
        return $this->category ? true : false;
    }

    public function hasDataCompleted()
    {
        return $this->isVerified() && $this->hasDetailsCompleted() && $this->hasLogoCompleted() &&
        $this->hasSocialLinksCompleted() && $this->hasAddressCompleted();
    }

    public function hasDetailsCompleted()
    {
        return $this->name && $this->website && $this->category && $this->email
        && $this->phone && $this->short_description && $this->description;
    }

    public function hasLogoCompleted()
    {
        return $this->logo;
    }

    public function hasSocialLinksCompleted()
    {
        return $this->social_links;
    }

    public function hasAddressCompleted()
    {
        return $this->address_line_1 && $this->address_line_2
        && $this->city && $this->state && $this->zip && $this->country;
    }

    public function hasFeature($feature)
    {
        if (licenseType(2) && config('settings.subscription.status')) {
            $owner = $this->owner;
            if ($owner->isSubscribed()) {
                return $owner->subscription->plan->{$feature};
            }
        }

        return config("settings.business.default.{$feature}");
    }

    protected $fillable = [
        'name',
        'website',
        'domain',
        'logo',
        'email',
        'phone',
        'short_description',
        'description',
        'tags',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip',
        'country',
        'social_links',
        'is_verified',
        'is_trending',
        'is_best_rating',
        'is_featured',
        'total_reviews',
        'avg_ratings',
        'total_views',
        'current_month_views',
        'category_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'object',
            'is_verified' => 'boolean',
            'is_trending' => 'boolean',
            'is_best_rating' => 'boolean',
            'is_featured' => 'boolean',
            'total_reviews' => 'integer',
            'avg_ratings' => 'double',
            'total_views' => 'integer',
            'current_month_views' => 'integer',
            'status' => 'boolean',
        ];
    }

    public function getAddressAttribute()
    {

        return implode(', ', array_filter([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->zip,
            $this->getCountry(),
        ]));
    }

    public function getTransAttribute()
    {
        return (object) [
            'name' => m_trans($this->name),
            'short_description' => m_trans($this->short_description),
            'description' => $this->description ? m_trans($this->description) : null,
            'tags' => $this->tags ? m_trans($this->tags) : null,
        ];
    }

    public function getSubCategoriesAttribute()
    {
        return SubCategory::whereIn('id', function ($query) {
            $query->select('sub_category_id')
                ->from('sub_sub_categories')
                ->whereIn('id', function ($subQuery) {
                    $subQuery->select('sub_sub_category_id')
                        ->from('business_sub_sub_category')
                        ->where('business_id', $this->id);
                });
        })->get();
    }

    public function getCountry()
    {
        return $this->country ? countries($this->country) : null;
    }

    public function getLogoLink()
    {
        if ($this->logo) {
            return asset($this->logo);
        }

        return asset(config('settings.business.media.default_logo'));
    }

    public function getLink()
    {
        return route('businesses.show', $this->domain);
    }

    public function getWriteReviewLink()
    {
        return route('businesses.review.create', $this->domain);
    }

    public function getDomainVerificationKey($suffix = null)
    {
        $key = Str::slug(m_trans(config('settings.general.site_name'))) . '-' . Str::slug($this->name) . '-' . hash_encode($this->id);

        if ($suffix) {
            $key = $key . '-' . $suffix;
        }

        return $key;
    }

    public function getFirstCategories()
    {
        $linkedSubSubs = $this->subSubCategories()->with('subCategory')->get();

        $grouped = $linkedSubSubs->groupBy(function ($subSub) {
            return $subSub->sub_category_id;
        })->filter();

        $firstGroup = $grouped->first();

        if (!$firstGroup) {
            return null;
        }

        $subCategory = $firstGroup->first()->subCategory;

        return (object) [
            'subCategory' => $subCategory,
            'subSubCategories' => $firstGroup,
        ];
    }

    public function getAvgRatingImageLink($avg = null)
    {
        $avg = $avg ?? $this->avg_ratings;
        if (empty($avg) || $avg < 1) {
            return asset(config('theme.settings.stars.stars_0'));
        }

        $rating = floor($avg * 2) / 2;

        $rating = min(5, $rating);

        $key = fmod($rating, 1) === 0.0
        ? (string) intval($rating)
        : str_replace('.', '_', number_format($rating, 1));

        return asset(config("theme.settings.stars.stars_{$key}"));
    }

    public function getGoogleMapAddress()
    {
        if ($this->hasAddressCompleted()) {
            $encodedAddress = urlencode($this->address);
            return "https://www.google.com/maps/search/?api=1&query={$encodedAddress}";
        }

        return null;
    }

    public function getReviewStarStats()
    {
        $publishedReviews = $this->reviews()->published()->get();
        $total = $publishedReviews->count();

        $counts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

        foreach ($publishedReviews as $review) {
            if (isset($counts[$review->stars])) {
                $counts[$review->stars]++;
            }
        }

        $percentages = collect($counts)->map(function ($count) use ($total) {
            return $total > 0 ? round(($count / $total) * 100) : 0;
        });

        return [
            'counts' => $counts,
            'percentages' => $percentages,
            'total' => $total,
        ];
    }

    public function updateReviewStats()
    {
        $stats = $this->reviews()
            ->published()
            ->selectRaw('COUNT(*) as total, AVG(stars) as average')
            ->first();

        $this->update([
            'total_reviews' => $stats->total ?? 0,
            'avg_ratings' => round($stats->average ?? 0, 1),
        ]);
    }

    public function getStatusName()
    {
        return self::getAvailableStatuses()[$this->status];
    }

    public static function getAvailableStatuses()
    {
        return [
            self::STATUS_ACTIVE => d_trans('Active'),
            self::STATUS_SUSPENDED => d_trans('Suspended'),
        ];
    }

    public function getVerificationStatusName()
    {
        return self::getAvailableVerificationStatuses()[$this->is_verified];
    }

    public static function getAvailableVerificationStatuses()
    {
        return [
            self::VERIFIED => d_trans('Verified'),
            self::UNVERIFIED => d_trans('Unverified'),
        ];
    }

    public function owner()
    {
        return $this->belongsTo(BusinessOwner::class, 'business_owner_id');
    }

    public function owners()
    {
        return $this->belongsToMany(BusinessOwner::class)
            ->using(BusinessOwnerPivot::class)
            ->withPivot('role')
            ->withTimestamps();
    }

    public function admins()
    {
        return $this->owners()->wherePivot('role', 'admin');
    }

    public function employees()
    {
        return $this->owners()->wherePivot('role', 'employee');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subSubCategories()
    {
        return $this->belongsToMany(SubSubCategory::class, 'business_sub_sub_category');
    }

    public function reviews()
    {
        return $this->hasMany(BusinessReview::class);
    }

    public function views()
    {
        return $this->hasMany(BusinessView::class);
    }
}
