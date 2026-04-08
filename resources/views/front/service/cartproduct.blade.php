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
                        {{ trans('labels.product_cart') }}
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!---- card-details ---->
    <section class="servicelist mb-4">
        <div class="container">
            <h2 class="text-font section-title fw-bold mb-4 fs-3">{{ trans('labels.product_cart') }}</h2>
        </div>
    </section>
    @php
        $subtotal = 0;
    @endphp
    <section class="mb-5">
        <div class="container">
            @if (count($getcartlist) > 0)
                @if (@helper::checkaddons('cart_checkout_countdown'))
                    @include('front.cart_checkout_countdown')
                @endif
                <div class="table-responsive rounded">
                    <table class="table m-0 rounded">
                        <thead class="table-primary">
                            <tr>
                                <th class="cart-table-title p-3 text-white">
                                    {{ trans('labels.product_name') }}
                                </th>
                                <th class="cart-table-title p-3 text-center text-white">
                                    {{ trans('labels.price') }}
                                </th>
                                <th class="cart-table-title p-3 text-center text-white">
                                    {{ trans('labels.qty') }}
                                </th>
                                <th class="cart-table-title p-3 text-white text-center">
                                    {{ trans('labels.total') }}
                                </th>
                                <th class="cart-table-title p-3 text-white text-center">
                                    {{ trans('labels.action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($getcartlist as $cart)
                                @php
                                    $subtotal += $cart->product_price * $cart->qty;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="tbl_cart_product gap-3">
                                            <div class="col-auto item-img-none">
                                                <div class="item-img">
                                                    <img src="{{ helper::image_path(@$cart->product_image) }}"
                                                        alt="item-image" class="rounded">
                                                </div>
                                            </div>
                                            <div class="tbl_cart_product_caption">
                                                <div class="d-flex gap-1 align-items-center mb-1">
                                                    <h5 class="tbl_pr_title color-changer fw-600 line-2 m-0 fs-6">
                                                        {{ $cart->product_name }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h4 class="tbl_org_price color-changer">
                                            {{ helper::currency_formate($cart->product_price, $vendordata->id) }}
                                        </h4>
                                    </td>
                                    <td>
                                        <div
                                            class="input-group qty-input2 qtu-width d-flex justify-content-between rounded-2 input-postion mx-auto">
                                            <button class="btn btn-sm py-0 change-qty cart-padding"
                                                onclick="qtyupdate('{{ $cart->id }}','{{ $cart->product_id }}','minus')">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input type="text" class="border color-changer text-center bg-transparent"
                                                value="{{ $cart->qty }}" min="1" max="10" readonly=""
                                                id="number_{{ $cart->id }}">
                                            <button class="btn btn-sm py-0 change-qty cart-padding"
                                                onclick="qtyupdate('{{ $cart->id }}','{{ $cart->product_id }}','plus')">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <h4 class="tbl_org_price color-changer">
                                            {{ helper::currency_formate($cart->product_price * $cart->qty, $vendordata->id) }}
                                        </h4>
                                    </td>
                                    <td>
                                        <div class="tbl_pr_action d-flex justify-content-center align-items-center">
                                            <button
                                                onclick="statusupdate('{{ URL::to($vendordata->slug . '/cart/delete-' . $cart->id) }}')"
                                                class="tbl_remove btn">
                                                <i class="fa-light fa-trash-can fs-7"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p
                    class="text-muted {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }} fs-7 m-0 line-2 mt-2">
                    {{ trans('labels.cart_progress_text') }}</p>
                @if (@helper::checkaddons('cart_checkout_progressbar'))
                    @include('front.cart_checkout_progressbar')
                @endif
                <div class="row g-3 justify-content-between mt-0 align-items-center">
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 ">
                        <a href="{{ URL::to(@$vendordata->slug . '/') }}"
                            class="btn p-2 fw-500 btn-outline-secondary color-changer w-100 d-flex gap-2 justify-content-center align-items-center">
                            {{ trans('labels.continue_shopping') }}</a>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 text-end">
                        <button
                            class="btn p-2 fw-500 btn-primary w-100 d-flex gap-2 justify-content-center align-items-center cart_checkout"
                            id="cartcheckout">
                            {{ trans('labels.go_to_checkout') }}
                        </button>
                    </div>
                </div>
            @else
                @include('admin.layout.no_data')
            @endif
        </div>
    </section>
    <input type="hidden" name="request_url" id="request_url"
        value="{{ @request()->segments()[1] ? @request()->segments()[1] : @request()->segments()[0] }}">
    <div class="extra-marginss"></div>
@endsection
@section('scripts')
    <script>
        var minorderamount = "{{ helper::appdata($vendordata->id)->min_order_amount }}";
        var subtotal = "{{ $subtotal }}";
        var min_order_amount_msg = "{{ trans('messages.min_order_amount_required') }}";
        $('#cartcheckout').on('click', function() {
            "use strict";
            if (minorderamount != '' && minorderamount != null) {
                if (parseFloat(minorderamount) > parseFloat(subtotal)) {
                    toastr.error(min_order_amount_msg + ' ' + minorderamount);
                } else {
                    $('#cartcheckout').prop("disabled", true);
                    $('#cartcheckout').html('<div class="load"></div>');
                    @if (Auth::user() && Auth::user()->type == 3)
                        location.href = "{{ URL::to(@$vendordata->slug . '/checkout?buynow=0') }}";
                    @else
                        @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                            @if (helper::appdata($vendordata->id)->is_checkout_login_required == 1)
                                location.href = "{{ URL::to(@$vendordata->slug . '/login') }}";
                            @else
                                $("#orderloginmodal").on('hidden.bs.modal', function(e) {
                                    $('#cartcheckout').html("{{ trans('labels.go_to_checkout') }}");
                                    $('#cartcheckout').prop("disabled", false);
                                });
                                $('#orderloginmodal').modal('show');
                            @endif
                        @else
                            location.href = "{{ URL::to(@$vendordata->slug . '/checkout?buynow=0') }}";
                        @endif
                    @endif
                }
            } else {
                $('#cartcheckout').prop("disabled", true);
                $('#cartcheckout').html('<div class="load"></div>');
                @if (Auth::user() && Auth::user()->type == 3)
                    location.href = "{{ URL::to(@$vendordata->slug . '/checkout?buynow=0') }}";
                @else
                    @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                        @if (helper::appdata($vendordata->id)->is_checkout_login_required == 1)
                            location.href = "{{ URL::to(@$vendordata->slug . '/login') }}";
                        @else
                            $("#orderloginmodal").on('hidden.bs.modal', function(e) {
                                $('#cartcheckout').html("{{ trans('labels.go_to_checkout') }}");
                                $('#cartcheckout').prop("disabled", false);
                            });
                            $('#orderloginmodal').modal('show');
                        @endif
                    @else
                        location.href = "{{ URL::to(@$vendordata->slug . '/checkout?buynow=0') }}";
                    @endif
                @endif
            }
        });
        var qtycheckurl = "{{ URL::to($vendordata->slug . '/cart/qtyupdate') }}";
    </script>
@endsection
