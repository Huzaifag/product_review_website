<?php

namespace App\Models;

use App\BusinessRole;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BusinessOwnerPivot extends Pivot
{
    protected $casts = [
        'role' => BusinessRole::class,
    ];
}
