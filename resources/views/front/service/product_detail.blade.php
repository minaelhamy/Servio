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
                        aria-current="page">{{ trans('labels.product_detail') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <section class="service-view-sec">
        <div class="container">
            <h2 class="section-title fw-bold fs-3">{{ trans('labels.product_detail') }}</h2>
        </div>
        <div class="container-fluid px-0 my-4">
            <div id="services-view" class="owl-carousel owl-theme">
                @foreach ($product['multi_image'] as $productimage)
                    <div class="item">
                        <a id="gallery" class="w-100 h-100 glightbox" data-glightbox="type: image"
                            href="{{ helper::image_path($productimage->image_name) }}">
                            <div class="card card-element-hover card-overlay-hover rounded-0 overflow-hidden">
                                <!-- Image -->
                                <img src="{{ helper::image_path($productimage->image_name) }}" class="w-100 h-100"
                                    alt="">
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
        <div class="container">
            <div class="col-12 mt-4">
                <div class="card border-0 bg-lights rounded">
                    <!-- Card body -->
                    <div class="card-body py-md-4">
                        <!-- Title and badge -->
                        @php
                            $price = $product->price;
                            $original_price = $product->original_price;
                            $off = $product->discount_percentage;
                        @endphp
                        <div class="d-flex flex-wrap gap-2 align-items-center justify-content-between">
                            <div class="badge text-bg-dark">{{ @$product['category_info']->name }}</div>
                            <div
                                class="d-flex flex-column flex-sm-row flex-wrap align-items-sm-center justify-content-between">
                                <div class="d-flex justify-content-between align-items-center gap-2 order-sm-2 order-1">
                                    @if ($off > 0)
                                        <span class="service-left-label-2">
                                            {{ $off }}% {{ trans('labels.off') }}
                                        </span>
                                    @endif
                                    <ul class="list-inline mb-0 d-flex gap-2">
                                        <!-- wishlist -->
                                        <li class="list-inline-item m-0">
                                            @if (@helper::checkaddons('customer_login'))
                                                @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                    <button
                                                        onclick="managefavorite('{{ $product->id }}',{{ $vendordata->id }},'{{ URL::to(@$vendordata->slug . '/product/managefavorite') }}')"
                                                        class="btn btn-sm btn-white px-2">
                                                        @if (Auth::user() && Auth::user()->type == 3)
                                                            @php
                                                                $favorite = helper::productcheckfavorite(
                                                                    $product->id,
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
                                        </li>
                                        <!-- Share -->
                                        <div class="position-relative">
                                            <li class="list-inline-item m-0 dropdown">
                                                <!-- Share button -->
                                                <button onclick="myFunction()" class="btn btn-sm btn-white px-2"
                                                    role="button" id="dropdownShare" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa-solid fa-fw fa-share-alt"></i>
                                                </button>
                                            </li>
                                            {!! $shareComponent !!}
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Title -->
                        <h2 class="my-2 fw-bold fs-3 order-sm-1 order-2 color-changer">{{ $product->name }}</h2>
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
                                        helper::appdata($vendordata->id)->product_fake_view_message,
                                    );
                                @endphp
                                <div class="d-flex gap-1 align-items-center blink_me my-2">
                                    <p class="fw-600 text-dark m-0 color-changer">{!! $fake_view !!}</p>
                                </div>
                            @endif
                        @endif
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
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="javascript:void(0)" data-bs-toggle="pill"
                                    data-bs-target="#pills-customer_review" aria-selected="false"
                                    role="tab">{{ trans('labels.customer_review') }}</a>
                            </li>
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
                                        <p class="text-justify">{!! $product->description !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-customer_review" role="tabpanel"
                            aria-labelledby="pills-pills-customer_review-tab">
                            @if (@helper::checkaddons('customer_login'))
                                @if (@helper::checkaddons('product_reviews'))
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
                                                        <div
                                                            class="col-3 col-sm-2 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
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
                                                        <div
                                                            class="col-3 col-sm-2 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
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
                                                        <div
                                                            class="col-3 col-sm-2 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
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
                                                        <div
                                                            class="col-3 col-sm-2 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
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
                                                        <div
                                                            class="col-3 col-sm-2 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                                            <span
                                                                class="h6 fw-semibold mb-0 color-changer">{{ number_format($one, 1) }}%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Progress-bar END -->
                                        </div>
                                    </div>
                                    <!-- Rating end -->
                                    @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                        <form class="mb-5"
                                            action="{{ URL::to('/' . $vendordata->slug . '/postreview') }}"
                                            method="POST">
                                            @csrf
                                            <div class="rating mb-3">
                                                <input type="hidden" name="product_id" id="product_id"
                                                    value="{{ $product->id }}">
                                                <select class="form-select border-0 bg-lights py-2 px-3" name="ratting"
                                                    aria-label="Default select example">
                                                    <option value="5" selected="">★★★★★ (5/5)</option>
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
                                    <!------- review start ------->
                                    @foreach ($reviews as $review)
                                        <div class="d-md-flex pb-3 mb-3 border-bottom">
                                            <!-- review avatar -->
                                            <div class="avatar avatar-lg me-3 flex-shrink-0">
                                                <img class="avatar-img rounded-circle"
                                                    src="{{ helper::image_path($review->user_info->image) }}"
                                                    alt="avatar">
                                            </div>
                                            <!-- review avatar -->

                                            <!-- review-content -->
                                            <div class="review-content w-100">
                                                <div class="d-flex justify-content-between mt-1 mt-md-0">
                                                    <div>
                                                        <h6 class="mb-0 fw-bold color-changer">
                                                            {{ $review->user_info->name }}</h6>
                                                        <!-- Info -->
                                                        <p class="text-muted fw-600 fs-7">
                                                            {{ helper::date_formate($review->created_at, $vendordata->id) }}
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

                                                <p class="mb-0 mt-1 text-muted fs-7 fw-normal">{{ $review->description }}
                                                </p>
                                            </div>
                                            <!-- review-content -->
                                        </div>
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
                    <div class="pb-4">

                        @if ($related_products->count() > 0)
                            <div class="border-bottom bg-transparent pb-2 mb-3">
                                <h3 class="card-title mb-0 fw-semibold fs-3 color-changer">
                                    {{ trans('labels.related_product') }}</h3>
                            </div>
                            <div class="row g-3 related-pro">
                                @foreach ($related_products as $products)
                                    @php
                                        $rprice = $products->price;
                                        $roriginal_price = $products->original_price;
                                        $roff = $products->discount_percentage;
                                    @endphp
                                    <div class="col-sm-6 col-xl-4 col-lg-4 col-12">
                                        <div class="card shadow h-100 w-100 border-0 rounded-4 overflow-hidden">
                                            <div class="position-relative overflow-hidden">
                                                <img src="{{ @helper::image_path($products['product_image']->image) }}"
                                                    class="card-img-top inner-service-img" alt="...">
                                                <div class="card-img-overlay p-3 z-index-1">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        @if ($roff > 0)
                                                            <div class="service-left-label text-bg-primary">
                                                                <p>{{ $roff }}% {{ trans('labels.off') }}</p>
                                                            </div>
                                                        @endif
                                                        @if (@helper::checkaddons('customer_login'))
                                                            @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                                <div class="badges bg-danger float-end">
                                                                    <button
                                                                        onclick="managefavorite('{{ $products->id }}',{{ $vendordata->id }},'{{ URL::to(@$vendordata->slug . '/product/managefavorite') }}')"
                                                                        class="btn text-white border-0 fs-6">
                                                                        @if (Auth::user() && Auth::user()->type == 3)
                                                                            @php
                                                                                $favorite = helper::productcheckfavorite(
                                                                                    $products->id,
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
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div class="d-flex align-items-center gap-1">
                                                        @if ($products->stock_management == 1)
                                                            @if ($products->qty > 0)
                                                                <span
                                                                    class="d-flex justify-content-center font-8px text-success">
                                                                    <i class="fa-solid fa-circle"></i>
                                                                </span>
                                                                <span class="text-success fs-8">
                                                                    {{ trans('labels.in_stock') }}
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="d-flex justify-content-center font-8px text-danger">
                                                                    <i class="fa-solid fa-circle"></i>
                                                                </span>
                                                                <span class="text-danger fs-8">
                                                                    {{ trans('labels.out_of_stock') }}
                                                                </span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    @if (@helper::checkaddons('product_reviews'))
                                                        @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                            <p
                                                                class="fw-semibold m-0 d-flex align-items-center gap-1 fs-7">
                                                                <i class="fas fa-star fa-fw text-warning"></i>
                                                                <span class="color-changer">
                                                                    {{ helper::productratting($products->id, $vendordata->id) == null ? number_format(0, 1) : number_format(helper::productratting($products->id, $vendordata->id), 1) }}
                                                                </span>
                                                            </p>
                                                        @endif
                                                    @endif
                                                </div>
                                                <h5 class="mb-0 fs-16 fw-semibold line-2">
                                                    <a href="{{ URL::to($vendordata->slug . '/product-' . $products->slug) }}"
                                                        class="color-changer">
                                                        {{ $products->name }}
                                                    </a>
                                                </h5>
                                            </div>
                                            <div class="card-footer border-top p-3 bg-transparent">
                                                <div class="d-flex gap-1 justify-content-between align-items-center">
                                                    <div class="d-flex flex-wrap align-items-center gap-1">
                                                        <span class="fw-600 my-0 text-truncate fs-16 color-changer">
                                                            {{ helper::currency_formate($rprice, $vendordata->id) }}
                                                        </span>
                                                        @if ($roriginal_price > $rprice)
                                                            <del class="fw-600 my-0 fs-18 text-muted">
                                                                {{ helper::currency_formate($roriginal_price, $vendordata->id) }}</del>
                                                        @endif
                                                    </div>
                                                    @if (helper::appdata($vendordata->id)->online_order == 1)
                                                        <button
                                                            onclick="addtocart('{{ $products->id }}','{{ URL::to($vendordata->slug . '/cart/add') }}',0)"
                                                            class="btn-primary-rgb col-auto btn text-primary-color fs-7 d-flex gap-1 fw-semibold add_to_cart_{{ $products->id }}">
                                                            <div class="add_to_cart_icon_{{ $products->id }}">
                                                                {{ trans('labels.add_cart') }}
                                                                <i
                                                                    class="fa-solid {{ session()->get('direction') == 2 ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                                                            </div>
                                                            <div
                                                                class="load showload d-none add_to_cart_loader_{{ $products->id }}">
                                                            </div>
                                                        </button>
                                                    @else
                                                        <a href="{{ URL::to($vendordata->slug . '/product-' . $products->slug) }}"
                                                            class="btn-primary-rgb btn col-auto text-primary-color fs-7 d-flex gap-1 fw-semibold">
                                                            {{ trans('labels.view') }}
                                                            <i
                                                                class="fa-solid {{ session()->get('direction') == 2 ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>


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
                                        @if ($product->tax != '' && $product->tax != null)
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
                                        @if ($product->video_url != '' && $product->video_url != null)
                                            <a href="{{ $product->video_url }}" target="_blank" id="btn-video"
                                                class="btn btn-outline-primary d-flex gap-2 align-items-center justify-content-center mb-0 fw-semibold btn-submit rounded">
                                                <i class="fa-solid fa-video"></i>
                                                {{ trans('labels.product_video') }}
                                            </a>
                                        @endif
                                        @if (helper::appdata($vendordata->id)->google_review != '' && helper::appdata($vendordata->id)->google_review != null)
                                            <a href="{{ helper::appdata($vendordata->id)->google_review }}"
                                                target="_blank"
                                                class="btn btn-outline-primary d-flex gap-2 align-items-center justify-content-center mb-0 fw-semibold btn-submit rounded">
                                                <i class="fa-solid fa-star"></i>
                                                {{ trans('labels.external_review_link') }}
                                            </a>
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
                                                    <a class="btn btn-outline-primary d-flex gap-2 align-items-center justify-content-center mb-0 fw-semibold btn-submit rounded"
                                                        href="https://api.whatsapp.com/send?phone= {{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number }} &text=  {{ trans('labels.item_inquiry_msg') }} {{ $product->name }}"
                                                        target="_blank">
                                                        <i class="fa-brands fa-whatsapp"></i>
                                                        {{ trans('labels.whatsapp') }}
                                                    </a>
                                                @endif
                                            @endif
                                        @else
                                            @if (@helper::checkaddons('whatsapp_message'))
                                                @if (
                                                    @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number != '' &&
                                                        @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number != null)
                                                    <a class="btn btn-outline-primary d-flex gap-2 align-items-center justify-content-center mb-0 fw-semibold btn-submit rounded"
                                                        href="https://api.whatsapp.com/send?phone= {{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number }} &text={{ trans('labels.item_inquiry_msg') }} {{ $product->name }}"
                                                        target="_blank">
                                                        <i class="fa-brands fa-whatsapp"></i>
                                                        {{ trans('labels.whatsapp') }}
                                                    </a>
                                                @endif
                                            @endif
                                        @endif
                                        @if (helper::appdata($vendordata->id)->online_order == 1)
                                            <button
                                                onclick="addtocart('{{ $product->id }}','{{ URL::to($vendordata->slug . '/cart/add') }}',0)"
                                                class="btn btn-primary d-flex gap-2 align-items-center justify-content-center fw-semibold btn-submit rounded add_to_cart_{{ $product->id }}">
                                                <div class="add_to_cart_icon_{{ $product->id }}">
                                                    <i class="fa-regular fa-cart-shopping"></i>
                                                    {{ trans('labels.add_to_cart') }}
                                                </div>
                                                <div class="load d-none add_to_cart_loader_{{ $product->id }}"></div>
                                            </button>
                                            <button
                                                onclick="addtocart('{{ $product->id }}','{{ URL::to($vendordata->slug . '/cart/add') }}',1)"
                                                class="btn btn-outline-primary fw-semibold d-flex gap-2 align-items-center justify-content-center btn-submit rounded buy_now_{{ $product->id }}">
                                                <div class="buy_now_icon_{{ $product->id }}">
                                                    <i class="fa-regular fa-bag-shopping"></i>
                                                    {{ trans('labels.buy_now') }}
                                                </div>
                                                <div class="load d-none buy_now_loader_{{ $product->id }}"></div>
                                            </button>
                                        @endif
                                        <a href="{{ URL::to($vendordata->slug . '/contact') }}"
                                            class="btn btn-outline-primary d-flex gap-2 align-items-center justify-content-center mb-0 fw-semibold btn-submit rounded">
                                            <i class="fa-regular fa-eye"></i>
                                            {{ trans('labels.send_inquiry') }}
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
            <!-- RECENT PRODUCTS START -->
            <div class="mt-3">

                @if (@helper::checkaddons('recent_view_product'))
                    @if (@helper::otherappdata($vendordata->id)->recent_view_product == 1)
                        @if (count($recentProducts) > 0)
                            <div class="border-bottom bg-transparent pb-2 mb-3">
                                <h3 class="card-title mb-0 fw-semibold fs-3 color-changer">
                                    {{ trans('labels.recent_view') }}</h3>
                            </div>
                            <div class="row g-3 related-product">
                                @foreach ($recentProducts as $products)
                                    @php
                                        $rprice = $products->price;
                                        $roriginal_price = $products->original_price;
                                        $roff = $products->discount_percentage;
                                    @endphp
                                    <div class="col-sm-6 col-xl-3 col-lg-4 col-12">
                                        <div class="card shadow h-100 w-100 border-0 rounded-4 overflow-hidden">
                                            <div class="position-relative overflow-hidden">
                                                <img src="{{ @helper::image_path($products['product_image']->image) }}"
                                                    class="card-img-top inner-service-img" alt="...">
                                                <div class="card-img-overlay p-3 z-index-1">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        @if ($roff > 0)
                                                            <div class="service-left-label text-bg-primary">
                                                                <p>{{ $roff }}% {{ trans('labels.off') }}
                                                                </p>
                                                            </div>
                                                        @endif
                                                        @if (@helper::checkaddons('customer_login'))
                                                            @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                                <div class="badges bg-danger float-end">
                                                                    <button
                                                                        onclick="managefavorite('{{ $products->id }}',{{ $vendordata->id }},'{{ URL::to(@$vendordata->slug . '/product/managefavorite') }}')"
                                                                        class="btn text-white border-0 fs-6">
                                                                        @if (Auth::user() && Auth::user()->type == 3)
                                                                            @php
                                                                                $favorite = helper::productcheckfavorite(
                                                                                    $products->id,
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
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div class="d-flex align-items-center gap-1">
                                                        @if ($products->stock_management == 1)
                                                            @if ($products->qty > 0)
                                                                <span
                                                                    class="d-flex justify-content-center font-8px text-success">
                                                                    <i class="fa-solid fa-circle"></i>
                                                                </span>
                                                                <span class="text-success fs-8">
                                                                    {{ trans('labels.in_stock') }}
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="d-flex justify-content-center font-8px text-danger">
                                                                    <i class="fa-solid fa-circle"></i>
                                                                </span>
                                                                <span class="text-danger fs-8">
                                                                    {{ trans('labels.out_of_stock') }}
                                                                </span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    @if (@helper::checkaddons('product_reviews'))
                                                        @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                            <p class="fw-semibold m-0 d-flex align-items-center gap-1 fs-7">
                                                                <i class="fas fa-star fa-fw text-warning"></i>
                                                                <span class="color-changer">
                                                                    {{ helper::productratting($products->id, $vendordata->id) == null ? number_format(0, 1) : number_format(helper::productratting($products->id, $vendordata->id), 1) }}
                                                                </span>
                                                            </p>
                                                        @endif
                                                    @endif
                                                </div>
                                                <h5 class="mb-0 fs-16 fw-semibold line-2">
                                                    <a href="{{ URL::to($vendordata->slug . '/product-' . $products->slug) }}"
                                                        class="color-changer">
                                                        {{ $products->name }}
                                                    </a>
                                                </h5>
                                            </div>
                                            <div class="card-footer border-top p-3 bg-transparent">
                                                <div class="d-flex gap-1 justify-content-between align-items-center">
                                                    <div class="d-flex flex-wrap align-items-center gap-1">
                                                        <span class="fw-600 my-0 text-truncate fs-16 color-changer">
                                                            {{ helper::currency_formate($rprice, $vendordata->id) }}
                                                        </span>
                                                        @if ($roriginal_price > $rprice)
                                                            <del class="fw-600 my-0 fs-18 text-muted">
                                                                {{ helper::currency_formate($roriginal_price, $vendordata->id) }}</del>
                                                        @endif
                                                    </div>
                                                    @if (helper::appdata($vendordata->id)->online_order == 1)
                                                        <button
                                                            onclick="addtocart('{{ $products->id }}','{{ URL::to($vendordata->slug . '/cart/add') }}',0)"
                                                            class="btn-primary-rgb col-auto btn text-primary-color fs-7 d-flex gap-1 fw-semibold add_to_cart_{{ $products->id }}">
                                                            <div class="add_to_cart_icon_{{ $products->id }}">
                                                                {{ trans('labels.add_cart') }}
                                                                <i
                                                                    class="fa-solid {{ session()->get('direction') == 2 ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                                                            </div>
                                                            <div
                                                                class="load showload d-none add_to_cart_loader_{{ $products->id }}">
                                                            </div>
                                                        </button>
                                                    @else
                                                        <a href="{{ URL::to($vendordata->slug . '/product-' . $products->slug) }}"
                                                            class="btn-primary-rgb btn col-auto text-primary-color fs-7 d-flex gap-1 fw-semibold">
                                                            {{ trans('labels.view') }}
                                                            <i
                                                                class="fa-solid {{ session()->get('direction') == 2 ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                                                        </a>
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
            <!-- RECENT PRODUCTS END -->
        </div>
    </section>

    @if (@helper::checkaddons('sticky_cart_bar'))
        @include('front.service.product-view-cart-bar')
    @endif
    <!---------------------------------------------------- subscription popup ---------------------------------------------------->
    @include('front.subscribe.index')
    <div class="extra-marginss"></div>
    <!---------------------------------------------------- subscription popup ---------------------------------------------------->
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#social-links').addClass('d-none');
        });

        function myFunction() {
            $('#social-links').toggleClass('d-none');
        }
    </script>
@endsection
