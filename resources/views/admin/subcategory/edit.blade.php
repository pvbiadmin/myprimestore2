@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Subcategory</h1>
        </div>
        <div class="mb-3">
            <a href="{{ route('admin.subcategory.index') }}" class="btn btn-primary">Back</a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Subcategory</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.subcategory.update', $subcategory->id) }}">
                                @csrf
                                @method( 'PUT' )
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select</option>
                                        @foreach( $categories as $category )
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $subcategory->category_id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           value="{{ $subcategory->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ $subcategory->status == 1 ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ $subcategory->status == 0 ? 'selected' : '' }}>Inactive
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
