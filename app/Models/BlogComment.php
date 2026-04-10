<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;

    public function scopePending($query)
    {
        $query->where('status', self::STATUS_PENDING);
    }

    public function isPending()
    {
        return $this->status == self::STATUS_PENDING;
    }

    public function scopePublished($query)
    {
        $query->where('status', self::STATUS_PUBLISHED);
    }

    public function isPublished()
    {
        return $this->status == self::STATUS_PUBLISHED;
    }

    protected $fillable = [
        'user_id',
        'body',
        'status',
        'blog_article_id',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
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

    public function article()
    {
        return $this->belongsTo(BlogArticle::class, 'blog_article_id');
    }
}
