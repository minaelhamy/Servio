<!DOCTYPE html>

<html lang="en" dir="{{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <meta property="og:title" content="{{ helper::appdata('')->meta_title }}" />

    <meta property="og:description" content="{{ helper::appdata('')->meta_description }}" />

    <meta property="og:image" content="{{ helper::image_path(helper::appdata('')->og_image) }}" />

    <title>{{ helper::appdata('')->web_title }}</title>

    @if (Auth::user()->type == 4)
        <link rel="icon" type="image" sizes="16x16"
            href="{{ helper::image_path(@helper::appdata('')->favicon) }}"><!-- Favicon icon -->
    @else
        <link rel="icon" type="image" sizes="16x16"
            href="{{ helper::image_path(@helper::appdata('')->favicon) }}"><!-- Favicon icon -->
    @endif
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/bootstrap/bootstrap.min.css') }}">
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/fontawesome/all.min.css') }}">
    <!-- FontAwesome CSS -->

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/toastr/toastr.min.css') }}">

    <!-- Toastr CSS -->

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/sweetalert/sweetalert2.min.css') }}">

    <!-- Sweetalert CSS -->

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/style.css') }}"><!-- Custom CSS -->

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/responsive.css') }}">

    <!-- Responsive CSS -->
    <style>
        :root {
            /* Color */
            --bs-primary: {{ helper::appdata('')->primary_color }};
            --bs-secondary: {{ helper::appdata('')->secondary_color }};
        }
    </style>
</head>

<body>
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
    @endphp
    @yield('content')


    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/jquery/jquery.min.js') }}"></script><!-- jQuery JS -->

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script><!-- Bootstrap JS -->
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/toastr/toastr.min.js') }}"></script><!-- Toastr JS -->

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/sweetalert/sweetalert2.min.js') }}"></script><!-- Sweetalert JS -->

    <script>
        var are_you_sure = "{{ trans('messages.are_you_sure') }}";
        var yes = "{{ trans('messages.yes') }}";
        var no = "{{ trans('messages.no') }}";
        var wrong = "{{ trans('messages.wrong') }}";
        var time_format = "{{ helper::appdata($vendor_id)->time_format }}";
        toastr.options = {
            "closeButton": true,
        }

        @if (Session::has('success'))
            toastr.success("{{ session('success') }}", "Success");
        @endif

        @if (Session::has('error'))
            toastr.error("{{ session('error') }}", "Error");
        @endif
        @if (Auth::user()->type == 2)
            // New Notification
            var noticount = 0;
            var notificationurl = "{{ URL::to('/admin/getorder') }}";
            var vendoraudio =
                "{{ url(env('ASSETPATHURL') . 'admin-assets/notification/' . helper::appdata(Auth::user()->id)->notification_sound) }}";
        @endif
    </script>
    @if (@helper::checkaddons('notification'))
        @if (Auth::user()->type == 2)
            <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/sound.js') }}"></script>
        @endif
    @endif
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/jquery/jquery-ui.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/common.js') }}"></script><!-- Common JS -->
    @yield('scripts')

</body>

</html>
