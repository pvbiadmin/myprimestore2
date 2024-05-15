@extends( 'vendor.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Referral Code
@endsection

@section( 'content' )
    <section id="wsus__dashboard">
        <div class="container-fluid">

            @include( 'vendor.layouts.sidebar' )

            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <div class="wsus__dashboard_profile">
                            <div class="row">
                                <div class="col-xl-5 col-md-10 col-lg-8 m-auto">
                                    <form class="tack_form" method="POST"
                                          action="{{ route('user.referral-code.send') }}">
                                        @csrf
                                        <input type="hidden" name="from_address"
                                               value="{{ auth()->user()->email }}">
                                        <div class="wsus__track_input">
                                            <input type="text" id="referral_code" name="referral_code" readonly
                                                   placeholder="Referral Code" aria-label="referral-code">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <button type="button" id="generate-code"
                                                        class="common_btn">Generate
                                                </button>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" id="copyButton" class="common_btn d-none">
                                                    <i class="fa fa-copy"></i> Copy
                                                </button>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" id="shareButton" class="common_btn d-none">
                                                    <i class="fa fa-share"></i> Share
                                                </button>
                                            </div>
                                        </div>
                                        <div id="share-code" class="d-none">
                                            <br>
                                            <hr>
                                            <br>
                                            <div class="wsus__track_input">
                                                <input type="email" name="to_address"
                                                       placeholder="Email Address"
                                                       aria-label="email">
                                            </div>
                                            <button type="submit" class="common_btn">send</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push( 'scripts' )
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const referralCodeInput = document.getElementById('referral_code');
            const copyButton = document.getElementById('copyButton');

            // Show copy button when referral code is generated
            referralCodeInput.addEventListener('input', () => {
                if (referralCodeInput.value) {
                    copyButton.classList.remove('d-none');
                } else {
                    copyButton.classList.add('d-none');
                }
            });

            const copyReferralCode = () => {
                const textToCopy = referralCodeInput.value;

                const dummyElement = document.createElement('textarea');
                dummyElement.value = textToCopy;
                document.body.appendChild(dummyElement);
                dummyElement.select();
                document.execCommand('copy');
                document.body.removeChild(dummyElement);

                copyButton.innerHTML = '<i class="fa fa-copy"></i> Copied!';

                setTimeout(() => {
                    copyButton.innerHTML = '<i class="fa fa-copy"></i> Copy';
                }, 3000);
            };

            copyButton.addEventListener('click', copyReferralCode);
        });

        ($ => {
            $(() => {
                $("body").on("click", "#shareButton", () => {
                    $("#share-code").removeClass("d-none");
                });

                const generateCode = () => {
                    $("body").on("click", "#generate-code", () => {
                        $.ajax({
                            url: "{{ route('user.referral-code.generate' )}}",
                            method: "GET",
                            success: res => {
                                if (res.status === "success") {
                                    $("#referral_code").val(res.message);
                                    $("#copyButton").removeClass("d-none");
                                    $("#shareButton").removeClass("d-none");
                                }

                                if (res.status === "error") {
                                    toastr.error(res.message);
                                }
                            },
                            error: (xhr, status, error) => {
                                console.log(error);
                            }
                        });
                    });
                }

                generateCode();
            });
        })(jQuery);
    </script>
@endpush
