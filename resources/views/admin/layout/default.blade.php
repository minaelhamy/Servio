<!DOCTYPE html>

<html lang="en" dir="{{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}" class="light">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <meta property="og:title" content="{{ helper::appdata('')->meta_title }}" />

    <meta property="og:description" content="{{ helper::appdata('')->meta_description }}" />

    <meta property="og:image" content="{{ helper::image_path(helper::appdata('')->og_image) }}" />

    <script>
        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.add('light');
        }
    </script>

    <title>{{ helper::appdata('')->web_title }}</title>

    @if (Auth::user()->type == 4)
        <link rel="icon" type="image" sizes="16x16"
            href="{{ helper::image_path(@helper::appdata('')->favicon) }}"><!-- Favicon icon -->
    @else
        <link rel="icon" type="image" sizes="16x16"
            href="{{ helper::image_path(@helper::appdata('')->favicon) }}"><!-- Favicon icon -->
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet"
        href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/bootstrap/bootstrap-select.min.css') }}">
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/fontawesome/all.min.css') }}">
    <!-- FontAwesome CSS -->

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/toastr/toastr.min.css') }}">

    <!-- Toastr CSS -->

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/sweetalert/sweetalert2.min.css') }}">

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/chartjs/chart_3.9.1.min.js') }}"></script>

    <!-- Sweetalert CSS -->

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/style.css') }}"><!-- Custom CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/hatchers-brand.css') }}">

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/responsive.css') }}">

    <!-- Responsive CSS -->

    <link rel="stylesheet"
        href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/timepicker/jquery.timepicker.min.css') }}">

    <link rel="stylesheet"
        href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/datatables/dataTables.bootstrap5.min.css') }}">

    <link rel="stylesheet"
        href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/datatables/buttons.dataTables.min.css') }}">

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'admin-assets/css/fullcalendar.css') }}">
    <style>
        :root {
            /* Color */
            --bs-primary: {{ helper::appdata('')->primary_color }};
            --bs-secondary: {{ helper::appdata('')->secondary_color }};
        }
    </style>
</head>

