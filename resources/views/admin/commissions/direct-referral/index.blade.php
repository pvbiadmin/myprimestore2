@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Direct Referral Settings</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Admin</a></div>
                <div class="breadcrumb-item"><a href="#">Manage Direct Referral</a></div>
                <div class="breadcrumb-item">Direct Referral Settings</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4><a href="{{ route('admin.referral-code.view') }}" class="btn btn-primary"><i
                                        class="fas fa-code"></i> Referral Code</a></h4>
                            @if ( count($packages) > 0 )
                                <div class="card-header-action">
                                    <a href="{{ route('admin.referral.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Create New</a>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push( 'scripts' )
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        const changeStatus = (cl_target, url_route) => {
            ($ => {
                $(() => {
                    $("body").on("click", cl_target, e => {
                        const $this = $(e.currentTarget);
                        const isChecked = $this.is(':checked');
                        const idToggle = $this.data('id');

                        $.ajax({
                            url: url_route,
                            method: "PUT",
                            data: {
                                isChecked: isChecked,
                                idToggle: idToggle
                            },
                            success: res => {
                                toastr.success(res.message);
                            },
                            error: (xhr, status, error) => {
                                console.log(error);
                            }
                        });
                    });
                });
            })(jQuery);
        }

        changeStatus(".change-status", "{{ route('admin.referral.change-status' )}}");
    </script>
@endpush
