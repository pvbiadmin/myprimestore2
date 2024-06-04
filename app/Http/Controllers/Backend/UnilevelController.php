<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\UnilevelSettingDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PointTransaction;
use App\Models\ProductType;
use App\Models\Referral;
use App\Models\UnilevelSetting;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use JsonException;
use LaravelIdea\Helper\App\Models\_IH_ProductType_C;

class UnilevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UnilevelSettingDataTable $dataTable
     * @return mixed
     */
    public function index(UnilevelSettingDataTable $dataTable)
    {
        $packages = $this->untouchedPackages();

        return $dataTable->render('admin.commissions.unilevel.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        $packages = $this->untouchedPackages();

        return view('admin.commissions.unilevel.create', compact('packages'));
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

        $unilevelSetting = new UnilevelSetting();

        $unilevelSetting->package = $request->input('package');
        $unilevelSetting->bonus = $request->input('bonus');
        $unilevelSetting->status = $request->input('status');

        $unilevelSetting->save();

        return redirect()->route('admin.unilevel.index')
            ->with(['message' => 'Settings Added Successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $unilevelSetting = UnilevelSetting::findOrFail($id);
        $packages = ProductType::where('is_package', 1)->get();

        return view('admin.commissions.unilevel.edit',
            compact('unilevelSetting', 'packages'));
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

        $referralSetting = UnilevelSetting::findOrFail($id);

        $referralSetting->package = $request->input('package');
        $referralSetting->bonus = $request->input('bonus');
        $referralSetting->status = $request->input('status');

        $referralSetting->save();

        return redirect()->route('admin.unilevel.index')
            ->with(['message' => 'Settings Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @param string $id
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
     */
    public function destroy(string $id)
    {
        $referralSetting = UnilevelSetting::findOrFail($id);

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
        $referralSetting = UnilevelSetting::findOrFail($request->input('idToggle'));

        $referralSetting->status = ($request->input('isChecked') === 'true' ? 1 : 0);
        $referralSetting->save();

        return response([
            'status' => 'success',
            'message' => 'Status Updated.'
        ]);
    }

    /**
     * @param Request $request
     */
    protected function validateRequest(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'package' => ['required'],
            'bonus' => ['required'],
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
     * Add Unilevel Bonus
     *
     * @param $orderId
     * @throws JsonException
     */
    public static function processPendingUnilevel($orderId): void
    {
        $order = Order::query()->findOrFail($orderId);
        $user = User::findOrFail($order->user_id);

        // add points to user
        $user_point = $user->point;

        if (!$user_point) {
            // Create a wallet record for the user with a zero balance
            $user_point = $user->point()->create(['balance' => 0]);
        }

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
     * @return ProductType[]|_IH_ProductType_C
     */
    protected function untouchedPackages()
    {
        return ProductType::where('is_package', 1)
            ->whereNotIn('id',  UnilevelSetting::select('package'))
            ->get();
    }
}
