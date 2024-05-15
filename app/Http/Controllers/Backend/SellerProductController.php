<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SellerPendingProductsDataTable;
use App\DataTables\SellerProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SellerProductController extends Controller
{
    /**
     * @param \App\DataTables\SellerProductDataTable $dataTable
     * @return mixed
     */
    public function index(SellerProductDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.product.seller-product.index');
    }

    /**
     * @param \App\DataTables\SellerPendingProductsDataTable $dataTable
     * @return mixed
     */
    public function pendingProducts(SellerPendingProductsDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.product.seller-product.pending');
    }

    /**
     * Handles Product Variant Option Status Update
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changeStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $slider = Product::query()->findOrFail($request->idToggle);

        $slider->status = ($request->isChecked == 'true' ? 1 : 0);
        $slider->save();

        return response([
            'status' => 'success',
            'message' => 'Product Status Updated.'
        ]);
    }

    /**
     * Handles Approval of Pending Products
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changeIsApproved(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $slider = Product::query()->findOrFail($request->idToggle);

        $slider->is_approved = ($request->isChecked == 'true' ? 1 : 0);
        $slider->save();

        return response([
            'status' => 'success',
//            'url' => route('admin.seller-products.' . ($request->isChecked == 'true' ? 'index' : 'pending')),
            'message' => 'Product Approval Updated.'
        ]);
    }
}
