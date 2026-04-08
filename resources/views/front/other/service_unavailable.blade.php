<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ helper::appdata($vendordata->id)->web_title }}</title>
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/bootstrap/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/style.css') }}" />
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/webfonts/css/all.min.css') }}" />
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'widget_asstes/css/style.css') }}" />
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
            }
        </style>
    @endif
    @yield('styles')
</head>
<body>
    <section class="wrong_page my-5">
        <div class="container">
            <div class="col-md-6 col-12 m-auto text-center">
                <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/other/unavailablepage.png')}}"
                    alt="" class="w-100 object-fit-cover">
                <h2 class="fw-semibold fs-1">{{ trans('labels.something_went_wrong') }}!</h2>
                <p class="text-muted">{{ trans('labels.service_unavailable_message') }}</p>
                <a href="{{URL::to('/'. $vendordata->slug)}}" class="btn btn-primary btn-submit rounded m-auto">{{ trans('labels.refresh_message') }}</a>
            </div>
        </div>
    </section>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/bootstrap/bootstrap.bundle.js') }}"></script>
</body>
</html>
