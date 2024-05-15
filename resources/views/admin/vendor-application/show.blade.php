@extends( 'admin.layouts.master' )

@section( 'content' )
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Vendor Application</h1>
        </div>

        <div class="section-body">
            <div class="invoice">
                <div class="invoice-print">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-md">
                                    <tr>
                                        <td>User Name:</td>
                                        <td>{{ $vendor->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>User Email:</td>
                                        <td>{{ $vendor->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Shop Name:</td>
                                        <td>{{ $vendor->shop_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Shop Email:</td>
                                        <td>{{ $vendor->email }}</td>

                                    </tr>
                                    <tr>
                                        <td>Shop Phone:</td>
                                        <td>{{ $vendor->phone }}</td>


                                    </tr>
                                    <tr>
                                        <td>Shop Address:</td>
                                        <td>{{ $vendor->address }}</td>

                                    </tr>
                                    <tr>
                                        <td>Description:</td>
                                        <td>{{ $vendor->description }}</td>
                                    </tr>


                                </table>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-8">
                                    <div class="col-md-4">
                                        <form action="{{
                                            route('admin.vendor-applications.change-status', $vendor->id)
                                            }}" method="POST">
                                            @csrf
                                            @method( 'PUT' )
                                            <div class="form-group">
                                                <label for="status">Action</label>
                                                <select name="status" id="status"
                                                        class="form-control" aria-label="status">
                                                    <option {{ $vendor->status == 0 ? 'selected': ''}} value="0">
                                                        Deny
                                                    </option>
                                                    <option {{ $vendor->status == 1 ? 'selected': '' }} value="1">
                                                        Approve
                                                    </option>
                                                </select>
                                            </div>
                                            <button class="btn btn-primary">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
