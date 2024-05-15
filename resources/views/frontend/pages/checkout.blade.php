@extends( 'frontend.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Checkout
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
                        <h4>checkout</h4>
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li><a href="{{ route('cart-details') }}">cart details</a></li>
                            <li><a href="javascript:">checkout</a></li>
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
        CHECK OUT PAGE START
    ==============================-->
    <section id="wsus__cart_view">
        <div class="container">
            <div class="wsus__checkout_form">
                <div class="row">
                    <div class="col-xl-8 col-lg-7">
                        <div class="wsus__check_form">
                            <h5>Shipping Details <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    add new address</a></h5>
                            <div class="row">
                                @foreach ( $addresses as $address )
                                    <div class="col-xl-6">
                                        <div class="wsus__checkout_single_address">
                                            <div class="form-check">
                                                <input class="form-check-input shipping_address"
                                                       data-address-id="{{ $address->id }}"
                                                       type="radio" name="flexRadioDefault"
                                                       id="flexRadioDefault1" checked>
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Select Address
                                                </label>
                                            </div>
                                            <ul>
                                                <li><span>Name :</span> {{ $address->name }}</li>
                                                <li><span>Phone :</span> {{ $address->phone }}</li>
                                                <li><span>Email :</span> {{ $address->email }}</li>
                                                <li><span>Country :</span> {{
                                                    config('settings.country_list')[$address->country] }}</li>
                                                <li><span>Region / State :</span> {{ $address->state }}</li>
                                                <li><span>Town / City :</span> {{ $address->city }}</li>
                                                <li><span>Address :</span> {{ $address->address }}</li>
                                                <li><span>Zip Code :</span> {{ $address->zip }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5">
                        <div class="wsus__order_details" id="sticky_sidebar">
                            @if ( count($shipping_methods) > 0 )
                                <p class="wsus__product">Shipping Methods</p>
                                @if ( !session()->has('shipping_rule') )
                                    @php $firstChecked = false; @endphp
                                @endif
                                @foreach ( $shipping_methods as $shipping )
                                    @if ( session()->has('shipping_rule') )
                                        @if ( $shipping->type === 2 && cartSubtotal() >= $shipping->min_cost )
                                            <div class="form-check">
                                                <input class="form-check-input shipping_method" type="radio"
                                                       data-shipping-cost="{{ $shipping->cost }}"
                                                       name="shipping{{ $shipping->id }}"
                                                       id="shipping{{ $shipping->id }}"
                                                       value="{{ $shipping->id }}" {{
                                                $shipping->type === session()->get('shipping_rule')['type']
                                                    ? 'checked' : '' }}>
                                                <label class="form-check-label" for="shipping{{ $shipping->id }}">
                                                    {{ $shipping->name }}
                                                    <span>cost: {{ $settings->currency_icon .
                                                number_format($shipping->cost, 2) }}</span>
                                                </label>
                                            </div>
                                        @elseif ( $shipping->type === 1 )
                                            <div class="form-check">
                                                <input class="form-check-input shipping_method" type="radio"
                                                       data-shipping-cost="{{ $shipping->cost }}"
                                                       name="shipping{{ $shipping->id }}"
                                                       id="shipping{{ $shipping->id }}"
                                                       value="{{ $shipping->id }}" {{
                                                $shipping->type === session()->get('shipping_rule')['type']
                                                    ? 'checked' : '' }}>
                                                <label class="form-check-label" for="shipping{{ $shipping->id }}">
                                                    {{ $shipping->name }}
                                                    <span>cost: {{ $settings->currency_icon .
                                            number_format($shipping->cost, 2) }}</span>
                                                </label>
                                            </div>
                                        @endif
                                    @else
                                        @if ( $shipping->type === 2 && cartSubtotal() >= $shipping->min_cost )
                                            <div class="form-check">
                                                <input class="form-check-input shipping_method" type="radio"
                                                       data-shipping-cost="{{ $shipping->cost }}"
                                                       name="shipping{{ $shipping->id }}"
                                                       id="shipping{{ $shipping->id }}"
                                                       value="{{ $shipping->id }}"
                                                       @if ( !$firstChecked ) checked @endif>
                                                @php $firstChecked = true; @endphp
                                                <label class="form-check-label" for="shipping{{ $shipping->id }}">
                                                    {{ $shipping->name }}
                                                    <span>cost: {{ $settings->currency_icon .
                                                number_format($shipping->cost, 2) }}</span>
                                                </label>
                                            </div>
                                        @elseif ( $shipping->type === 1 )
                                            <div class="form-check">
                                                <input class="form-check-input shipping_method" type="radio"
                                                       data-shipping-cost="{{ $shipping->cost }}"
                                                       name="shipping{{ $shipping->id }}"
                                                       id="shipping{{ $shipping->id }}"
                                                       value="{{ $shipping->id }}"
                                                       @if ( !$firstChecked ) checked @endif>
                                                @php $firstChecked = true; @endphp
                                                <label class="form-check-label" for="shipping{{ $shipping->id }}">
                                                    {{ $shipping->name }}
                                                    <span>cost: {{ $settings->currency_icon .
                                            number_format($shipping->cost, 2) }}</span>
                                                </label>
                                            </div>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                            <div class="wsus__order_details_summery">
                                <p>subtotal: <span>{{ $settings->currency_icon .
                                    number_format(cartSubtotal(), 2) }}</span></p>
                                <p>shipping fee (+): <span id="shipping_fee">{{ $settings->currency_icon .
                                    number_format(shippingFee(), 2) }}</span></p>
                                <p>discount (-): <span>{{ $settings->currency_icon .
                                    number_format(couponDiscount(), 2) }}</span></p>
                                <p><b>total:</b> <span><b id="total_price" data-cart-total="{{ cartTotal() }}">
                                            {{ $settings->currency_icon . number_format(cartTotal(), 2) }}
                                        </b></span></p>
                            </div>
                            <div class="terms_area">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                           value="" id="terms_agree" checked>
                                    <label class="form-check-label" for="terms_agree">
                                        I have read and agree to the website <a href="#">terms and conditions *</a>
                                    </label>
                                </div>
                            </div>
                            <form action="" id="checkout_form">
                                <input type="hidden" name="shipping_method_id" id="shipping_method_id" value="">
                                <input type="hidden" name="shipping_address_id" id="shipping_address_id" value="">
                            </form>
                            <button id="submit_checkout_form" class="common_btn">Place Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="wsus__popup_address">
        <div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">add new address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="wsus__check_form p-3">
                            <form action="{{ route('user.checkout.address-create') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="name" value="{{ old('name') }}"
                                                   aria-label="name" placeholder="Name *">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="phone" value="{{ old('phone') }}"
                                                   aria-label="phone" placeholder="Phone *">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                   aria-label="email" placeholder="Email *">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <select class="select_2" name="country" aria-label="country">
                                                <option value="">Country *</option>
                                                @foreach ( config('settings.country_list') as $code => $name )
                                                    <option value="{{ $code }}"
                                                        {{ old('country') == $code ? 'selected' : '' }}>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="state" value="{{ old('state') }}"
                                                   aria-label="state" placeholder="Region / State *">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="city" value="{{ old('city') }}"
                                                   aria-label="city" placeholder="Town / City *">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="zip" value="{{ old('zip') }}"
                                                   aria-label="zip" placeholder="Zip *">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="wsus__check_single_form">
                                            <input type="text" name="address" value="{{ old('address') }}"
                                                   aria-label="address" placeholder="Address *">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__check_single_form">
                                            <button type="submit" class="btn btn-primary">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--============================
        CHECK OUT PAGE END
    ==============================-->
@endsection

@push( 'scripts' )
    <script>
        ($ => {
            $(() => {
                @if ( session('show_modal') )
                $('#exampleModal').modal('show');
                @endif

                const formatFloat = (float) => {
                    const parsedFloat = parseFloat(float);
                    return parsedFloat.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }

                const shippingMethod = () => {
                    const clShippingMethodChecked = $(".shipping_method:checked");
                    const idTotalPrice = $("#total_price");

                    let shippingCost = clShippingMethodChecked.data("shipping-cost") ?? 0;
                    const totalPrice = idTotalPrice.data("cart-total") ?? 0;

                    $("#shipping_method_id").val(clShippingMethodChecked.val());
                    $("#shipping_fee").text("{{ $settings->currency_icon }}"
                        + formatFloat(shippingCost));

                    idTotalPrice.text("{{ $settings->currency_icon }}"
                        + formatFloat(totalPrice + shippingCost));

                    $("body").on("click", ".shipping_method", e => {
                        const $this = $(e.currentTarget);

                        shippingCost = $this.data("shipping-cost");

                        $(".shipping_method").not($this).prop("checked", false);
                        $("#shipping_method_id").val($this.val());
                        $("#shipping_fee").text("{{ $settings->currency_icon }}"
                            + formatFloat(shippingCost));

                        idTotalPrice.text("{{ $settings->currency_icon }}"
                            + formatFloat(totalPrice + shippingCost));
                    });
                }

                const shippingAddress = () => {
                    const clShippingAddressChecked = $(".shipping_address:checked");

                    $("#shipping_address_id").val(clShippingAddressChecked.data("address-id"));

                    $("body").on("click", ".shipping_address", e => {
                        const $this = $(e.currentTarget);

                        $("#shipping_address_id").val($this.data("address-id"));
                    });
                }

                const submitCheckoutForm = () => {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $("body").on("click", "#submit_checkout_form", e => {
                        const $this = $(e.currentTarget);

                        const shippingId = $("#shipping_method_id").val();
                        const addressId = $("#shipping_address_id").val();
                        const idTermsAgree = $("#terms_agree");

                        if (shippingId === "") {
                            toastr.error("Select Shipping Method.");
                        } else if (addressId === "") {
                            toastr.error("Select Shipping Address.");
                        } else if (!idTermsAgree.prop("checked")) {
                            toastr.error("You Have to Agree to Website Terms and Conditions.");
                        } else {
                            $.ajax({
                                url: "{{ route('user.checkout.form-submit') }}",
                                method: "POST",
                                data: $("#checkout_form").serialize(),
                                beforeSend: () => {
                                    $this.html("<i class='fas fa-spinner fa-spin fa-1x'></i>");
                                },
                                success: response => {
                                    const {status, redirect_url: redirectUrl} = response;

                                    if (status === "success") {
                                        $this.html("Place Order");
                                        Swal.fire({
                                            title: 'Redirecting to Payment page',
                                            text: 'Please wait...',
                                            icon: 'success',
                                            showConfirmButton: false,
                                            timer: 2000 // 2 seconds
                                        }).then(() => {
                                            window.location.href = redirectUrl;
                                        });
                                    } else {
                                        toastr.error("Checkout Cannot Be Processed.");
                                    }
                                },
                                error: (xhr, status, error) => {
                                    console.log(error);
                                }
                            });
                        }
                    });
                }

                shippingMethod();
                shippingAddress();
                submitCheckoutForm();
            });
        })(jQuery);
    </script>
@endpush
