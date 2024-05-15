<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorWithdrawDataTable;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\OrderProduct;
use App\Models\WithdrawMethod;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use DB;

class VendorWithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(VendorWithdrawDataTable $dataTable)
    {
        $user = auth()->user();
        $balance = optional($user->wallet)->balance;

        $totalEarnings = OrderProduct::query()->where('vendor_id', auth()->user()->id)
            ->whereHas('order', function ($query) {
                $query
                    ->where('payment_status', 1)
                    ->where('order_status', 'delivered');
            })
            ->sum(DB::raw('unit_price * quantity + product_variant_price_total'));

        $totalWithdraw = WithdrawRequest::query()
            ->where('status', 'paid')->sum('total_amount');

        $currentBalance = /*$totalEarnings - $totalWithdraw*/$balance;

        $pendingAmount = WithdrawRequest::query()
            ->where('status', 'pending')->sum('total_amount');

        return $dataTable->render('vendor.withdraw.index',
            compact('totalEarnings', 'currentBalance', 'totalWithdraw', 'pendingAmount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $methods = WithdrawMethod::all();

        return view('vendor.withdraw.create', compact('methods'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'withdraw_method' => ['required', 'integer'],
            'amount' => ['required', 'numeric'],
            'account_info' => ['required', 'max:2000']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with(['message' => $error, 'alert-type' => 'error']);
        }

        $method = WithdrawMethod::query()->findOrFail($request->withdraw_method);

        $currency = GeneralSetting::query()->first()->currency_icon;

        if ($request->amount < $method->minimum_amount
            || $request->amount > $method->maximum_amount) {
            $error = sprintf(
                "Amount must be greater than %s%s and less than %s%s",
                $currency,
                number_format($method->minimum_amount, 2),
                $currency,
                number_format($method->maximum_amount, 2)
            );

            return redirect()->back()->withInput()
                ->with(['message' => $error, 'alert-type' => 'error']);
        }

        $totalEarnings = OrderProduct::where('vendor_id', auth()->user()->id)
            ->whereHas('order', function ($query) {
                $query->where('payment_status', 1)->where('order_status', 'delivered');
            })
            ->sum(DB::raw('unit_price * quantity + product_variant_price_total'));

        $totalWithdraw = WithdrawRequest::query()
            ->where('status', 'paid')->sum('total_amount');

        $currentBalance = $totalEarnings - $totalWithdraw;

        if ($request->amount > $currentBalance) {
            return redirect()->back()->withInput()
                ->with(['message' => 'Insufficient Balance', 'alert-type' => 'error']);
        }

        if (WithdrawRequest::query()->where([
            'vendor_id' => auth()->user()->id,
            'status' => 'pending'
        ])->exists()) {
            return redirect()->back()->withInput()
                ->with(['message' => 'You already have a pending request', 'alert-type' => 'error']);
        }

        $withdraw = new WithdrawRequest();

        $withdraw->vendor_id = auth()->user()->id;
        $withdraw->method = $method->name;
        $withdraw->total_amount = $request->amount;
        $withdraw->withdraw_amount = $request->amount - ($method->withdraw_charge / 100) * $request->amount;
        $withdraw->withdraw_charge = ($method->withdraw_charge / 100) * $request->amount;
        $withdraw->account_info = $request->account_info;

        $withdraw->save();

        return redirect()->route('vendor.withdraw.index')
            ->with(['message' => 'Request added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $methodInfo = WithdrawMethod::query()->findOrFail($id);

        return response($methodInfo);
    }

    function showRequest(string $id)
    {
        $request = WithdrawRequest::query()->where('vendor_id', auth()->user()->id)->findOrFail($id);

        return view('vendor.withdraw.show', compact('request'));
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
     */
    public function destroy(string $id)
    {
        //
    }
}
