<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductType;
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

class ProductController extends Controller
{
    use ImageUploadTrait;
    use ProductTrait;

    /**
     * Display a listing of the resource.
     *
     * @param ProductDataTable $dataTable
     * @return mixed
     */
    public function index(ProductDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function create(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $child_categories = ChildCategory::all();
        $brands = Brand::all();
        $types = ProductType::all();

        return view('admin.product.create',
            compact('categories', 'subcategories', 'child_categories', 'brands', 'types'));
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

        $image_path = $this->uploadImage($request, 'image', 'uploads');

        $this->saveProduct($request, $product, $image_path, false);

        return redirect()->route('admin.products.index')
            ->with(['message' => 'Product Added Successfully']);
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
        $categories = Category::all();
        $subcategories = Subcategory::query()
            ->where('category_id', '=', $product->category_id)->get();
        $child_categories = ChildCategory::query()
            ->where('subcategory_id', '=', $product->subcategory_id)->get();
        $brands = Brand::all();
        $types = ProductType::all();

        return view('admin.product.edit', compact(
            'product',
            'brands',
            'categories',
            'subcategories',
            'child_categories',
            'types'
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
        $this->validateRequest($request, true);

        $product = Product::query()->findOrFail($id);

        // Handle image upload
        $image_path = $this->updateImage($request, 'image', 'uploads', $product->thumb_image);

        $this->saveProduct($request, $product, $image_path, false, true);

        return redirect()->route('admin.products.index')
            ->with(['message' => 'Product Updated Successfully']);
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

        if (OrderProduct::where('product_id', $product->id)->count() > 0) {
            return response([
                'status' => 'error',
                'message' => 'This product has orders, can\'t delete it.'
            ]);
        }

        $this->deleteProductImage($product);

        return response([
            'status' => 'success',
            'message' => 'Product Deleted Successfully.'
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
            'message' => 'Product Status Updated.'
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
