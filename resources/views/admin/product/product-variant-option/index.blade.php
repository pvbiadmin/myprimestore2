@extends( 'admin.layouts.master' )

@section( 'content' )
    <section class="section">
        <div class="section-header">
            <h1>Manage Product Variant Option</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Admin</a></div>
                <div class="breadcrumb-item"><a href="#">Product Variant Options</a></div>
                <div class="breadcrumb-item"></div>
            </div>
        </div>
        <div class="mb-3">
            <a href="{{ route('admin.products-variant.index', ['product' => $product->id]) }}"
               class="btn btn-primary">Back</a>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Variant: {{ ucwords($variant->name) }}</h4>
                            <div class="card-header-action">
                                <a href="{{ route('admin.products-variant-option.create', [
                                    'productId' => $product->id,
                                    'variantId' => $variant->id
                                ]) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create New</a>
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
        const variantOptionToggle = (cl_target, url_route) => {
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

        variantOptionToggle(".change-status", "{{ route('admin.products-variant-option.change-status') }}");
        variantOptionToggle(".change-is-default", "{{ route('admin.products-variant-option.change-is-default') }}");
    </script>
@endpush
