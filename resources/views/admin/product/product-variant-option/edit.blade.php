@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Product Variant Option</h1>
        </div>
        <div class="mb-3">
            <a href="{{ route('admin.products-variant-option.index', [
                'productId' => $product_id,
                'variantId' => $variant_id
            ]) }}" class="btn btn-primary">Back</a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Variant Option</h4>
                        </div>
                        <div class="card-body">
                            <form method="post"
                                  action="{{ route('admin.products-variant-option.update', $variant_option->id) }}">
                                @csrf
                                @method( 'PUT' )
                                <div class="form-group">
                                    <label for="variant_name">Variant Name</label>
                                    <input type="text" name="variant_name" id="variant_name" class="form-control"
                                           value="{{ $variant_option->productVariant->name }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name">Option Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           value="{{ $variant_option->name }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="price">Price <code>(Added to Product Price)</code></label>
                                            <input type="text" name="price" id="price" class="form-control"
                                                   value="{{ $variant_option->price }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="is_default">Is Default</label>
                                            <select name="is_default" id="is_default" class="form-control">
                                                <option value="">Select</option>
                                                <option value="1" {{
                                                    $variant_option->is_default == 1 ? 'selected' : '' }}>Yes
                                                </option>
                                                <option value="0" {{
                                                    $variant_option->is_default == 0 ? 'selected' : '' }}>No
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1" {{ $variant_option->status == 1 ? 'selected' : '' }}>
                                                    Active
                                                </option>
                                                <option value="0" {{ $variant_option->status == 0 ? 'selected' : '' }}>
                                                    Inactive
                                                </option>
                                            </select>
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
