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
    <!--================================== congratulations section sta ==================================-->
    <div class="container">
        <div class="mian-card card">
            <div class="wizard-card">
                <div class="congres">
                    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                        <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                    </svg>

                    <div class="text-center congrats">
                        <h5>#{{ $booking_number }}</h5>
                        <h2 class="mb-2">{{ trans('labels.success_title') }}!</h2>
                        <p class="fs-7 text-muted fwsemibold">{{ trans('labels.success_description') }}</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ URL::to('/' . $vendordata->slug . '/embedded') }}"
                                class="btn btn-primary next_button hov"><i class="fa-regular fa-house"></i></a>
                            <a href="https://api.whatsapp.com/send?phone={{ helper::appdata($vendordata->id)->whatsapp_number }}&text={{ $whmessage }}"
                                class="btn next_button bg-success hov"><i class="fa-brands fa-whatsapp"></i></a>
                            <a href="{{ URL::to('/' . $vendordata->slug . '/embedded/telegram/' . $booking_number . '') }}"
                                class="btn hov next_button bg-info"><i class="fab fa-telegram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--================================== congratulations section end ==================================-->
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/bootstrap/bootstrap.bundle.js') }}"></script>

</body>

</html>
