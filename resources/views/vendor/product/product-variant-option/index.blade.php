@extends( 'vendor.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Product: Variant - Option
@endsection

@section( 'content' )
    <!--=============================
    DASHBOARD START
  ==============================-->
    <section id="wsus__dashboard">
        <div class="container-fluid">

            @include( 'vendor.layouts.sidebar' )

            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <div class="mb-3">
                            <a href="{{ route('vendor.products-variant.index', ['product' => $product->id]) }}"
                               class="btn btn-warning"><i class="fas fa-long-arrow-left"></i> Back</a>
                        </div>
                        <h3><i class="fas fa-box-open"></i> Product Variant Options</h3>
                        <h6>Variant: {{ ucwords($variant->name) }}</h6>
                        <div class="create_button">
                            <a href="{{ route('vendor.products-variant-option.create', [
                                'productId' => $product->id,
                                'variantId' => $variant->id
                            ]) }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create New</a>
                        </div>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">
                                {{ $dataTable->table() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--=============================
      DASHBOARD START
    ==============================-->
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

        variantOptionToggle(".change-status", "{{ route('vendor.products-variant-option.change-status') }}");
        variantOptionToggle(".change-is-default", "{{ route('vendor.products-variant-option.change-is-default') }}");
    </script>
@endpush

