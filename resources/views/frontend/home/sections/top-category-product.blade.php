@php
    $popular_categories = $popular_categories ?? null;

    $pop_cats = isset($popular_categories) ? json_decode($popular_categories) : null;
    $pop_cats = $pop_cats ? json_decode($pop_cats->value, true) : null;

    if ($pop_cats) {
        // Filter the array
        $pop_cats = array_filter($pop_cats, function ($subArray) {
        // Check if any element of the sub-array is not null
        foreach ($subArray as $value) {
            if ($value !== null) {
                    return true; // Keep the sub-array
                }
            }

            return false; // Discard the sub-array
        });
    }
@endphp

@if ( $pop_cats )
    <section id="wsus__monthly_top" class="wsus__monthly_top_2">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="wsus__monthly_top_banner">
                        @if ( @$homepage_section_banner_one->banner_one->status == 1 )
                            <a class="wsus__monthly_top_banner_img" style="cursor: pointer" href="{{
                                    @$homepage_section_banner_one->banner_one->banner_url }}">
                                @if ( @$homepage_section_banner_one->banner_one->banner_image )
                                    <img src="{{ asset(@$homepage_section_banner_one->banner_one->banner_image) }}"
                                         alt="img" class="img-fluid w-100">
                                @endif
                                @if ( @$homepage_section_banner_one->banner_one->leading_text
                                       || @$homepage_section_banner_one->banner_one->hook_text
                                       || @$homepage_section_banner_one->banner_one->highlight_text
                                       || @$homepage_section_banner_one->banner_one->followup_text
                                       || @$homepage_section_banner_one->banner_one->button_text )
                                    <span></span>
                                @endif
                            </a>
                        @endif
                        @if ( @$homepage_section_banner_one->banner_one->leading_text
                                || @$homepage_section_banner_one->banner_one->hook_text
                                || @$homepage_section_banner_one->banner_one->highlight_text
                                || @$homepage_section_banner_one->banner_one->followup_text
                                || @$homepage_section_banner_one->banner_one->button_text )
                            <div class="wsus__monthly_top_banner_text">
                                @if ( @$homepage_section_banner_one->banner_one->leading_text )
                                    <h4>{{ @$homepage_section_banner_one->banner_one->leading_text }}</h4>
                                @endif
                                @if ( @$homepage_section_banner_one->banner_one->hook_text
                                        || @$homepage_section_banner_one->banner_one->highlight_text )
                                    <h3>@if ( @$homepage_section_banner_one->banner_one->hook_text ){{
                                            @$homepage_section_banner_one->banner_one->hook_text }}@endif @if (
                                        @$homepage_section_banner_one->banner_one->highlight_text )&nbsp;<span>{{
                                        @$homepage_section_banner_one->banner_one->highlight_text }}</span>@endif</h3>
                                    @if ( @$homepage_section_banner_one->banner_one->followup_text )
                                        <h6>{{ @$homepage_section_banner_one->banner_one->followup_text }}</h6>
                                    @endif
                                @endif
                                @if ( @$homepage_section_banner_one->banner_one->button_text  )
                                    <a class="shop_btn" href="{{ @$homepage_section_banner_one->banner_one->banner_url
                                        }}">{{ @$homepage_section_banner_one->banner_one->button_text }}</a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__section_header for_md">
                        <h3>Popular Categories</h3>
                        <div class="monthly_top_filter">
                            @php
                                $position = 0;
                                $category = null;
                                $products = [];
                            @endphp

                            @foreach( $pop_cats as $array )
                                @php
                                    $array = $array ?? null;

                                    $result = [];

                                    // Loop through the array in reverse order
                                    $keys = array_keys($array);

                                    for ($i = count($keys) - 1; $i >= 0; $i--) {
                                        $key = $keys[$i];
                                        // Check if the element is not null
                                        if ($array[$key] !== null) {
                                            // Save the non-null element in the result array
                                            $result[$key] = $array[$key];
                                            // Break the loop since we only want the last non-null element
                                            break;
                                        }
                                    }

                                    switch (key($result)) {
                                        case 'subcategory':
                                            $category = \App\Models\Subcategory::query()
                                                ->findOrFail($result['subcategory']);
                                            $product = \App\Models\Product::query()
                                                ->withAvg('reviews', 'rating')
                                                ->where('subcategory_id', '=', $result['subcategory'])
                                                ->where('status', '=', 1)
                                                ->orderBy('id', 'DESC')->take(12)->get();
                                            $products[] = $product;
                                        break;
                                        case 'child_category':
                                            $category = \App\Models\ChildCategory::query()
                                                ->findOrFail($result['child_category']);
                                            $product = \App\Models\Product::query()
                                                ->withAvg('reviews', 'rating')
                                                ->where('child_category_id', '=', $result['child_category'])
                                                ->where('status', '=', 1)
                                                ->orderBy('id', 'DESC')->take(12)->get();
                                            $products[] = $product;
                                        break;
                                        case 'category':
                                            $category = \App\Models\Category::query()
                                                ->findOrFail($result['category']);
                                            $product = \App\Models\Product::query()
                                                ->withAvg('reviews', 'rating')
                                                ->where('category_id', '=', $result['category'])
                                                ->where('status', '=', 1)
                                                ->orderBy('id', 'DESC')->take(12)->get();
                                            $products[] = $product;
                                        break;
                                    }
                                @endphp
                                @if ( count($product) > 0 )
                                    @php $position = isset($position) ? $position + 1 : 0 @endphp
                                    <button class="{{ $position === 1 ? 'auto_click active' : '' }}"
                                            data-filter=".category-{{ $loop->index }}">{{ $category->name }}</button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="row grid">
                        @foreach( $products as $key => $items )
                            @foreach( $items as $product )
                                <div class="col-xl-2 col-6 col-sm-6 col-md-4 col-lg-3 category-{{ $key }}">
                                    <a class="wsus__hot_deals__single"
                                       href="{{ route('product-detail', $product->slug) }}">
                                        <div class="wsus__hot_deals__single_img">
                                            <img src="{{ asset($product->thumb_image) }}"
                                                 alt="{!! $product->name !!}" class="img-fluid w-100">
                                        </div>
                                        <div class="wsus__hot_deals__single_text">
                                            <h5 class="show-read-more-top-product">
                                                {!! $product->name !!}</h5>
                                            @php
                                                $product = $product ?? null;

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
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
