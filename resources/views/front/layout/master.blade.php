<!DOCTYPE html>


<html lang="en" dir="{{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}" class="light">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script>
        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.add('light');
        }
    </script>
    @if (request()->is($vendordata->slug . '/service-*'))
        <meta property="og:title" content="{{ @$service->name }}" />
        <meta property="og:description" content="{{ strip_tags(trim($service->description)) }}" />
        <meta property="og:image" content="{{ @helper::image_path($service['service_image']->image) }}" />
    @elseif (request()->is($vendordata->slug . '/blog-*'))
        <meta property="og:title" content="{{ @$blogdetail->title }}" />
        <meta property="og:description" content="{{ strip_tags(trim($blogdetail->description)) }}" />
        <meta property="og:image" content="{{ @helper::image_path(@$blogdetail->image) }}" />
    @else
        <meta property="og:title" content="{{ helper::appdata($vendordata->id)->meta_title }}" />
        <meta property="og:description" content="{{ helper::appdata($vendordata->id)->meta_description }}" />
        <meta property="og:image" content='{{ helper::image_path(helper::appdata($vendordata->id)->og_image) }}' />
    @endif


    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/bootstrap/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/bootstrap/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/webfonts/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/glightbox.css') }}"><!-- glightbox css -->

    {{-- google fonts --}}
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/font.css') }}" />
    {{-- google fonts --}}
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/sweetalert/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/owl-carousel/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/calander/fullcalendar.min.css') }}">
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/style.css') }}" />
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/responsive.css') }}">
    <link rel="stylesheet"
        href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/datatables/dataTables.bootstrap5.min.css') }}">
    <!-- wow animation css -->
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/css/wow.css') }}" />
    <link rel="icon" type="image" sizes="16x16"
        href="{{ helper::image_path(helper::appdata($vendordata->id)->favicon) }}"><!-- Favicon icon -->
    <title>{{ helper::appdata($vendordata->id)->web_title }}</title>

    @php
        $baseurl = url('/') . '/' . request()->vendor;

    @endphp

    @if (@helper::checkaddons('subscription'))
        @if (@helper::checkaddons('pixel'))
            @php
                $checkplan = App\Models\Transaction::where('vendor_id',$vdata)->orderByDesc('id')->first();
                $user = App\Models\User::where('id',$vdata)->first();
                if (@$user->allow_without_subscription == 1) {
                    $pixel = 1;
                } else {
                    $pixel = @$checkplan->pixel;
                }
            @endphp
            @if ($pixel == 1)
                @include('front.pixel.pixel')
            @endif
        @endif
    @else
        @if (@helper::checkaddons('pixel'))
            @include('front.pixel.pixel')
        @endif
    @endif
    <style>
        :root {
            --bs-primary: {{ helper::appdata($vendordata->id)->primary_color }};
            --bs-secondary: {{ helper::appdata($vendordata->id)->secondary_color }};

            @if (helper::appdata(@$vendordata->id)->theme == 5 && $baseurl == request()->url())
                --bs-theme-5-body: #202224;
            @endif
        }

        /* @if (session()->get('direction') == 2)
        .theme-5 .owl-nav {
            display: flex;
            justify-content: center;
            flex-direction: row-reverse;
        }
        @endif
        */
    </style>
    <!-- PWA  -->
    @if (@helper::checkaddons('subscription'))
        @if (@helper::checkaddons('pwa'))
            @php
                $checkplan = App\Models\Transaction::where('vendor_id',$vdata)->orderByDesc('id')->first();
                $user = App\Models\User::where('id',$vdata)->first();
                if (@$user->allow_without_subscription == 1) {
                    $pwa = 1;
                } else {
                    $pwa = @$checkplan->pwa;
                }
            @endphp

            @if ($pwa == 1)
                @if (helper::appdata($vendordata->id)->pwa == 1)
                    @include('front.pwa.pwa')
                @endif
            @endif
        @else
            @if (@helper::checkaddons('pwa'))
                @if (helper::appdata($vendordata->id)->pwa == 1)
                    @include('front.pwa.pwa')
                @endif
            @endif
        @endif
    @endif
    <!-- PWA  -->
    @yield('styles')
