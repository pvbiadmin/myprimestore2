<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CancelledOrderDataTable;
use App\DataTables\DeliveredOrderDataTable;
use App\DataTables\DroppedOffOrderDataTable;
use App\DataTables\OrderDataTable;
use App\DataTables\OutForDeliveryOrderDataTable;
use App\DataTables\PendingOrderDataTable;
use App\DataTables\ProcessedAndReadyToShipOrderDataTable;
use App\DataTables\ShippedOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Vendor;
use App\Models\WalletTransaction;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\OrderDataTable $dataTable
     * @return mixed
     */
    public function index(OrderDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.order.index');
    }

    public function pendingOrders(PendingOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.pending');
    }

    public function processedAndReadyToShipOrders(ProcessedAndReadyToShipOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.processed-and-ready-to-ship');
    }

    public function droppedOffOrders(DroppedOffOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.dropped-off');
    }

    public function shippedOrders(ShippedOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.shipped');
    }

    public function outForDeliveryOrders(OutForDeliveryOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.out-for-delivery');
    }

    public function deliveredOrders(DeliveredOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.delivered');
    }

    public function cancelledOrders(CancelledOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.order.cancelled');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show all Orders
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $order = Order::query()->findOrFail($id);

        return view('admin.order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $order = Order::query()->findOrFail($id);

        $order->orderProducts()->delete();
        $order->transaction()->delete();
        $order->delete();

        return response([
            'status' => 'success',
            'message' => 'Order Deleted'
        ]);
    }

    /**
     * Change Order Status
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changeOrderStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        try {
            ['orderId' => $orderId, 'status' => $status] = $request->all();

            $order = Order::findOrFail($orderId);
            $order->order_status = $status;
            $order->save();

            if ($status === 'completed') {
                $orderProducts = OrderProduct::where('order_id', $orderId)->get();

                if ($orderProducts->isNotEmpty()) {
                    foreach ($orderProducts as $orderProduct) {
                        $earnings = $orderProduct->unit_price * $orderProduct->quantity;
                        $vendor = Vendor::find($orderProduct->vendor_id);

                        if (!$vendor) {
                            // Log or handle the case when vendor is not found
                            continue;
                        }

                        $user = $vendor->user;

                        if (!$user) {
                            // Log or handle the case when user is not found
                            continue;
                        }

                        $wallet = $user->wallet;

                        if (!$wallet) {
                            // Create a wallet record for the user with a zero balance
                            $wallet = $user->wallet()->create(['balance' => 0]);
                        }

                        $wallet->balance += $earnings;
                        $wallet->save();

                        WalletTransaction::create([
                            'wallet_id' => $wallet->id,
                            'type' => 'credit',
                            'amount' => $earnings,
                        ]);
                    }
                }
            }

            return response([
                'status' => 'success',
                'message' => 'Order Status Updated',
                'order_status' => $status
            ]);
        } catch (Exception) {
            // Log the error
            return response([
                'status' => 'error',
                'message' => 'An error occurred while updating order status.'
            ], 500); // Internal Server Error
        }
    }

    /**
     * Change Order Status
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changePaymentStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        ['orderId' => $orderId, 'status' => $status] = $request->all();

        $order = Order::query()->findOrFail($orderId);

        $order->payment_status = $status;
        $order->save();

        return response([
            'status' => 'success',
            'message' => 'Payment Status Updated',
            'payment_status' => $status
        ]);
    }
}
