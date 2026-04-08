@extends('front.layout.master')
@section('content')
    <!-- top-banner -->
    <section class="theme-4-home-banner position-relative py-lg-3 py-xl-4 py-xxl-5"
        style="background-image:url({{ helper::image_path(helper::appdata($vendordata->id)->home_banner) }}); background-position: center left; background-size: cover; /* height:100vh; */">
        <div class="container-fluid position-relative zindex-2 py-5 py-md-3 py-lg-5">
            <div class="row pb-3 pt-4 pt-sm-5">
                <div
                    class="col-md-9 col-lg-8 col-xl-6 col-xxl-5 {{ session()->get('direction') == '2' ? 'offset-lg-rtl' : 'offset-lg-1' }}">
                    <div class="card h-100 border-0 bg-dark rounded-4 p-md-5 py-sm-3 py-xl-4">
                        <div class="card-body p-xl-5 p-4">
                            <div class="mx-auto">
                                <h1 class="display-5 fw-semibold text-white mb-4">
                                    {{ helper::appdata($vendordata->id)->homepage_subtitle }}
                                </h1>
                                <p class="text-muted">{{ helper::appdata($vendordata->id)->homepage_title }}</p>
                                <form action="{{ URL::to($vendordata->slug . '/services') }}" method="get"
                                    class="bg-body p-2 shadow-sm rounded-2 mt-5 mb-5 w-100">
                                    <div class="input-group gap-2">
                                        <input class="form-control border-0 rounded-2 px-3 p-0 theme-4-search-input"
                                            type="text"
                                            value="{{ isset($_GET['search_input']) ? $_GET['search_input'] : '' }}"
                                            placeholder="{{ trans('labels.search_by_service_name') }}">
                                        <button type="submit"
                                            class="btn btn-primary rounded-2 mb-0 btn-submit px-md-4 px-3"><i
                                                class="fa-solid fa-magnifying-glass pe-2"></i>{{ trans('labels.search') }}</button>
                                    </div>
                                </form>
                                <!-- avatar -->
                                <div>
                                    <ul class="avatar-group mb-0 mx-auto mx-lg-0 justify-content-center mb-3">
                                        @foreach ($reviewimage as $image)
                                            <li class=" avatar-sm">
                                                <img class="avatar-img rounded-circle"
                                                    src="{{ helper::image_path($image->image) }}" alt="avatar">
                                            </li>
                                        @endforeach
                                    </ul>
                                    <p class="text-muted m-0 px-4 text-center text-truncate">
                                        {{ trans('labels.review_section_title') }}
                                    </p>
                                </div>
                                <!-- avatar -->
                            </div>
                        </div>
                    </div>
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
    <!-- category section -->
    @if ($getcategories->count() > 0)
        <section class="pb-5 theme-4 mt-5">
            <div class="container">
                <div class="text-center pb-5">
                    <h3 class="fs-1 fw-600 text-truncate fs-3 color-changer">{{ trans('labels.see_all_category') }}</h3>
                    <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.home_category_subtitle') }}</p>
                </div>
                {{-- new design --}}
                <div class="category-carousel owl-carousel owl-theme owl-loaded">
                    <div class="owl-stage-outer">
                        <div class="owl-stage carousel">
                            @foreach ($getcategories as $category)
                                <div class="owl-item py-2">
                                    <a
                                        href="{{ URL::to($vendordata->slug . '/services?category=' . $category->slug . '&search_input=') }}">
                                        <div
                                            class="card border-0 cat-theme-4-img rounded-4 overflow-hidden h-100 w-100 bg-light text-center align-items-center shadow-sm">
                                            <img src="{{ helper::image_path($category->image) }}"
                                                class="card-img-top object-fit-content" alt="">
                                            <div class="card-body w-100">
                                                <P class="text-center fs-7 text-primary-color m-0 text-truncate">
                                                    {{ trans('labels.services') }}
                                                    {{ helper::service_count($category->id) . '+' }}
                                                </P>
                                                <p class="m-0 text-center text-dark fw-600 text-truncate color-changer">
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
                {{-- new design --}}

                <div class="d-flex justify-content-center pt-5">
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
        <section class="theme-4">
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
        <section class="service-div theme-4-service w-100 py-5">
            <div class="container">
                <div class="text-center pb-5">
                    <h3 class="fs-1 fw-600 text-truncate fs-3 color-changer">{{ trans('labels.services') }}</h3>
                    <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.our_populer') }}
                        {{ trans('labels.services') }}
                    </p>
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
                        <div class="col-sm-6 col-lg-4 col-xl-3">
                            <div class="card h-100 w-100 border-0 overflow-hidden bg-transparent">
                                <div class="position-relative overflow-hidden rounded-4 img-over">
                                    <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}">
                                        <img src="{{ helper::image_path($service['service_image']->image) }}"
                                            class="card-img-top w-100 object-fit-cover rounded-4 img-h" alt="..."></a>
                                    <div class="card-img-overlay z-index-1 p-4">
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
                                @php
                                    $category = helper::getcategoryinfo($service->category_id, $service->vendor_id);
                                @endphp
                                <div class="card-body px-2 pb-0">
                                    <div class="card-text">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div class="w-100">
                                                <span class="fs-7 fw-500 text-muted">{{ $category[0]->name }}</span>
                                            </div>
                                            @if (@helper::checkaddons('product_reviews'))
                                                @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                    <span class="fs-7 h-100 d-flex gap-1 align-items-center fs-7">
                                                        <i class="fas fa-star fa-fw text-warning"></i>
                                                        <p class="m-0 color-changer">
                                                            {{ number_format($service->ratings_average, 1) }}
                                                        </p>
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                        <h5 class="fw-semibold text_truncation2 service-cardtitle">
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                class="color-changer">{{ $service->name }}</a>
                                        </h5>
                                    </div>
                                </div>
                                <div class="card-footer border-0 bg-transparent pt-0 px-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex justify-content-between align-items-center gap-1">
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
                                                class="booknow text-primary-color fw-semibold d-flex align-items-center gap-1">
                                                {{ trans('labels.book_now') }}
                                                <i
                                                    class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                        @else
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                class="booknow text-primary-color fw-semibold d-flex align-items-center gap-1">
                                                {{ trans('labels.view') }}
                                                <i
                                                    class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center pt-5">
                    <a class="fw-semibold btn btn-primary-rgb"
                        href="{{ URL::to($vendordata->slug . '/services') }}">{{ trans('labels.viewall') }} <i
                            class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                </div>
            </div>
        </section>
    @endif
    <!------------------------------------------------- Why choose section start ------------------------------------------------->
    @if ($choose->count() > 0)
        <section class="why-choose bg-primary-rgb py-5">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <!-- Left side START -->
                    <div class="col-lg-5 mb-4 mb-lg-0">
                        <!-- Image -->
                        <img src="{{ helper::image_path(helper::appdata($vendordata->id)->why_choose_image) }}"
                            class="rounded-4 w-100" alt="">
                    </div>
                    <!-- Left side END -->

                    <!-- Right side START -->
                    <div class="col-lg-6">
                        <h2 class="pb-1 fw-600 text_truncation2 fs-1 color-changer">
                            {{ helper::appdata($vendordata->id)->why_choose_title }}
                        </h2>
                        <p class="mb-3 mb-lg-5 text-muted text_truncation3">
                            {{ helper::appdata($vendordata->id)->why_choose_subtitle }}
                        </p>
                        <!-- Features START -->
                        <div class="row justify-content-center g-4">
                            <!-- Item -->
                            @foreach ($choose as $choose)
                                <div class="col-md-6">
                                    <div class="card border-0 rounded-4 shadow h-100">
                                        <div class="card-body p-4">
                                            <img src="{{ helper::image_path($choose->image) }}"
                                                class="icon-lg bg-success bg-opacity-10 text-success rounded-circle"
                                                alt="">
                                            <h5 class="fw-600 my-2 text-truncate color-changer">{{ $choose->title }}</h5>
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
        </section>
    @endif

    <!-------------------------------------------------- Why choose section end -------------------------------------------------->

    <!------------------------------------------------ top-category section start ------------------------------------------------>
    @if ($gettoprated->count() > 0)
        <section class="top-category theme-4-service theme-4 py-5">
            <div class="container">
                <div class="text-center pb-5">
                    <h2 class="fs-1 fw-600 text-truncate fs-3 color-changer">{{ trans('labels.top_ratted_services') }}
                    </h2>
                    <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.top_ratted_services_sub_title') }}
                    </p>
                </div>
                <!-- Listing -->
                <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-4 top-cate">
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
                        <div class="col">
                            <div class="card border-0 rounded-4 h-100">
                                <div class="card-img overflow-hidden rounded-4 position-relative">
                                    <img src="{{ $toprated['service_image'] == null ? helper::image_path('service.png') : helper::image_path($toprated['service_image']->image) }}"
                                        class="w-100 object-fit-cover rounded-4" alt="">
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
                                <div class="card-body px-2 pb-0">
                                    @if (@helper::checkaddons('product_reviews'))
                                        @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                            <p class="fw-semibold m-0 mb-1"><i
                                                    class="fas fa-star fa-fw text-warning fs-13"></i>
                                                <span
                                                    class="fs-13 color-changer">{{ $toprated->ratings_average == null ? number_format(0, 1) : number_format($toprated->ratings_average, 1) }}</span>
                                            </p>
                                        @endif
                                    @endif
                                    <div class="d-flex justify-content-between">
                                        <a class="fs-13 mb-0 text_truncation2 fw-600 color-changer"
                                            href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}">{{ $toprated->name }}</a>
                                    </div>
                                </div>
                                <div class="card-footer border-0 bg-transparent p-2 rounded-bottom-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-1">
                                            <p class="fs-7 col-auto m-0 fw-600 text-truncate text-success">
                                                {{ helper::currency_formate($tprice, $vendordata->id) }}
                                            </p>
                                            @if ($toriginal_price > $tprice)
                                                <del class="fs-8 col-10 m-0 fw-600 text-muted text-truncate">
                                                    {{ helper::currency_formate($toriginal_price, $vendordata->id) }}
                                                </del>
                                            @endif
                                        </div>
                                        @if (helper::appdata($vendordata->id)->online_order == 1)
                                            <a href="{{ URL::to($vendordata->slug . '/booking-' . $toprated->id) }}"
                                                class="btn btn-primary-rgb btn-round flex-shrink-0"><i
                                                    class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left' : 'fa-solid fa-arrow-right' }}"></i></a>
                                        @else
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                class="btn btn-primary-rgb btn-round flex-shrink-0"><i
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
                        class="fw-semibold btn btn-primary-rgb m-0">{{ trans('labels.view_all') }}<i
                            class="mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                </div>
            </div>
        </section>
    @endif
    <!------------------------------------------------- top-category section end ------------------------------------------------->
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

    @if (@helper::checkaddons('store_reviews'))
        <!------------------------------------------------ testimonial section start ------------------------------------------------->
        @if ($testimonials->count() > 0)
            <section class="testimonial py-5">
                <div class="container">
                    <div class="text-center position-relative">
                        <!-- Title -->
                        <div class="text-center pb-5">
                            <h5 class="fs-1 fw-600 text-truncate fs-3 color-changer">
                                {{ trans('labels.testimonial_title') }}</h5>
                            <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.testimonial_subtitle') }}
                            </p>
                        </div>
                        <!-- Slider START -->
                        <div id="testimonial4" class="owl-carousel owl-theme">
                            <!-- item -->
                            @foreach ($testimonials as $testimonial)
                                <div class="item py-4 px-3">
                                    <div class="card border-0 rounded-4 bg-primary-rgb shadow">
                                        <div class="card-body p-4">
                                            <ul
                                                class="list-inline small mb-3 text-start">
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
                                            <div class="d-flex align-items-center justify-contnt-between mb-4">
                                                <div class="avatar col-auto">
                                                    <img class="avatar-img rounded-circle"
                                                        src="{{ helper::image_path($testimonial->image) }}"
                                                        alt="avatar">
                                                </div>
                                                <div class="w-100">
                                                    <p
                                                        class="mb-1 fw-semibold text-start color-changer text-truncate service-cardtitle">
                                                        {{ $testimonial->name }}
                                                    </p>
                                                    <p class="text-muted line-2 fs-7 text-start">{{ $testimonial->position }}</p>
                                                </div>
                                            </div>
                                            <!-- Content -->
                                            <p
                                                class="fw-normal fs-7 mb-3 text-start color-changer text_truncation3">
                                                “{{ $testimonial->description }}”
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- Slider END -->
                    </div>
                </div>
            </section>
        @endif
        <!------------------------------------------------- testimonial section end -------------------------------------------------->
    @endif
    <!------------------------------------------------- app-downlode section end ------------------------------------------------->
    @if (@helper::checkaddons('user_app'))
        @if (!empty($app_section))
            @if ($app_section->mobile_app_on_off == 1)
                <section class="bg-primary">
                    <div class="container">
                        <div class="card border-0 bg-primary overflow-hidden">
                            <div class="card-body py-5">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-xl-6 col-lg-6 col-md-9 z-1">
                                        <!-- Title -->
                                        <h3 class="mb-4 fs-1 fw-600 app-title">{{ @$app_section->title }}</h3>
                                        <p class="mb-lg-5 mb-4 mt-3 text_truncation2">{{ @$app_section->subtitle }}</p>
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
                    <section class="blog-secction py-5">
                        <div class="container">
                            <div class="text-center pb-5">
                                <h3 class="fs-1 fw-600 text-truncate pb-1 fs-3 color-changer">
                                    {{ trans('labels.blog-post') }}</h3>
                                <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.latest-post') }}</p>
                            </div>
                            <div class="row g-3 justify-content-between">
                                @foreach ($getblog as $key => $blog)
                                    @if ($key == 0)
                                        <div class="col-lg-6">
                                            <div class="card rounded-4 border bg-transparent w-100">
                                                <div class="img-overlay rounded-4">
                                                    <img src="{{ helper::image_path($blog->image) }}"
                                                        class="rounded-4 w-100 object-fit-cover" alt="...">
                                                </div>
                                                <div class="card-body service-cardtitle">
                                                    <h5 class="fw-600 text_truncation2 service-cardtitle">
                                                        <a href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                            class="color-changer">
                                                            {{ $blog->title }}
                                                        </a>
                                                    </h5>
                                                    <small
                                                        class="card-text text-muted m-0 text_truncation2 mb-0 fs-7">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                </div>
                                                <div class="card-footer border-top-0 bg-transparent p-3">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <p class="m-0 fw-normal text-muted fs-7"><i
                                                                class="fa-solid fa-calendar-days"></i> <span
                                                                class="px-1">{{ helper::date_formate($blog->created_at, $vendordata->id) }}</span>
                                                        </p>
                                                        <div class="d-flex justify-content-end">
                                                            <a class="fw-semibold text-primary-color fs-7"
                                                                href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ trans('labels.readmore') }}<span
                                                                    class="mx-1"><i
                                                                        class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                        @else
                                            <div class="card border rounded-4 bg-transparent mb-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="theme-4-blog-img col-auto img-overlay rounded-4">
                                                        <img src="{{ helper::image_path($blog->image) }}"
                                                            class="rounded-4 w-100 h-100 object-fit-cover" alt="...">
                                                    </div>
                                                    <div class="w-100 p-2">
                                                        <h5 class="fw-600 text_truncation2 service-cardtitle">
                                                            <a href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                                class="text-dark color-changer">
                                                                {{ $blog->title }}
                                                            </a>
                                                        </h5>
                                                        <small
                                                            class="card-text text-muted m-0 text_truncation2">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                        <div class="d-flex flex-wrap justify-content-between mt-2">
                                                            <p class="m-0 fw-normal text-muted fs-7">
                                                                <i class="fa-solid fa-calendar-days"></i>
                                                                <span class="px-1">
                                                                    {{ helper::date_formate($blog->created_at, $vendordata->id) }}
                                                                </span>
                                                            </p>
                                                            <a class="fw-semibold text-primary-color fs-7 d-flex align-items-center gap-1"
                                                                href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">
                                                                {{ trans('labels.readmore') }}
                                                                <span>
                                                                    <i
                                                                        class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endif
                                @endforeach
                            </div>

                        </div>
                        <div class="d-flex justify-content-center pt-5">
                            <a class="fw-semibold btn btn-primary-rgb"
                                href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }}
                                <i
                                    class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i>
                            </a>
                        </div>
                    </section>
                @endif
            @endif
        @else
            @if (@helper::checkaddons('blog'))
                <section class="blog-secction py-5">
                    <div class="container">
                        <div class="text-center pb-5">
                            <h3 class="fs-1 fw-600 text-truncate pb-1 fs-3 color-changer">
                                {{ trans('labels.blog-post') }}</h3>
                            <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.latest-post') }}</p>
                        </div>
                        <div class="row g-3 justify-content-between">
                            @foreach ($getblog as $key => $blog)
                                @if ($key == 0)
                                    <div class="col-lg-6">
                                        <div class="card rounded-4 border bg-transparent w-100">
                                            <div class="img-overlay rounded-4">
                                                <img src="{{ helper::image_path($blog->image) }}"
                                                    class="rounded-4 w-100 object-fit-cover" alt="...">
                                            </div>
                                            <div class="card-body service-cardtitle">
                                                <h5 class="fw-600 text_truncation2 service-cardtitle">
                                                    <a href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                        class="color-changer">
                                                        {{ $blog->title }}
                                                    </a>
                                                </h5>
                                                <small
                                                    class="card-text text-muted m-0 text_truncation2 mb-0 fs-7">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                            </div>
                                            <div class="card-footer border-top-0 bg-transparent p-3">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <p class="m-0 fw-normal text-muted fs-7"><i
                                                            class="fa-solid fa-calendar-days"></i> <span
                                                            class="px-1">{{ helper::date_formate($blog->created_at, $vendordata->id) }}</span>
                                                    </p>
                                                    <div class="d-flex justify-content-end">
                                                        <a class="fw-semibold text-primary-color fs-7"
                                                            href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ trans('labels.readmore') }}<span
                                                                class="mx-1"><i
                                                                    class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                    @else
                                        <div class="card border rounded-4 bg-transparent mb-4">
                                            <div class="d-flex align-items-center">
                                                <div class="theme-4-blog-img col-auto img-overlay rounded-4">
                                                    <img src="{{ helper::image_path($blog->image) }}"
                                                        class="rounded-4 w-100 h-100 object-fit-cover" alt="...">
                                                </div>
                                                <div class="w-100 p-2">
                                                    <h5 class="fw-600 text_truncation2 service-cardtitle">
                                                        <a href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}"
                                                            class="text-dark color-changer">
                                                            {{ $blog->title }}
                                                        </a>
                                                    </h5>
                                                    <small
                                                        class="card-text text-muted m-0 text_truncation2">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                    <div class="d-flex flex-wrap justify-content-between mt-2">
                                                        <p class="m-0 fw-normal text-muted fs-7">
                                                            <i class="fa-solid fa-calendar-days"></i>
                                                            <span class="px-1">
                                                                {{ helper::date_formate($blog->created_at, $vendordata->id) }}
                                                            </span>
                                                        </p>
                                                        <a class="fw-semibold text-primary-color fs-7 d-flex align-items-center gap-1"
                                                            href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">
                                                            {{ trans('labels.readmore') }}
                                                            <span>
                                                                <i
                                                                    class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endif
                            @endforeach
                        </div>

                    </div>
                    <div class="d-flex justify-content-center pt-5">
                        <a class="fw-semibold btn btn-primary-rgb"
                            href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }}
                            <i
                                class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i>
                        </a>
                    </div>
                </section>
            @endif
        @endif
    @endif
    <!----------------------------------------------------- Blog section end ----------------------------------------------------->
    @if (helper::footer_features(@$vendordata->id)->count() > 0)
        <section class="theme-4-new-product-service footer-fiechar-section bg-lights py-5">
            <div class="container">
                <div class="d-none d-lg-block">
                    <div class="row justify-content-center g-3">
                        @foreach (helper::footer_features(@$vendordata->id) as $feature)
                            <div class="col-lg-3 col-md-6">
                                <div class="card shadow h-100 rounded-4">
                                    <div class="card-body text-center">
                                        <div class="free-icon fs-2 text-primary-color">
                                            {!! $feature->icon !!}
                                        </div>
                                        <div class="free-content">
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
                            <div class="card h-100 rounded-4">
                                <div class="card-body text-center">
                                    <div class="free-icon fs-2 text-primary-color">
                                        {!! $feature->icon !!}
                                    </div>
                                    <div class="free-content">
                                        <h3 class="pst fw-600 color-changer">{{ $feature->title }}</h3>
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
