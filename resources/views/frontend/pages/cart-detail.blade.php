@extends( 'frontend.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Cart Details
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
                        <h4>Cart Details</h4>
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li><a href="javascript:">cart details</a></li>
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
    CART VIEW PAGE START
==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="row">
                @if( count($cart_items) > 0 )
                    <div class="col-xl-9">
                        <div class="wsus__cart_list">
                            <div class="table-responsive">
                                <table>
                                    <tbody>
                                    <tr class="d-flex">
                                        <th class="wsus__pro_img">
                                            product item
                                        </th>

                                        <th class="wsus__pro_name">
                                            product details
                                        </th>

                                        <th class="wsus__pro_tk">
                                            unit price
                                        </th>

                                        <th class="wsus__pro_tk">
                                            total
                                        </th>

                                        <th class="wsus__pro_select">
                                            quantity
                                        </th>

                                        <th class="wsus__pro_icon">
                                            <a href="{{ route('clear-cart') }}" class="common_btn clear_cart">
                                                clear cart</a>
                                        </th>
                                    </tr>
                                    @foreach ( $cart_items as $item )
                                        <tr class="d-flex">
                                            <td class="wsus__pro_img">
                                                <a class="wsus__pro_link"
                                                   href="{{ route('product-detail', $item->options->slug) }}">
                                                    <img src="{{ asset($item->options->image) }}"
                                                         alt="{!! $item->name !!}" class="img-fluid w-100">
                                                </a>
                                            </td>

                                            <td class="wsus__pro_name">
                                                <p>{!! $item->name !!}</p>
                                                @if ( count($item->options->variants) > 0 )
                                                    @foreach ( $item->options->variants as $key => $variant )
                                                        <span>{{ $key }}: {{ $variant['name'] }} {{
                                                            $variant['price'] > 0 ? '(' . $settings->currency_icon .
                                                        number_format($variant['price'], 2) . ')' : '' }}</span>
                                                    @endforeach
                                                @endif
                                            </td>

                                            <td class="wsus__pro_tk">
                                                <h6>{{ $settings->currency_icon .
                                                    number_format($item->price, 2) }}</h6>
                                            </td>

                                            <td class="wsus__pro_tk">
                                                <h6 id="{{ $item->rowId }}">
                                                    {{ $settings->currency_icon . number_format((
                                                        $item->price + $item->options->variant_price_total
                                                        ) * $item->qty, 2) }}
                                                </h6>
                                            </td>

                                            <td class="wsus__pro_select">
                                                <div class="product_qty_wrapper">
                                                    @if ( $item->options->is_package
                                                        && $item->options->is_package == 1 )
                                                        {{ $item->qty }}
                                                    @else
                                                        <button class="decrement-cart-qty less-cart-qty">-</button>
                                                        <input class="product-qty cart-qty" name="quantity"
                                                               type="text" min="1" max="10" value="{{ $item->qty }}"
                                                               data-row-id="{{ $item->rowId }}"
                                                               aria-label="quantity" readonly/>
                                                        <button class="increment-cart-qty plus-cart-qty">+</button>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="wsus__pro_icon">
                                                <a href="{{ route('cart.remove-product', $item->rowId) }}">
                                                    <i class="far fa-times"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @php
                        $cart_package = cartPackage();
                    @endphp
                    <div class="col-xl-3">
                        <div class="wsus__cart_list_footer_button" id="sticky_sidebar">
                            <h6>total cart</h6>
                            <p>subtotal: <span id="cart-detail-subtotal">{{ $settings->currency_icon .
                                number_format(cartSubtotal(), 2) }}</span></p>
                            <p>coupon(-): <span id="coupon-discount">{{ $settings->currency_icon .
                                    number_format(couponDiscount(), 2) }}</span></p>
                            <p class="total"><span>total:</span> <span id="cart-total">{{
                                $settings->currency_icon . number_format(cartTotal(), 2) }}</span></p>
                            @if ( $cart_package && $cart_package[0]->options->is_package == 1 )
                                <form id="referral_form">
                                    <input type="text" name="referral" value="{{ session()->has('referral')
                                        ? session('referral')['code'] : '' }}"
                                           placeholder="Referral Code" aria-label="referral">
                                    <button type="submit" class="common_btn">apply</button>
                                </form>
                            @endif
                            <form id="coupon_form">
                                <input type="text" name="coupon" value="{{ session()->has('coupon')
                                    ? session('coupon')['code'] : '' }}"
                                       placeholder="{{ session()->has('coupon')
                                        ? session('coupon')['code'] : 'Coupon Code' }}" aria-label="coupon">
                                <button type="submit" class="common_btn">apply</button>
                            </form>
                            <a class="common_btn mt-4 w-100 text-center"
                               href="{{ route('user.checkout') }}">checkout</a>
                            <a class="common_btn mt-1 w-100 text-center"
                               href="{{ route('home') }}"><i class="fab fa-shopify"></i> go shop</a>
                        </div>
                    </div>
                @else
                    <div class="col-xl-6 col-md-10 col-lg-8 col-xxl-5 m-auto">
                        <div class="wsus__404_text">
                            <p>Cart is Empty.</p>
                            <p><a href="{{ url('/') }}" class="btn btn-primary">Shop for Products</a></p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section id="wsus__single_banner">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    @if ( @$cart_page_banner_section->banner_one->status == 1 )
                        <div class="wsus__single_banner_content">
                            <a class="wsus__single_banner_img" href="{{
                                @$cart_page_banner_section->banner_one->banner_url }}">
                                <img src="{{ asset(@$cart_page_banner_section->banner_one->banner_image) }}"
                                     alt="banner" class="img-fluid w-100">
                            </a>
                            @if ( @$cart_page_banner_section->banner_one->hook_text
                            || @$cart_page_banner_section->banner_one->highlight_text
                            || @$cart_page_banner_section->banner_one->followup_text
                            || @$cart_page_banner_section->banner_one->button_text )
                                <div class="wsus__single_banner_text">
                                    <h6>@if ( @$cart_page_banner_section->banner_one->hook_text ){{
                                    @$cart_page_banner_section->banner_one->hook_text }}@endif @if(
                                    @$cart_page_banner_section->banner_one->highlight_text )<span>{{
                                @$cart_page_banner_section->banner_one->highlight_text }}</span>@endif</h6>
                                    @if ( @$cart_page_banner_section->banner_one->followup_text )<h3>{{
                                    @$cart_page_banner_section->banner_one->followup_text }}</h3>@endif
                                    @if ( @$cart_page_banner_section->banner_one->followup_text )
                                        <a class="shop_btn" href="{{
                                    @$cart_page_banner_section->banner_one->banner_url }}">{{
                                    @$cart_page_banner_section->banner_one->button_text }}</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="col-xl-6 col-lg-6">
                    @if ( @$cart_page_banner_section->banner_two->status == 1 )
                        <div class="wsus__single_banner_content single_banner_2">
                            <a class="wsus__single_banner_img"
                               href="{{ @$cart_page_banner_section->banner_two->banner_url }}">
                                <img src="{{ asset(@$cart_page_banner_section->banner_two->banner_image) }}"
                                     alt="banner" class="img-fluid w-100">
                            </a>
                            @if ( @$cart_page_banner_section->banner_two->leading_text
                                || @$cart_page_banner_section->banner_two->followup_text
                                || @$cart_page_banner_section->banner_two->button_text )
                                <div class="wsus__single_banner_text">
                                    @if ( @$cart_page_banner_section->banner_two->leading_text )
                                        <h6>{{ @$cart_page_banner_section->banner_two->leading_text }}</h6>
                                    @endif
                                    @if ( @$cart_page_banner_section->banner_two->followup_text )
                                        <h3>{{ @$cart_page_banner_section->banner_two->followup_text }}</h3>
                                    @endif
                                    @if ( @$cart_page_banner_section->banner_two->button_text )
                                        <a class="shop_btn" href="{{
                                        @$cart_page_banner_section->banner_two->banner_url }}">{{
                                        @$cart_page_banner_section->banner_two->button_text }}</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--============================
          CART VIEW PAGE END
    ==============================-->
