<?php

/**
 * Where all magic begins...
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HomePageSetting;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomePageSettingController extends Controller
{
    /**
     * View Home Page Settings
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $categories = $this->getAllActiveCategories();
        $popular_categories = $this->getPopularCategories();
        $category_product_slider = $this->getCategoryProductSlider();

        return view('admin.home-page-settings.index', compact(
            'categories',
            'popular_categories',
            'category_product_slider'
        ));
    }

    /**
     * Get All Active Categories
     *
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function getAllActiveCategories(): Collection|array
    {
        return Category::query()->where('status', '=', 1)->get();
    }

    /**
     * Get Popular Categories for Home Page View
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|null
     */
    public function getPopularCategories(): Model|Builder|null
    {
        return HomePageSetting::query()->where('key', '=', 'popular_category')->first();
    }

    /**
     * Get Category Product Slider for Home Page View
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|null
     */
    public function getCategoryProductSlider(): Model|Builder|null
    {
        return HomePageSetting::query()
            ->where('key', '=', 'category_product_slider')->first();
    }

    /**
     * Update Popular Categories
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePopularCategories(Request $request): RedirectResponse
    {
        if (
            empty($request->popular_category1) &&
            empty($request->popular_category2) &&
            empty($request->popular_category3) &&
            empty($request->popular_category4)
        ) {
            return redirect()->back()->with([
                'message' => 'At Least One Category Required',
                'alert-type' => 'error'
            ]);
        }

        $data = [];

        for ($i = 1; $i <= 4; $i++) {
            $category = $request->{"popular_category$i"};
            $subcategory = $request->{"popular_subcategory$i"};
            $childCategory = $request->{"popular_child_category$i"};

            if (is_null($category) && (!is_null($subcategory) || !is_null($childCategory))) {
                $errorMessage = "Category Required for Subcategory or Child-category";

                return redirect()->back()->with([
                    'message' => $errorMessage,
                    'alert-type' => 'error'
                ]);
            }

            $data[] = [
                'category' => $request->{"popular_category$i"},
                'subcategory' => $request->{"popular_subcategory$i"},
                'child_category' => $request->{"popular_child_category$i"}
            ];
        }

        HomePageSetting::query()->updateOrCreate(
            ['key' => 'popular_category'],
            ['value' => json_encode($data)]
        );

        return redirect()->back()->with(['message' => 'Popular Category Settings Updated']);
    }

    /**
     * Category Product Slider
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCategoryProductSlider(Request $request): RedirectResponse
    {
        if (
            empty($request->slider_category1)
            && empty($request->slider_category2)
            && empty($request->slider_category3)
            && empty($request->slider_category4)
        ) {
            return redirect()->back()
                /*->with(['anchor' => 'list-category-product-slider-1'])*/
                ->with([
                    'anchor' => 'list-category-product-slider-1',
                    'message' => 'At Least One Category Required',
                    'alert-type' => 'error'
                ]);
        }

        $data = [];

        for ($i = 1; $i <= 4; $i++) {
            $category = $request->{"slider_category$i"};
            $subcategory = $request->{"slider_subcategory$i"};
            $childCategory = $request->{"slider_child_category$i"};

            if (is_null($category) && (!is_null($subcategory) || !is_null($childCategory))) {
                $errorMessage = "Category Required for Subcategory or Child-category";

                return redirect()->back()
                    /*->with(['anchor' => 'list-category-product-slider-1'])*/
                    ->with([
                        'anchor' => 'list-category-product-slider-1',
                        'message' => $errorMessage,
                        'alert-type' => 'error'
                    ]);
            }

            $data[] = [
                'category' => $request->{"slider_category$i"},
                'subcategory' => $request->{"slider_subcategory$i"},
                'child_category' => $request->{"slider_child_category$i"}
            ];
        }

        HomePageSetting::query()->updateOrCreate(
            ['key' => 'category_product_slider'],
            ['value' => json_encode($data)]
        );

        return redirect()->back()
            /*->with(['anchor' => 'list-category-product-slider-1'])*/
            ->with([
                'anchor' => 'list-category-product-slider-1',
                'message' => 'Category Product Slider Settings Updated'
            ]);
    }
}
