<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ProductCardList extends Component
{
    public $product;
    public $section;

    /**
     * Create a new component instance.
     */
    public function __construct($product, $section = '')
    {
        $this->product = $product;
        $this->section = $section;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.product-card-list');
    }
}
