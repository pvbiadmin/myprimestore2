@extends( 'frontend.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Products
@endsection

@section( 'content' )
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>products</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">home</a></li>
                            <li><a href="javascript:">products</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="wsus__product_page">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    @if ( @$product_page_banner_section->banner_one->status == 1 )
                        <div class="wsus__pro_page_bammer" id="product_page_banner_section" style="{{
                            @$product_page_banner_section->banner_one->banner_url ? 'cursor: pointer;' : '' }}">
                            @if ( @$product_page_banner_section->banner_one->banner_image )
                                <img src="{{ asset(@$product_page_banner_section->banner_one->banner_image) }}"
                                     alt="banner" class="img-fluid w-100">
                            @endif
                            @if ( @$product_page_banner_section->banner_one->leading_text
                                || @$product_page_banner_section->banner_one->hook_text
                                || @$product_page_banner_section->banner_one->highlight_text
                                || @$product_page_banner_section->banner_one->followup_text
                                || @$product_page_banner_section->banner_one->button_text )
                                <div class="wsus__pro_page_bammer_text_center">
                                    @if ( @$product_page_banner_section->banner_one->hook_text
                                        || @$product_page_banner_section->banner_one->highlight_text )
                                        <p>@if ( @$product_page_banner_section->banner_one->hook_text ){{
                                            @$product_page_banner_section->banner_one->hook_text }}@endif @if (
                                        @$product_page_banner_section->banner_one->highlight_text )&nbsp;<span>{{
                                        @$product_page_banner_section->banner_one->highlight_text }}</span>@endif</p>
                                    @endif
                                    @if ( @$product_page_banner_section->banner_one->followup_text )
                                        <h5>{{ @$product_page_banner_section->banner_one->followup_text }}</h5>
                                    @endif
                                    @if ( @$product_page_banner_section->banner_one->leading_text )
                                        <h3>{{ @$product_page_banner_section->banner_one->leading_text }}</h3>
                                    @endif
                                    @if ( @$product_page_banner_section->banner_one->button_text  )
                                        <a href="{{ @$product_page_banner_section->banner_one->banner_url }}"
                                           class="add_cart">{{
                                                @$product_page_banner_section->banner_one->button_text }}</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Filter --}}
                <div class="col-xl-3 col-lg-4">
                    <div class="wsus__sidebar_filter ">
                        <p>filter</p>
                        <span class="wsus__filter_icon">
                            <i class="far fa-minus" id="minus"></i>
                            <i class="far fa-plus" id="plus"></i>
                        </span>
                    </div>
                    <div class="wsus__product_sidebar" id="sticky_sidebar">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                        All Categories
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                     aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul>
                                            @foreach( $categories as $category )
                                                <li><a href="{{ route('products.index', [
                                                    'category' => $category->slug
                                                    ]) }}">{{ $category->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                        Price
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse show"
                                     aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="price_ranger">
                                            <form action="{{ url()->current() }}">
                                                @foreach ( request()->query() as $key => $value )
                                                    @if ( $key !== 'range' )
                                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}"/>
                                                    @endif
                                                @endforeach
                                                <input type="hidden" id="slider_range" name="range"
                                                       class="flat-slider"/>
                                                <button type="submit" class="common_btn">filter</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree2">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree2" aria-expanded="false"
                                            aria-controls="collapseThree">
                                        size
                                    </button>
                                </h2>
                                <div id="collapseThree2" class="accordion-collapse collapse show"
                                     aria-labelledby="headingThree2" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                   id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                small
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                   id="flexCheckChecked">
                                            <label class="form-check-label" for="flexCheckChecked">
                                                medium
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                   id="flexCheckChecked2">
                                            <label class="form-check-label" for="flexCheckChecked2">
                                                large
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree3">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree3" aria-expanded="false"
                                            aria-controls="collapseThree">
                                        brand
                                    </button>
                                </h2>
                                <div id="collapseThree3" class="accordion-collapse collapse show"
                                     aria-labelledby="headingThree3" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul>
                                            @foreach ( $brands as $brand )
                                                <li><a href="{{ route('products.index',
                                                    ['brand' => $brand->slug]) }}">
                                                        {{ $brand->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="true"
                                            aria-controls="collapseThree">
                                        color
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse show"
                                     aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                   id="flexCheckDefaultc1">
                                            <label class="form-check-label" for="flexCheckDefaultc1">
                                                black
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                   id="flexCheckCheckedc2">
                                            <label class="form-check-label" for="flexCheckCheckedc2">
                                                white
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                   id="flexCheckCheckedc3">
                                            <label class="form-check-label" for="flexCheckCheckedc3">
                                                green
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                   id="flexCheckCheckedc4">
                                            <label class="form-check-label" for="flexCheckCheckedc4">
                                                pink
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                   id="flexCheckCheckedc5">
                                            <label class="form-check-label" for="flexCheckCheckedc5">
                                                red
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}

                        </div>
                    </div>
                </div>

                {{-- Tab Contents --}}
                <div class="col-xl-9 col-lg-8">
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

    @foreach ( $products as $product )
        <x-product-modal :product="$product" />
    @endforeach
@endsection

@push( 'scripts' )
    <script>
        ($ => {
            $(() => {
                $("body").on("click", "#product_page_banner_section", () => {
                    window.location.href = "{{ @$product_page_banner_section->banner_one->banner_url }}";
                });

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
