@extends('front.layout.master')
@section('content')
    <div class="container">
        <div class="breadcrumb-div pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL::to($vendordata->slug) }}" class="text-primary-color"><i
                                class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.home') }}</a>
                    </li>
                    <li class="breadcrumb-item  active {{ session()->get('direction') == 2 ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">{{ trans('labels.services') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="servicelist mb-4">
        <div class="container">
            <h2 class="text-font section-title fw-bold mb-4 fs-3">{{ trans('labels.service_list') }}</h2>
            <div class="card bg-secondary border-0 servicelist_colorchange text-center p-4 p-md-5 rounded-4">
                <div class="card-body">
                    <div class="col-md-8 mx-auto my-5">
                        <h2 class="fs-1 fw-bold m-0 text-white fs-3">
                            {{ request()->get('category') ? $category_name : trans('labels.service_list') }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row mt-n6 mt-sm-n7">
                <div class="col-11 mx-auto z-index-9">
                    <div class="card shadow p-4 rounded-4">
                        <div class="row g-3 justify-content-between">
                            <div iv class="col-lg-5 col-md-6 col-sm-6">
                                <label class="form-label text-muted">{{ trans('labels.categories') }}</label>
                                <select class="form-select text-muted border rounded bg-white py-3 px-4"
                                    onchange="service_filter()" name="category" id="category">
                                    <option value="" selected>{{ trans('labels.select') }}</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->slug }}"
                                            {{ request()->get('category') == $category->slug ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-5 col-md-6 col-sm-6">
                                <label class="form-label text-muted">{{ trans('labels.service') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control border rounded bg-white py-3 px-4"
                                        name="search_input" id="search_input"
                                        value="{{ isset($_GET['search_input']) ? $_GET['search_input'] : '' }}"
                                        placeholder="{{ trans('labels.search_by_service_name') }}" />
                                </div>
                            </div>
                            <div class="col-lg-2 d-flex align-items-end">
                                <button onclick="service_filter()"
                                    class="btn bg-primary rounded w-100 py-3 px-4 text-white btn-submit m-0">{{ trans('labels.search') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- filter -->
            <div class="row align-items-center justify-content-between mt-5 mb-4 filter">
                <!-- result -->
                @php
                    $total = $getservice->total();
                    $currentPage = $getservice->currentPage();
                    $perPage = $getservice->perPage();
                    $from = ($currentPage - 1) * ($perPage + 1);
                    $to = min($currentPage * $perPage, $total);
                @endphp
                <div class="col-lg-8 col-md-6 col-12 mb-3 mb-md-0" id="count-section">
                    <h5 class="mb-0 fw-bold">{{ trans('labels.showing') }} {{ $from }}-{{ $to }} of
                        {{ $total }} {{ trans('labels.result') }}</h5>
                </div>
                <div class="col-lg-4 col-md-6 col-12 ms-auto">
                    <div class="d-flex align-items-center justify-content-md-end justify-content-between">
                        <div class="col-sm-auto col-7 mx-sm-2">
                            <select name="sorter-options" id="sorter-options" class="form-select bg-white py-2">
                                <option value="" selected>
                                    {{ trans('labels.rating') }} | {{ trans('labels.price') }}</option>
                                <option value="high-to-low-price" {{ $sorter == 'high-to-low-price' ? 'selected' : '' }}>
                                    {{ trans('labels.high_to_low_price') }}</option>
                                <option value="low-to-high-price" {{ $sorter == 'low-to-high-price' ? 'selected' : '' }}>
                                    {{ trans('labels.low_to_high_price') }}</option>
                                @if (@helper::checkaddons('customer_login'))
                                    @if (@helper::checkaddons('product_reviews'))
                                        <option value="high-to-low-rating"
                                            {{ $sorter == 'high-to-low-rating' ? 'selected' : '' }}>
                                            {{ trans('labels.high_to_low_rating') }}</option>
                                        <option value="low-to-high-rating"
                                            {{ $sorter == 'low-to-high-rating' ? 'selected' : '' }}>
                                            {{ trans('labels.low_to_high_rating') }}</option>
                                    @endif
                                @endif
                            </select>
                        </div>
                        <ul class="col-xl-3 col-lg-4 col-md-4 col-4 mx-1 mx-sm-0 d-flex justify-content-end nav nav-pills nav-pills-dark"
                            id="tour-pills-tab" role="tablist">
                            <!-- Tab item -->
                            <li
                                class="nav-item overflow-hidden {{ session()->get('direction') == 2 ? 'rounded-end' : 'rounded-start' }}">
                                <a class="nav-link text-dark mb-0 service-active rounded-0" id="column">
                                    <i class="fa-solid fa-grid-2"></i>
                                </a>
                            </li>
                            <li
                                class="nav-item overflow-hidden {{ session()->get('direction') == 2 ? 'rounded-start' : 'rounded-end' }}">
                                <a class="nav-link text-dark rounded-0 mb-0" id="grid">
                                    <i class="fa-solid fa-list-ul"></i>
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
                <!-- result -->
            </div>
            <!-- filter -->

        </div>
    </section>
    @if ($getservice->count() > 0)
        <section class="my-3">
            <div class="container">
                <div class="listing-view">
                    <!-- dropdown div -->
                    <div class="row g-3">
                        @foreach ($getservice as $service)
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
                            <div class="col-lg-3 col-md-6 d-flex">
                                <div class="card shadow h-100 w-100 border-0 rounded-4 overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <img src="{{ $service['service_image'] == null ? helper::image_path('service.png') : helper::image_path(@$service['service_image']->image) }}"
                                            class="card-img-top inner-service-img" alt="...">
                                        <div class="card-img-overlay p-3 z-index-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                @if ($off > 0)
                                                    <div
                                                        class="{{ session()->get('direction') == '2' ? 'service-right-label' : 'service-left-label' }} text-bg-primary">
                                                        <p>{{ $off }}% {{ trans('labels.off') }}</p>
                                                    </div>
                                                @endif
                                                @if (@helper::checkaddons('customer_login'))
                                                    @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                        <div class="badges bg-danger float-end">
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
                                            <h5 class="mb-0 fw-semibold text_truncation2 service-cardtitle">
                                                <a class="text-capitalize color-changer"
                                                    href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}">
                                                    {{ $service->name }}</a>
                                            </h5>
                                            <div class="d-flex align-items-center justify-content-between my-2">
                                                @php
                                                    $category = helper::getcategoryinfo(
                                                        $service->category_id,
                                                        $vendordata->id,
                                                    );
                                                @endphp
                                                <small
                                                    class="fs-8 text-muted text-truncate">{{ @$category[0]->name }}</small>
                                                @if (@helper::checkaddons('product_reviews'))
                                                    @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                        <p class="fw-semibold m-0 fs-7"><i
                                                                class="fas fa-star fa-fw text-warning"></i>
                                                            <span class="color-changer">
                                                                {{ helper::ratting($service->id, $vendordata->id) == null ? number_format(0, 1) : number_format(helper::ratting($service->id, $vendordata->id), 1) }}
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
                                                    <del class="fw-600 my-0 fs-18 text-muted">
                                                        {{ helper::currency_formate($original_price, $vendordata->id) }}</del>
                                                @endif
                                            </div>
                                            @if (helper::appdata($vendordata->id)->online_order == 1)
                                                <a href="{{ URL::to($vendordata->slug . '/booking-' . $service->id) }}"
                                                    class="booknow text-primary-color fw-semibold">{{ trans('labels.book_now') }}
                                                    <i
                                                        class=" mx-1 fa-solid {{ session()->get('direction') == 2 ? 'fa-arrow-left-long' : 'fa-arrow-right-long' }}"></i>
                                                </a>
                                            @else
                                                <a href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}"
                                                    class="booknow text-primary-color fw-semibold">{{ trans('labels.view') }}
                                                    <i
                                                        class=" mx-1 fa-solid {{ session()->get('direction') == 2 ? 'fa-arrow-left-long' : 'fa-arrow-right-long' }}"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- <div class="nav-scroller py-1 mb-2">
                        <nav class="nav d-flex justify-content-center">
                            <ul class="pagination pagination-sm flex-sm-wrap">
                                {!! $getservice->withQueryString()->links() !!} </ul>
                        </nav>
                    </div> --}}
                    <div class="d-flex justify-content-center mt-3 ">
                        {!! $getservice->withQueryString()->links() !!}
                    </div>
                </div>
                <div id="column-view" class="d-none">
                    <div class="row g-3 listing-severice">
                        @foreach ($getservice as $service)
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
                            <div class="col-lg-6 col-md-12">
                                <div class="card my-cart-categories shadow w-100 border-0 rounded-4 overflow-hidden p-2">
                                    <div class="card-body p-0">
                                        <div class="d-flex align-items-center h-100 gap-2">
                                            <div class="test-img col-auto">
                                                <div class="rounded-4 position-relative overflow-hidden">
                                                    <img src="{{ $service['service_image'] == null ? helper::image_path('service.png') : helper::image_path(@$service['service_image']->image) }}"
                                                        class="card-img-top p-0 border w-100 rounded-4" alt="...">
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
                                                    <small
                                                        class="text-muted text-truncate fs-8">{{ $category[0]->name }}</small>
                                                </div>
                                                <h5 class="title text_truncation2 my-1">
                                                    <a class="fs-16 color-changer text-capitalize"
                                                        href="{{ URL::to($vendordata->slug . '/service-' . $service->slug) }}">{{ $service->name }}</a>
                                                </h5>
                                                <div class="d-flex gap-1 justify-content-between align-items-center">
                                                    <div class="d-flex flex-wrap align-items-center gap-1">
                                                        <p class="price fs-16 m-0 fw-bold text-truncate color-changer">
                                                            {{ helper::currency_formate($price, $vendordata->id) }}
                                                        </p>
                                                        @if ($original_price > $price)
                                                            <del class="price fs-18 m-0 fw-bold text-muted text-truncate">
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
                        <div class="d-flex justify-content-center mt-3">
                            {!! $getservice->withQueryString()->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        @include('admin.layout.no_data')
    @endif

    <form id="service_filter_form">
        @if (request()->get('type') == 'topdeals')
            <input type="hidden" name="type" id="type" value="{{ request()->get('type') }}">
        @endif
        <input type="hidden" name="category" id="category_filters" value="{{ request()->get('category') }}">
        <input type="hidden" name="search_input" id="search_input_filters"
            value="{{ request()->get('search_input') }}">
        <input type="hidden" name="sorter" id="sorter" value="{{ @$sorter }}">
    </form>
    <!---------------------------------------------------- subscription popup ---------------------------------------------------->
    @include('front.subscribe.index')
    <div class="extra-marginss"></div>
    <!---------------------------------------------------- subscription popup ---------------------------------------------------->
    <input type="hidden" id="searchurl" value="{{ URL::to($vendordata->slug . '/services') }}">
    <!-- service listing section -->
@endsection
@section('scripts')
    <script>
        $('#sorter-options').change(function() {
            var selectedValue = $(this).val();
            $('#sorter').val(selectedValue);
            $("#service_filter_form").submit();
        });

        function service_filter() {
            var categoryselectedValue = $('option:selected').val();
            var search_inputValues = $('#search_input').val();
            $("#category_filters").val(categoryselectedValue);
            $("#search_input_filters").val(search_inputValues);
            $("#service_filter_form").submit();
        }

        $('#column').on('click', function() {
            "use strict";
            $('#column-view').addClass('d-none');
            $('#column').addClass('service-active');
            $('.listing-view').removeClass('d-none');
            $('#grid').removeClass('service-active');
        })
        $('#grid').on('click', function() {
            "use strict";
            $('#column-view').removeClass('d-none');
            $('#column').removeClass('service-active');
            $('.listing-view').addClass('d-none');
            $('#grid').addClass('service-active');
        })
    </script>
@endsection
