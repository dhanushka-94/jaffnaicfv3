<?php

namespace App\View\Components\Programme;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Gallery extends Component
{
    public function __construct(
        public string $title,
        public ?int $year = null,
        public bool $active = true,
        public $images = null,
        public ?string $description = null,
    ) {
    }

    public function render(): View|Closure|string
    {
        return view('programme._gallery');
    }
}


