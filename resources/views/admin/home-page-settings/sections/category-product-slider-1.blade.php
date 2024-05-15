@php
    $category_product_slider = isset($category_product_slider) ?
        json_decode($category_product_slider) : null;

    $cat_product_sliders = $category_product_slider ?
        json_decode($category_product_slider->value) : null;
@endphp
<div class="tab-pane fade"
     id="category-product-slider-1" role="tabpanel"
     aria-labelledby="category-product-slider-1">
    <div class="card border">
        <div class="card-body">
            <form method="post" action="{{ route('admin.home-page-setting.category-product-slider') }}">
                @csrf
                @method( 'PUT' )
                @if ( $cat_product_sliders )
                    @foreach ( $cat_product_sliders as $cat_product_slider )
                        @if ( $loop->iteration > 1 )
                            <hr>
                        @endif
                        <h5>Category {{ $loop->iteration }} <span class="float-right">
                                {{ in_array($loop->iteration, [1, 2]) ? 'Row Slider' :
                                (in_array($loop->iteration, [3, 4]) ? 'Col Slider' : '') }}</span></h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="slider-category{{ $loop->iteration }}">
                                        Category</label>
                                    <select name="slider_category{{ $loop->iteration }}"
                                            id="slider-category{{ $loop->iteration }}"
                                            class="form-control slider-category">
                                        <option value="">Select</option>
                                        @foreach ( $categories as $category )
                                            <option value="{{ $category->id }}" {{ $cat_product_slider
                                                && $category->id == $cat_product_slider->category
                                                    ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @php
                                $cat_product_slider = $cat_product_slider ?? null;
                                $subcategories = $cat_product_slider ? \App\Models\Subcategory::query()
                                    ->where('category_id', '=', $cat_product_slider->category)->get() : null;
                            @endphp
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="slider-subcategory{{ $loop->iteration }}">
                                        Subcategory</label>
                                    <select name="slider_subcategory{{ $loop->iteration }}"
                                            id="slider-subcategory{{ $loop->iteration }}"
                                            class="form-control slider-subcategory">
                                        <option value="">Select</option>
                                        @if ( $subcategories && count($subcategories) > 0 )
                                            @foreach ( $subcategories as $subcategory )
                                                <option value="{{ $subcategory->id }}" {{ $cat_product_slider
                                                    && $subcategory->id == $cat_product_slider->subcategory
                                                        ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @php
                                $cat_product_slider = $cat_product_slider ?? null;
                                $child_categories = $cat_product_slider ? \App\Models\ChildCategory::query()
                                    ->where('category_id', '=', $cat_product_slider->category)
                                    ->where('subcategory_id', '=', $cat_product_slider->subcategory)
                                    ->get() : null;
                            @endphp
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="slider-child-category{{ $loop->iteration }}">
                                        Child-category</label>
                                    <select name="slider_child_category{{ $loop->iteration }}"
                                            id="slider-child-category{{ $loop->iteration }}"
                                            class="form-control slider-child-category">
                                        <option value="">Select</option>
                                        @if ( $child_categories && count($child_categories) > 0 )
                                            @foreach ( $child_categories as $child_category )
                                                <option value="{{ $child_category->id }}" {{ $cat_product_slider &&
                                            $child_category->id == $cat_product_slider->child_category ?
                                                'selected' : '' }}>
                                                    {{ $child_category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    @for ( $index = 0; $index < 4; $index++ )
                        @if ( $index > 1 )
                            <hr>
                        @endif
                        <h5>Category {{ $index }} <span class="float-right">
                                {{ in_array($index, [1, 2]) ? 'Row Slider' :
                                (in_array($index, [3, 4]) ? 'Col Slider' : '') }}</span></h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="slider-category{{ $index + 1 }}">Category</label>
                                    <select name="slider_category{{ $index + 1 }}"
                                            id="slider-category{{ $index + 1 }}"
                                            class="form-control slider-category">
                                        <option value="">Select</option>
                                        @foreach ( $categories as $category )
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @php
                                $subcategories = \App\Models\Subcategory::query()->where('status', '=', 1)->get();
                            @endphp
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="slider-subcategory{{ $index + 1 }}">Subcategory</label>
                                    <select name="slider_subcategory{{ $index + 1 }}"
                                            id="slider-subcategory{{ $index + 1 }}"
                                            class="form-control slider-subcategory">
                                        <option value="">Select</option>
                                        @if ( $subcategories && count($subcategories) > 0 )
                                            @foreach ( $subcategories as $subcategory )
                                                <option value="{{ $subcategory->id }}">
                                                    {{ $subcategory->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            @php
                                $child_categories = \App\Models\ChildCategory::query()->where('status', '=', 1)->get();
                            @endphp
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="slider-child-category{{ $index + 1 }}">Child-category</label>
                                    <select name="slider_child_category{{ $index + 1 }}"
                                            id="slider-child-category{{ $index + 1 }}"
                                            class="form-control slider-child-category">
                                        <option value="">Select</option>
                                        @if ( $child_categories && count($child_categories) > 0 )
                                            @foreach ( $child_categories as $child_category )
                                                <option value="{{ $child_category->id }}">
                                                    {{ $child_category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endfor
                @endif
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

@push( 'scripts' )
    <script>
        ($ => {
            $(() => {
                const getCategorySlider = () => {
                    const target = 'select[name^="slider_category"]';

                    $("body").on("change", target, e => {
                        const $this = $(e.currentTarget);
                        const selectedOption = $this.val();

                        // Deselect the option in other category select tags with the same value
                        $(target)
                            .not(e.currentTarget)
                            .find('option[value="' + selectedOption + '"]')
                            .prop('selected', false);

                        // Hide the option in other category select tags with the same value
                        $(target)
                            .not(e.currentTarget)
                            .find('option[value="' + selectedOption + '"]')
                            .prop('disabled', true);

                        // Enable all previously disabled options
                        $('select[name^="slider_category"] option').prop('disabled', false);
                    });
                };

                const getSubcategorySlider = () => {
                    $("body").on("change", ".slider-category", event => {
                        const idSelectedCategory = $(event.target).val();
                        const currentRow = $(event.target).closest(".row");

                        $.ajax({
                            method: "GET",
                            url: "{{ route('admin.product.get-subcategories') }}",
                            data: {catFamId: idSelectedCategory},
                            success: response => {
                                const currentSubcategory = currentRow.find(".slider-subcategory");

                                currentSubcategory.html('<option value="">Select</option>');

                                $.each(response, (index, element) => {
                                    currentSubcategory
                                        .append(`<option value="${element.id}">${element.name}</option>`);
                                });
                            },
                            error: (xhr, status, error) => {
                                console.log(error);
                            }
                        });
                    });
                };

                const getChildCategorySlider = () => {
                    $("body").on(
                        "change",
                        ".slider-category",
                        ".slider-subcategory",
                        event => {
                            const idSelectedSubcategory = $(event.target).val();
                            const currentRow = $(event.target).closest(".row");

                            $.ajax({
                                method: "GET",
                                url: "{{ route('admin.product.get-child-categories') }}",
                                data: {catFamId: idSelectedSubcategory},
                                success: response => {
                                    const currentChildCategory = currentRow
                                        .find(".slider-child-category");

                                    currentChildCategory.html('<option value="">Select</option>');

                                    $.each(response, (index, element) => {
                                        currentChildCategory
                                            .append(`<option value="${element.id}">${element.name}</option>`);
                                    });
                                },
                                error: (xhr, status, error) => {
                                    console.log(error);
                                }
                            });
                        });
                };

                getCategorySlider();
                getSubcategorySlider();
                getChildCategorySlider();
            });
        })(jQuery);
    </script>
@endpush
