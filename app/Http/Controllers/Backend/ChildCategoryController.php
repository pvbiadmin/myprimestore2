<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ChildCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\HomePageSetting;
use App\Models\Product;
use App\Models\Subcategory;
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

class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\ChildCategoryDataTable $dataTable
     * @return mixed
     */
    public function index(ChildCategoryDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.child-category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('admin.child-category.create',
            compact('categories', 'subcategories'));
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
            'category' => ['required'],
            'subcategory' => ['required'],
            'name' => ['required', 'max:200', 'unique:child_categories,name'],
            'status' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with(['message' => $error, 'alert-type' => 'error']);
        }

        $child_category = new ChildCategory();

        $child_category->category_id = $request->category;
        $child_category->subcategory_id = $request->subcategory;
        $child_category->name = $request->name;
        $child_category->slug = Str::slug($request->name);
        $child_category->status = $request->status;

        $child_category->save();

        return redirect()->route('admin.child-category.index')
            ->with(['message' => 'Child Category Added Successfully']);
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
        $child_category = ChildCategory::query()->findOrFail($id);

        $categories = Category::all();

        $subcategories = Subcategory::query()
            ->where('category_id', '=', $child_category->category_id)
            ->get();

        return view(
            'admin.child-category.edit',
            compact('categories', 'subcategories', 'child_category')
        );
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
            'category' => ['required'],
            'subcategory' => ['required'],
            'name' => ['required', 'max:200', 'unique:child_categories,name,' . $id],
            'status' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with(['message' => $error, 'alert-type' => 'error']);
        }

        $child_category = ChildCategory::query()->findOrFail($id);

        $child_category->category_id = $request->category;
        $child_category->subcategory_id = $request->subcategory;
        $child_category->name = $request->name;
        $child_category->slug = Str::slug($request->name);
        $child_category->status = $request->status;

        $child_category->save();

        return redirect()->route('admin.child-category.index')
            ->with(['message' => 'Child-Category Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $child_category = ChildCategory::query()->findOrFail($id);

        if (Product::where('child_category_id', $child_category->id)->count() > 0) {
            return response([
                'status' => 'error',
                'message' => 'This item contains relation, can\'t delete it.'
            ]);
        }

        $homeSettings = HomePageSetting::all();

        foreach ($homeSettings as $item) {
            $array = json_decode($item->value, true);
            $collection = collect($array);

            if ($collection->contains('child_category', $child_category->id)) {
                return response([
                    'status' => 'error',
                    'message' => 'This item contains relations, can\'t delete it.'
                ]);
            }
        }

        $child_category->delete();

        return response([
            'status' => 'success',
            'message' => 'Child-Category Deleted Successfully.'
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function getSubcategories(Request $request): Collection|array
    {
        return Subcategory::query()
            ->where('category_id', '=', $request->categoryId)
            ->where('status', '=', 1)
            ->get();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changeStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $child_category = ChildCategory::query()->findOrFail($request->idToggle);

        $child_category->status = ($request->isChecked == 'true' ? 1 : 0);
        $child_category->save();

        return response([
            'status' => 'success',
            'message' => 'Child-Category Status Updated.'
        ]);
    }
}
