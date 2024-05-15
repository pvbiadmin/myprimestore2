@extends( 'admin.layouts.master' )

@section( 'content' )
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Vendor Request</h1>
        </div>

        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td><b>Withdraw Method</b></td>
                                    <td>{{ $request->method }}</td>
                                </tr>
                                <tr>
                                    <td><b>Withdraw Charge</b></td>
                                    <td>{{ $settings->currency_icon }}{{ number_format(
                                        ($request->withdraw_charge / $request->total_amount) * 100, 2) }}</td>
                                </tr>

                                <tr>
                                    <td><b>Withdraw Charge Rate</b></td>
                                    <td>{{ $request->withdraw_charge }}%</td>
                                </tr>
                                <tr>
                                    <td><b>Total Amount</b></td>
                                    <td>{{ $settings->currency_icon }}{{
                                        number_format($request->total_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Withdraw Amount</b></td>
                                    <td>{{ $settings->currency_icon }}{{
                                        number_format($request->withdraw_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><b>Status</b></td>
                                    <td>
                                        @if ( $request->status == 'pending' )
                                            <i class="badge badge-warning">Pending</i>
                                        @elseif ( $request->status == 'paid' )
                                            <i class="badge badge-success">Paid</i>
                                        @else
                                            <i class="badge badge-danger">Declined</i>
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
    </section>

    @if ( $request->status !== 'paid' )
        <section class="section">
            <div class="section-body">
                <div class="invoice">
                    <div class="invoice-print">
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <form action="{{ route('admin.withdraw.update', $request->id) }}" method="POST">
                                    @csrf
                                    @method( 'PUT' )
                                    <div class="form-group">
                                        <label for="">Status</label>
                                        <select name="status" class="form-control" id="">
                                            <option @selected( $request->status === 'pending' ) value="pending">
                                                Pending
                                            </option>
                                            <option @selected( $request->status === 'paid' ) value="paid">Paid</option>
                                            <option @selected( $request->status === 'declined' ) value="declined">
                                                Declined
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    @endif

@endsection

