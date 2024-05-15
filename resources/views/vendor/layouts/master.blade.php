<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="application-name" content="MyPrimeStore"/>
    <meta name="apple-mobile-web-app-title" content="MyPrimeStore"/>
    <meta name="theme-color" content="#0099cc"/>
    <meta name="msapplication-navbutton-color" content="#0099cc"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <link rel="apple-touch-icon" href="{{ asset('logo512.png') }}"/>
    <link rel="manifest" href="{{ asset('manifest.json') }}"/>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset($logo_setting->favicon) }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.nice-number.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/add_row_custon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/mobile_menu.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.exzoom.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/multiple-image-video.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/ranger_style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.classycountdown.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/venobox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/toastr.min.css') }}">
    {{--<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">--}}
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.dataTables.min.css') }}">
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">--}}
    {{--    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">--}}
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <!-- <link rel="stylesheet" href="css/rtl.css"> -->
    <link rel="stylesheet" href="{{ asset('frontend/css/pro.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/pro-v4-shims.min.css') }}">

    @if( $settings->site_layout === 'RTL' )
        <link rel="stylesheet" href="{{ asset('frontend/css/rtl.css') }}">
    @endif

    <script>
        window.USER = {
            id: "{{ auth()->user()->id }}",
            name: "{{ auth()->user()->name }}",
            image: "{{ asset(auth()->user()->image) }}"
        }

        window.PUSHER_SETTING = {
            key: "{{ $pusherSetting->pusher_key }}",
            cluster: "{{ $pusherSetting->pusher_cluster }}"
        }
    </script>
</head>

<body>


<!--=============================
  DASHBOARD MENU START
==============================-->
<div class="wsus__dashboard_menu">
    <div class="wsusd__dashboard_user">
        <img src="{{ asset(auth()->user()->image ?? 'frontend/images/profile.svg') }}"
             alt="{{ auth()->user()->name }}" class="img-fluid">
        <p>{{ auth()->user()->name }}</p>
    </div>
</div>
<!--=============================
  DASHBOARD MENU END
==============================-->


@yield( 'content' )


<!--============================
    SCROLL BUTTON START
  ==============================-->
<div class="wsus__scroll_btn">
    <i class="fas fa-chevron-up"></i>
</div>
<!--============================
  SCROLL BUTTON  END
==============================-->


<!--jquery library js-->
<script src="{{ asset('frontend/js/jquery-3.6.0.min.js') }}"></script>
<!--bootstrap js-->
<script src="{{ asset('frontend/js/bootstrap.bundle.min.js') }}"></script>
<!--font-awesome js-->
<script src="{{ asset('frontend/js/Font-Awesome.js') }}"></script>
<!--select2 js-->
<script src="{{ asset('frontend/js/select2.min.js') }}"></script>
<!--slick slider js-->
<script src="{{ asset('frontend/js/slick.min.js') }}"></script>
<!--simplyCountdown js-->
<script src="{{ asset('frontend/js/simplyCountdown.js') }}"></script>
<!--product zoomer js-->
<script src="{{ asset('frontend/js/jquery.exzoom.js') }}"></script>
<!--nice-number js-->
<script src="{{ asset('frontend/js/jquery.nice-number.min.js') }}"></script>
<!--counter js-->
<script src="{{ asset('frontend/js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.countup.min.js') }}"></script>
<!--add row js-->
<script src="{{ asset('frontend/js/add_row_custon.js') }}"></script>
<!--multiple-image-video js-->
<script src="{{ asset('frontend/js/multiple-image-video.js') }}"></script>
<!--sticky sidebar js-->
<script src="{{ asset('frontend/js/sticky_sidebar.js') }}"></script>
<!--price ranger js-->
<script src="{{ asset('frontend/js/ranger_jquery-ui.min.js') }}"></script>
<script src="{{ asset('frontend/js/ranger_slider.js') }}"></script>
<!--isotope js-->
<script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
<!--venobox js-->
<script src="{{ asset('frontend/js/venobox.min.js') }}"></script>
<!--classycountdown js-->
<script src="{{ asset('frontend/js/jquery.classycountdown.js') }}"></script>
<!--toastr js-->
<script src="{{ asset('frontend/js/toastr.min.js') }}"></script>
{{--<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>--}}

<script src="{{ asset('backend/assets/modules/summernote/summernote-bs4.js') }}"></script>

<script src="{{ asset('frontend/js/jquery.dataTables.min.js') }}"></script>
{{--<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>--}}

<script src="{{ asset('backend/assets/modules/moment.min.js') }}"></script>

<script src="{{ asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<script src="{{ asset('frontend/js/sweetalert2@11.js') }}"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>--}}

<!--main/custom js-->
<script src="{{ asset('frontend/js/main.js') }}"></script>

@include( 'vendor.layouts.scripts' )

@stack( 'scripts' )

@vite(['resources/js/app.js', 'resources/js/frontend.js'])
</body>

</html>
