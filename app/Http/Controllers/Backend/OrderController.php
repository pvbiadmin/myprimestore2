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
use App\Models\PointTransaction;
use App\Models\Referral;
use App\Models\ReferralSetting;
use App\Models\User;
use App\Models\Vendor;
use App\Models\WalletTransaction;
use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JsonException;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param OrderDataTable $dataTable
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
     * Show all Orders
     *
     * @param string $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function show(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $order = Order::query()->findOrFail($id);

        return view('admin.order.show', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
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
     * @param Request $request
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
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
     * @param Request $request
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
     * @throws JsonException
     */
    public function changePaymentStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        ['orderId' => $orderId, 'status' => $status] = $request->all();

        $order = Order::query()->findOrFail($orderId);

        $user = User::findOrFail($order->user_id);

        $orderProduct = OrderProduct::where('order_id', $order->id)->first();

        $product = $orderProduct->product;

        $product_type = $product->product_type;

        // referral wallet and points computation
        $this->addReferralBonus($user, $product_type);

        // compute unilevel
        $this->addUnilevelBonus($user);

        $order->payment_status = $status;
        $order->save();

        return response([
            'status' => 'success',
            'message' => 'Payment Status Updated',
            'payment_status' => $status
        ]);
    }

    /**
     * Add Referral Bonus
     *
     * @param $user
     * @param $product_type
     */
    public function addReferralBonus($user, $product_type): void
    {
        if ($product_type === 'basic_pack') {
            $referral = Referral::where('referred_id', $user->id)->first();
            $referrer = User::findOrFail($referral->referrer_id);

            // update points transactions
            $user_point_transactions = PointTransaction::where([
                'point_id' => $referrer->point->id,
                'type' => 'pending_credit'
            ])->first();

            // update referrer points
            $referrer_point = $referrer->point;
            $referrer_point->balance += $user_point_transactions->points;

            if ($referrer_point->save()) {
                $user_point_transactions->type = 'credit';
                $user_point_transactions->save();
            }

            // update referral status
            if ($referral->status === 0) {
                $referral->status = 1;
                $referral->save();
            }

            // update wallet
            $user_wallet_transactions = WalletTransaction::where([
                'wallet_id' => $referrer->wallet->id,
                'type' => 'pending_credit'
            ])->first();

            // update referrer wallet
            $referrer_wallet = $referrer->wallet;
            $referrer_wallet->balance += $user_wallet_transactions->amount;

            if ($referrer_wallet->save()) {
                $user_wallet_transactions->type = 'credit';
                $user_wallet_transactions->save();

                $commission = $user->commission;

                if (!$commission) {
                    $commission = $user->commission()->create(['referral' => 0, 'unilevel' => 0]);
                }

                $commission->referral += $user_wallet_transactions->amount;
                $commission->save();
            }
        }
    }

    /**
     * Add Unilevel Bonus
     *
     * @param $user
     * @throws JsonException
     */
    public function addUnilevelBonus($user): void
    {
        // add points to user
        $user_point = $user->point;

        $user_point_transactions = PointTransaction::where([
            'point_id' => $user_point->id,
            'type' => 'pending_credit'
        ])->first();

        $points_reward = $user_point_transactions->points;

        $user_point->balance += $points_reward;

        if ($user_point->save()) {
            // validate transaction
            $user_point_transactions->type = 'credit';
            $user_point_transactions->save();

            $referralSettings = ReferralSetting::first();

            // add unilevel points
            $referral = Referral::where('referred_id', $user->id)->first();
            $unilevel_bonus = $points_reward * $referralSettings->bonus / 100;

            while ($referral !== null) {
                $referrer = User::findOrFail($referral->referrer_id);

                $referrer_wallet = $referrer->wallet;
                $referrer_wallet_id = $referrer_wallet->id;

                $referrer_wallet->balance += $unilevel_bonus;

                if ($referrer_wallet->save()) {
                    $commission = $referrer->commission;

                    if (!$commission) {
                        $commission = $referrer->commission()->create(['referral' => 0, 'unilevel' => 0]);
                    }

                    $commission->unilevel += $unilevel_bonus;

                    if ($commission->save()) {
                        WalletTransaction::create([
                            'wallet_id' => $referrer_wallet_id,
                            'type' => 'credit',
                            'amount' => $unilevel_bonus,
                            'details' => json_encode(['commission' => 'unilevel'], JSON_THROW_ON_ERROR)
                        ]);
                    }
                }

                $referral = Referral::where('referred_id', $referrer->id)->first();
                $unilevel_bonus = $unilevel_bonus * $referralSettings->bonus / 100;
            }
        }
    }
}
