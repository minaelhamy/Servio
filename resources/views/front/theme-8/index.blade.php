@extends('front.layout.master')
@section('content')
    <main class="theme-8">
        <!-------------------------------------------------------- top-banner -------------------------------------------------------->
        <section class="home-banner-8">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-xl-6 col-lg-6 banner-content mb-5 mb-lg-0">
                        <div class="cat-hand">
                            <img src="storage\app\public\front\images\h3_banner_shape01.png" alt="shape"
                                data-aos="fade-down-right" data-aos-delay="600">
                        </div>
                        <p class="fw-semibold text-primary-color mb-3">
                            {{ helper::appdata($vendordata->id)->homepage_title }}
                        </p>
                        <h1 class="fw-600 text-dark home-subtitle m-0">
                            {{ helper::appdata($vendordata->id)->homepage_subtitle }}
                        </h1>
                        <form action="{{ URL::to($vendordata->slug . '/services') }}" method="get"
                            class="bg-body p-2 shadow-sm rounded-2 mb-4 mt-5 w-100">
                            <div class="input-group gap-2">
                                <input class="form-control border-0 rounded-2" type="text"
                                    placeholder="{{ trans('labels.search_by_service_name') }}"
                                    value="{{ isset($_GET['search_input']) ? $_GET['search_input'] : '' }}">
                                <button type="submit" class="btn btn-primary rounded-2 mb-0 btn-submit px-md-4 px-3">
                                    <i
                                        class="fa-solid fa-magnifying-glass {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}"></i>{{ trans('labels.search') }}</button>
                            </div>
                        </form>
                        <!-- avatar -->
                        <div class="d-sm-flex align-items-center">
                            <ul class="avatar-group mb-0 mx-auto mx-lg-0 justify-content-center mb-3 mb-md-0">
                                @foreach ($reviewimage as $image)
                                    <li class=" avatar-sm">
                                        <img class="avatar-img rounded-circle" src="{{ helper::image_path($image->image) }}"
                                            alt="avatar">
                                    </li>
                                @endforeach
                            </ul>
                            <p class="m-0 px-4 text-center text-truncate">{{ trans('labels.review_section_title') }}
                            </p>
                        </div>
                        <!-- avatar -->
                    </div>
                    <div class="col-xl-5 col-lg-6 position-relative d-none d-md-block order-2 order-lg-0">
                        <img src="{{ helper::image_path(helper::appdata($vendordata->id)->home_banner) }}" alt=""
                            class="w-100 banner-8-img object-fit-cover">
                        <img src="storage\app\public\front\images\services_shape01.png" alt="shape"
                            class="ribbonRotate {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                    </div>
                </div>
            </div>
        </section>
        <div class="d-lg-none">
            @if (!request()->is($vendordata->slug . '/service-*'))
                @if (helper::top_deals($vendordata->id) != null && count(helper::topdealitemlist($vendordata->id)) > 0)
                    <nav class="bg-primary-rgb p-3 my-2">
                        <div class="container">
                            <div id="eapps-countdown-timer-1"
                                class="rounded eapps-countdown-timer eapps-countdown-timer-align-center eapps-countdown-timer-position-bottom-bar-floating eapps-countdown-timer-animation-none eapps-countdown-timer-theme-default eapps-countdown-timer-finish-button-show   eapps-countdown-timer-style-combined eapps-countdown-timer-style-blocks eapps-countdown-timer-position-bar eapps-countdown-timer-area-clickable eapps-countdown-timer-has-background">
                                <div class="eapps-countdown-timer-container d-flex">
                                    <div class="eapps-countdown-timer-inner row g-3 flex-column flex-sm-row">
                                        <div
                                            class="eapps-countdown-timer-header d-sm-flex d-none col-md-4 align-items-center justify-content-center justify-content-md-start">
                                            <div class="eapps-countdown-timer-header-title ">
                                                <div
                                                    class="eapps-countdown-timer-header-title-text text-center {{ session()->get('direction') == 2 ? 'text-md-end' : 'text-md-start' }}">
                                                    <div class="line-2">{{ trans('labels.top_deals_title') }}
                                                        {{ trans('labels.top_deals_description') }}</div>
                                                </div>
                                            </div>
                                            <div class="eapps-countdown-timer-header-caption"></div>
                                        </div>
                                        <div class="eapps-countdown-timer-item-container col-md-4">
                                            <div
                                                class="eapps-countdown-timer-item d-flex gap-2 justify-content-center countdowntime">
                                            </div>
                                        </div>
                                        @if (request()->get('type') != 'topdeals')
                                            <div
                                                class="eapps-countdown-timer-button-container d-flex col-md-4 align-items-center justify-content-center justify-content-md-end">
                                                <a href="{{ URL::to($vendordata->slug . '/services?type=topdeals') }}"
                                                    class="eapps-countdown-timer-button rounded">
                                                    {{ trans('labels.book_now') }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </nav>
                @endif
            @endif
        </div>
        <!------------------------------------------------- Why choose section start ------------------------------------------------->
        @if ($choose->count() > 0)
            <section class="why-choose position-relative">
                <div class="container">
                    <div class="row g-4 justify-content-between align-items-center">
                        <!-- Left side START -->
                        <div class="col-lg-6">
                            <div class="appointment__img-mask-two">
                                <!-- Image -->
                                <img src="{{ helper::image_path(helper::appdata($vendordata->id)->why_choose_image) }}"
                                    class="w-100 h-100 object-fit-cover" alt="">
                            </div>
                        </div>
                        <!-- Left side END -->
                        <!-- Right side START -->
                        <div class="col-lg-6 choose-content order-2 order-lg-0">
                            <h2 class="fw-600 text_truncation2 fs-1 color-changer">
                                {{ helper::appdata($vendordata->id)->why_choose_title }}
                            </h2>
                            <p class="mt-2 text-muted text_truncation3">
                                {{ helper::appdata($vendordata->id)->why_choose_subtitle }}
                            </p>
                            <!-- Features START -->
                            <div class="row g-3 g-md-4 mt-2">
                                <!-- Item -->
                                @foreach ($choose as $choose)
                                    <div class="col-sm-6">
                                        <div class="d-flex">
                                            <img src="{{ helper::image_path($choose->image) }}"
                                                class="col-2 icon-lg bg-success bg-opacity-10 text-success rounded-circle"
                                                alt="">
                                            <div class="{{ session()->get('direction') == 2 ? 'me-3' : 'ms-3' }}">
                                                <h5 class="fw-600 text_truncation2 color-changer">{{ $choose->title }}</h5>
                                                <p class="mb-0 text-muted text_truncation2">{{ $choose->description }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <!-- Features END -->
                        </div>
                        <!-- Right side END -->
                    </div>
                </div>
                <div class="appointment__shape-wrap">
                    <img src="storage\app\public\front\images\appointment _shape01.png" alt="shape" class="ribbonRotate">
                    <img src="storage\app\public\front\images\appointment _shape02.png" alt="shape" data-aos="fade-right"
                        data-aos-delay="400" class="aos-init aos-animate dog">
                </div>
            </section>
        @endif
        <!-------------------------------------------------- Why choose section end -------------------------------------------------->

        <!----------------------------------------------------- banner section-1 ----------------------------------------------------->
        @if (@$getbannersection1->count() > 0)
            <section class="pt-90 pb-90">
                <div class="container">
                    <div class="card-carousel owl-carousel owl-loaded">
                        <div class="owl-stage-outer">
                            <div class="owl-stage carousel">
                                @foreach ($getbannersection1 as $banner)
                                    <div class="owl-item">
                                        <div class="card-top">
                                            <div class="card-overlay">
                                                @if ($banner->type == 1)
                                                    <a
                                                        href="{{ URL::to($vendordata->slug . '/services?category=' . $banner['category_info']->slug) }}">
                                                    @elseif($banner->type == 2)
                                                        @php
                                                            $service = helper::servicedetails(
                                                                $banner->service_id,
                                                                $vendordata->id,
                                                            );
                                                        @endphp
                                                        <a
                                                            href="{{ URL::to(@$vendordata->slug . '/service-' . $service->slug) }}">
                                                        @else
                                                            <a href="javascript:void(0)">
                                                @endif
                                                <div class="slider-1-mask">
                                                    <img src="{{ helper::image_path($banner->image) }}"
                                                        class="card-imp-top h-100" alt="">
                                                </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!----------------------------------------------------- banner secction-1 end ----------------------------------------------------->
        <!---------------------------------------------------- product service section start ---------------------------------------------------->
        @if (helper::footer_features(@$vendordata->id)->count() > 0)
            <section class="product-service theme-8 py-5">
                <div class="container">
                    <div class="rounded-4 d-lg-block d-none">
                        <div class="row align-items-center justify-content-around py-3">
                            @foreach (helper::footer_features(@$vendordata->id) as $feature)
                                <div class="col-xl-3 col-lg-3 col-md-6 text-center">
                                    <div class="free-icon fs-2 text-primary-color color-changer">
                                        {!! $feature->icon !!}
                                    </div>
                                    <div class="free-content">
                                        <h3 class="fs-6 mb-1 fw-600 color-changer">{{ $feature->title }}</h3>
                                        <p class="fs-7 text-muted">{{ $feature->description }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="footer-fiechar-slider owl-carousel owl-theme d-lg-none">
                        @foreach (helper::footer_features(@$vendordata->id) as $feature)
                            <div class="item h-100">
                                <div class="col h-100 text-center">
                                    <div class="free-icon fs-2 text-primary-color color-changer">
                                        {!! $feature->icon !!}
                                    </div>
                                    <div class="free-content">
                                        <h3 class="fs-6 mb-1 fw-600 color-changer">{{ $feature->title }}</h3>
                                        <p class="fs-7 text-muted">{{ $feature->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        <!---------------------------------------------------- product service section end ---------------------------------------------------->

        <!------------------------------------------------------ service section ------------------------------------------------------>
        @if (@$getservices->count() > 0)
            <section class="service-div w-100 pt-90 pb-90">
                <div class="container">
                    <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between pb-5">
                        <div class="">
                            <h3 class="fw-600 theme-3-title text-truncate fs-3 color-changer">
                                {{ trans('labels.services') }}</h3>
                            <p class="fw-semibold text-primary-color m-0 text-truncate">{{ trans('labels.our_populer') }}
                                {{ trans('labels.services') }}
                            </p>
                        </div>
                        <a class="fw-semibold btn btn-primary-rgb rounded-5"
                            href="{{ URL::to($vendordata->slug . '/services') }}">{{ trans('labels.viewall') }} <i
                                class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                    </div>
                    <div class="row g-4 listing-view">
                        @foreach ($getservices as $service)
                            @php
                                if ($service->top_deals == 1 && @helper::top_deals($vendordata->id) != null) {
                                    if (@helper::top_deals($vendordata->id)->offer_type == 1) {
                                        if ($service->price > @helper::top_deals($vendordata->id)->offer_amount) {
                                            $price =
                                                $service->price - @helper::top_deals($vendordata->id)->offer_amount;
                                        } else {
                                            $price = $service->price;
                                        }
                                    } else {
                                        $price =
                                            $service->price -
                                            $service->price * (@helper::top_deals($vendordata->id)->offer_amount / 100);
                                    }
                                    $original_price = $service->price;
                                    $off =
                                        $original_price > 0
                                            ? number_format(100 - ($price * 100) / $original_price, 1)
                                            : 0;
                                } else {
                                    $price = $service->price;
                                    $original_price = $service->original_price;
                                    $off = $service->discount_percentage;
                                }
                            @endphp
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <div class="card bg-transparent border-0 p-0 h-100 w-100 rounded-4 overflow-hidden">
                                    <div class="team__item-img">
                                        <div class="mask-img-wrap">
                                            @if ($service['service_image'] == null)
                                                <img src="{{ helper::image_path('service.png') }}"
                                                    class="h-100 w-100 rounded-3 object-fit-cover" alt="...">
                                            @else
                                                <img src="{{ helper::image_path($service['service_image']->image) }}"
                                                    class="h-100 w-100 rounded-3 object-fit-cover" alt="...">
                                            @endif
                                        </div>
                                        <div class="team__item-img-shape">
                                            <div class="shape-one">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 284 263"
                                                    fill="none" x="0px" y="0px" preserveAspectRatio="none"
                                                    data-inject-url="https://themedox.com/demo/petpal/assets/img/team/servic_img_shape01.svg"
                                                    class="injectable">
                                                    <path class="animation-dashed"
                                                        d="M6.10826 107.444L6.10828 107.444L6.10831 107.444L6.11408 107.425L6.11916 107.406C6.38877 106.405 6.66335 105.413 6.94283 104.43L5.98096 104.157C6.54248 102.182 7.12371 100.244 7.72394 98.3417L8.6776 98.6425C9.28902 96.7047 9.92017 94.8044 10.5703 92.9409L9.62609 92.6115C10.3038 90.6691 11.002 88.7663 11.72 86.9024L12.6532 87.2618C13.3837 85.3653 14.1347 83.5094 14.9052 81.6934L13.9846 81.3028C14.7869 79.412 15.6103 77.5639 16.4538 75.7575L17.3599 76.1807C18.2221 74.3341 19.1055 72.5318 20.0088 70.7726L19.1192 70.3158C20.0526 68.4979 21.0074 66.7254 21.9823 64.9974L22.8532 65.4887C23.8584 63.7069 24.8851 61.9729 25.9317 60.2854L25.0819 59.7583C26.1522 58.0327 27.2435 56.3552 28.3544 54.7245L29.1809 55.2875C30.3356 53.5926 31.5115 51.9488 32.7069 50.3547L31.9069 49.7548C33.1337 48.1188 34.3812 46.5346 35.6476 45.0005L36.4188 45.6372C37.7074 44.0763 39.0156 42.5679 40.3416 41.1105L39.602 40.4375C40.9857 38.9166 42.3889 37.4505 43.8094 36.0373L44.5147 36.7462C45.9504 35.3179 47.404 33.9442 48.8731 32.6232L48.2045 31.8796C49.7191 30.5179 51.2502 29.2116 52.7956 27.9586L53.4254 28.7354C55.0055 27.4544 56.6006 26.2296 58.2083 25.0588L57.6196 24.2504C59.2709 23.0479 60.9354 21.9019 62.6105 20.8098L63.1566 21.6475C64.8485 20.5445 66.5514 19.497 68.2624 18.5026L67.7599 17.638C69.5225 16.6136 71.2937 15.645 73.0703 14.7296L73.5284 15.6185C75.3311 14.6897 77.1398 13.8159 78.9512 12.9943L78.5381 12.0836C80.3975 11.2403 82.2596 10.4516 84.121 9.71452L84.4891 10.6443C86.3706 9.89924 88.2515 9.20724 90.1285 8.56506L89.8048 7.61891C91.7339 6.9589 93.6586 6.35121 95.5751 5.79238L95.855 6.7524C97.7994 6.18541 99.7356 5.66904 101.66 5.19965L101.423 4.22814C103.414 3.74233 105.392 3.30655 107.352 2.91681L107.547 3.89761C109.545 3.50029 111.525 3.15111 113.482 2.8458L113.328 1.85775C115.359 1.54097 117.365 1.27113 119.34 1.04352L119.455 2.03695C121.489 1.80269 123.49 1.61343 125.455 1.46396L125.379 0.466844C127.441 0.309957 129.461 0.196663 131.434 0.121003L131.472 1.12027C133.536 1.04112 135.547 1.0034 137.498 1.00022L137.496 0.000222021C139.587 -0.00318751 141.609 0.0328347 143.553 0.0998856L143.519 1.09929C145.611 1.17146 147.613 1.27979 149.512 1.41368L149.582 0.416153C151.745 0.568686 153.776 0.754194 155.658 0.957183L155.55 1.95141C157.747 2.18843 159.739 2.44936 161.497 2.70919L161.643 1.71993C164.124 2.0865 166.146 2.45111 167.633 2.74466L167.44 3.72573C168.378 3.91103 169.1 4.06739 169.585 4.17696C169.828 4.23175 170.011 4.27483 170.133 4.30397C170.194 4.31854 170.24 4.32963 170.269 4.33695L170.302 4.34508L170.31 4.34696L170.311 4.34735L170.356 4.35853L170.401 4.36558L170.402 4.36586L170.41 4.36706L170.443 4.37239C170.473 4.37725 170.518 4.38476 170.579 4.39504C170.701 4.41561 170.884 4.44727 171.125 4.49108C171.608 4.57868 172.323 4.71482 173.246 4.9078L173.45 3.92895C174.915 4.23497 176.893 4.68169 179.291 5.30136L179.041 6.26957C180.75 6.71116 182.675 7.24139 184.78 7.8721L185.067 6.91418C186.854 7.44983 188.771 8.0574 190.796 8.74406L190.474 9.69107C192.26 10.2965 194.129 10.9639 196.069 11.6981L196.423 10.7628C198.229 11.4466 200.096 12.188 202.011 12.9911L201.624 13.9133C203.397 14.6568 205.212 15.4534 207.059 16.3062L207.479 15.3983C209.25 16.2159 211.05 17.085 212.872 18.0082L212.42 18.9002C214.159 19.781 215.917 20.7113 217.687 21.6936L218.172 20.8192C219.892 21.7738 221.624 22.7772 223.362 23.8317L222.843 24.6866C224.516 25.702 226.193 26.7649 227.87 27.8774L228.423 27.0441C230.065 28.1341 231.707 29.2714 233.342 30.4579L232.755 31.2673C234.342 32.4186 235.922 33.6164 237.491 34.8624L238.113 34.0793C239.661 35.3084 241.199 36.5843 242.72 37.9086L242.064 38.663C243.545 39.9515 245.011 41.286 246.457 42.668L247.148 41.945C248.579 43.312 249.991 44.7253 251.381 46.1862L250.656 46.8753C252.009 48.298 253.34 49.7661 254.644 51.281L255.402 50.6283C256.694 52.128 257.96 53.6733 259.198 55.2656L258.408 55.8792C259.613 57.4286 260.789 59.0227 261.934 60.6627L262.754 60.0902C263.887 61.7127 264.99 63.3799 266.059 65.0929L265.21 65.6223C266.248 67.2857 267.254 68.9927 268.225 70.7443L269.1 70.2596C270.056 71.9853 270.979 73.754 271.864 75.5667L270.966 76.0056C271.824 77.762 272.647 79.5601 273.432 81.4009L274.352 81.0084C275.126 82.8212 275.863 84.675 276.561 86.5706L275.623 86.9164C275.966 87.8475 276.3 88.7888 276.624 89.7405C276.934 90.6556 277.233 91.5774 277.521 92.5057L278.476 92.2095C279.054 94.0759 279.588 95.9676 280.077 97.8819L279.108 98.1293C279.588 100.008 280.024 101.91 280.416 103.83L281.396 103.63C281.786 105.542 282.133 107.473 282.436 109.42L281.448 109.574C281.746 111.489 282.001 113.42 282.214 115.365L283.208 115.256C283.421 117.2 283.591 119.158 283.718 121.126L282.72 121.19C282.845 123.129 282.929 125.079 282.97 127.037L283.97 127.016C284.011 128.972 284.01 130.935 283.968 132.905L282.968 132.883C282.926 134.825 282.843 136.772 282.718 138.722L283.716 138.786C283.591 140.74 283.425 142.697 283.217 144.656L282.223 144.55C282.018 146.485 281.772 148.421 281.485 150.356L282.474 150.503C282.187 152.44 281.858 154.376 281.489 156.309L280.507 156.122C280.142 158.032 279.736 159.938 279.29 161.839L280.263 162.068C279.816 163.976 279.327 165.878 278.798 167.773L277.834 167.504C277.311 169.379 276.746 171.247 276.141 173.105L277.092 173.415C276.486 175.278 275.839 177.131 275.151 178.974L274.214 178.624C273.533 180.446 272.813 182.257 272.051 184.054L272.972 184.444C272.208 186.249 271.403 188.041 270.557 189.817L269.654 189.387C268.817 191.145 267.94 192.886 267.023 194.611L267.906 195.081C266.986 196.81 266.026 198.521 265.026 200.214L264.165 199.705C263.176 201.378 262.147 203.032 261.078 204.665L261.914 205.213C260.841 206.852 259.728 208.471 258.574 210.067L257.763 209.481C256.625 211.055 255.447 212.607 254.23 214.134L255.012 214.757C253.793 216.287 252.534 217.792 251.236 219.271L250.484 218.611C249.204 220.07 247.884 221.503 246.525 222.908L247.244 223.603C245.883 225.011 244.484 226.391 243.045 227.743L242.36 227.014C240.95 228.338 239.502 229.635 238.015 230.901L238.664 231.663C237.177 232.929 235.653 234.166 234.09 235.372L233.479 234.58C231.942 235.766 230.368 236.922 228.757 238.045L229.329 238.866C227.733 239.978 226.102 241.059 224.434 242.107L223.902 241.26C222.265 242.289 220.592 243.285 218.884 244.249L219.375 245.12C217.673 246.08 215.935 247.008 214.162 247.901L213.712 247.008C211.994 247.874 210.242 248.707 208.457 249.506L208.866 250.419C207.087 251.215 205.276 251.978 203.432 252.706L203.065 251.776C201.267 252.486 199.437 253.163 197.575 253.806L197.902 254.751C196.07 255.383 194.208 255.982 192.314 256.547L192.028 255.589C190.168 256.144 188.278 256.666 186.358 257.153L186.604 258.122C184.732 258.597 182.832 259.04 180.903 259.449L180.695 258.471C178.803 258.873 176.884 259.242 174.936 259.578L175.106 260.563C173.194 260.893 171.257 261.19 169.292 261.455L169.159 260.464C167.248 260.721 165.312 260.948 163.35 261.142L163.448 262.137C161.512 262.328 159.551 262.489 157.565 262.618L157.501 261.62C155.581 261.744 153.638 261.838 151.671 261.902L151.704 262.901C149.756 262.964 147.785 262.998 145.791 263L145.79 262C143.868 262.002 141.924 261.976 139.959 261.92L139.93 262.92C137.982 262.864 136.013 262.78 134.023 262.667L134.08 261.669C132.158 261.559 130.216 261.423 128.254 261.258L128.171 262.254C126.233 262.091 124.275 261.901 122.299 261.684L122.409 260.69C121.425 260.581 120.436 260.466 119.442 260.344C118.436 260.22 117.438 260.091 116.449 259.958L116.315 260.949C114.329 260.681 112.376 260.394 110.454 260.089L110.611 259.101C108.686 258.795 106.794 258.471 104.935 258.128L104.753 259.111C102.758 258.744 100.8 258.355 98.8783 257.947L99.0861 256.969C97.1731 256.562 95.2963 256.136 93.4551 255.69L93.2198 256.662C91.2569 256.187 89.3338 255.69 87.4498 255.172L87.715 254.208C85.8195 253.687 83.9641 253.144 82.1481 252.581L81.852 253.536C79.9305 252.94 78.0523 252.322 76.2167 251.681L76.5462 250.737C74.6894 250.089 72.8767 249.419 71.1071 248.727L70.743 249.658C68.868 248.925 67.0408 248.168 65.2601 247.387L65.6614 246.472C63.8678 245.686 62.1223 244.877 60.4235 244.046L59.9841 244.944C58.1697 244.057 56.4077 243.144 54.6969 242.208L55.1769 241.331C53.4518 240.387 51.7795 239.419 50.1585 238.429L49.6372 239.282C47.928 238.238 46.275 237.169 44.6764 236.077L45.2405 235.251C43.6058 234.134 42.0288 232.993 40.5077 231.83L39.9002 232.625C38.3288 231.423 36.816 230.197 35.3599 228.95L36.0104 228.191C34.5028 226.899 33.0567 225.585 31.67 224.249L30.9763 224.969C29.5419 223.588 28.1701 222.184 26.8584 220.76L27.5938 220.083C26.2652 218.641 24.999 217.178 23.7926 215.698L23.0175 216.33C21.761 214.789 20.5687 213.228 19.4376 211.651L20.2501 211.068C19.1028 209.469 18.0191 207.853 16.9959 206.223L16.149 206.755C15.0949 205.076 14.1044 203.382 13.1742 201.678L14.0519 201.199C13.1137 199.48 12.2375 197.75 11.4197 196.013L10.5148 196.438C9.67194 194.647 8.89064 192.848 8.16726 191.045L9.09536 190.673C8.36359 188.849 7.69154 187.02 7.07534 185.192L6.12768 185.511C5.49455 183.632 4.91994 181.753 4.39969 179.878L5.36329 179.61C4.83799 177.717 4.36851 175.828 3.95054 173.947L2.97435 174.164C2.54405 172.228 2.16795 170.301 1.84138 168.388L2.82712 168.22C2.49572 166.279 2.21568 164.353 1.98207 162.446L0.989493 162.567C0.747693 160.594 0.5553 158.641 0.406886 156.715L1.40393 156.639C1.25186 154.666 1.14629 152.721 1.08132 150.81L0.0818934 150.844C0.0137625 148.84 -0.0100384 146.875 0.00375479 144.954L1.00373 144.961C1.01808 142.962 1.07344 141.012 1.16213 139.118L0.163222 139.071C0.258318 137.04 0.391465 135.075 0.553291 133.184L1.54965 133.269C1.72423 131.229 1.9324 129.277 2.16226 127.425L1.16987 127.302C1.42795 125.222 1.71318 123.268 2.00891 121.456L2.99584 121.617C3.34064 119.505 3.69974 117.589 4.04632 115.896L3.06664 115.695C3.55701 113.3 4.02281 111.348 4.38942 109.918L5.35813 110.166C5.58591 109.277 5.77458 108.593 5.90575 108.133C5.97134 107.903 6.02254 107.729 6.05706 107.613C6.07432 107.555 6.08741 107.512 6.09604 107.484L6.1056 107.453L6.1078 107.445L6.10826 107.444Z"
                                                        stroke="currentcolor" stroke-width="2" stroke-dasharray="6 6">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="team__social">
                                            <ul class="list-wrap">
                                                <li>
                                                    @if (@helper::checkaddons('customer_login'))
                                                        @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                            <div class="badges bg-danger rounded-circle"
                                                                tooltip="Wishlist">
                                                                <button
                                                                    onclick="managefavorite('{{ $service->id }}',{{ $vendordata->id }},'{{ URL::to(@$vendordata->slug . '/managefavorite') }}')"
                                                                    class="btn border-0 text-white fs-6">
                                                                    @if (Auth::user() && Auth::user()->type == 3)
                                                                        @php
                                                                            $favorite = helper::ceckfavorite(
                                                                                $service->id,
                                                                                $vendordata->id,
                                                                                Auth::user()->id,
                                                                            );
                                                                        @endphp
                                                                        @if (!empty($favorite) && $favorite->count() > 0)
                                                                            <i class="fa-solid fa-fw fa-heart"></i>
                                                                        @else
                                                                            <i class="fa-regular fa-heart"></i>
                                                                        @endif
                                                                    @else
                                                                        <i class="fa-regular fa-heart"></i>
                                                                    @endif
                                                                </button>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </li>
                                                <li>
                                                    @if (helper::appdata($vendordata->id)->online_order == 1)
                                                        <a href="{{ URL::to($vendordata->slug . '/booking-' . $service->id) }}"
                                                            tooltip="Book Now"
                                                            class="badges bg-secondary rounded-circle text-white fs-7">
                                                            <i class="fa-solid fa-plus"></i></a>
                                                    @else
                                                        <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                            tooltip="Book Now"
                                                            class="badges bg-secondary rounded-circle text-white fs-7">
                                                            <i class="fa-solid fa-plus"></i></a>
                                                    @endif
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="card-body px-2 py-0">
                                        <div class="card-text text-center">
                                            <div
                                                class="d-flex align-items-center {{ $off > 0 ? 'justify-content-between' : 'justify-content-center' }} px-4">
                                                @if ($off > 0)
                                                    <span
                                                        class="{{ session()->get('direction') == '2' ? 'service-right-label-2' : 'service-left-label-2 ' }} fs-9">
                                                        {{ $off }}% {{ trans('labels.off') }}
                                                    </span>
                                                @endif
                                                @if (@helper::checkaddons('product_reviews'))
                                                    @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                        <p class="fw-semibold m-0 fs-7 d-flex align-items-center gap-1">
                                                            <i class="fas fa-star fa-fw text-warning"></i>
                                                            <span class="color-changer">
                                                                {{ number_format($service->ratings_average, 1) }}
                                                            </span>
                                                        </p>
                                                    @endif
                                                @endif
                                            </div>
                                            @php
                                                $category = helper::getcategoryinfo(
                                                    $service->category_id,
                                                    $service->vendor_id,
                                                );
                                            @endphp
                                            <small class="fs-8 text-muted text-truncate">{{ $category[0]->name }}</small>

                                            <h5 class="mb-0 fw-semibold text_truncation2 fs-16">
                                                <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                    class="color-changer">
                                                    {{ $service->name }}
                                                </a>
                                            </h5>
                                            <div class="d-flex justify-content-center align-items-center gap-1 py-2">
                                                <p class="fw-600 my-0 text-primary text-truncate">
                                                    {{ helper::currency_formate($price, $vendordata->id) }}
                                                </p>
                                                @if ($original_price > $price)
                                                    <del class="fw-600 my-0 text-muted text-truncate fs-7">
                                                        {{ helper::currency_formate($original_price, $vendordata->id) }}
                                                    </del>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!----------------------------------------------------- category section ----------------------------------------------------->
        @if (@$getcategories->count() > 0)
            <section class="category bg-primary-rgb position-relative pt-90 pb-90">
                <div class="container">
                    <div class="d-flex gap-3 align-items-center justify-content-between pb-5">
                        <div class="">
                            <h3 class="fw-600 theme-3-title line-1 fs-3 color-changer">
                                {{ trans('labels.see_all_category') }}
                            </h3>
                            <p class="fw-semibold text-primary-color mb-0 line-1">
                                {{ trans('labels.home_category_subtitle') }}
                            </p>
                        </div>
                        <a class="fs-6 fw-semibold btn btn-primary-rgb rounded-5 col-auto"
                            href="{{ URL::to($vendordata->slug . '/categories') }}">{{ trans('labels.viewall') }} <i
                                class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                    </div>
                    <div class="row g-4">
                        @foreach ($getcategories as $category)
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <a
                                    href="{{ URL::to($vendordata->slug . '/services?category=' . $category->slug . '&search_input=') }}">
                                    <div
                                        class="card p-md-5 p-sm-4 p-5 bg-transparent border-0 rounded-4 h-100 w-100 text-center align-items-center">
                                        <div class="services__shape">
                                            <div class="shape-one">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 303 378"
                                                    fill="none" x="0px" y="0px" preserveAspectRatio="none"
                                                    data-inject-url="storage\app\public\front\images\services_shape01.svg"
                                                    class="injectable">
                                                    <path
                                                        d="M3.85747 122.642C-10.6791 56.2814 31.4447 -7.84076 83.5423 1.34287L141.444 11.5497C147.873 12.683 154.389 12.683 160.818 11.5497L221.988 0.766826C277.534 1.34278 302.203 50.4246 302.203 119.514L292.324 169.8C289.656 183.385 289.294 197.575 291.264 211.365L298.723 263.557C308.036 328.73 265.288 386.288 215.463 375.662L156.077 362.997C147.167 361.097 138.066 361.389 129.237 363.858L88.0938 375.366C33.5856 390.611 -13.2316 323.07 3.41183 253.2L12.0101 217.104C16.2711 199.216 16.4391 180.078 12.4935 162.065L3.85747 122.642Z"
                                                        fill="currentcolor"></path>
                                                </svg>
                                            </div>
                                            <div class="shape-two">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 286 360"
                                                    fill="none" x="0px" y="0px" preserveAspectRatio="none"
                                                    data-inject-url="storage\app\public\front\images\services_shape02.svg"
                                                    class="injectable">
                                                    <path class="animation-dashed" vector-effect="non-scaling-stroke"
                                                        d="M284.434 116.47L285.416 116.661L284.247 122.662L283.266 122.471L282.097 128.472L283.078 128.663L281.91 134.665L280.928 134.473L279.76 140.475L280.741 140.666L279.573 146.667L278.591 146.476L277.423 152.477L278.404 152.668L277.236 158.669L276.254 158.478L275.67 161.479C275.456 162.574 275.258 163.674 275.076 164.777L276.063 164.94C275.702 167.122 275.402 169.319 275.163 171.524L274.169 171.417C273.929 173.635 273.75 175.863 273.633 178.096L274.631 178.148C274.515 180.359 274.459 182.575 274.465 184.792L273.465 184.794C273.47 187.028 273.537 189.262 273.665 191.492L274.664 191.434C274.791 193.647 274.979 195.855 275.228 198.056L274.234 198.168C274.36 199.278 274.501 200.387 274.658 201.492L275.099 204.606L276.089 204.466L276.971 210.695L275.981 210.835L276.864 217.064L277.854 216.923L278.736 223.152L277.746 223.292L278.628 229.521L279.618 229.38L280.501 235.609L279.51 235.749L280.393 241.978L281.383 241.838L282.265 248.066L281.275 248.206L281.716 251.321C281.855 252.301 281.982 253.279 282.096 254.255L283.089 254.139C283.321 256.121 283.504 258.095 283.638 260.059L282.64 260.127C282.775 262.102 282.861 264.067 282.899 266.018L283.898 265.999C283.937 267.994 283.926 269.977 283.867 271.944L282.868 271.914C282.808 273.892 282.7 275.855 282.544 277.801L283.541 277.88C283.382 279.87 283.174 281.841 282.918 283.792L281.926 283.662C281.669 285.624 281.363 287.565 281.011 289.483L281.994 289.663C281.633 291.626 281.224 293.565 280.768 295.478L279.795 295.246C279.336 297.173 278.829 299.072 278.276 300.942L279.235 301.226C278.668 303.143 278.053 305.029 277.392 306.882L276.45 306.547C275.785 308.412 275.073 310.243 274.316 312.037L275.237 312.426C274.46 314.268 273.636 316.072 272.768 317.834L271.871 317.392C270.996 319.167 270.075 320.899 269.111 322.586L269.979 323.082C268.987 324.818 267.949 326.507 266.868 328.144L266.033 327.593C264.941 329.247 263.805 330.847 262.628 332.391L263.423 332.997C262.208 334.589 260.95 336.123 259.65 337.593L258.901 336.931C257.592 338.411 256.242 339.826 254.853 341.173L255.549 341.891C254.112 343.285 252.632 344.607 251.114 345.853L250.479 345.08C248.955 346.331 247.392 347.504 245.793 348.594L246.356 349.42C244.707 350.544 243.02 351.583 241.297 352.531L240.815 351.655C239.096 352.602 237.343 353.456 235.559 354.213L235.95 355.134C234.12 355.911 232.257 356.589 230.364 357.162L230.075 356.204C228.213 356.768 226.323 357.229 224.409 357.581L224.59 358.564C222.649 358.922 220.683 359.17 218.696 359.305L218.628 358.307C216.703 358.437 214.757 358.459 212.794 358.367L212.747 359.366C210.796 359.274 208.827 359.073 206.845 358.758L207.002 357.77C206.045 357.618 205.085 357.438 204.121 357.231L201.311 356.626L201.101 357.604L195.48 356.395L195.691 355.417L190.07 354.208L189.86 355.186L184.24 353.976L184.45 352.999L178.83 351.79L178.62 352.767L172.999 351.558L173.21 350.581L167.59 349.371L167.379 350.349L161.759 349.14L161.969 348.162L156.349 346.953L156.139 347.931L150.519 346.722L150.729 345.744L147.919 345.14C146.85 344.91 145.778 344.713 144.704 344.549L144.553 345.537C142.43 345.213 140.298 345.02 138.166 344.958L138.195 343.959C136.016 343.896 133.836 343.967 131.662 344.173L131.756 345.168C129.636 345.369 127.522 345.699 125.42 346.16L125.206 345.183C124.146 345.415 123.089 345.68 122.037 345.977L118.792 346.892L119.063 347.855L112.574 349.686L112.302 348.723L105.813 350.554L106.084 351.517L99.5946 353.348L99.323 352.385L92.8334 354.217L93.105 355.179L86.6154 357.01L86.3438 356.048L83.099 356.963C82.1341 357.235 81.172 357.479 80.2132 357.696L80.4333 358.671C78.4437 359.12 76.4665 359.452 74.5049 359.672L74.3934 358.679C72.4105 358.901 70.4444 359.006 68.4983 359L68.4949 360C66.4691 359.993 64.464 359.867 62.4832 359.627L62.6033 358.635C60.6418 358.397 58.7041 358.046 56.794 357.586L56.5599 358.558C54.6085 358.088 52.6858 357.507 50.7953 356.82L51.1368 355.88C49.2919 355.21 47.4773 354.437 45.6967 353.565L45.2572 354.464C43.4651 353.587 41.7078 352.613 39.9889 351.547L40.5159 350.697C38.8488 349.663 37.2174 348.541 35.6251 347.335L35.0213 348.132C33.4367 346.932 31.8911 345.65 30.3877 344.292L31.058 343.55C29.6033 342.236 28.188 340.849 26.8152 339.393L26.0876 340.079C24.7234 338.632 23.4012 337.119 22.1238 335.543L22.9007 334.913C21.6628 333.386 20.4671 331.799 19.3162 330.155L18.4971 330.729C17.3551 329.098 16.2572 327.413 15.2059 325.677L16.0613 325.159C15.042 323.477 14.0668 321.746 13.1381 319.97L12.2519 320.433C11.3297 318.67 10.453 316.863 9.62422 315.016L10.5366 314.607C9.72926 312.808 8.96764 310.97 8.25389 309.096L7.3194 309.452C6.61006 307.59 5.94766 305.693 5.33426 303.765L6.28721 303.462C5.68844 301.58 5.13672 299.667 4.63403 297.726L3.66597 297.977C3.16592 296.046 2.714 294.089 2.31209 292.107L3.29214 291.908C2.89917 289.97 2.55441 288.008 2.25967 286.026L1.27054 286.173C0.977122 284.199 0.732868 282.205 0.539515 280.193L1.53493 280.098C1.34567 278.128 1.20559 276.141 1.11636 274.14L0.11735 274.184C0.0284803 272.191 -0.0103842 270.182 0.00236513 268.161L1.00235 268.168C1.01483 266.189 1.07723 264.198 1.19108 262.198L0.192699 262.141C0.306082 260.149 0.470063 258.147 0.686137 256.138L1.6804 256.245C1.89197 254.277 2.15389 252.303 2.46761 250.324L1.47994 250.167C1.79219 248.197 2.15532 246.222 2.57071 244.244L3.54937 244.449C3.75409 243.474 3.97161 242.498 4.20211 241.522L4.88021 238.651L3.90698 238.421L5.26319 232.677L6.23643 232.907L7.59264 227.163L6.6194 226.934L7.97561 221.19L8.94885 221.42L10.3051 215.676L9.33183 215.446L10.688 209.703L11.6613 209.933L12.3394 207.061C12.595 205.978 12.8352 204.891 13.0599 203.8L12.0805 203.598C12.5249 201.439 12.9085 199.264 13.2312 197.077L14.2205 197.223C14.545 195.023 14.8083 192.812 15.0106 190.593L14.0147 190.502C14.2149 188.305 14.3546 186.101 14.4339 183.894L15.4333 183.93C15.5132 181.706 15.5322 179.479 15.4904 177.254L14.4906 177.273C14.449 175.065 14.3471 172.859 14.1848 170.658L15.1821 170.585C15.0182 168.363 14.7932 166.148 14.5071 163.942L13.5154 164.071C13.2311 161.879 12.8859 159.697 12.4798 157.531L13.4627 157.346C13.2575 156.251 13.0369 155.16 12.8008 154.073L12.1197 150.936L11.1425 151.149L9.78035 144.876L10.7576 144.663L9.39541 138.39L8.41819 138.603L7.05603 132.329L8.03325 132.117L6.67109 125.844L5.69386 126.056L4.3317 119.783L5.30893 119.571L4.62785 116.435C4.40892 115.426 4.20367 114.419 4.01195 113.412L3.0296 113.599C2.6404 111.555 2.30643 109.514 2.02619 107.48L3.01683 107.343C2.73537 105.299 2.50856 103.261 2.33487 101.232L1.33851 101.317C1.16117 99.2445 1.03875 97.1804 0.969626 95.1272L1.96906 95.0935C1.89967 93.0322 1.88446 90.9819 1.92177 88.9453L0.921936 88.9269C0.960033 86.8474 1.05243 84.782 1.19739 82.7332L2.1949 82.8037C2.34045 80.7467 2.53944 78.7066 2.79008 76.6864L1.79769 76.5632C2.05384 74.4985 2.3635 72.4542 2.72478 70.4331L3.70917 70.6091C4.07252 68.5765 4.48851 66.5678 4.9552 64.5859L3.98183 64.3567C4.45936 62.3288 4.98954 60.3287 5.57034 58.3593L6.52949 58.6422C7.11359 56.6616 7.74927 54.7128 8.43439 52.7989L7.49289 52.4619C8.19526 50.4999 8.9492 48.574 9.7525 46.6876L10.6726 47.0794C11.4811 45.1805 12.3401 43.3226 13.247 41.5089L12.3525 41.0617C13.2853 39.1963 14.2685 37.3771 15.2997 35.6076L16.1637 36.1111C17.2044 34.3253 18.2942 32.5913 19.4304 30.9131L18.6023 30.3525C19.773 28.6233 20.9929 26.9522 22.259 25.3434L23.0448 25.9618C24.3198 24.3417 25.6419 22.7862 27.0079 21.2997L26.2715 20.623C27.6852 19.0847 29.1459 17.6186 30.6507 16.2296L31.329 16.9645C32.8423 15.5676 34.3999 14.2505 35.9985 13.018L35.3879 12.2261C37.038 10.9539 38.732 9.76983 40.4664 8.67927L40.9987 9.52582C42.7339 8.43479 44.5091 7.43951 46.3207 6.54526L45.8781 5.64855C47.7398 4.72953 49.6405 3.91486 51.5763 3.21034L51.9183 4.15004C53.8272 3.45529 55.7701 2.86992 57.7432 2.39951L57.5113 1.42677C59.5151 0.94907 61.5501 0.587504 63.6127 0.34789L63.7281 1.34121C65.7278 1.10891 67.754 0.993462 69.8032 1.00042L69.8066 0.000424476C71.8446 0.00734302 73.9046 0.13301 75.9834 0.382643L75.8642 1.37551C76.8675 1.496 77.8756 1.64594 78.888 1.82596L81.6279 2.31319L81.8029 1.32864L87.2827 2.3031L87.1076 3.28765L92.5874 4.26211L92.7624 3.27755L98.2422 4.25201L98.0671 5.23656L103.547 6.21102L103.722 5.22647L109.202 6.20092L109.027 7.18548L114.506 8.15993L114.681 7.17538L120.161 8.14984L119.986 9.13439L125.466 10.1088L125.641 9.12429L131.121 10.0987L130.946 11.0833L133.686 11.5705C134.457 11.7078 135.231 11.828 136.005 11.9311L136.137 10.9398C137.663 11.1431 139.194 11.2786 140.725 11.3465L140.681 12.3455C142.245 12.4148 143.811 12.4148 145.376 12.3455L145.331 11.3465C146.863 11.2786 148.393 11.1431 149.92 10.9398L150.052 11.9311C150.826 11.828 151.599 11.7078 152.371 11.5705L155.265 11.0558L155.09 10.0712L160.879 9.0418L161.054 10.0264L166.843 8.9969L166.668 8.01235L172.457 6.98289L172.632 7.96745L178.421 6.938L178.246 5.95344L184.035 4.92399L184.21 5.90855L190 4.87909L189.824 3.89454L195.613 2.86509L195.789 3.84964L201.578 2.82019L201.402 1.83564L207.191 0.806183L207.367 1.79074L210.169 1.29243C211.126 1.30346 212.073 1.33002 213.01 1.37194L213.055 0.372942C215.056 0.462464 217.013 0.62123 218.926 0.847642L218.809 1.84071C220.772 2.07302 222.687 2.37734 224.555 2.75175L224.752 1.77124C226.714 2.16436 228.625 2.63387 230.487 3.17779L230.206 4.13766C232.088 4.68748 233.918 5.31427 235.695 6.01581L236.062 5.08563C237.909 5.8145 239.702 6.62306 241.441 7.509L240.987 8.40002C242.72 9.28284 244.399 10.2437 246.023 11.2804L246.561 10.4374C248.221 11.4962 249.825 12.6329 251.375 13.8448L250.759 14.6325C252.278 15.8209 253.745 17.0833 255.159 18.4175L255.846 17.6901C257.268 19.0322 258.638 20.4453 259.956 21.9271L259.209 22.5917C260.484 24.026 261.711 25.5263 262.889 27.0908L263.687 26.4893C264.858 28.0434 265.98 29.6591 267.054 31.3342L266.213 31.8742C267.25 33.4915 268.244 35.1659 269.193 36.8954L270.07 36.4142C271.003 38.1133 271.893 39.8642 272.741 41.6651L271.837 42.0912C272.655 43.8288 273.434 45.6142 274.175 47.4459L275.102 47.0711C275.83 48.8715 276.52 50.7153 277.173 52.6011L276.228 52.9283C276.859 54.75 277.455 56.6117 278.016 58.5123L278.975 58.229C279.524 60.0887 280.041 61.9846 280.524 63.9155L279.554 64.1584C280.023 66.0285 280.46 67.932 280.867 69.868L281.846 69.6622C282.246 71.5633 282.616 73.4948 282.957 75.4557L281.972 75.6271C282.303 77.5315 282.607 79.4642 282.883 81.4242L283.874 81.2846C284.145 83.2108 284.39 85.1628 284.609 87.1397L283.616 87.2498C283.829 89.175 284.017 91.1241 284.181 93.0964L285.177 93.0137C285.339 94.9544 285.476 96.917 285.589 98.9007L284.591 98.9578C284.702 100.895 284.79 102.852 284.856 104.829L285.855 104.796C285.92 106.744 285.963 108.711 285.984 110.696L284.984 110.707C284.994 111.655 285 112.608 285 113.564L284.434 116.47Z"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        stroke="currentcolor" stroke-width="2" stroke-dasharray="6 6">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="icon-xl">
                                            <img src="{{ helper::image_path($category->image) }}" class="card-img-top"
                                                alt="">

                                        </div>
                                        <div class="card-body">
                                            <P class="mb-1 text-center fs-7 text-primary-color m-0 text-truncate">
                                                {{ trans('labels.services') }}
                                                {{ helper::service_count($category->id) . '+' }}
                                            </P>
                                            <h5 class="m-0 text-center fw-600 text-truncate1 fs-16">
                                                {{ $category->name }}
                                            </h5>
                                            <a class="fs-6 fw-semibold btn btn-primary-rgb rounded-5 mt-3"
                                                href="{{ URL::to($vendordata->slug . '/services?category=' . $category->slug . '&search_input=') }}">Show</a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="category__shape-wrap">
                    <img src="storage\app\public\front\images\services_shape01.png" alt="img" class="ribbonRotate">
                    <img src="storage\app\public\front\images\services_shape02.png" alt="img"
                        data-aos="fade-up-right" data-aos-delay="800" class="cat aos-init aos-animate">
                    <img src="storage\app\public\front\images\services_shape03.png" alt="img"
                        data-aos="fade-down-left" data-aos-delay="400" class="cat-hand2 aos-init aos-animate">
                </div>
            </section>
        @endif
        <!----------------------------------------------------- category section ----------------------------------------------------->

        <!----------------------------------------------------- banner-section-2 ----------------------------------------------------->
        @if (@$getbannersection2->count() > 0)
            <section class="banner-section pt-90">
                <div class="container">
                    <div id="carouselExampleSlides1" class="owl-carousel owl-theme rounded-4 overflow-hidden">
                        @foreach ($getbannersection2 as $key => $banner2)
                            <div class="item {{ $key == 0 ? 'active' : '' }} rounded-4 overflow-hidden">
                                @if ($banner2->type == 1)
                                    <a class="cursor-pointer"
                                        href="{{ URL::to($vendordata->slug . '/services?category=' . $banner2['category_info']->slug) }}">
                                    @elseif($banner2->type == 2)
                                        @php
                                            $service = helper::servicedetails($banner2->service_id, $vendordata->id);
                                        @endphp
                                        <a class="cursor-pointer"
                                            href="{{ URL::to(@$vendordata->slug . '/service-' . $service->slug) }}">
                                        @else
                                            <a class="cursor-pointer" href="javascript:void(0)">
                                @endif
                                <img src="{{ helper::image_path($banner2->image) }}"
                                    class="d-block w-100 rounded-4 overflow-hidden"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
        <!---------------------------------------------------- banner-section-2 ---------------------------------------------------->

        <!------------------------------------------------ top-service section start ------------------------------------------------>
        @if ($gettoprated->count() > 0)
            <section class="top-category pt-90 pb-90">
                <div class="container">
                    <!-- Title -->
                    <div class="d-flex gap-3 align-items-center justify-content-between pb-5">
                        <div class="">
                            <h3 class="fw-600 theme-3-title line-1 fs-3 color-changer">
                                {{ trans('labels.top_ratted_services') }}
                            </h3>
                            <p class="fw-semibold text-primary-color m-0 line-1">
                                {{ trans('labels.top_ratted_services_sub_title') }}
                            </p>
                        </div>
                        <a href="{{ URL::to($vendordata->slug . '/services') }}"
                            class="fw-semibold btn btn-primary-rgb rounded-5 col-auto">{{ trans('labels.view_all') }}<i
                                class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-regular fa-arrow-left' : 'fa-regular fa-arrow-right' }}"></i></a>
                    </div>
                    <!-- Listing -->
                    <div class="row g-4">
                        @foreach ($gettoprated as $toprated)
                            @php
                                if ($toprated->top_deals == 1 && @helper::top_deals($vendordata->id) != null) {
                                    if (@helper::top_deals($vendordata->id)->offer_type == 1) {
                                        if ($toprated->price > @helper::top_deals($vendordata->id)->offer_amount) {
                                            $tprice =
                                                $toprated->price - @helper::top_deals($vendordata->id)->offer_amount;
                                        } else {
                                            $tprice = $toprated->price;
                                        }
                                    } else {
                                        $tprice =
                                            $toprated->price -
                                            $toprated->price *
                                                (@helper::top_deals($vendordata->id)->offer_amount / 100);
                                    }
                                    $toriginal_price = $toprated->price;
                                    $off =
                                        $toriginal_price > 0
                                            ? number_format(100 - ($tprice * 100) / $toriginal_price, 1)
                                            : 0;
                                } else {
                                    $tprice = $toprated->price;
                                    $toriginal_price = $toprated->original_price;
                                    $off = $toprated->discount_percentage;
                                }
                            @endphp
                            <!-- Card item -->
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                                <div class="card p-md-5 p-sm-4 p-5 bg-transparent border-0 rounded-4 h-100">
                                    <div class="services__shape">
                                        <div class="shape-one">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 303 378" fill="none"
                                                x="0px" y="0px" preserveAspectRatio="none"
                                                data-inject-url="storage\app\public\front\images\services_shape01.svg"
                                                class="injectable">
                                                <path
                                                    d="M3.85747 122.642C-10.6791 56.2814 31.4447 -7.84076 83.5423 1.34287L141.444 11.5497C147.873 12.683 154.389 12.683 160.818 11.5497L221.988 0.766826C277.534 1.34278 302.203 50.4246 302.203 119.514L292.324 169.8C289.656 183.385 289.294 197.575 291.264 211.365L298.723 263.557C308.036 328.73 265.288 386.288 215.463 375.662L156.077 362.997C147.167 361.097 138.066 361.389 129.237 363.858L88.0938 375.366C33.5856 390.611 -13.2316 323.07 3.41183 253.2L12.0101 217.104C16.2711 199.216 16.4391 180.078 12.4935 162.065L3.85747 122.642Z"
                                                    fill="currentcolor"></path>
                                            </svg>
                                        </div>
                                        <div class="shape-two">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 286 360" fill="none"
                                                x="0px" y="0px" preserveAspectRatio="none"
                                                data-inject-url="storage\app\public\front\images\services_shape02.svg"
                                                class="injectable">
                                                <path class="animation-dashed" vector-effect="non-scaling-stroke"
                                                    d="M284.434 116.47L285.416 116.661L284.247 122.662L283.266 122.471L282.097 128.472L283.078 128.663L281.91 134.665L280.928 134.473L279.76 140.475L280.741 140.666L279.573 146.667L278.591 146.476L277.423 152.477L278.404 152.668L277.236 158.669L276.254 158.478L275.67 161.479C275.456 162.574 275.258 163.674 275.076 164.777L276.063 164.94C275.702 167.122 275.402 169.319 275.163 171.524L274.169 171.417C273.929 173.635 273.75 175.863 273.633 178.096L274.631 178.148C274.515 180.359 274.459 182.575 274.465 184.792L273.465 184.794C273.47 187.028 273.537 189.262 273.665 191.492L274.664 191.434C274.791 193.647 274.979 195.855 275.228 198.056L274.234 198.168C274.36 199.278 274.501 200.387 274.658 201.492L275.099 204.606L276.089 204.466L276.971 210.695L275.981 210.835L276.864 217.064L277.854 216.923L278.736 223.152L277.746 223.292L278.628 229.521L279.618 229.38L280.501 235.609L279.51 235.749L280.393 241.978L281.383 241.838L282.265 248.066L281.275 248.206L281.716 251.321C281.855 252.301 281.982 253.279 282.096 254.255L283.089 254.139C283.321 256.121 283.504 258.095 283.638 260.059L282.64 260.127C282.775 262.102 282.861 264.067 282.899 266.018L283.898 265.999C283.937 267.994 283.926 269.977 283.867 271.944L282.868 271.914C282.808 273.892 282.7 275.855 282.544 277.801L283.541 277.88C283.382 279.87 283.174 281.841 282.918 283.792L281.926 283.662C281.669 285.624 281.363 287.565 281.011 289.483L281.994 289.663C281.633 291.626 281.224 293.565 280.768 295.478L279.795 295.246C279.336 297.173 278.829 299.072 278.276 300.942L279.235 301.226C278.668 303.143 278.053 305.029 277.392 306.882L276.45 306.547C275.785 308.412 275.073 310.243 274.316 312.037L275.237 312.426C274.46 314.268 273.636 316.072 272.768 317.834L271.871 317.392C270.996 319.167 270.075 320.899 269.111 322.586L269.979 323.082C268.987 324.818 267.949 326.507 266.868 328.144L266.033 327.593C264.941 329.247 263.805 330.847 262.628 332.391L263.423 332.997C262.208 334.589 260.95 336.123 259.65 337.593L258.901 336.931C257.592 338.411 256.242 339.826 254.853 341.173L255.549 341.891C254.112 343.285 252.632 344.607 251.114 345.853L250.479 345.08C248.955 346.331 247.392 347.504 245.793 348.594L246.356 349.42C244.707 350.544 243.02 351.583 241.297 352.531L240.815 351.655C239.096 352.602 237.343 353.456 235.559 354.213L235.95 355.134C234.12 355.911 232.257 356.589 230.364 357.162L230.075 356.204C228.213 356.768 226.323 357.229 224.409 357.581L224.59 358.564C222.649 358.922 220.683 359.17 218.696 359.305L218.628 358.307C216.703 358.437 214.757 358.459 212.794 358.367L212.747 359.366C210.796 359.274 208.827 359.073 206.845 358.758L207.002 357.77C206.045 357.618 205.085 357.438 204.121 357.231L201.311 356.626L201.101 357.604L195.48 356.395L195.691 355.417L190.07 354.208L189.86 355.186L184.24 353.976L184.45 352.999L178.83 351.79L178.62 352.767L172.999 351.558L173.21 350.581L167.59 349.371L167.379 350.349L161.759 349.14L161.969 348.162L156.349 346.953L156.139 347.931L150.519 346.722L150.729 345.744L147.919 345.14C146.85 344.91 145.778 344.713 144.704 344.549L144.553 345.537C142.43 345.213 140.298 345.02 138.166 344.958L138.195 343.959C136.016 343.896 133.836 343.967 131.662 344.173L131.756 345.168C129.636 345.369 127.522 345.699 125.42 346.16L125.206 345.183C124.146 345.415 123.089 345.68 122.037 345.977L118.792 346.892L119.063 347.855L112.574 349.686L112.302 348.723L105.813 350.554L106.084 351.517L99.5946 353.348L99.323 352.385L92.8334 354.217L93.105 355.179L86.6154 357.01L86.3438 356.048L83.099 356.963C82.1341 357.235 81.172 357.479 80.2132 357.696L80.4333 358.671C78.4437 359.12 76.4665 359.452 74.5049 359.672L74.3934 358.679C72.4105 358.901 70.4444 359.006 68.4983 359L68.4949 360C66.4691 359.993 64.464 359.867 62.4832 359.627L62.6033 358.635C60.6418 358.397 58.7041 358.046 56.794 357.586L56.5599 358.558C54.6085 358.088 52.6858 357.507 50.7953 356.82L51.1368 355.88C49.2919 355.21 47.4773 354.437 45.6967 353.565L45.2572 354.464C43.4651 353.587 41.7078 352.613 39.9889 351.547L40.5159 350.697C38.8488 349.663 37.2174 348.541 35.6251 347.335L35.0213 348.132C33.4367 346.932 31.8911 345.65 30.3877 344.292L31.058 343.55C29.6033 342.236 28.188 340.849 26.8152 339.393L26.0876 340.079C24.7234 338.632 23.4012 337.119 22.1238 335.543L22.9007 334.913C21.6628 333.386 20.4671 331.799 19.3162 330.155L18.4971 330.729C17.3551 329.098 16.2572 327.413 15.2059 325.677L16.0613 325.159C15.042 323.477 14.0668 321.746 13.1381 319.97L12.2519 320.433C11.3297 318.67 10.453 316.863 9.62422 315.016L10.5366 314.607C9.72926 312.808 8.96764 310.97 8.25389 309.096L7.3194 309.452C6.61006 307.59 5.94766 305.693 5.33426 303.765L6.28721 303.462C5.68844 301.58 5.13672 299.667 4.63403 297.726L3.66597 297.977C3.16592 296.046 2.714 294.089 2.31209 292.107L3.29214 291.908C2.89917 289.97 2.55441 288.008 2.25967 286.026L1.27054 286.173C0.977122 284.199 0.732868 282.205 0.539515 280.193L1.53493 280.098C1.34567 278.128 1.20559 276.141 1.11636 274.14L0.11735 274.184C0.0284803 272.191 -0.0103842 270.182 0.00236513 268.161L1.00235 268.168C1.01483 266.189 1.07723 264.198 1.19108 262.198L0.192699 262.141C0.306082 260.149 0.470063 258.147 0.686137 256.138L1.6804 256.245C1.89197 254.277 2.15389 252.303 2.46761 250.324L1.47994 250.167C1.79219 248.197 2.15532 246.222 2.57071 244.244L3.54937 244.449C3.75409 243.474 3.97161 242.498 4.20211 241.522L4.88021 238.651L3.90698 238.421L5.26319 232.677L6.23643 232.907L7.59264 227.163L6.6194 226.934L7.97561 221.19L8.94885 221.42L10.3051 215.676L9.33183 215.446L10.688 209.703L11.6613 209.933L12.3394 207.061C12.595 205.978 12.8352 204.891 13.0599 203.8L12.0805 203.598C12.5249 201.439 12.9085 199.264 13.2312 197.077L14.2205 197.223C14.545 195.023 14.8083 192.812 15.0106 190.593L14.0147 190.502C14.2149 188.305 14.3546 186.101 14.4339 183.894L15.4333 183.93C15.5132 181.706 15.5322 179.479 15.4904 177.254L14.4906 177.273C14.449 175.065 14.3471 172.859 14.1848 170.658L15.1821 170.585C15.0182 168.363 14.7932 166.148 14.5071 163.942L13.5154 164.071C13.2311 161.879 12.8859 159.697 12.4798 157.531L13.4627 157.346C13.2575 156.251 13.0369 155.16 12.8008 154.073L12.1197 150.936L11.1425 151.149L9.78035 144.876L10.7576 144.663L9.39541 138.39L8.41819 138.603L7.05603 132.329L8.03325 132.117L6.67109 125.844L5.69386 126.056L4.3317 119.783L5.30893 119.571L4.62785 116.435C4.40892 115.426 4.20367 114.419 4.01195 113.412L3.0296 113.599C2.6404 111.555 2.30643 109.514 2.02619 107.48L3.01683 107.343C2.73537 105.299 2.50856 103.261 2.33487 101.232L1.33851 101.317C1.16117 99.2445 1.03875 97.1804 0.969626 95.1272L1.96906 95.0935C1.89967 93.0322 1.88446 90.9819 1.92177 88.9453L0.921936 88.9269C0.960033 86.8474 1.05243 84.782 1.19739 82.7332L2.1949 82.8037C2.34045 80.7467 2.53944 78.7066 2.79008 76.6864L1.79769 76.5632C2.05384 74.4985 2.3635 72.4542 2.72478 70.4331L3.70917 70.6091C4.07252 68.5765 4.48851 66.5678 4.9552 64.5859L3.98183 64.3567C4.45936 62.3288 4.98954 60.3287 5.57034 58.3593L6.52949 58.6422C7.11359 56.6616 7.74927 54.7128 8.43439 52.7989L7.49289 52.4619C8.19526 50.4999 8.9492 48.574 9.7525 46.6876L10.6726 47.0794C11.4811 45.1805 12.3401 43.3226 13.247 41.5089L12.3525 41.0617C13.2853 39.1963 14.2685 37.3771 15.2997 35.6076L16.1637 36.1111C17.2044 34.3253 18.2942 32.5913 19.4304 30.9131L18.6023 30.3525C19.773 28.6233 20.9929 26.9522 22.259 25.3434L23.0448 25.9618C24.3198 24.3417 25.6419 22.7862 27.0079 21.2997L26.2715 20.623C27.6852 19.0847 29.1459 17.6186 30.6507 16.2296L31.329 16.9645C32.8423 15.5676 34.3999 14.2505 35.9985 13.018L35.3879 12.2261C37.038 10.9539 38.732 9.76983 40.4664 8.67927L40.9987 9.52582C42.7339 8.43479 44.5091 7.43951 46.3207 6.54526L45.8781 5.64855C47.7398 4.72953 49.6405 3.91486 51.5763 3.21034L51.9183 4.15004C53.8272 3.45529 55.7701 2.86992 57.7432 2.39951L57.5113 1.42677C59.5151 0.94907 61.5501 0.587504 63.6127 0.34789L63.7281 1.34121C65.7278 1.10891 67.754 0.993462 69.8032 1.00042L69.8066 0.000424476C71.8446 0.00734302 73.9046 0.13301 75.9834 0.382643L75.8642 1.37551C76.8675 1.496 77.8756 1.64594 78.888 1.82596L81.6279 2.31319L81.8029 1.32864L87.2827 2.3031L87.1076 3.28765L92.5874 4.26211L92.7624 3.27755L98.2422 4.25201L98.0671 5.23656L103.547 6.21102L103.722 5.22647L109.202 6.20092L109.027 7.18548L114.506 8.15993L114.681 7.17538L120.161 8.14984L119.986 9.13439L125.466 10.1088L125.641 9.12429L131.121 10.0987L130.946 11.0833L133.686 11.5705C134.457 11.7078 135.231 11.828 136.005 11.9311L136.137 10.9398C137.663 11.1431 139.194 11.2786 140.725 11.3465L140.681 12.3455C142.245 12.4148 143.811 12.4148 145.376 12.3455L145.331 11.3465C146.863 11.2786 148.393 11.1431 149.92 10.9398L150.052 11.9311C150.826 11.828 151.599 11.7078 152.371 11.5705L155.265 11.0558L155.09 10.0712L160.879 9.0418L161.054 10.0264L166.843 8.9969L166.668 8.01235L172.457 6.98289L172.632 7.96745L178.421 6.938L178.246 5.95344L184.035 4.92399L184.21 5.90855L190 4.87909L189.824 3.89454L195.613 2.86509L195.789 3.84964L201.578 2.82019L201.402 1.83564L207.191 0.806183L207.367 1.79074L210.169 1.29243C211.126 1.30346 212.073 1.33002 213.01 1.37194L213.055 0.372942C215.056 0.462464 217.013 0.62123 218.926 0.847642L218.809 1.84071C220.772 2.07302 222.687 2.37734 224.555 2.75175L224.752 1.77124C226.714 2.16436 228.625 2.63387 230.487 3.17779L230.206 4.13766C232.088 4.68748 233.918 5.31427 235.695 6.01581L236.062 5.08563C237.909 5.8145 239.702 6.62306 241.441 7.509L240.987 8.40002C242.72 9.28284 244.399 10.2437 246.023 11.2804L246.561 10.4374C248.221 11.4962 249.825 12.6329 251.375 13.8448L250.759 14.6325C252.278 15.8209 253.745 17.0833 255.159 18.4175L255.846 17.6901C257.268 19.0322 258.638 20.4453 259.956 21.9271L259.209 22.5917C260.484 24.026 261.711 25.5263 262.889 27.0908L263.687 26.4893C264.858 28.0434 265.98 29.6591 267.054 31.3342L266.213 31.8742C267.25 33.4915 268.244 35.1659 269.193 36.8954L270.07 36.4142C271.003 38.1133 271.893 39.8642 272.741 41.6651L271.837 42.0912C272.655 43.8288 273.434 45.6142 274.175 47.4459L275.102 47.0711C275.83 48.8715 276.52 50.7153 277.173 52.6011L276.228 52.9283C276.859 54.75 277.455 56.6117 278.016 58.5123L278.975 58.229C279.524 60.0887 280.041 61.9846 280.524 63.9155L279.554 64.1584C280.023 66.0285 280.46 67.932 280.867 69.868L281.846 69.6622C282.246 71.5633 282.616 73.4948 282.957 75.4557L281.972 75.6271C282.303 77.5315 282.607 79.4642 282.883 81.4242L283.874 81.2846C284.145 83.2108 284.39 85.1628 284.609 87.1397L283.616 87.2498C283.829 89.175 284.017 91.1241 284.181 93.0964L285.177 93.0137C285.339 94.9544 285.476 96.917 285.589 98.9007L284.591 98.9578C284.702 100.895 284.79 102.852 284.856 104.829L285.855 104.796C285.92 106.744 285.963 108.711 285.984 110.696L284.984 110.707C284.994 111.655 285 112.608 285 113.564L284.434 116.47Z"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke="currentcolor"
                                                    stroke-width="2" stroke-dasharray="6 6"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="d-flex flex-column ">
                                            <!-- Image and text -->
                                            <div
                                                class="image_shape h-110px rounded-2 position-relative overflow-hidden mb-3 mx-auto">
                                                <img src="{{ helper::image_path($toprated['service_image']->image) }}"
                                                    class="h-110px rounded-2" alt="">
                                                <div class="card-img-overlay p-2 z-index-1">
                                                    @if (@helper::checkaddons('customer_login'))
                                                        @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                            <div
                                                                class="badges bg-danger rounded-circle {{ session()->get('direction') == '2' ? 'float-start' : 'float-end' }}">
                                                                <button
                                                                    onclick="managefavorite('{{ $toprated->id }}',{{ $vendordata->id }},'{{ URL::to(@$vendordata->slug . '/managefavorite') }}')"
                                                                    class="btn border-0 text-white fs-6">
                                                                    @if (Auth::user() && Auth::user()->type == 3)
                                                                        @php
                                                                            $favorite = helper::ceckfavorite(
                                                                                $toprated->id,
                                                                                $vendordata->id,
                                                                                Auth::user()->id,
                                                                            );
                                                                        @endphp
                                                                        @if (!empty($favorite) && $favorite->count() > 0)
                                                                            <i class="fa-solid fa-fw fa-heart"></i>
                                                                        @else
                                                                            <i class="fa-regular fa-heart"></i>
                                                                        @endif
                                                                    @else
                                                                        <i class="fa-regular fa-heart"></i>
                                                                    @endif
                                                                </button>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <h5
                                                class="fs-13 fw-600 mb-0 text-center text-capitalize text_truncation2 col-12">
                                                <a
                                                    href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}">{{ Str::limit($toprated->name, 50) }}</a>
                                            </h5>
                                            <div
                                                class="d-flex align-items-center {{ $off > 0 ? 'justify-content-between' : 'justify-content-center' }} mt-2">
                                                @if ($off > 0)
                                                    <span
                                                        class="{{ session()->get('direction') == '2' ? 'service-right-label-2' : 'service-left-label-2 ' }} fs-9">
                                                        {{ $off }}% {{ trans('labels.off') }}
                                                    </span>
                                                @endif
                                                @if (@helper::checkaddons('product_reviews'))
                                                    @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                        <p class="fw-semibold m-0 text-center fs-7">
                                                            <i class="fas fa-star fa-fw text-warning"></i>
                                                            {{ $toprated->ratings_average == null ? number_format(0, 1) : number_format($toprated->ratings_average, 1) }}
                                                        </p>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer border-top-0 p-0 mt-2 bg-transparent">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-1">
                                                <p class="fs-18 col-auto m-0 fw-600 text-truncate">
                                                    {{ helper::currency_formate($tprice, $vendordata->id) }}
                                                </p>
                                                @if ($toriginal_price > $tprice)
                                                    <del class="fs-18 col-8 m-0 fw-600 text-truncate text-muted">
                                                        {{ helper::currency_formate($toriginal_price, $vendordata->id) }}
                                                    </del>
                                                @endif
                                            </div>
                                            @if (helper::appdata($vendordata->id)->online_order == 1)
                                                <a href="{{ URL::to($vendordata->slug . '/booking-' . $toprated->id) }}"
                                                    class="btn btn-primary-rgb btn-round flex-shrink-0 ms-2 mb-0"><i
                                                        class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left' : 'fa-solid fa-arrow-right' }}"></i></a>
                                            @else
                                                <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                    class="btn btn-primary-rgb btn-round flex-shrink-0 ms-2 mb-0"><i
                                                        class="fa-regular fa-eye"></i></a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </section>
        @endif
        <!------------------------------------------------- top-service section end ------------------------------------------------->

        @if (@helper::checkaddons('store_reviews'))
            <!------------------------------------------------ testimonial section start ------------------------------------------------>
            @if ($testimonials->count() > 0)
                <section class="testimonial bg-lights position-relative pt-90 pb-90">
                    <div class="container">

                        <div class="row g-4 align-items-center justify-content-center">
                            <div class="col-xl-5 col-lg-6 col-md-10">
                                <div class="testimonial_img-two">
                                    <div class="testimonial_img-mask-two">
                                        <img src="https://themedox.com/demo/petpal/assets/img/images/h3_testimonial_img.jpg"
                                            alt="img">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-7 col-lg-6">
                                <div
                                    class="position-relative {{ session()->get('direction') == 2 ? 'me-md-5 me-0' : 'ms-md-5 ms-0' }}">
                                    <!-- Title -->
                                    <div class="mb-4">
                                        <div class="mb-3 mb-sm-4">
                                            <p class="fw-semibold text-primary-color m-0 text-truncate ">
                                                {{ trans('labels.testimonial_subtitle') }}
                                            </p>
                                            <h5 class="fw-600 theme-3-title fs-3 color-changer">
                                                {{ trans('labels.testimonial_title') }}
                                            </h5>
                                        </div>
                                    </div>
                                    <!-- Slider START -->
                                    <div id="testimonial8"
                                        class="owl-carousel owl-theme {{ session()->get('direction') == 2 ? 'rtl' : ' ' }}">
                                        @foreach ($testimonials as $testimonial)
                                            <div class="item my-4">
                                                <div
                                                    class="card h-100 bg-transparent border-0 rounded-4 position-relative overflow-hidden">
                                                    <div class="d-sm-flex gap-4 align-items-center mb-4">
                                                        <div class="testimonial_author mb-sm-0 mb-3">
                                                            <img src="{{ helper::image_path($testimonial->image) }}"
                                                                alt="avatar">
                                                        </div>
                                                        <div>
                                                            <!-- Content -->
                                                            <p class="text-muted text-start fs-7 text_truncation3 m-0">
                                                                {{ $testimonial->description }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center gap-md-4 gap-2">
                                                        <div class="testimonial_icon-three">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="59"
                                                                height="44" viewBox="0 0 59 44" fill="none"
                                                                data-inject-url="https://themedox.com/demo/petpal/assets/img/icon/quote.svg"
                                                                class="injectable">
                                                                <path
                                                                    d="M13.4098 18.5471H13.4099C15.7203 18.5469 17.9834 19.2004 19.9376 20.4319C21.8917 21.6634 23.4569 23.4225 24.4523 25.5056C25.4477 27.5887 25.8325 29.9109 25.5623 32.2034C25.2922 34.4959 24.378 36.6652 22.9256 38.4604C21.4732 40.2556 19.5417 41.6032 17.3547 42.3474C15.1677 43.0916 12.8145 43.2018 10.5674 42.6653C8.32025 42.1288 6.27113 40.9676 4.657 39.316C3.04287 37.6644 1.9297 35.59 1.44614 33.3328L1.23338 32.3397L1.22723 32.3411C1.18993 32.0514 1.1541 31.7315 1.13033 31.4085L1.12946 31.3968L1.12833 31.3851C1.01009 30.1698 0.951635 28.4654 1.04932 26.3993C1.167 24.3474 1.47023 21.9586 2.14395 19.4508C2.50055 18.1973 2.93406 16.916 3.46825 15.6689C3.53126 15.536 3.59338 15.4043 3.65494 15.2737C4.20987 14.0971 4.71965 13.0162 5.43343 12.023L5.4594 11.9868L5.48206 11.9485C6.16941 10.7866 7.06724 9.74579 8.03 8.70207L8.05613 8.67374L8.08 8.64349C8.45899 8.16318 8.91835 7.74276 9.43515 7.31588C9.60393 7.17646 9.78968 7.0281 9.98173 6.8747C10.3335 6.59373 10.7064 6.29588 11.0348 6.00527C11.4843 5.63211 11.9752 5.31875 12.5005 5.01038C12.6673 4.91247 12.8454 4.81083 13.028 4.7066C13.3944 4.49743 13.779 4.27788 14.1272 4.0574L14.137 4.0512L14.1466 4.04479C14.567 3.76471 15.0171 3.55643 15.5037 3.36067C15.658 3.29859 15.8303 3.23263 16.0098 3.16395C16.3384 3.0382 16.6908 2.90333 17.0001 2.7664C17.2706 2.66121 17.5168 2.56113 17.7449 2.46846C18.3944 2.20449 18.8962 2.00056 19.3913 1.90927L19.4233 1.90337L19.4549 1.89538C19.9086 1.78075 20.3077 1.68266 20.677 1.59189C20.9566 1.52316 21.2191 1.45863 21.4754 1.39429L22.2631 1.20442L23.2395 5.1032L22.6441 5.35048L22.6412 5.3517L21.0919 5.98936C20.6876 6.125 20.3207 6.32033 19.9975 6.50871C19.8466 6.59669 19.695 6.68937 19.5511 6.77729C19.5352 6.78703 19.5193 6.79671 19.5036 6.80632C19.3422 6.90492 19.1877 6.99869 19.0305 7.08875L19.0012 7.10551L18.9732 7.12422C18.7831 7.25084 18.5962 7.35361 18.3692 7.47841C18.2498 7.54407 18.1193 7.61583 17.9714 7.70036C17.5867 7.92024 17.1409 8.19914 16.7381 8.59284C16.5328 8.7818 16.3157 8.95078 16.0604 9.14949C15.9694 9.22033 15.8736 9.29495 15.7717 9.3756C15.4046 9.6661 14.9878 10.0146 14.6232 10.4534L14.6116 10.4673L14.6005 10.4817C14.425 10.7091 14.2385 10.9061 14.0152 11.1418C13.9251 11.237 13.829 11.3386 13.7252 11.4509C13.4031 11.7997 13.0393 12.2233 12.7607 12.7523C12.7508 12.7673 12.7409 12.7823 12.7309 12.7975C12.2478 13.5306 11.6993 14.3628 11.3316 15.3275C10.9619 16.0337 10.7353 16.7951 10.5433 17.4404L10.5395 17.4529L10.0931 18.953L11.6419 18.7277C11.6843 18.7216 11.7262 18.7154 11.7678 18.7094C12.3637 18.6223 12.8788 18.5471 13.4098 18.5471ZM45.7635 18.5471H45.7636C48.0739 18.5469 50.3371 19.2004 52.2913 20.4319C54.2454 21.6634 55.8106 23.4225 56.806 25.5056C57.8014 27.5887 58.1862 29.9109 57.916 32.2034C57.6459 34.4959 56.7317 36.6652 55.2793 38.4604C53.8269 40.2556 51.8954 41.6032 49.7084 42.3474C47.5214 43.0916 45.1682 43.2018 42.9211 42.6653C40.6739 42.1288 38.6248 40.9676 37.0107 39.316C35.3966 37.6644 34.2834 35.59 33.7998 33.3328L33.5871 32.3397L33.5809 32.3411C33.5436 32.0514 33.5078 31.7315 33.484 31.4085L33.4832 31.3968L33.482 31.3851C33.3638 30.1698 33.3053 28.4654 33.403 26.3995C33.5207 24.3474 33.8239 21.9586 34.4977 19.4506C34.8543 18.1972 35.2878 16.9159 35.8219 15.6689C35.8849 15.536 35.9471 15.4043 36.0086 15.2738C36.5635 14.0971 37.0733 13.0162 37.7871 12.023L37.8131 11.9868L37.8358 11.9485C38.5231 10.7866 39.4209 9.74579 40.3837 8.70207L40.4094 8.67421L40.4329 8.64449C40.812 8.16532 41.2715 7.74544 41.7885 7.31871C41.9566 7.17997 42.1413 7.03251 42.3322 6.88008C42.6849 6.5985 43.0588 6.29998 43.3885 6.00821C43.838 5.63505 44.3289 5.32169 44.8542 5.01332C45.021 4.91541 45.1991 4.81377 45.3817 4.70955C45.7481 4.50037 46.1327 4.28082 46.4809 4.06034L46.4915 4.0536L46.502 4.0466C46.9213 3.76605 47.371 3.55812 47.8582 3.36223C48.0085 3.30182 48.1751 3.23799 48.3486 3.17155C48.6816 3.04403 49.0397 2.90686 49.3555 2.76574C49.6253 2.66078 49.871 2.56094 50.0986 2.46845C50.7481 2.20449 51.2499 2.00056 51.745 1.90927L51.777 1.90337L51.8086 1.89538C52.2623 1.78074 52.6614 1.68265 53.0307 1.59187C53.3103 1.52315 53.5729 1.45862 53.8291 1.39429C53.8306 1.39391 53.8322 1.39352 53.8337 1.39313L54.6168 1.20442L55.5932 5.1032L54.9978 5.35048L54.9949 5.3517L53.4456 5.98936C53.0413 6.125 52.6744 6.32033 52.3512 6.50871C52.2003 6.59672 52.0485 6.68944 51.9046 6.77739L51.8573 6.80632C51.6959 6.90493 51.5414 6.99869 51.3842 7.08875L51.3549 7.10551L51.3269 7.12422C51.1368 7.25084 50.9499 7.35361 50.7229 7.4784C50.6035 7.54406 50.473 7.61582 50.3251 7.70036C49.9404 7.92023 49.4947 8.19912 49.0918 8.59281C48.8865 8.78179 48.6694 8.95078 48.4141 9.14952C48.3231 9.22035 48.2273 9.29496 48.1254 9.3756C47.7583 9.6661 47.3415 10.0146 46.9769 10.4534L46.9653 10.4673L46.9542 10.4817C46.7787 10.7091 46.5922 10.9061 46.3689 11.1418C46.2788 11.237 46.1827 11.3386 46.0789 11.4509C45.7568 11.7997 45.393 12.2233 45.1144 12.7522C45.1045 12.7673 45.0946 12.7824 45.0846 12.7975C44.6014 13.5306 44.053 14.3628 43.6853 15.3275C43.3156 16.0337 43.089 16.7951 42.897 17.4404L42.8932 17.4529L42.4468 18.953L43.9956 18.7277C44.038 18.7216 44.0799 18.7154 44.1215 18.7094C44.7174 18.6223 45.2325 18.5471 45.7635 18.5471Z"
                                                                    stroke="currentcolor" stroke-width="2"></path>
                                                            </svg>
                                                        </div>
                                                        <div class="p-2">
                                                            <ul class="list-inline small mb-2">
                                                                @php
                                                                    $count = (int) $testimonial->star;
                                                                @endphp
                                                                @for ($i = 0; $i < 5; $i++)
                                                                    @if ($i < $count)
                                                                        <li class="list-inline-item me-0 small"><i
                                                                                class="fa-solid fa-star text-warning fs-6"></i>
                                                                        </li>
                                                                    @else
                                                                        <li class="list-inline-item me-0 small"><i
                                                                                class="fa-regular fa-star text-warning fs-6"></i>
                                                                        </li>
                                                                    @endif
                                                                @endfor
                                                            </ul>
                                                            <h5
                                                                class="mb-1 fw-600 text-truncate1 service-cardtitle color-changer">
                                                                {{ $testimonial->name }}</h5>
                                                            <span
                                                                class="text-muted text-truncate fs-7">{{ $testimonial->position }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <!-- Slider END -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial_shape-wrap-three">
                        <img src="storage\app\public\front\images\services_shape03.png" alt="shape"
                            data-aos="fade-down-left" data-aos-delay="400" class="aos-init aos-animate">
                    </div>
                </section>
            @endif
            <!------------------------------------------------- testimonial section end ------------------------------------------------->
        @endif
        <!---------------------------------------------------- app-downlode section end ---------------------------------------------------->
        @if (@helper::checkaddons('user_app'))
            @if (!empty($app_section))
                @if ($app_section->mobile_app_on_off == 1)
                    <section class="app-downlode overflow-hidden bg-primary-rgb py-5">
                        <div class="container">
                            <div class="px-3 border-0 rounded-4 position-relative">
                                <div class="row align-items-center justify-content-center">
                                    <div class="col-lg-6 col-sm-10 text-center text-md-start">
                                        <!-- Title -->
                                        <h3 class="m-0 fw-600 app-title color-changer">{{ @$app_section->title }}</h3>
                                        <p class="mt-3 mb-5 text_truncation2 text-muted">{{ @$app_section->subtitle }}</p>
                                        <!-- Button -->
                                        <div class="gap-3 d-flex justify-content-md-start justify-content-center">
                                            <!-- Google play store button -->
                                            @if (@$app_section->android_link != '' || @$app_section->android_link != null)
                                                <a href="{{ @$app_section->android_link }}"> <img
                                                        src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/other/google-play.svg') }}"
                                                        class="h-50px" alt=""> </a>
                                            @endif
                                            <!-- App store button -->
                                            @if (@$app_section->ios_link != '' || @$app_section->ios_link != null)
                                                <a href="{{ @$app_section->ios_link }}"> <img
                                                        src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/other/app-store.svg') }}"
                                                        class="h-50px" alt=""> </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6 d-none d-lg-block mb-5 mb-lg-0">
                                        <div>
                                            <img src="{{ helper::image_path(@$app_section->image) }}"
                                                class="img-8 {{ session()->get('direction') == 2 ? 'mobile-img-rtl' : 'mobile-img' }} object-fit-cover d-none mx-auto d-md-block"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
            @endif
        @endif
        <!---------------------------------------------------- app-downlode section end ---------------------------------------------------->

        <!----------------------------------------------------- Blog Section start ----------------------------------------------------->
        @if ($getblog->count() > 0)
            @if (@helper::checkaddons('subscription'))
                @if (@helper::checkaddons('blog'))
                    @php
                        $checkplan = App\Models\Transaction::where('vendor_id', $vdata)
                            ->orderByDesc('id')
                            ->first();
                        $user = App\Models\User::where('id', $vdata)->first();
                        if (@$user->allow_without_subscription == 1) {
                            $blogs = 1;
                        } else {
                            $blogs = @$checkplan->blogs;
                        }
                    @endphp
                    @if ($blogs == 1)
                        <section class="blog-secction pb-90 pt-90 extra-margin">
                            <div class="container">
                                <div class="d-flex gap-3 align-items-center justify-content-between pb-5">
                                    <div class="">
                                        <h3 class="fw-600 theme-3-title line-1 fs-3 color-changer">
                                            {{ trans('labels.blog-post') }}
                                        </h3>
                                        <p class="fw-semibold text-primary-color m-0 line-1">
                                            {{ trans('labels.latest-post') }}
                                        </p>
                                    </div>
                                    <a class="fw-semibold btn btn-primary-rgb rounded-5 col-auto"
                                        href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }}
                                        <i
                                            class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                </div>
                                <div class="row g-4">
                                    @foreach ($getblog as $blog)
                                        <div class="col-xl-3 col-lg-4 col-sm-6">
                                            <div class="card border-0 bg-lights p-4 rounded-5 overflow-hidden w-100 h-100">
                                                <div class="blog_post-thumb">
                                                    <div class="img-overlay rounded-4 blog_post-mask">
                                                        <img src="{{ helper::image_path($blog->image) }}"
                                                            class="rounded-4 h-100 w-100 object-fit-cover" alt="...">
                                                    </div>
                                                    <div class="shape">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 336 292"
                                                            fill="none" x="0px" y="0px" preserveAspectRatio="none"
                                                            data-inject-url="/storage/app/public/front/images/blog_img_shape.svg"
                                                            class="injectable">
                                                            <path class="animation-dashed"
                                                                d="M95.9886 2.21488C1.35045 -4.96016 -4.86776 57.0243 3.8529 88.9133C11.5878 125.187 11.6257 152.858 10.6778 162.159C9.76777 167.739 5.74869 197.702 3.8529 211.985C-3.88194 272.973 46.5083 289.217 72.6703 289.715C127.724 280.946 206.703 286.061 239.311 289.715C320.299 300.079 336.755 245.203 334.859 216.47C323.484 179 326.707 136.415 329.74 119.806C335.2 92.3017 332.015 55.1975 329.74 40.0834C319.276 1.01944 260.923 -1.43893 233.055 2.21488C192.105 11.7814 124.615 6.20095 95.9886 2.21488Z"
                                                                stroke="currentcolor" stroke-width="2"
                                                                stroke-dasharray="7 7"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="card-body p-2">
                                                    <h5 class="fw-600 fs-16"><a
                                                            href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                            class="text-dark text_truncation2">{{ $blog->title }}</a>
                                                    </h5>
                                                    <small
                                                        class="card-text text-muted m-0 text_truncation2 blog-description">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                </div>
                                                <div class="card-footer border-top-0 bg-transparent px-2 pb-0">
                                                    <div class="d-flex flex-wrap gap-1 justify-content-between">
                                                        <p class="mb-0 fw-normal text-muted fs-7"><i
                                                                class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>
                                                            {{ helper::date_formate($blog->created_at, $vendordata->id) }}
                                                        </p>
                                                        <a class="fw-semibold text-primary-color fs-7 d-flex align-items-center gap-1"
                                                            href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ trans('labels.readmore') }}<span><i
                                                                    class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endif
                @endif
            @else
                @if (@helper::checkaddons('blog'))
                    <section class="blog-secction pb-90 pt-90 extra-margin">
                        <div class="container">
                            <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between pb-5">
                                <div>
                                    <h3 class="fw-600 fs-3 border-bottom border-primary pb-1 d-inline-block">
                                        {{ trans('labels.blog-post') }}</h3>
                                    <p class="text-font text-muted m-0">{{ trans('labels.latest-post') }}</p>
                                </div>
                                <a class="fw-semibold btn btn-primary-rgb rounded-5"
                                    href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }}
                                    <i
                                        class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                            </div>
                            <div class="row g-4">
                                @foreach ($getblog as $blog)
                                    <div class="col-xl-3 col-lg-4 col-sm-6">
                                        <div class="card border-0 bg-lights p-4 rounded-5 overflow-hidden w-100">
                                            <div class="blog_post-thumb">
                                                <div class="img-overlay rounded-4 blog_post-mask">
                                                    <img src="{{ helper::image_path($blog->image) }}"
                                                        class="rounded-4 h-100 w-100 object-fit-cover" alt="...">
                                                </div>
                                                <div class="shape">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 336 292"
                                                        fill="none" x="0px" y="0px" preserveAspectRatio="none"
                                                        data-inject-url="/storage/app/public/front/images/blog_img_shape.svg"
                                                        class="injectable">
                                                        <path class="animation-dashed"
                                                            d="M95.9886 2.21488C1.35045 -4.96016 -4.86776 57.0243 3.8529 88.9133C11.5878 125.187 11.6257 152.858 10.6778 162.159C9.76777 167.739 5.74869 197.702 3.8529 211.985C-3.88194 272.973 46.5083 289.217 72.6703 289.715C127.724 280.946 206.703 286.061 239.311 289.715C320.299 300.079 336.755 245.203 334.859 216.47C323.484 179 326.707 136.415 329.74 119.806C335.2 92.3017 332.015 55.1975 329.74 40.0834C319.276 1.01944 260.923 -1.43893 233.055 2.21488C192.105 11.7814 124.615 6.20095 95.9886 2.21488Z"
                                                            stroke="currentcolor" stroke-width="2"
                                                            stroke-dasharray="7 7"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <h5 class="fw-600 fs-16">
                                                    <a href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                        class="text-dark text_truncation2">{{ $blog->title }}</a>
                                                </h5>
                                                <small
                                                    class="card-text text-muted m-0 text_truncation2 blog-description">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                            </div>
                                            <div class="card-footer border-top-0 bg-transparent px-2 pb-0">
                                                <div class="d-flex flex-wrap gap-1 justify-content-between">
                                                    <p class="mb-0 fw-normal text-muted fs-7"><i
                                                            class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>
                                                        {{ helper::date_formate($blog->created_at, $vendordata->id) }}
                                                    </p>
                                                    <a class="fw-semibold text-primary-color fs-7 d-flex align-items-center gap-1"
                                                        href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ trans('labels.readmore') }}<span><i
                                                                class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif
            @endif

        @endif
        <!------------------------------------------------------ Blog section end ------------------------------------------------------>

    </main>
@endsection


@section('scripts')
    <script>
        var direction = "{{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}";
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/index.js') }}"></script>
@endsection
