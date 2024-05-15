@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Manage Payment Settings</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Admin</a></div>
                <div class="breadcrumb-item"><a href="#">Manage Payment Settings</a></div>
                <div class="breadcrumb-item">All Payment Settings</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-2">
                                    <div class="list-group" id="list-tab" role="tablist">
                                        <a class="list-group-item list-group-item-action active"
                                           id="list-paypal-list" data-toggle="list" href="#list-paypal"
                                           role="tab">Paypal</a>
                                        <a class="list-group-item list-group-item-action" id="list-cod-list"
                                           data-toggle="list" href="#list-cod" role="tab">COD</a>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="tab-content" id="nav-tabContent">
                                        @include( 'admin.payment-settings.paypal-setting' )
                                        @include( 'admin.payment-settings.cod-setting' )
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
                const anchorLinkTab = (
                    anchor = "{{ Session::get('anchor', 'list-paypal-list') }}"
                ) => {
                    @if( Session::has('anchor') )

                    let linkId = '#list-paypal-list';

                    switch (anchor) {
                        case 'list-paypal-list':
                            linkId = '#list-paypal-list';
                            break;
                        case 'list-cod-list':
                            linkId = '#list-cod-list';
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
