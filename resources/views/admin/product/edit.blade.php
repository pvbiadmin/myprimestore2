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
                            <h4>Update Product</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.products.update', $product->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method( 'PUT' )
                                <div class="form-group">
                                    <img src="{{ asset($product->thumb_image) }}"
                                         width="100" alt="{{ $product->name }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="points">Points</label>
                                            <input type="number" step="0.01" name="points" class="form-control"
                                                   id="points" value="{{ old('points') ?? $product->points }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           value="{{ old('name') ?? $product->name }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="brand">Brand</label>
                                            <select name="brand" id="brand" class="form-control">
                                                <option value="">Select</option>
                                                @foreach( $brands as $brand )
                                                    <option value="{{ $brand->id }}"
                                                        {{ $brand->id === (hasVal(old('brand')) ? old('brand')
                                                            : $product->brand_id) ? 'selected' : '' }}>
                                                        {{ $brand->name }}</option>
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
                                                    <option value="{{ $category->id }}" {{ (hasVal(old('category'))
                                                        ? old('category') : $product->category_id) === $category->id
                                                        ? 'selected' : '' }}>{{ $category->name }}</option>
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
                                                    <option value="{{ $subcategory->id }}"
                                                        {{ $subcategory->id === (hasVal(old('subcategory'))
                                                            ? old('subcategory') : $product->subcategory_id)
                                                            ? 'selected' : '' }}>{{ $subcategory->name }}</option>
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
                                                    <option value="{{ $child_category->id }}"
                                                        {{ $child_category->id === (hasVal(old('child_category'))
                                                            ? old('child_category') : $product->child_category_id)
                                                            ? 'selected' : '' }}>{{ $child_category->name }}
                                                    </option>
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
                                                @foreach( $types as $type )
                                                    <option value="{{ $type->id }}" {{ (hasVal(old('product_type'))
                                                        ? old('product_type') : $product->product_type_id) === $type->id
                                                            ? 'selected' : '' }}>{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="">Select</option>
                                                <option value="1" {{ (hasVal(old('status')) ? old('status')
                                                    : $product->status) === 1 ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0" {{ (hasVal(old('status')) ? old('status')
                                                    : $product->status) === 0 ? 'selected' : '' }}>Inactive
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sku">SKU</label>
                                            <input type="text" name="sku" id="sku" class="form-control"
                                                   value="{{ old('sku') ?? $product->sku }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="quantity">Stock Quantity</label>
                                            <input type="number" min="0" name="quantity" id="quantity"
                                                   class="form-control" value="{{
                                                    old('quantity') ?? $product->quantity }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="price">Standard Price</label>
                                            <input type="number" step="0.01" name="price" id="price"
                                                   class="form-control" value="{{ old('price') ?? $product->price }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="offer_price">Offer Price</label>
                                            <input type="number" step="0.01" name="offer_price" id="offer_price"
                                                   class="form-control" value="{{
                                                    old('offer_price') ?? $product->offer_price }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="offer_start_date">Offer Start Date</label>
                                            <input type="date" name="offer_start_date" id="offer_start_date"
                                                   class="form-control datepicker" value="{{
                                                    old('offer_start_date') ?? $product->offer_start_date }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="offer_end_date">Offer End Date</label>
                                            <input type="date" name="offer_end_date" id="offer_end_date"
                                                   class="form-control datepicker"
                                                   value="{{ old('offer_end_date') ?? $product->offer_end_date }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="video_link">Video Link</label>
                                    <input type="text" name="video_link" id="video_link" class="form-control"
                                           value="{{ old('video_link') ?? $product->video_link }}">
                                </div>
                                <div class="form-group">
                                    <label for="short_description">Short Description</label>
                                    <textarea name="short_description" class="form-control"
                                              id="short_description">{!! old('short_description')
                                                ?? $product->short_description !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="long_description">Long Description</label>
                                    <textarea name="long_description" class="form-control summernote"
                                              id="long_description">{!! old('long_description')
                                                ?? $product->long_description !!}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="seo_title">SEO Title</label>
                                    <input type="text" name="seo_title" id="seo_title" class="form-control"
                                           value="{{ old('seo_title') ?? $product->seo_title }}">
                                </div>
                                <div class="form-group">
                                    <label for="seo_description">SEO Description</label>
                                    <textarea name="seo_description" class="form-control"
                                              id="seo_description">{!! old('seo_description')
                                                ?? $product->seo_description !!}</textarea>
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

@push('scripts')
    <script>
        ($ => {
            $(() => {
                const getCatFam = (category, subcategory, childcategory, fam = "sub") => {
                    let target = category;
                    let famUrl = "{{ route('admin.product.get-subcategories') }}";
                    let idCatFam = $(subcategory);

                    if (fam === 'child') {
                        target = subcategory;
                        famUrl = "{{ route('admin.product.get-child-categories') }}";
                        idCatFam = $(childcategory);
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
                                if (fam !== "child") {
                                    $(childcategory).html('<option value="">Select</option>');
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

                getCatFam("#category", "#subcategory", "#child_category");
                getCatFam("#category", "#subcategory", "#child_category", "child");
            });
        })(jQuery);
    </script>
@endpush
