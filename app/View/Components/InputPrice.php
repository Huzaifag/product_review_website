<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputPrice extends Component
{
    public ?string $label;

    public ?string $size;

    public ?string $id;

    public ?string $name;

    public mixed $value;

    public bool $integer;

    public int|float|null $min;

    public int|float|null $max;

    public bool $disabled;

    public bool $required;

    public function __construct(
        ?string $label = null,
        ?string $size = '',
        ?string $id = null,
        ?string $name = null,
        mixed $value = null,
        bool $integer = false,
        int | float | null $min = null,
        int | float | null $max = null,
        bool $disabled = false,
        bool $required = false
    ) {
        $this->label = $label;
        $this->size = $size;
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
        $this->integer = $integer;
        $this->min = $min;
        $this->max = $max;
        $this->disabled = $disabled;
        $this->required = $required;
    }

    public function render(): View | Closure | string
    {
        return view('components.input-price');
    }
}