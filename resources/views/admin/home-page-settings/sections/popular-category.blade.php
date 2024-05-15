@php
    $categories = $categories ?? null;
    $popular_categories = isset($popular_categories) ? json_decode($popular_categories) : null;

    $pop_cats = $popular_categories ? json_decode($popular_categories->value) : null;
@endphp
<div class="tab-pane fade show active" id="popular-category-product" role="tabpanel"
     aria-labelledby="popular-category-product">
    <div class="card border">
        <div class="card-body">
            <form method="post" action="{{ route('admin.home-page-setting.popular-categories') }}">
                @csrf
                @method( 'PUT' )
                @if ( $pop_cats )
                    @foreach ( $pop_cats as $pop_cat )
                        @if ( $loop->iteration > 1 )
                            <hr>
                        @endif
                            <h5>Category {{ $loop->iteration }} <span class="float-right">Popular Products</span></h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="popular-category{{ $loop->iteration }}">Category</label>
                                    <select name="popular_category{{ $loop->iteration }}"
                                            id="popular-category{{ $loop->iteration }}"
                                            class="form-control popular-category">
                                        <option value="">Select</option>
                                        @foreach ( $categories as $category )
                                            <option value="{{ $category->id }}" {{
                                            $category->id == $pop_cat->category ? 'selected' : ''
                                                }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @php
                                $pop_cat = $pop_cat ?? null;

                                $subcategories = \App\Models\Subcategory::query()
                                    ->where('id', '=', $pop_cat->subcategory)
                                    ->where('category_id', '=', $pop_cat->category)
                                    ->get();
                            @endphp
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="popular-subcategory{{ $loop->iteration }}">Subcategory</label>
                                    <select name="popular_subcategory{{ $loop->iteration }}"
                                            id="popular-subcategory{{ $loop->iteration }}"
                                            class="form-control popular-subcategory">
                                        <option value="">Select</option>
                                        @foreach ( $subcategories as $subcategory )
                                            <option value="{{ $subcategory->id }}" {{
                                            $subcategory->id == $pop_cat->subcategory ? 'selected' : ''
                                                }}>{{ $subcategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @php
                                $pop_cat = $pop_cat ?? null;

                                $child_categories = \App\Models\ChildCategory::query()
                                    ->where('id', '=', $pop_cat->child_category)
                                    ->where('subcategory_id', '=', $pop_cat->subcategory)
                                    ->where('category_id', '=', $pop_cat->category)
                                    ->get();
                            @endphp
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="popular-child-category{{ $loop->iteration }}">Child-category</label>
                                    <select name="popular_child_category{{ $loop->iteration }}"
                                            id="popular-child-category{{ $loop->iteration }}"
                                            class="form-control popular-child-category">
                                        <option value="">Select</option>
                                        @foreach ( $child_categories as $child_category )
                                            <option value="{{ $child_category->id }}" {{
                                            $child_category->id == $pop_cat->child_category ? 'selected' : ''
                                                }}>{{ $child_category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    @for ( $index = 0; $index < 4; $index++ )
                        <h5>Popular Category {{ $index + 1 }} <span class="float-right">Popular Products</span></h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="popular-category{{ $index + 1 }}">Category</label>
                                    <select name="popular_category{{ $index + 1 }}"
                                            id="popular-category{{ $index + 1 }}"
                                            class="form-control popular-category">
                                        <option value="">Select</option>
                                        @foreach ($categories as $category)
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
                                    <label for="popular-subcategory{{ $index + 1 }}">Subcategory</label>
                                    <select name="popular_subcategory{{ $index + 1 }}"
                                            id="popular-subcategory{{ $index + 1 }}"
                                            class="form-control popular-subcategory">
                                        <option value="">Select</option>
                                        @foreach ( $subcategories as $subcategory )
                                            <option value="{{ $subcategory->id }}">
                                                {{ $subcategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @php
                                $child_categories = \App\Models\ChildCategory::query()
                                    ->where('status', '=', 1)->get();
                            @endphp
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="popular-child-category{{ $index + 1 }}">Child-category</label>
                                    <select name="popular_child_category{{ $index + 1 }}"
                                            id="popular-child-category{{ $index + 1 }}"
                                            class="form-control popular-child-category">
                                        <option value="">Select</option>
                                        @foreach ( $child_categories as $child_category )
                                            <option value="{{ $child_category->id }}">
                                                {{ $child_category->name }}</option>
                                        @endforeach
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
                const getPopularCategory = () => {
                    const target = 'select[name^="popular_category"]';

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
                        $('select[name^="popular_category"] option').prop('disabled', false);
                    });
                };

                const getPopularSubcategory = () => {
                    $("body").on("change", ".popular-category", event => {
                        const idSelectedCategory = $(event.target).val();
                        const currentRow = $(event.target).closest(".row");

                        $.ajax({
                            method: "GET",
                            url: "{{ route('admin.product.get-subcategories') }}",
                            data: {catFamId: idSelectedCategory},
                            success: response => {
                                const currentSubcategory = currentRow.find(".popular-subcategory");

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

                const getPopularChildCategory = () => {
                    $("body").on("change", ".popular-category", ".popular-subcategory", event => {
                        const idSelectedSubcategory = $(event.target).val();
                        const currentRow = $(event.target).closest(".row");

                        $.ajax({
                            method: "GET",
                            url: "{{ route('admin.product.get-child-categories') }}",
                            data: {catFamId: idSelectedSubcategory},
                            success: response => {
                                const currentChildCategory = currentRow.find(".popular-child-category");

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

                getPopularCategory();
                getPopularSubcategory();
                getPopularChildCategory();
            });
        })(jQuery);
    </script>
@endpush
