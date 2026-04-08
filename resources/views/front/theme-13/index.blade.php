@extends('front.layout.master')
@section('content')
    <!-- top-banner -->
    <section class="theme-13 shadow-lg">
        <div class="container-fluid p-0">
            <div class="col-12">
                <div class="row g-0">
                    <div class="col-lg-5 bg-primary py-4 order-lg-1 order-2">
                        <div class="section-search m-0 px-lg-5 px-3 h-100 d-flex justify-content-center align-items-center">
                            <div>
                                <p class="fs-6 fw-500 text-center text-white mb-4">
                                    {{ helper::appdata($vendordata->id)->homepage_title }}
                                </p>
                                <h1 class="fw-600er text-center text-secondary m-0 color-changer">
                                    {{ helper::appdata($vendordata->id)->homepage_subtitle }}
                                </h1>
                                <!-- avatar -->
                                <div class="mt-4 d-flex gap-3 align-items-center flex-column">
                                    <ul class="avatar-group justify-content-center gap-1">
                                        @foreach ($reviewimage as $image)
                                            <li class="avatar-sm">
                                                <img class="avatar-img rounded-circle"
                                                    src="{{ helper::image_path($image->image) }}" alt="avatar">
                                            </li>
                                        @endforeach
                                    </ul>
                                    <p class="text-white m-0 text-truncate">
                                        {{ trans('labels.review_section_title') }}
                                    </p>
                                </div>
                                <!-- avatar -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 order-lg-2 order-1 po">
                        <div class="theme-13-top-img ">
                            <img src="{{ helper::image_path(helper::appdata($vendordata->id)->home_banner) }}"
                                alt="" class="w-100 object-fit-cover" style="height: 80vh;">

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="bg-secondary-rgb h-100 theme-13 rounded-0 p-4 py-5">
            <div class="container">
                <div class="d-flex h-100 justify-content-center align-items-center">
                    <div class="col">
                        <div class="shadow bg-white p-sm-5 p-3">
                            <form action="{{ URL::to($vendordata->slug . '/services') }}" method="get"
                                class="row g-3 align-items-center">
                                <div class="col-xl-9 col-lg-8 col-md-8">
                                    <!-- Input -->
                                    <div class="form-input-dropdown position-relative">
                                        <input class="form-control form-control-lg ps-5 extra-padding rounded-0 fs-7"
                                            type="text" name="search_input" id="search_input"
                                            value="{{ isset($_GET['search_input']) ? $_GET['search_input'] : '' }}"
                                            placeholder="{{ trans('labels.search_by_service_name') }}">
                                        <span
                                            class="position-absolute top-50 translate-middle {{ session()->get('direction') == 2 ? 'ps-5 start-0' : 'end-0 pe-1' }}"><i
                                                class="fa-light fa-magnifying-glass fs-5 color-changer"></i></span>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-4 col-md-4">
                                    <!-- Search btn -->
                                    <button type="submit"
                                        class="btn btn-lg btn-primary mb-0 rounded-0 btn-submit w-100">{{ trans('labels.search') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
    <!-- top-banner -->
    @if (helper::footer_features(@$vendordata->id)->count() > 0)
        <section class="theme-9-new-product-service footer-fiechar my-5 pt-5">
            <div class="container">
                <div class="d-lg-block d-none">
                    <div class="row justify-content-center g-3">
                        @foreach (helper::footer_features(@$vendordata->id) as $feature)
                            <div class="col-lg-3 col-md-6">
                                <div class="card bg-white border-1 border-dark bg-transparent h-100 rounded-0">
                                    <div class="card-body text-center">
                                        <div class="free-icon fs-2 text-primary-color">
                                            {!! $feature->icon !!}
                                        </div>
                                        <div class="free-content">
                                            <h3 class="pst mb-1 fw-600 color-changer">{{ $feature->title }}</h3>
                                            <p class="fs-7 m-0 text-muted">{{ $feature->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="footer-fiechar-slider owl-carousel owl-theme d-lg-none">
                    @foreach (helper::footer_features(@$vendordata->id) as $feature)
                        <div class="item h-100">
                            <div class="card h-100 bg-white border-1 border-dark bg-transparent h-100 rounded-0">
                                <div class="card-body text-center">
                                    <div class="free-icon fs-2 text-primary-color">
                                        {!! $feature->icon !!}
                                    </div>
                                    <div class="free-content">
                                        <h3 class="pst mb-1 fw-600 color-changer">{{ $feature->title }}</h3>
                                        <p class="fs-7 m-0 text-muted">{{ $feature->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!------------------------------------------------- Why choose section start ------------------------------------------------->
    @if ($choose->count() > 0)
        <section class="my-5 py-5 position-relative">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="text-center col-md-7 mb-3">
                        <h2 class="pb-1 fw-600 text_truncation2 fs-1 color-changer">
                            {{ helper::appdata($vendordata->id)->why_choose_title }}
                        </h2>
                        <p class="mb-3 mb-lg-5 text-muted text_truncation3">
                            {{ helper::appdata($vendordata->id)->why_choose_subtitle }}
                        </p>
                    </div>
                </div>
                <div class="row g-4 justify-content-between align-items-center">
                    <!-- Left side START -->
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <!-- Image -->
                        <img src="{{ helper::image_path(helper::appdata($vendordata->id)->why_choose_image) }}"
                            class="rounded-0 w-100 h-100 object-fit-cover" alt="">
                    </div>
                    <!-- Left side END -->

                    <!-- Right side START -->
                    <div class="col-lg-6">

                        <!-- Features START -->
                        <div class="row justify-content-center g-4">
                            <!-- Item -->
                            @foreach ($choose as $choose)
                                <div class="col-md-12">
                                    <div class="card border rounded-0 shadow h-100">
                                        <div class="card-body p-3">
                                            <div class="d-flex gap-3 align-items-center">
                                                <div
                                                    class="col-4 col-sm-2 col-lg-3 col-xl-2 icon-img-12 rounded-0 p-1 bg-primary-rgb">
                                                    <img src="{{ helper::image_path($choose->image) }}" alt=""
                                                        class="rounded-0 shadow">
                                                </div>
                                                <div class="col-8 col-sm-10 col-lg-9 col-xl-10">
                                                    <h6 class="fw-600 mb-2 text-truncate1 color-changer">
                                                        {{ $choose->title }}</h6>
                                                    <p class="mb-0 fs-7 text-muted text_truncation2">
                                                        {{ $choose->description }}</p>
                                                </div>
                                            </div>
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
            <div class="shape">
                <img src="storage/app/public/front/images/dots.svg" class="home-course-steps-1">
                <img src="storage/app/public/front/images/dots.svg" class="home-course-steps-2">
            </div>
        </section>
    @endif
    <!-------------------------------------------------- Why choose section end -------------------------------------------------->
    @if ($getcategories->count() > 0)
        <section class="my-5 py-5">
            <div class="container">
                <div class="text-center pb-5">
                    <h3 class="fs-1 fw-600 text-truncate1 fs-3 color-changer">{{ trans('labels.see_all_category') }}</h3>
                    <p class="text-font text-muted m-0 text-truncate1">{{ trans('labels.home_category_subtitle') }}</p>
                </div>
                {{-- new design --}}

                <div class="row g-3 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-1">
                    @foreach ($getcategories as $category)
                        <div class="col">
                            <a
                                href="{{ URL::to($vendordata->slug . '/services?category=' . $category->slug . '&search_input=') }}">
                                <div class="card rounded-0 border bg-primary-rgb p-3 h-100">
                                    <div class="d-flex align-items-center gap-3">
                                        <div>
                                            <img src="{{ helper::image_path($category->image) }}"
                                                class="card-img-top object-fit-cover category-13-img rounded-0"
                                                alt="">
                                        </div>
                                        <div
                                            class="cat-text-13 bg-white p-2 w-100 h-100 d-flex flex-column justify-content-center">

                                            <P class="fs-7 text-primary-color m-0 text-truncate1">
                                                {{ trans('labels.services') }}
                                                {{ helper::service_count($category->id) . '+' }}
                                            </P>
                                            <p class="m-0 text-dark fs-7 fw-600 text-truncate-2">
                                                {{ $category->name }}
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                {{-- new design --}}
                <div class="d-flex justify-content-center pt-5">
                    <a class="fs-6 fw-semibold btn-border rounded-0"
                        href="{{ URL::to($vendordata->slug . '/categories') }}">{{ trans('labels.viewall') }} <i
                            class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                </div>
            </div>
        </section>
    @endif
    <!----------------------------- Category Section ----------------------------->

    <!-- banner section-1  -->
    @if ($getbannersection1->count() > 0)
        <section class="my-5">
            <div class="container">
                <div class="card-carousel owl-carousel owl-loaded">
                    <div class="owl-stage-outer">
                        <div class="owl-stage carousel">
                            @foreach ($getbannersection1 as $banner)
                                <div class="owl-item">
                                    <div class="card-top rounded-0">
                                        <div class="card-overlay rounded-0">
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
                                            <img src="{{ helper::image_path($banner->image) }}"
                                                class="card-imp-top rounded-0" alt="">
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
    <!-- banner section-1 -->

    <!--------------------------- service section --------------------------->
    @if ($getservices->count() > 0)
        <section class="my-5 py-5 w-100">
            <div class="container">
                <div class="text-center pb-5">
                    <h3 class="fs-1 fw-600 text-truncate1 fs-3 color-changer">{{ trans('labels.services') }}</h3>
                    <p class="text-font text-muted m-0 text-truncate1">{{ trans('labels.our_populer') }}
                        {{ trans('labels.services') }}
                    </p>
                </div>
                <div class="row g-3 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1">
                    @foreach ($getservices as $service)
                        @php
                            if ($service->top_deals == 1 && @helper::top_deals($vendordata->id) != null) {
                                if (@helper::top_deals($vendordata->id)->offer_type == 1) {
                                    if ($service->price > @helper::top_deals($vendordata->id)->offer_amount) {
                                        $price = $service->price - @helper::top_deals($vendordata->id)->offer_amount;
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
                                    $original_price > 0 ? number_format(100 - ($price * 100) / $original_price, 1) : 0;
                            } else {
                                $price = $service->price;
                                $original_price = $service->original_price;
                                $off = $service->discount_percentage;
                            }
                        @endphp
                        <div class="col">
                            <div class="card h-100 p-3 w-100 border rounded-0">
                                <div class="position-relative overflow-hidden rounded-0img-over">
                                    <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}">
                                        <img src="{{ helper::image_path($service['service_image']->image) }}"
                                            class="card-img-top w-100 object-fit-cover rounded-0" alt="..."
                                            height="220px">

                                    </a>
                                    <div class="card-img-overlay d-flex flex-column z-index-1 p-2">
                                        <div
                                            class="d-flex justify-content-{{ session()->get('direction') == '2' ? 'start' : 'end' }} align-items-center">
                                            @if (@helper::checkaddons('customer_login'))
                                                @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                    <div
                                                        class="badges-2 bg-danger rounded-0 {{ session()->get('direction') == '2' ? 'float-start' : 'float-end' }}">
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
                                                                    <i class="fa-solid fa-fw fa-heart fs-7"></i>
                                                                @else
                                                                    <i class="fa-regular fa-heart fs-7"></i>
                                                                @endif
                                                            @else
                                                                <i class="fa-regular fa-heart fs-7"></i>
                                                            @endif
                                                        </button>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        @php
                                            $category = helper::getcategoryinfo(
                                                $service->category_id,
                                                $service->vendor_id,
                                            );
                                        @endphp
                                    </div>
                                    <div class="card-13-service d-flex">
                                        <p
                                            class="text-primary shadow {{ session()->get('direction') == '2' ? 'rtl' : '' }} mb-0 px-4 py-1 bg-white fs-7 fw-500">
                                            {{ $category[0]->name }}</p>
                                    </div>
                                </div>
                                @if ($off > 0)
                                    <div class="offer-12">
                                        <span>{{ $off }}% {{ trans('labels.off') }}</span>
                                    </div>
                                @endif
                                <div class="card-body px-0 pt-4 pb-0">
                                    <div class="card-text">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center gap-1">
                                                <p class="fs-6 fw-600 text-truncate1 color-changer">
                                                    {{ helper::currency_formate($price, $vendordata->id) }}
                                                </p>
                                                @if ($original_price > $price)
                                                    <del class="fs-7 text-muted fw-600 text-truncate1">
                                                        {{ helper::currency_formate($original_price, $vendordata->id) }}
                                                    </del>
                                                @endif
                                            </div>
                                        </div>
                                        <h5 class="fw-semibold text_truncation2 service-cardtitle">
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                class="color-changer">{{ $service->name }}</a>
                                        </h5>
                                    </div>
                                </div>
                                <div class="card-footer border-0 bg-transparent pt-3 px-0 pb-0">
                                    <div class="d-flex justify-content-between align-items-center">

                                        @if (helper::appdata($vendordata->id)->online_order == 1)
                                            <a href="{{ URL::to($vendordata->slug . '/booking-' . $service->id) }}"
                                                class="booknow btn btn-outline-primary rounded-0 btn-md fs-7 fw-600">
                                                {{ trans('labels.book_now') }}
                                                <i
                                                    class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                        @else
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                class="booknow btn btn-outline-primary rounded-0 btn-md fs-7 fw-600">
                                                {{ trans('labels.view') }}
                                                <i
                                                    class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                        @endif
                                        @if (@helper::checkaddons('product_reviews'))
                                            @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                <p class="fw-600 fs-7 h-100 d-flex align-items-center rounded-0"><i
                                                        class="fas fa-star fa-fw text-warning {{ session()->get('direction') == '2' ? 'ms-1' : 'me-1' }}"></i>
                                                    <span class="color-changer">
                                                        {{ number_format($service->ratings_average, 1) }}
                                                    </span>
                                                </p>
                                            @endif
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center pt-5">
                    <a class="fw-semibold btn btn-border rounded-0"
                        href="{{ URL::to($vendordata->slug . '/services') }}">{{ trans('labels.viewall') }} <i
                            class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                </div>
            </div>
        </section>
    @endif

    <!----------------------------------------------------- banner-section-2 ----------------------------------------------------->
    @if ($getbannersection2->count() > 0)
        <section class="banner-section-2">
            <div id="carouselExampleSlides1" class="owl-carousel owl-theme">
                @foreach ($getbannersection2 as $key => $banner2)
                    <div class="item {{ $key == 0 ? 'active' : '' }}">
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
                        <img src="{{ helper::image_path($banner2->image) }}" class="d-block w-100"></a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
    <!---------------------------------------------------- banner-section-2 ---------------------------------------------------->

    <!------------------------------------------------ top-category section start ------------------------------------------------>
    @if ($gettoprated->count() > 0)
        <section class="my-5 py-5">
            <div class="container">
                <div class="text-center pb-4">
                    <h2 class="fs-1 fw-600 text-truncate1 fs-3 color-changer">{{ trans('labels.top_ratted_services') }}
                    </h2>
                    <p class="text-font text-muted m-0 text-truncate1">
                        {{ trans('labels.top_ratted_services_sub_title') }}
                    </p>
                </div>
                <!-- Listing -->
                <div
                    class="row g-sm-5 gy-5 gx-3 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1 top-cate mt-1">
                    @foreach ($gettoprated as $toprated)
                        @php
                            if ($toprated->top_deals == 1 && @helper::top_deals($vendordata->id) != null) {
                                if (@helper::top_deals($vendordata->id)->offer_type == 1) {
                                    if ($toprated->price > @helper::top_deals($vendordata->id)->offer_amount) {
                                        $tprice = $toprated->price - @helper::top_deals($vendordata->id)->offer_amount;
                                    } else {
                                        $tprice = $toprated->price;
                                    }
                                } else {
                                    $tprice =
                                        $toprated->price -
                                        $toprated->price * (@helper::top_deals($vendordata->id)->offer_amount / 100);
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
                        <div class="col theme-13-card">
                            <div class="card h-100 rounded-0">
                                <div class="card-img {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                                    <div class="card-imgs position-relative shadow">
                                        <img src="{{ $toprated['service_image'] == null ? helper::image_path('service.png') : helper::image_path($toprated['service_image']->image) }}"
                                            class="w-100 object-fit-cover rounded-0" alt="">
                                        <div class="card-img-overlay d-flex flex-column z-index-1 p-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                @if (@helper::checkaddons('customer_login'))
                                                    @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                        <div
                                                            class="badges-2 bg-danger rounded-0 {{ session()->get('direction') == '2' ? 'float-start' : 'float-end' }}">
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
                                                                        <i class="fa-solid fa-fw fa-heart fs-7"></i>
                                                                    @else
                                                                        <i class="fa-regular fa-heart fs-7"></i>
                                                                    @endif
                                                                @else
                                                                    <i class="fa-regular fa-heart fs-7"></i>
                                                                @endif
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3 pt-0">
                                    <div class="project-info">
                                        <div class="d-flex justify-content-between mb-2 align-items-center">
                                            @if ($off > 0)
                                                <div
                                                    class="{{ session()->get('direction') == '2' ? 'service-right-label' : 'service-left-label' }} text-bg-primary rounded-0">
                                                    <p>{{ $off }}% {{ trans('labels.off') }}</p>
                                                </div>
                                            @endif
                                            @if (@helper::checkaddons('product_reviews'))
                                                @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                    <p class="fw-500 fs-7 m-0 rounded-0">
                                                        <i class="fas fa-star fa-fw text-warning fs-8"></i>
                                                        <span
                                                            class="fs-8 color-changer">{{ $toprated->ratings_average == null ? number_format(0, 1) : number_format($toprated->ratings_average, 1) }}</span>
                                                    </p>
                                                @endif
                                            @endif
                                        </div>
                                        <a class="fs-6 mb-0 text_truncation2 fw-600 color-changer"
                                            href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}">{{ $toprated->name }}</a>
                                        <span class="fs-8 mt-2 line-2 text-muted">Lorem ipsum, dolor sit amet consectetur
                                            adipisicing
                                            elit.
                                            Repudiandae
                                            voluptas ullam aut incidunt minima.</span>
                                    </div>
                                </div>
                                <div class="card-footer border-top rounded-0 bg-transparent px-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex flex-wrap align-items-center gap-1">
                                            <p class="fs-7 m-0 fw-600 text-truncate1 color-changer">
                                                {{ helper::currency_formate($tprice, $vendordata->id) }}
                                            </p>
                                            @if ($toriginal_price > $tprice)
                                                <del class="fs-8 m-0 fw-600 text-muted text-truncate1">
                                                    {{ helper::currency_formate($toriginal_price, $vendordata->id) }}
                                                </del>
                                            @endif
                                        </div>
                                        @if (helper::appdata($vendordata->id)->online_order == 1)
                                            <a href="{{ URL::to($vendordata->slug . '/booking-' . $toprated->id) }}"
                                                class="btn btn-primary btn-round flex-shrink-0 rounded-0"><i
                                                    class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left' : 'fa-solid fa-arrow-right' }}"></i></a>
                                        @else
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                class="btn btn-primary btn-round flex-shrink-0 rounded-0"><i
                                                    class="fa-regular fa-eye"></i></a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center pt-5">
                    <a href="{{ URL::to($vendordata->slug . '/services') }}"
                        class="fw-semibold btn btn-border rounded-0 m-0">{{ trans('labels.view_all') }}<i
                            class="mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                </div>
            </div>
        </section>
    @endif
    <!------------------------------------------------- top-category section end ------------------------------------------------->

    <!------------------------------------------------ testimonial section start ------------------------------------------------>
    @if (@helper::checkaddons('store_reviews'))
        @if ($testimonials->count() > 0)
            <section class="testimonial my-5 py-5"
                style="background-image:url({{ url(env('ASSETPATHURL') . 'admin-assets/images/other/construction_shape.png') }}); background-position: center left; background-size: cover;">
                <div class="container">
                    <!-- Title -->
                    <div class="mb-5 text-center">
                        <div class="mb-3 mb-sm-4">
                            <h5 class="fw-600 fs-3 text-truncate fs-3 color-changer">
                                {{ trans('labels.testimonial_title') }}</h5>
                            <p class="text-font text-muted m-0 text-truncate">
                                {{ trans('labels.testimonial_subtitle') }}
                            </p>
                        </div>
                    </div>
                    <!-- Testimonials -->
                    <div id="testimonial-12" class="owl-carousel owl-theme">
                        @foreach ($testimonials as $testimonial)
                            <div class="item">
                                <div class="testimonial-12 align-items-center d-flex flex-column">
                                    <p class="description">
                                        "{{ $testimonial->description }}"
                                    </p>
                                    <div class="pic p-1">
                                        <img src="{{ helper::image_path($testimonial->image) }}" alt="avatar"
                                            class="rounded-circle">
                                    </div>
                                    <div class="testimonial-prof align-items-center d-flex flex-column">
                                        <h4>{{ $testimonial->name }}</h4>
                                        <small class="text-muted">{{ $testimonial->position }}</small>
                                        <ul class="list-inline small mb-3">
                                            @php
                                                $count = (int) $testimonial->star;
                                            @endphp
                                            @for ($i = 0; $i < 5; $i++)
                                                @if ($i < $count)
                                                    <li class="list-inline-item me-0 small"><i
                                                            class="fa-solid fa-star text-warning"></i>
                                                    </li>
                                                @else
                                                    <li class="list-inline-item me-0 small"><i
                                                            class="fa-regular fa-star text-warning"></i>
                                                    </li>
                                                @endif
                                            @endfor
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </section>
        @endif
    @endif
    <!------------------------------------------------- testimonial section end ------------------------------------------------->

    <!------------------------------------------------- app-downlode section end ------------------------------------------------->
    @if (@helper::checkaddons('user_app'))
        @if (!empty($app_section))
            @if ($app_section->mobile_app_on_off == 1)
                <section class="my-5">
                    <div class="container">
                        <div class="border-0 bg-primary-rgb overflow-hidden">
                            <div class="p-sm-5 p-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-xl-6 col-lg-6 col-md-9 z-1">
                                        <!-- Title -->
                                        <h3 class="mb-4 fs-1 fw-600 app-title color-changer">{{ @$app_section->title }}
                                        </h3>
                                        <p class="mb-lg-5 mb-4 mt-3 text_truncation2 text-muted">
                                            {{ @$app_section->subtitle }}
                                        </p>
                                        <div class="hstack gap-3">
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
                                    <div class="col-xl-4 col-lg-6 d-none d-lg-block">
                                        <img src="{{ helper::image_path(@$app_section->image) }}"
                                            class="h-400px object-fit-cover" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endif
    @endif
    <!------------------------------------------------- app-downlode section end ------------------------------------------------->

    <!---------------------------------------------------- Blog Section start ---------------------------------------------------->
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
                    <section class="blog-secction extra-margin pb-5">
                        <div class="container">
                            <div class="text-center pb-5">
                                <h3 class="fs-1 fw-600 text-truncate1 pb-1 fs-3 color-changer">
                                    {{ trans('labels.blog-post') }}
                                </h3>
                                <p class="text-font text-muted m-0 text-truncate1">{{ trans('labels.latest-post') }}
                                </p>
                            </div>
                            <div class="row g-3 g-3 justify-content-between">
                                <div class="{{ $getblog->count() > 1 ? 'col-lg-6' : 'col-lg-12' }}">
                                    @foreach ($getblog as $key => $blog)
                                        @if ($key == 0)
                                            <div class="card border bg-transparent rounded-0 overflow-hidden w-100">
                                                <div class="img-overlay rounded-0 mb-4">
                                                    <img src="{{ helper::image_path($blog->image) }}"
                                                        class="rounded-0 w-100 object-fit-cover" alt="...">
                                                </div>
                                                <div class="card-body p-2 service-cardtitle">
                                                    <p class="fw-normal text-muted fs-7 mb-2"><i
                                                            class="fa-solid fa-calendar-days"></i> <span
                                                            class="px-1">{{ helper::date_formate($blog->created_at, $vendordata->id) }}</span>
                                                    </p>
                                                    <h5 class="fw-600 text_truncation2 service-cardtitle"><a
                                                            href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                            class="color-changer">{{ $blog->title }}</a>
                                                    </h5>
                                                    <small
                                                        class="card-text text-muted fs-7 m-0 text_truncation3">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                </div>
                                                <div class="card-footer border-top-0 bg-transparent p-2">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <a class="fw-semibold text-primary-color fs-7"
                                                            href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ trans('labels.readmore') }}
                                                            <span class="mx-1">
                                                                <i
                                                                    class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                @if ($getblog->count() > 1)
                                    <div class="col-lg-6">
                                        <div
                                            class="row g-3 row-cols-sm-2 row-cols-1 align-items-center border-0 bg-transparent mb-4">
                                            @foreach ($getblog as $key => $blog)
                                                @if ($key != 0)
                                                    <div class="col">
                                                        <div class="card rounded-0 h-100">
                                                            <div class="img-overlay rounded-4">
                                                                <img src="{{ helper::image_path($blog->image) }}"
                                                                    class="rounded-0 w-100 object-fit-cover"
                                                                    alt="..." height="180px">
                                                            </div>
                                                            <div class="card-body p-2">
                                                                <p class="mb-2 fw-normal text-muted fs-7"><i
                                                                        class="fa-solid fa-calendar-days"></i> <span
                                                                        class="px-1">{{ helper::date_formate($blog->created_at, $vendordata->id) }}</span>
                                                                </p>
                                                                <h5 class="fw-600 text_truncation2 service-cardtitle"><a
                                                                        href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                                        class="text-dark color-changer">{{ $blog->title }}</a>
                                                                </h5>
                                                                <small
                                                                    class="card-text text-muted m-0 fs-7 text_truncation2">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            {{-- <div class="col-sm-4">
                                                <div class="img-overlay rounded-4">
                                                    <img src="{{ helper::image_path($blog->image) }}"
                                                        class="rounded-0 w-100 object-fit-cover blog-img-9"
                                                        alt="...">
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <p class="mb-2 fw-normal text-muted fs-7"><i
                                                        class="fa-solid fa-calendar-days"></i> <span
                                                        class="px-1">{{ helper::date_formate($blog->created_at, $vendordata->id) }}</span>
                                                </p>
                                                <h5 class="fw-600 text_truncation2 service-cardtitle"><a
                                                        href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                        class="text-dark">{{ $blog->title }}</a></h5>
                                                <small
                                                    class="card-text text-muted m-0 fs-7 text_truncation2">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                            </div> --}}

                                            {{-- <div class="order-bottomb mb-4">
                                            </div> --}}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-center pt-sm-5 pt-3">
                                <a class="fw-semibold btn btn-border rounded-0"
                                    href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }}
                                    <i
                                        class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                            </div>
                        </div>
                    </section>
                @endif
            @endif
        @else
            @if (@helper::checkaddons('blog'))
                <section class="blog-secction extra-margin pb-5">
                    <div class="container">
                        <div class="text-center pb-5">
                            <h3 class="fs-1 fw-600 text-truncate1 pb-1 fs-3 color-changer">
                                {{ trans('labels.blog-post') }}
                            </h3>
                            <p class="text-font text-muted m-0 text-truncate1">{{ trans('labels.latest-post') }}
                            </p>
                        </div>
                        <div class="row g-3 g-3 justify-content-between">
                            <div class="{{ $getblog->count() > 1 ? 'col-lg-6' : 'col-lg-12' }}">
                                @foreach ($getblog as $key => $blog)
                                    @if ($key == 0)
                                        <div class="card border bg-transparent rounded-0 overflow-hidden w-100">
                                            <div class="img-overlay rounded-0 mb-4">
                                                <img src="{{ helper::image_path($blog->image) }}"
                                                    class="rounded-0 w-100 object-fit-cover" alt="...">
                                            </div>
                                            <div class="card-body p-2 service-cardtitle">
                                                <p class="fw-normal text-muted fs-7 mb-2"><i
                                                        class="fa-solid fa-calendar-days"></i> <span
                                                        class="px-1">{{ helper::date_formate($blog->created_at, $vendordata->id) }}</span>
                                                </p>
                                                <h5 class="fw-600 text_truncation2 service-cardtitle"><a
                                                        href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                        class="color-changer">{{ $blog->title }}</a>
                                                </h5>
                                                <small
                                                    class="card-text text-muted fs-7 m-0 text_truncation3">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                            </div>
                                            <div class="card-footer border-top-0 bg-transparent p-2">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <a class="fw-semibold text-primary-color fs-7"
                                                        href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ trans('labels.readmore') }}
                                                        <span class="mx-1">
                                                            <i
                                                                class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @if ($getblog->count() > 1)
                                <div class="col-lg-6">
                                    <div
                                        class="row g-3 row-cols-sm-2 row-cols-1 align-items-center border-0 bg-transparent mb-4">
                                        @foreach ($getblog as $key => $blog)
                                            @if ($key != 0)
                                                <div class="col">
                                                    <div class="card rounded-0 h-100">
                                                        <div class="img-overlay rounded-4">
                                                            <img src="{{ helper::image_path($blog->image) }}"
                                                                class="rounded-0 w-100 object-fit-cover" alt="..."
                                                                height="180px">
                                                        </div>
                                                        <div class="card-body p-2">
                                                            <p class="mb-2 fw-normal text-muted fs-7"><i
                                                                    class="fa-solid fa-calendar-days"></i> <span
                                                                    class="px-1">{{ helper::date_formate($blog->created_at, $vendordata->id) }}</span>
                                                            </p>
                                                            <h5 class="fw-600 text_truncation2 service-cardtitle"><a
                                                                    href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                                    class="text-dark color-changer">{{ $blog->title }}</a>
                                                            </h5>
                                                            <small
                                                                class="card-text text-muted m-0 fs-7 text_truncation2">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                        {{-- <div class="col-sm-4">
                                                <div class="img-overlay rounded-4">
                                                    <img src="{{ helper::image_path($blog->image) }}"
                                                        class="rounded-0 w-100 object-fit-cover blog-img-9"
                                                        alt="...">
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <p class="mb-2 fw-normal text-muted fs-7"><i
                                                        class="fa-solid fa-calendar-days"></i> <span
                                                        class="px-1">{{ helper::date_formate($blog->created_at, $vendordata->id) }}</span>
                                                </p>
                                                <h5 class="fw-600 text_truncation2 service-cardtitle"><a
                                                        href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                        class="text-dark">{{ $blog->title }}</a></h5>
                                                <small
                                                    class="card-text text-muted m-0 fs-7 text_truncation2">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                            </div> --}}

                                        {{-- <div class="order-bottomb mb-4">
                                            </div> --}}
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-center pt-sm-5 pt-3">
                            <a class="fw-semibold btn btn-border rounded-0"
                                href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }}
                                <i
                                    class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                        </div>
                    </div>
                </section>
            @endif
        @endif
    @endif
    <!----------------------------------------------------- Blog section end ----------------------------------------------------->


@endsection
@section('scripts')
    <script>
        var direction = "{{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}";
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/index.js') }}"></script>
@endsection
