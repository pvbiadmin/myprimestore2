<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductVariantDataTable;
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

class ProductVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\DataTables\ProductVariantDataTable $dataTable
     * @return mixed
     */
    public function index(Request $request, ProductVariantDataTable $dataTable): mixed
    {
        $product = Product::query()->findOrFail($request->product);

        return $dataTable->render('admin.product.product-variant.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.product.product-variant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'product' => ['required', 'integer'],
            'name' => ['required', 'max:200'],
            'status' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with(['message' => $error, 'alert-type' => 'error']);
        }

        $variant = new ProductVariant();

        $variant->product_id = $request->product;
        $variant->name = $request->name;
        $variant->status = $request->status;

        $variant->save();

        return redirect()
            ->route('admin.products-variant.index', ['product' => $request->product])
            ->with(['message' => 'Product Variant Added Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $variant = ProductVariant::query()->findOrFail($id);
        $product = Product::query()->findOrFail($variant->product_id);

        return view('admin.product.product-variant.edit', compact('variant', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200'],
            'status' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with(['message' => $error, 'alert-type' => 'error']);
        }

        $variant = ProductVariant::query()->findOrFail($id);

        $variant->name = $request->name;
        $variant->status = $request->status;

        $variant->save();

        return redirect()
            ->route('admin.products-variant.index', ['product' => $variant->product_id])
            ->with(['message' => 'Product Variant Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $variant = ProductVariant::query()->findOrFail($id);

        $count_variant_option = ProductVariantOption::query()
            ->where('product_variant_id', '=', $variant->id)->count();

        $has_variant_option = $count_variant_option > 0;

        if ($has_variant_option) {
            return response([
                'status' => 'error',
                'message' => 'Contains Variant Option, kindly remove the corresponding Variant Option before proceeding.'
            ]);
        }

        $variant->delete();

        return response([
            'status' => 'success',
            'message' => 'Variant Deleted Successfully.'
        ]);
    }

    /**
     * Handles Variant Status Update
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changeStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $variant = ProductVariant::query()->findOrFail($request->idToggle);

        $variant->status = ($request->isChecked == 'true' ? 1 : 0);
        $variant->save();

        return response([
            'status' => 'success',
            'message' => 'Variant Status Updated.'
        ]);
    }
}
