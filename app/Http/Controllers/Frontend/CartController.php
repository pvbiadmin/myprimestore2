<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariantOption;
use App\Models\Referral;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Vinkla\Hashids\Facades\Hashids;

class CartController extends Controller
{
    /**
     * Add products to Cart
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function addToCart(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');
        $variant_options = $request->input('variant_options');
        $is_package = $request->input('is_package');

        $product = Product::query()->findOrFail($product_id);

        if ($product->quantity === 0) {
            return response([
                'status' => 'error',
                'message' => 'Product Out of Stock.'
            ]);
        }

        if ($product->quantity < $quantity) {
            return response([
                'status' => 'error',
                'message' => 'Product Short of Stock.'
            ]);
        }

        $variants = [];

        $variant_price_total = 0;

        if ($request->has('variant_options')) {
            foreach ($variant_options as $option_id) {
                $variant_option = ProductVariantOption::query()->find($option_id);

                $variants[$variant_option->productVariant->name]['name'] = $variant_option->name;
                $variants[$variant_option->productVariant->name]['price'] = $variant_option->price;

                $variant_price_total += $variant_option->price;
            }
        }

        $product_price = hasDiscount($product) ? $product->offer_price : $product->price;

        $cart_data = [];

        $cart_data['id'] = $product->id;
        $cart_data['name'] = $product->name;
        $cart_data['qty'] = $quantity;
        $cart_data['price'] = $product_price;
        $cart_data['weight'] = 10;
        $cart_data['options']['variants'] = $variants;
        $cart_data['options']['variant_price_total'] = $variant_price_total;
        $cart_data['options']['image'] = $product->thumb_image;
        $cart_data['options']['slug'] = $product->slug;
        $cart_data['options']['is_package'] = $is_package;

        Cart::add($cart_data);

        return response([
            'status' => 'success',
            'message' => 'Product Added to Cart.'
        ]);
    }

    /**
     * View Cart Page
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     * @throws \JsonException
     */
    public function cartDetails(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $cart_items = Cart::content();

        if (count($cart_items) === 0) {
            Session::forget('coupon');
        }

        $cart_page_banner_section = Advertisement::where('key', 'cart_page_banner_section')->first();
        $cart_page_banner_section = json_decode(
            $cart_page_banner_section?->value, false, 512, JSON_THROW_ON_ERROR);

        return view('frontend.pages.cart-detail',
            compact('cart_items', 'cart_page_banner_section'));
    }

    /**
     * Update Product Quantity
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function updateProductQty(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $rowId = $request->input('rowId');
        $quantity = $request->input('quantity');

        $product_id = Cart::get($rowId)->id;

        $product = Product::query()->findOrFail($product_id);

        if ($product->quantity === 0) {
            return response([
                'status' => 'error',
                'message' => 'Product Out of Stock.'
            ]);
        }

        if ($product->quantity < $quantity) {
            return response([
                'status' => 'error',
                'message' => 'Product Short of Stock.'
            ]);
        }

        Cart::update($rowId, $quantity);

        $product_total = $this->getProductTotal($rowId);

        return response([
            'status' => 'success',
            'message' => 'Product Quantity Updated.',
            'product_total' => $product_total
        ]);
    }

    /**
     * Helper method to get Total Price
     *
     * @param $row_id
     * @return float|int
     */
    public function getProductTotal($row_id): float|int
    {
        $product = Cart::get($row_id);

        $variant_price_total = property_exists($product->options, 'variant_price_total')
            ? $product->options->variant_price_total : 0;

        return ($product->price + $variant_price_total) * $product->qty;
    }

    /**
     * Get Cart Subtotal
     *
     * @return float|int
     */
    public function cartSubtotal(): float|int
    {
        $subtotal = 0;

        foreach (Cart::content() as $item) {
            $subtotal += $this->getProductTotal($item->rowId);
        }

        return $subtotal;
    }

    /**
     * Clear Cart Contents
     *
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function clearCart(): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        Cart::destroy();

        return response([
            'status' => 'success',
            'message' => 'Cart Contents Cleared.'
        ]);
    }

    /**
     * Remove Cart Item
     *
     * @param $row_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeProduct($row_id): RedirectResponse
    {
        Cart::remove($row_id);

        return redirect()->back()
            ->with('section', '#wsus__cart_view')
            ->with(['message' => 'Item Removed from Cart']);
    }

    /**
     * Count Cart Items
     *
     * @return int
     */
    public function getCartCount(): int
    {
        return Cart::content()->count();
    }

