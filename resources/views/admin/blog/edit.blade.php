@extends( 'admin.layouts.master' )

@section( 'content' )
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Blog</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Blog</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf
                                @method( 'PUT' )
                                <div class="form-group">
                                    <img src="{{ asset($blog->image) }}" width="200px" alt="{{ $blog->slug }}">
                                    <br>
                                    <label>Image</label>
                                    <input type="file" class="form-control" name="image">
                                </div>

                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" id="title" name="title"
                                           value="{{ $blog->title }}">
                                </div>

                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select id="category" class="form-control main-category" name="category">
                                        <option value="">Select</option>
                                        @foreach ( $categories as $category )
                                            <option
                                                {{ $category->id == $blog->category_id ? 'selected' : '' }}
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description"
                                              class="form-control summernote">{!! $blog->description !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="seo_title">SEO Title</label>
                                    <input type="text" class="form-control" name="seo_title" id="seo_title"
                                           value="{{ $blog->seo_title }}">
                                </div>

                                <div class="form-group">
                                    <label for="seo_description">SEO Description</label>
                                    <textarea name="seo_description" id="seo_description"
                                              class="form-control">{!! $blog->seo_description !!}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" class="form-control" name="status">
                                        <option {{ $blog->status == 1 ? 'selected' : '' }} value="1">Active</option>
                                        <option {{ $blog->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
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
