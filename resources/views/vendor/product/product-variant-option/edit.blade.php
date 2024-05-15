@extends( 'vendor.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Product: Variant Option - Edit
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
                                'productId' => $product_id,
                                'variantId' => $variant_id
                            ]) }}" class="btn btn-warning"><i class="fas fa-long-arrow-left"></i> Back</a>
                        </div>
                        <h3><i class="fas fa-list-alt"></i> Update Variant Option</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form method="post" action="{{
                                    route('vendor.products-variant-option.update', $variant_option->id) }}">
                                    @csrf
                                    @method( 'PUT' )
                                    <div class="form-group wsus__input">
                                        <label for="variant_name">Variant Name</label>
                                        <input type="text" name="variant_name" id="variant_name" class="form-control"
                                               value="{{ $variant_option->productVariant->name }}" readonly>
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="name">Option Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ $variant_option->name }}">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group wsus__input">
                                                <label for="price">
                                                    Price <code>(Set to 0 to make it free)</code></label>
                                                <input type="text" name="price" id="price" class="form-control"
                                                       value="{{ $variant_option->price }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group wsus__input">
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
                                            <div class="form-group wsus__input">
                                                <label for="status">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="1" {{
                                                        $variant_option->status == 1 ? 'selected' : '' }}>Active
                                                    </option>
                                                    <option value="0" {{
                                                        $variant_option->status == 0 ? 'selected' : '' }}>Inactive
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
        </div>
    </section>
    <!--=============================
      DASHBOARD START
    ==============================-->
@endsection

