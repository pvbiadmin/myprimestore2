@extends( 'frontend.dashboard.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Became a Vendor Today
@endsection

@section( 'content' )
    <!--=============================
    DASHBOARD START
  ==============================-->
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include( 'frontend.dashboard.layouts.sidebar' )
            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-edit"></i> Apply for Vendor</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                {!! @$content->content !!}
                            </div>
                        </div>
                        <br>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                <form action="{{ route('user.vendor-apply.create') }}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="wsus__dash_pro_single">
                                        <i class="fas fa-image" aria-hidden="true"></i>
                                        <input type="file" name="shop_image" placeholder="Shop Banner Image">
                                    </div>
                                    <div class="wsus__dash_pro_single">
                                        <i class="fas fa-store" aria-hidden="true"></i>
                                        <input type="text" name="shop_name" placeholder="Shop Name"
                                               value="{{ old('shop_name') }}" aria-label="shop_name">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="wsus__dash_pro_single">
                                                <i class="fas fa-envelope" aria-hidden="true"></i>
                                                <input type="text" name="shop_email" placeholder="Shop Email"
                                                       value="{{ old('shop_email') }}" aria-label="shop_email">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="wsus__dash_pro_single">
                                                <i class="fas fa-phone" aria-hidden="true"></i>
                                                <input type="text" name="shop_phone" placeholder="Shop Phone"
                                                       value="{{ old('shop_phone') }}" aria-label="shop_phone">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wsus__dash_pro_single">
                                        <i class="fas fa-address-card" aria-hidden="true"></i>
                                        <input type="text" name="shop_address" placeholder="Shop Address"
                                               value="{{ old('shop_address') }}" aria-label="shop_address">
                                    </div>
                                    <div class="wsus__dash_pro_single">
                                        <textarea name="about" placeholder="About You"
                                                  aria-label="about">{!! old('about') !!}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
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

