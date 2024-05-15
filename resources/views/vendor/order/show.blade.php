@php
    $order = $order ?? null;
    $address = json_decode($order->order_address);
    $shipping = json_decode($order->shipping_method);
    $total = 0;
@endphp

@extends( 'vendor.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Order Details
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
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="fas fa-box-open"></i> Order Details</h3>
                        <section>
                            <div class="wsus__invoice_area invoice-print">
                                <div class="wsus__invoice_header">
                                    <div class="wsus__invoice_content">
                                        <div class="row">
                                            <div class="col-xl-4 col-md-4 mb-5 mb-md-0">
                                                <div class="wsus__invoice_single">
                                                    <h5>Invoice To</h5>
                                                    <h6>{{ $address->name }}</h6>
                                                    <p>{{ $address->address }}</p>
                                                    <p>{{ $order->user->phone }}</p>
                                                    <p>{{ $address->city }}, {{ $address->state }}</p>
                                                    <p>{{ config('settings.country_list')[
                                                        $address->country] }} {{ $address->zip }}</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4 mb-5 mb-md-0">
                                                <div class="wsus__invoice_single text-md-center">
                                                    <h5>Shipped To</h5>
                                                    <h6>{{ $address->name }}</h6>
                                                    <p>{{ $address->address }}</p>
                                                    <p>{{ $order->user->phone }}</p>
                                                    <p>{{ $address->city }}, {{ $address->state }}</p>
                                                    <p>{{ config('settings.country_list')[
                                                        $address->country] }} {{ $address->zip }}</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4">
                                                <div class="wsus__invoice_single text-md-end">
                                                    <h5>Order ID: {{ $order->invoice_id }}</h5>
                                                    <h6>Order Status: {{ config('order_status.admin')[
                                                    $order->order_status]['status'] }}</h6>
                                                    <p>Payment Method: {{ ucwords($order->payment_method) }}</p>
                                                    <p>Payment Status: {{ $order->payment_status === 0 ?
                                                        'Pending' : 'Completed' }}</p>
                                                    <p>Transaction ID: {{ @$order->transaction->transaction_id }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wsus__invoice_description">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th class="name">
                                                        product
                                                    </th>
                                                    <th class="amount">
                                                        vendor
                                                    </th>
                                                    <th class="amount">
                                                        amount
                                                    </th>
                                                    <th class="quentity">
                                                        quantity
                                                    </th>
                                                    <th class="total">
                                                        total
                                                    </th>
                                                </tr>
                                                @foreach( $order->orderProducts as $item )
                                                    @if ( $item->vendor_id === Auth::user()->vendor->id )
                                                        @php
                                                            $item = $item ?? null;
                                                            $total = $total ?? 0;

                                                            $variants = json_decode($item->product_variant);
                                                            $total += $item->unit_price * $item->quantity;
                                                        @endphp
                                                        <tr>
                                                            <td class="name">
                                                                <p>{{ $item->product_name }}</p>
                                                                @foreach( $variants as $variant => $type )
                                                                    <span>{{ $variant }}: {{ $type->name }} ({{
                                                                        $settings->currency_icon .
                                                                            number_format($type->price, 2) }})</span>
                                                                @endforeach
                                                            </td>
                                                            <td class="amount">
                                                                {{ $item->vendor->shop_name }}
                                                            </td>
                                                            <td class="amount">
                                                                {{ $settings->currency_icon .
                                                                    number_format($item->unit_price, 2) }}
                                                            </td>
                                                            <td class="quentity">
                                                                {{ $item->quantity }}
                                                            </td>
                                                            <td class="total">
                                                                {{ $settings->currency_icon . number_format(
                                                                    $item->unit_price * $item->quantity, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="wsus__invoice_footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if ( in_array($order->order_status, [
                                                'pending',
                                                'processed_and_ready_to_ship'
                                            ]) )
                                                <div class="row g-3 align-items-center">
                                                    <div class="col-auto">
                                                        <label for="order_status">Order Status:</label>
                                                    </div>
                                                    <div class="col-auto">
                                                        <select name="order_status" id="order_status"
                                                                data-order-id="{{ $order->id }}" class="form-control">
                                                            @foreach ( config('order_status.vendor') as $key => $arr )
                                                                <option value="{{ $key }}" {{
                                                        $order->order_status === $key ? 'selected' : ''
                                                        }}>{{ $arr['status'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            @else
                                                <p><span>Order Status:</span> {{ config('order_status.admin')[
                                                    $order->order_status]['status'] }}</p>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <div class="float-end">
                                                <p><span>Total Amount:</span> {{ $settings->currency_icon .
                                        number_format($total, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid mt-3 d-md-flex justify-content-md-end">
                                <button class="btn btn-warning print-invoice-btn" type="button">
                                    <i class="fas fa-print"></i> Print
                                </button>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
      DASHBOARD START
    ==============================-->
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
        };

        const orderStateChange = () => {
            ($ => {
                $(() => {
                    $("body").on("change", "#order_status", e => {
                        const $this = $(e.currentTarget);
                        const status = $this.val();
                        const orderId = $this.data('order-id');

                        $.ajax({
                            url: "{{ route('vendor.order.change-order-status') }}",
                            method: "GET",
                            data: {
                                orderId: orderId,
                                status: status
                            },
                            success: response => {
                                if (response.status === 'success') {
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
        };

        orderStateChange('order_status');
        printInvoice();
    </script>
@endpush
