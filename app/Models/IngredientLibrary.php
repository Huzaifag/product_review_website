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
        'description',
        'health_effects',
        'regulatory_status',
        'cas_number',
        'found_in_count',
        'is_published',
        'oko_verified',
        'hazard_score',
        'concerns',
        'functions',
        'synonyms',
        'concern_flags',
        'image_url',
        'source',
        'inhalation_risk_flag',
    ];

    protected function casts(): array
    {
        return [
            'found_in_count'      => 'integer',
            'is_published'        => 'boolean',
            'oko_verified'        => 'boolean',
            'hazard_score'        => 'integer',
            'concerns'            => 'array',
            'functions'           => 'array',
            'synonyms'            => 'array',
            'concern_flags'       => 'array',
            'inhalation_risk_flag' => 'boolean',
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

    public function products()
    {
        return $this->belongsToMany(Product::class, 'ingredient_library_product');
    }
}
