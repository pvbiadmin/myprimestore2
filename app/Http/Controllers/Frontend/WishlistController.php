<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * View Wishlist Page
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $wishlist_products = Wishlist
            ::with('product')
            ->where(['user_id' => Auth::user()->id])
            ->orderBy('id', 'DESC')
            ->get();

        return view('frontend.pages.wishlist', compact('wishlist_products'));
    }

    /**
     * Add product to wishlist
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function addToWishlist(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        if (!Auth::check()) {
            return response([
                'status' => 'error',
                'message' => 'Login required'
            ]);
        }

        $addedToWishlist = Wishlist::query()->where([
                'product_id' => $request->productId,
                'user_id' => Auth::user()->id
            ])->count() > 0;

        if ($addedToWishlist) {
            return response([
                'status' => 'info',
                'message' => 'Already added to wishlist'
            ]);
        }

        $wishlist = new Wishlist();

        $wishlist->product_id = $request->productId;
        $wishlist->user_id = Auth::user()->id;

        $wishlist->save();

        $count = Wishlist::query()->where(['user_id' => Auth::user()->id])->count();

        return response([
            'status' => 'success',
            'message' => 'Added to wishlist',
            'count' => $count
        ]);
    }

    /**
     * Remove product from wishlist
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id): RedirectResponse
    {
        $wishlist_products = Wishlist::query()->where(['id' => $id])->firstOrFail();

        if ($wishlist_products->user_id !== Auth::user()->id) {
            return redirect()->back();
        }

        $wishlist_products->delete();

        /*toastr('Product removed successfully', 'success', 'success');*/

        return redirect()->back()->with([
            'message' => 'Product removed from wishlist',
            'alert-type' => 'info'
        ]);
    }
}
