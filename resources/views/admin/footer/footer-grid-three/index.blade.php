@extends ( 'admin.layouts.master' )

@section ( 'content' )
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Footer</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Footer Grid-3 Title</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.footer-grid-three.change-title') }}" method="POST">
                                @csrf
                                @method ( 'PUT' )
                                <div class="col-4">
                                    <div class="form-group d-flex">
                                        <input type="text" class="form-control" name="title" id="title"
                                               value="{{ @$footerTitle->footer_grid_three_title }}" aria-label="title">
                                        <button type="submit" class="btn btn-primary ml-4">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="section">

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Footer Grid-3 Item</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.footer-grid-three.create') }}" class="btn btn-primary"><i
                                        class="fas fa-plus"></i> Create New</a>
                            </div>
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
        ($ => {
            $(() => {
                $("body").on("click", ".change-status", e => {
                    const $this = $(e.currentTarget);
                    const isChecked = $this.is(':checked');
                    const idToggle = $this.data('id');

                    $.ajax({
                        url: "{{ route('admin.footer-grid-three.change-status') }}",
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
    </script>
@endpush
