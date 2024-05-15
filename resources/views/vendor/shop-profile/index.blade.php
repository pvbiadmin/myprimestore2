@extends( 'vendor.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Shop - Profile
@endsection

@section( 'content' )
    <!--=============================
    DASHBOARD START
  ==============================-->
    <section id="wsus__dashboard">
        <div class="container-fluid">

            @include( 'vendor.layouts.sidebar' )

            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i> Shop Profile</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form method="post" action="{{ route('vendor.shop-profile.store') }}"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-2 mb-4">
                                        <div class="wsus__dash_pro_img">
                                            <img src="{{ asset($vendor->banner ?? 'frontend/images/product_blank.jpg') }}"
                                                 alt="img" class="img-fluid w-100">
                                            <input type="file" name="image">
                                        </div>
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="shop_name">Shop Name</label>
                                        <input type="text" name="shop_name" id="shop_name" class="form-control"
                                               value="{{ $vendor->shop_name }}">
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                               value="{{ $vendor->phone }}">
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" class="form-control"
                                               value="{{ $vendor->email }}">
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="address">Address</label>
                                        <input type="text" name="address" id="address" class="form-control"
                                               value="{{ $vendor->address }}">
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="description">Description</label>
                                        <textarea class="summernote" name="description"
                                                  id="description">{{ $vendor->description }}</textarea>
                                    </div>
                                    <div class="form-group wsus__input mt-2">
                                        <label for="fb_link">Facebook</label>
                                        <input type="text" name="fb_link" id="fb_link" class="form-control"
                                               value="{{ $vendor->fb_link }}">
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="yt_link">Youtube</label>
                                        <input type="text" name="yt_link" id="yt_link" class="form-control"
                                               value="{{ $vendor->yt_link }}">
                                    </div>
                                    <div class="form-group wsus__input">
                                        <label for="tw_link">Twitter(X)</label>
                                        <input type="text" name="tw_link" id="tw_link" class="form-control"
                                               value="{{ $vendor->tw_link }}">
                                    </div>
                                    <div class="form-group wsus__input">
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
        </div>
    </section>
    <!--=============================
      DASHBOARD START
    ==============================-->
@endsection
