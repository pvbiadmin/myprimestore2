@extends( 'admin.layouts.master' )

@section( 'content' )
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Blog Category</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Blog Category</h4>

                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.blog-category.update', $category->id) }}" method="POST">
                                @csrf
                                @method( 'PUT' )
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name"
                                                   name="name" value="{{ $category->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select id="status" class="form-control" name="status">
                                                <option {{ $category->status == 1 ? 'selected' : '' }} value="1">
                                                    Active
                                                </option>
                                                <option {{ $category->status == 0 ? 'selected' : '' }} value="0">
                                                    Inactive
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
    </section>

@endsection
