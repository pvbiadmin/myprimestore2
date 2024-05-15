<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FooterGridTwoDataTable;
use App\Http\Controllers\Controller;
use App\Models\FooterGridTwo;
use App\Models\FooterTitle;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FooterGridTwoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\FooterGridTwoDataTable $dataTable
     * @return mixed
     */
    public function index(FooterGridTwoDataTable $dataTable): mixed
    {
        $footerTitle = FooterTitle::query()->first();
        return $dataTable->render('admin.footer.footer-grid-two.index', compact('footerTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.footer.footer-grid-two.create');
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
            'name' => ['required', 'max:200'],
            'url' => ['required', 'url'],
            'status' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with(['message' => $error, 'alert-type' => 'error']);
        }

        $footer = new FooterGridTwo();

        $footer->name = $request->name;
        $footer->url = $request->url;
        $footer->status = $request->status;

        $footer->save();

        Cache::forget('footer_grid_two');

        return redirect()->route('admin.footer-grid-two.index')
            ->with(['message' => 'Created Successfully']);
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
        $footer = FooterGridTwo::query()->findOrFail($id);
        return view('admin.footer.footer-grid-two.edit', compact('footer'));
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
            'name' => ['required', 'max:200'],
            'url' => ['required', 'url'],
            'status' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()
                ->with(['message' => $error, 'alert-type' => 'error']);
        }

        $footer = FooterGridTwo::query()->findOrFail($id);

        $footer->name = $request->name;
        $footer->url = $request->url;
        $footer->status = $request->status;

        $footer->save();

        Cache::forget('footer_grid_two');

        return redirect()->route('admin.footer-grid-two.index')
            ->with(['message' => 'Update Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $footer = FooterGridTwo::query()->findOrFail($id);
        $footer->delete();

        Cache::forget('footer_grid_two');

        return response(['status' => 'success', 'message' => 'Deleted successfully']);
    }

    /**
     * Handles Flash Sale Status Update
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function changeStatus(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $slider = FooterGridTwo::query()->findOrFail($request->idToggle);

        $slider->status = ($request->isChecked == 'true' ? 1 : 0);
        $slider->save();

        Cache::forget('footer_grid_two');

        return response([
            'status' => 'success',
            'message' => 'Status Updated'
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeTitle(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'max:200']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()
                ->with(['message' => $error, 'alert-type' => 'error']);
        }

        FooterTitle::query()->updateOrCreate(
            ['id' => 1],
            ['footer_grid_two_title' => $request->title]
        );

        return redirect()->back()->with(['message' => 'Updated Successfully']);
    }
}
