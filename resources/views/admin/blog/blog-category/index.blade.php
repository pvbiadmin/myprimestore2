@extends( 'admin.layouts.master' )

@section( 'content' )
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Blog Category</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All Blog Categories</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.blog-category.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Create New</a>
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
                        url: "{{ route('admin.blog-category.change-status') }}",
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
