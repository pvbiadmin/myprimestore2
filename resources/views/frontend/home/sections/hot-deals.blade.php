@if ( count($type_base_products) > 0 )
    <section id="wsus__hot_deals" class="wsus__hot_deals_2">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="wsus__section_header">
                        <h3>Product Types</h3>
                    </div>
                </div>
            </div>
            <div class="wsus__hot_large_item">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="wsus__section_header justify-content-start">
                            <div class="monthly_top_filter2 mb-1">
                                @if ( count($type_base_products['new_arrival']) > 0 )
                                    <button class="ms-0 active auto_click" data-filter=".new_arrival">
                                        New Arrival
                                    </button>
                                @endif
                                @if ( count($type_base_products['featured_product']) > 0 )
                                    <button data-filter=".featured_product">Featured Products</button>
                                @endif
                                @if ( count($type_base_products['top_product']) > 0 )
                                    <button data-filter=".top_product">Top Products</button>
                                @endif
                                @if ( count($type_base_products['best_product']) > 0 )
                                    <button data-filter=".best_product">Best Products</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row grid2">
                    @foreach( $type_base_products as $key => $products )
                        @foreach( $products as $product )
                            <x-product-card :product="$product" :section="'hotDeals'" :key="$key"/>
                        @endforeach
                    @endforeach
                </div>
            </div>

            <section id="wsus__single_banner" class="home_2_single_banner">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6">
                            @if ( @$homepage_section_banner_three->banner_one->status == 1 )
                                <div class="wsus__single_banner_content banner_1">
                                    <a href="{{ @$homepage_section_banner_three->banner_one->banner_url }}"
                                       class="wsus__single_banner_img">
                                        <img
                                            src="{{ asset(@$homepage_section_banner_three->banner_one->banner_image) }}"
                                            alt="banner" class="img-fluid w-100">
                                    </a>
                                    @if ( @$homepage_section_banner_three->banner_one->hook_text
                                        || @$homepage_section_banner_three->banner_one->highlight_text
                                        || @$homepage_section_banner_three->banner_one->followup_text
                                        || @$homepage_section_banner_three->banner_one->button_text )
                                        <div class="wsus__single_banner_text">
                                            @if ( @$homepage_section_banner_three->banner_one->hook_text
                                                || @$homepage_section_banner_three->banner_one->highlight_text )
                                                <h6>@if ( @$homepage_section_banner_three->banner_one->hook_text ){{
                                            @$homepage_section_banner_three->banner_one->hook_text }}@endif
                                                    @if ( @$homepage_section_banner_three->banner_one->highlight_text )
                                                        <span>{{@$homepage_section_banner_three->banner_one->highlight_text
                                                        }}</span>@endif</h6>
                                            @endif
                                            @if ( @$homepage_section_banner_three->banner_one->followup_text )
                                                <h3>{{ @$homepage_section_banner_three->banner_one->followup_text }}</h3>
                                            @endif
                                            @if ( @$homepage_section_banner_three->banner_one->button_text )
                                                <a class="shop_btn" href="{{
                                                @$homepage_section_banner_three->banner_one->banner_url }}">{{
                                                @$homepage_section_banner_three->banner_one->button_text }}
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div class="row">
                                <div class="col-12">
                                    @if ( @$homepage_section_banner_three->banner_two->status == 1 )
                                        <div class="wsus__single_banner_content single_banner_2">
                                            <a href="{{ @$homepage_section_banner_three->banner_two->banner_url }}"
                                               class="wsus__single_banner_img">
                                                <img alt="banner" class="img-fluid w-100" src="{{
                                                asset(@$homepage_section_banner_three->banner_two->banner_image) }}">
                                            </a>
                                            @if ( @$homepage_section_banner_three->banner_two->leading_text
                                                || @$homepage_section_banner_three->banner_two->followup_text
                                                || @$homepage_section_banner_three->banner_two->button_text )
                                                <div class="wsus__single_banner_text">
                                                    @if ( @$homepage_section_banner_three->banner_two->leading_text )
                                                        <h6>{{ @$homepage_section_banner_three->banner_two->leading_text }}</h6>
                                                    @endif
                                                    @if ( @$homepage_section_banner_three->banner_two->followup_text )
                                                        <h3>{{ @$homepage_section_banner_three->banner_two->followup_text }}</h3>
                                                    @endif
                                                    @if ( @$homepage_section_banner_three->banner_two->button_text )
                                                        <a class="shop_btn" href="{{
                                                        @$homepage_section_banner_three->banner_two->banner_url }}">{{
                                                        @$homepage_section_banner_three->banner_two->button_text }}</a>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12 mt-lg-4">
                                    <div class="wsus__single_banner_content">
                                        <a href="{{ @$homepage_section_banner_three->banner_three->banner_url }}"
                                           class="wsus__single_banner_img">
                                            <img class="img-fluid w-100" alt="banner" src="{{
                                            asset(@$homepage_section_banner_three->banner_three->banner_image) }}">
                                        </a>
                                        @if ( @$homepage_section_banner_three->banner_three->hook_text
                                            || @$homepage_section_banner_three->banner_three->highlight_text
                                            || @$homepage_section_banner_three->banner_three->followup_text
                                            || @$homepage_section_banner_three->banner_three->button_text )
                                            <div class="wsus__single_banner_text">
                                                @if ( @$homepage_section_banner_three->banner_three->hook_text
                                                    || @$homepage_section_banner_three->banner_three->highlight_text )
                                                    <h6>@if ( @$homepage_section_banner_three->banner_three->hook_text ){{
                                                @$homepage_section_banner_three->banner_three->hook_text
                                                }}@endif @if (
                                                @$homepage_section_banner_three->banner_three->highlight_text )<span>{{
                                                @$homepage_section_banner_three->banner_three->highlight_text
                                                }}</span>@endif</h6>
                                                @endif
                                                @if ( @$homepage_section_banner_three->banner_three->followup_text )
                                                    <h3>{{ @$homepage_section_banner_three->banner_three->followup_text }}</h3>
                                                @endif
                                                @if ( @$homepage_section_banner_three->banner_three->button_text )
                                                    <a class="shop_btn" href="{{
                                                    @$homepage_section_banner_three->banner_three->banner_url }}">{{
                                                    @$homepage_section_banner_three->banner_three->button_text }}</a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>

    @foreach( $type_base_products as $products )
        @foreach( $products as $product )
            <x-product-modal :product="$product"/>
        @endforeach
    @endforeach
@endif
