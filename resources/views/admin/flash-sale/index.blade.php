@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Manage Flash Sale</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Admin</a></div>
                <div class="breadcrumb-item"><a href="#">Manage Flash Sale</a></div>
                <div class="breadcrumb-item">All Flash Sale Products</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Sale End Date</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.flash-sale.update') }}">
                                @csrf
                                @method( 'PUT' )
                                <div class="form-group">
                                    <label for="end_date">Sale End Date</label>
                                    <input type="text" name="end_date" id="end_date"
                                           class="form-control datepicker" value="{{ @$flash_sale->end_date }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add Flash Sale Products</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.flash-sale.add-product') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="product">Add Product</label>
                                    <select name="product" id="product" class="form-control select2">
                                        <option value="">Select</option>
                                        @foreach ( $products as $product )
                                            <option value="{{ $product->id }}" {{ old('product') == $product->id
                                                ? 'selected' : '' }}>{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="show_at_home">Show at Home</label>
                                            <select name="show_at_home" id="show_at_home" class="form-control select2">
                                                <option value="">Select</option>
                                                <option value="1" {{ old('show_at_home') == 1
                                                    ? 'selected' : '' }}>Yes</option>
                                                <option value="0" {{ old('show_at_home') == 0
                                                    ? 'selected' : '' }}>No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control select2">
                                                <option value="">Select</option>
                                                <option value="1" {{ old('status') == 1
                                                    ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ old('status') == 0
                                                    ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Flash Sale Products</h4>
                        </div>
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push( 'scripts' )
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        const flashSaleToggle = (cl_target, url_route) => {
            ($ => {
                $(() => {
                    $("body").on("click", cl_target, e => {
                        const $this = $(e.currentTarget);
                        const isChecked = $this.is(':checked');
                        const idToggle = $this.data('id');

                        $.ajax({
                            url: url_route,
                            method: "PUT",
                            data: {
                                isChecked: isChecked,
                                idToggle: idToggle
                            },
                            success: res => {
                                toastr.success(res.message);
                            },
                            error: (xhr, status, error) => {
                                console.log(error);
                            }
                        });
                    });
                });
            })(jQuery);
        }

        flashSaleToggle(".change-status", "{{ route('admin.flash-sale.change-status' )}}");
        flashSaleToggle(".change-show-at-home", "{{ route('admin.flash-sale.change-show-at-home') }}");
    </script>
@endpush
