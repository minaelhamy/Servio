@extends('front.layout.master')
@section('content')
    <div class="bg-primary-rgb theme-9-color-back">
        <!----------------------------- top-banner ----------------------------->
        <section class="theme-9-home-banner position-relative py-lg-3 py-xl-4 py-xxl-5"
            style="background-image:url({{ helper::image_path(helper::appdata($vendordata->id)->home_banner) }}); background-position: center left; background-size: cover; height:100vh;">
            <div class="container-fluid zindex-2">
                <div class="banner-content-9">
                    <div class="card h-100 border-0 bg-dark-light rounded-0">
                        <div class="card-body p-xl-5 p-4">
                            <div class="mx-auto">
                                <h1 class="display-5 fw-semibold text-white mb-3">
                                    {{ helper::appdata($vendordata->id)->homepage_subtitle }}
                                </h1>
                                <p class="text-muted mb-3">{{ helper::appdata($vendordata->id)->homepage_title }}</p>
                                <div class="d-lg-flex gap-4 align-items-center">
                                    <div class="col-lg-8">
                                        <form action="{{ URL::to($vendordata->slug . '/services') }}" method="get"
                                            class="bg-body p-2 shadow-sm rounded-0 w-100">
                                            <div class="input-group gap-2">
                                                <input class="form-control border-0 px-3 rounded-0 p-0 theme-4-search-input"
                                                    type="text"
                                                    value="{{ isset($_GET['search_input']) ? $_GET['search_input'] : '' }}"
                                                    placeholder="{{ trans('labels.search_by_service_name') }}">
                                                <button type="submit"
                                                    class="btn btn-primary rounded-0 mb-0 btn-submit px-md-4 px-3"><i
                                                        class="fa-solid fa-magnifying-glass {{ session()->get('direction') == '2' ? 'ps-2' : 'pe-2' }}"></i>{{ trans('labels.search') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- avatar -->
                                    <div>
                                        <ul class="avatar-group mb-2 mt-lg-0 mt-3 ">
                                            @foreach ($reviewimage as $image)
                                                <li class="avatar-sm">
                                                    <img class="avatar-img rounded-circle"
                                                        src="{{ helper::image_path($image->image) }}" alt="avatar">
                                                </li>
                                            @endforeach
                                        </ul>
                                        <p class="text-muted mt-2 mb-0 text-truncate1">
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
        <!----------------------------- category section ----------------------------->
        @if ($getcategories->count() > 0)
            <section class="category-9 bg-primary-rgb">
                <div class="container">
                    <div class="text-center pb-5">
                        <h3 class="fs-1 fw-600 text-truncate1 fs-3 color-changer">{{ trans('labels.see_all_category') }}
                        </h3>
                        <p class="text-font text-muted m-0 text-truncate1">{{ trans('labels.home_category_subtitle') }}</p>
                    </div>
                    {{-- new design --}}

                    <div class="row g-4">
                        @foreach ($getcategories as $category)
                            <div class="col-xl-3 col-md-4 col-sm-6">
                                <a
                                    href="{{ URL::to($vendordata->slug . '/services?category=' . $category->slug . '&search_input=') }}">
                                    <div class="card rounded-0 align-items-center bg-white shadow p-4 h-100">
                                        <div>
                                            <img src="{{ helper::image_path($category->image) }}"
                                                class="card-img-top object-fit-cover rounded-3 border category-9-img rounded-circle"
                                                alt="">
                                        </div>
                                        <div class="card-body pb-0 text-center">
                                            <P class="fs-7 text-primary-color m-0 text-truncate1">
                                                {{ trans('labels.services') }}
                                                {{ helper::service_count($category->id) . '+' }}
                                            </P>
                                            <p class="m-0 text-dark fw-600 text-truncate-2 color-changer">
                                                {{ $category->name }}
                                            </p>
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
        @if (helper::footer_features(@$vendordata->id)->count() > 0)
            <section class="theme-9-new-product-service pb-90 pt-90">
                <div class="container">
                    <div class="d-lg-block d-none">
                        <div class="row justify-content-center g-3">
                            @foreach (helper::footer_features(@$vendordata->id) as $feature)
                                <div class="col-lg-3 col-md-6">
                                    <div class="card bg-white border-1 border-dark h-100 rounded-0">
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
                                <div class="card h-100 bg-white border-1 border-dark h-100 rounded-0">
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

        <!----------------------------- banner section-1 ----------------------------->
        @if ($getbannersection1->count() > 0)
            <section class="pt-90 pb-90 bg-primary-rgb">
                <div class="container">
                    <div class="row g-md-4 g-3">
                        <div class="col-md-5 col-12">
                            <div class="row g-md-4 g-3">
                                <div class="col-md-12 col-6">
                                    <img src="{{ helper::image_path($getbannersection1[0]->image) }}"
                                        class="banner-small-img w-100 rounded-0" alt="">
                                </div>
                                @if (isset($getbannersection1[1]))
                                    <div class="col-md-12 col-6">
                                        <img src="{{ helper::image_path($getbannersection1[1]->image) }}"
                                            class="banner-small-img w-100 rounded-0" alt="">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-7 col-12">
                            <div class="card-carousel-9 owl-carousel owl-loaded h-100">
                                <div class="owl-stage-outer h-100">
                                    <div class="owl-stage carousel h-100">
                                        @foreach ($getbannersection1 as $key => $banner)
                                            @if ($key != 0 && $key != 1)
                                                <div class="owl-item h-100">
                                                    <div class="card-top h-100">
                                                        <div class="card-overlay rounded-0 h-100">
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
                                                                class="banner-image-9 object-fit-cover" alt="">
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
            </section>
        @endif
        <!----------------------------- banner secction-1 ----------------------------->

        <!--------------------------- service section --------------------------->
        @if ($getservices->count() > 0)
            <section class="service-9 w-100">
                <div class="container">
                    <div class="text-center pb-5">
                        <h3 class="fs-1 fw-600 text-truncate1 fs-3 color-changer">{{ trans('labels.services') }}</h3>
                        <p class="text-font text-muted m-0 text-truncate1">{{ trans('labels.our_populer') }}
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
                            <div class="col-sm-6 col-lg-4">
                                <div class="card h-100 w-100 border-0 overflow-hidden rounded-0">
                                    <div class="position-relative overflow-hidden rounded-0img-over">
                                        <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}">
                                            <img src="{{ helper::image_path($service['service_image']->image) }}"
                                                class="card-img-top w-100 object-fit-cover rounded-0" alt="..."></a>
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
                                    </div>
                                    <div class="card-body px-4 pt-4 pb-0">
                                        <div class="card-text">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <div class="d-flex align-items-center gap-1">
                                                    <p class="fs-6 text-primary fw-600 text-truncate1">
                                                        {{ helper::currency_formate($price, $vendordata->id) }}
                                                    </p>
                                                    @if ($original_price > $price)
                                                        <del class="fs-7 text-muted fw-600 text-truncate1">
                                                            {{ helper::currency_formate($original_price, $vendordata->id) }}
                                                        </del>
                                                    @endif
                                                </div>
                                                @if (@helper::checkaddons('product_reviews'))
                                                    @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                        <span
                                                            class="badge text-bg-dark fs-8 h-100 d-flex align-items-center rounded-0"><i
                                                                class="fas fa-star fa-fw text-warning {{ session()->get('direction') == '2' ? 'ms-1' : 'me-1' }}"></i>
                                                            {{ number_format($service->ratings_average, 1) }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                class="color-changer fw-semibold text_truncation2 service-cardtitle">
                                                {{ $service->name }}
                                            </a>
                                            <p class="text-muted fs-7">Lorem ipsum dolor sit amet consectetur adipisicing
                                                elit.
                                                Similique tempore nisi reprehenderit.</p>
                                        </div>
                                    </div>
                                    <div class="card-footer border-0 bg-transparent pt-3 px-4 pb-4">
                                        <div class="d-flex justify-content-between align-items-center">

                                            @if (helper::appdata($vendordata->id)->online_order == 1)
                                                <a href="{{ URL::to($vendordata->slug . '/booking-' . $service->id) }}"
                                                    class="booknow text-primary fw-semibold">
                                                    {{ trans('labels.book_now') }}
                                                    <i
                                                        class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                            @else
                                                <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                    class="booknow text-primary fw-semibold">
                                                    {{ trans('labels.view') }}
                                                    <i
                                                        class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                            @endif
                                            <p class="text-muted mb-0 fs-7 fw-500">{{ $category[0]->name }}</p>

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
        <!------------------------------------------------- Why choose section start ------------------------------------------------->
        @if ($choose->count() > 0)
            <section class="why-choose-9 bg-primary-rgb position-relative">
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
                                class="rounded-0 w-100 object-fit-cover" alt="">
                        </div>
                        <!-- Left side END -->

                        <!-- Right side START -->
                        <div class="col-lg-6">

                            <!-- Features START -->
                            <div class="row justify-content-center g-4">
                                <!-- Item -->
                                @foreach ($choose as $choose)
                                    <div class="col-md-12">
                                        <div class="card border-0 rounded-0 shadow h-100">
                                            <div class="card-body p-4">
                                                <div class="d-flex gap-3 align-items-center mb-2">
                                                    <img src="{{ helper::image_path($choose->image) }}"
                                                        class="icon-lg bg-success bg-opacity-10 text-success rounded-circle"
                                                        alt="">
                                                    <h5 class="fw-600 mb-0 text-truncate1 color-changer">
                                                        {{ $choose->title }}</h5>
                                                </div>
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
                <div class="shape">
                    <img src="storage/app/public/front/images/dots.svg" class="home-course-steps-1">
                    <img src="storage/app/public/front/images/dots.svg" class="home-course-steps-2">
                </div>
            </section>
        @endif

        <!-------------------------------------------------- Why choose section end -------------------------------------------------->

        <!------------------------------------------------ top-category section start ------------------------------------------------>
        @if ($gettoprated->count() > 0)
            <section class="top-category-9">
                <div class="container">
                    <div class="text-center pb-5">
                        <h2 class="fs-1 fw-600 text-truncate1 fs-3 color-changer">
                            {{ trans('labels.top_ratted_services') }}</h2>
                        <p class="text-font text-muted m-0 text-truncate1">
                            {{ trans('labels.top_ratted_services_sub_title') }}
                        </p>
                    </div>
                    <!-- Listing -->
                    <div class="row g-sm-4 g-3 top-cate">
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
                            <div class="col-lg-3 col-sm-4 col-6">
                                <div class="card border-0 rounded-0 h-100">
                                    <div class="card-img overflow-hidden rounded-0 position-relative">
                                        <img src="{{ $toprated['service_image'] == null ? helper::image_path('service.png') : helper::image_path($toprated['service_image']->image) }}"
                                            class="w-100 object-fit-cover rounded-0" alt="">
                                        <div class="card-img-overlay p-sm-3 p-1 z-index-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                @if ($off > 0)
                                                    <div
                                                        class="{{ session()->get('direction') == '2' ? 'service-right-label' : 'service-left-label' }} text-bg-primary">
                                                        <p>{{ $off }}% {{ trans('labels.off') }}</p>
                                                    </div>
                                                @endif
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
                                    <div class="card-body px-2 pb-0">
                                        @if (@helper::checkaddons('product_reviews'))
                                            @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                <p class="fw-semibold m-0 mb-1"><i
                                                        class="fas fa-star fa-fw text-warning fs-8"></i>
                                                    <span
                                                        class="fs-8 color-changer">{{ $toprated->ratings_average == null ? number_format(0, 1) : number_format($toprated->ratings_average, 1) }}</span>
                                                </p>
                                            @endif
                                        @endif
                                        <div class="d-flex justify-content-between">
                                            <a class="fs-13 mb-0 text_truncation2 fw-600 color-changer"
                                                href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}">{{ $toprated->name }}</a>
                                        </div>
                                    </div>
                                    <div class="card-footer border-0 bg-transparent px-2">
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
                                                    class="btn btn-primary-rgb btn-round flex-shrink-0 rounded-0"><i
                                                        class="{{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left' : 'fa-solid fa-arrow-right' }}"></i></a>
                                            @else
                                                <a href="{{ URL::to($vendordata->slug . '/service-' . $toprated->slug) }}"
                                                    class="btn btn-primary-rgb btn-round flex-shrink-0 rounded-0"><i
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


        <!------------------------------------------------- app-downlode section end ------------------------------------------------->
        @if (@helper::checkaddons('user_app'))
            @if (!empty($app_section))
                @if ($app_section->mobile_app_on_off == 1)
                    <section class="pt-90 pb-90">
                        <div class="container">
                            <div class="border-0 bg-primary-rgb overflow-hidden">
                                <div class="card-body p-sm-5 p-4">
                                    <div class="row align-items-center justify-content-between">
                                        <div class="col-xl-6 col-lg-6 col-md-9 z-1">
                                            <!-- Title -->
                                            <h3 class="mb-4 fs-1 fw-600 app-title color-changer">
                                                {{ @$app_section->title }}</h3>
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

        @if (@helper::checkaddons('store_reviews'))
            <!------------------------------------------------ testimonial section start ------------------------------------------------->
            @if ($testimonials->count() > 0)
                <section class="testimonial-9 bg-secondary position-relative">
                    <div class="container">
                        <div class="text-center position-relative">
                            <!-- Title -->
                            <div class="text-center pb-5">
                                <h5 class="fs-1 fw-600 text-truncate1 text-white fs-3">
                                    {{ trans('labels.testimonial_title') }}</h5>
                                <p class="text-font text-muted m-0 text-truncate1">
                                    {{ trans('labels.testimonial_subtitle') }}
                                </p>
                            </div>
                            <!-- Slider START -->
                            <div class="testimonial-9-slider">
                                <div id="testimonial9" class="owl-carousel owl-theme">
                                    <!-- item -->
                                    @foreach ($testimonials as $testimonial)
                                        <div class="item">
                                            <div class="card border-0 rounded-0">
                                                <div class="card-body p-0">
                                                    <div class="d-md-flex align-items-center justify-content-between">
                                                        <div class="col-md-4 col-10 mx-md-0 mx-auto">
                                                            <div class="avatar-9">
                                                                <img class="avatar-img rounded-circle h-100 w-100"
                                                                    src="{{ helper::image_path($testimonial->image) }}"
                                                                    alt="avatar">
                                                            </div>
                                                        </div>
                                                        <div class="text-start col-md-7">
                                                            <!-- Content -->
                                                            <p
                                                                class="fw-500 fs-7 text-muted mt-md-0 mt-3 mb-3 text-md-start text-center">
                                                                “{{ $testimonial->description }}”</p>
                                                            <div
                                                                class="border-top d-md-flex justify-content-between align-items-center border-muted pt-3 text-md-start text-center">
                                                                <div>
                                                                    <p
                                                                        class="mb-1 text-primary fw-semibold text-truncate1 service-cardtitle">
                                                                        {{ $testimonial->name }}</p>
                                                                    <span
                                                                        class="text-muted fs-7 text-truncate1">{{ $testimonial->position }}</span>
                                                                </div>
                                                                <ul class="list-inline small mt-md-0 mt-2">
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
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- Slider END -->
                        </div>
                    </div>
                    <div class="shape-2">
                        <img src="storage/app/public/front/images/dots.svg" class="home-course-steps-1">
                        <img src="storage/app/public/front/images/dots.svg" class="home-course-steps-2">
                    </div>
                </section>
            @endif
            <!------------------------------------------------- testimonial section end -------------------------------------------------->
        @endif

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
                        <section class="blog-secction extra-margin pt-90 pb-90">
                            <div class="container">
                                <div class="text-center pb-5">
                                    <h3 class="fs-1 fw-600 text-truncate1 pb-1 fs-3 color-changer">
                                        {{ trans('labels.blog-post') }}</h3>
                                    <p class="text-font text-muted m-0 text-truncate1">{{ trans('labels.latest-post') }}
                                    </p>
                                </div>
                                <div class="row g-4 g-xl-5 justify-content-between">
                                    @foreach ($getblog as $key => $blog)
                                        @if ($key == 0)
                                            <div class="col-lg-6">
                                                <div class="border-0 bg-transparent rounded-0 overflow-hidden w-100">
                                                    <div class="img-overlay rounded-0 mb-4">
                                                        <img src="{{ helper::image_path($blog->image) }}"
                                                            class="rounded-0 w-100 object-fit-cover" alt="...">
                                                    </div>
                                                    <div class="card-body p-0 service-cardtitle">
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
                                                    <div class="card-footer border-top-0 bg-transparent px-0 py-3">
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
                                            </div>
                                            <div class="col-lg-6">
                                            @else
                                                <div class="border-bottom mb-4">
                                                    <div class="row g-3 align-items-center border-0 bg-transparent mb-4">
                                                        <div class="col-sm-4">
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
                                                                    class="text-dark color-changer">{{ $blog->title }}</a>
                                                            </h5>
                                                            <small
                                                                class="card-text text-muted m-0 fs-7 text_truncation2">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="d-flex justify-content-center pt-sm-5 pt-3">
                                <a class="fw-semibold btn btn-border rounded-0"
                                    href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }}
                                    <i
                                        class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                            </div>
                        </section>
                    @endif
                @endif
            @else
                @if (@helper::checkaddons('blog'))
                    <section class="blog-secction extra-margin pt-90 pb-90">
                        <div class="container">
                            <div class="text-center pb-5">
                                <h3 class="fs-1 fw-600 text-truncate1 pb-1 fs-3 color-changer">
                                    {{ trans('labels.blog-post') }}</h3>
                                <p class="text-font text-muted m-0 text-truncate1">{{ trans('labels.latest-post') }}
                                </p>
                            </div>
                            <div class="row g-4 g-xl-5 justify-content-between">
                                @foreach ($getblog as $key => $blog)
                                    @if ($key == 0)
                                        <div class="col-lg-6">
                                            <div class="border-0 bg-transparent rounded-0 overflow-hidden w-100">
                                                <div class="img-overlay rounded-0 mb-4">
                                                    <img src="{{ helper::image_path($blog->image) }}"
                                                        class="rounded-0 w-100 object-fit-cover" alt="...">
                                                </div>
                                                <div class="card-body p-0 service-cardtitle">
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
                                                <div class="card-footer border-top-0 bg-transparent px-0 py-3">
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
                                        </div>
                                        <div class="col-lg-6">
                                        @else
                                            <div class="border-bottom mb-4">
                                                <div class="row g-3 align-items-center border-0 bg-transparent mb-4">
                                                    <div class="col-sm-4">
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
                                                                class="text-dark color-changer">{{ $blog->title }}</a>
                                                        </h5>
                                                        <small
                                                            class="card-text text-muted m-0 fs-7 text_truncation2">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                                                    </div>
                                                </div>
                                            </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="d-flex justify-content-center pt-sm-5 pt-3">
                            <a class="fw-semibold btn btn-border rounded-0"
                                href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.viewall') }}
                                <i
                                    class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                        </div>
                    </section>
                @endif
            @endif
        @endif
    </div>
@endsection
@section('scripts')
    <script>
        var direction = "{{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}";
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/index.js') }}"></script>
@endsection
