@php
    // Parse JSON input
    $category_product_slider = json_decode($category_product_slider);

    // Extract slider data
    $cat_product_sliders = $category_product_slider ? json_decode($category_product_slider->value, true) : null;

    // Get the first slider
    $cat_product_slider1 = $cat_product_sliders ? reset($cat_product_sliders) : null;

    $result = null;

    if ($cat_product_slider1) {
        // Find the last non-null element
        $keys = array_keys($cat_product_slider1);
        // Check if array keys exist
        if ($keys) {
            // Loop through the array in reverse order
            for ($i = count($keys) - 1; $i >= 0; $i--) {
                $key = $keys[$i];
                // Check if the element is not null
                if ($cat_product_slider1[$key] !== null) {
                    // Save the non-null element in the result array
                    $result = $cat_product_slider1[$key];
                    // Break the loop since we only want the last non-null element
                    break;
                }
            }
        }
    }

    if ($result) {
        switch (key($cat_product_slider1)) {
            case 'subcategory':
                $category = \App\Models\Subcategory::findOrFail($result);
                $products = \App\Models\Product::withAvg('reviews', 'rating')
                    ->withCount('reviews')
                    ->with(['variants', 'category', 'imageGallery'])
                    ->where('subcategory_id', '=', $result)
                    ->orderBy('id', 'DESC')
                    ->take(12)
                    ->get();
                $search['subcategory'] = $category->slug;
                break;
            case 'child_category':
                $category = \App\Models\ChildCategory::findOrFail($result);
                $products = \App\Models\Product::withAvg('reviews', 'rating')
                    ->withCount('reviews')
                    ->with(['variants', 'category', 'imageGallery'])
                    ->where('child_category_id', '=', $result)
                    ->orderBy('id', 'DESC')
                    ->take(12)
                    ->get();
                $search['child_category'] = $category->slug;
                break;
            default:
                $category = \App\Models\Category::findOrFail($result);
                $products = \App\Models\Product::withAvg('reviews', 'rating')
                    ->withCount('reviews')
                    ->with(['variants', 'category', 'imageGallery'])
                    ->where('category_id', '=', $result)
                    ->orderBy('id', 'DESC')
                    ->take(12)
                    ->get();
                $search['category'] = $category->slug;
                break;
        }
    }
@endphp

@if ( isset($products) && count($products) > 0)
    <section id="wsus__electronic">
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
    <section id="wsus__electronic">
        <div class="container"></div>
    </section>
@endif
