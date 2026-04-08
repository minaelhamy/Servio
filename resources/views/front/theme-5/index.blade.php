@extends('front.layout.master')

@section('content')
    <!-- top-banner -->
    <section class="position-relative mb-5 home-banner py-8 py-lg-9 theme-5"
        style="background-image:url({{ helper::image_path(helper::appdata($vendordata->id)->home_banner) }}); background-position: center left; background-size: cover; height:100%;">
        <div class="bg-overlay"></div>
        <div class="container">
            <div class="row py-sm-5">
                <div class="col-xl-8 z-index-9 mb-4">
                    <p class="fs-6 fw-medium text-primary-color">{{ helper::appdata($vendordata->id)->homepage_title }}</p>
                    <h1 class="text-white home-subtitle m-0">
                        {{ helper::appdata($vendordata->id)->homepage_subtitle }}
                    </h1>
                </div>
                <!-- avatar -->
                <div class="d-sm-flex align-items-center z-index-9">
                    <ul class="avatar-group mb-0 justify-content-center mb-3 mb-md-0">
                        @foreach ($reviewimage as $image)
                            <li class=" avatar-sm">
                                <img class="avatar-img rounded-circle" src="{{ helper::image_path($image->image) }}"
                                    alt="avatar">
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-muted m-0 px-4 text-center text-truncate">{{ trans('labels.review_section_title') }}</p>
                </div>
                <!-- avatar -->
            </div>
            <div
                class="bg-blur z-index-9 bg-white col-xl-6 col-lg-8 col-md-10 col-sm-10 col-11 rounded-4 p-md-5 p-4 position-absolute top-100 start-50 translate-middle shadow">
                <form action="{{ URL::to($vendordata->slug . '/services') }}" method="get"
                    class="row g-3 align-items-center">
                    <div class="col-md-10">
                        <!-- Input -->
                        <div class="form-input-dropdown position-relative">
                            <input
                                class="form-control {{ session()->get('direction') == 2 ? 'pe-5' : 'ps-5' }} rounded-4 fs-7 p-3"
                                type="text" name="search_input" id="search_input"
                                value="{{ isset($_GET['search_input']) ? $_GET['search_input'] : '' }}"
                                placeholder="{{ trans('labels.search_by_service_name') }}">
                            <span
                                class="position-absolute top-50 translate-middle color-changer {{ session()->get('direction') == 2 ? 'end-0 ps-0' : 'start-0 ps-5' }}"><i
                                    class="fa-light fa-magnifying-glass fs-5"></i></span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <!-- Search btn -->
                        <button type="submit"
                            class="btn btn-lg btn-primary mb-0 rounded-4 btn-submit w-100 p-3">{{ trans('labels.search') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- top-banner -->
    <div class="d-lg-none">
        <div class="pt-5">
            @if (!request()->is($vendordata->slug . '/service-*'))
                @if (helper::top_deals($vendordata->id) != null && count(helper::topdealitemlist($vendordata->id)) > 0)
                    <nav class="bg-primary-rgb p-3">
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
    </div>
    <!-- category section -->
    @if ($getcategories->count() > 0)
        <section class="category pb-5 pt-8">
            <div class="container">
                <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between mb-4">
                    <div>
                        <h3 class="fs-1 fw-600 text-truncate pb-1 text-primary-color fs-3 color-changer">
                            {{ trans('labels.see_all_category') }}
                        </h3>
                        <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.home_category_subtitle') }}</p>
                    </div>
                    <a class="fs-6 fw-semibold btn btn-primary-rgb col-auto"
                        href="{{ URL::to($vendordata->slug . '/categories') }}">{{ trans('labels.viewall') }}
                        {{-- <i
                            class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i> --}}
                    </a>
                </div>
                <div id="category-carousel" class=" owl-carousel owl-theme owl-loaded theme-5">
                    <div class="owl-stage-outer">
                        <div class="owl-stage carousel">
                            @foreach ($getcategories as $category)
                                <div class="owl-item py-2">
                                    <a
                                        href="{{ URL::to($vendordata->slug . '/services?category=' . $category->slug . '&search_input=') }}">
                                        <div class="card border-0 rounded-4 h-100 overflow-hidden">
                                            <div class="position-relative overflow-hidden rounded-4">
                                                <img src="{{ helper::image_path($category->image) }}"
                                                    class="card-img-top img-h" alt="">
                                            </div>
                                            <div class="card-img-overlay d-flex flex-column z-index-1 p-2">
                                                <div class="w-100 mt-auto">
                                                    <P class="text-center fs-7 text-primary-color m-0 text-truncate">
                                                        {{ trans('labels.services') }}
                                                        {{ helper::service_count($category->id) . '+' }}
                                                    </P>
                                                    <p class="mb-1 text-center text-white fw-600 text-truncate">
                                                        {{ $category->name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Category Section -->

    <!-- banner section-1  -->
    @if ($getbannersection1->count() > 0)
        <section>
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
    <!-- banner secction-1 -->

    <!-- service section -->
    @if ($getservices->count() > 0)
        <section class="service-div w-100 py-5">
            <div class="container">
                <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between pb-5">
                    <div>
                        <h3 class="fs-1 fw-600 text-truncate pb-1 text-primary-color fs-3 color-changer">{{ trans('labels.services') }}
                        </h3>
                        <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.our_populer') }}
                            {{ trans('labels.services') }}
                        </p>
                    </div>
                    <a class="fw-semibold btn btn-primary-rgb"
                        href="{{ URL::to($vendordata->slug . '/services') }}">{{ trans('labels.viewall') }}
                        {{-- <i
                            class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i> --}}
                    </a>
                </div>
                <div class="row g-4">
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
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 theme-5">
                            <div class="card theme-5-card pro-shadow h-100 border-0 rounded-4 overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <div class="overflow-hidden rounded-4 img-over">
                                        <img src="{{ helper::image_path($service['service_image']->image) }}"
                                            class="card-img-top w-100 img-h4" alt="...">
                                    </div>
                                    <div class="position-absolute top-0 w-100 p-3 z-index-1">
                                        <div class="d-flex align-items-center justify-content-between">
                                            @if ($off > 0)
                                                <div
                                                    class="{{ session()->get('direction') == '2' ? 'service-right-label' : 'service-left-label ' }} text-bg-primary">
                                                    <p>{{ $off }}% {{ trans('labels.off') }}</p>
                                                </div>
                                            @endif
                                            @if (@helper::checkaddons('customer_login'))
                                                @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                    <div
                                                        class="badges bg-danger {{ session()->get('direction') == '2' ? 'float-start' : 'float-end' }}">
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
                                        </div>
                                    </div>
                                </div>
                                <div class="card-img-overlay d-flex flex-column ">
                                    <div class="w-100 mt-auto z-index-1">
                                        <div class="card-text">
                                            <h5 class="mb-0 fw-semibold text-capitalize">
                                                <a class="text-white text_truncation2 service-cardtitle"
                                                    href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}">{{ $service->name }}</a>
                                            </h5>
                                            @php
                                                $category = helper::getcategoryinfo(
                                                    $service->category_id,
                                                    $service->vendor_id,
                                                );
                                            @endphp
                                            <div class="d-flex align-items-center justify-content-between my-2">
                                                <small
                                                    class="fs-8 text-white text-truncate">{{ $category[0]->name }}</small>
                                                @if (@helper::checkaddons('product_reviews'))
                                                    @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                        <p class="fw-semibold m-0 fs-7 text-white">
                                                            <i class="fas fa-star fa-fw text-warning"></i>
                                                            {{ number_format($service->ratings_average, 1) }}
                                                        </p>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-1">
                                                <p class="fs-6 text-success fw-600 m-0 text-truncate">
                                                    {{ helper::currency_formate($price, $vendordata->id) }}
                                                </p>
                                                @if ($original_price > $price)
                                                    <del class="fs-7 text-muted fw-600 m-0 text-truncate">
                                                        {{ helper::currency_formate($original_price, $vendordata->id) }}
                                                    </del>
                                                @endif
                                            </div>
                                            @if (helper::appdata($vendordata->id)->online_order == 1)
                                                <a href="{{ URL::to($vendordata->slug . '/booking-' . $service->id) }}"
                                                    class="booknow text-primary-color col-auto fw-semibold">
                                                    {{ trans('labels.book_now') }} <i
                                                        class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                            @else
                                                <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                    class="booknow text-primary-color col-auto fw-semibold">
                                                    {{ trans('labels.view') }} <i
                                                        class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
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

    <!------------------------------------------------- Why choose section start ------------------------------------------------->
    @if ($choose->count() > 0)
        <section class="why-choose pt-5">
            <div class="container">
                <div class="row g-4 justify-content-between align-items-center">
                    <!-- Left side START -->
                    <div class="col-lg-5 position-relative">
                        <!-- Image -->
                        <img src="{{ helper::image_path(helper::appdata($vendordata->id)->why_choose_image) }}"
                            class="rounded-4 w-100 position-relative" alt="">
                    </div>
                    <!-- Left side END -->

                    <!-- Right side START -->
                    <div class="col-lg-6 choose-content">
                        <h2 class="fs-1 fw-600 text_truncation2 pb-1 mb-2 text-primary-color color-changer">
                            {{ helper::appdata($vendordata->id)->why_choose_title }}
                        </h2>
                        <p class="mb-3 mb-lg-5 text-muted text_truncation3">
                            {{ helper::appdata($vendordata->id)->why_choose_subtitle }}
                        </p>

                        <!-- Features START -->
                        <div class="row g-4">
                            @foreach ($choose as $choose)
                                <!-- Item -->
                                <div class="col-sm-6">
                                    <img src="{{ helper::image_path($choose->image) }}"
                                        class="icon-lg bg-success bg-opacity-10 text-success rounded-circle"
                                        alt="">

                                    <h5 class="mt-2 fw-600 text-white text-truncate change-light">{{ $choose->title }}
                                    </h5>
                                    <p class="mb-0 text-muted text_truncation2">{{ $choose->description }}</p>
                                </div>
                            @endforeach
                        </div>
                        <!-- Features END -->
                    </div>
                    <!-- Right side END -->
                </div>
            </div>
        </section>
    @endif
    <!-------------------------------------------------- Why choose section end -------------------------------------------------->

    <!----------------------------------------------------- banner-section-2 ----------------------------------------------------->
    @if ($getbannersection2->count() > 0)
        <section class="banner-section-2 pt-5 pb-0 new-banner">
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
    @if (@helper::checkaddons('store_reviews'))
        <!------------------------------------------------ testimonial section start ------------------------------------------------>
        @if ($testimonials->count() > 0)
            <section class="testimonial py-5">
                <div class="container">
                    <div class="testimonial-content py-4">
                        <!-- Title -->
                        <div class="text-center pb-5">
                            <h5 class="fs-1 fw-600 text-truncate pb-1 text-primary-color fs-3 color-changer">
                                {{ trans('labels.testimonial_title') }}
                            </h5>
                            <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.testimonial_subtitle') }}
                            </p>
                        </div>

                        <!-- Testimonials -->
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-12 mb-5 mb-lg-0">
                                <div class="testimonals-top-seven">
                                    <img decoding="async"
                                        src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/other/testimonials-seven.png') }}"
                                        alt="" class="w-100 object-fit-cover">
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <!-- Slider START -->
                                <div id="testimonial" class="owl-carousel owl-theme">
                                    @foreach ($testimonials as $testimonial)
                                        <div class="item">
                                            <div class="card rounded-4 border">
                                                <div class="card-body">
                                                    <div
                                                        class="d-flex align-items-center justify-content-sm-between justify-content-center mb-4">
                                                        <div class="d-sm-flex align-items-center text-center">
                                                            <div class="avatar avatar-xl">
                                                                <img class="avatar-img rounded-circle"
                                                                    src="{{ helper::image_path($testimonial->image) }}"
                                                                    alt="avatar">
                                                            </div>
                                                            <div class="mx-3 text-sm-start">
                                                                <h5 class="mb-0 fw-600 text-truncate color-changer service-cardtitle">
                                                                    {{ $testimonial->name }}
                                                                </h5>
                                                                <span
                                                                    class="text-muted text-truncate fs-7">{{ $testimonial->position }}</span>
                                                                <ul class="list-inline small">
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
                                                        <div class="testimonials-seven-img d-sm-block d-none">
                                                            <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/other/test-quote.svg') }}"
                                                                alt="">
                                                        </div>
                                                    </div>
                                                    <!-- Content -->
                                                    <p
                                                        class="fw-normal fs-7 mb-3 text-sm-start text-center text_truncation3 color-changer">
                                                        "{{ $testimonial->description }}"</p>
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
            </section>
        @endif
        <!------------------------------------------------- testimonial section end ------------------------------------------------->
    @endif
    <!------------------------------------------------ top-category section start ------------------------------------------------>
    @if ($gettoprated->count() > 0)
        <section class="top-category bg-primary-rgb py-5">
            <div class="container">
                <!-- Title -->
                <div class="d-flex gap-3 align-items-center justify-content-between pb-5">
                    <div class="">
                        <h2 class="fs-1 fw-600 line-1 pb-1 text-primary-color fs-3 color-changer">
                            {{ trans('labels.top_ratted_services') }}
                        </h2>
                        <p class="text-font text-muted m-0 line-1">
                            {{ trans('labels.top_ratted_services_sub_title') }}
                        </p>
                    </div>
                    <a class="fw-semibold btn btn-primary-rgb col-auto"
                        href="{{ URL::to($vendordata->slug . '/services') }}">{{ trans('labels.viewall') }}
                        {{-- <i
                            class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i> --}}
                    </a>
                </div>
                <!-- Listing -->
                <div class="row g-4">
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
                        <div class="col-lg-4 col-md-6">
                            <div class="card bg-transparent border border-primary rounded-4 card-body h-100 p-2 text-white">
                                <!-- Image and text -->
                                <div class="card-body p-0">
                                    <div class="d-flex gap-2 align-items-center justify-content-between w-100">
                                        <div class="col-auto position-relative rounded-2 overflow-hidden">
                                            <img src="{{ $toprated['service_image'] == null ? helper::image_path('service.png') : helper::image_path($toprated['service_image']->image) }}"
                                                class="h-110px rounded-2" alt="">
                                            <div class="card-img-overlay p-2 z-index-1">
                                                @if (@helper::checkaddons('customer_login'))
                                                    @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                        <div
                                                            class="badges bg-danger {{ session()->get('direction') == '2' ? 'float-end' : 'float-start' }}">
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
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between align-items-center gap-2">
                                                @if ($off > 0)
                                                    <span
                                                        class="{{ session()->get('direction') == '2' ? 'service-right-label-2' : 'service-left-label-2 ' }} fs-9">
                                                        {{ $off }}% {{ trans('labels.off') }}
                                                    </span>
                                                @endif
                                                @if (@helper::checkaddons('product_reviews'))
                                                    @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                        <p
                                                            class="fw-semibold change-light d-flex align-items-center gap-1 m-0 fs-7 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                                            <i class="fas fa-star fa-fw text-warning"></i>
                                                            {{ $toprated->ratings_average == null ? number_format(0, 1) : number_format($toprated->ratings_average, 1) }}
                                                        </p>
                                                    @endif
                                                @endif
                                            </div>
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                class="fs-13 fw-600 mb-0 text-white change-light text_truncation2 col-9">
                                                {{ $toprated->name }}
                                            </a>
                                            <div class="d-flex gap-2 align-items-center justify-content-between mt-2">
                                                <div
                                                    class="d-flex flex-wrap change-light align-items-center justify-content-between gap-1">
                                                    <p class="fs-7 col-auto m-0 fw-600 text-truncate">
                                                        {{ helper::currency_formate($tprice, $vendordata->id) }}
                                                    </p>
                                                    @if ($toriginal_price > $tprice)
                                                        <del class="fs-8 col-8 m-0 text-muted fw-600 text-truncate">
                                                            {{ helper::currency_formate($toriginal_price, $vendordata->id) }}
                                                        </del>
                                                    @endif
                                                </div>
                                                @if (helper::appdata($vendordata->id)->online_order == 1)
                                                    <a href="{{ URL::to($vendordata->slug . '/booking-' . $toprated->id) }}"
                                                        class="btn btn-primary-rgb btn-round mb-0 col-4 w-40"><i
                                                            class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left' : 'fa-solid fa-arrow-right' }}"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                        class="btn btn-primary-rgb btn-round mb-0 col-4 w-40"><i
                                                            class="fa-regular fa-eye"></i></a>
                                                @endif
                                            </div>
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
    <!------------------------------------------------- top-category section end ------------------------------------------------->

    <!---------------------------------------------- app-downlode section end ---------------------------------------------------->
    @if (@helper::checkaddons('user_app'))
        @if (!empty($app_section))
            @if ($app_section->mobile_app_on_off == 1)
                <section class="py-5">
                    <div class="container">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-6 col-12 mb-5 mb-lg-0 d-none d-md-block">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="mobile-img5">
                                        <img src="{{ helper::image_path(@$app_section->image) }}"
                                            class="object-fit-cover mobile-img" alt="">
                                        {{-- <div class="mobile-circle-one">
                                        <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/other/mobile-circle1.png') }}"
                                            alt="Circle" class="w-100 object-fit-cover filter">
                                    </div>
                                    <div class="mobile-circle-two">
                                        <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/other/mobile-circle2.png') }}"
                                            alt="Circle" class="w-100 object-fit-cover filter">
                                    </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12 text-center text-lg-start">
                                <!-- Title -->
                                <h3 class="m-0 fs-1 fw-600 text-primary-color">{{ @$app_section->title }}
                                </h3>
                                <p class="mb-lg-5 mb-4 mt-3 text-muted text_truncation2">{{ @$app_section->subtitle }}</p>
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
                    <section class="blog-secction py-5">
                        <div class="container">
                            <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between pb-5">
                                <div>
                                    <h5 class="fs-1 fw-600 text-truncate pb-1 text-primary-color fs-3 color-changer">
                                        {{ trans('labels.blog-post') }}
                                    </h5>
                                    <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.latest-post') }}
                                    </p>
                                </div>
                                <a class="fw-semibold btn btn-primary-rgb col-auto"
                                    href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }}
                                    {{-- <i
                                        class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i> --}}
                                </a>
                            </div>
                            <div class="row g-3">
                                @foreach ($getblog as $blog)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card h-100 blog-shadow border-0 rounded-4 overflow-hidden">
                                            <div class="position-relative overflow-hidden">
                                                <img src="{{ helper::image_path($blog->image) }}"
                                                    class="card-img-top w-100 img-h4" alt="...">
                                            </div>
                                            <div class="card-img-overlay d-flex flex-column z-index-1">
                                                <div class="w-100 mt-auto">
                                                    <div class="card-text">
                                                        <h5 class="m-0 fw-semibold text_truncation2 service-cardtitle">
                                                            <a class="text-white"
                                                                href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ $blog->title }}</a>
                                                        </h5>
                                                        <small
                                                            class="card-text text-white fs-7 mt-3 mb-2 text_truncation2">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <p class="mb-1 fw-normal text-white text-truncate fs-7"><i
                                                                class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>
                                                            {{ helper::date_formate($blog->created_at, $vendordata->id) }}
                                                        </p>
                                                        <a class="fw-semibold text-primary-color fs-7"
                                                            href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ trans('labels.readmore') }}<span
                                                                class="mx-1"><i
                                                                    class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></span></a>
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
            @endif
        @else
            @if (@helper::checkaddons('blog'))
                <section class="blog-secction py-5">
                    <div class="container">
                        <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between pb-5">
                            <div>
                                <h5 class="fs-1 fw-600 text-truncate pb-1 text-primary-color fs-3">
                                    {{ trans('labels.blog-post') }}
                                </h5>
                                <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.latest-post') }}
                                </p>
                            </div>
                            <a class="fw-semibold btn btn-primary-rgb"
                                href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }} <i
                                    class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                        </div>
                        <div class="row">
                            @foreach ($getblog as $blog)
                                <div class="col-lg-4 col-md-6 d-flex mt-3 justify-content-sm-center">
                                    <div class="card h-100 blog-shadow border-0 rounded-4 overflow-hidden">
                                        <div class="position-relative overflow-hidden">
                                            <img src="{{ helper::image_path($blog->image) }}"
                                                class="card-img-top w-100 img-h4" alt="...">
                                        </div>
                                        <div class="card-img-overlay d-flex flex-column z-index-1">
                                            <div class="w-100 mt-auto">
                                                <div class="card-text">
                                                    <h5 class="m-0 fw-semibold text_truncation2 service-cardtitle">
                                                        <a class="text-white"
                                                            href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ $blog->title }}</a>
                                                    </h5>
                                                    <small
                                                        class="card-text text-white mt-3 mb-2 text_truncation2">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p class="mb-1 fw-normal text-white text-truncate fs-7"><i
                                                            class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>
                                                        {{ helper::date_formate($blog->created_at, $vendordata->id) }}
                                                    </p>
                                                    <a class="fw-semibold text-primary-color fs-7"
                                                        href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ trans('labels.readmore') }}<span
                                                            class="mx-1"><i
                                                                class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></span></a>
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
        @endif
    @endif
    <!-------------------------------------------------------- Blog section end -------------------------------------------------->
    @if (helper::footer_features(@$vendordata->id)->count() > 0)
        <section class="theme-4-new-product-service theme-5-fie py-5 footer-fiechar-section">
            <div class="container">
                <div class="d-lg-block d-none">
                    <div class="row g-3 justify-content-center">
                        @foreach (helper::footer_features(@$vendordata->id) as $feature)
                            <div class="col-lg-3 col-md-6 col-12 text-center">
                                <div class="card bg-transparent border h-100 rounded-4">
                                    <div class="card-body text-center">
                                        <div class="free-icon fs-2 text-primary-color">
                                            {!! $feature->icon !!}
                                        </div>
                                        <div class="free-content">
                                            <h3 class="fs-6 mb-1 fw-600 text-white change-light">{{ $feature->title }}</h3>
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
                        <div class="item">
                            <div class="card bg-transparent border h-100 rounded-4">
                                <div class="card-body text-center">
                                    <div class="free-icon fs-2 text-primary-color">
                                        {!! $feature->icon !!}
                                    </div>
                                    <div class="free-content">
                                        <h3 class="fs-6 mb-1 fw-600 text-white change-light">{{ $feature->title }}</h3>
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
