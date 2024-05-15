@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Manage Settings</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Admin</a></div>
                <div class="breadcrumb-item"><a href="#">Manage Settings</a></div>
                <div class="breadcrumb-item">General Settings</div>
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
                                           id="list-home-list" data-toggle="list" href="#list-home"
                                           role="tab">General Setting</a>
                                        <a class="list-group-item list-group-item-action" id="list-email-config"
                                           data-toggle="list" href="#email-config" role="tab">
                                            Email Configuration</a>
                                        <a class="list-group-item list-group-item-action"
                                           id="list-logo-setting" data-toggle="list" href="#logo-setting"
                                           role="tab">Logo and Favicon</a>
                                        <a class="list-group-item list-group-item-action"
                                           id="list-pusher-setting" data-toggle="list" href="#list-pusher"
                                           role="tab">Pusher Setting</a>
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="tab-content" id="nav-tabContent">
                                        @include( 'admin.setting.general-setting' )
                                        @include( 'admin.setting.email-configuration' )
                                        @include( 'admin.setting.logo-setting' )
                                        @include( 'admin.setting.pusher-setting' )
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
                    anchor = "{{ Session::get('anchor', 'list-email-config') }}"
                ) => {
                    @if( Session::has('anchor') )

                    let linkId = '#list-email-config';

                    switch (anchor) {
                        case 'list-email-config':
                            linkId = '#list-email-config';
                            break;
                        case 'list-logo-setting':
                            linkId = '#list-logo-setting';
                            break;
                        case 'list-pusher-setting':
                            linkId = '#list-pusher-setting';
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
