@extends('front.layout.master')

@section('content')

    <div class="container">
        <div class="breadcrumb-div pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to($vendordata->slug) }}" class="text-primary-color">
                            <i
                                class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item  active {{ session()->get('direction') == '2' ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">{{ trans('labels.wishlist') }}</li>
                </ol>
            </nav>
        </div>
    </div>


    <section class="product-prev-sec product-list-sec">
        <div class="container">
            <h2 class="section-title fw-600">{{ trans('labels.account_details') }}</h2>
            <div class="user-bg-color mb-4">
                <div class="row g-3">
                    @include('front.user.commonmenu')
                    <div class="col-xl-9 col-lg-8 col-xxl-9 col-12 deleteprofile">
                        <div class="card w-100 rounded-4 overflow-hidden">
                            <!-- Card header -->
                            <div
                                class="card-header bg-transparent border-bottom color-changer p-3 d-flex gap-3 align-items-center">
                                <i class="fs-4 fa-regular fa-heart"></i>
                                <h5 class="title m-0 fw-500">{{ trans('labels.my_wishlist') }}</h5>
                            </div>
                            <!-- Card body START -->
                            <div class="card-body row">
                                <div class="col-12">
                                    <ul class="nav nav-tabs gap-2 align-items-center justify-content-between mb-3">
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <li class="nav-item text-center">
                                                <a href="{{ URL::to($vendordata->slug . '/wishlist') }}"
                                                    class="nav-link text-dark color-changer fs-17 {{ request()->is('*wishlist') && ! request()->is('*productwishlist')  ? 'active' : '' }}">
                                                    {{ trans('labels.service_wishlist') }}
                                                </a>
                                            </li>
                                            @if (@helper::checkaddons('product_shop'))
                                                <li class="nav-item new-line">
                                                    <a href="{{ URL::to($vendordata->slug . '/productwishlist') }}"
                                                        class="nav-link text-dark color-changer fs-17 {{ request()->is('*productwishlist') ? 'active' : '' }}">
                                                        {{ trans('labels.product_wishlist') }}
                                                    </a>
                                                </li>
                                            @endif
                                        </div>
                                        @if ($getservices->count() > 0 || $getproducts->count() > 0)
                                            <li>
                                                <button
                                                    onclick="statusupdate('{{ URL::to($vendordata->slug . '/removeall') }}')"
                                                    class="btn btn-danger-soft mb-0 fw-semibold float-end">
                                                    <i class="fas fa-trash me-2"></i>{{ trans('labels.remove_all') }}
                                                </button>
                                            </li>
                                        @endif
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div
                                            class="tab-pane fade {{ request()->is('*wishlist') && ! request()->is('*productwishlist')? 'active show' : '' }}">
                                            <div class="row g-3 service-div">
                                                @if ($getservices->count() > 0)
                                                    @foreach ($getservices as $services)
                                                        @php
                                                            if (
                                                                $services->top_deals == 1 &&
                                                                @helper::top_deals($vendordata->id) != null
                                                            ) {
                                                                if (
                                                                    @helper::top_deals($vendordata->id)->offer_type == 1
                                                                ) {
                                                                    if (
                                                                        $services->price >
                                                                        @helper::top_deals($vendordata->id)
                                                                            ->offer_amount
                                                                    ) {
                                                                        $price =
                                                                            $services->price -
                                                                            @helper::top_deals($vendordata->id)
                                                                                ->offer_amount;
                                                                    } else {
                                                                        $price = $services->price;
                                                                    }
                                                                } else {
                                                                    $price =
                                                                        $services->price -
                                                                        $services->price *
                                                                            (@helper::top_deals($vendordata->id)
                                                                                ->offer_amount /
                                                                                100);
                                                                }
                                                                $original_price = $services->price;
                                                                $off =
                                                                    $original_price > 0
                                                                        ? number_format(
                                                                            100 - ($price * 100) / $original_price,
                                                                            1,
                                                                        )
                                                                        : 0;
                                                            } else {
                                                                $price = $services->price;
                                                                $original_price = $services->original_price;
                                                                $off = $services->discount_percentage;
                                                            }
                                                        @endphp
                                                        <div class="col-xl-4 col-lg-6 col-md-6 col-auto">
                                                            <div
                                                                class="card shadow h-100 w-100 border-0 rounded-4 overflow-hidden">
                                                                <div class="position-relative">
                                                                    <img src="{{ $services['service_image'] == null ? helper::image_path('service.png') : helper::image_path($services['service_image']->image) }}"
                                                                        class="card-img-top" alt="...">
                                                                    <div class="card-img-overlay p-3 z-index-1">
                                                                        <div
                                                                            class="d-flex justify-content-between align-items-center">
                                                                            @if ($off > 0)
                                                                                <div
                                                                                    class="{{ session()->get('direction') == '2' ? 'service-right-label' : 'service-left-label' }} text-bg-primary">
                                                                                    <p>{{ $off }}%
                                                                                        {{ trans('labels.off') }}</p>
                                                                                </div>
                                                                            @endif
                                                                            @if (@helper::checkaddons('customer_login'))
                                                                                @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                                                    <div class="badges bg-danger float-end">
                                                                                        <button
                                                                                            onclick="managefavorite('{{ $services->id }}',{{ $vendordata->id }},'{{ URL::to(@$vendordata->slug . '/managefavorite') }}')"
                                                                                            class="btn border-0 text-white fs-6">
                                                                                            <i
                                                                                                class="fa-solid fa-fw fa-heart"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="card-text">
                                                                        <h6 class="mb-0 fw-semibold">
                                                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $services->id) }}"
                                                                                class="color-changer">{{ $services->name }}</a>
                                                                        </h6>
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-between my-2">
                                                                            @php
                                                                                $category = helper::getcategoryinfo(
                                                                                    $services->category_id,
                                                                                    $services->vendor_id,
                                                                                );
                                                                            @endphp
                                                                            <small
                                                                                class="fs-7 text-muted">{{ $category[0]->name }}</small>
                                                                            @if (@helper::checkaddons('product_reviews'))
                                                                                @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                                                    <p class="fw-semibold fs-7 m-0">
                                                                                        <i
                                                                                            class="fas fa-star fs-7 text-warning"></i>
                                                                                        <span class="color-changer">
                                                                                            {{ helper::ratting($services->id, $vendordata->id) == null ? number_format(0, 1) : number_format(helper::ratting($services->id, $vendordata->id), 1) }}
                                                                                        </span>

                                                                                    </p>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="card-footer border-top bg-transparent p-3">
                                                                    <div
                                                                        class="d-flex justify-content-between align-items-center">
                                                                        <div class="d-flex align-items-center gap-1">
                                                                            <p class="fw-600 my-0 color-changer">
                                                                                {{ helper::currency_formate($price, $vendordata->id) }}
                                                                            </p>
                                                                            @if ($original_price > $price)
                                                                                <del class="fw-600 my-0 text-muted fs-7">
                                                                                    {{ helper::currency_formate($original_price, $vendordata->id) }}
                                                                                </del>
                                                                            @endif
                                                                        </div>
                                                                        @if (helper::appdata($vendordata->id)->online_order == 1)
                                                                            <a href="{{ URL::to($vendordata->slug . '/booking-' . $services->id) }}"
                                                                                class="booknow text-primary-color fw-semibold">{{ trans('labels.book_now') }}<i
                                                                                    class=" mx-1 fa-solid {{ session()->get('direction') == 2 ? 'fa-arrow-left-long' : 'fa-arrow-right-long' }}"></i></a>
                                                                        @else
                                                                            <a href="{{ URL::to($vendordata->slug . '/service-' . $services->id) }}"
                                                                                class="booknow text-primary-color fw-semibold">{{ trans('labels.book_now') }}<i
                                                                                    class=" mx-1 fa-solid {{ session()->get('direction') == 2 ? 'fa-arrow-left-long' : 'fa-arrow-right-long' }}"></i></a>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <div class="d-flex justify-content-center mt-3">
                                                        {!! $getservices->links() !!}
                                                    </div>
                                                @else
                                                    @include('admin.layout.no_data')
                                                @endif
                                            </div>
                                        </div>
                                        @if (@helper::checkaddons('product_shop'))
                                            <div
                                                class="tab-pane fade {{ request()->is('*productwishlist') ? 'active show' : '' }}">
                                                @if ($getproducts->count() > 0)
                                                    <div
                                                        class="row g-3 row-cols-xl-3 row-cols-lg-2 row-cols-md-2 row-cols-1 product-card">
                                                        @foreach ($getproducts as $product)
                                                            @php
                                                                $price = $product->price;
                                                                $original_price = $product->original_price;
                                                                $off = $product->discount_percentage;
                                                            @endphp
                                                            <div class="col">
                                                                <div
                                                                    class="card shadow h-100 w-100 border-0 rounded-4 overflow-hidden">
                                                                    <div class="position-relative overflow-hidden">
                                                                        <img src="{{ helper::image_path(@$product['product_image']->image) }}"
                                                                            class="card-img-top inner-service-img"
                                                                            alt="...">
                                                                        <div class="card-img-overlay p-3 z-index-1">
                                                                            <div
                                                                                class="d-flex justify-content-between align-items-center">
                                                                                @if ($off > 0)
                                                                                    <div
                                                                                        class="service-left-label text-bg-primary">
                                                                                        <p>{{ $off }}%
                                                                                            {{ trans('labels.off') }}</p>
                                                                                    </div>
                                                                                @endif
                                                                                @if (@helper::checkaddons('customer_login'))
                                                                                    @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                                                                        <div
                                                                                            class="badges bg-danger float-end">
                                                                                            <button
                                                                                                onclick="managefavorite('{{ $product->id }}',{{ $vendordata->id }},'{{ URL::to(@$vendordata->slug . '/product/managefavorite') }}')"
                                                                                                class="btn text-white border-0 fs-6">
                                                                                                <i
                                                                                                    class="fa-solid fa-heart"></i>
                                                                                            </button>
                                                                                        </div>
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div
                                                                            class="d-flex align-items-center justify-content-between mb-2">
                                                                            <div class="d-flex align-items-center gap-1">
                                                                                @if ($product->stock_management == 1)
                                                                                    @if ($product->qty > 0)
                                                                                        <span
                                                                                            class="d-flex justify-content-center font-8px text-success">
                                                                                            <i
                                                                                                class="fa-solid fa-circle"></i>
                                                                                        </span>
                                                                                        <span class="text-success fs-8">
                                                                                            {{ trans('labels.in_stock') }}
                                                                                        </span>
                                                                                    @else
                                                                                        <span
                                                                                            class="d-flex justify-content-center font-8px text-danger">
                                                                                            <i
                                                                                                class="fa-solid fa-circle"></i>
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
                                                                                        <i
                                                                                            class="fas fa-star fa-fw text-warning"></i>
                                                                                        <span class="color-changer">
                                                                                            {{ helper::productratting($product->id, $vendordata->id) == null ? number_format(0, 1) : number_format(helper::productratting($product->id, $vendordata->id), 1) }}
                                                                                        </span>
                                                                                    </p>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                        <h5 class="mb-0 fs-16 fw-semibold line-2">
                                                                            <a
                                                                                href="{{ URL::to($vendordata->slug . '/product-' . $product->slug) }}" class="color-changer">
                                                                                {{ $product->name }}
                                                                            </a>
                                                                        </h5>
                                                                    </div>
                                                                    <div class="card-footer border-top p-3 bg-transparent">
                                                                        <div
                                                                            class="d-flex gap-2 justify-content-between align-items-center">
                                                                            <div
                                                                                class="d-flex flex-wrap align-items-center gap-1">
                                                                                <p class="fw-600 my-0 text-truncate fs-16 color-changer">
                                                                                    {{ helper::currency_formate($price, $vendordata->id) }}
                                                                                </p>
                                                                                @if ($original_price > $price)
                                                                                    <del
                                                                                        class="fw-600 my-0 fs-18 text-muted">
                                                                                        {{ helper::currency_formate($original_price, $vendordata->id) }}</del>
                                                                                @endif
                                                                            </div>
                                                                            @if (helper::appdata($vendordata->id)->online_order == 1)
                                                                                <button
                                                                                    onclick="addtocart('{{ $product->id }}','{{ URL::to($vendordata->slug . '/cart/add') }}',0)"
                                                                                    class="fs-7 btn-primary-rgb btn text-primary-color d-flex gap-1 fw-semibold add_to_cart_{{ $product->id }}">
                                                                                    <div
                                                                                        class="add_to_cart_icon_{{ $product->id }}">
                                                                                        {{ trans('labels.add_to_cart') }}
                                                                                        <i
                                                                                            class="fa-solid {{ session()->get('direction') == 2 ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                                                                                    </div>
                                                                                    <div
                                                                                        class="load d-none add_to_cart_loader_{{ $product->id }}">
                                                                                    </div>
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
                                                        {!! $getproducts->links() !!}
                                                    </div>
                                                @else
                                                    @include('admin.layout.no_data')
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- wishlist -->
                            </div>
                            <!-- Card body END -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- newsletter -->
            @include('front.contact.index')
        </div>
    </section>
@endsection
