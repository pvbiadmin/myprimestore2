@extends( 'frontend.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || GCash Payment
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
                            <li><a href="javascript:">gcash payment</a></li>
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
                    <div class="col-xl-6 col-md-10 col-lg-8 col-xxl-5 m-auto">
                        <div class="wsus__404_text">
                            <h2>Thanks!</h2>
                            <h4>Please settle your <span>GCash</span><br> Payment using the following details:</h4>
                            <hr>
                            <h5><span>Account Name:</span> {{ $gcashSettings->name }}</h5>
                            <h5><span>GCash Number:</span> {{ $gcashSettings->number }}</h5>
                            <h5><span>Amount Payable:</span> {{ $settings->currency_icon .
                                number_format($payable, 2) }}</h5>
                            <p>Thank you for choosing our store. We trust you will find satisfaction in your new
                                purchases.</p>
                            <a href="{{ route('user.orders.show', $order_id)
                                }}" class="common_btn">Order Details</a>
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
