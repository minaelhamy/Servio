<!DOCTYPE html>

<html lang="en" dir="{{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}">



<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta property="og:title" content="{{ helper::appdata('')->meta_title }}" />

    <meta property="og:description" content="{{ helper::appdata('')->meta_description }}" />

    <meta property="og:image" content='{{ helper::image_path(helper::appdata('')->og_image) }}' />

    <title>{{ helper::appdata('')->web_title }}</title>

    <link rel="icon" type="image" sizes="16x16" href="{{ helper::image_path(helper::appdata('')->favicon) }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- Favicon icon -->

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/bootstrap/bootstrap.min.css') }}">

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/fontawesome/all.min.css') }}">

    <!-- FontAwesome CSS -->

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/toastr/toastr.min.css') }}">

    <!-- FontAwesome CSS -->

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/style.css') }}"><!-- Custom CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/hatchers-brand.css') }}">

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/responsive.css') }}">
    <style>
        :root {
            /* Color */
            --bs-primary: {{ helper::appdata('')->primary_color }};
            --bs-secondary: {{ helper::appdata('')->secondary_color }};
        }
    </style>
    <!-- Responsive CSS -->
    <!-- IF VERSION 2  -->
    @if (helper::appdata('')->recaptcha_version == 'v2')
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif
    <!-- IF VERSION 3  -->
    @if (helper::appdata('')->recaptcha_version == 'v3')
        {!! RecaptchaV3::initJs() !!}
    @endif
</head>



<body class="light">
    <main>

        @yield('content')

    </main>

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/jquery/jquery.min.js') }}"></script><!-- jQuery JS -->

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script><!-- Bootstrap JS -->

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/toastr/toastr.min.js') }}"></script><!-- Toastr JS -->





    <script>
        
        toastr.options = {

            "closeButton": true,

        }

        @if (Session::has('success'))

            toastr.success("{{ session('success') }}", "Success");
        @endif

        @if (Session::has('error'))

            toastr.error("{{ session('error') }}", "Error");
        @endif

        function myFunction() {
            "use strict";
            toastr.error("This operation was not performed due to demo mode");
            return false;
        }
    </script>

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/auth_default.js') }}"></script>

    @yield('scripts')

</body>



</html>