</head>

<body class="">
    <main id="main-content" class="blur">
        @include('front.layout.header')
        <div>
            @yield('content')
        </div>
        @include('front.layout.footer')

        {{-- product popup add --}}
        @if (@helper::checkaddons('sales_notification'))
            @if (helper::appdata($vendordata->id)->fake_sales_notification == 1)
                @include('front.sales_notification')
            @endif
        @endif

        @include('cookie-consent::index')

        <!------ whatsapp_icon ------>
        @if (@helper::checkaddons('subscription'))
            @if (@helper::checkaddons('whatsapp_message'))
                @php
                    $checkplan = App\Models\Transaction::where('vendor_id',$vdata)
                        ->orderByDesc('id')
                        ->first();
                    $user = App\Models\User::where('id',$vdata)->first();
                    if (@$user->allow_without_subscription == 1) {
                        $whatsapp_message = 1;
                    } else {
                        $whatsapp_message = @$checkplan->whatsapp_message;
                    }

                @endphp
                @if ($whatsapp_message == 1 && @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_chat_on_off == 1)
                    <div
                        class="{{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_mobile_view_on_off == 1 ? 'd-block' : 'd-lg-block d-none' }}">
                        <input type="checkbox" id="check">
                        <label
                            class="chat-btn {{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_chat_position == 1 ? 'chat-btn_rtl' : 'chat-btn_ltr' }}"
                            for="check">
                            <i class="fa-brands fa-whatsapp comment"></i>
                            <i class="fa fa-close close"></i>
                        </label>

                        <div
                            class="shadow {{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_chat_position == 1 ? 'wrapper_rtl' : 'wrapper_ltr' }}">
                            <div class="msg_header">
                                <h6>{{ helper::appdata(@$vendordata->id)->web_title }}</h6>
                            </div>

                            <div class="text-start p-3 bg-msg">
                                <div class="card p-2 msg d-inline-block fs-7">
                                    {{ trans('labels.how_can_help_you') }}
                                </div>
                            </div>

                            <div class="chat-form">

                                <form action="https://api.whatsapp.com/send" method="get" target="_blank"
                                    class="d-flex align-items-center d-grid gap-2">
                                    <textarea class="form-control m-0" name="text" placeholder="{{ trans('messages.your_text_message') }}"
                                        cols="30" rows="10" required></textarea>
                                    <input type="hidden" name="phone"
                                        value="{{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number }}">
                                    <button type="submit" class="btn btn-whatsapp btn-block m-0">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                @endif
            @endif
        @else
            @if (@helper::checkaddons('whatsapp_message'))
                @if (whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_chat_on_off == 1)
                    <div
                        class="{{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_mobile_view_on_off == 1 ? 'd-block' : 'd-lg-block d-none' }}">
                        <input type="checkbox" id="check">
                        <label
                            class="chat-btn {{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_chat_position == 1 ? 'chat-btn_rtl' : 'chat-btn_ltr' }}"
                            for="check">
                            <i class="fa-brands fa-whatsapp comment"></i>
                            <i class="fa fa-close close"></i>
                        </label>

                        <div
                            class="shadow {{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_chat_position == 1 ? 'wrapper_rtl' : 'wrapper_ltr' }}">
                            <div class="msg_header">
                                <h6>{{ helper::appdata(@$vendordata->id)->web_title }}</h6>
                            </div>

                            <div class="text-start p-3 bg-msg">
                                <div class="card p-2 msg d-inline-block fs-7 color-changer">
                                    {{ trans('labels.how_can_help_you') }}
                                </div>
                            </div>

                            <div class="chat-form bg-changer">
                                <form action="https://api.whatsapp.com/send" method="get" target="_blank"
                                    class="d-flex align-items-center d-grid gap-2">
                                    <textarea class="form-control m-0" name="text" placeholder="{{ trans('messages.your_text_message') }}"
                                        cols="30" rows="10" required></textarea>
                                    <input type="hidden" name="phone"
                                        value="{{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number }}">
                                    <button type="submit" class="btn btn-whatsapp btn-block m-0">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        @endif

        <!-- Quick call -->
        @if (@helper::checkaddons('quick_call'))
            @if (@helper::appdata($vendordata->id)->quick_call == 1)
                <div
                    class="{{ helper::appdata($vendordata->id)->quick_call_mobile_view_on_off == 1 ? 'd-block' : 'd-lg-block d-none' }}">
                    @include('front.quick_call')
                </div>
            @endif
        @endif
    </main>

    <!-- Age Verification -->
    @if (@helper::checkaddons('age_verification'))
        @if (@helper::getagedetails($vendordata->id)->age_verification_on_off == 1)
            @include('front.age_modal')
        @endif
    @endif

    <!--Start of Tawk.to Script-->
    @if (@helper::checkaddons('tawk_addons'))
        @if (helper::appdata($vendordata->id)->tawk_on_off == 1)
            {!! helper::appdata($vendordata->id)->tawk_widget_id !!}
        @endif
    @endif
    <!--End of Tawk.to Script-->

    <!-- Wizz Chat -->
    @if (@helper::checkaddons('wizz_chat'))
        @if (helper::appdata($vendordata->id)->wizz_chat_on_off == 1)
            {!! helper::appdata($vendordata->id)->wizz_chat_settings !!}
        @endif
    @endif


    @include('front.layout.models')


    <script src="{{ url(env('ASSETPATHURL') . 'front/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/bootstrap/bootstrap.bundle.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/bootstrap/bootstrap-select.min.js') }}"></script><!-- Bootstrap JS -->
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/owl.carousel.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/glightbox.js') }}"></script><!-- glightbox JS -->
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/owl.carousel.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/jquery.number.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/sweetalert/sweetalert2.min.js') }}"></script><!-- Sweetalert JS -->
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/toastr/toastr.min.js') }}"></script><!-- Toastr JS -->
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/sweetalert/sweetalert2.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/datatables/jquery.dataTables.min.js') }}"></script><!-- Datatables JS -->
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/datatables/dataTables.bootstrap5.min.js') }}"></script><!-- Datatables Bootstrap5 JS -->
    <!-- wow js -->
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/wow.min.js') }}"></script>
    <script>
        new WOW().init();

        // top deals parameter
        var start_date = "{{ @helper::top_deals($vendordata->id)->start_date }}";
        var start_time = "{{ @helper::top_deals($vendordata->id)->start_time }}";
        var end_date = "{{ @helper::top_deals($vendordata->id)->end_date }}";
        var end_time = "{{ @helper::top_deals($vendordata->id)->end_time }}";
        @if (App\Models\SystemAddons::where('unique_identifier', 'top_deals')->first() != null &&
                App\Models\SystemAddons::where('unique_identifier', 'top_deals')->first()->activated == 1)
            var enddate = "{{ @App\Models\TopDeals::where('vendor_id', $vendordata->id)->first()->end_date }}";
            var endtime = "{{ @App\Models\TopDeals::where('vendor_id', $vendordata->id)->first()->end_time }}";
        @else
            var enddate = null;
            var endtime = null;
        @endif
        var topdeals = "{{ !empty(helper::topdealitemlist($vendordata->id)) ? 1 : 0 }}";
        var time_zone = "{{ helper::appdata($vendordata->id)->timezone }}";
        var current_date = "{{ \Carbon\Carbon::now()->toDateString() }}";
        var deal_type = "{{ @helper::top_deals($vendordata->id)->deal_type }}";
        var siteurl = "{{ URL::to($vendordata->slug) }}";

        var are_you_sure = "{{ trans('messages.are_you_sure') }}";
        var yes = "{{ trans('messages.yes') }}";
        var no = "{{ trans('messages.no') }}";
        var wrong = "{{ trans('messages.wrong') }}";
        var is_logedin = {{ Auth::user() && Auth::user()->type == 3 ? 1 : 2 }};
        var loginurl = "{{ URL::to($vendordata->slug . '/login') }}";
        var customerlogin = {!! @helper::checkaddons('customer_login') ? @helper::checkaddons('customer_login') : 2 !!};
        var login_required = "{{ helper::appdata($vendordata->id)->checkout_login_required }}";
        var checkout_login_required = "{{ helper::appdata($vendordata->id)->is_checkout_login_required }}";
        var darklogo = "{{ helper::image_path(helper::appdata($vendordata->id)->darklogo) }}";
        var lightlogo = "{{ helper::image_path(helper::appdata($vendordata->id)->logo) }}";
        toastr.options = {
            "closeButton": true,
        }
        @if (Session::has('success'))
            toastr.success("{{ session('success') }}", "Success");
        @endif
        @if (Session::has('error'))
            toastr.error("{{ session('error') }}", "Error");
        @endif

        function currency_formate(price) {
            var price = price * {{ @helper::currencyinfo($vendordata->id)->exchange_rate }};
            if ("{{ @helper::currencyinfo($vendordata->id)->currency_position }}" == "1") {

                if ("{{ helper::currencyinfo($vendordata->id)->decimal_separator }}" == 1) {
                    var oldprice = $.number(price, "{{ helper::currencyinfo($vendordata->id)->currency_formate }}");
                    if ("{{ @helper::currencyinfo($vendordata->id)->currency_space }}" == 1) {
                        newprice = "{{ @helper::currencyinfo($vendordata->id)->currency }}" + ' ' + oldprice;
                    } else {
                        newprice = "{{ @helper::currencyinfo($vendordata->id)->currency }}" + oldprice;
                    }

                } else {
                    var oldprice = $.number(price, "{{ helper::currencyinfo($vendordata->id)->currency_formate }}", ',',
                        '.');
                    if ("{{ @helper::currencyinfo($vendordata->id)->currency_space }}" == 1) {
                        newprice = "{{ @helper::currencyinfo($vendordata->id)->currency }}" + ' ' + oldprice;
                    } else {

                        newprice = "{{ @helper::currencyinfo($vendordata->id)->currency }}" + oldprice;
                    }
                }
                return newprice;
            } else {
                if ("{{ helper::currencyinfo($vendordata->id)->decimal_separator }}" == 1) {
                    var oldprice = $.number(price, "{{ helper::currencyinfo($vendordata->id)->currency_formate }}");
                    if ("{{ @helper::currencyinfo($vendordata->id)->currency_space }}" == 1) {
                        newprice = oldprice + ' ' + "{{ @helper::currencyinfo($vendordata->id)->currency }}";
                    } else {
                        newprice = oldprice + "{{ @helper::currencyinfo($vendordata->id)->currency }}";
                    }

                } else {
                    var oldprice = $.number(price, "{{ helper::currencyinfo($vendordata->id)->currency_formate }}", ',',
                        '.');
                    if ("{{ @helper::currencyinfo($vendordata->id)->currency_space }}" == 1) {
                        newprice = oldprice + ' ' + "{{ @helper::currencyinfo($vendordata->id)->currency }}";
                    } else {
                        newprice = oldprice + "{{ @helper::currencyinfo($vendordata->id)->currency }}";
                    }
                }
                return newprice;
            }
        }
    </script>
    @if (@helper::checkaddons('sales_notification'))
        @if (helper::appdata($vendordata->id)->fake_sales_notification == 1)
            <script>
                // Select the element with the ID 'sales-booster-popup'
                const popup = document.getElementById('sales-booster-popup');

                if (popup) {
                    // Define a function to add and remove the 'loaded' class
                    let isMouseOver = false;
                    const toggleLoadedClass = () => {
                        // Add the 'loaded' class
                        popup.classList.add('loaded');
                        // Remove the 'loaded' class after 5 seconds, unless the mouse is over the popup
                        setTimeout(() => {
                                if (!isMouseOver) {
                                    popup.classList.remove('loaded');
                                }
                            },
                            "{{ helper::appdata($vendordata->id)->notification_display_time }}"
                        ); // 1000 milliseconds = 1 seconds for demo purposes
                    };

                    // Function to handle mouseover event
                    const handleMouseOver = () => {
                        isMouseOver = true;
                        // You can perform actions here when mouse is over the popup
                    };

                    // Function to handle mouseout event
                    const handleMouseOut = () => {
                        isMouseOver = false;
                    };

                    // Call the function initially
                    toggleLoadedClass();

                    // Set an interval to call the function every 8 seconds
                    setInterval(function() {
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: "{{ URL::to('get_notification_data') }}",

                                type: "post",
                                dataType: "json",
                                data: {
                                    vendor_id: "{{ $vendordata->id }}",
                                },
                                success: function(response) {
                                    toggleLoadedClass();
                                    $('#sales-booster-popup').show();
                                    $('#notification_body').html(response.output);
                                },
                            });
                        },
                        "{{ helper::appdata($vendordata->id)->notification_display_time + helper::appdata($vendordata->id)->next_time_popup }}"
                    ); // 1000 milliseconds = 1 seconds

                    // Add mouseover and mouseout event listeners to the popup
                    popup.addEventListener('mouseover', handleMouseOver);
                    popup.addEventListener('mouseout', handleMouseOut);

                    // Select the close button within the popup
                    const closeButton = popup.querySelector('.close'); // Close button selector

                    if (closeButton) {
                        // Add an event listener to the close button
                        closeButton.addEventListener('click', () => {
                            // Remove the 'loaded' class immediately
                            popup.classList.remove('loaded');
                        });
                    }
                }
            </script>
        @endif
    @endif
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/common.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/top_deals.js') }}"></script>
    @if (@helper::checkaddons('age_verification'))
        @if (@helper::getagedetails($vendordata->id)->age_verification_on_off == 1)
            <script src="{{ url('resources/js/age.js') }}"></script>
        @else
            <script>
                $('#main-content').removeClass('blur');
            </script>
        @endif
    @else
        <script>
            $('#main-content').removeClass('blur');
        </script>
    @endif
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ helper::appdata(1)->tracking_id }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '{{ helper::appdata(1)->tracking_id }}');
    </script>
    @if (@helper::checkaddons('subscription'))
        @if (@helper::checkaddons('pwa'))
            @php
                $checkplan = App\Models\Transaction::where('vendor_id',$vdata)->orderByDesc('id')->first();
                $user = App\Models\User::where('id',$vdata)->first();
                if (@$user->allow_without_subscription == 1) {
                    $pwa = 1;
                } else {
                    $pwa = @$checkplan->pwa;
                }
            @endphp
            @if ($pwa == 1)
                <script src="{{ url('storage/app/public/sw.js') }}"></script>
                <script>
                    if (!navigator.serviceWorker.controller) {
                        navigator.serviceWorker.register("{{ url('storage/app/public/sw.js') }}").then(function(reg) {
                            console.log("Service worker has been registered for scope: " + reg.scope);
                        });
                    }
                </script>
            @endif
        @endif
    @else
        @if (@helper::checkaddons('pwa'))
            <script src="{{ url('storage/app/public/sw.js') }}"></script>
            <script>
                if (!navigator.serviceWorker.controller) {
                    navigator.serviceWorker.register("{{ url('storage/app/public/sw.js') }}").then(function(reg) {
                        console.log("Service worker has been registered for scope: " + reg.scope);
                    });
                }
            </script>
        @endif
    @endif



    @yield('scripts')
</body>

</html>
