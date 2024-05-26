@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Manage Referral</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Admin</a></div>
                <div class="breadcrumb-item"><a href="#">Commissions</a></div>
                <div class="breadcrumb-item">Manage Referral</div>
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
                                           id="list-code-list" data-toggle="list" href="#list-code"
                                           role="tab">Referral Code</a>
                                        <a class="list-group-item list-group-item-action" id="list-settings-list"
                                           data-toggle="list" href="#list-settings" role="tab">Settings</a>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="tab-content" id="nav-tabContent">
                                        @include( 'admin.commissions.referral.referral-code' )
                                        @include( 'admin.commissions.referral.settings' )
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
                    anchor = "{{ Session::get('anchor', 'list-settings-list') }}"
                ) => {
                    @if( Session::has('anchor') )

                    let linkId = '#list-settings-list';

                    switch (anchor) {
                        case 'list-settings-list':
                            linkId = '#list-settings-list';
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
