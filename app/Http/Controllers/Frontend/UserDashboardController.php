<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\Wishlist;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
//        dd(Auth::user()->id);

        $total_orders = Order::query()->where('user_id', Auth::user()->id)->count();
        $pending_orders = Order::query()->where('user_id', Auth::user()->id)
            ->where('order_status', 'pending')->count();
        $completed_orders = Order::query()->where('user_id', Auth::user()->id)
            ->where('order_status', 'delivered')->count();
        $reviews = ProductReview::query()->where('user_id', Auth::user()->id)->count();
        $wishlist = Wishlist::query()->where('user_id', Auth::user()->id)->count();

        $commission = Commission::where('user_id', Auth::user()->id)->first();
        if ($commission) {
            $unilevel = $commission->unilevel;
            $referral = $commission->referral;
        } else {
            // Handle the case where no commission was found
            $unilevel = 0;
            $referral = 0;
        }

        return view('frontend.dashboard.dashboard', compact(
            'total_orders',
            'pending_orders',
            'completed_orders',
            'reviews',
            'wishlist',
            'unilevel',
            'referral'
        ));
    }
}
