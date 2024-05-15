@extends( 'frontend.dashboard.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || User Dashboard
@endsection

@section( 'content' )
    <!--=============================
      DASHBOARD START
    ==============================-->
    <section id="wsus__dashboard">
        <div class="container-fluid">

            @include( 'frontend.dashboard.layouts.sidebar' )

            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <h3 class="mb-5">User Dashboard</h3>
                    <div class="dashboard_content">
                        <div class="wsus__dashboard">
                            <div class="row">
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item red" href="{{ route('user.orders.index') }}">
                                        <i class="far fa-list-alt"></i>
                                        <p>Total Orders</p>
                                        <p style="font-size: x-large">{{ number_format(@$total_orders) }}</p>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item green" href="javascript:">
                                        <i class="far fa-stream"></i>
                                        <p>Pending Orders</p>
                                        <p style="font-size: x-large">{{ number_format(@$pending_orders) }}</p>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item sky" href="javascript:">
                                        <i class="far fa-clipboard-list-check"></i>
                                        <p style="font-size: small">Completed Orders</p>
                                        <p style="font-size: x-large">{{ number_format(@$completed_orders) }}</p>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item blue" href="{{ route('user.review.index') }}">
                                        <i class="far fa-star"></i>
                                        <p>Reviews</p>
                                        <p style="font-size: x-large">{{ number_format(@$reviews) }}</p>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item orange" href="{{ route('user.wishlist.index') }}">
                                        <i class="far fa-heart"></i>
                                        <p>Wishlist</p>
                                        <p style="font-size: x-large">{{ number_format(@$wishlist) }}</p>
                                    </a>
                                </div>
                                <div class="col-xl-2 col-6 col-md-4">
                                    <a class="wsus__dashboard_item purple" href="{{ route('user.profile') }}">
                                        <i class="fal fa-user-alt"></i>
                                        <p>Profile</p>
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
