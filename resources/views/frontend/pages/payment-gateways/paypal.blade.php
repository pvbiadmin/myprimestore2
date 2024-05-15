<div class="tab-pane fade show active" id="v-pills-paypal" role="tabpanel"
     aria-labelledby="v-pills-paypal-tab">
    <div class="row">
        <div class="col-xl-12 m-auto">
            <div class="wsus__payment_area">
                <button id="pay-with-paypal" class="nav-link common_btn">
                    Pay with Paypal
                </button>
            </div>
        </div>
    </div>
</div>

@push( 'scripts' )
    <script>
        ($ => {
            $(() => {
                $("body").on("click", "#pay-with-paypal", () => {
                    Swal.fire({
                        title: 'Redirecting to PayPal...',
                        text: 'You will be redirected to PayPal for payment.',
                        icon: 'info',
                        showConfirmButton: false,
                        timer: 3000, // 3 seconds
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    }).then(() => {
                        window.location.href = "{{ route('user.paypal.payment') }}";
                    });
                });
            });
        })(jQuery);
    </script>
@endpush
