<section class="product_popup_modal">
    <div class="modal fade" id="exampleModal-{{ $product->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"><i class="far fa-times"></i></button>
                    <div class="row">
                        <div class="col-xl-6 col-12 col-sm-10 col-md-8 col-lg-6 m-auto display">
                            <div class="wsus__quick_view_img">
                                @if ( $product->video_link )
                                    <a class="venobox wsus__pro_det_video"
                                       data-autoplay="true" data-vbtype="video"
                                       href="{{ $product->video_link }}">
                                        <i class="fas fa-play"></i>
                                    </a>
                                @endif
                                <div class="row modal_slider">
                                    @if ( count($product->imageGallery) === 0 )
                                        <div class="col-xl-12">
                                            <div class="modal_slider_img">
                                                <img src="{{ asset($product->thumb_image) }}"
                                                     alt="{{ $product->name }}"
                                                     class="img-fluid w-100">
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="modal_slider_img">
                                                <img src="{{ asset($product->thumb_image) }}"
                                                     alt="{{ $product->name }}"
                                                     class="img-fluid w-100">
                                            </div>
                                        </div>
                                    @else
                                        @foreach ( $product->imageGallery as $image )
                                            <div class="col-xl-12">
                                                <div class="modal_slider_img">
                                                    <img src="{{ asset($image->image) }}"
                                                         alt="{{ $product->name }}"
                                                         class="img-fluid w-100">
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12 col-sm-12 col-md-12 col-lg-6">
                            <div class="wsus__pro_details_text">
                                <a class="title" href="{{ route('product-detail', $product->slug) }}">
                                    {{ $product->name }}</a>
                                <p class="wsus__stock_area">
                                    <span class="in_stock">in stock</span> (167 item)
                                </p>
                                @if ( hasDiscount($product) )
                                    <h4>
                                        {{ $settings->currency_icon }}{{
                                                    number_format($product->offer_price, 2) }}
                                        <del>{{ $settings->currency_icon }}{{
                                                    number_format($product->price, 2) }}</del>
                                    </h4>
                                @else
                                    <h4>
                                        {{ $settings->currency_icon }}{{ number_format($product->price, 2) }}
                                    </h4>
                                @endif
                                @php
                                    $product = $product ?? null;

                                    $count_reviews = count($product->reviews);
                                    $average_rating = $product->reviews()->avg('rating');

                                    $average_rating = $average_rating ?? 0;

                                    // Check if $average_rating is a whole number
                                    $is_whole_number = is_int($average_rating);

                                    // If not a whole number, split it into integer and fractional parts
                                    if (!$is_whole_number) {
                                        $integer_part = floor($average_rating);
                                        $fractional_part = $average_rating - $integer_part;
                                    }
                                @endphp
                                <p class="review">
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
                                    <span>{{ $count_reviews }} review{{ $count_reviews > 1 ? 's' : '' }}</span>
                                </p>
                                <p class="description">{!! $product->short_description !!}</p>

                                @if ( hasDiscount($product) )
                                    <div class="wsus_pro_hot_deals">
                                        <h5>offer ending time : </h5>
                                        <div class="simply-countdown simply-countdown-one"></div>
                                    </div>
                                @endif

                                <form class="cart-form">
                                    <div class="wsus__selectbox">
                                        <div class="row">
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            @foreach ( $product->variants as $variant )
                                                @if ( $variant->status != 0 )
                                                    <div class="col-xl-6 col-sm-6">
                                                        <h5 class="mb-2">
                                                            <label for="variant_{{ $variant->id }}">
                                                                {{ $variant->name }}:</label>
                                                        </h5>
                                                        <select id="variant_{{ $variant->id }}"
                                                                class="select_2" name="variant_options[]">
                                                            @foreach (
                                                                $variant->productVariantOptions as $option )
                                                                @if ( $option->status != 0 )
                                                                    <option value="{{ $option->id }}" {{
                                                                                $option->is_default ? 'selected' : ''
                                                                                }}>{{ $option->name }} {{
                                                                            $option->price > 0 ? '(' .
                                                                            $settings->currency_icon .
                                                                                number_format($option->price, 2) .
                                                                                    ')' : '' }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="wsus__quentity">
                                        <h5><label for="quantity">quantity:</label></h5>
                                        <div class="select_number">
                                            <input class="number_area" id="quantity" name="quantity"
                                                   type="text" min="1" max="100" value="1"/>
                                        </div>
                                        <h3>{{ $settings->currency_icon }}{{
                                                    number_format($product->price, 2) }}</h3>
                                    </div>
                                    <ul class="wsus__button_area">
                                        <li>
                                            <button type="submit" class="add_cart btn btn-primary">
                                                Add to Cart
                                            </button>
                                        </li>
                                        <li><a class="buy_now" href="#">Buy Now</a></li>
                                        <li><a href="javascript:" class="add-wishlist"
                                               data-id="{{ $product->id }}"><i class="fal fa-heart"></i></a>
                                        </li>
                                    </ul>
                                </form>

                                <p class="brand_model">
                                    <span>category :</span> {{ $product->category->name }}
                                </p>
                                <p class="brand_model"><span>brand :</span> {{ $product->brand->name }}</p>
                                @if (
                                    $product->vendor->fb_link
                                    || $product->vendor->yt_link
                                    || $product->vendor->tw_link
                                    || $product->vendor->insta_link
                                )
                                    <div class="wsus__pro_det_share">
                                        <h5>share :</h5>
                                        <ul class="d-flex">
                                            @if ( $product->vendor->fb_link )
                                                <li><a class="facebook"
                                                       href="{{ $product->vendor->fb_link }}">
                                                        <i class="fab fa-facebook-f"></i></a></li>
                                            @endif
                                            @if ( $product->vendor->tw_link )
                                                <li><a class="twitter"
                                                       href="{{ $product->vendor->tw_link }}">
                                                        <i class="fab fa-twitter"></i></a></li>
                                            @endif
                                            @if ( $product->vendor->yt_link )
                                                <li><a class="youtube"
                                                       href="{{ $product->vendor->yt_link }}">
                                                        <i class="fab fa-youtube"></i></a></li>
                                            @endif
                                            @if ( $product->vendor->fb_link )
                                                <li><a class="instagram"
                                                       href="{{ $product->vendor->fb_link }}">
                                                        <i class="fab fa-instagram"></i></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
