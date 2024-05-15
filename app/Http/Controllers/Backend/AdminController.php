<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function dashboard(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $orders_today = Order::query()->whereDate('created_at', Carbon::today())->count();

        $pending_orders_today = Order::query()
            ->whereDate('created_at', Carbon::today())
            ->where('order_status', 'pending')->count();

        $total_orders = Order::query()->count();

        $total_pending_orders = Order::query()->where('order_status', 'pending')->count();
        $total_cancelled_orders = Order::query()->where('order_status', 'cancelled')->count();
        $total_completed_orders = Order::query()->where('order_status', 'delivered')->count();

        $earnings_today = Order::query()
            ->where('order_status', '!=', 'cancelled')
            ->where('payment_status', 1)
            ->whereDate('created_at', Carbon::today())
            ->sum('subtotal');

        $monthly_earnings = Order::query()
            ->where('order_status', '!=', 'cancelled')
            ->where('payment_status', 1)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('subtotal');

        $yearly_earnings = Order::query()
            ->where('order_status', '!=', 'cancelled')
            ->where('payment_status', 1)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('subtotal');

        $total_reviews = ProductReview::query()->count();
        $total_brands = Brand::query()->count();
        $total_categories = Category::query()->count();
        $total_blogs = Blog::query()->count();
        $total_subscribers = NewsletterSubscriber::query()->count();
        $total_vendors = User::query()->where('role', 'vendor')->count();
        $total_users = User::query()->where('role', 'user')->count();

        return view('admin.dashboard', compact(
            'orders_today',
            'pending_orders_today',
            'total_orders',
            'total_pending_orders',
            'total_cancelled_orders',
            'total_completed_orders',
            'earnings_today',
            'monthly_earnings',
            'yearly_earnings',
            'total_reviews',
            'total_brands',
            'total_categories',
            'total_blogs',
            'total_subscribers',
            'total_vendors',
            'total_users'
        ));
    }

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function login(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.auth.login');
    }
}
