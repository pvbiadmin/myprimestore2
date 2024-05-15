<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>General Dashboard &mdash; MyPrimeStore</title>
    <link rel="icon" type="image/png" href="{{ asset($logo_setting->favicon) }}">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/toastr.min.css') }}">
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">--}}
    <link rel="stylesheet" href="{{ asset('frontend/css/jquery.dataTables.min.css') }}">
    {{--<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">--}}
    {{--    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">--}}
    <link rel="stylesheet"
          href="{{ asset('backend/assets/modules/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css') }}">

    @if( $settings->site_layout === 'RTL' )
        <link rel="stylesheet" href="{{ asset('backend/assets/css/rtl.css') }}">
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
<div id="app">
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
    @include( 'admin.layouts.navbar' )
    @include( 'admin.layouts.sidebar' )

    <!-- Main Content -->
        <div class="main-content">
            @yield( 'content' )
        </div>
        <footer class="main-footer">
            <div class="footer-left">
                Copyright &copy; {{ date('Y') }}
                <div class="bullet"></div>
                Prime Ventures Builder, Inc.
            </div>
            <div class="footer-right"></div>
        </footer>
    </div>
</div>

<!-- General JS Scripts -->
<script src="{{ asset('backend/assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/jquery.3.6.3.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/popper.js') }}"></script>
<script src="{{ asset('backend/assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('backend/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/stisla.js') }}"></script>

<!-- JS Libraries -->
<script src="{{ asset('backend/assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('backend/assets/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/chart.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('backend/assets/modules/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('backend/assets/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>--}}
<script src="{{ asset('frontend/js/jquery.dataTables.min.js') }}"></script>
{{--<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>--}}
{{--<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>--}}
<script src="{{ asset('frontend/js/sweetalert2@11.js') }}"></script>
<script src="{{ asset('backend/assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/flasher-toastr.min.js') }}"></script>
{{--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>--}}
<script src="{{ asset('backend/assets/modules/bootstrap-iconpicker/js/bootstrap-iconpicker.bundle.min.js') }}"></script>
<script src="{{ asset('backend/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>

<!-- Page Specific JS File -->
{{--<script src="{{ asset('backend/assets/js/page/index-0.js') }}"></script>--}}
<script src="{{ asset('backend/assets/js/page/forms-advanced-forms.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('backend/assets/js/scripts.js') }}"></script>
<script src="{{ asset('backend/assets/js/custom.js') }}"></script>

@include( 'admin.layouts.scripts' )

@stack( 'scripts' )

@vite(['resources/js/app.js', 'resources/js/admin.js'])
</body>
</html>
