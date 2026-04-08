@extends('front.layout.master')
@section('content')
    <div class="container">
        <div class="breadcrumb-div pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to($vendordata->slug) }}" class="text-primary-color">
                            <i class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>
                            {{ trans('labels.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">
                        {{ trans('labels.product_s') }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!---- card-details ---->
    <section class="servicelist mb-4">
        <div class="container">
            <h2 class="text-font section-title fw-bold mb-4 fs-3">{{ trans('labels.product_list') }}</h2>
            <div class="card border-0 bg-secondary text-center p-4 p-md-5 rounded-4">
                <div class="card-body">
                    <div class="col-md-8 mx-auto my-5">
                        <h2 class="fs-1 fw-bold m-0 text-white fs-3">
                            {{ trans('labels.product_list') }}
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row mt-n6 mt-sm-n7">
                <div class="col-11 mx-auto z-index-9">
                    <div class="card shadow p-4 rounded-4">
                        <div class="row g-3 justify-content-between">
                            <div class="col-lg-5 col-md-6 col-sm-6">
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
                                <label class="form-label text-muted">{{ trans('labels.product_') }}</label>
                                <div class="input-group">
                                    <input type="text" class="form-control border rounded bg-white py-3 px-4"
                                        name="search_input" id="search_input"
                                        value="{{ isset($_GET['search_input']) ? $_GET['search_input'] : '' }}"
                                        placeholder="{{ trans('labels.search_product_name') }}" />
                                </div>
                            </div>
                            <div class="col-lg-2 d-flex align-items-end">
                                <button onclick="service_filter()"
                                    class="btn bg-primary rounded w-100 py-3 px-4 text-white btn-submit m-0">
                                    {{ trans('labels.search') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- filter -->
            <div class="row align-items-center mt-5 mb-4">
                <div class="col-lg-8 col-md-6 col-12 mb-3 mb-md-0" id="count-section">
                    <h5 class="mb-0 fw-bold">
                        {{ trans('labels.showing') }}
                        {{ $getproduct->firstItem() ? $getproduct->firstItem() : 0 }}-{{ $getproduct->lastItem() ? $getproduct->lastItem() : 0 }}
                        {{ trans('labels.of') }}
                        {{ $getproduct->total() }} {{ trans('labels.result') }}
                    </h5>
                </div>
                <div class="col-lg-4 col-md-6 col-12 ms-auto">
                    <div class="d-flex align-items-center justify-content-md-end justify-content-between gap-3">
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
                        <ul class="d-flex justify-content-end nav nav-pills nav-pills-dark rounded">
                            <li class="nav-item  overflow-hidden {{ session()->get('direction') == 2 ? 'rounded-end' : 'rounded-start' }} ">
                                <a class="nav-link rounded-0 mb-0 service-active text-dark"
                                    id="column">
                                    <i class="fa-solid fa-grid-2"></i>
                                </a>
                            </li>
                            <li class="nav-item overflow-hidden {{ session()->get('direction') == 2 ? 'rounded-start' : 'rounded-end' }}">
                                <a class="nav-link text-dark rounded-0 mb-0"
                                    id="grid">
                                    <i class="fa-solid fa-list-ul"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if ($getproduct->count() > 0)
        <section class="mb-5">
            <div class="container">
                <div
                    class="row g-3 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-sm-2 row-cols-1 product-card listing-view">
                    @foreach ($getproduct as $product)
                        @php
                            $price = $product->price;
                            $original_price = $product->original_price;
                            $off = $product->discount_percentage;
                        @endphp
                        <div class="col">
                            <div class="card shadow h-100 w-100 border-0 rounded-4 overflow-hidden">
                                <div class="position-relative overflow-hidden">
                                    <img src="{{ helper::image_path(@$product['product_image']->image) }}"
                                        class="card-img-top inner-service-img" alt="...">
                                    <div class="card-img-overlay p-3 z-index-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            @if ($off > 0)
                                                <div class="service-left-label text-bg-primary">
                                                    <p>{{ $off }}% {{ trans('labels.off') }}</p>
                                                </div>
                                            @endif
                                            @if (@helper::checkaddons('customer_login'))
                                                @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                    <div class="badges bg-danger float-end">
                                                        <button
                                                            onclick="managefavorite('{{ $product->id }}',{{ $vendordata->id }},'{{ URL::to(@$vendordata->slug . '/product/managefavorite') }}')"
                                                            class="btn text-white border-0 fs-6">
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
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div class="d-flex align-items-center gap-1">
                                            @if ($product->stock_management == 1)
                                                @if ($product->qty > 0)
                                                    <span class="d-flex justify-content-center font-8px text-success">
                                                        <i class="fa-solid fa-circle"></i>
                                                    </span>
                                                    <span class="text-success fs-8">
                                                        {{ trans('labels.in_stock') }}
                                                    </span>
                                                @else
                                                    <span class="d-flex justify-content-center font-8px text-danger">
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
                                                        {{ helper::productratting($product->id, $vendordata->id) == null ? number_format(0, 1) : number_format(helper::productratting($product->id, $vendordata->id), 1) }}
                                                    </span>
                                                </p>
                                            @endif
                                        @endif
                                    </div>
                                    <h5 class="mb-0 fs-16 fw-semibold line-2">
                                        <a href="{{ URL::to($vendordata->slug . '/product-' . $product->slug) }}" class="color-changer">
                                            {{ $product->name }}
                                        </a>
                                    </h5>
                                </div>
                                <div class="card-footer border-top p-3 bg-transparent">
                                    <div class="d-flex gap-2 justify-content-between align-items-center">
                                        <div class="d-flex flex-wrap align-items-center gap-1">
                                            <p class="fw-600 my-0 text-truncate fs-16 color-changer">
                                                {{ helper::currency_formate($price, $vendordata->id) }}
                                            </p>
                                            @if ($original_price > $price)
                                                <del class="fw-600 my-0 fs-18 text-muted">
                                                    {{ helper::currency_formate($original_price, $vendordata->id) }}</del>
                                            @endif
                                        </div>
                                        @if (helper::appdata($vendordata->id)->online_order == 1)
                                            <button
                                                onclick="addtocart('{{ $product->id }}','{{ URL::to($vendordata->slug . '/cart/add') }}',0)"
                                                class="fs-7 btn-primary-rgb btn text-primary-color d-flex gap-1 fw-semibold add_to_cart_{{ $product->id }}">
                                                <div class="add_to_cart_icon_{{ $product->id }}">
                                                    {{ trans('labels.add_to_cart') }}
                                                    <i
                                                        class="fa-solid {{ session()->get('direction') == 2 ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                                                </div>
                                                <div class="load d-none add_to_cart_loader_{{ $product->id }}"></div>
                                            </button>
                                        @else
                                            <a href="{{ URL::to($vendordata->slug . '/product-' . $product->slug) }}"
                                                class="fs-7 btn-primary-rgb btn text-primary-color d-flex gap-1 fw-semibold">
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
                <div class="d-flex justify-content-center mt-3">
                    {!! $getproduct->withQueryString()->links() !!}
                </div>
                <div id="column-view" class="d-none">
                    <div
                        class="row g-3 pt-3 row-cols-xl-2 row-cols-lg-2 row-cols-md-1 row-cols-sm-1 row-cols-1 product_list-card">
                        @foreach ($getproduct as $product)
                            @php
                                $price = $product->price;
                                $original_price = $product->original_price;
                                $off = $product->discount_percentage;
                            @endphp
                            <div class="col">
                                <div
                                    class="card my-cart-categories shadow h-100 w-100 border-0 rounded-4 overflow-hidden p-2">
                                    <div class="card-body p-0">
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="test-img">
                                                <div class="rounded-4 h-100 position-relative overflow-hidden">
                                                    <img src="{{ helper::image_path(@$product['product_image']->image) }}"
                                                        class="card-img-top p-0 border rounded-4 h-100 product-list"
                                                        alt="...">
                                                    @if (@helper::checkaddons('customer_login'))
                                                        @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                            <div class="card-img-overlay p-2 z-index-1">
                                                                <div class="badges bg-danger rounded text-center">
                                                                    <button
                                                                        onclick="managefavorite('{{ $product->id }}',{{ $vendordata->id }},'{{ URL::to(@$vendordata->slug . '/product/managefavorite') }}')"
                                                                        class="btn text-white border-0 fs-6">
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
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="w-100">
                                                <div class="d-flex justify-content-between">
                                                    @if ($off > 0)
                                                        <span class="service-left-label-2 ">
                                                            {{ $off }}% {{ trans('labels.off') }}
                                                        </span>
                                                    @endif
                                                    @if (@helper::checkaddons('product_reviews'))
                                                        @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                            <p
                                                                class="fw-semibold m-0 d-flex align-items-center gap-1 fs-7">
                                                                <i class="fas fa-star fa-fw text-warning"></i>
                                                                <span class="color-changer">
                                                                    {{ helper::productratting($product->id, $vendordata->id) == null ? number_format(0, 1) : number_format(helper::productratting($product->id, $vendordata->id), 1) }}
                                                                </span>
                                                            </p>
                                                        @endif
                                                    @endif
                                                </div>
                                                <h5 class="title text_truncation2 my-1 fw-semibold">
                                                    <a class="fs-16 color-changer"
                                                        href="{{ URL::to($vendordata->slug . '/product-' . $product->slug) }}">{{ $product->name }}</a>
                                                </h5>
                                                <div class="d-flex align-items-center my-2 gap-1">
                                                    @if ($product->stock_management == 1)
                                                        @if ($product->qty > 0)
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
                                                <div class="d-flex gap-1 justify-content-between align-items-center">
                                                    <div class="d-flex flex-wrap align-items-center gap-1">
                                                        <p class="price fs-16 m-0 fw-600 text-truncate color-changer">
                                                            {{ helper::currency_formate($price, $vendordata->id) }}
                                                        </p>
                                                        @if ($original_price > $price)
                                                            <del class="price fs-18 m-0 fw-600 text-muted text-truncate">
                                                                {{ helper::currency_formate($original_price, $vendordata->id) }}</del>
                                                        @endif
                                                    </div>
                                                    @if (helper::appdata($vendordata->id)->online_order == 1)
                                                        <button
                                                            onclick="addtocart('{{ $product->id }}','{{ URL::to($vendordata->slug . '/cart/add') }}',0)"
                                                            class="fs-7 btn-primary-rgb btn text-primary-color fw-semibold add_to_cart_{{ $product->id }}">
                                                            <div
                                                                class="add_to_cart_icon_{{ $product->id }} d-flex gap-1 align-items-center">
                                                                <span
                                                                    class="d-none d-md-block">{{ trans('labels.add_to_cart') }}</span>
                                                                <i
                                                                    class="fa-solid {{ session()->get('direction') == 2 ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                                                            </div>
                                                            <div
                                                                class="load d-none add_to_cart_loader_{{ $product->id }}">
                                                            </div>
                                                        </button>
                                                    @else
                                                        <a href="{{ URL::to($vendordata->slug . '/product-' . $product->slug) }}"
                                                            class="fs-7 btn-primary-rgb btn text-primary-color fw-semibold">
                                                            <div class="d-flex gap-1 align-items-center d-none d-md-block">
                                                                {{ trans('labels.view') }}
                                                                <i
                                                                    class="fa-solid {{ session()->get('direction') == 2 ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                                                            </div>
                                                            <i class="fa-regular fa-eye d-block d-md-none"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-3">
                        {!! $getproduct->withQueryString()->links() !!}
                    </div>
                </div>
            </div>
        </section>
    @else
        @include('admin.layout.no_data')
    @endif

    <form id="service_filter_form">
        <input type="hidden" name="category" id="category_filters" value="{{ request()->get('category') }}">
        <input type="hidden" name="search_input" id="search_input_filters"
            value="{{ request()->get('search_input') }}">
        <input type="hidden" name="sorter" id="sorter" value="{{ @$sorter }}">
    </form>
    @include('front.subscribe.index')
    <div class="extra-marginss"></div>
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
