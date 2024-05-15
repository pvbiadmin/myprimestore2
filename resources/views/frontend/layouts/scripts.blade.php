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
            $(".auto_click").click();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

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

            const removeSidebarCartItem = () => {
                $("body").on("click", ".remove_sidebar_item", e => {
                    e.preventDefault();

                    const $this = $(e.currentTarget);
                    const rowId = $this.data("row-id");

                    $.ajax({
                        url: "{{ route('cart.sidebar.remove-product') }}",
                        method: "POST",
                        data: {
                            rowId: rowId
                        },
                        success: response => {
                            $("#mini-cart-" + rowId).remove();

                            getSidebarCartSubtotal();

                            const cl_mini_cart_wrapper = $(".mini_cart_wrapper");

                            if (cl_mini_cart_wrapper.find('li').length === 0) {
                                cl_mini_cart_wrapper.html(`
                                        <div class="col-xl-6 col-md-10 col-lg-8 col-xxl-5 m-auto">
                                            <div class="wsus__404_text">
                                                <p>Cart is Empty.</p>
                                            </div>
                                        </div>
                                    `);

                                $(".cart-count").addClass("d-none");
                                $(".mini-cart-actions").addClass("d-none");
                            }

                            if (response.status === "success") {
                                toastr.success(response.message);
                            }
                        },
                        error: (xhr, status, error) => {
                            console.log(error);
                        }
                    });
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

            const addToWishlist = () => {
                $("body").on("click", ".add-wishlist", e => {
                    e.preventDefault();

                    const $this = $(e.currentTarget);

                    const productId = $this.data("id");

                    $.ajax({
                        url: "{{ route('wishlist.store') }}",
                        method: "GET",
                        data: {productId: productId},
                        success: response => {
                            if (response.status === "success") {
                                const clWishlistCount = $(".wishlist-count");
                                clWishlistCount.removeClass("d-none");
                                clWishlistCount.text(response.count);
                                toastr.success(response.message);
                            } else if (response.status === "info") {
                                toastr.info(response.message);
                            } else if (response.status === "error") {
                                toastr.error(response.message);
                            }
                        },
                        error: (xhr, status, error) => {
                            console.log(error);
                        }
                    });
                });
            };

            const toggleReadMore = (handle, minThreshold = 0) => {
                let minChars = Infinity;

                const target = ".show-read-more-" + handle;
                const targetSelect = $(target);

                targetSelect.each((index, element) => {
                    const text = $(element).text().trim();
                    const numChars = text.length;

                    if (minThreshold > 0 && numChars < minThreshold) {
                        minChars = minThreshold;
                    } else if (numChars < minChars) {
                        minChars = numChars;
                    }
                });

                targetSelect.each((index, element) => {
                    const text = $(element).text().trim();
                    const numChars = text.length;
                    const maxChars = minChars;

                    if (numChars > maxChars) {
                        const newContent = text.slice(0, maxChars);
                        const remainingContent = text.slice(maxChars);

                        $(element).empty().text(newContent);
                        $(element).append('<span class="more-text-' + handle
                            + '" style="display: none;">' + remainingContent + '</span>');
                        $(element).append(' <a href="javascript:" class="read-more-'
                            + handle + '" style="all: unset;">...(+)</a>');
                    }
                });

                $(document).on("click", ".read-more-" + handle, event => {
                    const clMoreText = ".more-text-" + handle;
                    const $moreText = $(event.currentTarget).siblings(clMoreText);

                    if ($moreText.is(":visible")) {
                        $moreText.hide();
                        $(event.currentTarget).text("...(+)");
                    } else {
                        $moreText.show();
                        $(event.currentTarget).text("...(-)");
                    }
                });
            }

            $('#newsletter').on('submit', e => {
                e.preventDefault();
                const $this = $(e.currentTarget);
                let data = $this.serialize();

                const $subscribeBtn = $('.subscribe_btn');

                $.ajax({
                    method: 'POST',
                    url: "{{ route('newsletter-request') }}",
                    data: data,
                    beforeSend: () => {
                        $subscribeBtn.text('Loading...');
                        $subscribeBtn.attr('disabled', true);
                    },
                    success: response => {
                        if (response.status === 'success') {
                            $('.subscribe_btn').text('Subscribe');
                            $('.newsletter_email').val('');

                            toastr.success(response.message);
                        } else if (response.status === 'error') {
                            $('.subscribe_btn').text('Subscribe');

                            toastr.error(response.message);
                        }
                    },
                    error: (xhr, status, error) => {
                        console.log(error);

                        $('.subscribe_btn').text('Subscribe');
                    }
                })
            });

            addToCart();
            removeSidebarCartItem();
            addToWishlist();
            toggleReadMore("flash-sale", 17);
            toggleReadMore("flash-sale-modal-description", 33);
            toggleReadMore("flash-sale-page", 17);
            toggleReadMore("product-type", 17);
            toggleReadMore("top-product", 17);
            toggleReadMore("product-slider1", 17);
            toggleReadMore("product-slider2", 17);
            toggleReadMore("product-slider3", 17);
            toggleReadMore("product-page", 17);
        });
    })(jQuery);
</script>
