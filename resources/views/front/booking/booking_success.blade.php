<!DOCTYPE html>
<html lang="en" dir="" class="light">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/bootstrap/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/webfonts/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/owl-carousel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/style.css') }}" />
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/responsive.css') }}">
    <link rel="icon" type="image" sizes="16x16"
        href="{{ helper::image_path(helper::appdata($vendordata->id)->favicon) }}"><!-- Favicon icon -->
    <title>{{ helper::appdata($vendordata->id)->web_title }}</title>
    <style>
        :root {
            --bs-primary: {{ helper::appdata($vendordata->id)->primary_color }};
        }
    </style>
</head>

<body>
    @php
        $user = App\Models\User::where('id', $vdata)->first();
        if ($vendor_slug) {
            $ordersuccess = $vendor_slug . '/order-success-*';
            $success = $vendor_slug . '/success-*';
        } else {
            $ordersuccess = 'order-success-*';
            $success = 'success-*';
        }
    @endphp

    <!-- new order design -->
    <section>
        <div class="container">
            <div class="dive">
                <div class="col-md-8  m-auto">
                    <div class="order-success-img my-4">
                        <img src="{{ helper::image_path(helper::appdata($vendordata->id)->order_success_image) }}"
                            alt="" class="logo-image">
                    </div>
                    @if (request()->is($ordersuccess))
                        <h2 class="mb-4 order-title text-center color-changer">
                            {{ trans('labels.order_placed_succesfully') }} 🎉
                        </h2>
                    @elseif (request()->is($success))
                        <h2 class="mb-4 order-title text-center color-changer">
                            {{ trans('labels.booking_placed_succesfully') }} 🎉
                        </h2>
                    @endif
                    <div class="col-12">
                        <div class="row g-3 align-items-center  mb-3">
                            <div class="col-lg-10 col-md-9">
                                <div class="input-group rounded overflow-hidden border">
                                    <span class="input-group-text bg-white border-0" id="basic-addon1">
                                        <i class="fa-solid fa-link fs-5"></i>
                                    </span>
                                    @if (request()->is($ordersuccess))
                                        <input type="text" class="form-control px-2 border-0"
                                            aria-describedby="basic-addon1" id="myInput" type="text"
                                            value="{{ URL::to($vendor_slug . '/order/' . $booking_number) }}" readonly>
                                    @elseif (request()->is($success))
                                        <input type="text" class="form-control px-2 border-0"
                                            aria-describedby="basic-addon1" id="myInput" type="text"
                                            value="{{ URL::to($vendor_slug . '/booking/' . $booking_number) }}"
                                            readonly>
                                    @endif
                                </div>
                            </div>
                            <!-- Copy btn -->
                            <div class="col-lg-2 col-md-3 d-grid">
                                <button onclick="copyText()" class="copy-btn w-100 btn-submit rounded m-0"
                                    id="myTooltip">{{ trans('labels.copy') }}</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12">
                        <div class="col-12">
                            <div class="row g-3">
                                @php
                                    if (request()->is($ordersuccess)) {
                                        $class = 'col-lg-4 col-sm-7';
                                    } elseif (request()->is($success)) {
                                        $class = 'col-lg-4 col-sm-7';
                                    }

                                @endphp
                                <div class="{{ @$class }}">
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('whatsapp_message'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vdata)
                                                    ->orderByDesc('id')
                                                    ->first();

                                                if (@$user->allow_without_subscription == 1) {
                                                    $whatsapp_message = 1;
                                                } else {
                                                    $whatsapp_message = @$checkplan->whatsapp_message;
                                                }
                                            @endphp
                                            @if (
                                                $whatsapp_message == 1 && request()->is($ordersuccess)
                                                    ? @whatsapp_helper::whatsapp_message_config($vendordata->id)->product_order_created == 1
                                                    : @whatsapp_helper::whatsapp_message_config($vendordata->id)->order_created == 1)
                                                @if (whatsapp_helper::whatsapp_message_config($vendordata->id)->message_type == 2)
                                                    <a href="https://api.whatsapp.com/send?phone={{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number }}&text={{ $whmessage }}"
                                                        class="btn d-flex gap-1 justify-content-center w-100 order-btn btn-whatsaap btn-submit rounded m-0"
                                                        target="_blank">
                                                        <i class="fab fa-whatsapp"></i>
                                                        {{ trans('labels.whatsapp_message') }}
                                                    </a>
                                                @endif
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('whatsapp_message'))
                                            @if (request()->is($ordersuccess)
                                                    ? @whatsapp_helper::whatsapp_message_config($vendordata->id)->product_order_created == 1
                                                    : @whatsapp_helper::whatsapp_message_config($vendordata->id)->order_created == 1)
                                                @if (whatsapp_helper::whatsapp_message_config($vendordata->id)->message_type == 2)
                                                    <a href="https://api.whatsapp.com/send?phone={{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number }}&text={{ $whmessage }}"
                                                        class="btn order-btn btn-whatsaap justify-content-center btn-submit w-100 d-flex gap-1 rounded m-0"
                                                        target="_blank">
                                                        <i class="fab fa-whatsapp"></i>
                                                        {{ trans('labels.whatsapp_message') }}
                                                    </a>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                </div>
                                <div class="{{ @$class }}">
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('telegram_message'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vdata)
                                                    ->orderByDesc('id')
                                                    ->first();

                                                if (@$user->allow_without_subscription == 1) {
                                                    $telegram_message = 1;
                                                } else {
                                                    $telegram_message = @$checkplan->telegram_message;
                                                }
                                            @endphp
                                            @if (
                                                $telegram_message == 1 && request()->is($ordersuccess)
                                                    ? @helper::telegramdata($vendordata->id)->product_order_created == 1
                                                    : @helper::telegramdata($vendordata->id)->order_created == 1)
                                                <a href="{{ request()->is($ordersuccess) ? URL::to($vendordata->slug . '/ordertelegram/' . $booking_number) : URL::to($vendordata->slug . '/telegram/' . $booking_number) }}"
                                                    class="btn order-btn btn-telegram w-100 d-flex justify-content-center gap-1 btn-submit rounded m-0">
                                                    <i class="fab fa-telegram"></i>
                                                    {{ trans('labels.telegram_message') }}
                                                </a>
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('telegram_message'))
                                            @if (request()->is($ordersuccess)
                                                    ? @helper::telegramdata($vendordata->id)->product_order_created == 1
                                                    : @helper::telegramdata($vendordata->id)->order_created == 1)
                                                <a href="{{ request()->is($ordersuccess) ? URL::to($vendordata->slug . '/ordertelegram/' . $booking_number) : URL::to($vendordata->slug . '/telegram/' . $booking_number) }}"
                                                    class="btn order-btn btn-telegram w-100 d-flex justify-content-center gap-1 btn-submit rounded m-0">
                                                    <i class="fab fa-telegram"></i>
                                                    {{ trans('labels.telegram_message') }}
                                                </a>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                                <div class="{{ @$class }}">
                                    <a href="{{ URL::to($vendordata->slug) }}"
                                        class="btn shop-btn btn-home w-100 d-flex gap-1 justify-content-center btn-submit rounded">
                                        <i class="fa-solid fa-home"></i> {{ trans('labels.continue_to_home') }}
                                    </a>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                     <div class="col-xl-12 col-lg-12">
                        <div class="col-12">
                            <div class="row g-3">
                                 @php
                                    if (request()->is($ordersuccess)) {
                                        $class = 'col-lg-4 col-sm-6';
                                    } elseif (request()->is($success)) {
                                        $class = 'col-lg-4 col-sm-7';
                                    }

                                @endphp
                                @if (!request()->is(@$ordersuccess))
                                    @if (@helper::checkaddons('ical_export'))
                                        <div class="{{ @$class }}">
                                            <a  href="{{ URL::to($vendordata->slug . '/icalfile-' . $booking_number . '/' . $vendordata->id . '/2') }}"
                                                class="btn order-btn btn-ical btn-submit d-flex justify-content-center gap-1">
                                                <i class="fa-solid fa-download"></i> {{ trans('labels.download_ical_file') }}
                                            </a>
                                        </div>
                                    @endif
                                
                                    <div class="{{ @$class }}">
                                        @if (@helper::checkaddons('subscription'))
                                            @if (@helper::checkaddons('google_calendar'))
                                                @php
                                                    $checkplan = App\Models\Transaction::where(
                                                        'vendor_id',
                                                        $vdata,
                                                    )
                                                        ->orderByDesc('id')
                                                        ->first();

                                                    if (@$user->allow_without_subscription == 1) {
                                                        $calendar = 1;
                                                    } else {
                                                        $calendar = @$checkplan->calendar;
                                                    }
                                                @endphp
                                                @if ($calendar == 1)
                                                    <a href="{{ URL::to($vendordata->slug . '/googlesync-' . $booking_number . '/' . $vendordata->id . '/2') }}"
                                                        class="btn order-btn btn-danger btn-submit w-100 justify-content-center d-flex gap-1 rounded m-0">
                                                        <i class="fab fa-duotone fa-calendar-days"></i>
                                                        {{ trans('labels.google_calendar') }}
                                                    </a>
                                                @endif
                                            @endif
                                        @else
                                            @if (@helper::checkaddons('google_calendar'))
                                                <a href="{{ URL::to($vendordata->slug . '/googlesync-' . $booking_number . '/' . $vendordata->id . '/2') }}"
                                                    class="btn order-btn btn-danger btn-submit d-flex justify-content-center gap-1">
                                                    <i class="fab fa-duotone fa-calendar-days"></i>
                                                    {{ trans('labels.google_calendar') }}
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                @endif               
                            </div>
                        </div>
                     </div>
                </div>
            </div>
        </div>
    </section>
    <!-- new order design -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/jquery/jquery.min.js') }}"></script><!-- jQuery JS -->
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/bootstrap/bootstrap.bundle.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/owl.carousel.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/booking.js') }}"></script>
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

        function copyText() {
            "use strict";
            var copyText = document.getElementById("myInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            var tooltip = document.getElementById("myTooltip");
            tooltip.innerHTML = "Copied";
        }
    </script>
</body>

</html>
