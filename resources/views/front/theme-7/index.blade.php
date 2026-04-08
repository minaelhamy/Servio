@extends('front.layout.master')
@section('content')
    <div class="bg-primary-rgb">
        <!-- home-banner -->
        <section class="home-banner theme-7">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-end">

                    <div class="col-12 px-0 d-none d-lg-block">
                        <img src="{{ helper::image_path(helper::appdata($vendordata->id)->home_banner) }}" alt=""
                            class="w-100 object-fit-cover" style="height: 400px;">
                    </div>
                    <div
                        class="d-flex gap-3 flex-wrap align-items-center justify-content-center {{ session()->get('direction') == 2 ? 'banner-content-rtl' : 'banner-content' }}">
                        <div class="col-md-5 col-10 my-md-5 my-0">
                            <div class="section-search">
                                <p class="fs-6 fw-medium text-primary-color mb-1">
                                    {{ helper::appdata($vendordata->id)->homepage_title }}
                                </p>
                                <h1 class="fw-600 home-subtitle m-0 color-changer">
                                    {{ helper::appdata($vendordata->id)->homepage_subtitle }}
                                </h1>
                            </div>
                        </div>
                        <div class="col-md-5 col-10 mb-5 mt-sm-5">
                            <!-- avatar -->
                            <div class="mb-5">
                                <ul
                                    class="avatar-group justify-content-sm-start justify-content-center mb-0 mx-auto mx-lg-0 mb-3">
                                    @foreach ($reviewimage as $image)
                                        <li class="avatar-sm">
                                            <img class="avatar-img rounded-circle"
                                                src="{{ helper::image_path($image->image) }}" alt="avatar">
                                        </li>
                                    @endforeach
                                </ul>
                                <p
                                    class="text-muted m-0 text-truncate {{ session()->get('direction') == 2 ? 'text-sm-end text-center' : 'text-sm-start text-center' }}">
                                    {{ trans('labels.review_section_title') }}
                                </p>
                            </div>
                            <!-- avatar -->
                            <form action="{{ URL::to($vendordata->slug . '/services') }}" method="get"
                                class="bg-body rounded-2 p-2 shadow-sm rounded-4">
                                <div class="input-group gap-2">
                                    <input class="form-control border-0 rounded-3" type="text"
                                        placeholder="{{ trans('labels.search_by_service_name') }}"
                                        value="{{ isset($_GET['search_input']) ? $_GET['search_input'] : '' }}">
                                    <button type="submit" class="btn btn-primary rounded-3 mb-0 btn-submit px-md-4 px-3">
                                        <i
                                            class="fa-solid fa-magnifying-glass {{ session()->get('direction') == 2 ? 'ps-2 ' : 'pe-2' }}"></i>{{ trans('labels.search') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- home-banner -->
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
            <section class="why-choose bg-primary-rgb pt-90 pb-90">
                <div class="container">
                    <div class="row g-sm-5 justify-content-between align-items-center">
                        <!-- Left side START -->
                        <div class="col-lg-6 position-relative">
                            <!-- Image -->
                            <div class="imges-who">
                                <img src="{{ helper::image_path(helper::appdata($vendordata->id)->why_choose_image) }}"
                                    class="rounded-4 position-relative" alt="">
                            </div>
                        </div>
                        <!-- Left side END -->
                        <!-- Right side START -->
                        <div class="col-lg-6 col-12 choose-content">
                            <h2 class="pb-1 fw-600 text_truncation2 fs-1 color-changer">
                                {{ helper::appdata($vendordata->id)->why_choose_title }}
                            </h2>
                            <p class="mb-2 mb-lg-5 text-muted text_truncation3">
                                {{ helper::appdata($vendordata->id)->why_choose_subtitle }}
                            </p>

                            <!-- Features START -->
                            <div class="row g-4">
                                @foreach ($choose as $choose)
                                    <!-- Item -->
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ helper::image_path($choose->image) }}"
                                                class="icon-lg bg-success bg-opacity-10 text-success rounded-circle"
                                                alt="">
                                            <div class="col-9">
                                                <h5 class="fw-600 text-truncate2 m-0 color-changer">{{ $choose->title }}
                                                </h5>
                                            </div>
                                        </div>
                                        <p class="mb-0 text-muted text_truncation2 mt-2">{{ $choose->description }}</p>
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

        <!-- category section -->
        @if ($getcategories->count() > 0)
            <section class="category-theme-7 pt-90 pb-90">
                <div class="container">
                    <div class="text-center pb-5">
                        <h3 class="fw-600 fs-3 text-truncate color-changer">{{ trans('labels.see_all_category') }}</h3>
                        <div class="secondary-line-bottom bg-secondary mx-auto mb-1"></div>
                        <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.top_categories') }}</p>
                    </div>
                    <div class="row g-3">
                        @foreach ($getcategories as $category)
                            <div class="col-xl-3 col-lg-4 col-sm-6 col-6">
                                <div class="bg-primary-rgb2 border p-2 rounded-4">
                                    <div
                                        class="d-flex gap-2 align-items-center  {{ session()->get('direction') == 2 ? 'justify-content-sm-end justify-content-center text-sm-end text-center' : 'justify-content-sm-start justify-content-center text-sm-start text-center' }}">
                                        <!-- Content -->
                                        <div class="px-2 px-md-0 pb-md-0 pb-2 w-100">
                                            <h5 class="mb-1 fw-600 text-truncate service-cardtitle"><a
                                                    href="{{ URL::to($vendordata->slug . '/services?category=' . $category->slug . '&search_input=') }}"
                                                    class="color-changer">{{ $category->name }}</a>
                                            </h5>
                                            <P class="fs-7 text-muted m-0 text-truncate">
                                                {{ trans('labels.services') }}
                                                {{ helper::service_count($category->id) . '+' }}
                                            </P>
                                        </div>
                                        <!-- Image -->
                                        <div class="theme-7-cat col-auto">
                                            <img src="{{ helper::image_path($category->image) }}"
                                                class="card-img-top rounded-4 object-fit-cover" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center pt-5">
                        <a class="fs-6 fw-semibold btn btn-secondary-rgb border border-secondary rounded-5"
                            href="{{ URL::to($vendordata->slug . '/categories') }}">{{ trans('labels.viewall') }} <i
                                class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                    </div>
                </div>
            </section>
        @endif
        <!-- Category Section -->

        @if ($getbannersection1->count() > 0)
            <section class="bg-primary-rgb pt-90 pb-90">
                <div class="container">
                    <div class="row g-md-4 g-3">
                        <div class="col-md-7 col-12">
                            <img src="{{ helper::image_path($getbannersection1[0]->image) }}"
                                class="banner-image-7 w-100 rounded-4" alt="">
                        </div>
                        <div class="col-md-5 col-12">
                            <div class="row g-md-4 g-3">
                                <div class="col-md-12 col-6">
                                    <img src="{{ helper::image_path($getbannersection1[1]->image) }}"
                                        class="banner-small-img w-100 rounded-4" alt="">
                                </div>
                                <div class="col-md-12 col-6">
                                    <div class="card-carousel-7 owl-carousel owl-loaded">
                                        <div class="owl-stage-outer">
                                            <div class="owl-stage carousel">
                                                @foreach ($getbannersection1 as $key => $banner)
                                                    @if ($key != 0 && $key != 1)
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
                                                                    <img src="{{ helper::image_path($banner->image) }}"
                                                                        class="banner-small-img" alt="">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-- banner secction-1 -->

        <!-- service section -->
        @if ($getservices->count() > 0)
            <section class="service-div theme-7 pt-90 pb-90 w-100">
                <div class="container">
                    <div class="text-center pb-5">
                        <h3 class="fw-600 fs-3 color-changer">{{ trans('labels.services') }}</h3>
                        <div class="secondary-line-bottom bg-secondary mx-auto mb-1"></div>
                        <p class="text-font text-muted m-0">{{ trans('labels.our_populer') }}
                            {{ trans('labels.services') }}
                        </p>
                    </div>
                    <div class="row g-4">
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
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                <div class="card rounded-4 overflow-hidden shadow ">
                                    <div class="d-flex gap-2 align-items-center p-2 w-100 border-0">
                                        <div class="col-auto overflow-hidden rounded-4 img-over">
                                            <img src="{{ $service['service_image'] == null ? helper::image_path('service.png') : helper::image_path($service['service_image']->image) }}"
                                                class="card-img-top rounded-4" alt="...">
                                        </div>
                                        <div class="w-100 h-100 d-flex flex-column gap-2 justify-content-center">
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
                                                            class="badges bg-danger rounded-circle {{ session()->get('direction') == '2' ? 'float-start' : 'float-end' }}">
                                                            <button
                                                                onclick="managefavorite('{{ $service->id }}',{{ $vendordata->id }},'{{ URL::to(@$vendordata->slug . '/managefavorite') }}')"
                                                                class="btn border-0 text-white p-0">
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
                                            @php
                                                $category = helper::getcategoryinfo(
                                                    $service->category_id,
                                                    $service->vendor_id,
                                                );
                                            @endphp
                                            <div class="d-flex align-items-center justify-content-between">
                                                <small
                                                    class="fs-8 text-muted text-truncate">{{ $category[0]->name }}</small>
                                                @if (@helper::checkaddons('product_reviews'))
                                                    <div
                                                        class="badge text-dark p-0 d-flex align-items-center justify-content-center fw-semibold">
                                                        <i
                                                            class="fas fa-star fa-fw text-warning {{ session()->get('direction') == '2' ? 'ms-1' : 'me-1' }}"></i>
                                                        @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                            <span
                                                                class="fs-7 color-changer">{{ number_format($service->ratings_average, 1) }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                class="color-changer mb-0 fw-600 text_truncation2 service-cardtitle fs-6">
                                                {{ $service->name }}
                                            </a>
                                            <div class="pt-0">
                                                <div
                                                    class="d-flex gap-1 flex-wrap justify-content-between align-items-center">
                                                    <div class="d-flex gap-1 justify-content-between align-items-center">
                                                        <p class="fw-600 my-0 color-changer text-truncate">
                                                            {{ helper::currency_formate($price, $vendordata->id) }}
                                                        </p>
                                                        @if ($original_price > $price)
                                                            <del class="fw-600 my-0 text-muted text-truncate fs-7">
                                                                {{ helper::currency_formate($original_price, $vendordata->id) }}
                                                            </del>
                                                        @endif
                                                    </div>
                                                    @if (helper::appdata($vendordata->id)->online_order == 1)
                                                        <a href="{{ URL::to($vendordata->slug . '/booking-' . $service->id) }}"
                                                            class="booknow d-flex text-primary fw-semibold">
                                                            {{ trans('labels.book_now') }}
                                                            <i
                                                                class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                                    @else
                                                        <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                            class="booknow d-flex text-primary fw-semibold">
                                                            {{ trans('labels.view') }}
                                                            <i
                                                                class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center pt-5">
                        <a class="fw-semibold btn btn-secondary-rgb border border-secondary rounded-5"
                            href="{{ URL::to($vendordata->slug . '/services') }}">{{ trans('labels.viewall') }} <i
                                class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                    </div>
                </div>
            </section>
        @endif

        <!---------------------------------------------------- product service section start ---------------------------------------------------->
        @if (helper::footer_features(@$vendordata->id)->count() > 0)
            <section class="theme-2-new-product-service py-5 bg-primary-rgb">
                <div class="container">
                    <div class="d-lg-block d-none">
                        <div class="row g-4 justify-content-center">
                            @foreach (helper::footer_features(@$vendordata->id) as $feature)
                                <div class="col-xl-3 col-lg-4 col-sm-6">
                                    <div class="card rounded-4 border h-100 bg-transparent">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center h-100">
                                                <div class="footer-img fs-2 text-primary-color">
                                                    {!! $feature->icon !!}
                                                </div>
                                                <div class="footer-content px-3">
                                                    <h5 class="pst mb-1 fw-600 color-changer">{{ $feature->title }}</h5>
                                                    <p class="fs-7 m-0 text-muted">{{ $feature->description }}</p>
                                                </div>
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
                                <div class="col h-100">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="footer-img fs-2 text-primary-color">
                                            {!! $feature->icon !!}
                                        </div>
                                        <div class="footer-content px-3">
                                            <h5 class="pst mb-1 fw-600 color-changer">{{ $feature->title }}</h5>
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
        <!---------------------------------------------------- product service section end ---------------------------------------------------->
        <!----------------------------------------------------- banner-section-2 ----------------------------------------------------->
        @if ($getbannersection2->count() > 0)
            <section class="banner-section mt-90">
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

        <!------------------------------------------------ top-category section start ------------------------------------------------>
        @if ($gettoprated->count() > 0)
            <section class="top-product pt-90 pb-90">
                <div class="container">
                    <div class="text-center pb-5">
                        <h5 class="fw-600 fs-3 color-changer">{{ trans('labels.top_ratted_services') }}</h5>
                        <div class="secondary-line-bottom bg-secondary mx-auto mb-1"></div>
                        <p class="text-font text-muted m-0">{{ trans('labels.top_ratted_services_sub_title') }}</p>
                    </div>
                    <div class="row g-4 align-items-center">
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
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="card border-0 bg-primary-rgb2 shadow rounded-4 h-100 overflow-hidden">
                                    <div class="">
                                        <div class="rounded-3 overflow-hidden">
                                            <img src="{{ $toprated['service_image'] == null ? helper::image_path('service.png') : helper::image_path($toprated['service_image']->image) }}"
                                                class="product-img rounded-3" alt="">
                                            <div class="card-img-overlay p-3 z-index-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    @if ($off > 0)
                                                        <span
                                                            class="{{ session()->get('direction') == '2' ? 'service-right-label-2' : 'service-left-label-2 ' }} fs-9">
                                                            {{ $off }}% {{ trans('labels.off') }}
                                                        </span>
                                                    @endif
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
                                        </div>
                                    </div>
                                    <div class="product-layer">
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between g-0 w-100 mb-2">
                                            <div>
                                                <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                    class="fs-13 mb-0 fw-600 text_truncation2 col-12">{{ $toprated->name }}</a>
                                            </div>
                                            @if (@helper::checkaddons('product_reviews'))
                                                @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                    <p
                                                        class="fw-semibold m-0 fw-semibold col-3 fs-7 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                                        <i class="fas fa-star fa-fw text-warning"></i>
                                                        {{ $toprated->ratings_average == null ? number_format(0, 1) : number_format($toprated->ratings_average, 1) }}
                                                    </p>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="d-flex g-0 align-items-center justify-content-between">
                                            <div class="d-flex align-items-center gap-1">
                                                <p class="fs-7 col-auto m-0 fw-600">
                                                    {{ helper::currency_formate($tprice, $vendordata->id) }}
                                                </p>
                                                @if ($toriginal_price > $tprice)
                                                    <del class="fs-8 col-8 m-0 fw-600 text-muted">
                                                        {{ helper::currency_formate($toriginal_price, $vendordata->id) }}
                                                    </del>
                                                @endif
                                            </div>
                                            @if (helper::appdata($vendordata->id)->online_order == 1)
                                                <a href="{{ URL::to($vendordata->slug . '/booking-' . $toprated->id) }}"
                                                    class="text-primary btn btn-primary-rgb z-1">
                                                    <i
                                                        class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                            @else
                                                <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                    class="text-primary z-1 btn btn-primary-rgb">
                                                    <i class="fa-regular fa-eye"></i></a>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center pt-5">
                        <a href="{{ URL::to($vendordata->slug . '/services') }}"
                            class="fw-semibold btn btn-secondary-rgb border border-secondary rounded-5 m-0">{{ trans('labels.view_all') }}<i
                                class="mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                    </div>
                </div>
            </section>
        @endif

        <!------------------------------------------------- top-category section end ------------------------------------------------->

        @if (@helper::checkaddons('store_reviews'))
            <!---------------------------------------------------- testimonial section start ----------------------------------------------------->
            @if ($testimonials->count() > 0)
                <section class="bg-primary-rgb py-5">
                    <div class="container">
                        <!-- Title -->
                        <div class="text-center pb-5">
                            <h5 class="fw-600 fs-3 color-changer">{{ trans('labels.testimonial_title') }}</h5>
                            <div class="secondary-line-bottom bg-secondary mx-auto mb-1"></div>
                            <p class="text-font text-muted m-0">{{ trans('labels.testimonial_subtitle') }}</p>
                        </div>
                        <div id="testimonial2" class="owl-carousel owl-theme test">
                            @foreach ($testimonials as $testimonial)
                                <div class="item h-100">
                                    <div class="card h-100 text-center rounded-4 border-0">
                                        <div class="card-body p-4">
                                            <img class="card-img-top rounded-2 mx-auto mt-0 mb-2 {{ session()->get('direction') == 2 ? 'u-image-1-rtl' : 'u-image-1' }}"
                                                src="{{ helper::image_path($testimonial->image) }}" alt="">
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
                                            <h5 class="mb-2 fw-600 service-cardtitle color-changer">
                                                {{ $testimonial->name }}</h5>
                                            <span class="text-muted fs-7">{{ $testimonial->position }}</span>
                                            <p class="fs-7 text_truncation3 fw-normal text-muted mt-3">
                                                {{ $testimonial->description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
            <!------------------------------------------------- testimonial section end ------------------------------------------------->
        @endif

        <!------------------------------------------------- app-downlode section start ------------------------------------------------->
        @if (@helper::checkaddons('user_app'))
            @if (!empty($app_section))
                @if ($app_section->mobile_app_on_off == 1)
                    <section class="py-5">
                        <div class="container">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-lg-5 d-none d-lg-block position-relative">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <img src="{{ helper::image_path(@$app_section->image) }}" class="h-400px"
                                            alt="">
                                    </div>
                                </div>
                                <div
                                    class="col-lg-6 col-12 col-md-9 m-auto z-1 text-center {{ session()->get('direction') == 2 ? 'text-lg-end' : 'text-lg-start' }}">
                                    <!-- Title -->
                                    <h3 class="fs-1 m-0 fw-600 color-changer">{{ @$app_section->title }}</h3>
                                    <p class="mb-lg-5 mb-4 mt-3 text-muted">{{ @$app_section->subtitle }}</p>
                                    <!-- Button -->
                                    <div class="hstack justify-content-center justify-content-lg-start gap-3">
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
                            </div>
                        </div>
                    </section>
                @endif
            @endif
        @endif
        <!------------------------------------------------- app-downlode section end ------------------------------------------------->


        <!-- Blog Section -->
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
                        <section class="blog-secction theme-7 py-5 extra-margin bg-primary-rgb">
                            <div class="container">
                                <div class="text-center pb-5">
                                    <h5 class="fw-600 fs-3 color-changer">{{ trans('labels.blog-post') }}</h5>
                                    <div class="secondary-line-bottom bg-secondary mx-auto mb-1"></div>
                                    <p class="text-font text-muted m-0">{{ trans('labels.latest-post') }}</p>
                                </div>
                                <div class="row g-4">
                                    @foreach ($getblog as $blog)
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="card border-0 rounded-4 overflow-hidden">
                                                <div class="img-overlay rounded-4">
                                                    <img src="{{ helper::image_path($blog->image) }}"
                                                        class="blog-img rounded-4 object-fit-cover" alt="...">
                                                </div>
                                                <div class="card-body">
                                                    <h6 class="fw-600"><a
                                                            href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                            class="text-dark text_truncation2">{{ $blog->title }}</a>
                                                    </h6>
                                                    <div class="mt-2">
                                                        <div
                                                            class="d-flex flex-wrap gap-1 align-items-center justify-content-between">
                                                            <p class="fw-normal fs-8 mb-0"><i
                                                                    class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>
                                                                {{ helper::date_formate($blog->created_at, $vendordata->id) }}
                                                            </p>
                                                            <a class="fw-semibold text-primary fs-7"
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
                                <div class="d-flex justify-content-center pt-5">
                                    <a class="fw-semibold btn btn-secondary-rgb border border-secondary rounded-5"
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
                    <section class="blog-secction theme-7 pt-90 pb-90 extra-margin bg-primary-rgb">
                        <div class="container">
                            <div class="text-center pb-5">
                                <h5 class="fw-600 fs-3">{{ trans('labels.blog-post') }}</h5>
                                <div class="secondary-line-bottom bg-secondary mx-auto mb-1"></div>
                                <p class="text-font text-muted m-0">{{ trans('labels.latest-post') }}</p>
                            </div>
                            <div class="row g-4">
                                @foreach ($getblog as $blog)
                                    <div class="col-xl-4 col-sm-6">
                                        <div class="card border-0 rounded-4 overflow-hidden">
                                            <div class="img-overlay rounded-4">
                                                <img src="{{ helper::image_path($blog->image) }}"
                                                    class="blog-img rounded-4 object-fit-cover" alt="...">
                                            </div>
                                            <div class="card-body">
                                                <h6 class="fw-600"><a
                                                        href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                        class="text-dark text_truncation2">{{ $blog->title }}</a>
                                                </h6>
                                                <div class="mt-2">
                                                    <div
                                                        class="d-flex flex-wrap gap-1 align-items-center justify-content-between">
                                                        <p class="fw-normal fs-8 mb-0"><i
                                                                class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>
                                                            {{ helper::date_formate($blog->created_at, $vendordata->id) }}
                                                        </p>
                                                        <a class="fw-semibold text-primary fs-7"
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
                            <div class="d-flex justify-content-center pt-5">
                                <a class="fw-semibold btn btn-secondary-rgb border border-secondary rounded-5"
                                    href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }}
                                    <i
                                        class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                            </div>
                        </div>
                    </section>
                @endif
            @endif
        @endif
        <!-- Blog section -->


    </div>
@endsection
@section('scripts')
    <script>
        var direction = "{{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}";
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/index.js') }}"></script>
@endsection
