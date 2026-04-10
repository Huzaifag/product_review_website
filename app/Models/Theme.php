<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'name',
        'alias',
        'version',
        'preview_image',
        'description',
    ];

    public function isActive()
    {
        return $this->alias == activeTheme();
    }

    public function getPreviewImageLink()
    {
        return asset($this->preview_image);
    }
}
