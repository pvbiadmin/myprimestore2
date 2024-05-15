<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VendorOrderController extends Controller
{
    /**
     * View All Orders
     *
     * @param \App\DataTables\VendorOrderDataTable $dataTable
     * @return mixed
     */
    public function index(VendorOrderDataTable $dataTable): mixed
    {
        return $dataTable->render('vendor.order.index');
    }

    /**
     * View Order Details
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $order = Order::query()->with(['orderProducts'])->findOrFail($id);

        return view('vendor.order.show', compact('order'));
    }

    /**
     * Change Order Status
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changeOrderStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $order = Order::query()->findOrFail($request->orderId);

        $order->order_status = $request->status;
        $order->save();

        return response([
            'status' => 'success',
            'message' => 'Order Status Updated'
        ]);
    }
}
