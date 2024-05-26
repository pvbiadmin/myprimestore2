<?php

namespace App\Traits;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use LaravelIdea\Helper\App\Models\_IH_Product_C;

trait PackageTrait
{
    /**
     * Filters Unsold Package
     *
     * @return _IH_Product_C|Collection|array
     */
    public function unsoldPackage(): _IH_Product_C|Collection|array
    {
        // Get the current user ID
        $userId = Auth::id();

        // Query to get packages that have not been ordered by the current user
        return Product::query()
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
    }
}
