@extends( 'vendor.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Product: Variant Option - Create
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
                        <div class="mb-3">
                            <a href="{{ route('vendor.products-variant-option.index', [
                                'productId' => $product->id,
                                'variantId' => $variant->id
                            ]) }}" class="btn btn-warning"><i class="fas fa-long-arrow-left"></i> Back</a>
                        </div>
                        <h3><i class="fas fa-list-alt"></i> Add Variant Option</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form method="post" action="{{ route('vendor.products-variant-option.store') }}">
                                    @csrf
                                    <div class="form-group wsus__input">
                                        <label for="variant_name">Variant Name</label>
                                        <input type="text" name="variant_name" id="variant_name" class="form-control"
                                               value="{{ $variant->name }}" readonly>
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="variant_id" value="{{ $variant->id }}">
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="name">Option Name</label>
                                        <input type="text" name="name" id="name"
                                               class="form-control" value="{{ old('name') }}">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group wsus__input">
                                                <label for="price">
                                                    Price <code>(Set to 0 to make it free)</code></label>
                                                <input type="text" name="price" id="price"
                                                       class="form-control" value="{{ old('price') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group wsus__input">
                                                <label for="is_default">Is Default</label>
                                                <select name="is_default" id="is_default" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="1" {{ old('is_default') == 1
                                                        ? 'selected' : '' }}>Yes</option>
                                                    <option value="0" {{ old('is_default') == 0
                                                        ? 'selected' : '' }}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group wsus__input">
                                                <label for="status">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="1" {{ old('status') == 1
                                                        ? 'selected' : '' }}>Active</option>
                                                    <option value="0" {{ old('status') == 0
                                                        ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </form>
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

