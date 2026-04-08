@extends('front.layout.master')
@section('content')
    <div class="container">
        <div class="breadcrumb-div pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL::to($vendordata->slug) }}" class="text-primary-color"><i
                                class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">{{ trans('labels.service_details') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <section class="service-view-sec">
        <div class="container">
            <h2 class="section-title fw-bold fs-3">{{ trans('labels.service_details') }}</h2>
        </div>
        <div class="container-fluid px-0 my-4">
            <div id="services-view" class="owl-carousel owl-theme">
                @if ($service['multi_image']->count() == 0)
                    <div class="item">
                        <a id="gallery" class="w-100 h-100 glightbox" data-glightbox="type: image"
                            href="{{ helper::image_path('service.png') }}">
                            <div class="card card-element-hover card-overlay-hover rounded-0 overflow-hidden">
                                <!-- Image -->
                                <img src="{{ helper::image_path('service.png') }}" class="w-100 h-100" alt="">
                                <!-- Full screen button -->
                                <div class="hover-element w-100 h-100">
                                    <i
                                        class="fa-solid fa-expand fs-6 text-white position-absolute top-50 start-50 translate-middle bg-dark rounded-1 p-2 lh-1"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @foreach ($service['multi_image'] as $serviceimage)
                    <div class="item">
                        <a id="gallery" class="w-100 h-100 glightbox" data-glightbox="type: image"
                            href="{{ helper::image_path($serviceimage->image_name) }}">
                            <div class="card card-element-hover card-overlay-hover rounded-0 overflow-hidden">
                                <!-- Image -->
                                <img src="{{ $serviceimage->image == null ? helper::image_path('service.png') : helper::image_path($serviceimage->image_name) }}"
                                    class="w-100 h-100" alt="">
                                <!-- Full screen button -->
                                <div class="hover-element w-100 h-100">
                                    <i
                                        class="fa-solid fa-expand fs-6 text-white position-absolute top-50 start-50 translate-middle bg-dark rounded-1 p-2 lh-1"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @if ($service->top_deals == 1 && @helper::top_deals($vendordata->id) != null)
            <div class="container">
                <div id="eapps-countdown-timer-1"
                    class="rounded eapps-countdown-timer eapps-countdown-timer-align-center eapps-countdown-timer-position-bottom-bar-floating eapps-countdown-timer-animation-none eapps-countdown-timer-theme-default eapps-countdown-timer-finish-button-show   eapps-countdown-timer-style-combined eapps-countdown-timer-style-blocks eapps-countdown-timer-position-bar eapps-countdown-timer-area-clickable eapps-countdown-timer-has-background p-3">
                    <div class="eapps-countdown-timer-container d-flex">
                        <div class="eapps-countdown-timer-inner row g-sm-0 g-3 flex-column flex-sm-row">
                            <div class="eapps-countdown-timer-item-container col-md-12">
                                <div class="eapps-countdown-timer-item d-flex gap-2 justify-content-center countdowntime">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="container">
            <div class="col-12 mt-4">
                <div class="card border-0 bg-lights rounded">
                    <!-- Card body -->
                    <div class="card-body py-md-4">
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

                            $category = helper::getcategoryinfo($service->category_id, $service->vendor_id);
                        @endphp
                        <!-- Title and badge -->
                        <div class="d-flex align-items-center justify-content-between">
                            <!-- Badge -->
                            <div class="badge text-bg-dark">{{ $category[0]->name }}</div>
                            <div class="d-flex justify-content-between align-items-center gap-2">
                                @if ($off > 0)
                                    <span class="service-left-label-2">
                                        {{ $off }}% {{ trans('labels.off') }}
                                    </span>
                                @endif
                                <ul class="list-inline mb-0 d-flex gap-2">
                                    <!-- wishlist -->
                                    @if (@helper::checkaddons('customer_login'))
                                        @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                            <li class="list-inline-item m-0">
                                                <button
                                                    onclick="managefavorite('{{ $service->id }}',{{ $vendordata->id }},'{{ URL::to(@$vendordata->slug . '/managefavorite') }}')"
                                                    class="btn btn-sm btn-white px-2">
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
                                            </li>
                                        @endif
                                    @endif
                                    <!-- Share -->
                                    <div class="position-relative">
                                        <li class="list-inline-item dropdown m-0">
                                            <!-- Share button -->
                                            <button onclick="myFunction()" class="btn btn-sm btn-white px-2" role="button"
                                                id="dropdownShare">
                                                <i class="fa-solid fa-fw fa-share-alt"></i>
                                            </button>
                                        </li>
                                        {!! $shareComponent !!}
                                    </div>
                                </ul>
                            </div>
                        </div>

                        <!-- Title -->
                        <h2 class="my-2 fw-bold fs-3 color-changer text-capitalize">{{ $service->name }}</h2>
                        @if (@helper::checkaddons('product_reviews'))
                            @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                <div class="d-flex">
                                    <!-- Rating -->
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item me-1 h6 mb-0 fw-bold color-changer">
                                            {{ number_format($averagerating, 1) }}
                                        </li>
                                        @php
                                            $count = (float) $averagerating;
                                            $fullStars = 0;
                                            if ($count > 4.5) {
                                                $fullStars = $count >= 4.75 ? 5 : floor($count);
                                            } elseif ($count > 3.5) {
                                                $fullStars = $count >= 3.75 ? 4 : floor($count);
                                            } elseif ($count > 2.5) {
                                                $fullStars = $count >= 2.75 ? 3 : floor($count);
                                            } elseif ($count > 1.5) {
                                                $fullStars = $count >= 1.75 ? 2 : floor($count);
                                            } elseif ($count > 0.5) {
                                                $fullStars = $count >= 0.75 ? 1 : floor($count);
                                            }
                                            $hasHalfStar = $count - $fullStars >= 0.5 && $fullStars < 5;
                                        @endphp
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < $fullStars)
                                                <li class="list-inline-item me-0 small">
                                                    <i class="fa-solid fa-star text-warning"></i>
                                                </li>
                                            @elseif ($i == $fullStars && $hasHalfStar)
                                                <li class="list-inline-item me-0 small">
                                                    <i class="fa-solid fa-star-half-stroke text-warning"></i>
                                                </li>
                                            @else
                                                <li class="list-inline-item me-0 small">
                                                    <i class="fa-regular fa-star text-warning"></i>
                                                </li>
                                            @endif
                                        @endfor
                                    </ul>
                                    <a class="mb-0 m-0 mx-2 text-muted">({{ $totalreview }}
                                        {{ trans('labels.reviews') }})</a>
                                </div>
                            @endif
                        @endif
                        @if (@helper::checkaddons('fake_view'))
                            @if (helper::appdata($vendordata->id)->product_fake_view == 1)
                                @php
                                    $var = ['{eye}', '{count}'];
                                    $newvar = [
                                        "<i class='fa-solid fa-eye'></i>",
                                        rand(
                                            helper::appdata($vendordata->id)->min_view_count,
                                            helper::appdata($vendordata->id)->max_view_count,
                                        ),
                                    ];

                                    $fake_view = str_replace(
                                        $var,
                                        $newvar,
                                        helper::appdata($vendordata->id)->service_fake_view_message,
                                    );
                                @endphp
                                <div class="d-flex gap-1 align-items-center blink_me my-2">
                                    <p class="fw-600 text-dark color-changer m-0">{!! $fake_view !!}</p>
                                </div>
                            @endif
                        @endif
                        <!-- Buttons -->
                    </div>
                </div>
            </div>

            <div class="row g-4 my-4">
                <div class="col-lg-12 col-xl-8 order-2 order-xl-0">
                    <div class="product-view">
                        <ul class="nav nav-pills py-4 border-bottom border-top gap-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" aria-current="page" data-bs-toggle="pill"
                                    data-bs-target="#pills-description" href="javascript:void(0)" aria-selected="true"
                                    role="tab" tabindex="-1">
                                    {{ trans('labels.description') }}
                                </a>
                            </li>
                            @if (@helper::checkaddons('additional_service'))
                                @if (count($additional_service) > 0)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" aria-current="page" data-bs-toggle="pill"
                                            data-bs-target="#pills-additional_services" href="javascript:void(0)"
                                            aria-selected="true" role="tab" tabindex="-1">
                                            {{ trans('labels.additional_services') }}
                                        </a>
                                    </li>
                                @endif
                            @endif
                            @if (@helper::checkaddons('customer_login'))
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" href="javascript:void(0)" data-bs-toggle="pill"
                                        data-bs-target="#pills-customer_review" aria-selected="false"
                                        role="tab">{{ trans('labels.customer_review') }}</a>
                                </li>
                            @endif
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="javascript:void(0)" data-bs-toggle="pill"
                                    data-bs-target="#pills-product_inquiry" aria-selected="false"
                                    role="tab">{{ trans('labels.product_inquiry') }}</a>
                            </li>
                            @if (@helper::checkaddons('question_answer'))
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" href="javascript:void(0)" data-bs-toggle="pill"
                                        data-bs-target="#pills-quastions" aria-selected="false"
                                        role="tab">{{ trans('labels.quastions_ans') }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="tab-content py-3 mb-4" id="pills-tabContent">
                        <div class="tab-pane fade active show" id="pills-description" role="tabpanel"
                            aria-labelledby="pills-description-tab">
                            <div class="row mt-2">
                                <div class="col-auto">
                                    <div class="item-description ser_des_color">
                                        <h4 class="color-changer mb-3">{{ trans('labels.description') }}</h4>
                                        <p class=" service-description text-justify">{!! $service->description !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (@helper::checkaddons('additional_service'))
                            <div class="tab-pane fade" id="pills-additional_services" role="tabpanel"
                                aria-labelledby="pills-additional_services-tab">

                                <div class="row g-3 row-cols-xl-3 row-cols-lg-3 row-cols-md-2 row-cols-1">
                                    @foreach ($additional_service as $key => $add_service)
                                        <div
                                            class="col fw-bolder d-flex align-items-center staff-checked position-relative">
                                            <input
                                                class="form-check-input position-absolute end-10 d-none select_additional_service"
                                                type="checkbox" value="{{ $add_service->id }}"
                                                data-servicename="{{ $add_service->name }}"
                                                id="additional_service_{{ $key }}"
                                                name="select_additional_service[]">
                                            <label for="additional_service_{{ $key }}"
                                                class="d-flex align-items-center p-2 rounded-3 form-control additional_services_card pointer">
                                                <div class="d-flex gap-3 w-100 align-items-center fw-500">
                                                    <img src="{{ helper::image_path($add_service->image) }}"
                                                        width="70" height="70" class="rounded-3" alt="">
                                                    <div>
                                                        <p class="mb-1 fw-600 line-2 color-changer">
                                                            {{ $add_service->name }}
                                                        </p>
                                                        <p
                                                            class="d-flex align-items-center color-changer flex-wrap fw-500 m-0 gap-2">
                                                            {{ helper::currency_formate($add_service->price, $vendordata->id) }}

                                                        </p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        @endif

                        <div class="tab-pane fade" id="pills-customer_review" role="tabpanel"
                            aria-labelledby="pills-pills-customer_review-tab">
                            @if (@helper::checkaddons('customer_login'))
                                @if (@helper::checkaddons('product_reviews'))
                                    <!-- Customer Review -->
                                    <div class="card border-0 bg-lights p-4 mb-4">
                                        <div class="row g-4 align-items-center">
                                            <!-- Rating info -->
                                            <div class="col-md-4">
                                                <div class="text-center">
                                                    <!-- Info -->
                                                    <h2 class="mb-0 fw-bold color-changer">
                                                        {{ number_format($averagerating, 1) }}
                                                    </h2>
                                                    <p class="mb-2 text-muted">{{ trans('labels.based_on') }}
                                                        {{ $totalreview }}
                                                        {{ trans('labels.reviews') }}</p>
                                                    <!-- Star -->

                                                    <ul class="list-inline mb-0">
                                                        @php
                                                            $count = (float) $averagerating;
                                                            $fullStars = 0;
                                                            if ($count > 4.5) {
                                                                $fullStars = $count >= 4.75 ? 5 : floor($count);
                                                            } elseif ($count > 3.5) {
                                                                $fullStars = $count >= 3.75 ? 4 : floor($count);
                                                            } elseif ($count > 2.5) {
                                                                $fullStars = $count >= 2.75 ? 3 : floor($count);
                                                            } elseif ($count > 1.5) {
                                                                $fullStars = $count >= 1.75 ? 2 : floor($count);
                                                            } elseif ($count > 0.5) {
                                                                $fullStars = $count >= 0.75 ? 1 : floor($count);
                                                            }
                                                            $hasHalfStar = $count - $fullStars >= 0.5 && $fullStars < 5;
                                                        @endphp
                                                        @for ($i = 0; $i < 5; $i++)
                                                            @if ($i < $fullStars)
                                                                <li class="list-inline-item me-0 small">
                                                                    <i class="fa-solid fa-star text-warning"></i>
                                                                </li>
                                                            @elseif ($i == $fullStars && $hasHalfStar)
                                                                <li class="list-inline-item me-0 small">
                                                                    <i
                                                                        class="fa-solid fa-star-half-stroke text-warning"></i>
                                                                </li>
                                                            @else
                                                                <li class="list-inline-item me-0 small">
                                                                    <i class="fa-regular fa-star text-warning"></i>
                                                                </li>
                                                            @endif
                                                        @endfor
                                                    </ul>
                                                </div>
                                            </div>

                                            <!-- Progress-bar START -->
                                            <div class="col-md-8">
                                                <div class="card-body p-0">
                                                    <div class="row gx-3 g-2 align-items-center">
                                                        <!-- Progress bar and Rating -->
                                                        <div class="col-9 col-sm-10">
                                                            <!-- Progress item -->
                                                            @php
                                                                if ($totalreview != 0) {
                                                                    $five = ($fivestaraverage / $totalreview) * 100;
                                                                } else {
                                                                    $five = 0;
                                                                }
                                                            @endphp
                                                            <div class="progress progress-sm bg-warning bg-opacity-15">
                                                                <div class="progress-bar bg-warning" role="progressbar"
                                                                    style="width: {{ $five }}%"
                                                                    aria-valuenow="{{ $five }}" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Percentage -->
                                                        <div class="col-3 col-sm-2 text-end">
                                                            <span
                                                                class="h6 fw-semibold mb-0 color-changer">{{ number_format($five, 1) }}%</span>
                                                        </div>

                                                        <!-- Progress bar and Rating -->
                                                        <div class="col-9 col-sm-10">
                                                            <!-- Progress item -->
                                                            @php
                                                                if ($totalreview != 0) {
                                                                    $four = ($fourstaraverage / $totalreview) * 100;
                                                                } else {
                                                                    $four = 0;
                                                                }
                                                            @endphp
                                                            <div class="progress progress-sm bg-warning bg-opacity-15">
                                                                <div class="progress-bar bg-warning" role="progressbar"
                                                                    style="width: {{ $four }}%"
                                                                    aria-valuenow="{{ $four }}" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Percentage -->
                                                        <div class="col-3 col-sm-2 text-end">
                                                            <span
                                                                class="h6 fw-semibold mb-0 color-changer">{{ number_format($four, 1) }}%</span>
                                                        </div>

                                                        <!-- Progress bar and Rating -->
                                                        <div class="col-9 col-sm-10">
                                                            <!-- Progress item -->
                                                            @php
                                                                if ($totalreview != 0) {
                                                                    $three = ($threestaraverage / $totalreview) * 100;
                                                                } else {
                                                                    $three = 0;
                                                                }
                                                            @endphp
                                                            <div class="progress progress-sm bg-warning bg-opacity-15">
                                                                <div class="progress-bar bg-warning" role="progressbar"
                                                                    style="width: {{ $three }}%"
                                                                    aria-valuenow="{{ $three }}" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Percentage -->
                                                        <div class="col-3 col-sm-2 text-end">
                                                            <span
                                                                class="h6 fw-semibold mb-0 color-changer">{{ number_format($three, 1) }}%</span>
                                                        </div>

                                                        <!-- Progress bar and Rating -->
                                                        <div class="col-9 col-sm-10">
                                                            <!-- Progress item -->
                                                            @php
                                                                if ($totalreview != 0) {
                                                                    $two = ($twostaraverage / $totalreview) * 100;
                                                                } else {
                                                                    $two = 0;
                                                                }
                                                            @endphp
                                                            <div class="progress progress-sm bg-warning bg-opacity-15">
                                                                <div class="progress-bar bg-warning" role="progressbar"
                                                                    style="width: {{ $two }}%"
                                                                    aria-valuenow="{{ $two }}" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Percentage -->
                                                        <div class="col-3 col-sm-2 text-end">
                                                            <span
                                                                class="h6 fw-semibold mb-0 color-changer">{{ number_format($two, 1) }}%</span>
                                                        </div>

                                                        <!-- Progress bar and Rating -->
                                                        <div class="col-9 col-sm-10">
                                                            <!-- Progress item -->
                                                            @php
                                                                if ($totalreview != 0) {
                                                                    $one = ($onestaraverage / $totalreview) * 100;
                                                                } else {
                                                                    $one = 0;
                                                                }
                                                            @endphp
                                                            <div class="progress progress-sm bg-warning bg-opacity-15">
                                                                <div class="progress-bar bg-warning" role="progressbar"
                                                                    style="width: {{ $one }}%"
                                                                    aria-valuenow="{{ $one }}" aria-valuemin="0"
                                                                    aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Percentage -->
                                                        <div class="col-3 col-sm-2 text-end">
                                                            <span
                                                                class="h6 fw-semibold mb-0 color-changer">{{ number_format($one, 1) }}%</span>
                                                        </div>
                                                    </div> <!-- Row END -->
                                                </div>
                                            </div>
                                            <!-- Progress-bar END -->
                                        </div>
                                    </div>
                                    <!-- Rating end -->
                                    @if (@helper::checkaddons('customer_login'))
                                        @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                            <form class="mb-5"
                                                action="{{ URL::to('/' . $vendordata->slug . '/postreview') }}"
                                                method="POST">
                                                @csrf
                                                <div class="rating mb-3">
                                                    <input type="hidden" name="service_id" id="service_id"
                                                        value="{{ $service->id }}">
                                                    <select class="form-select border-0 bg-lights py-2 px-3"
                                                        name="ratting" aria-label="Default select example">
                                                        <option value="5" selected>★★★★★ (5/5)</option>
                                                        <option value="4">★★★★☆ (4/5)</option>
                                                        <option value="3">★★★☆☆ (3/5)</option>
                                                        <option value="2">★★☆☆☆ (2/5)</option>
                                                        <option value="1">★☆☆☆☆ (1/5)</option>
                                                    </select>
                                                </div>
                                                <div class="form-control bg-lights mb-3 border-0">
                                                    <textarea class="form-control border-0 bg-lights p-0" name="review" id="review"
                                                        placeholder="{{ trans('labels.your_review') }}" rows="3"></textarea>
                                                </div>
                                                <button type="submit"
                                                    class="btn btn-primary rounded btn-submit">{{ trans('labels.post_review') }}</button>
                                            </form>
                                        @endif
                                    @endif
                                    <!------- review start ------->
                                    @foreach ($reviews as $review)
                                        <div class="d-md-flex my-4">
                                            <!-- review avatar -->
                                            <div class="avatar avatar-lg me-3 flex-shrink-0">
                                                <img class="avatar-img rounded-circle"
                                                    src="{{ helper::image_path(@$review->user_info->image) }}"
                                                    alt="avatar">
                                            </div>
                                            <!-- review avatar -->

                                            <!-- review-content -->
                                            <div class="review-content w-100">
                                                <div class="d-flex justify-content-between mt-1 mt-md-0">
                                                    <div>
                                                        <h6 class="me-3 mb-0 fw-bold color-changer">
                                                            {{ @$review->user_info->name }}
                                                        </h6>
                                                        <!-- Info -->
                                                        <p class="text-muted fw-600 fs-7">
                                                            {{ @helper::date_formate($review->created_at, $vendordata->id) }}
                                                        </p>
                                                    </div>
                                                    <!-- Review star -->
                                                    <div>
                                                        <div class="fw-semibold m-0 py-2 badge text-bg-dark rounded-2">
                                                            <i
                                                                class="fas fa-star fa-fw text-warning {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ number_format($review->star, 1) }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <p class="mb-3 mt-1 text-muted fs-7 fw-normal">{{ @$review->description }}
                                                </p>
                                            </div>
                                            <!-- review-content -->
                                        </div>
                                        <!------- review end ------->
                                        <hr class="text-muted">
                                    @endforeach
                                @endif
                            @endif
                        </div>
                        <div class="tab-pane fade" id="pills-product_inquiry" role="tabpanel"
                            aria-labelledby="pills-product_inquiry-tab">
                            <div class="card sevirce-trued">
                                <div class="card-body">
                                    <form action="" method="get">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label for="first_name" class="form-label d-flex gap-1">
                                                    {{ trans('labels.first_name') }}
                                                    <div aria-hidden="true" class="text-danger">*</div>
                                                </label>
                                                <input type="text" class="form-control fs-7 input-h" id="first_name"
                                                    placeholder="First name">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="last_name" class="form-label d-flex gap-1">
                                                    {{ trans('labels.last_name') }}
                                                    <div aria-hidden="true" class="text-danger">*</div>
                                                </label>
                                                <input type="text" class="form-control fs-7 input-h"
                                                    placeholder="Last name" id="last_name">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label d-flex gap-1">
                                                    {{ trans('labels.email') }}
                                                    <div aria-hidden="true" class="text-danger">*</div>
                                                </label>
                                                <input type="email" class="form-control fs-7 input-h" id="email"
                                                    placeholder="Email">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="mobile" class="form-label d-flex gap-1">
                                                    {{ trans('labels.mobile') }}
                                                    <div aria-hidden="true" class="text-danger">*</div>
                                                </label>
                                                <input type="number" class="form-control fs-7 input-h"
                                                    placeholder="Mobile" id="mobile">
                                            </div>
                                            <div class="col-12">
                                                <label for="exampleFormControlTextarea1" class="form-label d-flex gap-1">
                                                    {{ trans('labels.comment') }}
                                                    <div aria-hidden="true" class="text-danger">*</div>
                                                </label>
                                                <p class="fs-8 mb-1"></p>
                                                <textarea class="form-control fs-7 m-0" id="exampleFormControlTextarea1" placeholder="Write your comment here..."
                                                    rows="3"></textarea>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary btn-submit fs-7 fw-500 m-0">
                                                    {{ trans('labels.submit') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @if (@helper::checkaddons('question_answer'))
                            <div class="tab-pane fade" id="pills-quastions" role="tabpanel"
                                aria-labelledby="pills-product_inquiry-tab">
                                <div class="card sevirce-trued">
                                    <div class="card-body">
                                        <div
                                            class="d-flex align-items-center justify-content-between gap-2 mb-2 pb-2 border-bottom">
                                            <p class="fs-7 line-1 color-changer">
                                                {{ trans('labels.have_doubts_regarding_this_product') }}</p>
                                            <div class="col-auto">
                                                <a type="button" class="w-100 fw-600 text-primary rounded-0 p-0"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#qustions_answer">{{ trans('labels.post_your_question') }}</a>
                                            </div>
                                        </div>
                                        @if (count($question_answer) > 0)
                                            @foreach ($question_answer as $item)
                                                <div class="border-bottom p-2">
                                                    <h6 class="fs-7 fw-600 line-2 color-changer">{{ $item->question }}
                                                    </h6>
                                                    <p class="fs-13  text-muted">{{ $item->answer }}
                                                    </p>
                                                </div>
                                            @endforeach
                                        @else
                                            @include('admin.layout.no_data')
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    <!-- related product -->
                    @if ($related_services->count() > 0)
                        <div class="border-bottom bg-transparent px-0 pt-0 pb-3">
                            <h3 class="card-title mb-0 fw-semibold fs-3 color-changer">
                                {{ trans('labels.related_services') }}
                            </h3>
                        </div>
                        <div class="row g-3 related-pro pt-3">
                            @foreach ($related_services as $services)
                                @php
                                    if ($services->top_deals == 1 && @helper::top_deals($vendordata->id) != null) {
                                        if (@helper::top_deals($vendordata->id)->offer_type == 1) {
                                            if ($services->price > @helper::top_deals($vendordata->id)->offer_amount) {
                                                $rprice =
                                                    $services->price -
                                                    @helper::top_deals($vendordata->id)->offer_amount;
                                            } else {
                                                $rprice = $services->price;
                                            }
                                        } else {
                                            $rprice =
                                                $services->price -
                                                $services->price *
                                                    (@helper::top_deals($vendordata->id)->offer_amount / 100);
                                        }
                                        $roriginal_price = $services->price;
                                        $off =
                                            $roriginal_price > 0
                                                ? number_format(100 - ($rprice * 100) / $roriginal_price, 1)
                                                : 0;
                                    } else {
                                        $rprice = $services->price;
                                        $roriginal_price = $services->original_price;
                                        $off = $services->discount_percentage;
                                    }
                                @endphp
                                <div class="col-md-4 col-xl-4 col-lg-4 col-12">
                                    <div class="card shadow h-100 w-100 border-0 rounded-4 overflow-hidden">
                                        <div class="position-relative overflow-hidden">
                                            <img src="{{ $services['service_image'] == null ? helper::image_path('service.png') : helper::image_path($services['service_image']->image) }}"
                                                class="card-img-top inner-service-img" alt="...">
                                            <div class="card-img-overlay">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    @if ($off > 0)
                                                        <div
                                                            class="{{ session()->get('direction') == '2' ? 'service-right-label' : 'service-left-label' }} text-bg-primary">
                                                            <p>{{ $off }}%
                                                                {{ trans('labels.off') }}</p>
                                                        </div>
                                                    @endif
                                                    @if (@helper::checkaddons('customer_login'))
                                                        @if (helper::appdata($vendordata->id)->online_order == 1)
                                                            @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                                <div class="badges bg-danger float-end">
                                                                    <button
                                                                        onclick="managefavorite('{{ $services->id }}',{{ $vendordata->id }},'{{ URL::to(@$vendordata->slug . '/managefavorite') }}')"
                                                                        class="btn border-0 text-white fs-6">
                                                                        @if (Auth::user() && Auth::user()->type == 3)
                                                                            @php
                                                                                $favorite = helper::ceckfavorite(
                                                                                    $services->id,
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
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-text">
                                                <h5 class="mb-0 fs-16 fw-semibold service-cardtitle">
                                                    <a href="{{ URL::to($vendordata->slug . '/service-' . $services->slug) }}"
                                                        class="color-changer">{{ $services->name }}</a>
                                                </h5>
                                                <div class="d-flex align-items-center justify-content-between my-2">
                                                    @php
                                                        $category = helper::getcategoryinfo(
                                                            $service->category_id,
                                                            $service->vendor_id,
                                                        );
                                                    @endphp

                                                    <small class="fs-7 text-muted">{{ $category[0]->name }}</small>
                                                    @if (@helper::checkaddons('customer_login'))
                                                        @if (helper::appdata($vendordata->id)->online_order == 1)
                                                            @if (@helper::checkaddons('product_reviews'))
                                                                @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                                    <p class="fw-semibold fs-7 m-0">
                                                                        <i class="fas fa-star fs-7 text-warning"></i>
                                                                        <span class="color-changer">
                                                                            {{ helper::ratting($services->id, $vendordata->id) == null ? number_format(0, 1) : number_format(helper::ratting($services->id, $vendordata->id), 1) }}
                                                                        </span>
                                                                    </p>
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-transparent border-top p-3">
                                            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                                <div class="d-flex align-items-center gap-1">
                                                    <p class="fw-bold my-0 color-changer">
                                                        {{ helper::currency_formate($rprice, $vendordata->id) }}
                                                    </p>
                                                    @if ($roriginal_price > $rprice)
                                                        <del class="fw-bold my-0 text-muted fs-7">
                                                            {{ helper::currency_formate($roriginal_price, $vendordata->id) }}
                                                        </del>
                                                    @endif
                                                </div>
                                                @if (helper::appdata($vendordata->id)->online_order == 1)
                                                    <a href="{{ URL::to($vendordata->slug . '/booking-' . $services->id) }}"
                                                        class="booknow fw-semibold text-primary-color">
                                                        {{ trans('labels.book_now') }} <i
                                                            class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                                @else
                                                    <a href="{{ URL::to($vendordata->slug . '/service-' . $services->slug) }}"
                                                        class="booknow fw-semibold text-primary-color">
                                                        {{ trans('labels.view') }} <i
                                                            class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
                <div class="col-lg-12 col-xl-4 ps-xl-5">
                    <div class="row">
                        <div class="col-md-6 col-xl-12">
                            <!------------- Book now item ------------->
                            <div class="card border rounded bg-transparentF">
                                <div class="card-body">
                                    <!-- Price -->
                                    <div class="hstack gap-2 mb-1">
                                        <h3 class="card-title fs-3 mb-0 fw-bold color-changer">
                                            {{ helper::currency_formate($price, $vendordata->id) }}</h3>
                                        @if ($original_price > $price)
                                            <del class="card-title fs-5 mb-0 fw-bold text-muted">
                                                {{ helper::currency_formate($original_price, $vendordata->id) }}</del>
                                        @endif
                                    </div>

                                    <div class="d-flex justify-content-between mb-4">
                                        @if ($service->tax != '' && $service->tax != null)
                                            <p class="text-danger">
                                                {{ trans('labels.exclusive_all_taxes') }}
                                            </p>
                                        @else
                                            <p class="text-success">
                                                {{ trans('labels.inclusive_all_taxes') }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Button -->
                                    <div class="d-grid gap-2">
                                        @if ($service->video_url != '' && $service->video_url != null)
                                            <a href="{{ $service->video_url }}" target="_blank" id="btn-video"
                                                class="btn btn-outline-primary mb-0 fw-semibold btn-submit rounded"><i
                                                    class="fa-solid fa-video me-2"></i>{{ trans('labels.service_video') }}</a>
                                        @endif
                                        @if (helper::appdata($vendordata->id)->google_review != '' && helper::appdata($vendordata->id)->google_review != null)
                                            <a href="{{ helper::appdata($vendordata->id)->google_review }}"
                                                target="_blank"
                                                class="btn btn-outline-primary mb-0 fw-semibold btn-submit rounded"><i
                                                    class="fa-solid fa-star {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.external_review_link') }}</a>
                                        @endif
                                        @if (@helper::checkaddons('subscription'))
                                            @if (@helper::checkaddons('whatsapp_message'))
                                                @php
                                                    $checkplan = App\Models\Transaction::where('vendor_id', $vdata)
                                                        ->orderByDesc('id')
                                                        ->first();
                                                    $user = App\Models\User::where('id', $vdata)->first();
                                                    if (@$user->allow_without_subscription == 1) {
                                                        $whatsapp_message = 1;
                                                    } else {
                                                        $whatsapp_message = @$checkplan->whatsapp_message;
                                                    }
                                                @endphp
                                                @if (
                                                    $whatsapp_message == 1 &&
                                                        @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number != '' &&
                                                        @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number != null)
                                                    <a class="btn btn-outline-primary mb-0 fw-semibold btn-submit rounded"
                                                        href="https://api.whatsapp.com/send?phone= {{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number }} &text=  {{ trans('labels.item_inquiry_msg') }} {{ $service->name }}"
                                                        target="_blank">
                                                        <i
                                                            class="fa-brands fa-whatsapp {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.whatsapp') }}</a>
                                                @endif
                                            @endif
                                        @else
                                            @if (@helper::checkaddons('whatsapp_message'))
                                                @if (whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number != '' &&
                                                        whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number != null)
                                                    <a class="btn btn-outline-primary mb-0 fw-semibold btn-submit rounded"
                                                        href="https://api.whatsapp.com/send?phone= {{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number }} &text={{ trans('labels.item_inquiry_msg') }} {{ $service->name }}"
                                                        target="_blank">
                                                        <i
                                                            class="fa-brands fa-whatsapp {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.whatsapp') }}</a>
                                                @endif
                                            @endif
                                        @endif

                                        @if (helper::appdata($vendordata->id)->online_order == 1)
                                            <button class="btn btn-primary fw-semibold btn-submit rounded"
                                                onclick="getadditionalservice()">
                                                <i
                                                    class="fa-regular fa-bookmark {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>
                                                {{ trans('labels.book_now') }}</button>
                                        @endif
                                        <a href="{{ URL::to($vendordata->slug . '/contact') }}"
                                            class="btn btn-outline-primary mb-0 fw-semibold btn-submit rounded">
                                            <i
                                                class="fa-regular fa-eye {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.send_inquiry') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-12">
                            <!--------------- Need Help --------------->
                            <div class="card border-0 bg-lights p-4 mt-xl-3 mt-3 mt-md-0 need_help">
                                <div class="card-body p-0">
                                    <!-- Title -->
                                    <h3 class="card-title fw-600 fs-3 color-changer">{{ trans('labels.need_help') }}?
                                    </h3>

                                    <!-- List -->
                                    <ul class="list-group list-group-borderless">
                                        <li class="list-group-item py-3">
                                            <a href="tel:{{ helper::appdata($vendordata->id)->contact }}"
                                                class="h6 mb-0 text-muted fw-500 d-flex align-items-center gap-2">
                                                <i
                                                    class="{{ session()->get('direction') == 2 ? 'fa-light fa-phone-flip' : 'fa-light fa-phone' }} text-primary-color fs-5"></i>
                                                <span
                                                    class="fw-bold text-dark color-changer">{{ trans('labels.call_us_on') }}
                                                    :</span>{{ helper::appdata($vendordata->id)->contact }}
                                            </a>
                                        </li>
                                        <div class="border-bottom my-3"></div>
                                        <li class="list-group-item pt-3 pb-0">
                                            <p class="h6 fw-bold mb-0 d-flex align-items-center gap-2 mb-1"><span><i
                                                        class="fa-regular fa-clock text-primary-color fs-5"></i></span>
                                                <span class="color-changer">
                                                    {{ trans('labels.timing') }}
                                                </span>
                                                :
                                            </p>
                                            @foreach ($times as $time)
                                                <h6 class="mb-0 text-dark fw-bold d-flex aloign-items-center gap-2">

                                                    <p class="text-dark fw-600 mb-1 color-changer">
                                                        {{ $time->day }} :
                                                        <span class="text-muted fw-500">
                                                            @if ($time->is_always_close == 1)
                                                                {{ trans('labels.closed') }}
                                                            @else
                                                                {{ $time->open_time }} {{ trans('labels.to') }}
                                                                {{ $time->close_time }}
                                                            @endif
                                                        </span>
                                                    </p>
                                                </h6>
                                            @endforeach
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-12">
                            @include('front.service.sevirce-trued')
                        </div>
                    </div>
                </div>
            </div>
            <!-- RECENT SERVICE START -->
            <div class="mt-3">
                @if (@helper::checkaddons('recent_view_product'))
                    @if (@helper::otherappdata($vendordata->id)->recent_view_product == 1)
                        @if (count($recentServices) > 0)
                            <div class="border-bottom bg-transparent px-0 pt-0 pb-3">
                                <h3 class="card-title mb-0 fw-semibold fs-3 color-changer">
                                    {{ trans('labels.recent_view') }}
                                </h3>
                            </div>
                            <div class="row g-3 related-pro pt-3">
                                @foreach ($recentServices as $services)
                                    @php
                                        if ($services->top_deals == 1 && @helper::top_deals($vendordata->id) != null) {
                                            if (@helper::top_deals($vendordata->id)->offer_type == 1) {
                                                if (
                                                    $services->price > @helper::top_deals($vendordata->id)->offer_amount
                                                ) {
                                                    $rprice =
                                                        $services->price -
                                                        @helper::top_deals($vendordata->id)->offer_amount;
                                                } else {
                                                    $rprice = $services->price;
                                                }
                                            } else {
                                                $rprice =
                                                    $services->price -
                                                    $services->price *
                                                        (@helper::top_deals($vendordata->id)->offer_amount / 100);
                                            }
                                            $roriginal_price = $services->price;
                                            $off =
                                                $roriginal_price > 0
                                                    ? number_format(100 - ($rprice * 100) / $roriginal_price, 1)
                                                    : 0;
                                        } else {
                                            $rprice = $services->price;
                                            $roriginal_price = $services->original_price;
                                            $off = $services->discount_percentage;
                                        }
                                    @endphp
                                    <div class="col-sm-6 col-xl-3 col-lg-4 col-12">
                                        <div class="card shadow h-100 w-100 border-0 rounded-4 overflow-hidden">
                                            <div class="position-relative overflow-hidden">
                                                <img src="{{ $services['service_image'] == null ? helper::image_path('service.png') : helper::image_path($services['service_image']->image) }}"
                                                    class="card-img-top inner-service-img" alt="...">
                                                <div class="card-img-overlay">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        @if ($off > 0)
                                                            <div
                                                                class="{{ session()->get('direction') == '2' ? 'service-right-label' : 'service-left-label' }} text-bg-primary">
                                                                <p>{{ $off }}%
                                                                    {{ trans('labels.off') }}</p>
                                                            </div>
                                                        @endif
                                                        @if (@helper::checkaddons('customer_login'))
                                                            @if (helper::appdata($vendordata->id)->online_order == 1)
                                                                @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                                    <div class="badges bg-danger float-end">
                                                                        <button
                                                                            onclick="managefavorite('{{ $services->id }}',{{ $vendordata->id }},'{{ URL::to(@$vendordata->slug . '/managefavorite') }}')"
                                                                            class="btn border-0 text-white fs-6">
                                                                            @if (Auth::user() && Auth::user()->type == 3)
                                                                                @php
                                                                                    $favorite = helper::ceckfavorite(
                                                                                        $services->id,
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
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="card-text">
                                                    <h5 class="mb-0 fs-16 fw-semibold service-cardtitle">
                                                        <a href="{{ URL::to($vendordata->slug . '/service-' . $services->slug) }}"
                                                            class="color-changer">{{ $services->name }}</a>
                                                    </h5>
                                                    <div class="d-flex align-items-center justify-content-between my-2">
                                                        @php
                                                            $category = helper::getcategoryinfo(
                                                                $service->category_id,
                                                                $service->vendor_id,
                                                            );
                                                        @endphp

                                                        <small class="fs-7 text-muted">{{ $category[0]->name }}</small>
                                                        @if (@helper::checkaddons('customer_login'))
                                                            @if (helper::appdata($vendordata->id)->online_order == 1)
                                                                @if (@helper::checkaddons('product_reviews'))
                                                                    @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                                        <p class="fw-semibold fs-7 m-0">
                                                                            <i class="fas fa-star fs-7 text-warning"></i>
                                                                            <span class="color-changer">
                                                                                {{ helper::ratting($services->id, $vendordata->id) == null ? number_format(0, 1) : number_format(helper::ratting($services->id, $vendordata->id), 1) }}
                                                                            </span>
                                                                        </p>
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-transparent border-top p-3">
                                                <div
                                                    class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center gap-1">
                                                        <p class="fw-bold my-0 color-changer">
                                                            {{ helper::currency_formate($rprice, $vendordata->id) }}
                                                        </p>
                                                        @if ($roriginal_price > $rprice)
                                                            <del class="fw-bold my-0 text-muted fs-7">
                                                                {{ helper::currency_formate($roriginal_price, $vendordata->id) }}
                                                            </del>
                                                        @endif
                                                    </div>
                                                    @if (helper::appdata($vendordata->id)->online_order == 1)
                                                        <a href="{{ URL::to($vendordata->slug . '/booking-' . $services->id) }}"
                                                            class="booknow fw-semibold text-primary-color">
                                                            {{ trans('labels.book_now') }} <i
                                                                class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                                    @else
                                                        <a href="{{ URL::to($vendordata->slug . '/service-' . $services->slug) }}"
                                                            class="booknow fw-semibold text-primary-color">
                                                            {{ trans('labels.view') }} <i
                                                                class=" mx-1 {{ session()->get('direction') == 2 ? 'fa-solid fa-arrow-left-long' : 'fa-solid fa-arrow-right-long' }}"></i></a>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                @endif
            </div>
            <!-- RECENT SERVICE END -->
        </div>
    </section>
    @if (@helper::checkaddons('sticky_cart_bar'))
        @include('front.service.service-view-cart-bar')
    @endif
    <!---------------------------------------------------- subscription popup ---------------------------------------------------->
    @include('front.subscribe.index')
    <div class="extra-marginss"></div>
    <!---------------------------------------------------- subscription popup ---------------------------------------------------->
@endsection
@section('scripts')
    <script>
        function getadditionalservice() {
            var value = $(".select_additional_service:checked").map(function() {
                return $(this).val();
            }).get().join("|");
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: "{{ URL::to($vendordata->slug . '/addtional_service') }}",
                type: "post",
                dataType: "json",
                data: {
                    value: value
                },
                success: function(response) {
                    if (response.status == "1") {
                        window.location.href =
                            "{{ URL::to($vendordata->slug . '/booking-' . $service->id) }}";
                    }
                }
            });
        }

        $(document).ready(function() {
            $('#social-links').addClass('d-none');
        });

        function myFunction() {
            $('#social-links').toggleClass('d-none');
        }
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/service.js') }}"></script>
@endsection
