@if ( @$homepage_section_banner_two->banner_one->status == 1
    || @$homepage_section_banner_two->banner_two->status == 1 )
    <section id="wsus__single_banner" class="wsus__single_banner_2">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6">
                    @if ( @$homepage_section_banner_two->banner_one->status == 1 )
                        <div class="wsus__single_banner_content">
                            <a class="wsus__single_banner_img"
                               href="{{ @$homepage_section_banner_two->banner_one->banner_url }}">
                                <img src="{{ asset(@$homepage_section_banner_two->banner_one->banner_image) }}"
                                     alt="banner" class="img-fluid w-100">
                            </a>
                            @if ( @$homepage_section_banner_two->banner_one->hook_text
                                || @$homepage_section_banner_two->banner_one->highlight_text
                                || @$homepage_section_banner_two->banner_one->followup_text
                                || @$homepage_section_banner_two->banner_one->button_text )
                                <div class="wsus__single_banner_text">
                                    <h6>@if ( @$homepage_section_banner_two->banner_one->hook_text ){{
                                    @$homepage_section_banner_two->banner_one->hook_text }}@endif @if(
                                    @$homepage_section_banner_two->banner_one->highlight_text )<span>{{
                                @$homepage_section_banner_two->banner_one->highlight_text }}</span>@endif</h6>
                                    @if ( @$homepage_section_banner_two->banner_one->followup_text )<h3>{{
                                    @$homepage_section_banner_two->banner_one->followup_text }}</h3>@endif
                                    @if ( @$homepage_section_banner_two->banner_one->followup_text )
                                        <a class="shop_btn" href="{{
                                    @$homepage_section_banner_two->banner_one->banner_url }}">{{
                                    @$homepage_section_banner_two->banner_one->button_text }}</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="col-xl-6 col-lg-6">
                    @if ( @$homepage_section_banner_two->banner_two->status == 1 )
                        <div class="wsus__single_banner_content single_banner_2">
                            <a class="wsus__single_banner_img"
                               href="{{ @$homepage_section_banner_two->banner_two->banner_url }}">
                                <img src="{{ asset(@$homepage_section_banner_two->banner_two->banner_image) }}"
                                     alt="banner" class="img-fluid w-100">
                            </a>
                            @if ( @$homepage_section_banner_two->banner_two->leading_text
                                || @$homepage_section_banner_two->banner_two->followup_text
                                || @$homepage_section_banner_two->banner_two->button_text )
                                <div class="wsus__single_banner_text">
                                    @if ( @$homepage_section_banner_two->banner_two->leading_text )
                                        <h6>{{ @$homepage_section_banner_two->banner_two->leading_text }}</h6>
                                    @endif
                                    @if ( @$homepage_section_banner_two->banner_two->followup_text )
                                        <h3>{{ @$homepage_section_banner_two->banner_two->followup_text }}</h3>
                                    @endif
                                    @if ( @$homepage_section_banner_two->banner_two->button_text )
                                        <a class="shop_btn" href="{{
                                        @$homepage_section_banner_two->banner_two->banner_url }}">{{
                                        @$homepage_section_banner_two->banner_two->button_text }}</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endif
