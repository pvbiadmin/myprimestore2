<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\VendorProductImageGalleryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImageGallery;
use App\Traits\ImageUploadTrait;
use Auth;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class VendorProductImageGalleryController extends Controller
{
    use ImageUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\DataTables\VendorProductImageGalleryDataTable $dataTable
     * @return mixed
     */
    public function index(Request $request, VendorProductImageGalleryDataTable $dataTable): mixed
    {
        $product = Product::query()->findOrFail($request->product);

        if ($product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }

        return $dataTable->render('vendor.product.image-gallery.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            'image.*' => ['required', 'image', 'max:2048']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with(['message' => $error, 'alert-type' => 'error']);
        }

        $paths = $this->uploadMultiImage($request, 'image', 'uploads');

        if ($paths) {
            foreach ($paths as $path) {
                $product_image_gallery = new ProductImageGallery();

                $product_image_gallery->image = $path;
                $product_image_gallery->product_id = $request->product;

                $product_image_gallery->save();
            }
        }

        return redirect()->back()->with(['message' => 'Vendor Product Image Uploaded Successfully']);
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
     *
     * @param string $id
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $product_image = ProductImageGallery::query()->findOrFail($id);

        if ($product_image->product->vendor_id !== Auth::user()->vendor->id) {
            abort(404);
        }

        if (!empty($product_image->image)) {
            $this->deleteImage($product_image->image);
            $product_image->delete();
        }

        return response([
            'status' => 'success',
            'message' => 'Vendor Product Image Deleted Successfully.'
        ]);
    }
}
