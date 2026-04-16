<?php

namespace App\View\Components\Admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImageUploader extends Component
{
    public string $name;

    public string $accept;

    public bool $required;

    public ?string $src;

    public ?string $width;

    public ?string $height;

    public ?string $label;

    public string $description;

    public bool $upload;

    public string $version;

    public string $background;

    public function __construct(
        string $name = 'image',
        string $label = null,
        string $accept = '.png,.jpg,.jpeg , webp',
        bool $required = false,
        ?string $src = null,
        ?string $width = null,
        ?string $height = null,
        bool $upload = true,
        string $version = 'v2',
        string $background = '',
    ) {
        $this->name = $name;
        $this->label = $label ?? d_trans('Choose Image');
        $this->accept = $accept;
        $this->required = $required;
        $this->src = $src;
        $this->width = $width;
        $this->height = $height;
        $this->upload = $upload;
        $this->version = $version;
        $this->background = $background;

        $this->description = d_trans('Supported Types (:types)', ['types' => strtoupper($this->accept)]);
    }

    public function render(): View | Closure | string
    {
        return view('components.admin.image-uploader');
    }
}
