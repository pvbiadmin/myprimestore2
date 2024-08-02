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
     * @param VendorOrderDataTable $dataTable
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
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $order = Order::query()->with(['orderProducts'])->findOrFail($id);

        return view('vendor.order.show', compact('order'));
    }

    /**
     * Change Order Status
     *
     * @param Request $request
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
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
