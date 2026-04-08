<!DOCTYPE html>
<html lang="en" dir="{{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}" class="light">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta property="og:title" content="{{ helper::appdata($vendordata->id)->meta_title }}" />
    <meta property="og:description" content="{{ helper::appdata($vendordata->id)->meta_description }}" />
    <meta property="og:image" content='{{ helper::image_path(helper::appdata($vendordata->id)->og_image) }}' />

    <script>
        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.add('light');
        }
    </script>

    <title>{{ helper::appdata($vendordata->id)->web_title }}</title>
    <link rel="icon" type="image" sizes="16x16"
        href="{{ helper::image_path(helper::appdata($vendordata->id)->favicon) }}"><!-- Favicon icon -->
    <!-- Favicon icon -->
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/bootstrap/bootstrap.min.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/fontawesome/all.min.css') }}">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/toastr/toastr.min.css') }}">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/style.css') }}" />
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/responsive.css') }}">
    <!-- Responsive CSS -->
    <!-- IF VERSION 2  -->
    @if (helper::appdata('')->recaptcha_version == 'v2')
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif
    <!-- IF VERSION 3  -->
    @if (helper::appdata('')->recaptcha_version == 'v3')
        {!! RecaptchaV3::initJs() !!}
    @endif
    <style>
        :root {
            /* Color */
            --bs-primary: {{ helper::appdata($vendordata->id)->primary_color }};
            --bs-secondary: {{ helper::appdata($vendordata->id)->primary_color . '10' }};
        }
    </style>
</head>

<body>
    <main>
        @yield('content')
    </main>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/bootstrap/bootstrap.bundle.js') }}"></script>
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

    @yield('scripts')
</body>

</html>
