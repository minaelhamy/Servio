@extends('front.layout.master')
@php
    $user = App\Models\User::where('id', $vdata)->first();
@endphp
@section('content')
    <div class="container mb-2">
        <div class="breadcrumb-div pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to($vendordata->slug) }}" class="text-primary-color">
                            <i
                                class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>{{ trans('labels.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">{{ trans('labels.order_detail') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <section class="booking-detail mb-4">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h2 class="section-title fw-bold">{{ trans('labels.order_detail') }}</h2>
                @if (@helper::checkaddons('custom_status'))
                    <div class="btn btn-primary-rgb btn-submit px-5 rounded">
                        {{ @helper::gettype($getorderdata->status, $getorderdata->status_type, $vendordata->id, 2)->name == null ? '-' : @helper::gettype($getorderdata->status, $getorderdata->status_type, $vendordata->id, 2)->name }}
                    </div>
                @endif
            </div>
            <div class="table-responsive shadow rounded">
                <table class="table rounded overflow-hidden m-0">
                    <thead class="table-primary">
                        <tr class="text-capitalize py-2 fw-600">
                            <td class="text-white py-3">
                                {{ trans('labels.product_name') }}
                            </td>
                            <td
                                class="text-white py-3 {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                {{ trans('labels.price') }}
                            </td>
                            <td
                                class="text-white py-3 {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                {{ trans('labels.qty') }}
                            </td>
                            <td
                                class="text-white py-3 {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                {{ trans('labels.total') }}
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getorderitemlist as $product)
                            <tr class="fs-15 fw-normal align-middle">
                                <td>
                                    <div class="tbl_cart_product gap-3">
                                        <div class="col-auto item-img-none">
                                            <div class="item-img">
                                                <img src="{{ helper::image_path($product->product_image) }}"
                                                    alt="item-image" class="rounded">
                                            </div>
                                        </div>
                                        <div class="tbl_cart_product_caption">
                                            <div class="d-flex gap-1 align-items-center mb-1">
                                                <h5 class="tbl_pr_title fw-600 line-2 m-0 fs-6 color-changer">
                                                    {{ $product->product_name }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="{{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }} color-changer">
                                    {{ helper::currency_formate($product->product_price, $vendordata->id) }}
                                </td>
                                <td
                                    class="{{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }} color-changer">
                                    {{ $product->qty }}
                                </td>
                                <td
                                    class="{{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }} color-changer">
                                    {{ helper::currency_formate($product->product_price * $product->qty, $vendordata->id) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($getorderdata->notes != '')
                <div class="row pt-3">
                    <div class="col-12">
                        <div class="card rounded-4 shadow border-0 h-100">
                            <div class="card-header bg-transparent border-bottom p-3">
                                <h5 class="m-0 color-changer">{{ trans('labels.order_notes') }}</h5>
                            </div>
                            <div class="card-body">
                                <span class="text-muted fw-500">{{ $getorderdata->notes }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($getorderdata->vendor_note != '')
                <div class="row pt-3">
                    <div class="col-12">
                        <div class="mn-3 card rounded-4 shadow-sm border-0 h-100  p-3">
                            <div class="card-header bg-white px-0 pt-0">
                                <h5 class="m-0">{{ trans('labels.vendor') }}
                                    {{ trans('labels.notes') }}</h5>
                            </div>
                            <div class="card-body px-0 pb-0">
                                <span class="text-muted fw-500">{{ $getorderdata->vendor_note }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row pt-3 g-3">
                <div class="col-xl-4 col-md-6">
                    <div class="card rounded-4 shadow border-0 h-100">
                        <div class="card-header bg-transparent border-bottom p-3">
                            <h5 class="m-0 color-changer">{{ trans('labels.personal_info') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-lg-flex justify-content-between align-items-center">
                                <ul class="list-group w-100 list-group-flush py-0 service-list">
                                    <li class="list-group-item border-0 fs-7 fw-500 px-0 bg-transparent">
                                        <span class="color-changer">
                                            {{ trans('labels.name') }} :
                                            {{ $getorderdata->user_name }}
                                        </span>
                                    </li>
                                    <li class="list-group-item border-0 fs-7 fw-500 px-0 bg-transparent">
                                        <span class="color-changer">
                                            {{ trans('labels.email') }} :
                                            {{ $getorderdata->user_email }}
                                        </span>
                                    </li>
                                    <li class="list-group-item border-0 fs-7 fw-500 px-0 bg-transparent">
                                        <span class="color-changer">
                                            {{ trans('labels.mobile') }} :
                                            {{ $getorderdata->user_mobile }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card rounded-4 shadow border-0 h-100">
                        <div class="card-header bg-transparent border-bottom p-3">
                            <h5 class="m-0 color-changer">{{ trans('labels.billing_address') }}</h5>
                        </div>
                        <div class="card-body">
                            <span class="pb-2 d-block fs-7 fw-500 color-changer">
                                {{ trans('labels.address') }} :
                                {{ $getorderdata->address }}
                            </span>
                            <span class="pb-2 d-block fs-7 fw-500 color-changer">
                                {{ trans('labels.landmark') }} :
                                {{ $getorderdata->landmark }}
                            </span>
                            <span class="pb-2 d-block fs-7 fw-500 color-changer">
                                {{ trans('labels.postal_code') }} :
                                {{ $getorderdata->postal_code }}
                            </span>
                            <span class="pb-2 d-block fs-7 fw-500 color-changer">
                                {{ trans('labels.city') }} :
                                {{ $getorderdata->city }}
                            </span>
                            <span class="pb-2 d-block fs-7 fw-500 color-changer">
                                {{ trans('labels.state') }} :
                                {{ $getorderdata->state }}
                            </span>
                            <span class="pb-2 d-block fs-7 fw-500 color-changer">
                                {{ trans('labels.country') }} :
                                {{ $getorderdata->country }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card rounded-4 shadow border-0 h-100">
                        <div class="card-header bg-transparent border-bottom p-3">
                            <h5 class="m-0 color-changer">{{ trans('labels.payment_details') }}</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 pt-0 fs-7 d-flex justify-content-between">
                                    <span class="text-dark color-changer fw-500">{{ trans('labels.payment_type') }}
                                        :</span>
                                    <span class="text-dark color-changer fw-500">
                                        {{ @helper::getpayment($getorderdata->transaction_type, $vendordata->id)->payment_name }}
                                        @if ($getorderdata->transaction_type == 6)
                                            : <small>
                                                <a href="{{ helper::image_path($getorderdata->screenshot) }}"
                                                    target="_blank" class="text-danger">
                                                    {{ trans('labels.click_here') }}
                                                </a>
                                            </small>
                                        @endif
                                    </span>
                                </li>
                                @if (@helper::checkaddons('vendor_tip'))
                                    @if (@helper::otherappdata($vendordata->id)->tips_on_off == 1)
                                        <li class="list-group-item px-0 fs-7 d-flex flex-wrap justify-content-between">
                                            <span class="text-dark color-changer fw-500">{{ trans('labels.tips_pro') }}
                                                :</span>
                                            <span class="text-dark color-changer fw-500">
                                                {{ helper::currency_formate($getorderdata->tips, $vendordata->id) }}
                                            </span>
                                        </li>
                                    @endif
                                @endif
                                @if (!empty($getorderdata->transaction_id))
                                    <li class="list-group-item px-0 fs-7 d-flex flex-wrap justify-content-between">
                                        <span class="text-dark color-changer fw-500">{{ trans('labels.payment_id') }}
                                            :</span>
                                        <span class="text-dark color-changer fw-500">
                                            {{ $getorderdata->transaction_id }}
                                        </span>
                                    </li>
                                @endif
                                <li class="list-group-item px-0 d-flex justify-content-between border-0">
                                    <span class="text-dark color-changer fs-7 fw-500"> {{ trans('labels.subtotal') }}
                                        :</span>
                                    <span
                                        class="text-dark color-changer fs-7 fw-500">{{ helper::currency_formate($getorderdata->sub_total, $vendordata->id) }}</span>
                                </li>
                                @if ($getorderdata->offer_amount > 0)
                                    <li class="list-group-item px-0 d-flex justify-content-between border-0">
                                        <span class="text-dark color-changer fs-7 fw-500">{{ trans('labels.discount') }}
                                            ({{ $getorderdata->offer_code }})
                                            :</span>
                                        <span class="text-dark color-changer fs-7 fw-500">–
                                            {{ helper::currency_formate($getorderdata->offer_amount, $vendordata->id) }}</span>
                                    </li>
                                @endif
                                @if ($getorderdata->tax_amount != null && $getorderdata->tax_amount != '')
                                    @php
                                        $tax_amount = explode('|', $getorderdata->tax_amount);
                                        $tax_name = explode('|', $getorderdata->tax_name);
                                    @endphp
                                    @foreach ($tax_amount as $key => $tax_value)
                                        <li class="list-group-item px-0 d-flex justify-content-between border-0">
                                            <span class="text-dark color-changer fs-7 fw-500">{{ $tax_name[$key] }}
                                                :</span>
                                            <span
                                                class="text-dark color-changer fs-7 fw-500">{{ helper::currency_formate($tax_value, $vendordata->id) }}</span>
                                        </li>
                                    @endforeach
                                @endif
                                <li class="list-group-item px-0 d-flex justify-content-between border-0">
                                    <span class="text-dark color-changer fs-7 fw-500">{{ trans('labels.delivery') }}
                                        @if ($getorderdata->shipping_area != '')
                                            ({{ $getorderdata->shipping_area }})
                                        @endif
                                        :
                                    </span>
                                    <span class="text-dark color-changer fs-7 fw-500">
                                        @if ($getorderdata->delivery_charge > 0)
                                            {{ helper::currency_formate($getorderdata->delivery_charge, $vendordata->id) }}
                                        @else
                                            {{ trans('labels.free') }}
                                        @endif
                                    </span>
                                </li>
                                <li
                                    class="list-group-item px-0 pb-0 pt-3 d-flex justify-content-between border-0 text-success border-top">
                                    <span class="fs-16 fw-600">{{ trans('labels.grand_total') }} :</span>
                                    <span
                                        class="fs-16 fw-600">{{ helper::currency_formate($getorderdata->grand_total, $vendordata->id) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- buttons -->
            @if ($getorderdata->status_type == 1 || $getorderdata->status_type == 2)
                <div class="btn-gc d-flex gap-2 flex-wrap align-items-between justify-content-lg-end mt-4">
                    <!-- whatsapp button -->
                    @if (@helper::checkaddons('subscription'))
                        @if (@helper::checkaddons('whatsapp_message'))
                            @php
                                $checkplan = App\Models\Transaction::where('vendor_id', $vdata)
                                    ->orderByDesc('id')
                                    ->first();

                                if (@$user->allow_without_subscription == 1) {
                                    $whatsapp_message = 1;
                                } else {
                                    $whatsapp_message = @$checkplan->whatsapp_message;
                                }
                            @endphp
                            @if ($whatsapp_message == 1 && @whatsapp_helper::whatsapp_message_config($vendordata->id)->product_order_created == 1)
                                @if (whatsapp_helper::whatsapp_message_config($vendordata->id)->message_type == 2)
                                    <a href="https://api.whatsapp.com/send?phone={{ @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number }}&text={{ $whmessage }}"
                                        class="btn btn-whatsaap btn-submit rounded m-0 d-flex gap-1 align-items-center"
                                        target="_blank">
                                        <i class="fab fa-whatsapp"></i>{{ trans('labels.whatsapp_message') }}
                                    </a>
                                @endif
                            @endif
                        @endif
                    @else
                        @if (@helper::checkaddons('whatsapp_message'))
                            @if (@whatsapp_helper::whatsapp_message_config($vendordata->id)->product_order_created == 1)
                                @if (whatsapp_helper::whatsapp_message_config($vendordata->id)->message_type == 2)
                                    <a href="https://api.whatsapp.com/send?phone={{ @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number }}&text={{ $whmessage }}"
                                        class="btn btn-whatsaap btn-submit rounded m-0 d-flex gap-1 align-items-center"
                                        target="_blank">
                                        <i class="fab fa-whatsapp"></i>{{ trans('labels.whatsapp_message') }}
                                    </a>
                                @endif
                            @endif
                        @endif
                    @endif
                    <!-- telegram button -->
                    @if (@helper::checkaddons('subscription'))
                        @if (@helper::checkaddons('telegram_message'))
                            @php
                                $checkplan = App\Models\Transaction::where('vendor_id', $vdata)
                                    ->orderByDesc('id')
                                    ->first();

                                if (@$user->allow_without_subscription == 1) {
                                    $telegram_message = 1;
                                } else {
                                    $telegram_message = @$checkplan->telegram_message;
                                }
                            @endphp
                            @if ($telegram_message == 1 && @helper::telegramdata($vendordata->id)->product_order_created == 1)
                                <a href="{{ URL::to($vendordata->slug . '/ordertelegram/' . $getorderdata->order_number . '') }}"
                                    class="btn btn-telegram btn-submit rounded m-0 d-flex gap-1 align-items-center">
                                    <i class="fab fa-telegram"></i>{{ trans('labels.telegram_message') }}
                                </a>
                            @endif
                        @endif
                    @else
                        @if (@helper::checkaddons('telegram_message'))
                            @if (@helper::telegramdata($vendordata->id)->product_order_created == 1)
                                <a href="{{ URL::to($vendordata->slug . '/ordertelegram/' . $getorderdata->order_number . '') }}"
                                    class="btn btn-telegram btn-submit rounded m-0 d-flex gap-1 align-items-center">
                                    <i class="fab fa-telegram"></i>{{ trans('labels.telegram_message') }}
                                </a>
                            @endif
                        @endif
                    @endif
                    <!-- cancel order button -->
                    @if (@helper::checkaddons('custom_status'))
                        @if ($getorderdata->status_type == 1)
                            <button
                                onclick="statusupdate('{{ URL::to($vendordata->slug . '/order/status_change-' . $getorderdata->order_number . '/4') }}')"
                                class="btn btn-danger text-white btn-submit rounded m-0 d-flex gap-1 align-items-center">
                                <i class="fa-regular fa-trash-can"></i>
                                {{ trans('labels.cancel_order') }}
                            </button>
                        @endif
                    @endif
                </div>
            @endif
            <!-- buttons -->
            <!-- question box start -->
            <div class="card border p-4 p-sm-5 rounded-4 mt-4 mb-5 extra-margins">
                <div class="row g-3 g-xl-4 align-items-center">
                    <div class="col-xl-8">
                        <!-- Title -->
                        <div class="d-sm-flex gap-2 align-items-center mb-2">
                            <h3 class="mb-2 mb-sm-0 fs-1 color-changer fw-bold">{{ trans('labels.still_have_question') }}
                            </h3>
                            <!-- Avatar group -->
                            @if (count($reviewimage) > 0)
                                <ul class="avatar-group mb-0 ms-sm-3">
                                    @foreach ($reviewimage as $image)
                                        <li class="avatar avatar-sm">
                                            <img class="avatar-img rounded-circle"
                                                src="{{ helper::image_path($image->image) }}" alt="avatar">
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <p class="mb-0 text-muted fs-15">{{ trans('labels.footer_message') }}</p>
                    </div>
                    <!-- Content and input -->
                    <div class="col-xl-4 {{ session()->get('direction') == 2 ? 'text-xl-start' : 'text-xl-end' }}">
                        <a href="{{ URL::to($vendordata->slug . '/contact') }}"
                            class="btn btn-primary mb-0  btn-submit rounded">
                            <div class="d-flex gap-2 align-items-center">
                                {{ trans('labels.contactus') }}<i
                                    class="fa-solid {{ session()->get('direction') == 2 ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                            </div>
                        </a>
                    </div>
                </div> <!-- Row END -->
            </div>
            <!-- question box end -->
        </div>
    </section>
@endsection
