@extends('front.layout.master')

@section('content')
    <!-- top-banner -->
    <section class="theme-1-home theme-14 position-relative py-8 py-lg-9"
        style="background-image:url({{ helper::image_path(helper::appdata($vendordata->id)->home_banner) }}); background-position: center left; background-size: cover; height:70vh;">
        <div class="bg-overlay d-flex flex-column h-100 justify-content-center">
            <div class="container">
                <div class="d-flex flex-column flex-md-row h-100 justify-content-center">
                    <div class="col-md-7 mb-3 mb-md-0">
                        <div class="d-flex gap-md-3 gap-2 flex-column justify-content-center h-100 p-3">
                            <h5 class="fs-5 fw-500 text-primary-color color-changer">
                                {{ helper::appdata($vendordata->id)->homepage_title }}
                            </h5>
                            <h1 class="fw-600 text-white home-subtitle m-0">
                                {{ helper::appdata($vendordata->id)->homepage_subtitle }}</h1>
                            <p class="line-2 fs-7 text-white">
                                {{ trans('labels.top_banner_title') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div
                            class="bg-blur bg-white bg-opacity-10 border shadow-lg border-light border-opacity-25 rounded-3 p-4">
                            <div class="p-xl-5 my-xl-5">
                                <!-- avatar -->
                                <ul class="avatar-group mb-0 mx-auto mx-lg-0 justify-content-center mb-3">
                                    @foreach ($reviewimage as $image)
                                        <li class="avatar-sm">
                                            <img class="avatar-img rounded-circle"
                                                src="{{ helper::image_path($image->image) }}" alt="avatar">
                                        </li>
                                    @endforeach
                                </ul>
                                <p class="text-white m-0 px-md-4 mb-4 text-center text-truncate">
                                    {{ trans('labels.review_section_title') }}
                                </p>
                                <!-- avatar -->
                                <form action="{{ URL::to($vendordata->slug . '/services') }}" method="get"
                                    class="row g-3 align-items-center">
                                    <div class="col-12">
                                        <!-- Input -->
                                        <div class="form-input-dropdown position-relative">
                                            <input class="form-control form-control-lg extra-padding ps-5 rounded-4 fs-7"
                                                type="text" name="search_input" id="search_input"
                                                value="{{ isset($_GET['search_input']) ? $_GET['search_input'] : '' }}"
                                                placeholder="{{ trans('labels.search_by_service_name') }}">
                                            <span
                                                class="position-absolute top-50 translate-middle {{ session()->get('direction') == 2 ? 'ps-5 start-0' : 'end-0 pe-1' }}"><i
                                                    class="fa-light fa-magnifying-glass fs-5 color-changer"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <!-- Search btn -->
                                        <button type="submit"
                                            class="btn btn-lg btn-primary mb-0 rounded-4 btn-submit w-100">{{ trans('labels.search') }}</button>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- top-banner -->
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
        <section class="why-choose pt-90 pb-90 blog-section-14">
            <div class="container">
                <div class="row g-4 justify-content-between align-items-center">

                    <!-- left side START -->
                    <div class="col-lg-6 choose-content">
                        <h2 class="fs-1 fw-600 text_truncation2 pb-1 color-changer">
                            {{ helper::appdata($vendordata->id)->why_choose_title }}
                        </h2>
                        <div class="d-flex align-items-center gap-3 my-1">
                            <div class="heading-line color-changer m-0"></div>
                            <i class="fa-solid fa-feather-pointed fs-3 text-primary"></i>
                            <div class="heading-line color-changer m-0"></div>
                        </div>
                        <p class="mb-3 mb-lg-5 text-muted text_truncation3">
                            {{ helper::appdata($vendordata->id)->why_choose_subtitle }}
                        </p>

                        <!-- Features START -->
                        <div class="row g-3">
                            @foreach ($choose as $key => $choose)
                                @php
                                    if ($key % 2 == 0) {
                                        $class = 'bg-primary-rgb';
                                    } else {
                                        $class = 'bg-secondary-rgb';
                                    }
                                @endphp
                                <!-- Item -->
                                <div class="col-12 theme-14-who">
                                    <div class="card rounded-4 {{ $class }} border">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="icon-img-who">
                                                    <img src="{{ helper::image_path($choose->image) }}" alt=""
                                                        class="rounded-4 shadow">
                                                </div>
                                                <div class="message-text-container">
                                                    <p class="fs-6 mb-1 fw-600 line-1 color-changer">{{ $choose->title }}
                                                    </p>
                                                    <p class="fs-7 text-muted text_truncation2">{{ $choose->description }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Features END -->
                    </div>
                    <!-- left side END -->

                    <!-- right side START -->
                    <div class="col-lg-5 position-relative">
                        <!-- Image -->
                        <img src="{{ helper::image_path(helper::appdata($vendordata->id)->why_choose_image) }}"
                            class="rounded-4 w-100 position-relative" alt="">
                    </div>
                    <!-- right side END -->
                </div>
            </div>
        </section>
    @endif
    <!-------------------------------------------------- Why choose section end -------------------------------------------------->

    <!-- category section -->
    @if ($getcategories->count() > 0)
        <section class="category pb-90 pt-90">
            <div class="container">
                <div class="d-flex align-items-center justify-content-center text-center mb-5">
                    <div>
                        <h3 class="fw-600 text-truncate fs-3 color-changer">
                            {{ trans('labels.see_all_category') }}
                        </h3>
                        <div class="d-flex justify-content-center align-items-center my-1">
                            <div class="heading-line color-changer"></div>
                            <i class="fa-solid fa-feather-pointed fs-3 text-primary"></i>
                            <div class="heading-line color-changer"></div>
                        </div>
                        <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.home_category_subtitle') }}</p>
                    </div>
                </div>
                <div class="row g-3 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-2">
                    @foreach ($getcategories as $category)
                        <div class="col theme-14-cat">
                            <a
                                href="{{ URL::to($vendordata->slug . '/services?category=' . $category->slug . '&search_input=') }}">
                                <div class="card rounded-4 h-100">
                                    <div class="temporary_text">
                                        <img src="{{ helper::image_path($category->image) }}" height="200">
                                    </div>
                                    <div class="card-body">
                                        <div class="card_content shadow-lg p-3 px-2 rounded-top-4">
                                            <span class="card_title text-center text-truncate-2">
                                                {{ $category->name }}</span>
                                            <span class="card_subtitle text-truncate1 fw-600 text-center mt-1">
                                                {{ trans('labels.services') }}
                                                {{ helper::service_count($category->id) . '+' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-5">
                    <div>
                        <a class="fs-6 fw-semibold btn btn-primary-rgb"
                            href="{{ URL::to($vendordata->slug . '/categories') }}">{{ trans('labels.viewall') }} <i
                                class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                    </div>
                </div>
        </section>
    @endif
    <!-- Category Section -->

    <!-- banner section-1  -->
    @if ($getbannersection1->count() > 0)
        <section>
            <div class="container">
                <div class="card-carousel14 owl-carousel owl-loaded">
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
                                            <img src="{{ helper::image_path($banner->image) }}" class="card-imp-top"
                                                alt="">
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

    <!-- service section -->
    @if ($getservices->count() > 0)
        <section class="pb-90 pt-90 w-100">
            <div class="container">
                <div class="d-flex align-items-center justify-content-center text-center mb-5">
                    <div>
                        <h3 class="fw-600 text-truncate fs-3 color-changer">
                            {{ trans('labels.services') }}
                        </h3>
                        <div class="d-flex justify-content-center align-items-center my-1">
                            <div class="heading-line color-changer"></div>
                            <i class="fa-solid fa-feather-pointed fs-3 text-primary"></i>
                            <div class="heading-line color-changer"></div>
                        </div>
                        <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.our_populer') }}
                            {{ trans('labels.services') }}
                        </p>
                    </div>
                </div>
                <div class="row g-3 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1">
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
                        <div class="col theme-14 ">
                            <div class="card h-100 rounded-4 overflow-hidden">
                                @if ($off > 0)
                                    <div class="block-3 shadow-md">
                                        <div class="ribbon">
                                            {{ $off }}% {{ trans('labels.off') }}
                                        </div>
                                    </div>
                                @endif
                                <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}">
                                    <img src="{{ helper::image_path($service['service_image']->image) }}"
                                        class="w-100 object-fit-cover" alt="" height="220px">
                                </a>
                                @php
                                    $category = helper::getcategoryinfo($service->category_id, $service->vendor_id);
                                @endphp
                                <div class="card-body pt-0 p-2">
                                    <div class="box-content">
                                        <div class="buy">
                                            <span>
                                                @if (@helper::checkaddons('customer_login'))
                                                    @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
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
                                                    @endif
                                                @endif
                                            </span>
                                        </div>
                                        <h6 class="text-capitalize mb-1 fs-15 text-dark fw-600 text-truncate-2">
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                class="color-changer">
                                                {{ $service->name }}
                                            </a>
                                        </h6>
                                        <h5 class="fs-7 mb-2 fw-500 text-muted text-truncate">
                                            {{ $category[0]->name }}
                                        </h5>
                                        <div class="d-flex align-items-center gap-1">
                                            <p class="fs-6 fw-600 mb-0 text-truncate1 text-primary">
                                                {{ helper::currency_formate($price, $vendordata->id) }}
                                            </p>
                                            @if ($original_price > $price)
                                                <del class="fs-7 text-muted fw-600 mb-0 text-truncate1">
                                                    {{ helper::currency_formate($original_price, $vendordata->id) }}
                                                </del>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-primary-rgb z-1 p-2">
                                    <div class="d-flex justify-content-between gap-1 align-items-center">
                                        <p class="d-flex gap-1 align-items-center fs-7 fw-600">
                                            @if (@helper::checkaddons('product_reviews'))
                                                @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                    <i class="fas fa-star fa-fw text-warning"></i>
                                                    <span class="color-changer">
                                                        {{ number_format($service->ratings_average, 1) }}
                                                    </span>
                                                @endif
                                            @endif
                                        </p>
                                        @if (helper::appdata($vendordata->id)->online_order == 1)
                                            <a href="{{ URL::to($vendordata->slug . '/booking-' . $service->id) }}"
                                                class="booknow btn btn-secondary fw-semibold rounded-4 fs-7">
                                                {{ trans('labels.book_now') }}
                                            </a>
                                        @else
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                class="booknow btn btn-secondary fw-semibold rounded-4 fs-7">
                                                {{ trans('labels.view') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-5">
                    <div>
                        <a class="fw-semibold btn btn-primary-rgb" href="{{ URL::to($vendordata->slug . '/services') }}">
                            {{ trans('labels.viewall') }}
                            <i
                                class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!----------------------------------------------------- banner-section-2 ----------------------------------------------------->
    @if ($getbannersection2->count() > 0)
        <section class="banner-section-2 p-0 new-banner">
            <div class="container">
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
                            <img src="{{ helper::image_path($banner2->image) }}" class="d-block w-100 rounded-4"></a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!---------------------------------------------------- banner-section-2 ---------------------------------------------------->

    <!------------------------------------------------ top-category section start ------------------------------------------------>
    @if ($gettoprated->count() > 0)
        <section class="top-category-10 pt-90 pb-90">
            <div class="container">
                <!-- Title -->
                <div class="d-flex align-items-center justify-content-center text-center mb-5">
                    <div>
                        <h2 class="fw-600 text-truncate fs-3 color-changer">
                            {{ trans('labels.top_ratted_services') }}
                        </h2>
                        <div class="d-flex justify-content-center align-items-center my-1">
                            <div class="heading-line color-changer"></div>
                            <i class="fa-solid fa-feather-pointed fs-3 text-primary"></i>
                            <div class="heading-line color-changer"></div>
                        </div>
                        <p class="text-font text-muted m-0 text-truncate">
                            {{ trans('labels.top_ratted_services_sub_title') }}
                        </p>
                    </div>
                </div>
                <!-- Listing -->
                <div class="row g-3 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1">
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
                        <div class="col theme-14 ">
                            <div class="card h-100 rounded-4 overflow-hidden">
                                @if ($off > 0)
                                    <div class="block-3 shadow-md">
                                        <div class="ribbon">
                                            {{ $off }}% {{ trans('labels.off') }}
                                        </div>
                                    </div>
                                @endif
                                <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}">
                                    <img src="{{ $toprated['service_image'] == null ? helper::image_path('service.png') : helper::image_path($toprated['service_image']->image) }}"
                                        class="w-100 object-fit-cover" alt="" height="220px">
                                </a>
                                <div class="card-body pt-0 p-2">
                                    <div class="box-content">
                                        <div class="buy">
                                            <span>
                                                @if (@helper::checkaddons('customer_login'))
                                                    @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
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
                                                    @endif
                                                @endif
                                            </span>
                                        </div>
                                        <h6
                                            class="text-capitalize text-center mb-2 fs-15 text-dark fw-600 text-truncate-2">
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                class="color-changer">
                                                {{ $toprated->name }}
                                            </a>
                                        </h6>
                                        <div class="d-flex flex-wrap justify-content-center align-items-center gap-1">
                                            <p class="fs-16 m-0 fw-600 text-primary text-truncate">
                                                {{ helper::currency_formate($tprice, $vendordata->id) }}
                                            </p>
                                            @if ($toriginal_price > $tprice)
                                                <del class="fs-13 m-0 fw-600 text-muted text-truncate">
                                                    {{ helper::currency_formate($toriginal_price, $vendordata->id) }}
                                                </del>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-primary-rgb z-1 p-2">
                                    <div class="d-flex flex-wrap justify-content-between gap-2 align-items-center">
                                        <p class="d-flex gap-1 align-items-center fs-7 fw-600">
                                            @if (@helper::checkaddons('product_reviews'))
                                                @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                    <i class="fas fa-star fa-fw text-warning"></i>
                                                    <span class="color-changer">
                                                        {{ $toprated->ratings_average == null ? number_format(0, 1) : number_format($toprated->ratings_average, 1) }}
                                                    </span>
                                                @endif
                                            @endif
                                        </p>
                                        @if (helper::appdata($vendordata->id)->online_order == 1)
                                            <a href="{{ URL::to($vendordata->slug . '/booking-' . $toprated->id) }}"
                                                class="booknow btn btn-secondary fw-semibold rounded-4 fs-7">
                                                {{ trans('labels.book_now') }}
                                            </a>
                                        @else
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                class="booknow btn btn-secondary fw-semibold rounded-4 fs-7">
                                                {{ trans('labels.book_now') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-5">
                    <div>
                        <a class="fw-semibold btn btn-primary-rgb"
                            href="{{ URL::to($vendordata->slug . '/services') }}">{{ trans('labels.viewall') }} <i
                                class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                    </div>
                </div>
        </section>
    @endif
    <!------------------------------------------------- top-category section end ------------------------------------------------->

    <!------------------------------------------------ testimonial section start ------------------------------------------------>
    @if (@helper::checkaddons('store_reviews'))
        @if ($testimonials->count() > 0)
            <section class="testimonial-10 blog-section-14 bg-secondary-rgb pt-90 pb-90">
                <div class="container">
                    <div class="d-flex flex-column h-100 justify-content-center">
                        <div class="testimonial-content py-4">
                            <!-- Title -->
                            <div class="text-center pb-5 position-relative z-1">
                                <h3 class="fw-600 text-truncate fs-3 color-changer">
                                    {{ trans('labels.testimonial_title') }}
                                </h3>
                                <div class="d-flex justify-content-center align-items-center my-1">
                                    <div class="heading-line color-changer"></div>
                                    <i class="fa-solid fa-feather-pointed fs-3 text-primary"></i>
                                    <div class="heading-line color-changer"></div>
                                </div>
                                <p class="text-font text-muted m-0 text-truncate">
                                    {{ trans('labels.testimonial_subtitle') }}
                                </p>
                            </div>
                            <!-- Slider START -->
                            <div id="testimonial-slider-14" class="owl-carousel owl-theme">
                                @foreach ($testimonials as $testimonial)
                                    <div class="item">
                                        <div class="testimonial rounded-4 bg-white">
                                            <div class="pic">
                                                <img src="{{ helper::image_path($testimonial->image) }}" alt="">
                                            </div>
                                            <div class="overflow-hidden">
                                                <p class="description color-changer">" {{ $testimonial->description }} "
                                                </p>
                                                <div
                                                    class="testimonial-content p-3  d-flex flex-wrap gap-2 align-items-center justify-content-between">
                                                    <div class="testimonial-profile">
                                                        <h3 class="name line-1">{{ $testimonial->name }}</h3>
                                                        <span class="post line-2">{{ $testimonial->position }}</span>
                                                    </div>
                                                    <ul
                                                        class="rating d-flex gap-1 align-items-center justify-content-center">
                                                        @php
                                                            $count = (int) $testimonial->star;
                                                        @endphp
                                                        @for ($i = 0; $i < 5; $i++)
                                                            @if ($i < $count)
                                                                <li class="list-inline-item me-0 small"><i
                                                                        class="fa-solid fa-star"></i>
                                                                </li>
                                                            @else
                                                                <li class="list-inline-item me-0 small"><i
                                                                        class="fa-regular fa-star"></i>
                                                                </li>
                                                            @endif
                                                        @endfor
                                                    </ul>
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
            </section>
        @endif
        <!------------------------------------------------- testimonial section end ------------------------------------------------->
    @endif


    <!---------------------------------------------- app-downlode section end ---------------------------------------------------->
    @if (@helper::checkaddons('user_app'))
        @if (!empty($app_section))
            @if ($app_section->mobile_app_on_off == 1)
                <section class="pt-90 pb-90">
                    <div class="container">
                        <div class="col-12">
                            <div class="row align-items-center justify-content-between">
                                <div class="col-lg-6 col-12 mb-5 mb-lg-0 d-none d-md-block">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="mobile-img5">
                                            <img src="{{ helper::image_path(@$app_section->image) }}"
                                                class="object-fit-cover mobile-img" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12 text-center text-lg-start">
                                    <!-- Title -->
                                    <h3 class="m-0 fs-1 fw-600 text-primary-color color-changer">
                                        {{ @$app_section->title }}
                                    </h3>
                                    <p class="mb-lg-5 mb-4 mt-3 text-muted text_truncation2">{{ @$app_section->subtitle }}
                                    </p>
                                    <!-- Button -->
                                    <div
                                        class="hstack justify-content-center {{ session()->get('direction') == 2 ? 'justify-content-lg-end' : 'justify-content-lg-start' }} gap-3">
                                        <!-- Google play store button -->
                                        @if (@$app_section->android_link != '' || @$app_section->android_link != null)
                                            <a href="{{ @$app_section->android_link }}"><img
                                                    src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/other/google-play.svg') }}"
                                                    class="h-50px" alt=""> </a>
                                        @endif
                                        @if (@$app_section->ios_link != '' || @$app_section->ios_link != null)
                                            <!-- App store button -->
                                            <a href="{{ @$app_section->ios_link }}"><img
                                                    src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/other/app-store.svg') }}"
                                                    class="h-50px" alt=""> </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endif
    @endif
    <!---------------------------------------------- app-downlode section end ---------------------------------------------------->

    <!------------------------------------------------- Blog Section start ------------------------------------------------------->
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
                    <section class="blog-section-14 bg-secondary-rgb pb-90 pt-90">
                        <div class="container">
                            <div class="d-flex align-items-center justify-content-center text-center mb-5">
                                <div>
                                    <h5 class="fw-600 text-truncate fs-3 color-changer">
                                        {{ trans('labels.blog-post') }}
                                    </h5>
                                    <div class="d-flex justify-content-center align-items-center my-1">
                                        <div class="heading-line color-changer"></div>
                                        <i class="fa-solid fa-feather-pointed fs-3 text-primary"></i>
                                        <div class="heading-line color-changer"></div>
                                    </div>
                                    <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.latest-post') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row g-3">
                                    @foreach ($getblog as $blog)
                                        <div class="col-lg-6 col-md-6 d-flex mt-3 justify-content-sm-center">
                                            <div class="card h-100 border rounded-4 overflow-hidden">
                                                <div class="card-body p-0">
                                                    <div class="d-flex flex-column flex-sm-row h-100">
                                                        <div class="position-relative">
                                                            <img src="{{ helper::image_path($blog->image) }}"
                                                                class="card-img-top rounded-0 h-100 object-fit-cover"
                                                                alt="...">
                                                            <div class="bg-overlay"></div>
                                                        </div>
                                                        <div
                                                            class="p-3 d-flex flex-column h-100 align-items-center justify-content-center">
                                                            <div class="text-box">
                                                                <div class="date mb-3">
                                                                    <p class="mb-0 fw-normal text-truncate fs-8"><i
                                                                            class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>
                                                                        {{ helper::date_formate($blog->created_at, $vendordata->id) }}
                                                                    </p>
                                                                </div>
                                                                <div class="card-text">
                                                                    <h5
                                                                        class="m-0 fw-semibold text_truncation2 service-cardtitle">
                                                                        <a href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                                            class="color-changer">{{ $blog->title }}</a>
                                                                    </h5>
                                                                    <small
                                                                        class="card-text text-muted mt-2 mb-2 text_truncation2 fs-7">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                                </div>
                                                                <div
                                                                    class="d-flex mt-3 justify-content-between align-items-center">

                                                                    <a class="fw-semibold text-primary-color fs-7"
                                                                        href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ trans('labels.readmore') }}<span
                                                                            class="mx-1"><i
                                                                                class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></span></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex justify-content-center mt-5">
                                <div class="">
                                    <a class="fw-semibold btn btn-primary-rgb"
                                        href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }}
                                        <i
                                            class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif
            @endif
        @else
            @if (@helper::checkaddons('blog'))
                <section class="blog-section-14 bg-secondary-rgb pb-90 pt-90">
                    <div class="container">
                        <div class="d-flex align-items-center justify-content-center text-center mb-5">
                            <div>
                                <h5 class="fw-600 text-truncate fs-3 color-changer">
                                    {{ trans('labels.blog-post') }}
                                </h5>
                                <div class="d-flex justify-content-center align-items-center my-1">
                                    <div class="heading-line color-changer"></div>
                                    <i class="fa-solid fa-feather-pointed fs-3 text-primary"></i>
                                    <div class="heading-line color-changer"></div>
                                </div>
                                <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.latest-post') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row g-3">
                                @foreach ($getblog as $blog)
                                    <div class="col-lg-6 col-md-6 d-flex mt-3 justify-content-sm-center">
                                        <div class="card h-100 border rounded-4 overflow-hidden">
                                            <div class="card-body p-0">
                                                <div class="d-flex flex-column flex-sm-row h-100">
                                                    <div class="position-relative">
                                                        <img src="{{ helper::image_path($blog->image) }}"
                                                            class="card-img-top rounded-0 h-100 object-fit-cover"
                                                            alt="...">
                                                        <div class="bg-overlay"></div>
                                                    </div>
                                                    <div
                                                        class="p-3 d-flex flex-column h-100 align-items-center justify-content-center">
                                                        <div class="text-box">
                                                            <div class="date mb-3">
                                                                <p class="mb-0 fw-normal text-truncate fs-8"><i
                                                                        class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>
                                                                    {{ helper::date_formate($blog->created_at, $vendordata->id) }}
                                                                </p>
                                                            </div>
                                                            <div class="card-text">
                                                                <h5
                                                                    class="m-0 fw-semibold text_truncation2 service-cardtitle">
                                                                    <a href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                                        class="color-changer">{{ $blog->title }}</a>
                                                                </h5>
                                                                <small
                                                                    class="card-text text-muted mt-2 mb-2 text_truncation2 fs-7">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                            </div>
                                                            <div
                                                                class="d-flex mt-3 justify-content-between align-items-center">

                                                                <a class="fw-semibold text-primary-color fs-7"
                                                                    href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ trans('labels.readmore') }}<span
                                                                        class="mx-1"><i
                                                                            class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></span></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-5">
                            <div class="">
                                <a class="fw-semibold btn btn-primary-rgb"
                                    href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }}
                                    <i
                                        class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endif
    @endif
    <!-------------------------------------------------------- Blog section end -------------------------------------------------->
    @if (helper::footer_features(@$vendordata->id)->count() > 0)
        <section class="theme-10-new-product-service pb-90 pt-90 extra-margin footer-fiechar-section">
            <div class="container">
                <div class="d-none d-lg-block">
                    <div class="row g-3 justify-content-center">
                        @foreach (helper::footer_features(@$vendordata->id) as $feature)
                            <div class="col-lg-3 col-md-6 col-12 text-center">
                                <div class="card bg-transparent border h-100 rounded-4">
                                    <div class="card-body text-center">
                                        <div class="free-icon fs-2 text-primary-color">
                                            {!! $feature->icon !!}
                                        </div>
                                        <div class="free-content">
                                            <h3 class="fs-6 fw-600 color-changer">{{ $feature->title }}</h3>
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
                            <div class="card bg-transparent border h-100 rounded-4">
                                <div class="card-body text-center">
                                    <div class="free-icon fs-2 text-primary-color">
                                        {!! $feature->icon !!}
                                    </div>
                                    <div class="free-content">
                                        <h3 class="fs-6 fw-600 color-changer">{{ $feature->title }}</h3>
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
@endsection

@section('scripts')
    <script>
        var direction = "{{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}";
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/index.js') }}"></script>
@endsection
