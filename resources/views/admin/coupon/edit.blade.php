@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Coupon</h1>
        </div>
        <div class="mb-3">
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary">Back</a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Coupon</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.coupons.update', $coupon->id) }}">
                                @csrf
                                @method( 'PUT' )
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name"
                                                   class="form-control" value="{{ $coupon->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" {{ $coupon->status == 1 ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="0" {{ $coupon->status == 0 ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code">Code</label>
                                            <input type="text" name="code" id="code" class="form-control"
                                                   value="{{ $coupon->code }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" min="0" name="quantity" id="quantity"
                                                   class="form-control" value="{{ $coupon->quantity }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="max_use">Max. Use / Person</label>
                                            <input type="number" min="0" name="max_use" id="max_use"
                                                   class="form-control" value="{{ $coupon->max_use }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="discount">Discount Value</label>
                                            <input type=number step=0.01 min="0" name="discount" id="discount"
                                                   class="form-control" value="{{ $coupon->discount }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="discount_type">Discount Type</label>
                                            <select name="discount_type" id="discount_type" class="form-control">
                                                <option value="1" {{
                                                    $coupon->discount_type == 1 ? 'selected' : '' }}>
                                                    Percent (%)
                                                </option>
                                                <option value="2" {{ $coupon->discount_type == 2 ? 'selected' : '' }}>
                                                    Amount ({{ $settings->currency_icon }})
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="start_date">Start Date</label>
                                            <input type="text" name="start_date" id="start_date"
                                                   class="form-control datepicker" value="{{ $coupon->start_date }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="end_date">End Date</label>
                                            <input type="text" name="end_date" id="end_date"
                                                   class="form-control datepicker" value="{{ $coupon->end_date }}">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
