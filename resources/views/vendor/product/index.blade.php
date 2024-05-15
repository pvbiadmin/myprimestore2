    @extends( 'vendor.layouts.master' )

@section( 'title' )
    {{ $settings->site_name }} || Product
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
                        <h3><i class="fas fa-box-open"></i> Products</h3>
                        <div class="create_button">
                            <a href="{{ route('vendor.products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create New</a>
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
        ($ => {
            $(() => {
                const changeStatus = () => {
                    $("body").on("click", ".change-status", e => {
                        const $this = $(e.currentTarget);
                        const isChecked = $this.is(':checked');
                        const idToggle = $this.data('id');

                        $.ajax({
                            url: "{{ route('vendor.product.change-status') }}",
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
                };

                const toggleFullText = (colName) => {
                    $(document).on("click", ".toggle-full-name", e => {
                        const $this = $(e.currentTarget);
                        const $truncatedSpan = $this.prev(".truncate_" + colName);
                        const truncatedText = $truncatedSpan.text();
                        const fullText = $truncatedSpan.data("full-text");

                        if (truncatedText === fullText) {
                            // Text is already full, truncate it
                            $truncatedSpan.text(truncatedText.substring(0, 20));
                            $this.text(" ... (+)");
                        } else {
                            // Text is truncated, reveal full text
                            $truncatedSpan.text(fullText);
                            $this.text(" (-)");
                        }
                    });
                }

                changeStatus();
                toggleFullText('name');
            });
        })(jQuery);
    </script>
@endpush
