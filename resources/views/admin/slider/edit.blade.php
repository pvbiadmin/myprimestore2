@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Slider</h1>
        </div>
        <div class="mb-3">
            <a href="{{ route('admin.slider.index') }}" class="btn btn-primary">Back</a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Slider</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.slider.update', $slider->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method( 'PUT' )
                                <div class="form-group">
                                    <img src="{{ asset($slider->image) }}" width="200" alt="{{ $slider->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <input type="text" name="type" id="type" class="form-control"
                                           value="{{ $slider->type }}">
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                           value="{{ $slider->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="subtitle">Subtitle</label>
                                    <input type="text" name="subtitle" id="subtitle" class="form-control"
                                           value="{{ $slider->subtitle }}">
                                </div>
                                <div class="form-group">
                                    <label for="cta_caption">CTA Caption</label>
                                    <input type="text" name="cta_caption" id="cta_caption" class="form-control"
                                           value="{{ $slider->cta_caption }}">
                                </div>
                                <div class="form-group">
                                    <label for="cta_link">CTA Link</label>
                                    <input type="text" name="cta_link" id="cta_link" class="form-control"
                                           value="{{ $slider->cta_link }}">
                                </div>
                                <div class="form-group">
                                    <label for="serial">Serial</label>
                                    <input type="text" name="serial" id="serial" class="form-control"
                                           value="{{ $slider->serial }}">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ $slider->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $slider->status == 0 ? 'selected' : '' }}>Inactive</option>
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
