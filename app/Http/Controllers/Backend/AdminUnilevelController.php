<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PointTransaction;
use App\Models\Referral;
use App\Models\UnilevelSetting;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use JsonException;

class AdminUnilevelController extends Controller
{
    /**
     * View Unilevel Page
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $unilevelSettings = UnilevelSetting::first();

        return view('admin.commissions.unilevel.index', compact('unilevelSettings'));
    }

    /**
     * Update Unilevel Settings
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function updateUnilevelSettings(Request $request, string $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'bonus' => ['required'],
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

        UnilevelSetting::updateOrCreate(
            ['id' => $id],
            [
                'bonus' => $request->input('bonus'),
            ]
        );

        return redirect()->back()->with([
            'anchor' => 'list-settings-list',
            'message' => 'Updated Successfully!'
        ]);
    }

    /**
     * Add Unilevel Bonus
     *
     * @param $orderId
     * @throws JsonException
     */
    public static function addUnilevelBonus($orderId): void
    {
        $order = Order::query()->findOrFail($orderId);
        $user = User::findOrFail($order->user_id);

        // add points to user
        $user_point = $user->point;

        if (!$user_point) {
            // Create a wallet record for the user with a zero balance
            $user_point = $user->point()->create(['balance' => 0]);
        }

//        $user_point_transactions = PointTransaction::where([
//            'point_id' => $user_point->id,
//            'type' => 'pending_credit',
//            'details' => '{"order_id":' . $order->id . '}'
//        ])->first();

        $user_point_transactions = self::getPointTransaction(
            $user_point->id,
            'pending_credit',
            '{"order_id":' . $order->id . '}'
        );

        if ($user_point_transactions !== null) {
            $points_reward = $user_point_transactions->points;

            $user_point->balance += $points_reward;

            if ($user_point->save()) {
                // validate transaction
                $user_point_transactions->type = 'credit';
                $user_point_transactions->save();

                $unilevelSettings = UnilevelSetting::first();

                // add unilevel points
                $unilevel_bonus = $points_reward * $unilevelSettings->bonus / 100;
                $referral = Referral::where('referred_id', $user->id)->first();

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

                    $unilevel_bonus = $unilevel_bonus * $unilevelSettings->bonus / 100;
                    $referral = Referral::where('referred_id', $referrer->id)->first();
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
}
