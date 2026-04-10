<?php

namespace App\Models;

use App\Models\Scopes\LanguageScope;
use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;

    private const PERMANENT_TEMPLATES = [
        'password_reset',
        'email_verification',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new LanguageScope);
    }

    public function scopeDisabled($query)
    {
        $query->where('status', self::STATUS_DISABLED);
    }

    public function isDisabled()
    {
        return $this->status == self::STATUS_DISABLED;
    }

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isPermanent()
    {
        return in_array($this->alias, self::PERMANENT_TEMPLATES);
    }

    protected $fillable = [
        'subject',
        'body',
        'status',
        'lang',
    ];

    protected function casts(): array
    {
        return [
            'shortcodes' => 'object',
            'status' => 'boolean',
        ];
    }

    public function getStatusName()
    {
        return self::getAvailableStatues()[$this->status];
    }

    public static function getAvailableStatues()
    {
        return [
            self::STATUS_ACTIVE => d_trans('Active'),
            self::STATUS_DISABLED => d_trans('Disabled'),
        ];
    }

}
