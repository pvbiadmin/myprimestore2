<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FlashSaleItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\Product;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FlashSaleController extends Controller
{
    /**
     * View Flash Sales
     *
     * @param FlashSaleItemDataTable $dataTable
     * @return mixed
     */
    public function index(FlashSaleItemDataTable $dataTable): mixed
    {
        $flash_sale = FlashSale::query()->first();
        $products = Product::query()
            ->where('is_approved', '=', 1)
            ->where('status', '=', 1)
            ->orderBy('id', 'DESC')
            ->get();

        return $dataTable->render('admin.flash-sale.index',
            compact('flash_sale', 'products'));
    }

    /**
     * Update Flash Sale End Date
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'end_date' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with(['message' => $error, 'alert-type' => 'error']);
        }

        FlashSale::query()->updateOrCreate(
            ['id' => 1],
            ['end_date' => $request->input('end_date')]
        );

        return redirect()->back()->with(['message' => 'Flash Sale End Date Updated']);
    }

    /**
     * Adds Product to Flash Sale
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function addProduct(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'product' => ['required', 'unique:flash_sale_items,product_id'],
            'show_at_home' => ['required'],
            'status' => ['required']
        ], [
            'product.unique' => 'Product Already in Flash Sale.'
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with(['message' => $error, 'alert-type' => 'error']);
        }

        $flash_sale_item = new FlashSaleItem();

        $flash_sale_item->product_id = $request->input('product');
        $flash_sale_item->show_at_home = $request->input('show_at_home');
        $flash_sale_item->status = $request->input('status');

        $flash_sale_item->save();

        return redirect()->back()->with(['message' => 'Product Added to Flash Sale']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
     */
    public function destroy(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $variant = FlashSaleItem::query()->findOrFail($id);

        $variant->delete();

        return response([
            'status' => 'success',
            'message' => 'Flash Sale Item Deleted Successfully.'
        ]);
    }

    /**
     * Handles Flash Sale Status Update
     *
     * @param Request $request
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
     */
    public function changeStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $slider = FlashSaleItem::query()->findOrFail($request->input('idToggle'));

        $slider->status = ($request->input('isChecked') === 'true' ? 1 : 0);
        $slider->save();

        return response([
            'status' => 'success',
            'message' => 'Flash Sale Status Updated.'
        ]);
    }

    /**
     * Handles Flash Sale `Show-at-Home` Update
     *
     * @param Request $request
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
     */
    public function changeShowAtHome(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $slider = FlashSaleItem::query()->findOrFail($request->input('idToggle'));

        $slider->show_at_home = ($request->input('isChecked') === 'true' ? 1 : 0);
        $slider->save();

        return response([
            'status' => 'success',
            'message' => 'Flash Sale Show-at-Home Updated.'
        ]);
    }
}
