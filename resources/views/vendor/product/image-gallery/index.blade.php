@extends( 'vendor.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Product - Gallery
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
                    <a href="{{ route('vendor.products.index') }}" class="btn btn-warning mb-4">
                        <i class="fas fa-long-arrow-left"></i> Back</a>
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="fas fa-box-open"></i> Product: {{ $product->name }}</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{ route('vendor.products-image-gallery.store') }}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <p><code>(Multiple image supported.)</code></p>
                                    <div class="col-md-2 mb-4">
                                        <div class="wsus__dash_pro_img">
                                            <img src="{{ asset('frontend/images/product_blank.jpg') }}"
                                                 alt="img" class="img-fluid w-100">
                                            <input type="file" name="image[]" multiple>
                                            <input type="hidden" name="product" value="{{ $product->id }}">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="fas fa-images"></i> All Images</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                {{ $dataTable->table() }}
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

@push( 'scripts' )
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
