<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Models\ProductVariant;
use App\Models\Subcategory;
use App\Traits\ImageUploadTrait;
use Auth;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    use ImageUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\ProductDataTable $dataTable
     * @return mixed
     */
    public function index(ProductDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function create(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $child_categories = ChildCategory::all();
        $brands = Brand::all();

        return view('admin.product.create',
            compact('categories', 'subcategories', 'child_categories', 'brands'));
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
            'image' => ['required', 'image', 'max:3000'],
            'name' => ['required', 'max:200'],
            'category' => ['required'],
            'brand' => ['required'],
            'price' => ['required'],
            'quantity' => ['required'],
            'short_description' => ['required', 'max:600'],
            'seo_title' => ['nullable', 'max:200'],
            'seo_description' => ['nullable', 'max:250'],
            'status' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with(['message' => $error, 'alert-type' => 'error']);
        }

        $product = new Product();

        // Handle image upload
        $image_path = $this->uploadImage($request, 'image', 'uploads');

        if ($image_path) {
            $product->thumb_image = $image_path;
        }

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->vendor_id = Auth::user()->vendor->id;
        $product->category_id = $request->category;
        $product->subcategory_id = $request->subcategory;
        $product->child_category_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->quantity = $request->quantity;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->video_link = $request->video_link;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->offer_start_date = $request->offer_start_date;
        $product->offer_end_date = $request->offer_end_date;
        $product->product_type = $request->product_type;
        $product->status = $request->status;
        $product->is_approved = 1;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;

        $product->save();

        return redirect()->route('admin.products.index')->with(['message' => 'Product Added Successfully']);
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
        $product = Product::query()->findOrFail($id);
        $categories = Category::all();
        $subcategories = Subcategory::query()
            ->where('category_id', '=', $product->category_id)->get();
        $child_categories = ChildCategory::query()
            ->where('subcategory_id', '=', $product->subcategory_id)->get();
        $brands = Brand::all();

        return view('admin.product.edit', compact(
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
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'image' => ['nullable', 'image', 'max:3000'],
            'name' => ['required', 'max:200'],
            'category' => ['required'],
            'brand' => ['required'],
            'price' => ['required'],
            'quantity' => ['required'],
            'short_description' => ['required', 'max:600'],
            'seo_title' => ['nullable', 'max:200'],
            'seo_description' => ['nullable', 'max:250'],
            'status' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with(['message' => $error, 'alert-type' => 'error']);
        }

        $product = Product::query()->findOrFail($id);

        // Handle image upload
        $image_path = $this->updateImage($request, 'image', 'uploads', $product->thumb_image);

        if ($image_path) {
            $product->thumb_image = $image_path;
        }

        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
//        $product->vendor_id = Auth::user()->vendor->id;
        $product->category_id = $request->category;
        $product->subcategory_id = $request->subcategory;
        $product->child_category_id = $request->child_category;
        $product->brand_id = $request->brand;
        $product->quantity = $request->quantity;
        $product->short_description = $request->short_description;
        $product->long_description = $request->long_description;
        $product->video_link = $request->video_link;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->offer_start_date = $request->offer_start_date;
        $product->offer_end_date = $request->offer_end_date;
        $product->product_type = $request->product_type;
        $product->status = $request->status;
//        $product->is_approved = 1;
        $product->seo_title = $request->seo_title;
        $product->seo_description = $request->seo_description;

        $product->save();

        return redirect()->route('admin.products.index')
            ->with(['message' => 'Product Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
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

        $this->deleteImage($product->thumb_image);

        $images = ProductImageGallery::query()
            ->where('product_id', '=', $product->id)->get();

        if ($images) {
            foreach ($images as $image) {
                $this->deleteImage($image->image);
                $image->delete();
            }
        }

        $variants = ProductVariant::query()
            ->where('product_id', '=', $product->id)->get();

        if ($variants) {
            foreach ($variants as $variant) {
                $variant->productVariantOptions()->delete();
                $variant->delete();
            }
        }

        $product->delete();

        return response([
            'status' => 'success',
            'message' => 'Product Deleted Successfully.'
        ]);
    }

    /**
     * Handles Category Status Update
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changeStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $product = Product::query()->findOrFail($request->idToggle);

        $product->status = ($request->isChecked == 'true' ? 1 : 0);
        $product->save();

        return response([
            'status' => 'success',
            'message' => 'Product Status Updated.'
        ]);
    }

    /**
     * Get all product subcategories
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function getSubcategories(Request $request): Collection|array
    {
        return Subcategory::query()->where('category_id', '=', $request->catFamId)->get();
    }

    /**
     * Get all product child-categories
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function getChildCategories(Request $request): Collection|array
    {
        return ChildCategory::query()->where('subcategory_id', '=', $request->catFamId)->get();
    }
}
