<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantOptionDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantOption;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ProductVariantOptionController extends Controller
{
    /**
     * @param \App\DataTables\ProductVariantOptionDataTable $dataTable
     * @param $product_id
     * @param $variant_id
     * @return mixed
     */
    public function index(ProductVariantOptionDataTable $dataTable, $product_id, $variant_id): mixed
    {
        $product = Product::query()->findOrFail($product_id);
        $variant = ProductVariant::query()->findOrFail($variant_id);

        return $dataTable->render('admin.product.product-variant-option.index',
            compact('product', 'variant'));
    }

    /**
     * @param string $product_id
     * @param string $variant_id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create(string $product_id, string $variant_id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $product = Product::query()->findOrFail($product_id);
        $variant = ProductVariant::query()->findOrFail($variant_id);

        return view('admin.product.product-variant-option.create',
            compact('product', 'variant'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'variant_id' => ['required', 'integer'],
            'name' => ['required', 'max:200'],
            'price' => ['required', 'integer'],
            'is_default' => ['required'],
            'status' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with(['message' => $error, 'alert-type' => 'error']);
        }

        $variant_option = new ProductVariantOption();

        $variant_option->product_variant_id = $request->variant_id;
        $variant_option->name = $request->name;
        $variant_option->price = $request->price;
        $variant_option->is_default = $request->is_default;
        $variant_option->status = $request->status;

        $variant_option->save();

        return redirect()->route('admin.products-variant-option.index',
            ['productId' => $request->product_id, 'variantId' => $request->variant_id])
            ->with(['message' => 'Product Variant Option Added Successfully']);
    }

    /**
     * Show the form for editing the Product Variant Option.
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $variant_option = ProductVariantOption::query()->findOrFail($id);

        // without model relation: inclusive
//        $variant = ProductVariant::query()->findOrFail($variant_option->product_variant_id);
//        $product = Product::query()->findOrFail($variant->product_id);

        $product_id = $variant_option->productVariant->product_id;
        $variant_id = $variant_option->product_variant_id;

        return view('admin.product.product-variant-option.edit', compact(
            'variant_option', 'variant_id', 'product_id'
        ));
    }

    /**
     * Update the Product Variant Option.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200'],
            'price' => ['required', 'integer'],
            'is_default' => ['required'],
            'status' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with(['message' => $error, 'alert-type' => 'error']);
        }

        $variant_option = ProductVariantOption::query()->findOrFail($id);

        $variant_option->name = $request->name;
        $variant_option->price = $request->price;
        $variant_option->is_default = $request->is_default;
        $variant_option->status = $request->status;

        $variant_option->save();

        return redirect()->route('admin.products-variant-option.index',
            [
                'productId' => $variant_option->productVariant->product_id,
                'variantId' => $variant_option->product_variant_id
            ]
        )->with(['message' => 'Product Variant Option Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $variant = ProductVariantOption::query()->findOrFail($id);

        $variant->delete();

        return response([
            'status' => 'success',
            'message' => 'Variant Option Deleted Successfully.'
        ]);
    }

    /**
     * Handles Product Variant Option Status Update
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changeStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $slider = ProductVariantOption::query()->findOrFail($request->idToggle);

        $slider->status = ($request->isChecked == 'true' ? 1 : 0);
        $slider->save();

        return response([
            'status' => 'success',
            'message' => 'Variant Option Status Updated.'
        ]);
    }

    /**
     * Handles Product Variant Option `Is-Default` Update
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changeIsDefault(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $slider = ProductVariantOption::query()->findOrFail($request->idToggle);

        $slider->is_default = ($request->isChecked == 'true' ? 1 : 0);
        $slider->save();

        return response([
            'status' => 'success',
            'message' => 'Variant Option Is-Default Updated.'
        ]);
    }
}
