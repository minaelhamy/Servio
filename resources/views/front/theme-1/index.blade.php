@extends('front.layout.master')
@section('content')

    <!-- top-banner -->
    <section class="theme-1-home position-relative home-banner py-8 py-lg-9"
        style="background-image:url({{ helper::image_path(helper::appdata($vendordata->id)->home_banner) }}); background-position: center left; background-size: cover; height:100%">
        <div class="bg-overlay"></div>
        <div class="container z-index-9 position-relative">
            <div class="row py-sm-5">
                <div class="col-xl-8 m-auto text-center mt-2 mt-md-0">
                    <p class="fs-6 fw-medium text-primary-color">{{ helper::appdata($vendordata->id)->homepage_title }}</p>
                    <h1 class="fw-600 text-white home-subtitle m-0">
                        {{ helper::appdata($vendordata->id)->homepage_subtitle }}</h1>
                </div>
                <div class="col-xl-8 mx-auto">
                    <div class="bg-blur bg-white bg-opacity-10 border border-light border-opacity-25 rounded-3 p-4 my-5">
                        <form action="{{ URL::to($vendordata->slug . '/services') }}" method="get"
                            class="row g-3 align-items-center">
                            <div class="col-md-10">
                                <!-- Input -->
                                <div class="form-input-dropdown position-relative">
                                    <input class="form-control form-control-lg ps-5 rounded fs-7" type="text"
                                        name="search_input" id="search_input"
                                        value="{{ isset($_GET['search_input']) ? $_GET['search_input'] : '' }}"
                                        placeholder="{{ trans('labels.search_by_service_name') }}">
                                    <span
                                        class="position-absolute top-50 translate-middle color-changer {{ session()->get('direction') == 2 ? 'ps-5 start-0' : 'end-0 pe-1' }}"><i
                                            class="fa-light fa-magnifying-glass fs-5"></i></span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <!-- Search btn -->
                                <button type="submit"
                                    class="btn btn-lg btn-primary mb-0 rounded btn-submit w-100">{{ trans('labels.search') }}</button>
                            </div>
                        </form>
                    </div>
                    <!-- avatar -->
                    <div class="">
                        <ul class="avatar-group mb-0 mx-auto mx-lg-0 justify-content-center mb-3">
                            @foreach ($reviewimage as $image)
                                <li class="avatar-sm">
                                    <img class="avatar-img rounded-circle" src="{{ helper::image_path($image->image) }}"
                                        alt="avatar">
                                </li>
                            @endforeach
                        </ul>
                        <p class="text-muted m-0 px-md-4 text-center text-truncate">
                            {{ trans('labels.review_section_title') }}
                        </p>
                    </div>
                    <!-- avatar -->
                </div>
            </div>
        </div>
    </section>
    <!-- banner section-1  -->
    <div class="d-lg-none">
        @if (helper::top_deals($vendordata->id) != null && count(helper::topdealitemlist($vendordata->id)) > 0)
            <nav class="bg-primary-rgb p-3 mt-2">
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
    </div>
    @if ($getbannersection1->count() > 0)
        <section class="my-5">
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

    <!-- category section -->
    @if ($getcategories->count() > 0)
        <section class="category my-5">
            <div class="container">
                <div class="d-flex gap-3 align-items-center justify-content-between pb-5">
                    <div>
                        <h3 class="fw-600 fs-3 line-1 color-changer">{{ trans('labels.see_all_category') }}</h3>
                        <p class="text-font text-muted line-1 m-0">{{ trans('labels.home_category_subtitle') }}</p>
                    </div>
                    <a class="fs-6 fw-semibold btn btn-primary-rgb col-auto"
                        href="{{ URL::to($vendordata->slug . '/categories') }}">{{ trans('labels.viewall') }}
                        {{-- <i
                            class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i> --}}
                    </a>
                </div>
                <div class="category-carousel owl-carousel owl-theme owl-loaded category-slide">
                    <div class="owl-stage-outer">
                        <div class="owl-stage carousel">
                            @foreach ($getcategories as $category)
                                <div class="owl-item">
                                    <a
                                        href="{{ URL::to($vendordata->slug . '/services?category=' . $category->slug . '&search_input=') }}">
                                        <div
                                            class="card border-0 rounded-4 h-100 w-100 bg-light text-center align-items-center">
                                            <div class="card-body">
                                                <div class="icon-xl bg-mode rounded-circle mb-2 mx-auto">
                                                    <img src="{{ helper::image_path($category->image) }}"
                                                        class="card-img-top" alt="">
                                                </div>
                                                <P class="text-center fs-7 text-primary-color m-0 text-truncate">
                                                    {{ trans('labels.services') }}
                                                    {{ helper::service_count($category->id) . '+' }}
                                                </P>
                                                <p class="mb-1 text-center text-dark fw-600 text-truncate color-changer">
                                                    {{ $category->name }}
                                                </p>
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

    <!------------------------------------------------- service section start ------------------------------------------------->
    @if ($getservices->count() > 0)
        <section class="service-div w-100">
            <div class="container">
                <div class="d-flex gap-3 align-items-center justify-content-between my-5">
                    <div class="">
                        <h5 class="fw-600 fs-3 line-1 color-changer">{{ trans('labels.services') }}</h5>
                        <p class="text-font text-muted line-1 m-0">{{ trans('labels.our_populer') }}
                            {{ trans('labels.services') }}</p>
                    </div>
                    <a class="fw-semibold btn btn-primary-rgb col-auto"
                        href="{{ URL::to($vendordata->slug . '/services') }}">{{ trans('labels.viewall') }}
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
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <div class="card shadow h-100 w-100 border-0 rounded-4 overflow-hidden">
                                <div class="position-relative overflow-hidden img-over">
                                    @if ($service['service_image'] == null)
                                        <img src="{{ helper::image_path('service.png') }}" class="card-img-top w-100"
                                            alt="...">
                                    @else
                                        <img src="{{ helper::image_path($service['service_image']->image) }}"
                                            class="card-img-top w-100" alt="...">
                                    @endif
                                    <div class="card-img-overlay p-3 z-index-1">
                                        <div class="d-flex justify-content-between align-items-center">
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

                                <div class="card-body">
                                    <div class="card-text">
                                        <h6
                                            class="mb-0 fs-16 fw-semibold text_truncation2 text-capitalize service-cardtitle">
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                class="color-changer">{{ $service->name }}</a>
                                        </h6>
                                        <div class="d-flex align-items-center justify-content-between mt-2">
                                            @php
                                                $category = helper::getcategoryinfo(
                                                    $service->category_id,
                                                    $service->vendor_id,
                                                );
                                            @endphp
                                            @if (@helper::checkaddons('product_reviews'))
                                                <small
                                                    class="fs-8 text-muted text-truncate">{{ $category[0]->name }}</small>
                                                @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                    <p class="fw-semibold m-0 fs-7"><i
                                                            class="fas fa-star fa-fw text-warning"></i>
                                                        <span class="color-changer">
                                                            {{ number_format($service->ratings_average, 1) }}
                                                        </span>
                                                    </p>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-top p-3 bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center gap-1">
                                            <p class="fw-600 my-0 text-truncate fs-16 color-changer">
                                                {{ helper::currency_formate($price, $vendordata->id) }}
                                            </p>
                                            @if ($original_price > $price)
                                                <del class="fw-600 my-0 text-truncate text-muted fs-18">
                                                    {{ helper::currency_formate($original_price, $vendordata->id) }}
                                                </del>
                                            @endif
                                        </div>
                                        @if (helper::appdata($vendordata->id)->online_order == 1)
                                            <a href="{{ URL::to($vendordata->slug . '/booking-' . $service->id) }}"
                                                class="booknow text-primary-color fw-semibold">
                                                {{ trans('labels.book_now') }} <i
                                                    class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                        @else
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                class="booknow text-primary-color fw-semibold">
                                                {{ trans('labels.view') }} <i
                                                    class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
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
    <!----------------------------------------------------- service section end ----------------------------------------------------->

    <!----------------------------------------------------- banner-section-2 ----------------------------------------------------->
    @if ($getbannersection2->count() > 0)
        <section class="banner-section-2 py-5">
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

    <!------------------------------------------------- Why choose section start ------------------------------------------------->
    @if ($choose->count() > 0)
        <section class="why-choose mb-5">
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
                        <h2 class="pb-1 fw-600 text_truncation2 fs-1 color-changer">
                            {{ helper::appdata($vendordata->id)->why_choose_title }}
                        </h2>
                        <p class="mb-3 mb-lg-5 text-muted text_truncation3">
                            {{ helper::appdata($vendordata->id)->why_choose_subtitle }}</p>

                        <!-- Features START -->
                        <div class="row g-4">
                            <!-- Item -->
                            @foreach ($choose as $choose)
                                <div class="col-sm-6">
                                    <img src="{{ helper::image_path($choose->image) }}"
                                        class="icon-lg bg-success bg-opacity-10 text-success rounded-circle"
                                        alt="">
                                    <h5 class="mt-2 fw-600 text-truncate color-changer">{{ $choose->title }}</h5>
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


    <!------------------------------------------------ testimonial section start ------------------------------------------------>
    @if (@helper::checkaddons('store_reviews'))
        @if ($testimonials->count() > 0)
            <section class="testimonial bg-light py-5"
                style="background-image:url({{ url(env('ASSETPATHURL') . 'admin-assets/images/other/construction_shape.png') }}); background-position: center left; background-size: cover;">
                <div class="container">
                    <div class="text-center position-relative py-5">
                        <!-- Title -->
                        <div class="mb-4 text-center">
                            <div class="mb-3 mb-sm-4">
                                <h5 class="fw-600 fs-3 text-truncate fs-3 color-changer">
                                    {{ trans('labels.testimonial_title') }}</h5>
                                <p class="text-font color-changer m-0 text-truncate">
                                    {{ trans('labels.testimonial_subtitle') }}
                                </p>
                            </div>
                        </div>

                        <!-- Testimonials -->
                        <div class="row">
                            <div class="col-md-9 col-xl-7 mx-auto">
                                <!-- Slider START -->
                                <div id="testimonial" class="owl-carousel owl-theme">
                                    @foreach ($testimonials as $testimonial)
                                        <div class="item">
                                            <div class="avatar avatar-xl mb-4">
                                                <img class="avatar-img rounded-circle"
                                                    src="{{ helper::image_path($testimonial->image) }}" alt="avatar">
                                            </div>
                                            <!-- Content -->
                                            <p class="fs-5 px-3 fw-normal mb-3 text_truncation2 color-changer">
                                                "{{ $testimonial->description }}"
                                            </p>
                                            <ul class="list-inline small mb-3">
                                                @php
                                                    $count = (int) $testimonial->star;
                                                @endphp
                                                @for ($i = 0; $i < 5; $i++)
                                                    @if ($i < $count)
                                                        <li class="list-inline-item me-0 small">
                                                            <i class="fa-solid fa-star text-warning"></i>
                                                        </li>
                                                    @else
                                                        <li class="list-inline-item me-0 small">
                                                            <i class="fa-regular fa-star text-warning"></i>
                                                        </li>
                                                    @endif
                                                @endfor
                                            </ul>
                                            <h5 class="mb-0 fw-600 text-truncate service-cardtitle color-changer">
                                                {{ $testimonial->name }}</h5>
                                            <span
                                                class="color-changer text-truncate fs-7">{{ $testimonial->position }}</span>
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
    @endif
    <!------------------------------------------------- testimonial section end ------------------------------------------------->

    <!------------------------------------------------ top rated service section start ------------------------------------------------>
    @if ($gettoprated->count() > 0)
        <section class="top-category py-5">
            <div class="container">
                <div class="row g-4 align-items-center justify-content-between">
                    <!-- Listing -->
                    <div class="col-lg-7 order-2 order-lg-0">
                        <div class="row g-4">
                            @foreach ($gettoprated as $toprated)
                                @php
                                    if ($toprated->top_deals == 1 && @helper::top_deals($vendordata->id) != null) {
                                        if (@helper::top_deals($vendordata->id)->offer_type == 1) {
                                            if ($toprated->price > @helper::top_deals($vendordata->id)->offer_amount) {
                                                $tprice =
                                                    $toprated->price -
                                                    @helper::top_deals($vendordata->id)->offer_amount;
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
                                <div class="col-md-6">
                                    <div class="card shadow border-0">
                                        <div class="card-body p-0">
                                            <div
                                                class="d-flex gap-3 align-items-center h-100 w-100 border-0 rounded-4 overflow-hidden p-2">
                                                <div class="col-auto">
                                                    <div class="h-110px rounded-2 position-relative overflow-hidden">
                                                        <img src="{{ $toprated['service_image'] == null ? helper::image_path('service.png') : helper::image_path($toprated['service_image']->image) }}"
                                                            class="card-img-top h-100 rounded-2" alt="">
                                                        <div class="card-img-overlay p-1 z-index-1">
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
                                                </div>
                                                <div class="w-100">
                                                    <div
                                                        class="d-flex gap-2 justify-content-between align-items-center w-10">
                                                        @if ($off > 0)
                                                            <span
                                                                class="{{ session()->get('direction') == '2' ? 'service-right-label-2' : 'service-left-label-2 ' }} fs-9">
                                                                {{ $off }}% {{ trans('labels.off') }}
                                                            </span>
                                                        @endif
                                                        @if (@helper::checkaddons('product_reviews'))
                                                            @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                                <p
                                                                    class="fw-semibold m-0 gap-1 fs-7 d-flex align-items-center">
                                                                    <i class="fas fa-star fa-fw text-warning"></i>
                                                                    <span class="color-changer">
                                                                        {{ $toprated->ratings_average == null ? number_format(0, 1) : number_format($toprated->ratings_average, 1) }}
                                                                    </span>
                                                                </p>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                        class="fs-13 fw-600 my-1 text_truncation2 col-12 color-changer">{{ $toprated->name }}</a>
                                                    <div class="d-flex g-0 align-items-center justify-content-between">
                                                        <div
                                                            class="d-flex flex-wrap align-items-center justify-content-between gap-1">
                                                            <p
                                                                class="fs-7 col-auto m-0 fw-600 text-truncate color-changer">
                                                                {{ helper::currency_formate($tprice, $vendordata->id) }}
                                                            </p>
                                                            @if ($toriginal_price > $tprice)
                                                                <del
                                                                    class="fs-8 col-8 m-0 fw-600 text-muted text-truncate">
                                                                    {{ helper::currency_formate($toriginal_price, $vendordata->id) }}
                                                                </del>
                                                            @endif
                                                        </div>
                                                        @if (helper::appdata($vendordata->id)->online_order == 1)
                                                            <a href="{{ URL::to($vendordata->slug . '/booking-' . $toprated->id) }}"
                                                                class="btn btn-primary-rgb btn-round mb-0 col-4 w-40"><i
                                                                    class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left' : 'fa-solid fa-arrow-right' }}"></i></a>
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
                    <!-- Title -->
                    <div class="col-lg-4">
                        <div
                            class="d-flex flex-lg-column gap-3 align-items-lg-start align-items-center justify-content-between">
                            <div class="">
                                <h2 class="fs-3 fw-600 text_truncation2 line-1 color-changer">
                                    {{ trans('labels.top_ratted_services') }}
                                </h2>
                                <p class="text-font text-muted line-1">{{ trans('labels.top_ratted_services_sub_title') }}
                                </p>
                            </div>
                            <a href="{{ URL::to($vendordata->slug . '/services') }}"
                                class="fw-semibold btn btn-primary-rgb m-0 col-auto">
                                {{ trans('labels.view_all') }}
                                {{-- <i
                                    class="mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left' : 'fa-solid fa-arrow-right' }}"></i> --}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!------------------------------------------------- top rated service section end ------------------------------------------------->

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
                    <section class="blog-secction py-5">
                        <div class="container">
                            <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between pb-5">
                                <div>
                                    <h5 class="fw-600 fs-3 line-1 color-changer">{{ trans('labels.blog-post') }}</h5>
                                    <p class="text-font text-muted line-1 m-0">{{ trans('labels.latest-post') }}</p>
                                </div>
                                <a class="fw-semibold btn btn-primary-rgb"
                                    href="{{ URL::to($vendordata->slug . '/allblogs') }}">
                                    {{ trans('labels.viewall') }}
                                </a>
                            </div>
                            <div class="row g-4">
                                @foreach ($getblog as $blog)
                                    <div class="col-lg-4 col-md-6 d-flex justify-content-sm-center">
                                        <div class="card shadow border-0 rounded-4 overflow-hidden w-100">
                                            <div class="img-overlay rounded-4">
                                                <img src="{{ helper::image_path($blog->image) }}" height="250"
                                                    class="rounded-4 w-100 object-fit-cover" alt="...">
                                            </div>
                                            <div class="card-body">
                                                <h5 class="fw-600 service-cardtitle text_truncation2"><a
                                                        href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                        class="text-dark color-changer">{{ $blog->title }}</a></h5>
                                                <small
                                                    class="card-text text-muted m-0 blog-description fs-7 text_truncation2">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                            </div>
                                            <div class="card-footer border-top-0 bg-transparent">
                                                <div class="d-flex justify-content-between">
                                                    <p class="mb-1 fw-normal text-muted fs-7"><i
                                                            class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>
                                                        {{ helper::date_formate($blog->created_at, $vendordata->id) }}
                                                    </p>
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
                                <h5 class="fw-600 fs-3 color-changer">{{ trans('labels.blog-post') }}</h5>
                                <p class="text-font text-muted m-0">{{ trans('labels.latest-post') }}</p>
                            </div>
                            <a class="fw-semibold btn btn-primary-rgb"
                                href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }}
                                <i
                                    class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                        </div>
                        <div class="row g-4">
                            @foreach ($getblog as $blog)
                                <div class="col-lg-4 col-md-6 d-flex justify-content-sm-center">
                                    <div class="card shadow border-0 rounded-4 overflow-hidden w-100">
                                        <div class="img-overlay rounded-4">
                                            <img src="{{ helper::image_path($blog->image) }}" height="250"
                                                class="rounded-4 w-100 object-fit-cover" alt="...">
                                        </div>
                                        <div class="card-body">
                                            <h5 class="fw-600 service-cardtitle text_truncation2"><a
                                                    href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                    class="text-dark color-changer">{{ $blog->title }}</a></h5>
                                            <small
                                                class="card-text text-muted m-0 blog-description fs-7 text_truncation2">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                        </div>
                                        <div class="card-footer border-top-0 bg-transparent">
                                            <div class="d-flex justify-content-between">
                                                <p class="mb-1 fw-normal text-muted fs-7"><i
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
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
        @endif
    @endif
    <!------------------------------------------------------ Blog section end ------------------------------------------------------>

    <!---------------------------------------------------- app-downlode section end ---------------------------------------------------->

    @if (@helper::checkaddons('user_app'))
        @if (!empty($app_section))
            @if ($app_section->mobile_app_on_off == 1)
                <section class="mb-5">
                    <div class="container">
                        <div class="card border-0 rounded-4 bg-lights position-relative overflow-hidden">
                            <div class="card-body p-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-xl-5 col-lg-6 col-md-9 m-auto z-1">
                                        <!-- Title -->
                                        <h3 class="m-0 fw-600 app-title color-changer">{{ @$app_section->title }}</h3>
                                        <p class="mb-lg-5 mb-4 mt-3 text-muted">{{ @$app_section->subtitle }}</p>
                                        <!-- Button -->
                                        <div class="hstack gap-3">
                                            <!-- Google play store button -->
                                            @if (@$app_section->android_link != '' || @$app_section->android_link != null)
                                                <a href="{{ @$app_section->android_link }}"> <img
                                                        src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/other/google-play.svg') }}"
                                                        class="h-50px" alt=""> </a>
                                            @endif
                                            @if (@$app_section->ios_link != '' || @$app_section->ios_link != null)
                                                <!-- App store button -->
                                                <a href="{{ @$app_section->ios_link }}"> <img
                                                        src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/other/app-store.svg') }}"
                                                        class="h-50px" alt=""> </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-xl-5 col-lg-6 d-none d-lg-block z-index-9">
                                        <img src="{{ helper::image_path(@$app_section->image) }}" class="h-400px"
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


    @if (helper::footer_features(@$vendordata->id)->count() > 0)
        <section class="py-5 footer-fiechar-section">
            <div class="container">
                <div class="d-lg-block d-none">
                    <div class="row g-3 justify-content-center">
                        @foreach (helper::footer_features(@$vendordata->id) as $feature)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                                <div class="footer-widget border-0 card h-100 rounded-4">
                                    <div class="widget-wrapper d-flex align-items-start">
                                        <div class="widget-icon fs-3 text-primary-color"> {!! $feature->icon !!} </div>
                                        <div class="widget-content">
                                            <h3 class="pst fw-600 color-changer">{{ $feature->title }}</h3>
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
                            <div class="col">
                                <div class="footer-widget border-0 card h-100 rounded-4">
                                    <div class="widget-wrapper d-flex justify-content-center align-items-start">
                                        <div class="widget-icon fs-3 text-primary-color"> {!! $feature->icon !!} </div>
                                        <div class="widget-content">
                                            <h3 class="pst fw-600 color-changer">{{ $feature->title }}</h3>
                                            <p class="fs-7 m-0 text-muted">{{ $feature->description }}</p>
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
@endsection


@section('scripts')
    <script>
        var direction = "{{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}";
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/index.js') }}"></script>
@endsection
