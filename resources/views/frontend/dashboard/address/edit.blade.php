@extends( 'frontend.dashboard.layouts.master' )

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
                        <h3><i class="fal fa-gift-card"></i>update address</h3>
                        <div class="wsus__dashboard_add wsus__add_address">
                            <form action="{{ route('user.address.update', $address->id) }}" method="post">
                                @csrf
                                @method( 'PUT' )
                                <div class="row">
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label for="name">name <b>*</b></label>
                                            <input type="text" name="name" id="name"
                                                   value="{{ $address->name }}" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label for="email">email</label>
                                            <input type="email" name="email" id="email"
                                                   value="{{ $address->email }}" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label for="phone">phone <b>*</b></label>
                                            <input type="text" name="phone" id="phone"
                                                   value="{{ $address->phone }}" placeholder="Phone">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label for="country">country <b>*</b></label>
                                            <div class="wsus__topbar_select">
                                                <select class="select_2" name="country" id="country">
                                                    <option value="">Select</option>
                                                    @foreach( config('settings.country_list') as $abbr => $country )
                                                        <option value="{{ $abbr }}" {{ $address->country == $abbr ?
                                                                'selected' : '' }}>{{ $country }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label for="state">state (Region) <b>*</b></label>
                                            <div class="wsus__topbar_select">
                                                <input type="text" name="state" id="state"
                                                       value="{{ $address->state }}" placeholder="State">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label for="city">city <b>*</b></label>
                                            <div class="wsus__topbar_select">
                                                <input type="text" name="city" id="city"
                                                       value="{{ $address->city }}" placeholder="City">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label for="zip">zip code <b>*</b></label>
                                            <input type="text" name="zip" id="zip"
                                                   value="{{ $address->zip }}" placeholder="Zip Code">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6">
                                        <div class="wsus__add_address_single">
                                            <label for="address">address <b>*</b></label>
                                            <input type="text" name="address" id="address"
                                                   value="{{ $address->address }}" placeholder="Address">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <button type="submit" class="common_btn">update</button>
                                    </div>
                                </div>
                            </form>
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
