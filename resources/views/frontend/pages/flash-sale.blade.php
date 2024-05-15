@extends( 'frontend.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Flash Sale
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
                        <h4>flash sale</h4>
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li><a href="javascript:">flash sale</a></li>
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
        DAILY DEALS DETAILS START
    ==============================-->
    <section id="wsus__daily_deals">
        <div class="container">
            <div class="wsus__offer_details_area">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="wsus__section_header rounded-0">
                            <h3>flash sale</h3>
                            <div class="wsus__offer_countdown">
                                <span class="end_text">ends time :</span>
                                <div class="simply-countdown simply-countdown-one"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @php
                        $products = \App\Models\Product::query()
                            ->withAvg('reviews', 'rating')
                            ->withCount('reviews')
                            ->with(['variants', 'category', 'imageGallery'])
                            ->whereIn('id', $flash_sale_items)
                            ->orderBy('id', 'ASC')
                            ->paginate(20);
                    @endphp
                    @foreach ( $products as $product )
                        <x-product-card :product="$product" :section="'flashSale'"/>
                    @endforeach
                </div>

                <div class="mt-5">
                    @if ( $products->hasPages() )
                        {{ $products->links() }}
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--============================
        DAILY DEALS DETAILS END
    ==============================-->

    <!--==========================
    PRODUCT MODAL VIEW START
    ===========================-->
    @php
        $products = \App\Models\Product::query()
            ->with(['variants', 'category', 'vendor', 'brand', 'imageGallery', 'reviews'])
            ->whereIn('id', $flash_sale_items)->get();
    @endphp
    @foreach ( $products as $product )
        <x-product-modal :product="$product"/>
    @endforeach

    <!--==========================
  PRODUCT MODAL VIEW END
===========================-->
@endsection

@push( 'scripts' )
    <script>
        ($ => {
            $(() => {
                simplyCountdown('.simply-countdown-one', {
                    year: {{ date('Y', strtotime(@$flash_sale->end_date)) }},
                    month: {{ date('m', strtotime(@$flash_sale->end_date)) }},
                    day: {{ date('d', strtotime(@$flash_sale->end_date)) }},
                });
            });
        })(jQuery);
    </script>
@endpush
