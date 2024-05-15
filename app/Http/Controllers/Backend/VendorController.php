<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function dashboard(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $orders_today = Order::query()
            ->whereDate('created_at', Carbon::today())
            ->whereHas('orderProducts', function ($query) {
                $query->where('vendor_id', Auth::user()->vendor->id);
            })->count();

        $pending_orders_today = Order::query()
            ->whereDate('created_at', Carbon::today())
            ->where('order_status', 'pending')
            ->whereHas('orderProducts', function ($query) {
                $query->where('vendor_id', Auth::user()->vendor->id);
            })->count();

        $total_orders = Order::query()
            ->whereHas('orderProducts', function ($query) {
            $query->where('vendor_id', Auth::user()->vendor->id);
        })->count();

        $total_pending_orders = Order::query()
            ->where('order_status', 'pending')
            ->whereHas('orderProducts', function ($query) {
                $query->where('vendor_id', Auth::user()->vendor->id);
            })->count();

        $total_completed_orders = Order::query()
            ->where('order_status', 'delivered')
            ->whereHas('orderProducts', function ($query) {
                $query->where('vendor_id', Auth::user()->vendor->id);
            })->count();

        $total_products = Product::query()
            ->where('vendor_id', Auth::user()->vendor->id)
            ->count();

        $earnings_today = Order::query()
            ->where('order_status', 'delivered')
            ->where('payment_status', 1)
            ->whereDate('created_at', Carbon::today())
            ->whereHas('orderProducts', function ($query) {
                $query->where('vendor_id', Auth::user()->vendor->id);
            })->sum('subtotal');

        $monthly_earnings = Order::query()
            ->where('order_status', 'delivered')
            ->where('payment_status', 1)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereHas('orderProducts', function ($query) {
                $query->where('vendor_id', Auth::user()->vendor->id);
            })->sum('subtotal');

        $yearly_earnings = Order::query()
            ->where('order_status', 'delivered')
            ->where('payment_status', 1)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereHas('orderProducts', function ($query) {
                $query->where('vendor_id', Auth::user()->vendor->id);
            })->sum('subtotal');

        $total_earnings = Order::query()
            ->where('order_status', 'delivered')
            ->whereHas('orderProducts', function ($query) {
                $query->where('vendor_id', Auth::user()->vendor->id);
            })->sum('subtotal');

        $total_reviews = ProductReview::query()
            ->whereHas('product', function ($query) {
            $query->where('vendor_id', Auth::user()->vendor->id);
        })->count();

        return view('vendor.dashboard.dashboard', compact(
            'orders_today',
            'pending_orders_today',
            'total_orders',
            'total_pending_orders',
            'total_completed_orders',
            'total_products',
            'earnings_today',
            'monthly_earnings',
            'yearly_earnings',
            'total_earnings',
            'total_reviews'
        ));
    }
}
