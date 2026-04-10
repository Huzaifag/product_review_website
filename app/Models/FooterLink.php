<?php

namespace App\Models;

use App\Models\Scopes\LanguageScope;
use App\Models\Scopes\NestableScope;
use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    const TYPE_INTERNAL = 1;
    const TYPE_EXTERNAL = 2;

    protected static function booted()
    {
        static::addGlobalScope(new LanguageScope);
        static::addGlobalScope(new NestableScope);
    }

    public function isInternal()
    {
        return $this->type == self::TYPE_INTERNAL;
    }

    public function isExternal()
    {
        return $this->type == self::TYPE_EXTERNAL;
    }

    protected $fillable = [
        'name',
        'link',
        'type',
        'parent_id',
        'lang',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
            'type' => 'integer',
        ];
    }

    public static function getAvailableTypes()
    {
        return [
            self::TYPE_INTERNAL => d_trans('Internal'),
            self::TYPE_EXTERNAL => d_trans('External'),
        ];
    }

    public function children()
    {
        return $this->hasMany(FooterLink::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(FooterLink::class, 'parent_id');
    }
}
