<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Traits\ImageUploadTrait;
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

class SliderController extends Controller
{
    use ImageUploadTrait;

    /**
     * @param \App\DataTables\SliderDataTable $dataTable
     * @return mixed
     */
    public function index(SliderDataTable $dataTable): mixed
    {
        return $dataTable->render('admin.slider.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.slider.create');
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
            'image' => ['required', 'image', 'max:2048'],
            'type' => ['nullable', 'string', 'max:200'],
            'title' => ['nullable', 'string', 'max:200'],
            'subtitle' => ['nullable', 'string', 'max:200'],
            'cta_caption' => ['nullable', 'string', 'max:200'],
            'cta_link' => ['nullable', 'url'],
            'serial' => ['required', 'integer'],
            'status' => ['required', 'boolean'],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with(['message' => $error, 'alert-type' => 'error']);
        }

        $slider = new Slider();

        // handle image upload
        $image_path = $this->uploadImage($request, 'image', 'uploads');

        $this->saveSlider($request, $slider, $image_path);

        return redirect()->route('admin.slider.index')
            ->with(['message' => 'Slider Added Successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function edit(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $slider = Slider::query()->findOrFail($id);

        return view('admin.slider.edit', compact('slider'));
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
            'image' => ['nullable', 'image', 'max:2048'],
            'type' => ['nullable', 'string', 'max:200'],
            'title' => ['nullable', 'string', 'max:200'],
            'subtitle' => ['nullable', 'string', 'max:200'],
            'cta_caption' => ['nullable', 'string', 'max:200'],
            'cta_link' => ['nullable', 'url'],
            'serial' => ['required', 'integer'],
            'status' => ['required']
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->with(['message' => $error, 'alert-type' => 'error']);
        }

        $slider = Slider::query()->findOrFail($id);

        // Update image
        $image_path = $this->updateImage(
            $request,
            'image',
            'uploads',
            $slider->image
        );

        if ($image_path) {
            $slider->image = $image_path;
        }

        $this->saveSlider($request, $slider, $image_path);

        return redirect()->route('admin.slider.index')
            ->with(['message' => 'Slider Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     * @return \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function destroy(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $slider = Slider::query()->findOrFail($id);

        if (!empty($slider->image)) {
            $this->deleteImage($slider->image);
            $slider->delete();
        }

        return response([
            'status' => 'success',
            'message' => 'Slider Deleted Successfully.'
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
        $slider = Slider::query()->findOrFail($request->input('idToggle'));

        $slider->status = ($request->input('isChecked') === 'true' ? 1 : 0);
        $slider->save();

        return response([
            'status' => 'success',
            'message' => 'Slider Status Updated.'
        ]);
    }

    /**
     * Save Slider entry
     *
     * @param \Illuminate\Http\Request $request
     * @param $slider
     * @param $image_path
     */
    public function saveSlider(Request $request, $slider, $image_path): void
    {
        if ($image_path) {
            $slider->image = $image_path;
        }

        $slider->type = $request->input('type');
        $slider->title = $request->input('title');
        $slider->subtitle = $request->input('subtitle');
        $slider->cta_caption = $request->input('cta_caption');
        $slider->cta_link = $request->input('cta_link');
        $slider->serial = $request->input('serial');
        $slider->status = $request->input('status');

        $slider->save();

        Cache::forget('sliders');
    }
}
