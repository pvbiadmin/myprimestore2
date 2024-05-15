@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Product Variants</h1>
        </div>
        <div class="mb-3">
            <a href="{{ route('admin.products-variant.index', [
                'product' => $product->id
            ]) }}" class="btn btn-primary">Back</a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Variant</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.products-variant.update', $variant->id) }}">
                                @csrf
                                @method( 'PUT' )
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           value="{{ $variant->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{
                                            $variant->status == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{
                                            $variant->status == 0 ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
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
