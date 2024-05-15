@extends( 'vendor.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Order
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
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="fas fa-box-open"></i> Orders</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                {{ $dataTable->table() }}
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

@push( 'scripts' )
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
@php
    $order = $order ?? null;
    $address = json_decode($order->order_address);
    $shipping = json_decode($order->shipping_method);
    $coupon = $order->coupon ? json_decode($order->coupon) : null;
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

            @include( 'frontend.dashboard.layouts.sidebar' )

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
                                                    <p>{{ config('settings.country_list')[$address->country]
                                                        }} {{ $address->zip }}</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4 mb-5 mb-md-0">
                                                <div class="wsus__invoice_single text-md-center">
                                                    <h5>Shipped To</h5>
                                                    <h6>{{ $address->name }}</h6>
                                                    <p>{{ $address->address }}</p>
                                                    <p>{{ $order->user->phone }}</p>
                                                    <p>{{ $address->city }}, {{ $address->state }}</p>
                                                    <p>{{ config('settings.country_list')[$address->country]
                                                        }} {{ $address->zip }}</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-4 col-md-4">
                                                <div class="wsus__invoice_single text-md-end">
                                                    <h5>Order ID: {{ $order->invoice_id }}</h5>
                                                    <h6>Order Status: {{ config('order_status.admin')[
                                                        $order->order_status]['status'] }}</h6>
                                                    <p>Payment Method: {{ ucwords($order->payment_method) }}</p>
                                                    <p>Payment Status: {{ $order->payment_status === 0
                                                        ? 'Pending' : 'Completed' }}</p>
                                                    <p>Transaction ID: {{ $order->transaction->transaction_id }}</p>
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
                                                    @php
                                                        $item = $item ?? null;
                                                        $variants = json_decode($item->product_variant);
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
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="wsus__invoice_footer">
                                    <div class="row">
                                        <div class="float-end">
                                            <p><span>Subtotal:</span> {{ $settings->currency_icon .
                                                    number_format($order->subtotal, 2) }}</p>
                                            <p><span>Shipping Fee:</span> {{ $settings->currency_icon .
                                                    number_format($shipping->cost, 2) }}</p>
                                            @if ( $coupon !== null )
                                                <p><span>Coupon:</span> {{ $settings->currency_icon .
                                                    number_format($coupon->discount, 2) }}</p>
                                            @endif
                                            <p><span>Total:</span> {{ $settings->currency_icon .
                                                    number_format($order->amount, 2) }}</p>
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

        printInvoice();
    </script>
@endpush
