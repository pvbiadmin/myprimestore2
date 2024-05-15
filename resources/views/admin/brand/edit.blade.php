@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Brand</h1>
        </div>
        <div class="mb-3">
            <a href="{{ route('admin.brand.index') }}" class="btn btn-primary">Back</a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Brand</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.brand.update', $brand->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method( 'PUT' )
                                <div class="form-group">
                                    <label for="logo_preview">Preview</label><br>
                                    <img src="{{ asset($brand->logo) }}" id="logo_preview"
                                         width="200" alt="{{ $brand->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <input type="file" name="logo" id="logo" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           value="{{ $brand->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="is_featured">Is Featured</label>
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="1" {{
                                            $brand->is_featured == 1 ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="0" {{
                                            $brand->is_featured == 0 ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ $brand->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $brand->status == 0 ? 'selected' : '' }}>Inactive</option>
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
