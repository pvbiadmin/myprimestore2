@extends( 'vendor.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Vendor Dashboard
@endsection

@section( 'content' )
    <!--=============================
  DASHBOARD START
==============================-->
    <section id="wsus__dashboard">
        <div class="container-fluid">

            @include( 'vendor.layouts.sidebar' )

            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <h3 class="mb-5">Vendor Dashboard</h3>
                    <div class="dashboard_content">
                        <div class="wsus__dashboard">
                            <div class="row">
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item red" href="{{ route('vendor.orders.index') }}">
                                        <i class="far fa-sun"></i>
                                        <p>Today's Orders</p>
                                        <p style="font-size: x-large">{{ number_format(@$orders_today) }}</p>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item green" href="{{ route('vendor.orders.index') }}">
                                        <i class="fal fa-hourglass"></i>
                                        <p style="font-size: x-small">Today's Pending Orders</p>
                                        <p style="font-size: x-large">{{ number_format(@$pending_orders_today) }}</p>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item sky" href="{{ route('vendor.orders.index') }}">
                                        <i class="fas fa-list-alt"></i>
                                        <p>Total Orders</p>
                                        <p style="font-size: x-large">{{ number_format(@$total_orders) }}</p>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item blue" href="{{ route('vendor.orders.index') }}">
                                        <i class="far fa-hourglass"></i>
                                        <p style="font-size: x-small">Total Pending Orders</p>
                                        <p style="font-size: x-large">{{ number_format(@$total_pending_orders) }}</p>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item orange" href="{{ route('vendor.orders.index') }}">
                                        <i class="fas fa-badge-check"></i>
                                        <p style="font-size: x-small">Total Completed Orders</p>
                                        <p style="font-size: x-large">{{ number_format(@$total_completed_orders) }}</p>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item purple" href="{{ route('vendor.products.index') }}">
                                        <i class="fal fa-box-open"></i>
                                        <p>Total Products</p>
                                        <p style="font-size: x-large">{{ number_format(@$total_products) }}</p>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item blue" href="{{ route('vendor.reviews.index') }}">
                                        <i class="fal fa-star"></i>
                                        <p>Total Reviews</p>
                                        <p style="font-size: x-large">{{ number_format(@$total_reviews) }}</p>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item orange" href="javascript:">
                                        <i class="fal fa-sun"></i>
                                        <p style="font-size: small">Today's Earnings</p>
                                        <p style="font-size: x-large">{{ $settings->currency_icon
                                            }}{{ number_format(@$earnings_today, 2) }}</p>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item purple" href="javascript:">
                                        <i class="fal fa-moon"></i>
                                        <p style="font-size: small">Monthly Earnings</p>
                                        <p style="font-size: x-large">{{ $settings->currency_icon }}{{
                                            number_format(@$monthly_earnings, 2) }}</p>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item green" href="javascript:">
                                        <i class="fal fa-calendar-check"></i>
                                        <p>Yearly Earnings</p>
                                        <p style="font-size: x-large">{{ $settings->currency_icon }}{{
                                            number_format(@$yearly_earnings, 2) }}</p>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item sky" href="javascript:">
                                        <i class="fal fa-wallet"></i>
                                        <p>Total Earnings</p>
                                        <p style="font-size: x-large">{{ $settings->currency_icon }}{{
                                            number_format(@$total_earnings, 2) }}</p>
                                    </a>
                                </div>

                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item red"
                                       href="{{ route('vendor.shop-profile.index') }}">
                                        <i class="fal fa-user-alt"></i>
                                        <p>Shop Profile</p>
                                        <p style="font-size: x-large">***</p>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
      DASHBOARD START
    ==============================-->
@endsection
