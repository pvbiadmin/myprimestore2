@if ( count($flash_sale_items) > 0 )
    <section id="wsus__flash_sell" class="wsus__flash_sell_2">
        <div class=" container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="offer_time" style="background: url({{ asset('frontend/images/flash_sell_bg.jpg') }})">
                        <div class="wsus__flash_coundown">
                            <span class=" end_text">flash sale</span>
                            <div class="simply-countdown simply-countdown-one"></div>
                            <a class="common_btn" href="{{ route('flash-sale') }}">
                                see more <i class="fas fa-caret-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row flash_sell_slider">
                @php
                    $products = \App\Models\Product::query()
                        ->withAvg('reviews', 'rating')
                        ->withCount('reviews')
                        ->with(['variants', 'category', 'imageGallery'])
                        ->whereIn('id', $flash_sale_items)->get();
                @endphp
                @foreach( $products as $product )
                        <x-product-card :product="$product" :section="'flashSale'" />
                @endforeach
            </div>
        </div>
    </section>
    @php
        $products = \App\Models\Product::query()
            ->with(['variants', 'category', 'vendor', 'brand', 'imageGallery', 'reviews'])
            ->whereIn('id', $flash_sale_items)->get();
    @endphp
    @foreach( $products as $product )
        <x-product-modal :product="$product" />
    @endforeach

    @push( 'scripts' )
        <script>
            ($ => {
                $(() => {
                    simplyCountdown(".simply-countdown-one", {
                        year: {{ date("Y", strtotime(@$flash_sale->end_date)) }},
                        month: {{ date("m", strtotime(@$flash_sale->end_date)) }},
                        day: {{ date("d", strtotime(@$flash_sale->end_date)) }}
                    });
                });
            })(jQuery);
        </script>
    @endpush
@endif
