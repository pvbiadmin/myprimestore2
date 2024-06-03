<?php

namespace App\Traits;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductImageGallery;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

trait ProductTrait
{
    use ImageUploadTrait;

    /**
     * Save Product
     *
     * @param Request $request
     * @param $product
     * @param $image_path
     * @param false $update
     * @param bool $vendor
     */
    public function saveProduct(Request $request, $product, $image_path, $vendor = false, $update = false): void
    {
        if ($image_path) {
            $product->thumb_image = $image_path;
        }

        $product->name = $request->input('name');
        $product->points = $request->input('points') ?? (
            hasReferral(Auth::user()->id) ? $request->input('price') : 0);
        $product->slug = Str::slug($request->input('name'));

        if (!$update) {
            $product->vendor_id = Auth::user()->vendor->id;
        }

        $product->category_id = $request->input('category');
        $product->subcategory_id = $request->input('subcategory');
        $product->child_category_id = $request->input('child_category');
        $product->brand_id = $request->input('brand');
        $product->quantity = $request->input('quantity');
        $product->short_description = $request->input('short_description');
        $product->long_description = $request->input('long_description');
        $product->video_link = $request->input('video_link');

        if ($request->input('sku')) {
            $product->sku = $request->input('sku');
        } else if (!$update) {
            $product->sku = $this->generateSKU($request);
        }

        $product->price = $request->input('price');
        $product->offer_price = $request->input('offer_price');
        $product->offer_start_date = $request->input('offer_start_date');
        $product->offer_end_date = $request->input('offer_end_date');
        $product->status = $request->input('status');

        if (!$vendor) {
//            $product->product_type = $request->input('product_type');
            $product->product_type_id = $request->input('product_type');
        }

        if (!$update) {
            $product->is_approved = $vendor ? 0 : 1;
        }

        $product->seo_title = $request->input('seo_title');
        $product->seo_description = $request->input('seo_description');

        $product->save();
    }

    /**
     * Delete product image from the directory
     *
     * @param $product
     */
    public function deleteProductImage($product): void
    {
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
    }

    /**
     * Validate Input Request
     *
     * @param Request $request
     * @param bool $update
     */
    public function validateRequest(Request $request, $update = false): void
    {
        $image_rule = ['image', 'max:3000'];

        if (!$update) {
            $image_rule[] = 'required';
        } else {
            $image_rule[] = 'nullable';
        }

        $validator = Validator::make($request->all(), [
            'image' => $image_rule,
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
            redirect()->back()->withInput()
                ->with(['message' => $error, 'alert-type' => 'error'])
                ->throwResponse();
        }
    }

    /**
     * Generate SKU based on inputs
     *
     * @param Request $request
     * @return string
     */
    protected function generateSKU(Request $request): string
    {
        // Fetch category and brand codes
        $categoryCode = $this->getCategoryCode($request->input('category'));
        $brandCode = $this->getBrandCode($request->input('brand'));
        $uniqueId = Str::upper(Str::random(6));

        return $categoryCode . '-' . $brandCode . '-' . $uniqueId;
    }

    /**
     * Category Code Fragment for SKU
     *
     * @param $categoryId
     * @return string
     */
    protected function getCategoryCode($categoryId): string
    {
        $category = Category::find($categoryId); // Assuming Category model exists
        return $category ? Str::upper(Str::substr($category->name, 0, 3)) : 'GEN';
    }

    /**
     * Brand Code Fragment for SKU
     *
     * @param $brandId
     * @return string
     */
    protected function getBrandCode($brandId): string
    {
        $brand = Brand::find($brandId); // Assuming Brand model exists
        return $brand ? Str::upper(Str::substr($brand->name, 0, 3)) : 'GEN';
    }
}
