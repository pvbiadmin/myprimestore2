<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class PackageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $packages = Product::query()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->with(['variants', 'category', 'imageGallery'])
            ->where('status', 1)
            ->where('is_approved', 1)
            ->where('product_type', 'like', '%pack')
            ->get();

        return view('frontend.dashboard.packages.index', compact('packages'));
    }
}
