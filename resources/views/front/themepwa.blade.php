<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ helper::appdata(@$vendordata->id)->web_title }}</title>
    <link rel="icon" type="image" sizes="16x16"
        href="{{ helper::image_path(helper::appdata(@$vendordata->id)->favicon) }}">
    <!-- Favicon icon -->

    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'landing/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'landing/css/style.css') }}">
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'landing/css/responsive.css') }}">
    <style>
        :root {
            /* Color */
            --primary-color: {{ helper::landingsettings()->primary_color }};
            --secondary-color: {{ helper::landingsettings()->secondary_color }};
        }
    </style>
</head>

<body>
    <div class="d-none d-xl-block">
        <div class="arrow">
            <div class="arrow__body"></div>
        </div>
    </div>
    <section class="bg-gradient-color2 h-100 custom-padding position-relative">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="h-100 d-flex gap-3 justify-content-center flex-column">
                        <div class="logo">
                            <a href="{{ URL::to('/') }}">
                                <img src="{{ helper::image_path(helper::appdata('')->logo) }}" height="50"
                                    alt="">
                            </a>
                        </div>
                        <h1 class="text-capitalize text-dark fw-bold col-xl-10  col-12">
                            {{ trans('landing.pwa_tital') }}
                        </h1>
                        <p class="text-white text-capitalize col-xl-10 fw-500 col-12 fs-17">
                            {{ trans('landing.description_pwa') }}
                        </p>
                        @php
                            $getuserslist = App\Models\User::where('type', 2)
                                ->where('is_available', 1)
                                ->where('is_deleted', 2)
                                ->get();
                        @endphp
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($getuserslist as $key => $user)
                                <a href="{{ URL::to($user->slug . '/pwa') }}"
                                    class="{{ request()->is($user->slug . '/pwa') ? 'btn-secondary text-white' : 'btn-primary' }} rounded-5 p-2 px-4 shadow fs-6 m-0 fw-500">
                                    {{ $user->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="h-100 d-flex justify-content-center flex-column">
                        <div class="smartphone shadow-lg">
                            <div class="content">
                                <iframe src="{{ URL::to($vendordata->slug) }}"
                                    style="width:100%; border:none; height:100%"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/jquery/jquery.min.js') }}"></script><!-- jQuery JS -->
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script><!-- Bootstrap JS -->
</body>

</html>
