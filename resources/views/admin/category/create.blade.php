@extends( 'admin.layouts.master' )

{{--@dd( old() )--}}

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Category</h1>
        </div>
        <div class="mb-3">
            <a href="{{ route('admin.category.index') }}" class="btn btn-primary">Back</a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Category</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.category.store') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="icon">Icon</label><br>
                                    <button id="icon" class="btn btn-primary" name="icon" role="iconpicker"
                                            data-icon="{{ old('icon') }}" data-selected-class="btn-danger"
                                            data-unselected-class="btn-info"></button>
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
