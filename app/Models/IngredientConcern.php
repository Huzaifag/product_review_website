<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngredientConcern extends Model
{
    protected $fillable = [
        'product_id',
        'ingredient_library_id',
        'ingredient_name',
        'inci_name',
        'severity',
        'description',
        'concentration',
    ];

    protected function casts(): array
    {
        return [
            'concentration' => 'decimal:4',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function ingredientLibrary()
    {
        return $this->belongsTo(IngredientLibrary::class);
    }
}
