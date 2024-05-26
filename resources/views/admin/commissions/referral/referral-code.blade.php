<div class="tab-pane fade show active" id="list-code" role="tabpanel"
     aria-labelledby="list-code-list">
    <div class="card border">
        <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
            <div class="card-header">
                <div class="buttons">
                    <button class="btn btn-info" id="generate-code">Generate Code</button>
                    <a href="javascript:" class="btn" id="referral_code"></a>
                    <a href="javascript:" class="btn d-none" id="copyButton"
                       onclick="copyReferralCode()">
                        <i class="fa fa-copy"></i> Copy</a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.referral-code.send') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <input type="hidden" name="referral_code" id="referral_code_send">
                            <input type="hidden" name="from_address"
                                   value="{{ auth()->user()->email }}">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                            <input id="email" type="email" class="form-control" name="to_address"
                                   autofocus="" placeholder="Email" aria-label="email">
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-lg btn-round btn-primary">
                            Send Code
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push( 'scripts' )
    <script>
        const copyReferralCode = () => {
            const referralLink = document.getElementById('referral_code');
            const textToCopy = referralLink.innerText;

            const dummyElement = document.createElement('textarea');
            dummyElement.value = textToCopy;
            document.body.appendChild(dummyElement);
            dummyElement.select();
            document.execCommand('copy');
            document.body.removeChild(dummyElement);

            const copyButton = document.getElementById('copyButton');
            copyButton.innerHTML = '<i class="fa fa-check"></i> Copied!';

            setTimeout(() => {
                copyButton.innerHTML = '<i class="fa fa-copy"></i> Copy';
            }, 3000);
        }

        const generateCode = () => {
            ($ => {
                $(() => {
                    $("body").on("click", "#generate-code", () => {
                        $.ajax({
                            url: "{{ route('admin.referral-code.generate' )}}",
                            method: "GET",
                            success: res => {
                                if (res.status === "success") {
                                    $("#referral_code").text(res.message);
                                    $("#referral_code_send").val(res.message);
                                    $("#copyButton").removeClass("d-none");
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
                });
            })(jQuery);
        }

        generateCode();
    </script>
@endpush
