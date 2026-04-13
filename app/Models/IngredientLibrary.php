<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class IngredientLibrary extends Model
{
    use Sluggable;

    protected $table = 'ingredients_library';

    protected $fillable = [
        'name',
        'inci_name',
        'slug',
        'severity',
        'concern_description',
        'health_effects',
        'regulatory_status',
        'cas_number',
        'found_in_count',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'found_in_count' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function ingredientConcerns()
    {
        return $this->hasMany(IngredientConcern::class);
    }
}
