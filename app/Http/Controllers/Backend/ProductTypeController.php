<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ProductTypeDataTable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductType;
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

class ProductTypeController extends Controller
{
    use ImageUploadTrait;

    /**
     * Display a listing of the resource.
     *
     * @param ProductTypeDataTable $dataTable
     * @return mixed
     */
    public function index(ProductTypeDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $degrees_available = /*$this->degreesAvailable()*/$this->productTypeDegrees();

        return view('admin.type.create', compact('degrees_available'));
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

        $type = new ProductType();

        $this->productTypeSave($request, $type);

        return redirect()->route('admin.type.index')
            ->with(['message' => 'New Type Added']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $type = ProductType::findOrFail($id);
        $degrees_available = /*$this->degreesAvailable()*/$this->productTypeDegrees();

        return view('admin.type.edit', compact('type', 'degrees_available'));
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
        $this->validateRequest($request);

        $type = ProductType::findOrFail($id);

        $this->productTypeSave($request, $type);

        return redirect()->route('admin.type.index')
            ->with(['message' => 'Product Type Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
     */
    public function destroy(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $type = ProductType::findOrFail($id);

        if (Product::where('product_type_id', $type->id)->count() > 0) {
            return response([
                'status' => 'error',
                'message' => 'This type has products, you can\'t delete it.'
            ]);
        }

        return response([
            'status' => 'success',
            'message' => 'Type Deleted Successfully.'
        ]);
    }

    /**
     * Handles Type Status Update
     *
     * @param Request $request
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
     */
    public function changeStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $type = ProductType::findOrFail($request->input('idToggle'));

        $type->status = ($request->input('isChecked') === 'true' ? 1 : 0);
        $type->save();

        return response([
            'status' => 'success',
            'message' => 'Status Updated'
        ]);
    }

    /**
     * Handles Type `Is-Featured` Update
     *
     * @param Request $request
     * @return Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
     */
    public function changeIsPackage(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $type = ProductType::findOrFail($request->input('idToggle'));

        $type->is_package = ($request->input('isChecked') === 'true' ? 1 : 0);
        $type->save();

        return response([
            'status' => 'success',
            'message' => 'Is-Package Status Updated'
        ]);
    }

    /**
     * Validate the given request.
     *
     * @param Request $request
     * @return void
     */
    protected function validateRequest(Request $request): void
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:200'],
            'is_package' => ['required'],
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
     * Save Type
     *
     * @param Request $request
     * @param $type
     */
    protected function productTypeSave(Request $request, $type): void
    {
        $type->name = $request->input('name');
        $type->slug = Str::slug($request->input('name'));
        $type->is_package = $request->input('is_package');
        $type->degree = $request->input('degree') ?? 0;
        $type->status = $request->input('status');

        $type->save();
    }

    /**
     * Degrees assignable to a type
     *
     * @return int[]
     */
    public function productTypeDegrees(): array
    {
        return [1, 2, 3, 4, 5, 6, 7, 8, 9];
    }

    /**
     * @return array
     */
    public function degreesAvailable(): array
    {
        $packages = ProductType::where('is_package', 1)->orderBy('degree')->get();

        $package_degrees = [];

        if (count($packages) > 0) {
            foreach ($packages as $package) {
                $package_degrees[] = $package->degree;
            }
        }

        return array_diff($this->productTypeDegrees(), $package_degrees);
    }
}
