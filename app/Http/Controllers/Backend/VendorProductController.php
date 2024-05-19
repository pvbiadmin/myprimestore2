<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\Subcategory;
use App\Traits\ImageUploadTrait;
use App\Traits\ProductTrait;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class VendorProductController extends Controller
{
    use ImageUploadTrait;
    use ProductTrait;

    /**
     * Display a listing of the resource.
     *
     * @param VendorProductDataTable $dataTable
     * @return mixed
     */
    public function index(VendorProductDataTable $dataTable): mixed
    {
        return $dataTable->render('vendor.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function create(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $brands = Brand::all();
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $child_categories = ChildCategory::all();

        return view('vendor.product.create',
            compact('brands', 'categories', 'subcategories', 'child_categories'));
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

        $product = new Product();

        // Handle image upload
        $image_path = $this->uploadImage($request, 'image', 'uploads');

        $this->saveProduct($request, $product, $image_path, true);

        return redirect()->route('vendor.products.index')
            ->with(['message' => 'Vendor Product Added Successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $product = Product::query()->findOrFail($id);

        if ($product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }

        $categories = Category::all();
        $subcategories = Subcategory::query()
            ->where('category_id', '=', $product->category_id)->get();
        $child_categories = ChildCategory::query()
            ->where('subcategory_id', '=', $product->subcategory_id)->get();
        $brands = Brand::all();

        return view('vendor.product.edit', compact(
            'product',
            'brands',
            'categories',
            'subcategories',
            'child_categories'
        ));
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
        $product = Product::query()->findOrFail($id);

        if ($product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }

        $this->validateRequest($request, true);

        // Handle image upload
        $image_path = $this->updateImage($request, 'image', 'uploads', $product->thumb_image);

        $this->saveProduct($request, $product, $image_path, true, true);

        return redirect()->route('vendor.products.index')
            ->with(['message' => 'Vendor Product Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
     */
    public function destroy(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $product = Product::query()->findOrFail($id);

        if ($product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }

        $this->deleteProductImage($product);

        return response([
            'status' => 'success',
            'message' => 'Vendor Product Deleted Successfully.'
        ]);
    }

    /**
     * Handles Category Status Update
     *
     * @param Request $request
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
     */
    public function changeStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $product = Product::query()->findOrFail($request->input('idToggle'));

        $product->status = ($request->input('isChecked') === 'true' ? 1 : 0);
        $product->save();

        return response([
            'status' => 'success',
            'message' => 'Vendor Product Status Updated.'
        ]);
    }

    /**
     * Get all product subcategories
     *
     * @param Request $request
     * @return Collection|array
     */
    public function getSubcategories(Request $request): Collection|array
    {
        return Subcategory::query()
            ->where('category_id', '=', $request->input('catFamId'))
            ->get();
    }

    /**
     * Get all product child-categories
     *
     * @param Request $request
     * @return Collection|array
     */
    public function getChildCategories(Request $request): Collection|array
    {
        return ChildCategory::query()
            ->where('subcategory_id', '=', $request->input('catFamId'))
            ->get();
    }
}