@endsection

@push( 'scripts' )
    <script>
        ($ => {
            $(() => {
                const changeQuantity = (trigger) => {
                    // Validate the trigger input
                    if (trigger !== "plus" && trigger !== "less") {
                        console.error("Invalid trigger value. Expected 'plus' or 'less'.");
                        return; // Exit the function early
                    }

                    // Define the class name for the trigger based on the input
                    let cl_trigger = trigger === "plus" ? ".plus-cart-qty" : ".less-cart-qty";

                    // Attach click event handler to the specified trigger class
                    $("body").on("click", cl_trigger, e => {
                        // Get the current target (the clicked button)
                        const $this = $(e.currentTarget);

                        // Find the input element for quantity in the same container as the clicked button
                        let input = $this.siblings(".cart-qty");

                        // Get the current quantity value
                        let quantity = parseInt(input.val());

                        // Update quantity based on the trigger (plus or less)
                        quantity = trigger === "plus" ? quantity + 1 : quantity - 1;

                        // Retrieve min and max values from the input element
                        const minValue = parseInt(input.attr('min'));
                        const maxValue = parseInt(input.attr('max'));

                        if (trigger === "less" && quantity < minValue) {
                            return;
                        }

                        if (trigger === "plus" && quantity > maxValue) {
                            return;
                        }

                        // Ensure quantity stays within the min and max range
                        // quantity = quantity < minValue ? minValue : quantity;
                        // quantity = quantity > maxValue ? maxValue : quantity;

                        // Update the value of the input element
                        input.val(quantity);

                        // Get the cart rowId of the input element
                        const rowId = input.data("row-id");

                        // Send data to CartController::updateQuantity for processing
                        $.ajax({
                            url: "{{ route('cart.update-quantity') }}",
                            method: "POST",
                            data: {
                                rowId: rowId,
                                quantity: quantity
                            },
                            success: response => {
                                const {status, message, product_total: productTotal} = response;

                                if (status === "success") {
                                    const total = parseFloat(productTotal);
                                    const totalFormatted = total.toLocaleString(undefined, {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });

                                    $("#" + rowId).text("{{$settings->currency_icon}}" + totalFormatted);

                                    getCartItems();

                                    toastr.success(message);
                                } else if (response.status === "error") {
                                    toastr.error(response.message);
                                }
                            },
                            error: (xhr, status, error) => {
                                console.log(error);
                            }
                        });
                    });
                };

                const clearCart = () => {
                    $("body").on("click", ".clear_cart", e => {
                        e.preventDefault();

                        const $this = $(e.currentTarget);
                        const deleteUrl = $this.attr("href");

                        Swal.fire({
                            title: "Are you sure?",
                            text: "This action will clear your cart!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, clear it!"
                        }).then(result => {
                            const {isConfirmed} = result;

                            if (isConfirmed) {
                                $.ajax({
                                    type: "GET",
                                    url: deleteUrl,
                                    success: response => {
                                        const {status, message} = response;

                                        if (status === "success") {
                                            Swal.fire({
                                                title: "Cart Cleared!",
                                                text: message,
                                                icon: "success"
                                            });

                                            // Assuming you have a variable sectionId that holds the ID of the section you want to scroll to
                                            const sectionId = 'wsus__cart_view';

                                            // Reload the page
                                            location.reload();

                                            // After the page is reloaded, scroll to the specified section
                                            $(window).on('load', function () {
                                                const sectionElement = $('#' + sectionId);

                                                if (sectionElement.length) {
                                                    $('html, body').animate({
                                                        scrollTop: sectionElement.offset().top
                                                    }, 1000); // Adjust the scroll speed as needed
                                                }
                                            });

                                            // window.location.reload();
                                        } else if (status === "error") {
                                            Swal.fire({
                                                title: "Can't Be Cleared!",
                                                text: message,
                                                icon: "error"
                                            });
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        console.log(error);
                                    }
                                });
                            }
                        });
                    });
                };

                const formatFloat = (float) => {
                    const parsedFloat = parseFloat(float);
                    return parsedFloat.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }

                const getCartItems = () => {
                    $.ajax({
                        url: "{{ route('cart-items') }}",
                        method: "GET",
                        success: response => {
                            // console.log(response);
                            const cl_mini_cart_wrapper = $(".mini_cart_wrapper");

                            cl_mini_cart_wrapper.html("");

                            let html = "";

                            for (let item in response) {
                                if (response.hasOwnProperty(item)) {
                                    const {rowId, name, qty, price, options} = response[item];
                                    const {variant_price_total, slug, image} = options;

                                    const priceFormatted = formatFloat(price);
                                    const variantPriceTotalFormatted = formatFloat(variant_price_total);


                                    html += `<li id="mini-cart-${rowId}">
                                            <div class="wsus__cart_img">
                                                <a href="{{ route('product-detail', '') }}/${slug}">
                                                    <img src="{{ asset('') }}/${image}" alt="${name}"
                                                        class="img-fluid w-100"></a>
                                                <a class="wsis__del_icon remove_sidebar_item"
                                                    data-row-id="${rowId}" href="#">
                                                    <i class="fas fa-minus-circle"></i></a>
                                            </div>
                                            <div class="wsus__cart_text">
                                                <a class="wsus__cart_title"
                                                    href="{{ route('product-detail', '') }}/${slug}">${name}</a>
                                                <p>{{ $settings->currency_icon }}${priceFormatted}</p>`;
                                    html += variantPriceTotalFormatted > 0 ? `<small>Add.: {{
                                                $settings->currency_icon }}${variantPriceTotalFormatted}
                                            </small><br>` : ``;
                                    html += `<small>Qty: ${qty}</small>
                                            </div>
                                        </li>`;
                                }
                            }

                            cl_mini_cart_wrapper.html(html);
                            getCartSubtotal();
                            calculateCoupon();
                        },
                        error: (xhr, status, error) => {
                            console.log(error);
                        }
                    });
                };

                const getCartSubtotal = () => {
                    $.ajax({
                        url: "{{ route('cart.sidebar.subtotal') }}",
                        method: "GET",
                        success: response => {
                            const responseFormatted = formatFloat(response);

                            $("#cart-detail-subtotal").text("{{ $settings->currency_icon }}" + responseFormatted);
                            $("#mini-cart-subtotal").text("{{ $settings->currency_icon }}" + responseFormatted);
                        },
                        error: (xhr, status, error) => {
                            console.log(error);
                        }
                    });
                }

                const applyCoupon = () => {
                    $("#coupon_form").on("submit", e => {
                        e.preventDefault();

                        const $this = $(e.currentTarget);
                        const formData = $this.serialize();

                        $.ajax({
                            url: "{{ route('cart.apply-coupon') }}",
                            method: "GET",
                            data: formData,
                            success: response => {
                                if (response.status === 'success') {
                                    calculateCoupon();
                                    toastr.success(response.message);
                                } else if (response.status === 'error') {
                                    toastr.error(response.message);
                                }
                            },
                            error: (xhr, status, error) => {
                                console.log(error);
                            }
                        });
                    });
                }

                const applyReferral = () => {
                    $("#referral_form").on("submit", e => {
                        e.preventDefault();

                        const $this = $(e.currentTarget);
                        const formData = $this.serialize();

                        $.ajax({
                            url: "{{ route('cart.apply-referral') }}",
                            method: "GET",
                            data: formData,
                            success: response => {
                                if (response.status === 'success') {
                                    console.log(response);
                                    toastr.success(response.message);
                                } else if (response.status === 'error') {
                                    toastr.error(response.message);
                                }
                            },
                            error: (xhr, status, error) => {
                                console.log(error);
                            }
                        });
                    });
                }

                const calculateCoupon = () => {
                    $.ajax({
                        url: "{{ route('cart.coupon-calculation') }}",
                        method: "GET",
                        success: response => {
                            const {status, coupon_discount, cart_total} = response;

                            if (status === 'success') {
                                $("#coupon-discount").text("{{$settings->currency_icon}}"
                                    + formatFloat(coupon_discount));
                                $("#cart-total").text("{{$settings->currency_icon}}"
                                    + formatFloat(cart_total));
                            } else if (response.status === 'error') {
                                toastr.error(response.message);
                            }
                        },
                        error: (xhr, status, error) => {
                            console.log(error);
                        }
                    });
                }

                // Call the changeQuantity function for both plus and less triggers
                changeQuantity("plus");
                changeQuantity("less");
                clearCart();
                applyCoupon();
                applyReferral();
            });
        })(jQuery);
    </script>
@endpush
