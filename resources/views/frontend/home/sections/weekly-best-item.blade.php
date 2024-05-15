@php
    $category_product_slider = isset($category_product_slider) ?
        json_decode($category_product_slider) : null;

    $cat_product_sliders = $category_product_slider
        ? json_decode($category_product_slider->value, true) : null;

    $col_sliders = [];

    $cat_product_col_sliders = [];

    if ($cat_product_sliders && count($cat_product_sliders) >= 4) {
        $cat_product_col_sliders[] = $cat_product_sliders[2];
        $cat_product_col_sliders[] = $cat_product_sliders[3];

        foreach($cat_product_col_sliders as $slider) {
            $result = [];

            // Loop through the array in reverse order
            $keys = array_keys($slider);

            for ($i = count($keys) - 1; $i >= 0; $i--) {
                $key = $keys[$i];
                // Check if the element is not null
                if ($slider[$key] !== null) {
                    // Save the non-null element in the result array
                    $result[$key] = $slider[$key];
                    // Break the loop since we only want the last non-null element
                    break;
                }
            }

            switch (key($result)) {
                case 'subcategory':
                    $category = \App\Models\Subcategory::query()
                        ->findOrFail($result['subcategory']);
                    $products = \App\Models\Product::query()
                        ->withAvg('reviews', 'rating')
                        ->where('subcategory_id', '=', $result['subcategory'])
                        ->orderBy('id', 'DESC')->take(12)->get();
                break;
                case 'child_category':
                    $category = \App\Models\ChildCategory::query()
                        ->findOrFail($result['child_category']);
                    $products = \App\Models\Product::query()
                        ->withAvg('reviews', 'rating')
                        ->where('child_category_id', '=', $result['child_category'])
                        ->orderBy('id', 'DESC')->take(12)->get();
                break;
                default:
                    $category = \App\Models\Category::query()
                        ->findOrFail($result['category']);
                    $products = \App\Models\Product::query()
                        ->withAvg('reviews', 'rating')
                        ->where('category_id', '=', $result['category'])
                        ->orderBy('id', 'DESC')->take(12)->get();
                break;
            }

            $col_sliders[] = [
                'category' => $category,
                'products' => $products
            ];
        }
    }
@endphp

@if ( isset($col_sliders) && count($col_sliders) > 0 )
    <section id="wsus__weekly_best" class="home2_wsus__weekly_best_2">
        <div class="container">
            <div class="row">
                @foreach( $col_sliders as $col_slider )
                    <div class="col-xl-6 col-sm-6">
                        @if ( count($col_slider['products']) > 0 )
                            <div class="wsus__section_header">
                                <h3>{{ $col_slider['category']->name }}</h3>
                            </div>
                            <div class="row weekly_best2">
                                @foreach( $col_slider['products'] as $product )
                                    <div class="col-xl-4 col-lg-4">
                                        <a class="wsus__hot_deals__single"
                                           href="{{ route('product-detail', $product->slug) }}">
                                            <div class="wsus__hot_deals__single_img">
                                                <img src="{{ asset($product->thumb_image) }}" alt="{{ $product->name }}"
                                                     class="img-fluid w-100">
                                            </div>
                                            <div class="wsus__hot_deals__single_text">
                                                <h5 class="show-read-more-product-slider3">{{ $product->name }}</h5>
                                                @php
                                                    $product = $product ?? null;

                                                    /*$average_rating = $product->reviews()->avg('rating');*/
                                                    $average_rating = $product->reviews_avg_rating;

                                                    $average_rating = $average_rating ?? 0;

                                                    // Check if $average_rating is a whole number
                                                    $is_whole_number = is_int($average_rating);

                                                    // If not a whole number, split it into integer and fractional parts
                                                    if (!$is_whole_number) {
                                                        $integer_part = floor($average_rating);
                                                        $fractional_part = $average_rating - $integer_part;
                                                    }
                                                @endphp
                                                <p class="wsus__rating">
                                                    @if ( $is_whole_number )
                                                        {{-- Render full stars --}}
                                                        @for ( $i = 1; $i <= 5; $i++ )
                                                            @if ( $i <= $average_rating )
                                                                <i class="fas fa-star"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    @else
                                                        {{-- Render integer part as full stars --}}
                                                        @for ( $i = 1; $i <= $integer_part; $i++ )
                                                            <i class="fas fa-star"></i>
                                                        @endfor
                                                        {{-- Render fractional part as half star --}}
                                                        <i class="fas fa-star-half-alt"></i>
                                                        {{-- Render remaining empty stars --}}
                                                        @for ( $i = $integer_part + 1; $i < 5; $i++ )
                                                            <i class="far fa-star"></i>
                                                        @endfor
                                                    @endif
                                                </p>
                                                @if ( hasDiscount($product) )
                                                    <p class="wsus__tk">{{ $settings->currency_icon .
                                                    number_format($product->offer_price, 2) }}
                                                        <del>{{ $settings->currency_icon .
                                                        number_format($product->price, 2) }}</del>
                                                    </p>
                                                @else
                                                    <p class="wsus__tk">{{ $settings->currency_icon .
                                                    number_format($product->price, 2) }}</p>
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
