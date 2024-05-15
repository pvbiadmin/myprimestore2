@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Child-Category</h1>
        </div>
        <div class="mb-3">
            <a href="{{ route('admin.child-category.index') }}" class="btn btn-primary">Back</a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Child-Category</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{
                                route('admin.child-category.update', $child_category->id) }}">
                                @csrf
                                @method( 'PUT' )
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control main-category">
                                        <option value="">Select</option>
                                        @foreach ( $categories as $category )
                                            @if ( count($category->subcategories) > 0 )
                                                <option value="{{ $category->id }}" {{
                                                    $category->id == $child_category->category_id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="subcategory">Subcategory</label>
                                    <select name="subcategory" id="subcategory" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ( $subcategories as $subcategory )
                                            <option value="{{ $subcategory->id }}" {{
                                                $subcategory->id == $child_category->subcategory_id
                                                    ? 'selected' : '' }}>
                                                {{ $subcategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           value="{{ $child_category->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ $child_category->status == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ $child_category->status == 0 ? 'selected' : '' }}>
                                            Inactive
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

@push( 'scripts' )
    <script>
        ($ => {
            $(() => {
                $("body").on("change", ".main-category", e => {
                    const $this = $(e.currentTarget);
                    const categoryId = $this.val();

                    $.ajax({
                        method: "GET",
                        url: "{{ route('admin.get-subcategories') }}",
                        data: {categoryId: categoryId},
                        success: res => {
                            $("#subcategory").html('<option value="">Select</option>');
                            $.each(res, (i, item) => {
                                $("#subcategory").append(`<option value="${item.id}">${item.name}</option>`);
                            });
                        },
                        error: (xhr, status, error) => {
                            console.log(error);
                        }
                    });
                })
            });
        })(jQuery);
    </script>
@endpush