    /**
     * Get Cart Items
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCartItems(): Collection
    {
        return Cart::content();
    }

    /**
     * Remove Sidebar Cart Item
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function removeSidebarProduct(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        Cart::remove($request->input('rowId'));

        return response([
            'status' => 'success',
            'message' => 'Cart Item Removed.'
        ]);
    }

    /**
     * Apply Coupon
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function applyCoupon(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $coupon_code = $request->input('coupon');

        // Check if session coupon is set and its code matches the current coupon code
        if (Session::has('coupon')) {
            $sessionCoupon = Session::get('coupon');
            if ($sessionCoupon['code'] === $coupon_code) {
                return response([
                    'status' => 'error',
                    'message' => 'Coupon already applied.'
                ]);
            }
        }

        if ($coupon_code === null) {
            return response([
                'status' => 'error',
                'message' => 'Enter coupon.'
            ]);
        }

        $coupon = Coupon::query()->where([
            'code' => $coupon_code,
            'status' => 1
        ])->first();

        if ($coupon === null) {
            return response([
                'status' => 'error',
                'message' => 'Coupon Invalid.'
            ]);
        }

        if ($coupon->start_date > date('Y-m-d')) {
            return response([
                'status' => 'error',
                'message' => 'Coupon Not Available.'
            ]);
        }

        if ($coupon->end_date < date('Y-m-d')) {
            return response([
                'status' => 'error',
                'message' => 'Coupon Expired.'
            ]);
        }

        if ($coupon->total_use >= $coupon->quantity) {
            return response([
                'status' => 'error',
                'message' => 'Coupon Not Applicable.'
            ]);
        }

        Session::put('coupon', [
            'id' => $coupon->id,
            'name' => $coupon->name,
            'code' => $coupon->code,
            'discount_type' => ($coupon->discount_type === 1 ? 'percent' : 'amount'),
            'discount' => $coupon->discount,
        ]);

        return response([
            'status' => 'success',
            'message' => 'Coupon Applied Successfully.'
        ]);
    }

    /**
     * Calculate Coupon Discount and Overall Cart Total
     *
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function couponCalculation(): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $subtotal = cartSubtotal();

        $discount = 0;
        $total = $subtotal;

        if (Session::has('coupon')) {
            $coupon = Session::get('coupon');

            if ($coupon['discount_type'] === 'percent') {
                $discount = $coupon['discount'] * $subtotal / 100;
                $total = $subtotal - $discount;
            } elseif ($coupon['discount_type'] === 'amount') {
                $discount = $coupon['discount'];
                $total = $subtotal - $discount;
            }
        }

        return response([
            'status' => 'success',
            'coupon_discount' => $discount,
            'cart_total' => $total
        ]);
    }

    /**
     * Set the referral session
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function applyReferral(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $referral_code = $request->input('referral');

        if ($referral_code === null) {
            return response([
                'status' => 'error',
                'message' => 'Enter referral code.'
            ]);
        }

        $referrer_id = $this->decodeReferral($referral_code);
        $referrer = User::findOrFail($referrer_id)->first();

        // Check if the referral pair exists in the referrals table
        $referralExists = Referral::query()
            ->where('referrer_id', $referrer->id)
            ->where('referred_id', Auth::id()) // Assuming you are using Laravel's authentication
            ->exists();

        if ($referralExists) {
            return response([
                'status' => 'error',
                'message' => 'Code already used.'
            ]);
        }

        Session::put('referral', [
            'id' => $referrer->id,
            'name' => 'basic_pack',
            'code' => $referral_code,
            'points' => 10, // points
            'bonus' => 100 // e-wallet
        ]);

        return response([
            'status' => 'success',
            'message' => 'Referral Code Applied Successfully.'
        ]);
    }

    /**
     * Retrieve the user_id from the hash
     *
     * @param $referral_code
     * @return array
     */
    public function decodeReferral($referral_code): array
    {
        /* To do: Obtain the referrer_id based on the referral code */
        return Hashids::decode($referral_code);
    }
}
