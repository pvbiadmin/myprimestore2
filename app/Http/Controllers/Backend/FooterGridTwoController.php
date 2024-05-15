<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\FooterGridTwoDataTable;
use App\Http\Controllers\Controller;
use App\Models\FooterGridTwo;
use App\Models\FooterTitle;
use App\Traits\FooterGridTrait;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FooterGridTwoController extends Controller
{
    use FooterGridTrait;

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
        $this->validateRequest($request);

        FooterGridTwo::create([
            'name' => $request->input('name'),
            'url' => $request->input('url'),
            'status' => $request->input('status'),
        ]);

        Cache::forget('footer_grid_two');

        return redirect()->route('admin.footer-grid-two.index')
            ->with(['message' => 'Created Successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
     */
    public function edit(string $id): View|Factory|Application
    {
        $footer = FooterGridTwo::findOrFail($id);
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
        $this->validateRequest($request);

        $footer = FooterGridTwo::findOrFail($id);
        $footer->update([
            'name' => $request->input('name'),
            'url' => $request->input('url'),
            'status' => $request->input('status'),
        ]);

        Cache::forget('footer_grid_two');

        return redirect()->route('admin.footer-grid-two.index')
            ->with(['message' => 'Updated Successfully']);
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
        $slider = FooterGridTwo::query()->findOrFail($request->input('idToggle'));

        $slider->status = ($request->input('isChecked') === 'true' ? 1 : 0);
        $slider->save();

        Cache::forget('footer_grid_two');

        return response([
            'status' => 'success',
            'message' => 'Status Updated'
        ]);
    }

    /**
     * Change Footer Grid Title
     *
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
            ['footer_grid_two_title' => $request->input('title')]
        );

        return redirect()->back()->with(['message' => 'Updated Successfully']);
    }
}
