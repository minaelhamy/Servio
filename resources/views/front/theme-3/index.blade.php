@extends('front.layout.master')
@section('content')
    <!-------------------------------------------------------- top-banner -------------------------------------------------------->
    <section class="home-banner-3 py-8 pt-100">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-5 col-lg-6 position-relative d-none d-md-block order-2 order-lg-0">
                    <img src="{{ helper::image_path(helper::appdata($vendordata->id)->home_banner) }}" alt=""
                        class="w-100 h-700px round-top object-fit-cover right-shadow">
                </div>
                <div class="col-xl-6 col-lg-6 banner-content mb-5 mb-lg-0">
                    <p class="fw-semibold text-primary-color mb-3">{{ helper::appdata($vendordata->id)->homepage_title }}
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
                                <li class="avatar-sm">
                                    <img class="avatar-img rounded-circle" src="{{ helper::image_path($image->image) }}"
                                        alt="avatar">
                                </li>
                            @endforeach
                        </ul>
                        <p class="text-white m-0 px-4 text-center text-truncate">{{ trans('labels.review_section_title') }}
                        </p>
                    </div>
                    <!-- avatar -->
                </div>
            </div>
        </div>
    </section>
    <div class="d-lg-none">
        @if (!request()->is($vendordata->slug . '/service-*'))
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
        @endif
    </div>
    <!----------------------------------------------------- banner section-1 ----------------------------------------------------->
    @if (@$getbannersection1->count() > 0)
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

    <!----------------------------------------------------- category section ----------------------------------------------------->
    @if (@$getcategories->count() > 0)
        <section class="category bg-primary-rgb py-5 ">
            <div class="container">
                <div class="d-flex gap-3 align-items-center justify-content-between pb-5">
                    <div>
                        <h3 class="fw-600 theme-3-title text-truncate fs-3 line-1 color-changer">
                            {{ trans('labels.see_all_category') }}
                        </h3>
                        <p class="fw-semibold text-primary-color mb-0 text-truncate line-1">
                            {{ trans('labels.home_category_subtitle') }}
                        </p>
                    </div>
                    <a class="fs-6 fw-semibold btn btn-primary-rgb col-auto"
                        href="{{ URL::to($vendordata->slug . '/categories') }}">{{ trans('labels.viewall') }}
                    </a>
                </div>
                <div class="cat3 owl-carousel owl-theme">
                    @foreach ($getcategories as $category)
                        <div class="item">
                            <a
                                href="{{ URL::to($vendordata->slug . '/services?category=' . $category->slug . '&search_input=') }}">
                                <div class="card bg-transparent border-0 rounded-4 h-100 w-100 text-center">
                                    <div class="icon-xxl border border-1 border-primary rounded-circle mb-2 mt-3 mx-auto">
                                        <img src="{{ helper::image_path($category->image) }}" class="card-img-top"
                                            alt="">
                                    </div>
                                    <div class="card-body">
                                        <P class="mb-1 text-center fs-7 text-primary-color m-0 text-truncate">
                                            {{ trans('labels.services') }}
                                            {{ helper::service_count($category->id) . '+' }}
                                        </P>
                                        <h5 class="m-0 text-center fw-600 text-truncate color-changer fs-6">
                                            {{ $category->name }}
                                        </h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- Category Section -->

    <!------------------------------------------------------ service section ------------------------------------------------------>
    @if (@$getservices->count() > 0)
        <section class="service-div w-100 py-5">
            <div class="container">
                <div class="d-flex gap-3 align-items-center justify-content-between pb-5">
                    <div class="">
                        <h3 class="fw-600 theme-3-title text-truncate fs-3 line-1 color-changer">
                            {{ trans('labels.services') }}</h3>
                        <p class="fw-semibold text-primary-color m-0 text-truncate line-1">
                            {{ trans('labels.our_populer') }}
                            {{ trans('labels.services') }}
                        </p>
                    </div>
                    <a class="fw-semibold btn btn-primary-rgb"
                        href="{{ URL::to($vendordata->slug . '/services') }}">{{ trans('labels.viewall') }}
                        {{-- <i
                            class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i> --}}
                    </a>
                </div>
                <div class="row g-4 listing-view">
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
                        <div class="col-lg-6 col-md-12">
                            <div class="card my-cart-categories shadow h-100 w-100 border-0 rounded-4 overflow-hidden p-2">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="test-img">
                                            <div class="rounded-4 position-relative overflow-hidden">
                                                <img src="{{ $service['service_image'] == null ? helper::image_path('service.png') : helper::image_path(@$service['service_image']->image) }}"
                                                    class="card-img-top p-0 border rounded-4" alt="...">
                                                @if (@helper::checkaddons('customer_login'))
                                                    @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                        <div class="card-img-overlay p-2 z-index-1">
                                                            <div class="badges bg-danger rounded text-center">
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
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <div class="w-100">
                                            @php
                                                $category = helper::getcategoryinfo(
                                                    $service->category_id,
                                                    $service->vendor_id,
                                                );
                                            @endphp
                                            <div class="d-flex justify-content-between">
                                                @if ($off > 0)
                                                    <span
                                                        class="{{ session()->get('direction') == '2' ? 'service-right-label-2' : 'service-left-label-2 ' }}">
                                                        {{ $off }}% {{ trans('labels.off') }}
                                                    </span>
                                                @endif
                                                @if (@helper::checkaddons('product_reviews'))
                                                    @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                        <p
                                                            class="fw-semibold m-0 fs-8 d-flex gap-1 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }} ">
                                                            <i class="fas fa-star fs-8 text-warning"></i>
                                                            <span class="color-changer">
                                                                {{ helper::ratting($service->id, $vendordata->id) == null ? number_format(0, 1) : number_format(helper::ratting($service->id, $vendordata->id), 1) }}
                                                            </span>
                                                        </p>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center my-1">
                                                <small class="text-muted text-truncate">{{ $category[0]->name }}</small>
                                            </div>
                                            <h5 class="title text_truncation2 my-1">
                                                <a class="fs-7 color-changer"
                                                    href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}">{{ $service->name }}</a>
                                            </h5>
                                            <div class="d-flex gap-1 justify-content-between align-items-center">
                                                <div class="d-flex flex-wrap align-items-center gap-1">
                                                    <p class="price fs-7 m-0 fw-600 text-truncate color-changer">
                                                        {{ helper::currency_formate($price, $vendordata->id) }}
                                                    </p>
                                                    @if ($original_price > $price)
                                                        <del class="price fs-8 m-0 fw-600 text-muted text-truncate">
                                                            {{ helper::currency_formate($original_price, $vendordata->id) }}
                                                        </del>
                                                    @endif
                                                </div>

                                                @if (helper::appdata($vendordata->id)->online_order == 1)
                                                    <a href="{{ URL::to($vendordata->slug . '/booking-' . $service->id) }}"
                                                        class="booknow text-primary-color fw-semibold d-none d-md-block">{{ trans('labels.book_now') }}<i
                                                            class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>

                                                    <a href="{{ URL::to($vendordata->slug . '/booking-' . $service->id) }}"
                                                        class="btn btn-primary-rgb btn-round mb-0 d-block d-md-none"><i
                                                            class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left' : 'fa-solid fa-arrow-right' }}"></i></a>
                                                @else
                                                    <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                        class="booknow text-primary-color fw-semibold d-none d-md-block">{{ trans('labels.view') }}<i
                                                            class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>

                                                    <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                        class="btn btn-primary-rgb btn-round mb-0 d-block d-md-none"><i
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

    <!------------------------------------------------- Why choose section start ------------------------------------------------->
    @if ($choose->count() > 0)
        <section class="why-choose mt-4">
            <div class="container">
                <div class="row g-4 justify-content-between align-items-center">
                    <!-- Right side START -->
                    <div class="col-lg-6 choose-content order-2 order-lg-0">
                        <h2 class="fw-600 text_truncation2 fs-1 color-changer">
                            {{ helper::appdata($vendordata->id)->why_choose_title }}
                        </h2>
                        <p class="py-2 text-muted text_truncation3">
                            {{ helper::appdata($vendordata->id)->why_choose_subtitle }}
                        </p>
                        <!-- Features START -->
                        <div class="row g-4 g-md-5 mt-2">
                            <!-- Item -->
                            @foreach ($choose as $choose)
                                <div class="col-12">
                                    <div class="d-flex">
                                        <img src="{{ helper::image_path($choose->image) }}"
                                            class="col-2 icon-lg bg-success bg-opacity-10 text-success rounded-circle"
                                            alt="">
                                        <div class="mx-3">
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

                    <!-- Left side START -->
                    <div class="col-lg-5 position-relative">
                        <!-- Image -->
                        <img src="{{ helper::image_path(helper::appdata($vendordata->id)->why_choose_image) }}"
                            class="w-100 position-relative round-top left-shadow" alt="">
                    </div>
                    <!-- Left side END -->
                </div>
            </div>
        </section>
    @endif
    <!-------------------------------------------------- Why choose section end -------------------------------------------------->

    <!----------------------------------------------------- banner-section-2 ----------------------------------------------------->
    @if (@$getbannersection2->count() > 0)
        <section class="banner-section-2 pb-0 new-banner">
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
        <section class="top-category py-5">
            <div class="container">
                <!-- Title -->
                <div class="d-flex gap-3 align-items-center justify-content-between pb-5">
                    <div class="">
                        <h3 class="fw-600 theme-3-title fs-3 line-1 color-changer">
                            {{ trans('labels.top_ratted_services') }}
                        </h3>
                        <p class="fw-semibold text-primary-color m-0 line-1">
                            {{ trans('labels.top_ratted_services_sub_title') }}
                        </p>
                    </div>
                    <a href="{{ URL::to($vendordata->slug . '/services') }}"
                        class="fw-semibold btn btn-primary-rgb col-auto">{{ trans('labels.view_all') }}
                        {{-- <i
                            class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-regular fa-arrow-left' : 'fa-regular fa-arrow-right' }}"></i> --}}
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
                        <div class="col-lg-3 col-md-4 col-12">
                            <div class="card border-0 rounded-4 shadow h-100 p-2">
                                <div class="card-body pb-0">
                                    <div class="d-flex flex-column ">
                                        <!-- Image and text -->
                                        <div class="h-110px rounded-2 position-relative overflow-hidden mb-3 mx-auto">
                                            <img src="{{ helper::image_path($toprated['service_image']->image) }}"
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
                                        <h5 class="fs-13 fw-600 mb-0 text-center text_truncation2 col-12">
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                class="color-changer">
                                                {{ Str::limit($toprated->name, 50) }}
                                            </a>
                                        </h5>
                                        <div
                                            class="d-flex align-items-center {{ $off > 0 ? 'justify-content-between' : 'justify-content-center' }}">
                                            @if ($off > 0)
                                                <span
                                                    class="{{ session()->get('direction') == '2' ? 'service-right-label-2' : 'service-left-label-2 ' }} fs-9">
                                                    {{ $off }}% {{ trans('labels.off') }}
                                                </span>
                                            @endif
                                            @if (@helper::checkaddons('product_reviews'))
                                                @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                    <p class="fw-semibold m-0 text-center mt-1 fs-7">
                                                        <i class="fas fa-star fa-fw text-warning"></i>
                                                        <span class="color-changer">
                                                            {{ $toprated->ratings_average == null ? number_format(0, 1) : number_format($toprated->ratings_average, 1) }}
                                                        </span>
                                                    </p>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-top-0 bg-transparent">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-1">
                                            <p class="fs-7 col-auto m-0 fw-600 text-truncate color-changer">
                                                {{ helper::currency_formate($tprice, $vendordata->id) }}
                                            </p>
                                            @if ($toriginal_price > $tprice)
                                                <del class="fs-8 col-8 m-0 fw-600 text-muted text-truncate">
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
    <!------------------------------------------------- top-category section end ------------------------------------------------->
    @if (@helper::checkaddons('store_reviews'))
        <!------------------------------------------------ testimonial section start ------------------------------------------------>
        @if ($testimonials->count() > 0)
            <section class="testimonial bg-lights py-5">
                <div class="container">
                    <div class="text-center position-relative">
                        <!-- Title -->
                        <div class="mb-4 text-center">
                            <div class="mb-3 mb-sm-4">
                                <h5 class="fw-600 theme-3-title text-truncate fs-3 color-changer">
                                    {{ trans('labels.testimonial_title') }}</h5>
                                <p class="fw-semibold text-primary-color m-0 text-truncate">
                                    {{ trans('labels.testimonial_subtitle') }}
                                </p>
                            </div>
                        </div>
                        <!-- Slider START -->
                        <div id="testimonial3" class="owl-carousel owl-theme">
                            @foreach ($testimonials as $testimonial)
                                <div class="item my-4">
                                    <div
                                        class="card h-100 shadow border-0 rounded-4 p-md-5 p-3 position-relative overflow-hidden">
                                        <span class="quote-icon d-none d-md-block"></span>
                                        <div class="d-flex align-items-center mb-4">
                                            <div class="avatar avatar-xl postion-relative">
                                                <img class="avatar-img avatar-img border-end border-5 rounded-2 border-primary"
                                                    src="{{ helper::image_path($testimonial->image) }}" alt="avatar">
                                            </div>
                                            <div class="ps-4 text-start">
                                                <ul class="list-inline small mb-2">
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
                                                <h5 class="mb-1 fw-600 text-truncate service-cardtitle color-changer">
                                                    {{ $testimonial->name }}
                                                </h5>
                                                <span class="text-muted text-truncate fs-7">
                                                    {{ $testimonial->position }}
                                                </span>
                                            </div>
                                        </div>
                                        <!-- Content -->
                                        <p class="text-muted text-start lh-lg fw-500 fs-7 text_truncation3 m-0">
                                            {{ $testimonial->description }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Slider END -->
                    </div>
                </div>
            </section>
        @endif
        <!------------------------------------------------- testimonial section end ------------------------------------------------->
    @endif
    <!------------------------------------------------------- Blog Section start ------------------------------------------------------->
    @if (@$getblog->count() > 0)
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
                    <section class="blog-secction">
                        <div class="container">
                            <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between py-5">
                                <div class="">
                                    <h5 class="fw-600 theme-3-title text-truncate fs-3 color-changer">
                                        {{ trans('labels.blog-post') }}
                                    </h5>
                                    <p class="fw-semibold text-primary-color m-0 text-truncate">
                                        {{ trans('labels.latest-post') }}
                                    </p>
                                </div>
                                <a class="fw-semibold btn btn-primary-rgb"
                                    href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }}
                                </a>
                            </div>
                            <div class="row g-4 pb-5">
                                @foreach ($getblog as $blog)
                                    <div class="col-lg-6 col-md-6 d-flex justify-content-sm-center">
                                        <div class="card border-0 rounded-4 shadow p-3 overflow-hidden">
                                            <div class="row g-0">
                                                <div class="col-md-8 order-2 order-lg-0">
                                                    <div class="card-body">
                                                        <p class="mb-2 fw-normal text-muted fs-7 text-truncate"><i
                                                                class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>{{ helper::date_formate($blog->created_at, $blog->vendor_id) }}
                                                        </p>
                                                        <h5 class="fw-600 service-cardtitle"><a
                                                                href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                                class="text-dark text_truncation2 color-changer">{{ $blog->title }}</a>
                                                        </h5>
                                                        <small
                                                            class="card-text fs-7 text-muted mb-3 blog-description text_truncation2 border-top pt-2">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                        <a class="fw-semibold text-primary-color fs-7"
                                                            href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ trans('labels.readmore') }}<span
                                                                class="mx-1"><i
                                                                    class="{{ session()->get('direction') == 2 ? 'fa-light fa-arrow-left-long fw-semibold' : 'fa-light fa-arrow-right-long fw-semibold' }}"></i></span></a>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <img src="{{ helper::image_path($blog->image) }}" height="200"
                                                        class="rounded-3 w-100 object-fit-cover" alt="...">
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
    @else
        @if (@helper::checkaddons('blog'))
            <section class="blog-secction">
                <div class="container">
                    <div class="d-flex flex-wrap gap-3 align-items-center justify-content-between py-5">
                        <div class="">
                            <h5 class="fw-600 theme-3-title text-truncate fs-3 color-changer">
                                {{ trans('labels.blog-post') }}
                            </h5>
                            <p class="fw-semibold text-primary-color m-0 text-truncate">
                                {{ trans('labels.latest-post') }}
                            </p>
                        </div>
                        <a class="fw-semibold btn btn-primary-rgb"
                            href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }}
                        </a>
                    </div>
                    <div class="row g-4 pb-5">
                        @foreach ($getblog as $blog)
                            <div class="col-lg-6 col-md-6 d-flex justify-content-sm-center">
                                <div class="card border-0 rounded-4 shadow p-3 overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-md-8 order-2 order-lg-0">
                                            <div class="card-body">
                                                <p class="mb-2 fw-normal text-muted fs-7 text-truncate"><i
                                                        class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>{{ helper::date_formate($blog->created_at, $blog->vendor_id) }}
                                                </p>
                                                <h5 class="fw-600 service-cardtitle"><a
                                                        href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                        class="text-dark text_truncation2 color-changer">{{ $blog->title }}</a>
                                                </h5>
                                                <small
                                                    class="card-text fs-7 text-muted mb-3 blog-description text_truncation2 border-top pt-2">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                <a class="fw-semibold text-primary-color fs-7"
                                                    href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ trans('labels.readmore') }}<span
                                                        class="mx-1"><i
                                                            class="{{ session()->get('direction') == 2 ? 'fa-light fa-arrow-left-long fw-semibold' : 'fa-light fa-arrow-right-long fw-semibold' }}"></i></span></a>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <img src="{{ helper::image_path($blog->image) }}" height="200"
                                                class="rounded-3 w-100 object-fit-cover" alt="...">
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
    <!-------------------------------------------------------- Blog section end -------------------------------------------------------->

    <!---------------------------------------------------- app-downlode section end ---------------------------------------------------->
    @if (@helper::checkaddons('user_app'))
        @if (!empty($app_section))
            @if ($app_section->mobile_app_on_off == 1)
                <section class="app-downlode overflow-hidden py-5">
                    <div class="container">
                        <div class="card border-0 bg-lights rounded-4 position-relative py-5 p-3">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-xl-4 col-lg-4 col-12 d-none d-md-block mb-5 mb-lg-0">
                                    <img src="{{ helper::image_path(@$app_section->image) }}"
                                        class="img-3 {{ session()->get('direction') == 2 ? 'mobile-img-rtl' : 'mobile-img' }} object-fit-cover d-none mx-auto d-md-block"
                                        alt="">
                                </div>
                                <div class="col-xl-5 col-lg-5 col-md-10 col-12 text-center text-md-start">
                                    <!-- Title -->
                                    <h3 class="m-0 fw-600 app-title">{{ @$app_section->title }}</h3>
                                    <p class="my-3 text_truncation2">{{ @$app_section->subtitle }}</p>
                                </div>
                                <div class="col-xl-3 col-lg-3">
                                    <!-- Button -->
                                    <div class="hstack gap-3 flex-lg-column justify-content-center">
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
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endif
    @endif
    <!---------------------------------------------------- app-downlode section end ---------------------------------------------------->
    <!---------------------- product service section start ---------------------->
    @if (helper::footer_features(@$vendordata->id)->count() > 0)
        <section class="product-service py-5 bg-lights footer-fiechar-section">
            <div class="container">
                <div class="rounded-4 d-lg-block d-none">
                    <div class="row g-3 align-items-center justify-content-around">
                        @foreach (helper::footer_features(@$vendordata->id) as $feature)
                            <div class="col-xl-3 col-lg-3 col-md-6 text-center">
                                <div class="free-icon fs-2 text-primary-color color-changer">
                                    {!! $feature->icon !!}
                                </div>
                                <div class="free-content">
                                    <h3 class="fs-6 fw-600 color-changer">{{ $feature->title }}</h3>
                                    <p class="fs-7 text-muted">{{ $feature->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="footer-fiechar-slider owl-carousel owl-theme d-lg-none">
                    @foreach (helper::footer_features(@$vendordata->id) as $feature)
                        <div class="item">
                            <div class="col text-center">
                                <div class="free-icon fs-2 text-primary-color color-changer">
                                    {!! $feature->icon !!}
                                </div>
                                <div class="free-content">
                                    <h3 class="fs-6 fw-600 color-changer">{{ $feature->title }}</h3>
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
@endsection


@section('scripts')
    <script>
        var direction = "{{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}";
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/index.js') }}"></script>
@endsection
