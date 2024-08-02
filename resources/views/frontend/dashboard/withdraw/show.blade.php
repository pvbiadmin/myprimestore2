@extends( 'frontend.dashboard.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Create Withdraw Request
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
                        <h3><i class="far fa-user"></i>Withdraw Request</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="row">
                                <div class="wsus__dash_pro_area col-md-7">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td><b>Withdraw Method</b></td>
                                            <td>{{ $request->method }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Withdraw Charge</b></td>
                                            <td>{{ $settings->currency_icon . number_format(
                                                ($request->withdraw_charge / $request->total_amount) * 100, 2) }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <td><b>Withdraw Charge Rate</b></td>
                                            <td>{{ $request->withdraw_charge }}%</td>
                                        </tr>
                                        <tr>
                                            <td><b>Total Amount</b></td>
                                            <td>{{ $settings->currency_icon .
                                                number_format($request->total_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Withdraw Amount</b></td>
                                            <td>{{ $settings->currency_icon .
                                                number_format($request->withdraw_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Status</b></td>
                                            <td>
                                                @if ( $request->status === 'pending' )
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif ( $request->status === 'paid' )
                                                    <span class="badge bg-success">Paid</span>
                                                @else
                                                    <span class="badge bg-danger">Declined</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Account Information</b></td>
                                            <td>{!! $request->account_info !!}</td>
                                        </tr>
                                        </tbody>
                                    </table>
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
