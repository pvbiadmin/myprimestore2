@php
    $category_product_slider = isset($category_product_slider) ?
        json_decode($category_product_slider) : null;

    $cat_product_sliders = $category_product_slider ? json_decode($category_product_slider->value, true) : null;

    $cat_product_slider2 = null;
    $result = [];

    if ($cat_product_sliders && count($cat_product_sliders) > 1) {
        $cat_product_slider2 = $cat_product_sliders[1];

        // Loop through the array in reverse order
        $keys = array_keys($cat_product_slider2);

        for ($i = count($keys) - 1; $i >= 0; $i--) {
            $key = $keys[$i];
            // Check if the element is not null
            if ($cat_product_slider2[$key] !== null) {
                // Save the non-null element in the result array
                $result[$key] = $cat_product_slider2[$key];
                // Break the loop since we only want the last non-null element
                break;
            }
        }
    }

    if ($result) {
        switch (key($result)) {
            case 'subcategory':
                $category = \App\Models\Subcategory::query()
                    ->findOrFail($result['subcategory']);
                $products = \App\Models\Product::query()
                    ->withAvg('reviews', 'rating')
                    ->withCount('reviews')
                    ->with(['variants', 'category', 'imageGallery'])
                    ->where('subcategory_id', '=', $result['subcategory'])
                    ->orderBy('id', 'DESC')->take(12)->get();
                $search['subcategory'] = $category->slug;
            break;
            case 'child_category':
                $category = \App\Models\ChildCategory::query()
                ->findOrFail($result['child_category']);
                $products = \App\Models\Product::query()
                    ->withAvg('reviews', 'rating')
                    ->withCount('reviews')
                    ->with(['variants', 'category', 'imageGallery'])
                    ->where('child_category_id', '=', $result['child_category'])
                    ->orderBy('id', 'DESC')->take(12)->get();
                $search['child_category'] = $category->slug;
            break;
            default:
                $category = \App\Models\Category::query()
                    ->findOrFail($result['category']);
                $products = \App\Models\Product::query()
                    ->withAvg('reviews', 'rating')
                    ->withCount('reviews')
                    ->with(['variants', 'category', 'imageGallery'])
                    ->where('category_id', '=', $result['category'])
                    ->orderBy('id', 'DESC')->take(12)->get();
                $search['category'] = $category->slug;
            break;
        }
    }
@endphp

@if ( isset($products) && count($products) > 0)
    <section id="wsus__electronic2">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__section_header">
                        <h3>{{ $category->name }}</h3>
                        <a class="see_btn" href="{{ route('products.index', $search) }}">
                            see more <i class="fas fa-caret-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row flash_sell_slider">
                @foreach( $products as $product )
                    <x-product-card :product="$product" :section="'flashSale'" />
                @endforeach
            </div>
        </div>
    </section>

    @foreach( $products as $product )
        <x-product-modal :product="$product" />
    @endforeach
@else
    <section id="wsus__electronic2">
        <div class="container"></div>
    </section>
@endif
