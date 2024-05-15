@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Manage Home Page Settings</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Admin</a></div>
                <div class="breadcrumb-item"><a href="#">Manage Home Page Settings</a></div>
                <div class="breadcrumb-item">Home Page Settings</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3">
                                    <div class="list-group" id="list-tab" role="tablist">
                                        <a class="list-group-item list-group-item-action active"
                                           id="popular-category-product-list" data-toggle="list"
                                           href="#popular-category-product" role="tab">Popular Categories</a>
                                        <a class="list-group-item list-group-item-action"
                                           id="list-category-product-slider-1" data-toggle="list"
                                           href="#category-product-slider-1" role="tab">
                                            Category Product Slider</a>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="tab-content" id="nav-tabContent">
                                        @include( 'admin.home-page-settings.sections.popular-category' )
                                        @include( 'admin.home-page-settings.sections.category-product-slider-1' )
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

                    let linkId = '#list-category-product-slider-1';

                    switch ("{{ Session::get('anchor', 'list-category-product-slider-1') }}") {
                        case 'list-category-product-slider-1':
                            linkId = '#list-category-product-slider-1';
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
