<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\BrandDataTable;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Traits\ImageUploadTrait;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BrandController extends Controller
{
    use ImageUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\BrandDataTable $dataTable
     * @return mixed
     */
    public function index(BrandDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validateRequest($request);

        $brand = new Brand();

        $image_path = $this->uploadImage($request, 'logo', 'uploads');

        $this->brandSave($request, $brand, $image_path);

        return redirect()->route('admin.brand.index')
            ->with(['message' => 'New Brand Added']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $brand = Brand::query()->findOrFail($id);

        return view('admin.brand.edit', compact('brand'));
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
        $this->validateRequest($request, true);

        $brand = Brand::query()->findOrFail($id);

        $image_path = $this->updateImage($request, 'logo', 'uploads', $brand->logo);

        $this->brandSave($request, $brand, $image_path);

        return redirect()->route('admin.brand.index')
            ->with(['message' => 'Brand Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $brand = Brand::query()->findOrFail($id);

        if (Product::where('brand_id', $brand->id)->count() > 0) {
            return response([
                'status' => 'error',
                'message' => 'This brand has products, you can\'t delete it.'
            ]);
        }

        if (!empty($brand->logo)) {
            $this->deleteImage($brand->logo);
            $brand->delete();
        }

        return response([
            'status' => 'success',
            'message' => 'Brand Deleted Successfully.'
        ]);
    }

    /**
     * Handles Brand Status Update
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changeStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $slider = Brand::query()->findOrFail($request->input('idToggle'));

        $slider->status = ($request->input('isChecked') === 'true' ? 1 : 0);
        $slider->save();

        return response([
            'status' => 'success',
            'message' => 'Brand Status Updated.'
        ]);
    }

    /**
     * Handles Brand `Is-Featured` Update
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changeIsFeatured(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $slider = Brand::query()->findOrFail($request->input('idToggle'));

        $slider->is_featured = ($request->input('isChecked') === 'true' ? 1 : 0);
        $slider->save();

        return response([
            'status' => 'success',
            'message' => 'Brand Is-Featured Updated.'
        ]);
    }

    /**
     * Validate the given request.
     *
     * @param \Illuminate\Http\Request $request
     * @param bool $update
     * @return void
     */
    protected function validateRequest(Request $request, $update = false): void
    {
        $logo_rules = ['image', 'max:2048'];

        if (!$update) {
            $logo_rules[] = 'required';
        }

        $validator = Validator::make($request->all(), [
            'logo' => $logo_rules,
            'name' => ['required', 'max:200'],
            'is_featured' => ['required'],
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
     * Save Brand
     *
     * @param \Illuminate\Http\Request $request
     * @param $brand
     * @param $image_path
     */
    protected function brandSave(Request $request, $brand, $image_path): void
    {
        if ($image_path) {
            $brand->logo = $image_path;
        }

        $brand->name = $request->input('name');
        $brand->slug = Str::slug($request->input('name'));
        $brand->is_featured = $request->input('is_featured');
        $brand->status = $request->input('status');

        $brand->save();
    }
}
