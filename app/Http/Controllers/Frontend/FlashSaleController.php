<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class FlashSaleController extends Controller
{
    /**
     * Display Flash Sale Main PAge
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $flash_sale = FlashSale::query()->first();

        $flash_sale_items = FlashSaleItem::query()
            ->where('status', '=', 1)
            ->pluck('product_id')->toArray();

        return view('frontend.pages.flash-sale', compact('flash_sale', 'flash_sale_items'));
    }
}
