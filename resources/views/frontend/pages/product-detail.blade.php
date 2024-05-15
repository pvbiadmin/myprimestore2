@extends( 'frontend.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Product - Detail
@endsection

@push( 'styles' )
    <style>
        .rating i {
            color: #ccc;
            cursor: pointer;
        }

        .rating i.active {
            color: #ff9f00;
        }

        .align-middle-left {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }
    </style>
@endpush

@section( 'content' )
    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>products details</h4>
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li><a href="javascript:">product</a></li>
                            <li><a href="javascript:">product details</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        PRODUCT DETAILS START
    ==============================-->
    <section id="wsus__product_details">
        <div class="container">
            <div class="wsus__details_bg">
                <div class="row">
                    <div class="col-xl-4 col-md-5 col-lg-5" style="z-index: 10 !important;">
                        <div id="sticky_pro_zoom">
                            <div class="exzoom hidden" id="exzoom">
                                <div class="exzoom_img_box">
                                    @if ( $product->video_link )
                                        <a class="venobox wsus__pro_det_video"
                                           data-autoplay="true" data-vbtype="video"
                                           href="{{ $product->video_link }}">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    @endif
                                    <ul class='exzoom_img_ul'>
                                        <li><img class="zoom ing-fluid w-100"
                                                 src="{{ asset($product->thumb_image) }}"
                                                 alt="{{ $product->name }}"></li>
                                        @foreach( $product->imageGallery as $image )
                                            <li><img class="zoom ing-fluid w-100"
                                                     src="{{ asset($image->image) }}"
                                                     alt="{{ $product->name }}"></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="exzoom_nav"></div>
                                <p class="exzoom_btn">
                                    <a href="javascript:" class="exzoom_prev_btn"> <i
                                            class="far fa-chevron-left"></i> </a>
                                    <a href="javascript:" class="exzoom_next_btn"> <i
                                            class="far fa-chevron-right"></i> </a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-md-7 col-lg-7">
                        <div class="wsus__pro_details_text">
                            <a class="title" href="#">{{ $product->name }}</a>
                            @if ( $product->quantity > 0 )
                                <p class="wsus__stock_area">
                                    <span class="in_stock">in stock</span> ({{ $product->quantity }} item{{
                                        $product->quantity > 1 ? 's' : '' }})
                                </p>
                            @elseif ( $product->quantity == 0 )
                                <span class="in_stock">out of stock</span>
                            @endif
                            @if ( hasDiscount($product) )
                                <h4>{{ $settings->currency_icon }}{{ number_format($product->offer_price, 2) }}
                                    <del>{{ $settings->currency_icon }}{{ number_format($product->price, 2) }}</del>
                                </h4>
                            @else
                                <h4>{{ $settings->currency_icon }}{{ number_format($product->price, 2) }}</h4>
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
                                                        <label for="variant_{{ $variant->id }}">{{
                                                            $variant->name }}:</label>
                                                    </h5>
                                                    <select id="variant_{{ $variant->id }}" class="select_2"
                                                            name="variant_options[]" aria-label="variant_options">
                                                        @foreach ( $variant->productVariantOptions as $option )
                                                            @if ( $option->status != 0 )
                                                                <option value="{{ $option->id }}"
                                                                    {{ $option->is_default == 1 ? 'selected' : '' }}>
                                                                    {{ $option->name }} {{ $option->price > 0 ? '(' .
                                                            $settings->currency_icon .
                                                            number_format($option->price, 2) . ')' : '' }}
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
                                    {{--<h3>{{$settings->currency_icon}}50.00</h3>--}}
                                </div>
                                <ul class="wsus__button_area">
                                    <li>
                                        <button type="submit" class="add_cart btn btn-primary">add to cart</button>
                                    </li>
                                    <li></li>
                                    <li><a href="javascript:" class="add-wishlist"
                                           data-id="{{ $product->id }}"><i class="fal fa-heart"></i></a></li>
                                    <li><a href="javascript:" class="open-message-modal" data-bs-toggle="modal"
                                           data-bs-target="#messageModal"><i class="fal fa-comment-alt"></i></a></li>
                                </ul>
                            </form>

                            <p class="brand_model"><span>category :</span> {{ $product->category->name }}</p>
                            <p class="brand_model"><span>brand :</span> {{ $product->brand->name }}</p>
                            @if (
                                $product->vendor->fb_link
                                || $product->vendor->yt_link
                                || $product->vendor->tw_link
                                || $product->vendor->insta_link
                            )
                                <div class="wsus__pro_det_share">
                                    <h5>share:</h5>
                                    <ul class="d-flex">
                                        @if ( $product->vendor->fb_link )
                                            <li><a class="facebook" href="{{ $product->vendor->fb_link }}">
                                                    <i class="fab fa-facebook-f"></i></a></li>
                                        @endif
                                        @if ( $product->vendor->tw_link )
                                            <li><a class="twitter" href="{{ $product->vendor->tw_link }}">
                                                    <i class="fab fa-twitter"></i></a></li>
                                        @endif
                                        @if ( $product->vendor->yt_link )
                                            <li><a class="youtube" href="{{ $product->vendor->yt_link }}">
                                                    <i class="fab fa-youtube"></i></a></li>
                                        @endif
                                        @if ( $product->vendor->fb_link )
                                            <li><a class="instagram" href="{{ $product->vendor->fb_link }}">
                                                    <i class="fab fa-instagram"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                            <div class="brand_model">
                                <a class="wsus__pro_report" href="#" data-bs-toggle="modal"
                                   data-bs-target="#exampleModal">
                                    <i class="fal fa-comment-alt-smile"></i> Report incorrect product information.</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__pro_det_description">
                        <div class="wsus__details_bg">
                            <ul class="nav nav-pills mb-3" id="pills-tab3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link
                                    @if ( session('product_detail_tab_view_active') === 'description' ) active @endif
                                    @if( !session()->has('product_detail_tab_view_active') ) active @endif tab-view"
                                            data-id="description" id="pills-home-tab7" data-bs-toggle="pill"
                                            data-bs-target="#pills-home22" type="button" role="tab"
                                            aria-controls="pills-home" aria-selected="
                                    @if ( session('product_detail_tab_view_active') === 'description' )
                                        true @endif
                                    @if( !session()->has('product_detail_tab_view_active') ) true @endif">
                                        Description
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link
                                        @if ( session('product_detail_tab_view_active') === 'vendor' )
                                        active @endif tab-view"
                                            data-id="vendor" id="pills-contact-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact" type="button" role="tab"
                                            aria-controls="pills-contact" aria-selected="
                                        @if ( session('product_detail_tab_view_active') === 'vendor' )
                                        true @endif">Vendor Info
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link
                                        @if ( session('product_detail_tab_view_active') === 'review' )
                                        active @endif tab-view"
                                            data-id="review" id="pills-contact-tab2" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact2" type="button" role="tab"
                                            aria-controls="pills-contact2" aria-selected="
                                        @if ( session('product_detail_tab_view_active') === 'review' )
                                        true @endif">Reviews
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="pills-tabContent4">
                                <div class="tab-pane fade
                                @if ( session('product_detail_tab_view_active') === 'description' ) show active @endif
                                @if( !session()->has('product_detail_tab_view_active') ) show active @endif"
                                     id="pills-home22" role="tabpanel" aria-labelledby="pills-home-tab7">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="wsus__description_area">
                                                {!! $product->long_description !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade
                                @if ( session('product_detail_tab_view_active') === 'vendor' ) show active @endif"
                                     id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                    <div class="wsus__pro_det_vendor">
                                        <div class="row">
                                            <div class="col-xl-6 col-xxl-5 col-md-6">
                                                <div class="wsus__vebdor_img">
                                                    <img src="{{ asset($product->vendor->banner) }}"
                                                         alt="{{ $product->vendor->shop_name }}"
                                                         class="img-fluid w-100">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-xxl-7 col-md-6 mt-4 mt-md-0">
                                                <div class="wsus__pro_det_vendor_text">
                                                    <h4>{{ $product->vendor->user->username }}</h4>
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
                                                    <p class="rating">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <span>(41 review)</span>
                                                    </p>
                                                    <p><span>Store Name:</span> {{ $product->vendor->shop_name }}</p>
                                                    <p><span>Address:</span> {{ $product->vendor->address }}</p>
                                                    <p><span>Phone:</span> {{ $product->vendor->phone }}</p>
                                                    <p><span>mail:</span> {{ $product->vendor->email }}</p>
                                                    <a href="vendor_details.html" class="see_btn">visit store</a>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="wsus__vendor_details">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                        Accusantium aut consequatur fugiat, nobis nostrum quisquam
                                                        voluptate voluptates. Fugit incidunt laborum perferendis
                                                        repellendus vitae! At error ipsam magni nisi quod. Ad animi
                                                        culpa deleniti, dolorem expedita iste perferendis quo recusandae
                                                        unde vel. Adipisci, aliquam animi delectus deserunt dignissimos
                                                        eligendi est maxime necessitatibus, omnis quam, saepe
                                                        voluptatem? Ab aspernatur cumque, delectus dolorum expedita illo
                                                        minima numquam, quam, quia quod recusandae reiciendis rerum
                                                        tenetur. Accusantium adipisci amet dignissimos ducimus eligendi
                                                        et in natus necessitatibus placeat qui sed, similique.
                                                        Consectetur culpa cum nesciunt vitae. Eaque esse obcaecati sint.
                                                        Aliquid aperiam dignissimos quo tempore voluptate.
                                                        <span>
                                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                        Accusantium aut consequatur fugiat, nobis nostrum quisquam
                                                        voluptate voluptates. Fugit incidunt laborum perferendis
                                                        repellendus vitae! At error ipsam magni nisi quod. Ad animi
                                                        culpa deleniti, dolorem expedita iste perferendis quo recusandae
                                                        unde vel. Adipisci, aliquam animi delectus deserunt dignissimos
                                                        eligendi est maxime necessitatibus, omnis quam, saepe
                                                        voluptatem? Ab aspernatur cumque, delectus dolorum expedita illo
                                                        minima numquam, quam, quia quod recusandae reiciendis rerum
                                                        tenetur. Accusantium adipisci amet dignissimos ducimus eligendi
                                                        et in natus necessitatibus placeat qui sed, similique.
                                                        Consectetur culpa cum nesciunt vitae. Eaque esse obcaecati sint.
                                                        Aliquid aperiam dignissimos quo tempore voluptate.
                                                        </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade
                                @if ( session('product_detail_tab_view_active') === 'review' ) show active @endif"
                                     id="pills-contact2" role="tabpanel" aria-labelledby="pills-contact-tab2">
                                    <div class="wsus__pro_det_review">
                                        <div class="wsus__pro_det_review_single">
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-7">
                                                    <div class="wsus__comment_area">
                                                        @if ( ($count_reviews = count($reviews)) > 0 )
                                                            <h4>Reviews <span>{{ $count_reviews }}</span></h4>
                                                            @foreach ( $reviews as $review )
                                                                <div class="wsus__main_comment">
                                                                    <div class="wsus__comment_img">
                                                                        <img src="{{ asset($review->user->image) }}"
                                                                             alt="user" class="img-fluid w-100">
                                                                    </div>
                                                                    <div class="wsus__comment_text reply">
                                                                        <h6>{{ $review->user->name }} <span>{{
                                                                            $review->rating }} <i
                                                                                    class="fas fa-star"></i>
                                                                    </span></h6>
                                                                        <span>{{
                                                                            date('d M Y', strtotime($review->created_at))
                                                                            }}</span>
                                                                        <p>{{ $review->review }}</p>
                                                                        <ul class="">
                                                                            @if ( count($review->productReviewGalleries) > 0 )
                                                                                @foreach ( $review->productReviewGalleries as $image )
                                                                                    <li><img
                                                                                            src="{{ asset($image->image) }}"
                                                                                            class="img-fluid w-100"
                                                                                            alt="product">
                                                                                    </li>
                                                                                @endforeach
                                                                            @endif
                                                                        </ul>

                                                                        {{--<a href="#" data-bs-toggle="collapse"
                                                                           data-bs-target="#flush-collapsetwo">reply</a>
                                                                        <div class="accordion accordion-flush"
                                                                             id="accordionFlushExample2">
                                                                            <div class="accordion-item">
                                                                                <div id="flush-collapsetwo"
                                                                                     class="accordion-collapse collapse"
                                                                                     aria-labelledby="flush-collapsetwo"
                                                                                     data-bs-parent="#accordionFlushExample">
                                                                                    <div class="accordion-body">
                                                                                        <form>
                                                                                            <div
                                                                                                class="wsus__riv_edit_single text_area">
                                                                                                <i class="far fa-edit"></i>
                                                                                                <textarea cols="3" rows="1"
                                                                                                          placeholder="Your Text"></textarea>
                                                                                            </div>
                                                                                            <button type="submit"
                                                                                                    class="common_btn">submit
                                                                                            </button>
                                                                                        </form>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>--}}
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                            <div id="pagination">
                                                                @if ( $reviews->hasPages() )
                                                                    {{ $reviews->links() }}
                                                                @endif
                                                            </div>
                                                        @else
                                                            <div class="col-xl-6 col-md-10 col-lg-8 col-xxl-5 m-auto">
                                                                <div class="wsus__404_text">
                                                                    <p>No reviews yet.</p>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-xl-4 col-lg-5 mt-4 mt-lg-0">
                                                    @auth
                                                        @php
                                                            $product = $product ?? null;
                                                            $has_bought = false;

                                                            $orders = \App\Models\Order::query()
                                                                ->where([
                                                                    'user_id' => auth()->user()->id,
                                                                    'order_status' => 'delivered'
                                                                ])->get();

                                                            foreach ($orders as $key => $order) {
                                                                $existItem = $order->orderProducts()
                                                                    ->where('product_id', $product->id)->first();
                                                                if ($existItem) {
                                                                   $has_bought = true;
                                                                }
                                                            }
                                                        @endphp

                                                        @if ( $has_bought === true )
                                                            <div class="wsus__post_comment rev_mar"
                                                                 id="sticky_sidebar3">
                                                                <h4>Write a Review</h4>
                                                                <form action="{{ route('user.review.create') }}"
                                                                      enctype="multipart/form-data" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="product_id"
                                                                           id="review_product_id"
                                                                           value="{{ $product->id }}">
                                                                    <input type="hidden" name="vendor_id"
                                                                           id="review_vendor_id"
                                                                           value="{{ $product->vendor_id }}">
                                                                    <input type="hidden" name="rating"
                                                                           id="review_rating">
                                                                    <p class="rating">
                                                                        <span>select your rating: </span>
                                                                        <i class="fas fa-star active"></i>
                                                                        <i class="fas fa-star"></i>
                                                                        <i class="fas fa-star"></i>
                                                                        <i class="fas fa-star"></i>
                                                                        <i class="fas fa-star"></i>
                                                                    </p>
                                                                    <div class="row">
                                                                        <div class="col-xl-12">
                                                                            <div class="col-xl-12">
                                                                                <div class="wsus__single_com">
                                                                            <textarea cols="3" rows="3" id="review"
                                                                                      aria-label="review" name="review"
                                                                                      placeholder="Write your review"
                                                                            ></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="img_upload">
                                                                            <input type="file" name="images[]" multiple>
                                                                        </div>
                                                                    </div>
                                                                    <button class="common_btn" type="submit">
                                                                        submit review
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    @endauth
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!--============================
        PRODUCT DETAILS END
    ==============================-->


    <!--==========================
      PRODUCT MODAL VIEW START
    ===========================-->
    <section class="product_popup_modal">
        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                                class="far fa-times"></i></button>
                        <div class="row">
                            <div class="col-xl-6 col-12 col-sm-10 col-md-8 col-lg-6 m-auto display">
                                <div class="wsus__quick_view_img">
                                    @if ( $product->video_link )
                                        <a class="venobox wsus__pro_det_video" data-autoplay="true"
                                           data-vbtype="video" href="{{ $product->video_link }}">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    @endif
                                    <div class="row modal_slider">
                                        @if ( count($product->imageGallery ) === 0)
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
                                    <a class="title" href="javascript:">{{ $product->name }}</a>
                                    <p class="wsus__stock_area"><span class="in_stock">in stock</span> (167 item)
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
                                            {{ $settings->currency_icon }}{{
                                                    number_format($product->price, 2) }}
                                        </h4>
                                    @endif
                                    <p class="review">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <span>20 review</span>
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
                                                <input type="hidden" name="product_id"
                                                       value="{{ $product->id }}">
                                                @foreach ( $product->variants as $variant )
                                                    @if ( $variant->status != 0 )
                                                        <div class="col-xl-6 col-sm-6">
                                                            <h5 class="mb-2">
                                                                <label for="variant_{{ $variant->id }}">
                                                                    {{ $variant->name }}:</label>
                                                            </h5>
                                                            <select id="variant_{{ $variant->id }}"
                                                                    class="select_2" name="variant_options[]"
                                                                    aria-label="variant_options">
                                                                @foreach (
                                                                    $variant->productVariantOptions as $option )
                                                                    @if ( $option->status != 0 )
                                                                        <option value="{{ $option->id }}"
                                                                            {{ $option->is_default == 1 ?
                                                                                'selected' : '' }}>
                                                                            {{ $option->name }} {{
                                                                                    $option->price > 0 ? '(' .
                                                                                    $settings->currency_icon .
                                                                            number_format($option->price, 2) . ')' :
                                                                            '' }}
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
                                            {{--<h3>{{$settings->currency_icon}}50.00</h3>--}}
                                        </div>
                                        <ul class="wsus__button_area">
                                            <li>
                                                <button type="submit" class="add_cart btn btn-primary">
                                                    add to cart
                                                </button>
                                            </li>
                                            <li><a class="buy_now" href="#">buy now</a></li>
                                            <li><a href="javascript:" class="add-wishlist"
                                                   data-id="{{ $product->id }}">
                                                    <i class="fal fa-heart"></i></a></li>
                                            <li><a href="#"><i class="far fa-random"></i></a></li>
                                        </ul>
                                    </form>

                                    <p class="brand_model">
                                        <span>category:</span> {{ $product->category->name }}
                                    </p>
                                    <p class="brand_model"><span>brand :</span> {{
                                            $product->brand->name }}</p>
                                    @if (
                                        $product->vendor->fb_link
                                        || $product->vendor->yt_link
                                        || $product->vendor->tw_link
                                        || $product->vendor->insta_link
                                    )
                                        <div class="wsus__pro_det_share">
                                            <h5>share:</h5>
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
    <!--==========================
      PRODUCT MODAL VIEW END
    ===========================-->

    <!-- Message Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Send Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="message_modal">
                        @csrf
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea name="message" id="message"
                                      rows="5" class="form-control mt-2 message-box"></textarea>
                            <input type="hidden" name="receiver_id" value="{{ $product->vendor->user_id }}">
                        </div>

                        {{--<button type="submit" class="btn add_cart mt-4 send-button">Send</button>--}}
                        <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4 modal-button">
                            <button class="btn btn-primary me-md-2 order-md-1 send-button" type="submit">Send</button>
                            {{--<a href="#" class="btn btn-secondary order-md-2" type="button">View Messages</a>--}}
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>

@endsection

@push( 'scripts' )
    <script>
        ($ => {
            $(() => {
                simplyCountdown(".simply-countdown-one", {
                    year: {{ date("Y", strtotime(@$flash_sale->end_date)) }},
                    month: {{ date("m", strtotime(@$flash_sale->end_date)) }},
                    day: {{ date("d", strtotime(@$flash_sale->end_date)) }}
                });

                const showMessageModal = () => {
                    $("body").on("click", ".open-message-modal", e => {
                        e.preventDefault();
                        const $this = $(e.currentTarget);
                        const targetModalId = $this.data('target');
                        $(targetModalId).modal('show');
                    });
                }

                const sendMessage = () => {
                    $("body").on("submit", ".message_modal", e => {
                        e.preventDefault();
                        const $this = $(e.currentTarget);
                        let formData = $this.serialize();

                        const clSendButton = $(".send-button");

                        $.ajax({
                            method: 'POST',
                            url: '{{ route("user.send-message") }}',
                            data: formData,
                            beforeSend: () => {
                                let html = `<span class="spinner-border spinner-border-sm text-light"
                                    role="status" aria-hidden="true"></span> Sending...`
                                clSendButton.html(html);
                                clSendButton.prop('disabled', true);
                            },
                            success: response => {
                                if (response.status === 'success') {
                                    $('.message-box').val('');
                                    /*$('.modal-body').append(`<div class="alert alert-success mt-2"><a href="{{
                                        route('user.messages.index') }}" class="text-primary">View Messenger</a></div>`)*/

                                    const htmlMessenger = `<button class="btn btn-primary me-md-2 order-md-1
                                            send-button" type="submit">Send</button>
                                        <a href="{{ route('user.messages.index') }}" class="btn btn-secondary
                                            order-md-2" type="button">View Messages</a>`;

                                    $(".modal-button").html(htmlMessenger);

                                    toastr.success(response.message);
                                } else {
                                    toastr.error(response.message);
                                    clSendButton.html('Send');
                                    clSendButton.prop('disabled', false);
                                }
                            },
                            error: (xhr, status, error) => {
                                console.log(xhr.status, status, error);

                                if (xhr.status === 401 && status === 'error' && error === 'Unauthorized') {
                                    toastr.error("Login Required.");
                                    clSendButton.html('Send');
                                    clSendButton.prop('disabled', false);
                                }
                            },
                            complete: () => {
                                clSendButton.html('Send');
                                clSendButton.prop('disabled', false);
                            }
                        });
                    });
                }

                const tabView = () => {
                    $("body").on("click", ".tab-view", e => {
                        const $this = $(e.currentTarget);
                        let style = $this.data("id");

                        $.ajax({
                            method: "GET",
                            url: "{{ route('change-product-detail-tab-view') }}",
                            data: {style: style},
                            success: response => {
                                console.log(response);
                            },
                            error: (xhr, status, error) => {
                                console.log(error);
                            }
                        });
                    });
                }

                const getRating = () => {
                    $("#review_rating").val(1);

                    $("body").on("click", ".rating i", star => {
                        const $star = $(star.currentTarget);

                        $star.addClass("active");
                        $star.prevAll().addClass("active");
                        $star.nextAll().removeClass("active");

                        const rating = $(".rating i.active").length;

                        $("#review_rating").val(rating);
                    });
                };

                showMessageModal();
                sendMessage();

                tabView();
                getRating();
            });
        })(jQuery);
    </script>
@endpush
