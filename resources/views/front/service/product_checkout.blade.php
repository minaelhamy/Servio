@extends('front.layout.master')
@section('content')
    <div class="container">
        <div class="breadcrumb-div pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL::to($vendordata->slug) }}" class="text-primary-color">
                            <i class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>
                            {{ trans('labels.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">{{ trans('labels.product_checkout') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!---- card-details ---->
    <section class="service-detail">
        <div class="container">
            <h2 class="section-title fw-bold fs-3">{{ trans('labels.product_checkout') }}</h2>
        </div>
    </section>
    <!---- card-details ---->
    <!-- service detail section -->
    <section class="py-3 appoinment mb-5">
        <div class="container">
            @if (count($getcartlist) > 0)
                @if (@helper::checkaddons('cart_checkout_countdown'))
                    @include('front.cart_checkout_countdown')
                @endif
                @php
                    $subtotal = 0;
                @endphp
                @foreach ($getcartlist as $cartdata)
                    @php
                        $subtotal += $cartdata->product_price * $cartdata->qty;
                    @endphp
                @endforeach
                <div class="row d-flex justify-content-center">
                    <div class="col-md-12">
                        <div class="card rounded-4 border-0 bg-lights mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-semibold mb-4 border-bottom color-changer pb-2">
                                    {{ trans('labels.confirm_order') }}</h5>
                                <div class="row g-3">
                                    <div class="col-lg-8 col-12">
                                        <div class="card rounded-4 border overflow-hidden">
                                            <div class="card-body">
                                                <div class="personal-info p-2">
                                                    <h6 class="text-dark fw-600 border-bottom pb-2 mb-3">
                                                        <span
                                                            class="text-capitalize color-changer">{{ trans('labels.personal_info') }}</span>
                                                    </h6>
                                                    <div class="row g-3">
                                                        <div class="col-md-4">
                                                            <div class="form-group m-0">
                                                                <label for="user_name"
                                                                    class="form-label">{{ trans('labels.name') }}</label>
                                                                <input type="text" class="form-control input-h rounded"
                                                                    id="user_name" name="user_name"
                                                                    value="{{ @Auth::user()->name }}"
                                                                    placeholder="{{ trans('labels.name') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group m-0">
                                                                <label for="user_email"
                                                                    class="form-label">{{ trans('labels.email') }}</label>
                                                                <input type="email" class="form-control input-h rounded"
                                                                    id="user_email" name="user_email"
                                                                    value="{{ @Auth::user()->email }}"
                                                                    placeholder="{{ trans('labels.email') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group m-0">
                                                                <label for="user_mobile"
                                                                    class="form-label">{{ trans('labels.mobile') }}</label>
                                                                <input type="text"
                                                                    class="form-control input-h rounded numbers_only"
                                                                    id="user_mobile" name="user_mobile"
                                                                    value="{{ @Auth::user()->mobile }}"
                                                                    placeholder="{{ trans('labels.mobile') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="billing-info p-2">
                                                    <h6 class="text-dark fw-600 border-bottom py-2 mb-3">
                                                        <span
                                                            class="text-capitalize color-changer">{{ trans('labels.billing_address') }}</span>
                                                    </h6>
                                                    <div class="row g-3">
                                                        <div class="col-md-12">
                                                            <div class="form-group m-0">
                                                                <label for="address"
                                                                    class="form-label">{{ trans('labels.address') }}</label>
                                                                <input type="text" class="form-control input-h rounded"
                                                                    id="address" name="address"
                                                                    placeholder="{{ trans('labels.address') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0">
                                                                <label for="landmark"
                                                                    class="form-label">{{ trans('labels.landmark') }}</label>
                                                                <input type="text" class="form-control input-h rounded"
                                                                    id="landmark" name="landmark"
                                                                    placeholder="{{ trans('labels.landmark') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0">
                                                                <label for="postal_code"
                                                                    class="form-label">{{ trans('labels.postalcode') }}</label>
                                                                <input type="text" class="form-control input-h rounded"
                                                                    id="postal_code" name="postal_code"
                                                                    placeholder="{{ trans('labels.postalcode') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0">
                                                                <label for="city"
                                                                    class="form-label">{{ trans('labels.city') }}</label>
                                                                <input type="text" class="form-control input-h rounded"
                                                                    id="city" name="city"
                                                                    placeholder="{{ trans('labels.city') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0">
                                                                <label for="state"
                                                                    class="form-label">{{ trans('labels.state') }}</label>
                                                                <input type="text" class="form-control input-h rounded"
                                                                    id="state" name="state"
                                                                    placeholder="{{ trans('labels.state') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group m-0">
                                                                <label for="country"
                                                                    class="form-label">{{ trans('labels.country') }}</label>
                                                                <input type="text" class="form-control input-h rounded"
                                                                    id="country" name="country"
                                                                    placeholder="{{ trans('labels.country') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group m-0">
                                                                <label for="order_notes"
                                                                    class="form-label">{{ trans('labels.order_notes') }}</label>
                                                                <textarea class="form-control m-0" id="order_notes" placeholder="{{ trans('labels.order_notes_o') }}"
                                                                    rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if (@helper::checkaddons('vendor_tip'))
                                                    @if (@helper::otherappdata($vendordata->id)->tips_on_off == 1)
                                                        <div class="billing-info p-2">
                                                            <h6
                                                                class="text-dark fw-600 border-bottom color-changer py-2 mb-3">
                                                                {{ trans('labels.tips_pro') }}
                                                            </h6>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group m-0">
                                                                        <label for="order_notes"
                                                                            class="form-label">{{ trans('labels.add_amount') }}</label>
                                                                        <input type="number" class="form-control m-0"
                                                                            id="tips_amount" name="tips_amount"
                                                                            placeholder={{ trans('labels.add_amount_p') }}>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-12">
                                        <!-- Offer and discount -->
                                        @if (@helper::checkaddons('subscription'))
                                            @if (@helper::checkaddons('coupon'))
                                                @php
                                                    $checkplan = App\Models\Transaction::where(
                                                        'vendor_id',
                                                        $vendordata->id,
                                                    )
                                                        ->where('transaction_type', null)
                                                        ->orderByDesc('id')
                                                        ->first();
                                                    if (
                                                        helper::getslug($vendordata->id)->allow_without_subscription ==
                                                        1
                                                    ) {
                                                        $coupons = 1;
                                                    } else {
                                                        $coupons = @$checkplan->coupons;
                                                    }
                                                @endphp
                                                @if ($coupons == 1)
                                                    <div class="card mb-3 rounded-4 border overflow-hidden">
                                                        <div
                                                            class="card-header p-3 bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                                            <h6 class="fw-600 m-0 color-changer">
                                                                {{ trans('labels.offer_discount') }}</h6>
                                                            <a href="javascript:void(0)" id="selectPromocode"
                                                                class="d-none text-success" data-bs-toggle="modal"
                                                                data-bs-target="#promocodemodal">
                                                                {{ trans('labels.promocode') }}
                                                            </a>
                                                        </div>
                                                        <div class="card-body p-3 date-time-text">
                                                            <div class="promocode-widget">
                                                                <div class="row g-2 align-items-center">
                                                                    <div class="col-xl-9 col-lg-8 col-md-9 col-12">
                                                                        <input
                                                                            class="form-control form-control-lg rounded fs-7"
                                                                            type="text" name="offer_code"
                                                                            id="offer_code"
                                                                            value="{{ @Session::get('order_discount_data')['offer_code'] }}"
                                                                            placeholder="{{ trans('labels.enter_coupon_code') }}"
                                                                            readonly="">
                                                                    </div>
                                                                    <div class="col-xl-3 col-lg-4 col-md-3 col-12">
                                                                        <button onclick="ApplyCoupon()" id="btnapply"
                                                                            class="btn w-100 py-2 px-3 btn-primary mb-0 rounded btn-submit d-flex justify-content-center">{{ trans('labels.apply') }}</button>
                                                                        <button onclick="RemoveCoupon()" id="btnremove"
                                                                            class="btn w-100 py-2 px-3 btn-primary mb-0 rounded btn-submit d-flex justify-content-center d-none">{{ trans('labels.remove') }}</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @else
                                            @if (@helper::checkaddons('coupon'))
                                                <div class="card mb-3 rounded-4 border overflow-hidden">
                                                    <div
                                                        class="card-header p-3 bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                                        <h6 class="fw-600 m-0 color-changer">
                                                            {{ trans('labels.offer_discount') }}</h6>
                                                        <a href="javascript:void(0)" id="selectPromocode"
                                                            class="d-none text-success" data-bs-toggle="modal"
                                                            data-bs-target="#promocodemodal">
                                                            {{ trans('labels.promocode') }}
                                                        </a>
                                                    </div>
                                                    <div class="card-body p-3 date-time-text">
                                                        <div class="promocode-widget">
                                                            <div class="row g-2 align-items-center">
                                                                <div class="col-xl-9 col-lg-8 col-md-9 col-12">
                                                                    <input
                                                                        class="form-control form-control-lg rounded fs-7"
                                                                        type="text" name="offer_code" id="offer_code"
                                                                        value="{{ @Session::get('order_discount_data')['offer_code'] }}"
                                                                        placeholder="{{ trans('labels.enter_coupon_code') }}"
                                                                        readonly="">
                                                                </div>
                                                                <div class="col-xl-3 col-lg-4 col-md-3 col-12">
                                                                    <button onclick="ApplyCoupon()" id="btnapply"
                                                                        class="btn w-100 py-2 px-3 btn-primary mb-0 rounded btn-submit d-flex justify-content-center">{{ trans('labels.apply') }}</button>
                                                                    <button onclick="RemoveCoupon()" id="btnremove"
                                                                        class="btn w-100 py-2 px-3 btn-primary mb-0 rounded btn-submit d-flex justify-content-center d-none">{{ trans('labels.remove') }}</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                        <!-- Offer and discount -->
                                        <!-- Shipping Areas -->
                                        @if (@helper::checkaddons('shipping_area'))
                                            @if (helper::appdata($vendordata->id)->shipping_area == 1)
                                                <div class="card mb-3 rounded-4 border overflow-hidden shipping-area-info">
                                                    <div
                                                        class="card-header p-3 bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                                        <h6 class="fw-600 m-0 color-changer">
                                                            {{ trans('labels.shipping_area') }}</h6>
                                                    </div>
                                                    <div class="card-body p-3 date-time-text">
                                                        <div class="row g-2 align-items-center">
                                                            <div class="col-md-12">
                                                                <select name="shipping_area" id="shipping_area"
                                                                    class="form-select">
                                                                    <option value="" selected disabled>
                                                                        {{ trans('labels.select') }}
                                                                    </option>
                                                                    @foreach ($getshippingarealist as $shippingarea)
                                                                        <option value="{{ $shippingarea->id }}"
                                                                            data-delivery-charge="{{ $shippingarea->delivery_charge }}"
                                                                            data-area-name="{{ $shippingarea->area_name }}">
                                                                            {{ $shippingarea->area_name }}
                                                                            @if (helper::appdata($vendordata->id)->min_order_amount_for_free_shipping >= $subtotal)
                                                                                @if ($shippingarea->delivery_charge > 0)
                                                                                    {{ trans('labels.delivery_charge') }}
                                                                                    :
                                                                                    {{ helper::currency_formate($shippingarea->delivery_charge, @$vendordata->id) }}
                                                                                @else
                                                                                    {{ trans('labels.free_delivery') }}
                                                                                @endif
                                                                            @endif
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                        <!-- Shipping Areas -->
                                        <!-- Price Summary -->
                                        <div class="card mb-3 rounded-4 border overflow-hidden">
                                            <div class="card-header bg-transparent p-3 bg-transparent border-bottom">
                                                <h6 class="fw-600 m-0 color-changer">{{ trans('labels.price_summary') }}
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-group list-group-flush">
                                                    <li
                                                        class="list-group-item d-flex fs-15 justify-content-between px-0 py-3 fw-500">
                                                        <p class="text-muted">{{ trans('labels.subtotal') }}</p>
                                                        <span
                                                            class="text-dark color-changer fw-500">{{ helper::currency_formate($subtotal, $vendordata->id) }}</span>
                                                    </li>
                                                    @php
                                                        $discount = @session()->get('order_discount_data')[
                                                            'offer_amount'
                                                        ];
                                                    @endphp
                                                    <li
                                                        class="list-group-item d-flex fs-15 justify-content-between px-0 py-3 fw-500 discount_section d-none">
                                                        <p class="text-muted">{{ trans('labels.discount') }}</p>
                                                        <span id="offer_amount" class="text-dark color-changer fw-500">–
                                                            {{ helper::currency_formate($discount, $vendordata->id) }}</span>
                                                    </li>
                                                    @php
                                                        $totaltax = 0;
                                                    @endphp
                                                    @if ($taxArr['tax'] != null && $taxArr['rate'] != null)
                                                        @foreach ($taxArr['tax'] as $k => $tax)
                                                            @php
                                                                $rate = $taxArr['rate'][$k];
                                                                $totaltax += (float) $taxArr['rate'][$k];
                                                            @endphp
                                                            <li
                                                                class="list-group-item fs-15 fw-500 d-flex justify-content-between px-0 py-3 fw-semibold">
                                                                <p class="text-muted">{{ $tax }}</p>
                                                                <span class="text-dark fw-500 color-changer">
                                                                    {{ helper::currency_formate($rate, $vendordata->id) }}
                                                                </span>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                    <li
                                                        class="list-group-item fs-15 fw-500 d-flex justify-content-between px-0 py-3 fw-semibold">
                                                        <p class="text-muted">{{ trans('labels.delivery') }}</p>
                                                        @if (@helper::checkaddons('shipping_area'))
                                                            @if (helper::appdata($vendordata->id)->shipping_area == 1)
                                                                @php

                                                                    $grand_total = $subtotal - $discount + $totaltax;
                                                                @endphp
                                                                @if (helper::appdata($vendordata->id)->min_order_amount_for_free_shipping >= $subtotal)
                                                                    <input type="hidden" name="delivery_charge"
                                                                        id="delivery_charge" value="0">
                                                                    <span
                                                                        class="text-dark color-changer fw-500 delivery_charge">{{ helper::currency_formate(0, $vendordata->id) }}</span>
                                                                @else
                                                                    <input type="hidden" name="delivery_charge"
                                                                        id="delivery_charge" value="0">
                                                                    <span
                                                                        class="text-dark color-changer fw-500">{{ trans('labels.free') }}</span>
                                                                @endif
                                                            @else
                                                                @if ($subtotal >= helper::appdata($vendordata->id)->min_order_amount_for_free_shipping)
                                                                    @php
                                                                        $grand_total =
                                                                            $subtotal - $discount + $totaltax;
                                                                    @endphp
                                                                    <input type="hidden" name="delivery_charge"
                                                                        id="delivery_charge" value="0">
                                                                    <span
                                                                        class="text-dark color-changer fw-500">{{ trans('labels.free') }}</span>
                                                                @else
                                                                    @php
                                                                        $grand_total =
                                                                            $subtotal -
                                                                            $discount +
                                                                            $totaltax +
                                                                            helper::appdata($vendordata->id)
                                                                                ->shipping_charges;
                                                                    @endphp
                                                                    <input type="hidden" name="delivery_charge"
                                                                        id="delivery_charge"
                                                                        value="{{ helper::appdata($vendordata->id)->shipping_charges }}">
                                                                    <span
                                                                        class="text-dark color-changer fw-500">{{ helper::currency_formate(helper::appdata($vendordata->id)->shipping_charges, $vendordata->id) }}</span>
                                                                @endif
                                                            @endif
                                                        @else
                                                            @if ($subtotal >= helper::appdata($vendordata->id)->min_order_amount_for_free_shipping)
                                                                @php
                                                                    $grand_total = $subtotal - $discount + $totaltax;
                                                                @endphp
                                                                <input type="hidden" name="delivery_charge"
                                                                    id="delivery_charge" value="0">
                                                                <span
                                                                    class="text-dark color-changer fw-500">{{ trans('labels.free') }}</span>
                                                            @else
                                                                @php
                                                                    $grand_total =
                                                                        $subtotal -
                                                                        $discount +
                                                                        $totaltax +
                                                                        helper::appdata($vendordata->id)
                                                                            ->shipping_charges;
                                                                @endphp
                                                                <input type="hidden" name="delivery_charge"
                                                                    id="delivery_charge"
                                                                    value="{{ helper::appdata($vendordata->id)->shipping_charges }}">
                                                                <span
                                                                    class="text-dark color-changer fw-500">{{ helper::currency_formate(helper::appdata($vendordata->id)->shipping_charges, $vendordata->id) }}</span>
                                                            @endif
                                                        @endif
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between px-0 pt-3 fw-600 fs-16 text-success">
                                                        {{ trans('labels.grand_total') }}
                                                        <span id="total_amount"
                                                            class="fw-600">{{ helper::currency_formate($grand_total, $vendordata->id) }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Price Summary -->
                                        @include('front.service.sevirce-trued')

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- payment type -->
                        <div class="card border-0 rounded-4 bg-lights my-4 payment_methods">
                            <div class="card-body p-4">
                                <h5 class="fw-semibold mb-3 border-bottom pb-2 color-changer">
                                    {{ trans('labels.payment_type') }}
                                </h5>
                                <div class="row g-3">
                                    @foreach ($getpayment as $payment)
                                        @php
                                            // Check if the current $payment is a system addon and activated
                                            if ($payment->payment_type == '1' || $payment->payment_type == '16') {
                                                $systemAddonActivated = true;
                                            } else {
                                                $systemAddonActivated = false;
                                            }
                                            $addon = App\Models\SystemAddons::where(
                                                'unique_identifier',
                                                $payment->unique_identifier,
                                            )->first();
                                            if ($addon != null && $addon->activated == 1) {
                                                $systemAddonActivated = true;
                                            }
                                            $payment_type = $payment->payment_type;
                                        @endphp
                                        @if ($systemAddonActivated)
                                            <div
                                                class="col-xl-3 col-lg-4 col-md-6 col-12 fw-bolder d-flex align-items-center payment-checked position-relative">
                                                <input
                                                    class="form-check-input position-absolute {{ session()->get('direction') == 2 ? 'start-10' : 'end-10' }}"
                                                    type="radio" value="{{ $payment->public_key }}"
                                                    id="payment{{ $payment_type }}"
                                                    data-transaction-type="{{ $payment_type }}"
                                                    @if ($payment_type == '6') data-bank-description="{{ $payment->payment_description }}" @endif
                                                    data-currency="{{ $payment->currency }}" name="paymentmode">
                                                <label for="payment{{ $payment_type }}"
                                                    class="d-flex align-items-center py-4 rounded-4 form-control bg-white pointer">
                                                    <div class="payment-gateway d-flex align-items-center fw-500">
                                                        <img src="{{ helper::image_path($payment->image) }}"
                                                            width="30" height="30" class="mx-3" alt="">
                                                        <div class="d-flex align-items-center gap-3">
                                                            {{ $payment->payment_name }}
                                                            @if (Auth::user())
                                                                @if ($payment_type == 16)
                                                                    <span
                                                                        class="fw-500 text-muted">{{ helper::currency_formate(Auth::user()->wallet, $vendordata->id) }}</span>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </label>
                                                @if ($payment_type == '3')
                                                    <input type="hidden" name="stripe_public_key" id="stripe_public_key"
                                                        value="{{ $payment->public_key }}">
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- payment type -->
                        <div class="row g-3 justify-content-between">
                            <div class="col-sm-auto col-12">
                                <a href="{{ URL::to(@$vendordata->slug . '/') }}" type="button"
                                    class="btn w-100 btn-outline-secondary color-changer btn-md btn-submit rounded">
                                    {{ trans('labels.continue_shopping') }}
                                </a>
                            </div>
                            <div class="col-sm-auto col-12">
                                <button class="btn w-100 btn-primary btn-submit rounded text-white placeorder"
                                    onclick="placeorder()">
                                    {{ trans('labels.checkout') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="vendor_id" name="vendor_id" value="{{ $vendordata->id }}">
                <input type="hidden" id="vendor_slug" name="vendor_slug" value="{{ $vendordata->slug }}">
                <input type="hidden" id="subtotal" name="subtotal" value="{{ @$subtotal }}">
                <input type="hidden" id="totaltax" name="totaltax" value="{{ @$totaltax }}">
                <input type="hidden" id="tax_amount" name="tax_amount" value="{{ implode('|', $taxArr['rate']) }}">
                <input type="hidden" id="tax_name" name="tax_name" value="{{ implode('|', $taxArr['tax']) }}">
                <input type="hidden" id="grand_total" name="grand_total" value="{{ $grand_total }}">
                <input type="hidden" id="buynow" name="buynow" value="{{ request()->buynow }}">
                <input type="hidden" name="couponcode" id="couponcode"
                    value="{{ @Session::get('order_discount_data')['offer_code'] }}">
                <input type="hidden" name="discount_amount" id="discount_amount" value="{{ @$discount }}">
                <input type="hidden" value="{{ trans('messages.payment_selection_required') }}"
                    name="paymentmode_message" id="paymentmode_message">
                <form action="{{ URL::to($vendordata->slug) . '/paypalrequest' }}" method="post" class="d-none">
                    {{ csrf_field() }}
                    <input type="hidden" name="return" value="2">
                    <input type="submit" class="callpaypal" name="submit">
                </form>
            @else
                @include('admin.layout.no_data')
            @endif
        </div>
    </section>
    <div class="extra-marginss"></div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            if ("{{ Session::has('order_discount_data') }}") {
                $('.discount_section').removeClass('d-none');
                $('#btnremove').removeClass('d-none');
                $('#btnapply').addClass('d-none');
                $('#selectPromocode').addClass('d-none');
            } else {
                $('.discount_section').addClass('d-none');
                $('#btnremove').addClass('d-none');
                $('#btnapply').removeClass('d-none');
                $('#selectPromocode').removeClass('d-none');
            }
        });

        function ApplyCoupon() {
            $('#btnapply').prop("disabled", true);
            $('#btnapply').html('<div class="load"></div>');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ URL::to('/order/applypromocode') }}",
                method: 'POST',
                data: {
                    offer_code: $('#offer_code').val(),
                    subtotal: $('#subtotal').val(),
                    vendor_id: "{{ $vendordata->id }}",
                },
                success: function(response) {
                    $('#btnapply').html("{{ trans('labels.apply') }}");
                    $('#btnapply').prop("disabled", false);
                    if (response.status == 1) {
                        var total = parseFloat($('#subtotal').val());
                        var tax = "{{ @$totaltax }}";
                        var discount = response.data.offer_amount;
                        var grandtotal = parseFloat(total) + parseFloat(tax) - parseFloat(discount);
                        $('.discount_section').removeClass('d-none');
                        $('#offer_amount').text('– ' + currency_formate(parseFloat(discount)));
                        $('#total_amount').text(currency_formate(parseFloat(grandtotal)));
                        $('#grand_total').val(grandtotal);
                        $('#discount_amount').val(discount);
                        $('#couponcode').val(response.data.offer_code);
                        $('#btnremove').removeClass('d-none');
                        $('#btnapply').addClass('d-none');
                        $('#selectPromocode').addClass('d-none');
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error(wrong);
                    $('#btnapply').html("{{ trans('labels.apply') }}");
                    $('#btnapply').prop("disabled", false);
                }
            });
        }

        function RemoveCoupon() {
            $('#btnremove').prop("disabled", true);
            $('#btnremove').html('<div class="load"></div>');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ URL::to('/order/removepromocode') }}",
                method: 'POST',
                success: function(response) {
                    $('#btnremove').html("{{ trans('labels.remove') }}");
                    $('#btnremove').prop("disabled", false);
                    if (response.status == 1) {
                        var total = $('#subtotal').val();
                        var tax = "{{ @$totaltax }}";
                        var discount = 0;
                        var grandtotal = parseFloat(total) + parseFloat(tax) - parseFloat(discount);
                        $('#offer_amount').text(currency_formate(parseFloat(0)));
                        $('#total_amount').text(currency_formate(parseFloat(grandtotal)));
                        $('#offer_code').val('');
                        $('#grand_total').val(grandtotal);
                        $('#discount_amount').val(discount);
                        $('#couponcode').val('');
                        $('#btnremove').addClass('d-none');
                        $('#btnapply').removeClass('d-none');
                        $('#selectPromocode').removeClass('d-none');
                        $('.discount_section').addClass('d-none');
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error(wrong);
                    $('#btnremove').html("{{ trans('labels.remove') }}");
                    $('#btnremove').prop("disabled", false);
                }
            });
        }

        var checkout = "{{ trans('labels.checkout') }}";
        var min_order_amount = "{{ helper::appdata($vendordata->id)->min_order_amount }}";
        var min_order_amount_msg = "{{ trans('messages.min_order_amount_required') }}";
        var title = {{ Js::from(helper::appdata(@$vendordata->id)->web_title) }}
        var description = "Order Payment";
        var successurl = "{{ URL::to($vendordata->slug) }}/paymentsuccess";
        var failureurl = "{{ url()->current() . '?buynow=' . request()->buynow }}";
        var checkouturl = "{{ URL::to($vendordata->slug) }}";
        var min_order_amount_for_free_shipping =
            "{{ helper::appdata($vendordata->id)->min_order_amount_for_free_shipping }}";
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/checkout.js') }}"></script>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script> {{-- Razorpay --}}
    <script src="https://js.stripe.com/v3/"></script> {{-- Stripe --}}
    <script src="https://js.paystack.co/v1/inline.js"></script> {{--  Paystack --}}
    <script src="https://checkout.flutterwave.com/v3.js"></script> {{-- Flutterwave --}}
@endsection
