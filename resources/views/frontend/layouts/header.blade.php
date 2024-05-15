@php
    $login_id = isset(auth()->user()->id) ?? null;
    $count_wishlist = $login_id ? \App\Models\Wishlist::query()
        ->where(['user_id' => auth()->user()->id])->count() : 0;
@endphp

<header>
    <div class="container">
        <div class="row">
            <div class="col-2 col-md-1 d-lg-none">
                <div class="wsus__mobile_menu_area">
                    <span class="wsus__mobile_menu_icon"><i class="fal fa-bars"></i></span>
                </div>
            </div>
            <div class="col-xl-2 col-7 col-md-8 col-lg-2">
                <div class="wsus_logo_area">
                    <a class="wsus__header_logo" href="{{ url('/') }}">
                        <img src="{{ asset($logo_setting->logo) }}" alt="logo" class="img-fluid w-100">
                    </a>
                </div>
            </div>
            <div class="col-xl-5 col-md-6 col-lg-4 d-none d-lg-block">
                <div class="wsus__search">
                    <form action="{{ route('products.index') }}">
                        <input type="text" name="search" value="{{ request()->search }}"
                               placeholder="Search..." aria-label="search">
                        <button type="submit"><i class="far fa-search"></i></button>
                    </form>
                </div>
            </div>
            <div class="col-xl-5 col-3 col-md-3 col-lg-6">
                <div class="wsus__call_icon_area">
                    <div class="wsus__call_area">
                        <div class="wsus__call">
                            <i class="fas fa-user-headset"></i>
                        </div>
                        <div class="wsus__call_text">
                            <p>{{ $settings->contact_email }}</p>
                            <p>{{ $settings->contact_phone }}</p>
                        </div>
                    </div>
                    <ul class="wsus__icon_area">
                        <li><a href="{{ route('user.wishlist.index') }}"><i class="fal fa-heart"></i><span
                                    class="wishlist-count {{ $count_wishlist > 0 ? '' : 'd-none' }}">
                                    {{ $count_wishlist > 0 ? $count_wishlist : 0 }}</span></a></li>
                        <li>
                            <a class="wsus__cart_icon" href="#">
                                <i class="fal fa-shopping-bag"></i><span class="cart-count {{
                                    \Gloudemans\Shoppingcart\Facades\Cart::content()->count() > 0 ? '' : 'd-none' }}">
                                    {{ Gloudemans\Shoppingcart\Facades\Cart::content()->count() }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="wsus__mini_cart">
        <h4>shopping cart <span class="wsus_close_mini_cart"><i class="far fa-times"></i></span></h4>
        <ul class="mini_cart_wrapper">
            @if( \Gloudemans\Shoppingcart\Facades\Cart::content()->count() > 0 )
                @foreach( \Gloudemans\Shoppingcart\Facades\Cart::content() as $item )
                    <li id="mini-cart-{{ $item->rowId }}">
                        <div class="wsus__cart_img">
                            <a href="{{ route('product-detail', $item->options->slug) }}">
                                <img src="{{ asset($item->options->image) }}" alt="{!! $item->name !!}"
                                     class="img-fluid w-100"></a>
                            <a class="wsis__del_icon remove_sidebar_item" href="#" data-row-id="{{ $item->rowId }}">
                                <i class="fas fa-minus-circle"></i></a>
                        </div>
                        <div class="wsus__cart_text">
                            <a class="wsus__cart_title" href="{{ route('product-detail', $item->options->slug) }}">
                                {!! $item->name !!}</a>
                            <p>{{ $settings->currency_icon . number_format($item->price, 2) }}</p>
                            @if ( ($add = $item->options->variant_price_total) > 0 )
                                <small>Add.: {{ $settings->currency_icon . number_format($add, 2) }}</small><br>
                            @endif
                            <small>Qty: {{ $item->qty }}</small>
                        </div>
                    </li>
                @endforeach
            @else
                <div class="col-xl-6 col-md-10 col-lg-8 col-xxl-5 m-auto">
                    <div class="wsus__404_text">
                        <p>Cart is Empty.</p>
                    </div>
                </div>
            @endif
        </ul>
        <div class="mini-cart-actions {{ \Gloudemans\Shoppingcart\Facades\Cart::content()->count() > 0
            ? '' : 'd-none' }}">
            <h5>Subtotal <span id="mini-cart-subtotal">{{
                $settings->currency_icon . number_format(cartSubtotal(), 2) }}</span></h5>
            <div class="wsus__minicart_btn_area">
                <a class="common_btn" href="{{ route('cart-details') }}">view cart</a>
                <a class="common_btn" href="{{ route('user.checkout') }}">checkout</a>
            </div>
        </div>
    </div>
</header>
