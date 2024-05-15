<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Traits\ImageUploadTrait;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AdvertisementController extends Controller
{
    use ImageUploadTrait;

    /**
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $homepage_section_banner_one = Advertisement::query()
            ->where('key', 'homepage_section_banner_one')->first();
        $homepage_section_banner_one = $homepage_section_banner_one
            ? json_decode($homepage_section_banner_one->value) : null;

        $homepage_section_banner_two = Advertisement::query()
            ->where('key', 'homepage_section_banner_two')->first();
        $homepage_section_banner_two = $homepage_section_banner_two
            ? json_decode($homepage_section_banner_two?->value) : null;

        $homepage_section_banner_three = Advertisement::query()
            ->where('key', 'homepage_section_banner_three')->first();
        $homepage_section_banner_three = $homepage_section_banner_three
            ? json_decode($homepage_section_banner_three?->value) : null;

        $homepage_section_banner_four = Advertisement::query()
            ->where('key', 'homepage_section_banner_four')->first();
        $homepage_section_banner_four = $homepage_section_banner_four
            ? json_decode($homepage_section_banner_four?->value) : null;

        $product_page_banner_section = Advertisement::query()
            ->where('key', 'product_page_banner_section')->first();
        $product_page_banner_section = $product_page_banner_section
            ? json_decode($product_page_banner_section?->value) : null;

        $cart_page_banner_section = Advertisement::query()
            ->where('key', 'cart_page_banner_section')->first();
        $cart_page_banner_section = json_decode($cart_page_banner_section?->value);

        return view('admin.advertisement.index', compact(
            'homepage_section_banner_one',
            'homepage_section_banner_two',
            'homepage_section_banner_three',
            'homepage_section_banner_four',
            'product_page_banner_section',
            'cart_page_banner_section'
        ));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function homepageBannerSectionOne(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'banner_image' => ['image'],
            'banner_url' => ['required'],
            'leading_text' => ['nullable', 'string', 'max:40'],
            'hook_text' => ['nullable', 'string', 'max:20'],
            'highlight_text' => ['nullable', 'string', 'max:20'],
            'followup_text' => ['nullable', 'string', 'max:20'],
            'button_text' => ['nullable', 'string', 'max:20'],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with([
                    'anchor' => 'homepage_section_banner_one',
                    'message' => $error,
                    'alert-type' => 'error'
                ]);
        }

        /** Handle the image upload */
        $imagePath = $this->updateImage($request, 'banner_image', 'uploads');

        $value = [
            'banner_one' => [
                'banner_url' => $request->banner_url,
                'status' => $request->status == 'on' ? 1 : 0,
                'leading_text' => $request->leading_text,
                'hook_text' => $request->hook_text,
                'highlight_text' => $request->highlight_text,
                'followup_text' => $request->followup_text,
                'button_text' => $request->button_text
            ]
        ];

        if (!empty($imagePath)) {
            $value['banner_one']['banner_image'] = $imagePath;
        } else {
            $value['banner_one']['banner_image'] = $request->banner_old_image;
        }

        $value = json_encode($value);

        Advertisement::query()->updateOrCreate(
            ['key' => 'homepage_section_banner_one'],
            ['value' => $value]
        );

        return redirect()->back()->with([
            'anchor' => 'homepage_section_banner_one',
            'message' => 'Updated Successfully'
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function homepageBannerSectionTwo(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'banner_one_image' => ['image'],
            'banner_one_url' => ['required'],
            'banner_one_hook_text' => ['nullable', 'string', 'max:20'],
            'banner_one_highlight_text' => ['nullable', 'string', 'max:20'],
            'banner_one_followup_text' => ['nullable', 'string', 'max:20'],
            'banner_one_button_text' => ['nullable', 'string', 'max:20'],

            'banner_two_image' => ['image'],
            'banner_two_url' => ['required'],
            'banner_two_leading_text' => ['nullable', 'string', 'max:40'],
            'banner_two_followup_text' => ['nullable', 'string', 'max:20'],
            'banner_two_button_text' => ['nullable', 'string', 'max:20'],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with([
                    'anchor' => 'homepage_section_banner_two',
                    'message' => $error,
                    'alert-type' => 'error'
                ]);
        }

        /** Handle the image upload */
        $imagePath = $this->updateImage($request, 'banner_one_image', 'uploads');
        $imagePathTwo = $this->updateImage($request, 'banner_two_image', 'uploads');

        $value = [
            'banner_one' => [
                'banner_url' => $request->banner_one_url,
                'status' => $request->banner_one_status == 'on' ? 1 : 0,
                'hook_text' => $request->banner_one_hook_text,
                'highlight_text' => $request->banner_one_highlight_text,
                'followup_text' => $request->banner_one_followup_text,
                'button_text' => $request->banner_one_button_text,
            ],
            'banner_two' => [
                'banner_url' => $request->banner_two_url,
                'status' => $request->banner_two_status == 'on' ? 1 : 0,
                'leading_text' => $request->banner_two_leading_text,
                'followup_text' => $request->banner_two_followup_text,
                'button_text' => $request->banner_two_button_text,
            ]
        ];

        if (!empty($imagePath)) {
            $value['banner_one']['banner_image'] = $imagePath;
        } else {
            $value['banner_one']['banner_image'] = $request->banner_one_old_image;
        }

        if (!empty($imagePathTwo)) {
            $value['banner_two']['banner_image'] = $imagePathTwo;
        } else {
            $value['banner_two']['banner_image'] = $request->banner_two_old_image;
        }

        $value = json_encode($value);

        Advertisement::query()->updateOrCreate(
            ['key' => 'homepage_section_banner_two'],
            ['value' => $value]
        );

        return redirect()->back()->with([
            'anchor' => 'homepage_section_banner_two',
            'message' => 'Updated Successfully'
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function homepageBannerSectionThree(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'banner_one_image' => ['image'],
            'banner_one_url' => ['required'],
            'banner_one_hook_text' => ['nullable', 'string', 'max:20'],
            'banner_one_highlight_text' => ['nullable', 'string', 'max:20'],
            'banner_one_followup_text' => ['nullable', 'string', 'max:20'],
            'banner_one_button_text' => ['nullable', 'string', 'max:20'],

            'banner_two_image' => ['image'],
            'banner_two_url' => ['required'],
            'banner_two_leading_text' => ['nullable', 'string', 'max:40'],
            'banner_two_followup_text' => ['nullable', 'string', 'max:20'],
            'banner_two_button_text' => ['nullable', 'string', 'max:20'],

            'banner_three_image' => ['image'],
            'banner_three_url' => ['required'],
            'banner_three_hook_text' => ['nullable', 'string', 'max:20'],
            'banner_three_highlight_text' => ['nullable', 'string', 'max:20'],
            'banner_three_followup_text' => ['nullable', 'string', 'max:20'],
            'banner_three_button_text' => ['nullable', 'string', 'max:20'],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with([
                    'anchor' => 'homepage_section_banner_three',
                    'message' => $error,
                    'alert-type' => 'error'
                ]);
        }

        /** Handle the image upload */
        $imagePath = $this->updateImage($request, 'banner_one_image', 'uploads');
        $imagePathTwo = $this->updateImage($request, 'banner_two_image', 'uploads');
        $imagePathThree = $this->updateImage($request, 'banner_three_image', 'uploads');

        $value = [
            'banner_one' => [
                'banner_url' => $request->banner_one_url,
                'status' => $request->banner_one_status == 'on' ? 1 : 0,
                'hook_text' => $request->banner_one_hook_text,
                'highlight_text' => $request->banner_one_highlight_text,
                'followup_text' => $request->banner_one_followup_text,
                'button_text' => $request->banner_one_button_text,
            ],
            'banner_two' => [
                'banner_url' => $request->banner_two_url,
                'status' => $request->banner_two_status == 'on' ? 1 : 0,
                'leading_text' => $request->banner_two_leading_text,
                'followup_text' => $request->banner_two_followup_text,
                'button_text' => $request->banner_two_button_text,
            ],
            'banner_three' => [
                'banner_url' => $request->banner_three_url,
                'status' => $request->banner_three_status == 'on' ? 1 : 0,
                'hook_text' => $request->banner_three_hook_text,
                'highlight_text' => $request->banner_three_highlight_text,
                'followup_text' => $request->banner_three_followup_text,
                'button_text' => $request->banner_three_button_text,
            ]
        ];

        if (!empty($imagePath)) {
            $value['banner_one']['banner_image'] = $imagePath;
        } else {
            $value['banner_one']['banner_image'] = $request->banner_one_old_image;
        }

        if (!empty($imagePathTwo)) {
            $value['banner_two']['banner_image'] = $imagePathTwo;
        } else {
            $value['banner_two']['banner_image'] = $request->banner_two_old_image;
        }

        if (!empty($imagePathThree)) {
            $value['banner_three']['banner_image'] = $imagePathThree;
        } else {
            $value['banner_three']['banner_image'] = $request->banner_three_old_image;
        }

        $value = json_encode($value);

        Advertisement::query()->updateOrCreate(
            ['key' => 'homepage_section_banner_three'],
            ['value' => $value]
        );

        return redirect()->back()->with([
            'anchor' => 'homepage_section_banner_three',
            'message' => 'Updated Successfully'
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function homepageBannerSectionFour(Request $request): RedirectResponse
    {
        /*dd($request->all());*/
        $validator = Validator::make($request->all(), [
            'banner_image' => ['image'],
            'banner_header' => ['nullable', 'string', 'max:40'],
            'banner_description' => ['nullable', 'string', 'max:120'],
            'button1_url' => ['nullable', 'url'],
            'button1_text' => ['nullable', 'string', 'max:40'],

            'leading_text' => ['nullable', 'string', 'max:40'],
            'highlight_text' => ['nullable', 'string', 'max:40'],
            'followup_text' => ['nullable', 'string', 'max:40'],
            'button2_url' => ['nullable', 'url'],
            'button2_text' => ['nullable', 'string', 'max:40'],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with([
                    'anchor' => 'homepage_section_banner_four',
                    'message' => $error,
                    'alert-type' => 'error'
                ]);
        }

        /** Handle the image upload */
        $imagePath = $this->updateImage($request, 'banner_image', 'uploads');

        $value = [
            'banner_one' => [
                'status' => $request->status == 'on' ? 1 : 0,
                'banner_header' => $request->banner_header,
                'banner_description' => $request->banner_description,
                'button1_url' => $request->button1_url,
                'button1_text' => $request->button1_text,
                'leading_text' => $request->leading_text,
                'highlight_text' => $request->highlight_text,
                'followup_text' => $request->followup_text,
                'button2_url' => $request->button2_url,
                'button2_text' => $request->button2_text,
                'default_url' => $request->default_url1 == 'on'
                    ? $request->button1_url : $request->button2_url,
            ]
        ];

        if (!empty($imagePath)) {
            $value['banner_one']['banner_image'] = $imagePath;
        } else {
            $value['banner_one']['banner_image'] = $request->banner_old_image;
        }

        /*dd($value);*/

        $value = json_encode($value);

        Advertisement::query()->updateOrCreate(
            ['key' => 'homepage_section_banner_four'],
            ['value' => $value]
        );

        return redirect()->back()->with([
            'anchor' => 'homepage_section_banner_four',
            'message' => 'Updated Successfully'
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function productPageBanner(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'banner_image' => ['image'],
            'banner_url' => ['required'],
            'leading_text' => ['nullable', 'string', 'max:60'],
            'hook_text' => ['nullable', 'string', 'max:40'],
            'highlight_text' => ['nullable', 'string', 'max:40'],
            'followup_text' => ['nullable', 'string', 'max:40'],
            'button_text' => ['nullable', 'string', 'max:40'],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with([
                    'anchor' => 'product_page_banner_section',
                    'message' => $error,
                    'alert-type' => 'error'
                ]);
        }

        /** Handle the image upload */
        $imagePath = $this->updateImage($request, 'banner_image', 'uploads');

        $value = [
            'banner_one' => [
                'banner_url' => $request->banner_url,
                'status' => $request->status == 'on' ? 1 : 0,
                'leading_text' => $request->leading_text,
                'hook_text' => $request->hook_text,
                'highlight_text' => $request->highlight_text,
                'followup_text' => $request->followup_text,
                'button_text' => $request->button_text
            ]
        ];

        if (!empty($imagePath)) {
            $value['banner_one']['banner_image'] = $imagePath;
        } else {
            $value['banner_one']['banner_image'] = $request->banner_old_image;
        }

        $value = json_encode($value);

        Advertisement::query()->updateOrCreate(
            ['key' => 'product_page_banner_section'],
            ['value' => $value]
        );

        return redirect()->back()->with([
            'anchor' => 'product_page_banner_section',
            'message' => 'Updated Successfully'
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cartPageBanner(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'banner_one_image' => ['image'],
            'banner_one_url' => ['required'],
            'banner_one_hook_text' => ['nullable', 'string', 'max:20'],
            'banner_one_highlight_text' => ['nullable', 'string', 'max:20'],
            'banner_one_followup_text' => ['nullable', 'string', 'max:20'],
            'banner_one_button_text' => ['nullable', 'string', 'max:20'],

            'banner_two_image' => ['image'],
            'banner_two_url' => ['required'],
            'banner_two_leading_text' => ['nullable', 'string', 'max:40'],
            'banner_two_followup_text' => ['nullable', 'string', 'max:20'],
            'banner_two_button_text' => ['nullable', 'string', 'max:20'],
        ]);

        try {
            $validator->validate();
        } catch (ValidationException $e) {
            $error = $e->validator->errors()->first();
            return redirect()->back()->withInput()
                ->with([
                    'anchor' => 'cart_page_banner_section',
                    'message' => $error,
                    'alert-type' => 'error'
                ]);
        }

        /** Handle the image upload */
        $imagePath = $this->updateImage($request, 'banner_one_image', 'uploads');
        $imagePathTwo = $this->updateImage($request, 'banner_two_image', 'uploads');

        $value = [
            'banner_one' => [
                'banner_url' => $request->banner_one_url,
                'status' => $request->banner_one_status == 'on' ? 1 : 0,
                'hook_text' => $request->banner_one_hook_text,
                'highlight_text' => $request->banner_one_highlight_text,
                'followup_text' => $request->banner_one_followup_text,
                'button_text' => $request->banner_one_button_text,
            ],
            'banner_two' => [
                'banner_url' => $request->banner_two_url,
                'status' => $request->banner_two_status == 'on' ? 1 : 0,
                'leading_text' => $request->banner_two_leading_text,
                'followup_text' => $request->banner_two_followup_text,
                'button_text' => $request->banner_two_button_text,
            ]
        ];

        if (!empty($imagePath)) {
            $value['banner_one']['banner_image'] = $imagePath;
        } else {
            $value['banner_one']['banner_image'] = $request->banner_one_old_image;
        }

        if (!empty($imagePathTwo)) {
            $value['banner_two']['banner_image'] = $imagePathTwo;
        } else {
            $value['banner_two']['banner_image'] = $request->banner_two_old_image;
        }

        $value = json_encode($value);

        Advertisement::query()->updateOrCreate(
            ['key' => 'cart_page_banner_section'],
            ['value' => $value]
        );

        return redirect()->back()->with([
            'anchor' => 'cart_page_banner_section',
            'message' => 'Updated Successfully'
        ]);
    }
}
