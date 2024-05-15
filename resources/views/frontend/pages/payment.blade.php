@extends( 'frontend.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Payment
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
                        <h4>payment</h4>
                        <ul>
                            <li><a href="{{ route('home') }}">home</a></li>
                            <li><a href="{{ route('user.checkout') }}">checkout</a></li>
                            <li><a href="javascript:">payment</a></li>
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
        PAYMENT PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="wsus__pay_info_area">
                <div class="row">
                    <div class="col-xl-3 col-lg-3">
                        <div class="wsus__payment_menu" id="sticky_sidebar">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                 aria-orientation="vertical">
                                <button class="nav-link common_btn active" id="v-pills-paypal-tab"
                                        data-bs-toggle="pill" data-bs-target="#v-pills-paypal"
                                        type="button" role="tab" aria-controls="v-pills-paypal"
                                        aria-selected="true">paypal
                                </button>
                                <button class="nav-link common_btn" id="v-pills-cod-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-cod" type="button" role="tab"
                                        aria-controls="v-pills-cod" aria-selected="false">Cash-on-Delivery
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5">
                        <div class="tab-content sticky_sidebar" id="v-pills-tabContent">
                            @include( 'frontend.pages.payment-gateways.paypal' )
                            @include( 'frontend.pages.payment-gateways.cod' )
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="wsus__pay_booking_summary" id="sticky_sidebar2">
                            <h5>Order Summary</h5>
                            <p>subtotal: <span>{{ $settings->currency_icon .
                                number_format(cartSubtotal(), 2) }}</span></p>
                            <p>shipping fee: <span>{{ $settings->currency_icon .
                                number_format(shippingFee(), 2) }}</span></p>
                            <p>discount: <span>{{ $settings->currency_icon .
                                number_format(couponDiscount(), 2) }}</span></p>
                            <h6>total <span>{{ $settings->currency_icon .
                                number_format(payableTotal(), 2) }}</span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        PAYMENT PAGE END
    ==============================-->
@endsection
