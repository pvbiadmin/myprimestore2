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
                            <h4>Create Child-Category</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.child-category.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ( $categories as $category )
                                            @if ( count($category->subcategories) > 0 )
                                                <option value="{{ $category->id }}" {{
                                                    old('category') == $category->id ? 'selected'
                                                        : '' }}>{{ $category->name }}</option>
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
                                                    old('subcategory') == $subcategory->id ? 'selected'
                                                        : '' }}>{{ $subcategory->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name"
                                           class="form-control" value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
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
                $("body").on("change", "#category", e => {
                    const $this = $(e.currentTarget);
                    const categoryId = $this.val();

                    $.ajax({
                        method: "GET",
                        url: "{{ route('admin.get-subcategories') }}",
                        data: {
                            categoryId: categoryId
                        },
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
