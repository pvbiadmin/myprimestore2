@extends( 'vendor.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Product - Edit
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
                    <a href="{{ route('vendor.products.index') }}" class="btn btn-warning mb-4">
                        <i class="fas fa-long-arrow-left"></i> Back</a>
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="fas fa-edit"></i> Update Product</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form method="post" action="{{ route('vendor.products.update', $product->id) }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method( 'PUT' )
                                    <div class="col-md-2 mb-4">
                                        <div class="wsus__dash_pro_img">
                                            <img src="{{ asset($product->thumb_image) }}"
                                                 alt="{{ $product->name }}" class="img-fluid w-100">
                                            <input type="file" name="image">
                                        </div>
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ $product->name }}">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group wsus__input">
                                                <label for="brand">Brand</label>
                                                <select name="brand" id="brand" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach ( $brands as $brand )
                                                        <option value="{{ $brand->id }}"
                                                            {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
                                                            {{ $brand->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group wsus__input">
                                                <label for="category">Category</label>
                                                <select name="category" id="category" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach ( $categories as $category )
                                                        <option value="{{ $category->id }}" {{
                                                            $category->id == $product->category_id ? 'selected' : ''
                                                            }}>{{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group wsus__input">
                                                <label for="subcategory">Subcategory</label>
                                                <select name="subcategory" id="subcategory" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach ( $subcategories as $subcategory )
                                                        <option value="{{$subcategory->id}}" {{
                                                            $subcategory->id == $product->subcategory_id
                                                                ? 'selected' : '' }}>{{ $subcategory->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group wsus__input">
                                                <label for="child_category">Child-Category</label>
                                                <select name="child_category" id="child_category" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach ( $child_categories as $child_category )
                                                        <option value="{{ $child_category->id }}" {{
                                                            $child_category->id == $product->child_category_id
                                                                ? 'selected' : '' }}>{{ $child_category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        {{--<div class="col-md-3">
                                            <div class="form-group wsus__input">
                                                <label for="product_type">Type</label>
                                                <select name="product_type" id="product_type" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="new_arrival" {{
                                                        $product->product_type == 'new_arrival' ? 'selected' : '' }}>
                                                        New Arrival
                                                    </option>
                                                    <option value="featured_product" {{
                                                        $product->product_type == 'featured_product'
                                                            ? 'selected' : '' }}>Featured
                                                    </option>
                                                    <option value="top_product" {{
                                                        $product->product_type == 'top_product'
                                                            ? 'selected' : '' }}>Top Product
                                                    </option>
                                                    <option value="best_product" {{
                                                        $product->product_type == 'best_product'
                                                            ? 'selected' : '' }}>Best Product
                                                    </option>
                                                </select>
                                            </div>
                                        </div>--}}
                                        <div class="col-md-3">
                                            <div class="form-group wsus__input">
                                                <label for="status">Status</label>
                                                <select name="status" id="status" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>
                                                        Active
                                                    </option>
                                                    <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>
                                                        Inactive
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group wsus__input">
                                                <label for="sku">SKU</label>
                                                <input type="text" name="sku" id="sku" class="form-control"
                                                       value="{{ $product->sku }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group wsus__input">
                                                <label for="quantity">Stock Quantity</label>
                                                <input type="number" min="0" name="quantity" id="quantity"
                                                       class="form-control" value="{{ $product->quantity }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group wsus__input">
                                                <label for="price">Standard Price</label>
                                                <input type="text" name="price" id="price" class="form-control"
                                                       value="{{ $product->price }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group wsus__input">
                                                <label for="offer_price">Offer Price</label>
                                                <input type="text" name="offer_price" id="offer_price"
                                                       class="form-control" value="{{ $product->offer_price }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group wsus__input">
                                                <label for="offer_start_date">Offer Start Date</label>
                                                <input type="text" name="offer_start_date" id="offer_start_date"
                                                       class="form-control datepicker"
                                                       value="{{ $product->offer_start_date }}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group wsus__input">
                                                <label for="offer_end_date">Offer End Date</label>
                                                <input type="text" name="offer_end_date" id="offer_end_date"
                                                       class="form-control datepicker"
                                                       value="{{ $product->offer_end_date }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="video_link">Video Link</label>
                                        <input type="text" name="video_link" id="video_link" class="form-control"
                                               value="{{ $product->video_link }}">
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="short_description">Short Description</label>
                                        <textarea name="short_description" class="form-control"
                                                  id="short_description">{!! $product->short_description !!}</textarea>
                                    </div>
                                    <div class="form-group wsus__input mb-3">
                                        <label for="long_description">Long Description</label>
                                        <textarea name="long_description" class="form-control summernote"
                                                  id="long_description">{!! $product->long_description !!}</textarea>
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="seo_title">SEO Title</label>
                                        <input type="text" name="seo_title" id="seo_title" class="form-control"
                                               value="{{ $product->seo_title }}">
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="seo_description">SEO Description</label>
                                        <textarea name="seo_description" class="form-control"
                                                  id="seo_description">{!! $product->seo_description !!}</textarea>
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

@push( 'scripts' )
    <script>
        ($ => {
            $(() => {
                const getCatFam = (fam = "sub") => {
                    let target = "#category";
                    let famUrl = "{{ route('vendor.product.get-subcategories') }}";
                    let idCatFam = $("#subcategory");

                    if (fam === 'child') {
                        target = "#subcategory";
                        famUrl = "{{ route('vendor.product.get-child-categories') }}";
                        idCatFam = $("#child_category");
                    }

                    $("body").on("change", target, e => {
                        const $this = $(e.currentTarget);
                        const famId = $this.val();

                        $.ajax({
                            method: "GET",
                            url: famUrl,
                            data: {
                                catFamId: famId
                            },
                            success: res => {
                                if (fam !== 'child') {
                                    $("#child_category").html('<option value="">Select</option>');
                                }

                                idCatFam.html('<option value="">Select</option>');
                                $.each(res, (i, item) => {
                                    idCatFam.append(`<option value="${item.id}">${item.name}</option>`);
                                });
                            },
                            error: (xhr, status, error) => {
                                console.log(error);
                            }
                        });
                    });
                };

                getCatFam();
                getCatFam("child");
            });
        })(jQuery);
    </script>
@endpush
