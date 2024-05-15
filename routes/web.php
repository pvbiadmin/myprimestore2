<?php

use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\PackageController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\FlashSaleController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProductTrackController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\UserAddressController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Http\Controllers\Frontend\UserMessageController;
use App\Http\Controllers\Frontend\UserOrderController;
use App\Http\Controllers\Frontend\UserProfileController;
use App\Http\Controllers\Frontend\UserReferralCodeController;
use App\Http\Controllers\Frontend\UserVendorApplyController;
use App\Http\Controllers\Frontend\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/*Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});*/

require __DIR__ . '/auth.php';

Route::get('flash-sale', [FlashSaleController::class, 'index'])->name('flash-sale');

/**
 * Product Routes
 */
Route::controller(ProductController::class)->group(function () {
    Route::get('products', 'index')->name('products.index');
    Route::get('product/detail/{slug}', 'detail')->name('product-detail');
    Route::get('change-product-tab-view', 'changeProductTabView')->name('change-product-tab-view');
    Route::get('change-product-detail-tab-view', 'changeProductDetailTabView')
        ->name('change-product-detail-tab-view');
});

/**
 * Cart Routes
 */
Route::controller(CartController::class)->group(function () {
    Route::post('add-to-cart', 'addToCart')->name('add-to-cart');
    Route::get('cart-details', 'cartDetails')->name('cart-details');
    Route::post('cart/update-quantity', 'updateProductQty')->name('cart.update-quantity');
    Route::get('clear-cart', 'clearCart')->name('clear-cart');
    Route::get('cart/remove-product/{rowId}', 'removeProduct')->name('cart.remove-product');
    Route::get('cart-count', 'getCartCount')->name('cart-count');
    Route::get('cart-items', 'getCartItems')->name('cart-items');
    Route::post('cart/sidebar/remove-product', 'removeSidebarProduct')
        ->name('cart.sidebar.remove-product');
    Route::get('cart/sidebar/subtotal', 'cartSubtotal')->name('cart.sidebar.subtotal');
    Route::get('cart/apply-coupon', 'applyCoupon')->name('cart.apply-coupon');
    Route::get('cart/coupon-calculation', 'couponCalculation')->name('cart.coupon-calculation');
    Route::get('cart/apply-referral', 'applyReferral')->name('cart.apply-referral');
});

/** Newsletter routes */
Route::controller(NewsletterController::class)->group(function () {
    Route::post('newsletter-request', 'newsLetterRequest')->name('newsletter-request');
    Route::get('newsletter-verify/{token}', 'newsLetterEmailVerify')->name('newsletter-verify');
});

/** vendor page routes */
Route::controller(HomeController::class)->group(function () {
    Route::get('vendors', 'vendorsPage')->name('vendors.index');
    Route::get('vendor-products/{id}', 'vendorProductsPage')->name('vendor.products');
});

/** Page Controller Routes */
Route::controller(PageController::class)->group(function () {
    Route::get('about', 'about')->name('about');
    Route::get('terms-and-conditions', 'termsAndCondition')->name('terms-and-conditions');
    Route::get('contact', 'contact')->name('contact');
    Route::post('contact', 'handleContactForm')->name('handle-contact-form');
});

/** Product track route */
Route::get('product-tracking', [ProductTrackController::class, 'index'])->name('product-tracking.index');

/** blog routes */
Route::controller(BlogController::class)->group(function () {
    Route::get('blog-details/{slug}', 'blogDetails')->name('blog-details');
    Route::get('blog', 'blog')->name('blog');
});

Route::get('wishlist/add-product', [WishlistController::class, 'addToWishlist'])
    ->name('wishlist.store');

Route::get('/download/{filename}', function ($filename) {
    $file_path = public_path($filename);

    $headers = [
        'Content-Type' => 'application/vnd.android.package-archive',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    if (file_exists($file_path)) {
        return response()->download($file_path, $filename, $headers);
    } else {
        return response('File not found', 404);
    }
})->name('download');

Route::group([
    'middleware' => ['auth', 'verified'],
    'prefix' => 'user',
    'as' => 'user.'
], function () {
    Route::get('dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

    Route::controller(UserProfileController::class)->group(function () {
        Route::get('profile', 'index')->name('profile');
        Route::put('profile', 'updateProfile')->name('profile.update');
        Route::post('profile', 'updatePassword')->name('profile.update.password');
    });

    /** Message Route */
    Route::controller(UserMessageController::class)->group(function () {
        Route::get('messages', 'index')->name('messages.index');
        Route::post('send-message', 'sendMessage')->name('send-message');
        Route::get('get-messages', 'getMessages')->name('get-messages');
        Route::get('get-online-status', 'getOnlineStatus')->name('get-online-status');
    });

    /** Referral code route */
    Route::controller(UserReferralCodeController::class)->group(function () {
        Route::as('referral-code.')->group(function () {
            Route::get('referral-code', 'index')->name('index');
            Route::get('referral-code/generate', 'generateCode')->name('generate');
            Route::post('referral-code/send', 'sendCode')->name('send');
        });
    });

    /**
     * User Address Route
     */
    Route::resource('address', UserAddressController::class);

    /**
     * Orders Routes
     */
    Route::controller(UserOrderController::class)->group(function () {
        Route::get('orders', 'index')->name('orders.index');
        Route::get('orders/show/{id}', 'show')->name('orders.show');
    });

    /**
     * Wishlist Routes
     */
    Route::controller(WishlistController::class)->group(function () {
        Route::get('wishlist', 'index')->name('wishlist.index');
        Route::get('wishlist/remove-product/{id}', 'destroy')->name('wishlist.destroy');
    });

    /** product review routes */
    Route::controller(ReviewController::class)->group(function () {
        Route::get('reviews', 'index')->name('review.index');
        Route::post('review', 'create')->name('review.create');
    });

    /** blog comment routes */
    Route::post('blog-comment', [BlogController::class, 'comment'])->name('blog-comment');

    /** Vendor request route */
    Route::controller(UserVendorApplyController::class)->group(function () {
        Route::get('vendor-apply', 'index')->name('vendor-apply.index');
        Route::post('vendor-apply', 'create')->name('vendor-apply.create');
    });

    Route::get('packages', [PackageController::class, 'index'])->name('packages.index');

    /**
     * Checkout Routes
     */
    Route::controller(CheckoutController::class)->group(function () {
        Route::get('checkout', 'index')->name('checkout');
        Route::post('checkout/address-create', 'createAddress')->name('checkout.address-create');
        Route::post('checkout/form-submit', 'checkoutFormSubmit')->name('checkout.form-submit');
    });

    /**
     * Payment Routes
     */
    Route::controller(PaymentController::class)->group(function () {
        Route::get('payment', 'index')->name('payment');
        Route::get('payment/success', 'paymentSuccess')->name('payment.success');
        Route::get('paypal/payment', 'payWithPaypal')->name('paypal.payment');
        Route::get('paypal/success', 'paypalSuccess')->name('paypal.success');
        Route::get('paypal/cancel', 'paypalCancel')->name('paypal.cancel');
        Route::get('cod/payment', 'payWithCod')->name('cod.payment');
    });
});
