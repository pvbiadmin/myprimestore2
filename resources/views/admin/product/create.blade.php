@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Product</h1>
        </div>
        <div class="mb-3">
            <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Back</a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Product</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.products.store') }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           value="{{ old('name') }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="brand">Brand</label>
                                            <select name="brand" id="brand" class="form-control">
                                                <option value="">Select</option>
                                                @foreach( $brands as $brand )
                                                    <option value="{{ $brand->id }}" {{ old('brand') == $brand->id
                                                        ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <select name="category" id="category" class="form-control">
                                                <option value="">Select</option>
                                                @foreach( $categories as $category )
                                                    <option value="{{ $category->id }}" {{
                                                        old('category') == $category->id ? 'selected' : ''
                                                        }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="subcategory">Subcategory</label>
                                            <select name="subcategory" id="subcategory" class="form-control">
                                                <option value="">Select</option>
                                                @foreach( $subcategories as $subcategory )
                                                    <option value="{{ $subcategory->id }}" {{
                                                        old('subcategory') == $subcategory->id ? 'selected' : ''
                                                        }}>{{ $subcategory->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="child_category">Child-Category</label>
                                            <select name="child_category" id="child_category" class="form-control">
                                                <option value="">Select</option>
                                                @foreach( $child_categories as $child_category )
                                                    <option value="{{ $child_category->id }}" {{
                                                        old('child_category') == $child_category->id ? 'selected' : ''
                                                        }}>{{ $child_category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="product_type">Type</label>
                                            <select name="product_type" id="product_type" class="form-control">
                                                <option value="">Select</option>
                                                <option value="new_arrival" {{ old('product_type') == 'new_arrival'
                                                    ? 'selected' : '' }}>New Arrival
                                                </option>
                                                <option value="featured_product" {{
                                                    old('product_type') == 'featured_product'
                                                        ? 'selected' : '' }}>Featured
                                                </option>
                                                <option value="top_product" {{ old('product_type') == 'top_product'
                                                    ? 'selected' : '' }}>Top Product
                                                </option>
                                                <option value="best_product" {{ old('product_type') == 'best_product'
                                                    ? 'selected' : '' }}>Best Product
                                                </option>
                                                <option value="basic_pack" {{ old('product_type') == 'basic_pack'
                                                    ? 'selected' : '' }}>Basic Pack
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="">Select</option>
                                                <option value="1" {{ old('status') == 1
                                                    ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ old('status') == 0
                                                    ? 'selected' : '' }}>Inactive
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sku">SKU</label>
                                            <input type="text" name="sku" id="sku" class="form-control"
                                                   value="{{ old('sku') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="quantity">Stock Quantity</label>
                                            <input type="number" min="0" name="quantity" id="quantity"
                                                   class="form-control" value="{{ old('quantity') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="price">Standard Price</label>
                                            <input type="text" name="price" id="price" class="form-control"
                                                   value="{{ old('price') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="offer_price">Offer Price</label>
                                            <input type="text" name="offer_price" id="offer_price"
                                                   class="form-control" value="{{ old('offer_price') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="offer_start_date">Offer Start Date</label>
                                            <input type="text" name="offer_start_date" id="offer_start_date"
                                                   class="form-control datepicker"
                                                   value="{{ old('offer_start_date') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="offer_end_date">Offer End Date</label>
                                            <input type="text" name="offer_end_date" id="offer_end_date"
                                                   class="form-control datepicker"
                                                   value="{{ old('offer_end_date') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="video_link">Video Link</label>
                                    <input type="text" name="video_link" id="video_link" class="form-control"
                                           value="{{ old('video_link') }}">
                                </div>
                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea name="short_description" class="form-control"
                                              id="short_description">{{ old('short_description') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="long_description">Long Description</label>
                                    <textarea name="long_description" class="form-control summernote"
                                              id="long_description">{{ old('long_description') }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="seo_title">SEO Title</label>
                                    <input type="text" name="seo_title" id="seo_title" class="form-control"
                                           value="{{ old('seo_title') }}">
                                </div>
                                <div class="form-group">
                                    <label for="seo_description">SEO Description</label>
                                    <textarea name="seo_description" class="form-control"
                                              id="seo_description">{{ old('seo_description') }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push( 'scripts' )
    <script>
        ($ => {
            $(() => {
                const getCatFam = (fam = "sub") => {
                    let target = "#category";
                    let famUrl = "{{ route('admin.product.get-subcategories') }}";
                    let idCatFam = $("#subcategory");

                    if (fam === 'child') {
                        target = "#subcategory";
                        famUrl = "{{ route('admin.product.get-child-categories') }}";
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
