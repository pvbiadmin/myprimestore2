<div class="col-sm-6 {{
        match ($section) {
            'flashSale' => 'col-xl-3 col-lg-4',
            'hotDeals' => 'col-xl-3 col-lg-4 col-md-4',
            default => 'col-xl-4'
        }
    }} {{ @$key }}">
    <div class="wsus__product_item">
        <span class="wsus__new">{{ productType($product->product_type) }}</span>
        @if( hasDiscount($product) )
            <span class="wsus__minus">
            -{{ displayNumber(
                discountPercent($product->price, $product->offer_price), 2
            ) }}%
        </span>
        @endif
        <a class="wsus__pro_link" href="{{ route('product-detail', $product->slug) }}">
            <img src="{{ asset($product->thumb_image) }}" alt="{{ $product->name }}"
                 class="img-fluid w-100 img_1"/>
            <img src="@if ( isset($product->imageGallery[0]->image) )
            {{ asset($product->imageGallery[0]->image) }}
            @else
            {{ asset($product->thumb_image) }}
            @endif"
                 alt="{{ $product->name }}"
                 class="img-fluid w-100 img_2"/>
        </a>
        <ul class="wsus__single_pro_icon">
            <li><a href="javascript:" data-bs-toggle="modal"
                   data-bs-target="#exampleModal-{{ $product->id }}">
                    <i class="far fa-eye"></i></a></li>
            <li><a href="javascript:" class="add-wishlist" data-id="{{ $product->id }}">
                    <i class="far fa-heart"></i></a></li>
            {{--<li><a href="javascript:"><i class="far fa-comment-alt"></i></a>--}}
        </ul>
        <div class="wsus__product_details">
            <a class="wsus__category" href="javascript:">{{ $product->category->name }}</a>
            @php
                $product = $product ?? null;

                $count_reviews = $product->reviews_count;
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

            <p class="wsus__pro_rating">
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
                <span>({{ $count_reviews }} review{{ $count_reviews > 1 ? 's' : '' }})</span>
            </p>

            <a class="wsus__pro_name show-read-more-flash-sale"
               href="{{ route('product-detail', $product->slug) }}">
                {!! $product->name !!}</a>
            @if( hasDiscount($product) )
                <p class="wsus__price">
                    {{ $settings->currency_icon }}{{
                                    number_format($product->offer_price, 2) }}
                    <del>{{ $settings->currency_icon }}{{
                                        number_format($product->price, 2) }}</del>
                </p>
            @else
                <p class="wsus__price">
                    {{ $settings->currency_icon }}{{ number_format($product->price, 2) }}
                </p>
            @endif
            <form class="cart-form">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" value="1"/>
                @foreach( $product->variants as $variant )
                    @if( $variant->status != 0 )
                        <select id="variant_{{ $variant->id }}" class="d-none"
                                name="variant_options[]" aria-label="product_variants">
                            @foreach( $variant->productVariantOptions as $option )
                                @if( $option->status != 0 )
                                    <option value="{{ $option->id }}"
                                        {{ $option->is_default == 1 ? 'selected' : '' }}>
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    @endif
                @endforeach
                <button type="submit" class="add_cart btn btn-primary">add to cart</button>
            </form>
        </div>
    </div>
</div>
