@extends( 'admin.layouts.master' )

@section( 'content' )
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Footer</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Footer Social</h4>

                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.footer-socials.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="icon">Icon</label><br>
                                    <button id="icon" class="btn btn-primary" name="icon" role="iconpicker"
                                            data-icon="{{ old('icon') }}" data-selected-class="btn-danger"
                                            data-unselected-class="btn-info"></button>

                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name"
                                           id="name" value="{{ old('name') }}">
                                </div>
                                <div class="form-group">
                                    <label for="url">URL</label>
                                    <input type="text" class="form-control" name="url"
                                           id="url" value="{{ old('url') }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputState">Status</label>
                                    <select id="inputState" class="form-control" name="status">
                                        <option value="1" {{ old('status') === '1'
                                            ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') === '0'
                                            ? 'selected' : '' }}>Inactive</option>
                                    </select>
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
