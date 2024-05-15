@extends ( 'admin.layouts.master' )

@section ( 'content' )
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Advertisement Settings</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="list-group" id="list-tab" role="tablist">
                                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                                           id="homepage_section_banner_one" href="#homepage-banner-one"
                                           role="tab">Homepage Banner Section 1</a>
                                        <a class="list-group-item list-group-item-action" data-toggle="list"
                                           id="homepage_section_banner_two" href="#homepage-banner-two"
                                           role="tab">Homepage Banner Section 2</a>
                                        <a class="list-group-item list-group-item-action" data-toggle="list"
                                           id="homepage_section_banner_three" href="#homepage-banner-three"
                                           role="tab">Homepage Banner Section 3</a>
                                        <a class="list-group-item list-group-item-action" data-toggle="list"
                                           id="homepage_section_banner_four" href="#homepage-banner-four"
                                           role="tab">Homepage Banner Section 4</a>
                                        <a class="list-group-item list-group-item-action"
                                           id="product_page_banner_section" data-toggle="list"
                                           href="#product" role="tab">Product Page Banner</a>
                                        <a class="list-group-item list-group-item-action"
                                           id="cart_page_banner_section" data-toggle="list"
                                           href="#cart" role="tab">Cart Page Banner</a>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="tab-content" id="nav-tabContent">

                                        @include('admin.advertisement.sections.homepage-banner-one')

                                        @include('admin.advertisement.sections.homepage-banner-two')

                                        @include('admin.advertisement.sections.homepage-banner-three')

                                        @include('admin.advertisement.sections.homepage-banner-four')

                                        @include('admin.advertisement.sections.product-page-banner')

                                        @include('admin.advertisement.sections.cart-page-banner')

                                    </div>
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
        ($ => {
            $(() => {
                const anchorLinkTab = () => {
                    @if( Session::has('anchor') )

                    let linkId = '#homepage_section_banner_one';

                    switch ("{{ Session::get('anchor', 'homepage_section_banner_one') }}") {
                        case 'homepage_section_banner_two':
                            linkId = '#homepage_section_banner_two';
                            break;
                        case 'homepage_section_banner_three':
                            linkId = '#homepage_section_banner_three';
                            break;
                        case 'homepage_section_banner_four':
                            linkId = '#homepage_section_banner_four';
                            break;
                        case 'product_page_banner_section':
                            linkId = '#product_page_banner_section';
                            break;
                        case 'cart_page_banner_section':
                            linkId = '#cart_page_banner_section';
                            break;
                    }

                    const anchorLink = $(linkId);

                    if (anchorLink.length) {
                        anchorLink.tab('show');
                        anchorLink.click();
                    }

                    @endif
                };

                anchorLinkTab();
            });
        })(jQuery);
    </script>
@endpush
