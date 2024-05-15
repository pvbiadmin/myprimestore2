@extends ( 'vendor.layouts.master' )

@section ( 'title' )
    {{ $settings->site_name }} || Create Withdraw Request
@endsection

@section( 'content' )
    <!--=============================
    DASHBOARD START
  ==============================-->
    <section id="wsus__dashboard">
        <div class="container-fluid">
            @include ( 'vendor.layouts.sidebar' )

            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i> Create Withdraw Request</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="row">
                                <div class="wsus__dash_pro_area col-md-6">
                                    <form action="{{ route('vendor.withdraw.store') }}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group wsus__input">
                                                    <label for="withdraw_method">Method</label>
                                                    <select name="withdraw_method" id="withdraw_method"
                                                            class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach ( $methods as $method )
                                                            <option value="{{ $method->id }}">
                                                                {{$method->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group wsus__input">
                                                    <label for="amount">Withdraw Amount ({{
                                                        $settings->currency_icon }})</label>
                                                    <input type="number" step="0.01" class="form-control decimal-input"
                                                           id="amount" name="amount" placeholder="0.00">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group wsus__input">
                                            <label for="account_info">Account Information</label>
                                            <textarea name="account_info" rows="7"
                                                      class="form-control" id="account_info"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </form>
                                </div>
                                <div class="wsus__dash_pro_area col-md-6 account_info_area ml-2"></div>
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
    <script>
        ($ => {
            $(() => {
                const formatFloat = (float) => {
                    const parsedFloat = parseFloat(float);
                    return parsedFloat.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }

                $('#withdraw_method').on('change', function (e) {
                    const $this = $(e.currentTarget);
                    const id = $this.val();

                    $.ajax({
                        method: 'GET',
                        url: "{{ route('vendor.withdraw.show', ':id') }}".replace(':id', id),
                        success: function (response) {
                            const {minimum_amount, maximum_amount, withdraw_charge, description} = response;

                            $('.account_info_area').html(`
                                <h3>Payout Range: {{ $settings->currency_icon }}${formatFloat(minimum_amount)} - {{
                                    $settings->currency_icon }}${formatFloat(maximum_amount)}</h3>
                                <h3>Withdraw charge: ${formatFloat(withdraw_charge)}%</h3>
                                <p>${description}</p>`)
                        },
                        error: (xhr, status, error) => {
                            console.log(error);
                        }
                    });
                });

                $('.decimal-input').on('change', function (e) {
                    const $this = $(e.currentTarget);
                    // Round the input value to two decimal places
                    $this.val(parseFloat($this.val()).toFixed(2));
                });
            });
        })(jQuery);
    </script>
@endpush