<body class="">
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
    @endphp
    <main>

        <div class="wrapper">

            @include('admin.layout.header')

            <div class="content-wrapper">

                @include('admin.layout.sidebar')

                <div class="{{ session()->get('direction') == 2 ? 'main-content-rtl' : 'main-content' }}">

                    <div class="page-content">

                        <div class="container-fluid">
                            <div class="row">
                                @if (env('Environment') == 'sendbox')
                                    <div class="col-12">
                                        <div class="alert alert-warning mt-3" role="alert">
                                            <p class="d-flex flex-wrap align-items-center gap-2">According to Envato's
                                                license policy, an extended license is required for SaaS usage. <a
                                                    class="btn btn-primary px-sm-4 btn-sm active"
                                                    href="https://1.envato.market/KeRzWn" target="_blank">Buy Now
                                                </a></p>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12 ml-sm-auto">

                                    @if (env('Environment') == 'live')
                                        @if (request()->is('admin/custom_domain'))
                                            <div class="alert alert-warning" role="alert">
                                                {{ trans('messages.custom_domain_message') }}
                                            </div>
                                        @endif
                                        @if (request()->is('admin/apps'))
                                            <div class="alert alert-warning" role="alert">
                                                {{ trans('messages.addon_message') }}
                                            </div>
                                        @endif
                                    @endif
                                    @if (Auth::user()->type == 2)

                                        <?php
                                        
                                        $checkplan = helper::checkplan(Auth::user()->id, '');
                                        
                                        $plan = json_decode(json_encode($checkplan));
                                        
                                        ?>

                                        @if (@$plan->original->status == '2')

                                            <div class="alert alert-warning" role="alert">

                                                {{ @$plan->original->message }}{{ empty($plan->original->expdate) ? '' : ':' . $plan->original->expdate }}

                                                @if (@$plan->original->showclick == 1)
                                                    <u><a href="{{ URL::to('/admin/plan') }}"
                                                            class="text-danger fw-500">{{ trans('labels.click_here') }}</a></u>
                                                @endif

                                            </div>

                                        @endif

                                    @endif

                                </div>

                            </div>
                            @yield('content')

                        </div>

                    </div>

                </div>



                <!--Modal: booking-modal-->

                <div class="modal fade" id="booking-modal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">

                    <div class="modal-dialog modal-fullscreen-md-down modal-notify modal-info" role="document">

                        <div class="modal-content text-center">
                            <div class="modal-body">
                                <img src="{{ url('storage/app/public/admin-assets/images/icons-bell.gif') }}"
                                    class="mb-4 icon-bell" alt="">
                                <p class="heading fs-5 fw-600 color-changer">{{ trans('messages.be_up_to_date') }}</p>
                                <p class="fs-16 fw-500 color-changer">{{ trans('messages.new_booking_arrive') }}</p>
                            </div>

                            <div class="modal-footer flex-center">

                                <a role="button" class="btn btn-primary m-0 waves-effect"
                                    onClick="window.location.reload();"
                                    data-bs-dismiss="modal">{{ trans('labels.okay') }}</a>

                            </div>

                        </div>

                    </div>

                </div>

                <!--Modal: order-modal-->

                <div class="modal fade" id="order-modal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">

                    <div class="modal-dialog modal-fullscreen-md-down modal-notify modal-info" role="document">

                        <div class="modal-content text-center">
                            <div class="modal-body">
                                <img src="{{ url('storage/app/public/admin-assets/images/icons-bell.gif') }}"
                                    class="mb-4 icon-bell" alt="">
                                <p class="heading fs-5 fw-600 color-changer">{{ trans('messages.be_up_to_date') }}</p>
                                <p class="fs-16 fw-500 color-changer">{{ trans('messages.new_order_arrive') }}</p>
                            </div>

                            <div class="modal-footer flex-center">

                                <a role="button" class="btn btn-primary m-0 waves-effect"
                                    onClick="window.location.reload();"
                                    data-bs-dismiss="modal">{{ trans('labels.okay') }}</a>

                            </div>

                        </div>

                    </div>

                </div>

                <!--Modal: modalPush-->

            </div>

            @include('admin.layout.footer')

        </div>
        <!--theme image Modal -->
        <div class="modal fade" id="themeinfo" tabindex="-1" aria-labelledby="themeinfoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header justify-content-between">
                        <h5 class="modal-title color-changer" id="themeinfoLabel"></h5>
                        <button type="button" class="bg-transparent border-0 color-changer" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa-regular fa-xmark fs-4"></i>
                        </button>
                    </div>
                    <div class="modal-body" id="theme_modalbody">
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/jquery/jquery.min.js') }}"></script><!-- jQuery JS -->

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script><!-- Bootstrap JS -->
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/bootstrap/bootstrap-select.min.js') }}"></script><!-- Bootstrap JS -->
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/toastr/toastr.min.js') }}"></script><!-- Toastr JS -->

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/sweetalert/sweetalert2.min.js') }}"></script><!-- Sweetalert JS -->

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/datatables/jquery.dataTables.min.js') }}"></script><!-- Datatables JS -->

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/datatables/dataTables.bootstrap5.min.js') }}"></script><!-- Datatables Bootstrap5 JS -->

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/datatables/dataTables.buttons.min.js') }}"></script><!-- Datatables Buttons JS -->

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/datatables/jszip.min.js') }}"></script><!-- Datatables Excel Buttons JS -->

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/datatables/pdfmake.min.js') }}"></script><!-- Datatables Make PDF Buttons JS -->

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/datatables/vfs_fonts.js') }}"></script><!-- Datatables Export PDF Buttons JS -->

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/datatables/buttons.html5.min.js') }}"></script><!-- Datatables Buttons HTML5 JS -->
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/jquery.number.min.js') }}"></script>

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
            var bookingnotificationurl = "{{ URL::to('/admin/getbooking') }}";
            var ordernotificationurl = "{{ URL::to('/admin/getorder') }}";
            var vendoraudio =
                "{{ url(env('ASSETPATHURL') . 'admin-assets/notification/' . helper::appdata(Auth::user()->id)->notification_sound) }}";
        @endif

        function currency_formate(price) {
            var price = price * {{ @helper::currencyinfo($vendor_id)->exchange_rate }};
            if ("{{ @helper::currencyinfo($vendor_id)->currency_position }}" == "1") {

                if ("{{ helper::currencyinfo($vendor_id)->decimal_separator }}" == 1) {
                    var oldprice = $.number(price, "{{ helper::currencyinfo($vendor_id)->currency_formate }}");
                    if ("{{ @helper::currencyinfo($vendor_id)->currency_space }}" == 1) {
                        newprice = "{{ @helper::currencyinfo($vendor_id)->currency }}" + ' ' + oldprice;
                    } else {
                        newprice = "{{ @helper::currencyinfo($vendor_id)->currency }}" + oldprice;
                    }

                } else {
                    var oldprice = $.number(price, "{{ helper::currencyinfo($vendor_id)->currency_formate }}", ',', '.');
                    if ("{{ @helper::currencyinfo($vendor_id)->currency_space }}" == 1) {
                        newprice = "{{ @helper::currencyinfo($vendor_id)->currency }}" + ' ' + oldprice;
                    } else {

                        newprice = "{{ @helper::currencyinfo($vendor_id)->currency }}" + oldprice;
                    }
                }
                return newprice;
            } else {
                if ("{{ helper::currencyinfo($vendor_id)->decimal_separator }}" == 1) {
                    var oldprice = $.number(price, "{{ helper::currencyinfo($vendor_id)->currency_formate }}");
                    if ("{{ @helper::currencyinfo($vendor_id)->currency_space }}" == 1) {
                        newprice = oldprice + ' ' + "{{ @helper::currencyinfo($vendor_id)->currency }}";
                    } else {
                        newprice = oldprice + "{{ @helper::currencyinfo($vendor_id)->currency }}";
                    }

                } else {
                    var oldprice = $.number(price, "{{ helper::currencyinfo($vendor_id)->currency_formate }}", ',', '.');
                    if ("{{ @helper::currencyinfo($vendor_id)->currency_space }}" == 1) {
                        newprice = oldprice + ' ' + "{{ @helper::currencyinfo($vendor_id)->currency }}";
                    } else {
                        newprice = oldprice + "{{ @helper::currencyinfo($vendor_id)->currency }}";
                    }
                }
                return newprice;
            }
        }
    </script>
    @if (@helper::checkaddons('notification'))
        @if (Auth::user()->type == 2)
            <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/sound.js') }}"></script>
        @endif
    @endif
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/jquery/jquery-ui.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/common.js') }}"></script><!-- Common JS -->
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/calendar/moment.min.js') }}"></script>
    @yield('scripts')

</body>

</html>
