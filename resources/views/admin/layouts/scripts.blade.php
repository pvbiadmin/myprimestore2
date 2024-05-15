<script>
    @if ( $errors->any() )
    @foreach ( $errors->all() as $error )
    toastr.error("{{ $error }}")
    @endforeach
    @endif
</script>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
</script>

<script>
    @if( Session::has('message') )

    const type = "{{ Session::get('alert-type', 'success') }}";

    switch (type) {
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }

    @endif
</script>

<!-- Dynamic Delete Alert -->
<script>
    ($ => {
        $(() => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("body").on("click", ".delete-item", e => {
                e.preventDefault();

                const $this = $(e.currentTarget);
                const deleteUrl = $this.attr("href");

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: deleteUrl,
                            success: res => {
                                if (res.status === "success") {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: res.message,
                                        icon: "success"
                                    });

                                    window.location.reload();
                                } else if (res.status === "error") {
                                    Swal.fire({
                                        title: "Can't Be Deleted!",
                                        text: res.message,
                                        icon: "error"
                                    });
                                }
                            },
                            error: function (xhr, status, error) {
                                console.log(error);
                            }
                        });
                    }
                });
            })
        });
    })(jQuery);
</script>
