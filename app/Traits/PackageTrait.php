<?php

namespace App\Traits;

use App\Models\Product;
//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
//use LaravelIdea\Helper\App\Models\_IH_Product_C;

trait PackageTrait
{
//    /**
//     * Filters Unsold Package
//     *
//     * @return _IH_Product_C|Collection|array
//     */
//    public function unsoldPackage(): _IH_Product_C|Collection|array
//    {
//        // Get the current user ID
//        $userId = Auth::id();
//
//        // Query to get packages that have not been ordered by the current user
//        return Product::query()
//            ->withAvg('reviews', 'rating')
//            ->withCount('reviews')
//            ->with(['variants', 'category', 'imageGallery', 'productType'])
//            ->where(['status' => 1, 'is_approved' => 1])
//            ->whereNotIn('id', function ($query) use ($userId) {
//                $query->select('product_id')
//                    ->from('order_products')
//                    ->join('orders', 'orders.id', '=', 'order_products.order_id')
//                    ->where('orders.user_id', '=', $userId);
//            })
//            ->get();
//    }

//    /**
//     * Filters Unsold Package
//     *
//     * @return _IH_Product_C|Collection|array
//     */
//    public function unsoldPackage(): _IH_Product_C|Collection|array
//    {
//        // Get the current user ID
//        $userId = Auth::id();
//
//        // Get the highest degree of product types bought by the user
//        $highestDegreeBought = DB::table('order_products')
//            ->join('orders', 'orders.id', '=', 'order_products.order_id')
//            ->join('products', 'products.id', '=', 'order_products.product_id')
//            ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
//            ->where('orders.user_id', $userId)
//            ->max('product_types.degree');
//
//        // Determine the target degree based on whether the user has bought anything
//        $targetDegree = is_null($highestDegreeBought) ? 1 : $highestDegreeBought + 1;
//
//        // Query to get packages that meet the criteria
//        return Product::query()
//            ->withAvg('reviews', 'rating')
//            ->withCount('reviews')
//            ->with(['variants', 'category', 'imageGallery', 'productType'])
//            ->whereHas('productType', function ($query) use ($targetDegree) {
//                $query->where('degree', $targetDegree);
//            })
//            ->where(['status' => 1, 'is_approved' => 1])
//            ->whereNotIn('id', function ($query) use ($userId) {
//                $query->select('product_id')
//                    ->from('order_products')
//                    ->join('orders', 'orders.id', '=', 'order_products.order_id')
//                    ->where('orders.user_id', '=', $userId);
//            })
//            ->get();
//    }

    /**
     * Filters Unsold Package
     *
     * @return \Illuminate\Support\Collection
     */
    public function unsoldPackage(): Collection
    {
        // Get the current user ID
        $userId = Auth::id();

        // Get the highest degree of product types bought by the user
        $highestDegreeBought = DB::table('order_products')
            ->join('orders', 'orders.id', '=', 'order_products.order_id')
            ->join('products', 'products.id', '=', 'order_products.product_id')
            ->join('product_types', 'product_types.id', '=', 'products.product_type_id')
            ->where('orders.user_id', $userId)
            ->max('product_types.degree');

        // Get the maximum degree available in product_types
        $maxDegree = DB::table('product_types')->max('degree');

        // Determine the target degree based on whether the user has bought anything
        $targetDegree = is_null($highestDegreeBought) ? 1 : $highestDegreeBought + 1;

        // If the target degree is greater than the maximum degree, return an empty collection
        if ($targetDegree > $maxDegree) {
            return collect([]);
        }

        // Query to get packages that meet the criteria
        return Product::query()
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->with(['variants', 'category', 'imageGallery', 'productType'])
            ->whereHas('productType', function ($query) use ($targetDegree) {
                $query->where('degree', $targetDegree);
            })
            ->where(['status' => 1, 'is_approved' => 1])
            ->whereNotIn('id', function ($query) use ($userId) {
                $query->select('product_id')
                    ->from('order_products')
                    ->join('orders', 'orders.id', '=', 'order_products.order_id')
                    ->where('orders.user_id', '=', $userId);
            })
            ->get();
    }
}
