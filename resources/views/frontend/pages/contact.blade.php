@extends( 'frontend.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || About
@endsection

@section( 'content' )
    <!--============================
        BREADCRUMB START
    ==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>contact us</h4>
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        BREADCRUMB END
    ==============================-->


    <!--============================
        CONTACT PAGE START
    ==============================-->
    <section id="wsus__contact">
        <div class="container">
            <div class="wsus__contact_area">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="row">
                            @if( $settings->contact_email )
                                <div class="col-xl-12">
                                    <div class="wsus__contact_single">
                                        <i class="fal fa-envelope"></i>
                                        <h5>mail address</h5>
                                        <a href="mailto:{{ $settings->contact_email }}">
                                            {{ $settings->contact_email }}</a>
                                        <span><i class="fal fa-envelope"></i></span>
                                    </div>
                                </div>
                            @endif

                            @if( $settings->contact_phone )
                                <div class="col-xl-12">
                                    <div class="wsus__contact_single">
                                        <i class="far fa-phone-alt"></i>
                                        <h5>phone number</h5>
                                        <a href="tel:{{ $settings->contact_phone }}">{{ $settings->contact_phone }}</a>
                                        <span><i class="far fa-phone-alt"></i></span>
                                    </div>
                                </div>
                            @endif

                            @if( $settings->contact_address )
                                <div class="col-xl-12">
                                    <div class="wsus__contact_single">
                                        <i class="fal fa-map-marker-alt"></i>
                                        <h5>contact address</h5>
                                        <a href="javascript:">{!! $settings->contact_address !!}</a>
                                        <span><i class="fal fa-map-marker-alt"></i></span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-8">
                        <div class="wsus__contact_question">
                            <h5>Send Us a Message</h5>
                            <form id="contact-form">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="wsus__con_form_single">
                                            <input type="text" placeholder="Your Name" name="name" aria-label="name">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__con_form_single">
                                            <input type="email" placeholder="Email" name="email" aria-label="email">
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <div class="wsus__con_form_single">
                                            <input type="text" placeholder="Subject" name="subject"
                                                   aria-label="subject">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="wsus__con_form_single">
                                            <textarea cols="3" rows="5" placeholder="Message" name="message"
                                                      aria-label="message"></textarea>
                                        </div>
                                        <button type="submit" class="common_btn" id="form-submit">send now</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="wsus__con_map">
                            <iframe
                                src="{{ $settings->map }}"
                                width="1600" height="450" style="border:0;" allowfullscreen
                                loading="lazy"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================
        CONTACT PAGE END
    ==============================-->
@endsection

@push( 'scripts' )
    <script>
        ($ => {
            $(() => {
                $('#contact-form').on('submit', e => {
                    e.preventDefault();
                    const $this = $(e.currentTarget);
                    let data = $this.serialize();

                    const $formSubmit = $('#form-submit');

                    $.ajax({
                        method: 'POST',
                        url: "{{ route('handle-contact-form') }}",
                        data: data,
                        beforeSend: () => {
                            $formSubmit.text('sending...');
                            $formSubmit.attr('disabled', true);
                        },
                        success: response => {
                            if (response.status === 'success') {
                                $formSubmit.text('send now')
                                $formSubmit.attr('disabled', false);

                                toastr.success(response.message);

                                $('#contact-form')[0].reset();
                            } else if (response.status === 'error') {
                                $formSubmit.text('send now');
                                $formSubmit.attr('disabled', false);

                                toastr.error(response.message);
                            }
                        },
                        error: (xhr, status, error) => {
                            console.log(error);

                            $formSubmit.text('send now');
                            $formSubmit.attr('disabled', false);
                        }
                    })
                })
            });
        })(jQuery);
    </script>
@endpush
