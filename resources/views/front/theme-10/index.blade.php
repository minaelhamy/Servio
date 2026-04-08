@extends('front.layout.master')

@section('content')
    <!-- top-banner -->
    <section class="home-banner theme-10">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-end">
                <div
                    class="d-flex gap-3 bg-primary theme-10-color-back py-4 flex-wrap align-items-center justify-content-center {{ session()->get('direction') == 2 ? 'banner-content-rtl' : 'banner-content' }}">
                    <div class="col-md-5 col-10 my-md-5 my-0">
                        <div class="section-search">
                            <p class="fs-6 fw-medium text-white mb-1">
                                {{ helper::appdata($vendordata->id)->homepage_title }}
                            </p>
                            <h1 class="fw-600 text-white m-0">
                                {{ helper::appdata($vendordata->id)->homepage_subtitle }}
                            </h1>
                        </div>
                    </div>
                    <div class="col-md-5 col-10 mb-5 mt-sm-5">
                        <form action="{{ URL::to($vendordata->slug . '/services') }}" method="get"
                            class="bg-body rounded-2 p-2 border shadow-sm rounded-4">
                            <div class="input-group gap-2">
                                <input class="form-control border-0 rounded-2" type="text"
                                    placeholder="{{ trans('labels.search_by_service_name') }}"
                                    value="{{ isset($_GET['search_input']) ? $_GET['search_input'] : '' }}">
                                <button type="submit" class="btn btn-secondary rounded-2 mb-0 btn-submit px-md-4 px-3">
                                    <i
                                        class="fa-solid fa-magnifying-glass {{ session()->get('direction') == 2 ? 'ps-2 ' : 'pe-2' }}"></i>{{ trans('labels.search') }}</button>
                            </div>
                        </form>
                        <!-- avatar -->
                        <div class="mt-5 d-flex gap-4 align-items-center">
                            <ul
                                class="avatar-group {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }} justify-content-sm-start justify-content-center mb-0 mx-auto mx-lg-0">
                                @foreach ($reviewimage as $image)
                                    <li class="avatar-sm">
                                        <img class="avatar-img rounded-circle" src="{{ helper::image_path($image->image) }}"
                                            alt="avatar">
                                    </li>
                                @endforeach
                            </ul>
                            <p
                                class="text-white m-0 text-truncate {{ session()->get('direction') == 2 ? 'text-sm-end text-center' : 'text-sm-start text-center' }}">
                                {{ trans('labels.review_section_title') }}
                            </p>
                        </div>
                        <!-- avatar -->
                    </div>
                </div>
                <div class="col-12 px-0 d-none d-lg-block">
                    <img src="{{ helper::image_path(helper::appdata($vendordata->id)->home_banner) }}" alt=""
                        class="w-100 object-fit-cover" style="height: 400px;">
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
    <!-- category section -->
    @if ($getcategories->count() > 0)
        <section class="category bg-primary-rgb2 pb-90 pt-90">
            <div class="container">
                <div class="d-flex align-items-center justify-content-center text-center mb-5">
                    <div>
                        <h3 class="fw-600 text-truncate text-primary-color fs-3 color-changer">
                            {{ trans('labels.see_all_category') }}
                        </h3>
                        <div class="d-flex justify-content-center align-items-center mb-2">
                            <div class="heading-line color-changer">
                            </div><img src="storage/app/public/front/images/barbershop.svg" alt="Icon Barbeshop">
                            <div class="heading-line color-changer"></div>
                        </div>
                        <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.home_category_subtitle') }}</p>
                    </div>
                </div>
                <div class="bg-white p-md-5 p-sm-4 p-3 rounded-4">
                    <div class="row g-sm-4 g-3">
                        @foreach ($getcategories as $category)
                            <div class="col-lg-4 col-sm-6">
                                <a
                                    href="{{ URL::to($vendordata->slug . '/services?category=' . $category->slug . '&search_input=') }}">
                                    <div
                                        class="d-flex gap-sm-4 gap-2 rounded-0 border-0 align-items-center bg-white p-sm-3 p-2 h-100">
                                        <div>
                                            <img src="{{ helper::image_path($category->image) }}"
                                                class="card-img-top object-fit-cover rounded-3 category-10-img"
                                                alt="">
                                        </div>
                                        <div class="">
                                            <p class="m-0 category-text text-dark fw-600 text-truncate-2">
                                                {{ $category->name }}
                                            </p>
                                            <P class="fs-7 text-secondary m-0 text-truncate1">
                                                {{ trans('labels.services') }}
                                                {{ helper::service_count($category->id) . '+' }}
                                            </P>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-5">
                    <div>
                        <a class="fs-6 fw-semibold btn btn-primary-rgb"
                            href="{{ URL::to($vendordata->slug . '/categories') }}">{{ trans('labels.viewall') }} <i
                                class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Category Section -->

    <!-- banner section-1  -->
    @if ($getbannersection1->count() > 0)
        <section class="pb-90 pt-90 theme-10-color-back">
            <div class="container">
                <div class="card-carousel10 owl-carousel owl-loaded">
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
        <section class="service-10 all-service-10 bg-white pb-90 pt-90 w-100">
            <div class="container">
                <div class="d-flex align-items-center justify-content-center text-center mb-5">
                    <div>
                        <h3 class="fw-600 text-truncate text-primary-color fs-3 color-changer">
                            {{ trans('labels.services') }}
                        </h3>
                        <div class="d-flex align-items-center mb-2">
                            <div class="heading-line color-changer"></div>
                            <img src="storage/app/public/front/images/barbershop.svg" alt="Icon Barbeshop">
                            <div class="heading-line color-changer"></div>
                        </div>
                        <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.our_populer') }}
                            {{ trans('labels.services') }}
                        </p>
                    </div>
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
                        <div class="col-lg-4 col-sm-6 ">
                            <div class="card h-100 w-100 border-0 overflow-hidden bg-transparent rounded-4">
                                <div class="position-relative overflow-hidden rounded-0img-over">
                                    <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}">
                                        <img src="{{ helper::image_path($service['service_image']->image) }}"
                                            class="card-img-top w-100 object-fit-cover rounded-4" alt="..."></a>
                                    <div class="card-img-overlay d-flex flex-column z-index-1 p-4">
                                        <div class="d-flex justify-content-between align-items-center">
                                            @if ($off > 0)
                                                <span
                                                    class="{{ session()->get('direction') == '2' ? 'service-right-label-2' : 'service-left-label-2' }}">
                                                    {{ $off }}% {{ trans('labels.off') }}
                                                </span>
                                            @endif
                                            @if (@helper::checkaddons('customer_login'))
                                                @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                    <div
                                                        class="badges bg-danger rounded-circle {{ session()->get('direction') == '2' ? 'float-start' : 'float-end' }}">
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
                                        @php
                                            $category = helper::getcategoryinfo(
                                                $service->category_id,
                                                $service->vendor_id,
                                            );
                                        @endphp

                                        <div class="btn-10 rounded-5">
                                            @if (helper::appdata($vendordata->id)->online_order == 1)
                                                <a href="{{ URL::to($vendordata->slug . '/booking-' . $service->id) }}"
                                                    class="booknow btn btn-primary fw-semibold rounded-0 fs-7">
                                                    {{ trans('labels.book_now') }}
                                                    <i
                                                        class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                            @else
                                                <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                    class="booknow btn btn-primary fw-semibold rounded-0 fs-7">
                                                    {{ trans('labels.view') }}
                                                    <i
                                                        class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body px-0 py-4">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <p class="text-muted fs-8 fw-500">{{ $category[0]->name }}</p>
                                        @if (@helper::checkaddons('product_reviews'))
                                            @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                <p class="fs-8 h-100 d-flex align-items-center"><i
                                                        class="fas fa-star fa-fw text-warning {{ session()->get('direction') == '2' ? 'ms-1' : 'me-1' }}"></i>
                                                    <span class="color-changer">
                                                        {{ number_format($service->ratings_average, 1) }}
                                                    </span>
                                                </p>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="d-flex flex-wrap gap-1 justify-content-between">
                                        <div class="col-auto">
                                            <h5 class="fw-semibold text_truncation2 service-cardtitle mb-0">
                                                <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                    class="color-changer">
                                                    {{ $service->name }}
                                                </a>
                                            </h5>
                                        </div>
                                        <div class="d-flex align-items-center gap-1">
                                            <p class="fs-6 text-primary fw-600 mb-0 text-truncate1">
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
            </div>
        </section>
    @endif

    <!----------------------------------------------------- banner-section-2 ----------------------------------------------------->
    @if ($getbannersection2->count() > 0)
        <section class="banner-section-2 p-0 new-banner">
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
        <section class="why-choose bg-primary-rgb2 pt-90 pb-90">
            <div class="container">
                <div class="row g-4 justify-content-between align-items-center">

                    <!-- left side START -->
                    <div class="col-lg-6 choose-content">
                        <h2 class="fs-1 fw-600 text_truncation2 pb-1 mb-2 text-primary-color color-changer">
                            {{ helper::appdata($vendordata->id)->why_choose_title }}
                        </h2>
                        <div class="d-flex gap-3 align-items-center mb-2">
                            <div class="heading-line color-changer m-0"></div>
                            <img src="storage/app/public/front/images/barbershop.svg" alt="Icon Barbeshop">
                            <div class="heading-line color-changer m-0"></div>
                        </div>
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

                                    <h5 class="mt-2 fw-600 text-truncate color-changer">{{ $choose->title }}</h5>
                                    <p class="mb-0 text-muted text_truncation2">{{ $choose->description }}</p>
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

    <!------------------------------------------------ testimonial section start ------------------------------------------------>
    @if (@helper::checkaddons('store_reviews'))
        @if ($testimonials->count() > 0)
            <section class="testimonial-10 pt-90 pb-90 background bg-img bg-fixed layer position-relative"
                style="background-image: url(&quot;https://shtheme.com/demosd/perukar/wp-content/uploads/2023/02/6.jpg&quot;);">
                <div class="container">
                    <div class="testimonial-content py-4">
                        <!-- Title -->
                        <div class="text-center pb-5 position-relative z-1">
                            <h3 class="fw-600 text-truncate text-primary-color fs-3 color-changer">
                                {{ trans('labels.testimonial_title') }}
                            </h3>
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <div class="heading-line color-changer"></div>
                                <img src="storage/app/public/front/images/barbershop.svg" alt="Icon Barbeshop">
                                <div class="heading-line color-changer"></div>
                            </div>
                            <p class="text-font text-white m-0 text-truncate">{{ trans('labels.testimonial_subtitle') }}
                            </p>
                        </div>

                        <!-- Testimonials -->
                        <div class="row align-items-center justify-content-center">
                            <div class="col-lg-6 col-12">
                                <!-- Slider START -->
                                <div id="testimonial10" class="owl-carousel owl-theme">
                                    @foreach ($testimonials as $testimonial)
                                        <div class="item">
                                            <div class="bg-transparent rounded-4 border-0">
                                                <div class="p-3">
                                                    <ul class="list-inline small text-center mb-2">
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
                                                    <!-- Content -->
                                                    <p class="fw-normal text-white fs-7 text-center text_truncation3">
                                                        "{{ $testimonial->description }}"</p>
                                                    <div class="d-flex align-items-center justify-content-center mt-4">
                                                        <div class="text-center">
                                                            <div class="avatar avatar-xl">
                                                                <img class="avatar-img rounded-circle"
                                                                    src="{{ helper::image_path($testimonial->image) }}"
                                                                    alt="avatar">
                                                            </div>
                                                            <div class="mx-3 text-center">
                                                                <h6 class="mb-0 text-white fw-600 text-truncate mb-1">
                                                                    {{ $testimonial->name }}
                                                                </h6>
                                                                <span
                                                                    class="text-white text-truncate fs-7">{{ $testimonial->position }}</span>

                                                            </div>
                                                        </div>
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
            </section>
        @endif
        <!------------------------------------------------- testimonial section end ------------------------------------------------->
    @endif
    <!------------------------------------------------ top-category section start ------------------------------------------------>
    @if ($gettoprated->count() > 0)
        <section class="top-category-10 all-service-10 bg-primary-rgb pt-90 pb-90">
            <div class="container">
                <!-- Title -->
                <div class="d-flex align-items-center justify-content-center text-center mb-5">
                    <div>
                        <h2 class="fw-600 text-truncate text-primary-color fs-3 color-changer">
                            {{ trans('labels.top_ratted_services') }}
                        </h2>
                        <div class="d-flex justify-content-center align-items-center mb-2">
                            <div class="heading-line color-changer"></div>
                            <img src="storage/app/public/front/images/barbershop.svg" alt="Icon Barbeshop">
                            <div class="heading-line color-changer"></div>
                        </div>
                        <p class="text-font text-muted m-0 text-truncate">
                            {{ trans('labels.top_ratted_services_sub_title') }}
                        </p>
                    </div>
                </div>
                <!-- Listing -->
                <div class="row g-3">
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
                            <div class="card bg-transparent border-0 rounded-4 card-body h-100 p-3">
                                <!-- Image and text -->
                                <div class="w-100 category-content">
                                    <div class="rounded-2 overflow-hidden top-category-10-img">
                                        <img src="{{ $toprated['service_image'] == null ? helper::image_path('service.png') : helper::image_path($toprated['service_image']->image) }}"
                                            class="rounded-2" alt="">
                                        <div class="card-img-overlay">
                                            <div class="d-flex justify-content-between align-items-center">
                                                @if ($off > 0)
                                                    <span
                                                        class="{{ session()->get('direction') == '2' ? 'service-right-label-2' : 'service-left-label-2' }}">
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

                                    <div class="category-text">
                                        <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                            class="fs-6 fw-600 mb-0 text_truncation2 mb-2 text-white">{{ $toprated->name }}</a>
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <p class="fs-16 m-0 fw-600 text-white text-truncate">
                                                {{ helper::currency_formate($tprice, $vendordata->id) }}
                                            </p>
                                            @if ($toriginal_price > $tprice)
                                                <del class="fs-7 m-0 fw-600 text-muted text-truncate">
                                                    {{ helper::currency_formate($toriginal_price, $vendordata->id) }}
                                                </del>
                                            @endif
                                        </div>
                                        @if (@helper::checkaddons('product_reviews'))
                                            @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                <p class="fw-semibold m-0 fw-semibold fs-7 text-white mt-2">
                                                    <i class="fas fa-star fa-fw text-warning"></i>
                                                    {{ $toprated->ratings_average == null ? number_format(0, 1) : number_format($toprated->ratings_average, 1) }}
                                                </p>
                                            @endif
                                        @endif

                                        @if (helper::appdata($vendordata->id)->online_order == 1)
                                            <a href="{{ URL::to($vendordata->slug . '/booking-' . $toprated->id) }}"
                                                class="btn btn-primary btn-round mb-0 fw-600 mt-3">Book Now<i
                                                    class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left pe-1' : 'fa-solid fa-arrow-right ps-1' }}"></i></a>
                                        @else
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                class="btn btn-primary btn-round mb-0 fw-600 mt-3">Book Now <i
                                                    class="fa-regular fa-eye {{ session()->get('direction') == 2 ? 'pe-1' : 'ps-1' }}"></i></a>
                                        @endif
                                    </div>

                                    <div class="text-box p-3 rounded-3">
                                        <div class="d-lg-block d-none">
                                            <div class="row g-0">
                                                <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                    class="fs-6 fw-600 mb-0 text_truncation2 mb-2">{{ $toprated->name }}</a>
                                                <div class="d-flex justify-content-center align-items-center gap-1">
                                                    <p class="fs-6 m-0 fw-600 text-truncate">
                                                        {{ helper::currency_formate($tprice, $vendordata->id) }}
                                                    </p>
                                                    @if ($toriginal_price > $tprice)
                                                        <del class="fs-7 m-0 fw-600 text-muted text-truncate">
                                                            {{ helper::currency_formate($toriginal_price, $vendordata->id) }}
                                                        </del>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-lg-none">
                                            <div class="row g-0 align-items-center">
                                                <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                    class="fs-6 fw-600 mb-0 text_truncation2 {{ session()->get('direction') == 2 ? 'text-end' : 'text-start' }} text-start mb-2">{{ $toprated->name }}</a>
                                                <div class="d-flex align-items-center gap-1">
                                                    <p class="fs-6 m-0 fw-600 text-truncate">
                                                        {{ helper::currency_formate($tprice, $vendordata->id) }}
                                                    </p>
                                                    @if ($toriginal_price > $tprice)
                                                        <del class="fs-7 m-0 fw-600 text-muted text-truncate">
                                                            {{ helper::currency_formate($toriginal_price, $vendordata->id) }}
                                                        </del>
                                                    @endif
                                                </div>
                                                <div class="d-flex gap-2 mt-2 align-items-center justify-content-between">
                                                    @if (@helper::checkaddons('product_reviews'))
                                                        @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                            <p class="fw-semibold m-0 fw-semibold fs-7">
                                                                <i class="fas fa-star fa-fw text-warning"></i>
                                                                {{ $toprated->ratings_average == null ? number_format(0, 1) : number_format($toprated->ratings_average, 1) }}
                                                            </p>
                                                        @endif
                                                    @endif
                                                    @if (helper::appdata($vendordata->id)->online_order == 1)
                                                        <a href="{{ URL::to($vendordata->slug . '/booking-' . $toprated->id) }}"
                                                            class="btn btn-primary btn-round mb-0 fw-600">Book Now<i
                                                                class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left pe-1' : 'fa-solid fa-arrow-right ps-1' }}"></i></a>
                                                    @else
                                                        <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                            class="btn btn-primary btn-round mb-0 fw-600">Book Now <i
                                                                class="fa-regular fa-eye {{ session()->get('direction') == 2 ? 'pe-1' : 'ps-1' }}"></i></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
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

    <!---------------------------------------------- app-downlode section end ---------------------------------------------------->
    @if (@helper::checkaddons('user_app'))
        @if (!empty($app_section))
            @if ($app_section->mobile_app_on_off == 1)
                <section class="py-5 my-5">
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
                    <section class="blog-section-10 theme-10-color-back all-service-10 pb-90 pt-90">
                        <div class="container">
                            <div class="d-flex align-items-center justify-content-center text-center mb-5">
                                <div>
                                    <h5 class="fw-600 text-truncate text-primary-color fs-3 color-changer">
                                        {{ trans('labels.blog-post') }}
                                    </h5>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="heading-line color-changer"></div>
                                        <img src="storage/app/public/front/images/barbershop.svg" alt="Icon Barbeshop">
                                        <div class="heading-line color-changer"></div>
                                    </div>
                                    <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.latest-post') }}
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($getblog as $blog)
                                    <div class="col-lg-4 col-md-6 d-flex mt-3 justify-content-sm-center">
                                        <div class="card h-100 bg-transparent border-0 rounded-3">
                                            <div class="position-relative overflow-hidden rounded-3">
                                                <div class="img-h4 overflow-hidden rounded-3">
                                                    <img src="{{ helper::image_path($blog->image) }}"
                                                        class="card-img-top w-100 img-h4 rounded-3 object-fit-cover"
                                                        alt="...">
                                                </div>
                                                <div class="date">
                                                    <p class="mb-0 fw-normal text-truncate fs-8"><i
                                                            class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>
                                                        {{ helper::date_formate($blog->created_at, $vendordata->id) }}
                                                    </p>
                                                </div>
                                                <div class="text-box shadow">
                                                    <div class="card-text">
                                                        <h5 class="m-0 fw-semibold text_truncation2 service-cardtitle">
                                                            <a
                                                                href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ $blog->title }}</a>
                                                        </h5>
                                                        <small
                                                            class="card-text mt-2 mb-2 text_truncation2 fs-7">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center">

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
                <section class="blog-section-10 pb-5">
                    <div class="container">
                        <div class="d-flex align-items-center justify-content-center text-center mb-5">
                            <div>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="heading-line"></div>
                                    <img src="storage/app/public/front/images/barbershop.svg" alt="Icon Barbeshop">
                                    <div class="heading-line"></div>
                                </div>
                                <h5 class="fw-600 text-truncate text-primary-color fs-3">
                                    {{ trans('labels.blog-post') }}
                                </h5>
                                <p class="text-font text-muted m-0 text-truncate">{{ trans('labels.latest-post') }}
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($getblog as $blog)
                                <div class="col-lg-4 col-md-6 d-flex mt-3 justify-content-sm-center">
                                    <div class="card h-100 bg-transparent border-0 rounded-3">
                                        <div class="position-relative overflow-hidden rounded-3">
                                            <img src="{{ helper::image_path($blog->image) }}"
                                                class="card-img-top w-100 img-h4 rounded-3 object-fit-cover"
                                                alt="...">
                                            <div class="date">
                                                <p class="mb-0 fw-normal text-truncate fs-8"><i
                                                        class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>
                                                    {{ helper::date_formate($blog->created_at, $vendordata->id) }}
                                                </p>
                                            </div>
                                            <div class="text-box">
                                                <div class="card-text">
                                                    <h5 class="m-0 fw-semibold text_truncation2 service-cardtitle">
                                                        <a
                                                            href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ $blog->title }}</a>
                                                    </h5>
                                                    <small
                                                        class="card-text mt-2 mb-2 text_truncation2">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">

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
                        <div class="d-flex justify-content-center mt-5">
                            <div class="">
                                <a class="fw-semibold btn btn-primary-rgb"
                                    href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }} <i
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
