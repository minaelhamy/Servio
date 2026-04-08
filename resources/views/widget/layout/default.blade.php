<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ helper::appdata($vendordata->id)->web_title }}</title>
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/bootstrap/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/webfonts/css/all.min.css') }}" />
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/calander/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'widget_asstes/css/style.css') }}" />
    <link rel="icon" type="image" sizes="16x16"
        href="{{ helper::image_path(helper::appdata($vendordata->id)->favicon) }}"><!-- Favicon icon -->
    @if (helper::appdata($vendordata->id)->frame_color == '' || helper::appdata($vendordata->id)->frame_color == null)
        <style>
            :root {
                /* Color */

                --bs-primary: #19A7CE;
            }
        </style>
    @else
        <style>
            :root {
                /* Color */

                --bs-primary: {{ helper::appdata($vendordata->id)->frame_color }};
                --bs-secondary: {{ helper::appdata($vendordata->id)->frame_secondarycolor }};
            }
        </style>
    @endif

    @yield('styles')
</head>

<body>
    <!-- pre-loader section -->
    <div class="container">
        <div class="mian-card card">
            <div class="wizard-card">
                @include('widget.layout.sidebar')
                <div class="col-md-8 col-lg-9 col-12 right-side">
                    <!-- pre-loader section -->
                    <div id="preload" class="bg-light">
                        <div id="loader" class="loader">
                            <div class="loader-container">
                                <div class="loader-icon"><img
                                        src="{{ helper::image_path(helper::appdata($vendordata->id)->frame_logo) }}"
                                        alt="Swipy">
                                </div>
                            </div>
                        </div>
                    </div>
                    @yield('content')

                </div>
            </div>
        </div>
    </div>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/bootstrap/bootstrap.bundle.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/calander/moment.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/calander/fullcalendar.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/toastr/toastr.min.js') }}"></script><!-- Toastr JS -->
    <script>
        toastr.options = {
            "closeButton": true,
        }
        @if (Session::has('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if (Session::has('error'))
            toastr.error("{{ session('error') }}");
        @endif
        $(window).on("load", function() {

            "use strict";

            setTimeout(removeLoader, 2000); //wait for page load PLUS two seconds.

        });

        function removeLoader() {

            "use strict";

            $("#preload").fadeOut(500);

        }
    </script>
    @yield('scripts')
</body>

</html>
