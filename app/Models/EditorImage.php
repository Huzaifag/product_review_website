<?php

namespace App\Models;

use App\Handlers\FileHandler;
use Illuminate\Database\Eloquent\Model;

class EditorImage extends Model
{
    protected $fillable = [
        'name',
        'path',
    ];

    public function getLink()
    {
        return asset($this->path);
    }

    public function deleteImage()
    {
        FileHandler::delete($this->path);
        $this->delete();
    }
}
