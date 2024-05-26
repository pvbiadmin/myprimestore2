<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\FlashSale;
use App\Models\FlashSaleItem;
use App\Models\HomePageSetting;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Vendor;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * View Home Page
     *
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $sliders = Cache::rememberForever('sliders', static function () {
            return Slider::where('status', 1)->orderBy('serial')->get();
        });

        $flash_sale = $this->flashSale();
        $flash_sale_items = $this->flashSaleItems();
        $popular_categories = $this->popularCategories();
        $brands = $this->brands();
        $type_base_products = $this->getTypeBaseProduct();
        $category_product_slider = $this->categoryProductSlider();

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

        $recentBlogs = Blog::with(['category', 'user'])
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->take(8)->get();

        return view('frontend.home.home', compact(
                'sliders',
                'flash_sale',
                'flash_sale_items',
                'popular_categories',
                'brands',
                'type_base_products',
                'category_product_slider',
                'homepage_section_banner_one',
                'homepage_section_banner_two',
                'homepage_section_banner_three',
                'homepage_section_banner_four',
                'recentBlogs'
            )
        );
    }

    /**
     * Flash Sale
     *
     * @return Model|Builder|null
     */
    public function flashSale(): Model|Builder|null
    {
        return FlashSale::query()->first();
    }

    /**
     * Flash Sale Items
     *
     * @return Collection|array
     */
    public function flashSaleItems(): Collection|array
    {
        return FlashSaleItem::query()
            ->where('show_at_home', '=', 1)
            ->where('status', '=', 1)
            ->pluck('product_id')->toArray();
    }

    /**
     * @return Model|Builder|null
     */
    public function popularCategories(): Model|Builder|null
    {
        return HomePageSetting::query()
            ->where('key', '=', 'popular_category')->first();
    }

    /**
     * Category Product Slider
     *
     * @return Model|Builder|null
     */
    public function categoryProductSlider(): Model|Builder|null
    {
        return HomePageSetting::query()
            ->where('key', '=', 'category_product_slider')->first();
    }

    /**
     * Brands
     *
     * @return Collection|array
     */
    public function brands(): Collection|array
    {
        return Brand::query()
            ->where('status', '=', 1)
            ->where('is_featured', '=', 1)
            ->get();
    }

    /**
     * Type Base Products Array
     *
     * @return array
     */
    public function getTypeBaseProduct(): array
    {
        $type_base_products = [];

        $type_base_products['new_arrival'] = $this->getProductType('new_arrival');
        $type_base_products['featured_product'] = $this->getProductType('featured_product');
        $type_base_products['top_product'] = $this->getProductType('top_product');
        $type_base_products['best_product'] = $this->getProductType('best_product');

        return $type_base_products;
    }

    /**
     * New Arrival Type Products
     *
     * @param $type
     * @return Collection|array
     */
    public function getProductType($type): Collection|array
    {
        return Product::query()
            ->withAvg('reviews', 'rating')->withCount('reviews')
            ->with(['variants', 'category', 'imageGallery'])
            ->where('product_type', '=', $type)
            ->where('is_approved', '=', 1)
            ->where('status', '=', 1)
            ->orderBy('id', 'DESC')
            ->take(8)
            ->get();
    }

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function vendorsPage(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $vendors = Vendor::query()->where('status', 1)->paginate(4);

        return view('frontend.pages.vendors', compact('vendors'));
    }

    /**
     * @param string $id
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function vendorProductsPage(string $id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $products = Product::query()
            ->withAvg('reviews', 'rating')->withCount('reviews')
            ->with(['variants', 'category', 'imageGallery'])
            ->where(['status' => 1, 'is_approved' => 1, 'vendor_id' => $id])
            ->orderBy('id', 'DESC')->paginate(6);

        $categories = Category::query()->where(['status' => 1])->get();
        $brands = Brand::query()->where(['status' => 1])->get();
        $vendor = Vendor::query()->findOrFail($id);

        return view('frontend.pages.vendor-products',
            compact('products', 'categories', 'brands', 'vendor'));
    }
}
