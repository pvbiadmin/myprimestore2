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
    @if ( Session::has('message') )

    const type = "{{ Session::get('alert-type', 'success') }}";

    switch (type) {
        case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;

        case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;

        case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;

        case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break;
    }

    @endif
</script>

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

            const addToCart = () => {
                $("body").on("submit", ".cart-form", e => {
                    e.preventDefault();

                    const $this = $(e.currentTarget);
                    const formData = $this.serialize();

                    $.ajax({
                        url: "{{ route('add-to-cart') }}",
                        method: "POST",
                        data: formData,
                        success: res => {
                            if (res.status === "success") {
                                $(".cart-count").removeClass("d-none");
                                getCartCount();
                                getSidebarCartItems();
                                $(".mini-cart-actions").removeClass("d-none");
                                $(".view_cart_package").removeClass("d-none");
                                $(".cart-form").addClass("d-none");
                                toastr.success(res.message);
                            } else if (res.status === "error") {
                                toastr.error(res.message);
                            }
                        },
                        error: (xhr, status, error) => {
                            console.log(error);
                        }
                    });
                });
            };

            const getCartCount = () => {
                $.ajax({
                    url: "{{ route('cart-count') }}",
                    method: "GET",
                    success: response => {
                        $(".cart-count").text(response);
                    },
                    error: (xhr, status, error) => {
                        console.log(error);
                    }
                });
            };

            const formatFloat = (float) => {
                const parsedFloat = parseFloat(float);
                return parsedFloat.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            const getSidebarCartItems = () => {
                $.ajax({
                    url: "{{ route('cart-items') }}",
                    method: "GET",
                    success: response => {
                        // console.log(response);
                        const cl_mini_cart_wrapper = $(".mini_cart_wrapper");

                        cl_mini_cart_wrapper.html("");

                        let html = "";

                        for (let item in response) {
                            if (response.hasOwnProperty(item)) {
                                const {rowId, name, qty, price, options} = response[item];
                                const {variant_price_total, slug, image} = options;

                                const priceFormatted = formatFloat(price);
                                const variantPriceTotalFormatted = formatFloat(variant_price_total);

                                html += `<li id="mini-cart-${rowId}">
                                            <div class="wsus__cart_img">
                                                <a href="{{route('product-detail', '')}}/${slug}">
                                                    <img src="{{asset('')}}/${image}" alt="${name}"
                                                        class="img-fluid w-100"></a>
                                                <a class="wsis__del_icon remove_sidebar_item"
                                                    data-row-id="${rowId}" href="#">
                                                    <i class="fas fa-minus-circle"></i></a>
                                            </div>
                                            <div class="wsus__cart_text">
                                                <a class="wsus__cart_title"
                                                    href="{{route('product-detail', '')}}/${slug}">${name}</a>
                                                <p>{{$settings->currency_icon}}${priceFormatted}</p>`;
                                html += variantPriceTotalFormatted > 0 ? `<small>Add.: {{
                                                $settings->currency_icon}}${variantPriceTotalFormatted}
                                            </small><br>` : ``;
                                html += `<small>Qty: ${qty}</small>
                                            </div>
                                        </li>`;
                            }
                        }

                        cl_mini_cart_wrapper.html(html);
                        getSidebarCartSubtotal();
                    },
                    error: (xhr, status, error) => {
                        console.log(error);
                    }
                });
            };

            const getSidebarCartSubtotal = () => {
                $.ajax({
                    url: "{{ route('cart.sidebar.subtotal') }}",
                    method: "GET",
                    success: response => {
                        const responseFormatted = formatFloat(response);

                        $("#mini-cart-subtotal").text("{{$settings->currency_icon}}" + responseFormatted);
                    },
                    error: (xhr, status, error) => {
                        console.log(error);
                    }
                });
            };

            addToCart();
        });
    })(jQuery);
</script>
