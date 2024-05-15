<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\Wishlist;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $total_orders = Order::query()->where('user_id', Auth::user()->id)->count();
        $pending_orders = Order::query()->where('user_id', Auth::user()->id)
            ->where('order_status', 'pending')->count();
        $completed_orders = Order::query()->where('user_id', Auth::user()->id)
            ->where('order_status', 'delivered')->count();
        $reviews = ProductReview::query()->where('user_id', Auth::user()->id)->count();
        $wishlist = Wishlist::query()->where('user_id', Auth::user()->id)->count();

        return view('frontend.dashboard.dashboard', compact(
            'total_orders',
            'pending_orders',
            'completed_orders',
            'reviews',
            'wishlist'
        ));
    }
}
