@php
    $order = $order ?? null;

    $address = json_decode($order->order_address);
    $shipping = json_decode($order->shipping_method);
    $coupon = $order->coupon != 'null' ? json_decode($order->coupon) : '';

    $payment_icon = match ($order->payment_method) {
        'paypal' => '<img src="' . asset('backend/assets/img/paypal.png') . '" alt="paypal">',
        'bank' => '<img src="' . asset('backend/assets/img/visa.png') . '" alt="visa">' .
                '<img src="' . asset('backend/assets/img/mastercard.png') . '" alt="mastercard">' .
                '<img src="' . asset('backend/assets/img/jcb.png') . '" alt="jcb">',
        default => ''
    };
@endphp

@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Orders</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Admin</a></div>
                <div class="breadcrumb-item"><a href="#">Orders</a></div>
                <div class="breadcrumb-item">Order Details</div>
            </div>
        </div>

        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="invoice-title">
                                <h2>Invoice</h2>
                                <div class="invoice-number">Order #{{ $order->invoice_id }}</div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Billed To:</strong><br>
                                        {{ $address->name }}<br>
                                        {{ $address->address }}<br>
                                        {{ $address->city }}, {{ $address->state }}<br>
                                        {{ config('settings.country_list')[$address->country] }} {{ $address->zip }}
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Shipped To:</strong><br>
                                        {{ $address->name }}<br>
                                        {{ $address->address }}<br>
                                        {{ $address->city }}, {{ $address->state }}<br>
                                        {{ config('settings.country_list')[$address->country] }} {{ $address->zip }}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address>
                                        <strong>Shipping Method:</strong><br>
                                        {{ $shipping->name }} ({{
                                            $settings->currency_icon . number_format($shipping->cost, 2) }})
                                    </address>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <address>
                                        <strong>Order Date:</strong><br>
                                        {{ date('F d, Y', strtotime($order->created_at)) }}<br><br>
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="section-title">Order Summary</div>
                            <p class="section-lead">All items here cannot be deleted.</p>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <th data-width="40">#</th>
                                        <th>Item</th>
                                        <th class="text-center">Variant</th>
                                        <th class="text-center">Vendor</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Totals</th>
                                    </tr>
                                    @foreach( $order->orderProducts as $item )
                                        @php
                                            $variants = isset($item) ? json_decode($item->product_variant) : '';
                                        @endphp
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            @if ( isset($item->product->slug) )
                                                <td><a href="{{ route('product-detail', $item->product->slug) }}"
                                                       target="_blank">{{ $item->product_name }}</a></td>
                                            @else
                                                <td>{{ $item->product_name }}</td>
                                            @endif
                                            <td class="text-center">
                                                @if ( !is_null($variants) )
                                                    @foreach( $variants as $key => $val )
                                                        {{ ucwords($key) }}: {{ ucwords($val->name) }} ({{
                                                        $settings->currency_icon . number_format($val->price, 2) }})<br>
                                                    @endforeach
                                                @else
                                                    <p>---</p>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $item->vendor->shop_name }}</td>
                                            <td class="text-center">{{ $settings->currency_icon .
                                                number_format($item->unit_price, 2) }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-right">{{ $settings->currency_icon .
                                                number_format(($item->unit_price * $item->quantity)
                                                + $item->product_variant_price_total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">
                                    <div class="section-title">Payment Method</div>
                                    <p class="section-lead">{{ ucwords($order->payment_method) }}<br> @if(
                                        $order->transaction && isset($order->transaction->transaction_id)
                                        )({{ 'Transaction ID: ' . $order->transaction->transaction_id }})@endif</p>
                                    @if( $payment_icon )<p class="section-lead">{!! $payment_icon !!}</p>@endif
                                    <div class="row" style="margin-top: 30px">
                                        <div class="form-group col-md-6">
                                            <label id="label-payment-status" for="payment_status">Payment Status{{
                                                $order->payment_status === 1 ? ': Completed' : '' }}</label>
                                            @if ( $order->payment_status !== 1 )
                                                <select name="payment_status" id="payment_status"
                                                        data-order-id="{{ $order->id }}" class="form-control">
                                                    <option
                                                        value="0" {{ $order->payment_status === 0 ? 'selected' : '' }}>
                                                        Pending
                                                    </option>
                                                    <option
                                                        value="1" {{ $order->payment_status === 1 ? 'selected' : '' }}>
                                                        Completed
                                                    </option>
                                                </select>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label id="label-order-status" for="order_status">Order Status{{
                                                $order->order_status === 'completed' ? ': Completed' : '' }}</label>
                                            @if ( $order->order_status !== 'completed' )
                                                <select name="order_status" id="order_status"
                                                        data-order-id="{{ $order->id }}" class="form-control">
                                                    @foreach( config('order_status.admin') as $key => $arr )
                                                        <option value="{{ $key }}" {{
                                                        $order->order_status === $key ? 'selected' : ''
                                                        }}>{{ $arr['status'] }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-right">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Subtotal</div>
                                        <div class="invoice-detail-value">{{ $settings->currency_icon .
                                            number_format($order->subtotal, 2) }}</div>
                                    </div>
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Shipping</div>
                                        <div class="invoice-detail-value">{{ $settings->currency_icon .
                                            number_format($shipping->cost, 2) }}</div>
                                    </div>
                                    @if ( $coupon )
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Coupon</div>
                                            <div class="invoice-detail-value">{{ $settings->currency_icon .
                                            number_format($coupon->discount, 2) }}</div>
                                        </div>
                                    @endif
                                    <hr class="mt-2 mb-2">
                                    <div class="invoice-detail-item">
                                        <div class="invoice-detail-name">Total</div>
                                        <div class="invoice-detail-value invoice-detail-value-lg">{{
                                            $settings->currency_icon .
                                            number_format($order->amount, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="text-md-right">
                    {{--<div class="float-lg-left mb-lg-0 mb-3">
                        <button class="btn btn-primary btn-icon icon-left">
                            <i class="fas fa-credit-card"></i> Process Payment
                        </button>
                        <button class="btn btn-danger btn-icon icon-left">
                            <i class="fas fa-times"></i> Cancel
                        </button>
                    </div>--}}
                    <button class="btn btn-warning btn-icon icon-left print-invoice-btn">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@push( 'scripts' )
    <script>
        const printInvoice = () => {
            ($ => {
                $(() => {
                    const body = $("body");

                    body.on("click", ".print-invoice-btn", () => {
                        const printBody = $(".invoice-print");
                        let rawContent = body.html();

                        body.html(printBody.html());

                        window.print();

                        body.html(rawContent);
                    });
                });
            })(jQuery);
        }

        const stateChange = (target) => {
            ($ => {
                $(() => {
                    let url = "{{ route('admin.order.change-order-status') }}";
                    let idTarget = "#order_status";
                    let labelStatus = "#label-order-status";

                    if (target === 'payment_status') {
                        url = "{{ route('admin.order.change-payment-status') }}";
                        idTarget = "#payment_status";
                        labelStatus = "#label-payment-status";
                    }

                    $(idTarget).removeClass('d-none');

                    $("body").on("change", idTarget, e => {
                        const $this = $(e.currentTarget);
                        const status = $this.val();
                        const orderId = $this.data('order-id');

                        $.ajax({
                            url: url,
                            method: "GET",
                            data: {
                                orderId: orderId,
                                status: status
                            },
                            success: response => {
                                const {
                                    status,
                                    order_status: orderStatus = null,
                                    payment_status: paymentStatus = null
                                } = response;

                                if ( paymentStatus !== null && paymentStatus.toString() === "1") {
                                    $(labelStatus).text("Payment Status: Completed");
                                    $(idTarget).addClass('d-none');
                                }

                                if ( orderStatus !== null && orderStatus.toString() === 'completed') {
                                    $(labelStatus).text("Order Status: Completed");
                                    $(idTarget).addClass('d-none');
                                }

                                if (status === 'success') {
                                    toastr.success(response.message);
                                }
                            },
                            error: (xhr, status, error) => {
                                console.log(error);
                            }
                        });
                    });
                });
            })(jQuery);
        }

        stateChange('order_status');
        stateChange('payment_status');
        printInvoice();
    </script>
@endpush
