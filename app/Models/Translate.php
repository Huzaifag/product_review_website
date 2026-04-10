<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translate extends Model
{
    const TYPE_DYNAMIC = 'dynamic';
    const TYPE_MANUAL = 'manual';

    public $timestamps = false;

    public function scopeDynamic($query)
    {
        $query->where('type', self::TYPE_DYNAMIC);
    }

    public function scopeManual($query)
    {
        $query->where('type', self::TYPE_MANUAL);
    }

    public function isDynamic()
    {
        return $this->type == self::TYPE_DYNAMIC;
    }

    public function isManual()
    {
        return $this->type == self::TYPE_MANUAL;
    }

    protected $fillable = [
        'key',
        'value',
        'type',
        'lang',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'lang', 'code');
    }
}