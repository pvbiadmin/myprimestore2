<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PointTransaction;
use App\Models\Referral;
use App\Models\ReferralSetting;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Traits\ReferralTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Vinkla\Hashids\Facades\Hashids;

class AdminReferralController extends Controller
{
    use ReferralTrait;

    /**
     * View Referral Code Generation Page
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $referralSettings = ReferralSetting::first();

        return view('admin.commissions.referral.index', compact('referralSettings'));
    }

    /**
     * Generate Referral Code
     *
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
     */
    public function generateCode()
    {
        if (!auth()->check()) {
            return response([
                'status' => 'error',
                'message' => 'Login required.'
            ], 402);
        }

        $code = Hashids::encode(auth()->user()->id);

        return response([
            'status' => 'success',
            'message' => $code
        ]);
    }

    /**
     * Send Referral Code to Admin
     *
     * @param Request $request
     * @return RedirectResponse|null
     */
    public function sendCode(Request $request): ?RedirectResponse
    {
        return $this->sendReferralCode($request);
    }

    /**
     * Update Referral Settings
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function updateReferralSettings(Request $request, string $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'bonus' => ['required'],
            'points' => ['required'],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with([
                'anchor' => 'list-settings-list',
                'message' => $error,
                'alert-type' => 'error'
            ]);
        }

        ReferralSetting::updateOrCreate(
            ['id' => $id],
            [
                'bonus' => $request->input('bonus'),
                'points' => $request->input('points'),
            ]
        );

        return redirect()->back()->with([
            'anchor' => 'list-settings-list',
            'message' => 'Updated Successfully!'
        ]);
    }

    /**
     * Add Referral Bonus
     *
     * @param $orderId
     */
    public static function addReferralBonus($orderId): void
    {
        $order = Order::query()->findOrFail($orderId);
        $orderProduct = OrderProduct::where('order_id', $order->id)->first();
        $product = $orderProduct->product;
        $product_type = $product->product_type;

        if ($product_type === 'basic_pack') {
            $user = User::findOrFail($order->user_id);
            $referral = Referral::where('referred_id', $user->id)->first();
            $referrer = User::findOrFail($referral->referrer_id);

            $referrer_point = $referrer->point;

            // update points transactions
//            $referrer_point_transactions = PointTransaction::where([
//                'point_id' => $referrer_point->id,
//                'type' => 'pending_credit',
//                'details' => '{"order_id":' . $order->id . '}'
//            ])->first();

            $referrer_point_transactions = self::getPointTransaction(
                $referrer_point->id,
                'pending_credit',
                '{"order_id":' . $order->id . '}'
            );

            if ($referrer_point_transactions !== null) {
                $point_rewards = $referrer_point_transactions->points;

                // update referrer points
                $referrer_point->balance += $point_rewards;

                if ($referrer_point->save()) {
                    $referrer_point_transactions->type = 'credit';
                    $referrer_point_transactions->save();
                }

                // update referral status
                if ($referral->status === 0) {
                    $referral->status = 1;
                    $referral->save();
                }

                $referrer_wallet = $referrer->wallet;

                // update wallet
//                $referrer_wallet_transactions = WalletTransaction::where([
//                    'wallet_id' => $referrer_wallet->id,
//                    'type' => 'pending_credit',
//                    'details' => '{"order_id":' . $order->id . '}'
//                ])->first();

                $referrer_wallet_transactions = self::getWalletTransaction(
                    $referrer_wallet->id,
                    'pending_credit',
                    '{"order_id":' . $order->id . '}'
                );

                if ($referrer_wallet_transactions !== null) {
                    $referral_bonus = $referrer_wallet_transactions->amount;

                    // update referrer wallet
                    $referrer_wallet->balance += $referral_bonus;

                    if ($referrer_wallet->save()) {
                        $referrer_wallet_transactions->type = 'credit';
                        $referrer_wallet_transactions->save();

                        $commission = $referrer->commission;

                        if (!$commission) {
                            $commission = $referrer->commission()->create(['referral' => 0, 'unilevel' => 0]);
                        }

                        $commission->referral += $referral_bonus;
                        $commission->save();
                    }
                }
            }
        }
    }

    /**
     * Get point transaction
     *
     * @param $point_id
     * @param $type
     * @param $details
     * @return PointTransaction
     */
    protected static function getPointTransaction($point_id, $type, $details): PointTransaction
    {
        return PointTransaction::where([
            'point_id' => $point_id,
            'type' => $type,
            'details' => $details
        ])->first();
    }

    /**
     * Get wallet transaction
     *
     * @param $wallet_id
     * @param $type
     * @param $details
     * @return WalletTransaction
     */
    protected static function getWalletTransaction($wallet_id, $type, $details): WalletTransaction
    {
        return WalletTransaction::where([
            'wallet_id' => $wallet_id,
            'type' => $type,
            'details' => $details
        ])->first();
    }
}
