<?php

namespace App\View\Components;

use App\Models\Advertisement;
use Illuminate\View\Component;

class Ad extends Component
{
    public $alias;

    public function __construct($alias)
    {
        $this->alias = $alias;
    }

    public function render()
    {
        $code = null;
        $ad = Advertisement::where('alias', $this->alias)
            ->active()->first();

        if ($ad) {
            $code = $ad->code;
        }

        return theme_view('components.ad', [
            'code' => $code,
        ]);
    }
}