@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Vendor Profile</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Update Vendor Profile</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.vendor-profile.store') }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <img src="{{ asset($vendor->banner) }}" alt="" width="200">
                                </div>
                                <div class="form-group">
                                    <label for="banner">Banner</label>
                                    <input type="file" name="banner" id="banner" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="shop_name">Shop Name</label>
                                    <input type="text" name="shop_name" id="shop_name" class="form-control"
                                           value="{{ $vendor->shop_name }}">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                           value="{{ $vendor->phone }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control"
                                           value="{{ $vendor->email }}">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" id="address" class="form-control"
                                           value="{{ $vendor->address }}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="summernote" name="description"
                                              id="description">{{ $vendor->description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="fb_link">Facebook</label>
                                    <input type="text" name="fb_link" id="fb_link" class="form-control"
                                           value="{{ $vendor->fb_link }}">
                                </div>
                                <div class="form-group">
                                    <label for="yt_link">Youtube</label>
                                    <input type="text" name="yt_link" id="yt_link" class="form-control"
                                           value="{{ $vendor->yt_link }}">
                                </div>
                                <div class="form-group">
                                    <label for="tw_link">Twitter(X)</label>
                                    <input type="text" name="tw_link" id="tw_link" class="form-control"
                                           value="{{ $vendor->tw_link }}">
                                </div>
                                <div class="form-group">
                                    <label for="insta_link">Instagram</label>
                                    <input type="text" name="insta_link" id="insta_link" class="form-control"
                                           value="{{ $vendor->insta_link }}">
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
