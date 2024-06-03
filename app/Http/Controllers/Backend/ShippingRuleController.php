<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ShippingRuleDataTable;
use App\Http\Controllers\Controller;
use App\Models\ShippingRule;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ShippingRuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ShippingRuleDataTable $dataTable
     * @return mixed
     */
    public function index(ShippingRuleDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.shipping-rule.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.shipping-rule.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200'],
            'status' => ['required'],
            'type' => ['required'],
            'min_cost' => ['nullable', 'numeric'],
            'cost' => ['required', 'numeric']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with(['message' => $error, 'alert-type' => 'error']);
        }

        $shipping = new ShippingRule();

        $shipping->name = $request->input('name');
        $shipping->type = $request->input('type');
        $shipping->min_cost = $request->input('min_cost');
        $shipping->cost = $request->input('cost');
        $shipping->status = $request->input('status');

        $shipping->save();

        return redirect()->route('admin.shipping-rules.index')
            ->with(['message' => 'Shipping Rule Added Successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $shipping = ShippingRule::query()->findOrFail($id);

        return view('admin.shipping-rule.edit', compact('shipping'));
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
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200'],
            'status' => ['required'],
            'type' => ['required'],
            'min_cost' => ['nullable', 'numeric'],
            'cost' => ['required', 'numeric']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with(['message' => $error, 'alert-type' => 'error']);
        }

        $shipping = ShippingRule::query()->findOrFail($id);

        $shipping->name = $request->input('name');
        $shipping->type = $request->input('type');
        $shipping->min_cost = $request->input('min_cost');
        $shipping->cost = $request->input('cost');
        $shipping->status = $request->input('status');

        $shipping->save();

        return redirect()->route('admin.shipping-rules.index')
            ->with(['message' => 'Shipping Rule Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
     */
    public function destroy(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $shipping = ShippingRule::query()->findOrFail($id);

        $shipping->delete();

        return response([
            'status' => 'success',
            'message' => 'Shipping Rule Deleted.'
        ]);
    }

    /**
     * Handles Coupon Status Update
     *
     * @param Request $request
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
     */
    public function changeStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $shipping = ShippingRule::query()->findOrFail($request->input('idToggle'));

        $shipping->status = ($request->input('isChecked') === 'true' ? 1 : 0);
        $shipping->save();

        return response([
            'status' => 'success',
            'message' => 'Shipping Status Updated.'
        ]);
    }
}
