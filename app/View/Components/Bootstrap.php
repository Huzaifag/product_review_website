<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Bootstrap extends Component
{
    public function render()
    {
        $file = config('system.rtl') && getDirection() == 'rtl' ? 'bootstrap-rtl.min.css' : 'bootstrap.min.css';
        $link = '<link rel="stylesheet" href="' . asset("vendor/libs/bootstrap/{$file}") . '">';

        return view('components.bootstrap', [
            'link' => $link,
        ]);
    }
}
