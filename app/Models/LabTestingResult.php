<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabTestingResult extends Model
{
    protected $fillable = [
        'product_id',
        'mineral_uv_filter',
        'concerning_uv_filter',
        'has_fragrance',
        'further_concerns',
        'further_concerns_detail',
        'ingredient_grade',
        'plastic_compounds',
        'further_defects',
        'further_defects_detail',
        'defects_grade',
        'overall_grade',
        'footnote_ref',
        'footnote_text',
        'test_summary',
        'tested_at',
        'lab_name',
    ];

    protected function casts(): array
    {
        return [
            'concerning_uv_filter' => 'boolean',
            'has_fragrance' => 'boolean',
            'further_concerns' => 'boolean',
            'plastic_compounds' => 'boolean',
            'further_defects' => 'boolean',
            'tested_at' => 'date',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
