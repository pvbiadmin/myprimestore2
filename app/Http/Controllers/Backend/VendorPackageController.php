<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class VendorPackageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        // Get the current user ID
        $userId = Auth::id();

        // Query to get packages that have not been ordered by the current user
        $packages = Product::query()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->with(['variants', 'category', 'imageGallery'])
            ->where('status', 1)
            ->where('is_approved', 1)
            ->where('product_type', 'like', '%pack')
            ->whereNotIn('id', function ($query) use ($userId) {
                $query->select('product_id')
                    ->from('order_products')
                    ->join('orders', 'orders.id', '=', 'order_products.order_id')
                    ->where('orders.user_id', '=', $userId);
            })
            ->get();

//        dd($packages);

        return view('vendor.packages.index', compact('packages'));
    }
}
