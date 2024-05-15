@extends( 'vendor.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Packages
@endsection

@section( 'content' )
    <section id="wsus__dashboard">
        <div class="container-fluid">

            @include( 'vendor.layouts.sidebar' )

            @php
                $cart_package = cartPackage();
            @endphp

            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-box" aria-hidden="true"></i> Packages</h3>
                        <div class="create_button view_cart_package {{ $cart_package
                            && $cart_package[0]->options->is_package == 1 ? '' : 'd-none' }}">
                            <a href="{{ route('cart-details') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-cart" aria-hidden="true"></i> View Cart</a>
                        </div>
                        <div class="wsus__dashboard_review">
                            <div class="row">
                                @if ( count($packages) > 0 )
                                    @foreach ( $packages as $package )
                                        <x-product-card-list :product="$package" :section="'package'"/>
                                    @endforeach
                                @else
                                    <div class="col-xl-12">
                                        <div class="wsus__product_item wsus__list_view">
                                            <div class="col-xl-6 col-md-10 col-lg-8 col-xxl-5 m-auto">
                                                <div class="wsus__404_text">
                                                    <p>No package to show</p>
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
        </div>
    </section>
@endsection
