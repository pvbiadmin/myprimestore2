<section id="wsus__large_banner">
    <div class="container">
        <div class="row">
            <div class="cl-xl-12">
                @if ( @$homepage_section_banner_four->banner_one->status == 1 )
                    <div class="wsus__large_banner_content" style="background: url({{
                        asset(@$homepage_section_banner_four->banner_one->banner_image) }}); {{
                            @$homepage_section_banner_four->banner_one->default_url ? 'cursor: pointer;' : '' }}">
                        <div class="wsus__large_banner_content_overlay">
                            <div class="row">
                                <div class="col-xl-6 col-12 col-md-6">
                                    @if ( @$homepage_section_banner_four->banner_one->banner_header
                                        || @$homepage_section_banner_four->banner_one->banner_description
                                        || @$homepage_section_banner_four->banner_one->button1_text )
                                        <div class="wsus__large_banner_text">
                                            @if ( @$homepage_section_banner_four->banner_one->banner_header )
                                                <h3>{{ @$homepage_section_banner_four->banner_one->banner_header }}</h3>
                                            @endif
                                            @if ( @$homepage_section_banner_four->banner_one->banner_description )
                                                <p>{{ @$homepage_section_banner_four->banner_one->banner_description }}</p>
                                            @endif
                                            @if ( @$homepage_section_banner_four->banner_one->button1_text
                                                && @$homepage_section_banner_four->banner_one->button1_url )
                                                <a class="shop_btn" href="{{
                                                @$homepage_section_banner_four->banner_one->button1_url }}">{{
                                                @$homepage_section_banner_four->banner_one->button1_text }}</a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="col-xl-6 col-12 col-md-6">
                                    @if ( @$homepage_section_banner_four->banner_one->leading_text
                                        || @$homepage_section_banner_four->banner_one->highlight_text
                                        || @$homepage_section_banner_four->banner_one->followup_text
                                        || @$homepage_section_banner_four->banner_one->button2_text )
                                        <div class="wsus__large_banner_text wsus__large_banner_text_right">
                                            @if ( @$homepage_section_banner_four->banner_one->leading_text )
                                                <h3>{{ @$homepage_section_banner_four->banner_one->leading_text }}</h3>
                                            @endif
                                            @if ( @$homepage_section_banner_four->banner_one->highlight_text )
                                                <h5>{{ @$homepage_section_banner_four->banner_one->highlight_text }}</h5>
                                            @endif
                                            @if ( @$homepage_section_banner_four->banner_one->followup_text )
                                                <p>{{ @$homepage_section_banner_four->banner_one->followup_text }}</p>
                                            @endif
                                            @if ( @$homepage_section_banner_four->banner_one->button2_url
                                            && @$homepage_section_banner_four->banner_one->button2_text )
                                                <a class="shop_btn" href="{{
                                                    @$homepage_section_banner_four->banner_one->button2_url }}">{{
                                                    @$homepage_section_banner_four->banner_one->button2_text }}</a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@if ( @$homepage_section_banner_four->banner_one->default_url )
    @push( 'scripts' )
        <script>
            ($ => {
                $(() => {
                    $("body").on("click", ".wsus__large_banner_content", () => {
                        window.location.href = "{{ @$homepage_section_banner_four->banner_one->default_url }}";
                    });
                });
            })(jQuery);
        </script>
    @endpush
@endif
