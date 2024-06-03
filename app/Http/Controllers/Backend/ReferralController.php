<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ReferralSettingDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PointTransaction;
use App\Models\ProductType;
use App\Models\Referral;
use App\Models\ReferralSetting;
use App\Models\User;
use App\Models\WalletTransaction;
use App\Traits\ReferralTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Vinkla\Hashids\Facades\Hashids;

class ReferralController extends Controller
{
    use ReferralTrait;

    /**
     * Display a listing of the resource.
     *
     * @param ReferralSettingDataTable $dataTable
     * @return mixed
     */
    public function index(ReferralSettingDataTable $dataTable)
    {
        return $dataTable->render('admin.commissions.direct-referral.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        $packages = ProductType::where('is_package', 1)->get();

        return view('admin.commissions.direct-referral.create', compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validateRequest($request);

        $referralSetting = new ReferralSetting();

        $referralSetting->package = $request->input('package');
        $referralSetting->bonus = $request->input('bonus');
        $referralSetting->points = $request->input('points');
        $referralSetting->status = $request->input('status');

        $referralSetting->save();

        return redirect()->route('admin.referral.index')
            ->with(['message' => 'Settings Added Successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit(string $id)
    {
        $referralSetting = ReferralSetting::findOrFail($id);
        $packages = ProductType::where('is_package', 1)->get();

        return view('admin.commissions.direct-referral.edit',
            compact('referralSetting', 'packages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $this->validateRequest($request);

        $referralSetting = ReferralSetting::findOrFail($id);

        $referralSetting->package = $request->input('package');
        $referralSetting->bonus = $request->input('bonus');
        $referralSetting->points = $request->input('points');
        $referralSetting->status = $request->input('status');

        $referralSetting->save();

        return redirect()->route('admin.referral.index')
            ->with(['message' => 'Settings Updated Successfully']);
    }

    /**
     * @param Request $request
     */
    protected function validateRequest(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'package' => ['required'],
            'bonus' => ['required'],
            'points' => ['required'],
            'status' => ['required'],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            redirect()->back()->withInput()
                ->with(['message' => $error, 'alert-type' => 'error'])
                ->throwResponse();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
     */
    public function destroy(string $id)
    {
        $referralSetting = ReferralSetting::findOrFail($id);

        $referralSetting->delete();

        return response([
            'status' => 'success',
            'message' => 'Setting Deleted Successfully.'
        ]);
    }

    /**
     * Handles Flash Sale Status Update
     *
     * @param Request $request
     * @return Application|Response|ResponseFactory
     */
    public function changeStatus(Request $request)
    {
        $referralSetting = ReferralSetting::findOrFail($request->input('idToggle'));

        $referralSetting->status = ($request->input('isChecked') === 'true' ? 1 : 0);
        $referralSetting->save();

        return response([
            'status' => 'success',
            'message' => 'Status Updated.'
        ]);
    }

    public function viewCode()
    {
        return view('admin.commissions.referral-code.index');
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
     * Add Referral Bonus
     *
     * @param $orderId
     */
    public static function addReferralBonus($orderId): void
    {
        $order = Order::findOrFail($orderId);
        $orderProduct = OrderProduct::where('order_id', $order->id)->first();

        if ($orderProduct->product->productType->is_package) {
            $user = User::findOrFail($order->user_id);
            $referral = Referral::where('referred_id', $user->id)->first();
            $referrer = User::findOrFail($referral->referrer_id);

            $referrer_point = $referrer->point;

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
     * @return PointTransaction|null
     */
    protected static function getPointTransaction($point_id, $type, $details): ?PointTransaction
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
     * @return WalletTransaction|null
     */
    protected static function getWalletTransaction($wallet_id, $type, $details): ?WalletTransaction
    {
        return WalletTransaction::where([
            'wallet_id' => $wallet_id,
            'type' => $type,
            'details' => $details
        ])->first();
    }
}
