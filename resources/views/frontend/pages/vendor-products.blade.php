@extends( 'frontend.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Vendor Products
@endsection

@section( 'content' )
    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>vendor products</h4>
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li><a href="javascript:">vendor products</a></li>
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
        PRODUCT PAGE START
    ==============================-->
    <section id="wsus__product_page">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__pro_page_bammer vendor_det_banner">
                        <img src="{{ asset('frontend/images/vendor_details_banner.jpg') }}" alt="banner"
                             class="img-fluid w-100">
                        <div class="wsus__pro_page_bammer_text wsus__vendor_det_banner_text">
                            <div class="wsus__vendor_text_center">
                                <h4>{{ $vendor->shop_name }}</h4>

                                <a href="callto:{{ $vendor->phone }}">
                                    <i class="far fa-phone-alt"></i> {{ $vendor->phone }}
                                </a>
                                <a href="mailto:{{ $vendor->email }}">
                                    <i class="far fa-envelope"></i> {{ $vendor->email }}
                                </a>
                                <p class="wsus__vendor_location">
                                    <i class="fal fa-map-marker-alt"></i> {{ $vendor->address }}
                                </p>
                                <ul class="d-flex">
                                    <li><a class="facebook" href="{{ $vendor->fb_link }}">
                                            <i class="fab fa-facebook-f"></i></a></li>
                                    <li><a class="twitter" href="{{ $vendor->tw_link }}">
                                            <i class="fab fa-twitter"></i></a></li>
                                    <li><a class="instagram" href="{{ $vendor->insta_link }}">
                                            <i class="fab fa-instagram"></i></a></li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Buttons --}}
                    <div class="col-xl-12 d-none d-md-block mt-md-4 mt-lg-0">
                        <div class="wsus__product_topbar">
                            <div class="wsus__product_topbar_left">
                                <div class="nav nav-pills" id="v-pills-tab" role="tablist"
                                     aria-orientation="vertical">

                                    <button
                                        class="nav-link {{ session()->has('product_tab_view_style')
                                                && session('product_tab_view_style') === 'grid'
                                                ? 'active' : '' }} {{ !session()->has('product_tab_view_style')
                                                ? 'show active' : '' }} tab-view" data-id="grid" id="v-pills-home-tab"
                                        data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button"
                                        role="tab" aria-controls="v-pills-home" aria-selected="{{
                                                session('product_tab_view_style') === 'grid' ? 'true' : 'false' }}">
                                        <i class="fas fa-th"></i>
                                    </button>

                                    <button
                                        class="nav-link {{ session()->has('product_tab_view_style')
                                                && session('product_tab_view_style') === 'list' ? 'active' : ''
                                                }} tab-view" data-id="list" id="v-pills-profile-tab"
                                        data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button"
                                        role="tab" aria-controls="v-pills-profile" aria-selected="{{
                                                session('product_tab_view_style') === 'list' ? 'true' : 'false' }}">
                                        <i class="fas fa-list-ul"></i>
                                    </button>

                                </div>
                                {{--<div class="wsus__topbar_select">
                                    <select class="select_2" name="state">
                                        <option>default shorting</option>
                                        <option>short by rating</option>
                                        <option>short by latest</option>
                                        <option>low to high</option>
                                        <option>high to low</option>
                                    </select>
                                </div>--}}
                            </div>
                            {{--<div class="wsus__topbar_select">
                                <select class="select_2" name="state">
                                    <option>show 12</option>
                                    <option>show 15</option>
                                    <option>show 18</option>
                                    <option>show 21</option>
                                </select>
                            </div>--}}
                        </div>
                    </div>

                    {{-- Products --}}
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade {{ session()->has('product_tab_view_style')
                                && session('product_tab_view_style') === 'grid' ? 'show active' : '' }} {{
                                    !session()->has('product_tab_view_style') ? 'show active' : '' }}"
                             id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="row">
                                @if ( count($products) > 0 )
                                    @foreach ( $products as $product )
                                        <x-product-card :product="$product" />
                                    @endforeach
                                @else
                                    <div class="col-xl-12">
                                        <div class="wsus__product_item wsus__list_view">
                                            <div class="col-xl-6 col-md-10 col-lg-8 col-xxl-5 m-auto">
                                                <div class="wsus__404_text">
                                                    <p>No products to show</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="tab-pane fade {{ session()->has('product_tab_view_style')
                                && session('product_tab_view_style') === 'list' ? 'show active' : '' }}"
                             id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="row">
                                @if ( count($products) > 0 )
                                    @foreach ( $products as $product )
                                        <x-product-card-list :product="$product" />
                                    @endforeach
                                @else
                                    <div class="col-xl-12">
                                        <div class="wsus__product_item wsus__list_view">
                                            <div class="col-xl-6 col-md-10 col-lg-8 col-xxl-5 m-auto">
                                                <div class="wsus__404_text">
                                                    <p>No products to show</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="col-xl-12">
                    @if ( $products->hasPages() )
                        {{ $products->withQueryString()->links() }}
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--============================
        PRODUCT PAGE END
    ==============================-->

    @foreach ( $products as $product )
        <x-product-modal :product="$product" />
    @endforeach
@endsection

@push( 'scripts' )
    <script>
        ($ => {
            $(() => {
                const tabView = () => {
                    $("body").on("click", ".tab-view", e => {
                        const $this = $(e.currentTarget);
                        let style = $this.data("id");

                        $.ajax({
                            method: "GET",
                            url: "{{ route('change-product-tab-view') }}",
                            data: {style: style},
                            success: response => {
                                console.log(response);
                            },
                            error: (xhr, status, error) => {
                                console.log(error);
                            }
                        });
                    });
                };

                @php
                    $from = 0;
                    $to = 8000;

                    if (request()->has('range')) {
                        $price = explode(';', request()->range);
                        $from = $price[0];
                        $to = $price[1];
                    }
                @endphp

                $("#slider_range").flatslider({
                    min: 0, max: 10000,
                    step: 100,
                    values: [{{ $from }}, {{ $to }}],
                    range: true,
                    einheit: '{{ $settings->currency_icon }}'
                });

                tabView();
            });
        })(jQuery);
    </script>
@endpush
