@extends('front.layout.master')
@php
    $user = App\Models\User::where('id', $vdata)->first();
@endphp
@section('content')
    <div class="container mb-2">
        <div class="breadcrumb-div pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL::to($vendordata->slug) }}" class="text-primary-color"><i
                                class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>{{ trans('labels.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">{{ trans('labels.booking_details') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <section class="booking-detail mb-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h2 class="section-title fw-bold">{{ trans('labels.booking_details') }}</h2>
                @if (@helper::checkaddons('custom_status'))
                    <div class="btn btn-pbtn btn-primary-rgb btn-submit px-5 rounded">
                        {{ @helper::gettype($booking_detail->status, $booking_detail->status_type, $vendordata->id, 1)->name == null ? '-' : @helper::gettype($booking_detail->status, $booking_detail->status_type, $vendordata->id, 1)->name }}
                    </div>
                @endif
            </div>
            <div class="card border-0 rounded-4 bg-white shadow">
                <div class="card-body">
                    <div class="row justify-content-between flex-wrap">
                        <div class="col-lg-12">
                            <ul class="list-group list-group-flush py-0 service-list">
                                <li class="list-group-item px-0 bg-transparent border-0">
                                    @php
                                        $category = helper::getcategoryinfo(
                                            $getservice->category_id,
                                            $getservice->vendor_id,
                                        );
                                    @endphp
                                    <span class="badge text-bg-dark">{{ $category[0]->name }}</span>
                                </li>
                                <li class="list-group-item px-0 bg-transparent border-0">
                                    <h5 class="fw-600 m-0 color-changer">{{ $getservice->name }}</h5>
                                </li>

                                <li class="list-group-item px-0 bg-transparent border-0">
                                    <span class="fw-bold d-inline-block color-changer fs-6 fw-600">
                                        {{ trans('labels.price') }} : </span>
                                    <h6 class="text-break fw-600 d-inline-block m-0 color-changer">
                                        {{ helper::currency_formate($booking_detail->sub_total, $booking_detail->vendor_id) }}
                                    </h6>
                                </li>
                            </ul>
                            <!-- additional_service -->
                            @if (@helper::checkaddons('additional_service'))
                                @if ($booking_detail->additional_service_id != null && $booking_detail->additional_service_id != '')
                                    @php
                                        $price = $booking_detail->additional_service_price;
                                        $name = $booking_detail->additional_service_name;
                                        $image = $booking_detail->additional_service_image;

                                        $add_service_price = explode('|', $price);
                                        $add_service_name = explode('|', $name);
                                        $add_service_image = explode('|', $image);
                                    @endphp
                                    <div class="row g-3 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 p-2">
                                        @foreach ($add_service_name as $key => $additional_service_name)
                                            <div
                                                class="col fw-bolder d-flex align-items-center staff-checked position-relative">
                                                <input class="form-check-input position-absolute end-10 d-none"
                                                    type="" data-staffname="additional_service"
                                                    id="additional_service_{{ $key }}"
                                                    name="select_additional_service">
                                                <label for="additional_service_{{ $key }}"
                                                    class="d-flex align-items-center p-2 rounded-3 form-control additional_services_card pointer">
                                                    <div class="d-flex gap-3 w-100 align-items-center fw-500">
                                                        <img src="{{ helper::image_path($add_service_image[$key]) }}"
                                                            width="70" height="70" class="rounded-3" alt="">
                                                        <div>
                                                            <p class="mb-1 fw-600 line-2 color-changer">
                                                                {{ $additional_service_name }}
                                                            </p>
                                                            <p
                                                                class="d-flex align-items-center color-changer flex-wrap fw-500 m-0 gap-2">
                                                                {{ helper::currency_formate($add_service_price[$key], $vendordata->id) }}

                                                            </p>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            @if ($booking_detail->booking_notes != null && $booking_detail->booking_notes != '')
                <div class="row pt-3">
                    <div class="col-12">
                        <div class="card rounded-4 shadow border-0 h-100">
                            <div class="card-header bg-transparent border-bottom p-3">
                                <h5 class="m-0 color-changer">{{ trans('labels.message') }}</h5>
                            </div>
                            <div class="card-body">
                                <span class="text-muted fw-500">{{ $booking_detail->booking_notes }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if ($booking_detail->vendor_note != null && $booking_detail->vendor_note != '')
                <div class="row pt-3">
                    <div class="col-12">
                        <div class="card rounded-4 shadow border-0 h-100">
                            <div class="card-header bg-transparent border-bottom p-3">
                                <h5 class="m-0 color-changer">{{ trans('labels.vendor') }}
                                    {{ trans('labels.message') }}</h5>
                            </div>
                            <div class="card-body">
                                <span class="text-muted fw-500">{{ $booking_detail->vendor_note }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row g-3 py-3">
                <!-- Provider details -->
                <div class="col-xl-3 col-md-6">
                    <div class="card rounded-4 shadow border-0 h-100">
                        <div class="card-header bg-transparent border-bottom p-3">
                            <h5 class="m-0 color-changer">{{ trans('labels.provider_details') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-lg-flex justify-content-between align-items-center">
                                <ul class="list-group list-group-flush py-0 service-list">
                                    <li class="list-group-item border-0 fs-7 fw-500 px-0 bg-transparent">
                                        <span class="color-changer">{{ trans('labels.name') }} :
                                            {{ $vendordata->name }}</span>
                                    </li>
                                    <li class="list-group-item border-0 fs-7 fw-500 px-0 bg-transparent">
                                        <span class="color-changer">{{ trans('labels.email') }} :
                                            {{ $vendordata->email }}</span>
                                    </li>
                                    <li class="list-group-item border-0 fs-7 fw-500 px-0 bg-transparent">
                                        <span class="color-changer">{{ trans('labels.mobile') }} :
                                            {{ $vendordata->mobile }}</span>
                                    </li>

                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('employee'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vendordata->id)
                                                    ->orderByDesc('id')
                                                    ->first();

                                                if ($vendordata->allow_without_subscription == 1) {
                                                    $employee = 1;
                                                } else {
                                                    $employee = @$checkplan->employee;
                                                }
                                            @endphp
                                            @if ($employee == 1)
                                                @if ($booking_detail->staff_id != '' && $booking_detail->staff_id != null)
                                                    <li class="list-group-item fs-7 fw-500 border-0 px-0 bg-transparent">
                                                        <span class="color-changer">{{ trans('labels.staff_member') }}
                                                            :
                                                            {{ @helper::getslug($booking_detail->staff_id)->name }}</span>
                                                    </li>
                                                @endif
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('employee'))
                                            @if ($booking_detail->staff_id != '' && $booking_detail->staff_id != null)
                                                <li class="list-group-item fs-7 fw-500 px-0 border-0 bg-transparent">
                                                    <span class="color-changer">{{ trans('labels.staff_member') }}
                                                        :
                                                        {{ @helper::getslug($booking_detail->staff_id)->name }}</span>
                                                </li>
                                            @endif
                                        @endif
                                    @endif

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Provider details -->
                <div class="col-xl-3 col-md-6">
                    <div class="card rounded-4 shadow border-0 h-100">
                        <div class="card-header bg-transparent border-bottom p-3">
                            <h5 class="m-0 color-changer">{{ trans('labels.date_time') }}</h5>
                        </div>
                        <div class="card-body">
                            <span class="list-group-item fs-7 border-0 pb-2 d-flex justify-content-between"><span
                                    class="fw-500 color-changer">{{ trans('labels.date') }} :</span>
                                <span class="text-dark fs-7 fw-500 color-changer">{{ $booking_detail->booking_date }}
                                    <br>
                                    {{ $booking_detail->booking_time }} -
                                    {{ $booking_detail->booking_endtime }}</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card rounded-4 shadow border-0 h-100">
                        <div class="card-header bg-transparent border-bottom p-3">
                            <h5 class="m-0 color-changer">{{ trans('labels.address') }}</h5>
                        </div>
                        <div class="card-body">
                            <span class="pb-2 d-block fs-7 fw-500 color-changer">{{ trans('labels.address') }} : </span>
                            <span class="text-dark color-changer fs-7 fw-500">
                                {{ $booking_detail->address . ',' . $booking_detail->landmark . ',' . $booking_detail->postalcode . ',' . $booking_detail->city . ',' . $booking_detail->state . ',' . $booking_detail->country . '.' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card rounded-4 shadow border-0 h-100">
                        <div class="card-header bg-transparent border-bottom p-3">
                            <h5 class="m-0 color-changer">{{ trans('labels.payment_details') }}</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @if ($booking_detail->payment_status == 2)
                                    <li class="list-group-item px-0 fs-7 d-flex justify-content-between">
                                        <span class="text-dark color-changer fw-500">{{ trans('labels.payment_type') }}
                                            :</span>
                                        <span class="text-dark color-changer fw-500">
                                            {{ @helper::getpayment($booking_detail->transaction_type, $vendordata->id)->payment_name }}
                                        </span>
                                    </li>
                                    @if (!empty($booking_detail->transaction_id))
                                        <li class="list-group-item px-0 fs-7 d-flex flex-wrap justify-content-between">
                                            <span class="text-dark color-changer fw-500">{{ trans('labels.payment_id') }}
                                                :</span>
                                            <span class="text-dark color-changer fw-500">
                                                {{ $booking_detail->transaction_id }}
                                            </span>
                                        </li>
                                    @endif
                                @endif
                                <li class="list-group-item px-0 fs-7 d-flex justify-content-between">
                                    <span class="text-dark color-changer fw-500">{{ trans('labels.tips_pro') }}
                                        :</span>
                                    <span class="text-dark color-changer fw-500">
                                        {{ helper::currency_formate($booking_detail->tips, $booking_detail->vendor_id) }}
                                    </span>
                                </li>
                                <li class="list-group-item px-0 d-flex justify-content-between border-0">
                                    <span class="text-dark color-changer fs-7 fw-500">{{ trans('labels.price') }}
                                        :</span>
                                    <span
                                        class="text-dark color-changer fs-7 fw-500">{{ helper::currency_formate($booking_detail->sub_total, $booking_detail->vendor_id) }}</span>
                                </li>
                                @if ($booking_detail->additional_service_price != '' && $booking_detail->additional_service_price != null)
                                    @php
                                        $add_service_price = 0;
                                        $add_price = explode('|', $booking_detail->additional_service_price);
                                        foreach ($add_price as $price) {
                                            $add_service_price += (float) $price;
                                        }

                                    @endphp
                                    <li class="list-group-item px-0 d-flex justify-content-between border-0">
                                        <span
                                            class="text-dark color-changer fs-7 fw-500">{{ trans('labels.additional_service') }}
                                            :</span>
                                        <span
                                            class="text-dark color-changer fs-7 fw-500">{{ helper::currency_formate($add_service_price, $booking_detail->vendor_id) }}</span>
                                    </li>
                                @endif
                                @if ($booking_detail->tax != null && $booking_detail->tax != '')
                                    @php
                                        $tax = explode('|', $booking_detail->tax);
                                        $tax_name = explode('|', $booking_detail->tax_name);
                                    @endphp

                                    @foreach ($tax as $key => $tax_value)
                                        <li class="list-group-item px-0 d-flex justify-content-between border-0">
                                            <span class="text-dark color-changer fs-7 fw-500">{{ $tax_name[$key] }}
                                                :</span>
                                            <span
                                                class="text-dark color-changer fs-7 fw-500">{{ helper::currency_formate((float) $tax[$key], $booking_detail->vendor_id) }}</span>
                                        </li>
                                    @endforeach
                                @endif
                                @if ($booking_detail->offer_amount > 0)
                                    <li class="list-group-item px-0 d-flex justify-content-between border-0">
                                        <span class="text-dark color-changer fs-7 fw-500">{{ trans('labels.discount') }}
                                            :</span>
                                        <span
                                            class="text-dark color-changer fs-7 fw-500">-{{ helper::currency_formate($booking_detail->offer_amount, $booking_detail->vendor_id) }}
                                        </span>
                                    </li>
                                @endif
                                <li
                                    class="list-group-item px-0 pb-0 pt-3 d-flex justify-content-between border-0 text-success border-top">
                                    <span class="fs-16 fw-600">{{ trans('labels.total') }}
                                        {{ trans('labels.amount') }}:</span>
                                    <span
                                        class="fs-16 fw-600">{{ helper::currency_formate($booking_detail->grand_total, $booking_detail->vendor_id) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @if (helper::allpaymentcheckaddons($vendordata->id))
                @if ($booking_detail->payment_status == 1 && $booking_detail->grand_total != 0 && $booking_detail->status_type != '4')
                    @if ($booking_detail->transaction_type == 6 && $booking_detail->payment_status == 1)
                        {{ trans('messages.payment_in_progress') }}
                    @else
                        <div class="card rounded-4 shadow border-0 h-100">
                            <div class="card-header bg-transparent border-bottom p-3">
                                <h5 class="m-0 color-changer">{{ trans('labels.payment_type') }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="row pb-3 g-3" id="paynow">
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
                                                    class="d-flex align-items-center py-4 rounded-4 form-control bg-light pointer">
                                                    <div class="payment-gateway d-flex align-items-center fw-500">
                                                        <img src="{{ helper::image_path($payment->image) }}"
                                                            width="30" height="30" class="mx-3"alt=""
                                                            srcset="">
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
                                @if ($getpayment->count() > 0)
                                    <div class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                                        <button onclick="Paymentgetway()" id="booking_payment"
                                            class="btn btn-primary btn-submit rounded">{{ trans('labels.pay_now') }}</button>
                                        <button id="booking_loader" disabled
                                            class="btn btn-lg btn-primary btn-submit rounded d-none">
                                            <div class="load showload"></div>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endif
            @endif
            @if ($booking_detail->status_type == 1 || $booking_detail->payment_status == 2)
                <!-- buttons -->
                <div class="btn-gc d-flex gap-2 flex-wrap align-items-between justify-content-lg-end mt-4">

                    @if ($booking_detail->status_type == 1 || $booking_detail->status_type == 2)
                         @if (@helper::checkaddons('ical_export'))       
                            <a href="{{ URL::to($vendordata->slug . '/icalfile-' . $booking_detail->booking_number . '/' . $vendordata->id . '/2') }}" class="btn btn-ical btn-submit rounded"><i class="fab fa-duotone fa-download {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>{{ trans('labels.download_ical_file') }}</a>
                        @endif
                                            
                        @if (@helper::checkaddons('subscription'))
                            @if (@helper::checkaddons('google_calendar'))
                                @php
                                    $checkplan = App\Models\Transaction::where('vendor_id', $vdata)
                                        ->orderByDesc('id')
                                        ->first();
                                    if (@$user->allow_without_subscription == 1) {
                                        $calendar = 1;
                                    } else {
                                        $calendar = @$checkplan->calendar;
                                    }
                                @endphp
                                @if ($calendar == 1)
                                    <a href="{{ URL::to($vendordata->slug . '/googlesync-' . $booking_detail->booking_number . '/' . $vendordata->id . '/2') }}"
                                        class="btn btn-danger btn-submit rounded"><i
                                            class="fab fa-duotone fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>{{ trans('labels.google_calendar') }}</a>
                                @endif
                            @endif
                        @else
                            @if (@helper::checkaddons('google_calendar'))
                                <a href="{{ URL::to($vendordata->slug . '/googlesync-' . $booking_detail->booking_number . '/' . $vendordata->id . '/2') }}"
                                    class="btn btn-danger btn-submit rounded"><i
                                        class="fab fa-duotone fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>{{ trans('labels.google_calendar') }}</a>
                            @endif
                        @endif
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
                                @if ($whatsapp_message == 1 && @whatsapp_helper::whatsapp_message_config($vendordata->id)->order_created == 1)
                                    @if (whatsapp_helper::whatsapp_message_config($vendordata->id)->message_type == 2)
                                        <a href="https://api.whatsapp.com/send?phone={{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number }}&text={{ $whmessage }}"
                                            class="btn btn-whatsaap btn-submit rounded m-0" target="_blank">
                                            <i
                                                class="fab fa-whatsapp {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>{{ trans('labels.whatsapp_message') }}</a>
                                    @endif
                                @endif
                            @endif
                        @else
                            @if (@helper::checkaddons('whatsapp_message'))
                                @if (@whatsapp_helper::whatsapp_message_config($vendordata->id)->order_created == 1)
                                    @if (whatsapp_helper::whatsapp_message_config($vendordata->id)->message_type == 2)
                                        <a href="https://api.whatsapp.com/send?phone={{ whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number }}&text={{ $whmessage }}"
                                            class="btn btn-whatsaap btn-submit rounded m-0" target="_blank">
                                            <i
                                                class="fab fa-whatsapp {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>{{ trans('labels.whatsapp_message') }}</a>
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
                                @if ($telegram_message == 1 && @helper::telegramdata($vendordata->id)->order_created == 1)
                                    <a href="{{ URL::to($vendordata->slug . '/telegram/' . $booking_detail->booking_number . '') }}"
                                        class="btn btn-telegram btn-submit rounded m-0">
                                        <i
                                            class="fab fa-telegram {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>{{ trans('labels.telegram_message') }}</a>
                                @endif
                            @endif
                        @else
                            @if (@helper::checkaddons('telegram_message'))
                                @if (@helper::telegramdata($vendordata->id)->order_created == 1)
                                    <a href="{{ URL::to($vendordata->slug . '/telegram/' . $booking_detail->booking_number . '') }}"
                                        class="btn btn-telegram btn-submit rounded m-0">
                                        <i
                                            class="fab fa-telegram {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>{{ trans('labels.telegram_message') }}</a>
                                @endif
                            @endif
                        @endif

                    @endif
                    @if (@helper::checkaddons('custom_status'))
                        @if ($booking_detail->status_type == 1)
                            <!-- cancel booking button -->
                            <button
                                onclick="statusupdate('{{ URL::to($vendordata->slug . '/status_change-' . $booking_detail->booking_number . '/4') }}')"
                                class="btn btn-danger text-white btn-submit rounded m-0">
                                <i
                                    class="fa-regular fa-trash-can {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>
                                {{ trans('labels.cancel_booking') }}</button>
                        @endif
                    @endif
                </div>
                <!-- buttons -->
            @endif
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

    <input type="hidden" value="{{ trans('messages.payment_selection_required') }}" name="paymentmode_message"
        id="paymentmode_message">
    <input type="hidden" name="vendor_id" id="vendor_id" value="{{ $booking_detail->vendor_id }}">
    <input type="hidden" name="price" id="price" value="{{ $booking_detail->grand_total }}">
    <input type="hidden" name="tips" id="tips" value="{{ $booking_detail->tips }}">
    <input type="hidden" name="booking_number" id="booking_number" value="{{ $booking_detail->booking_number }}">
    <input type="hidden" name="customer_name" id="customer_name" value="{{ $booking_detail->customer_name }}">
    <input type="hidden" name="customer_email" id="customer_email" value="{{ $booking_detail->email }}">
    <input type="hidden" name="customer_mobile" id="customer_mobile" value="{{ $booking_detail->mobile }}">
    <input type="hidden" name="url" id="url" value="{{ URL::to($vendordata->slug . '/payment') }}">
    <input type="hidden" name="success_url" id="success_url"
        value="{{ URL::to($vendordata->slug . '/booking/' . $booking_detail->booking_number) }}">
    <input type="hidden" name="mercado_url" id="mercado_url"
        value="{{ URL::to('/' . $vendordata->slug) . '/mercadoorder-' . $booking_detail->booking_number }}">

    <input type="hidden" name="paypal_url" id="paypal_url"
        value="{{ URL::to('/' . $vendordata->slug) . '/paypalrequest-' . $booking_detail->booking_number }}">

    <input type="hidden" name="myfatoorah_url" id="myfatoorah_url"
        value="{{ URL::to('/' . $vendordata->slug) . '/myfatoorahrequest-' . $booking_detail->booking_number }}">

    <input type="hidden" name="toyyibpay_url" id="toyyibpay_url"
        value="{{ URL::to('/' . $vendordata->slug) . '/toyyibpayrequest-' . $booking_detail->booking_number }}">

    <input type="hidden" name="paytab_url" id="paytab_url"
        value="{{ URL::to('/' . $vendordata->slug) . '/paytabrequest-' . $booking_detail->booking_number }}">

    <input type="hidden" name="mercado_successurl" id="mercado_successurl"
        value="{{ URL::to('/' . $vendordata->slug) . '/mercadoordersuccess' }}">

    <input type="hidden" name="phonepe_url" id="phonepe_url"
        value="{{ URL::to('/' . $vendordata->slug) . '/phoneperequest-' . $booking_detail->booking_number }}">

    <input type="hidden" name="mollie_url" id="mollie_url"
        value="{{ URL::to('/' . $vendordata->slug) . '/mollierequest-' . $booking_detail->booking_number }}">

    <input type="hidden" name="khalti_url" id="khalti_url"
        value="{{ URL::to('/' . $vendordata->slug) . '/khaltirequest-' . $booking_detail->booking_number }}">

    <input type="hidden" name="xendit_url" id="xendit_url"
        value="{{ URL::to('/' . $vendordata->slug) . '/xenditrequest-' . $booking_detail->booking_number }}">

    <form action="{{ URL::to('/' . $vendordata->slug) . '/paypalrequest-' . $booking_detail->booking_number }}"
        method="post" class="d-none">
        {{ csrf_field() }}
        <input type="hidden" name="return" value="2">
        <input type="submit" class="callpaypal" name="submit">
    </form>

@endsection

@section('scripts')
    <script>
        var price = parseFloat($("#price").val()) + parseFloat($("#tips").val());
        var booking_number = $("#booking_number").val();
        var purchase_url = $("#url").val();
        var success_url = $("#success_url").val();
        var payment_id = "";
        var stripe_secret_key = $("#stripe_secret_key").val();
        var customer_name = $("#customer_name").val();
        var customer_email = $("#customer_email").val();
        var customer_mobile = $("#customer_mobile").val();
        var mercado_url = $("#mercado_url").val();
        var myfatoorah_url = $("#myfatoorah_url").val();
        var toyyibpay_url = $("#toyyibpay_url").val();
        var paytab_url = $("#paytab_url").val();
        var paypal_url = $("#paypal_url").val();
        var vendor_id = $("#vendor_id").val();
        var mercado_successurl = $("#mercado_successurl").val();
        var phonepe_url = $("#phonepe_url").val();
        var mollie_url = $("#mollie_url").val();
        var khalti_url = $("#khalti_url").val();
        var xendit_url = $("#xendit_url").val();
    </script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script> {{-- Razorpay --}}
    <script src="https://js.stripe.com/v3/"></script> {{-- Stripe --}}
    <script src="https://js.paystack.co/v1/inline.js"></script> {{--  Paystack --}}
    <script src="https://checkout.flutterwave.com/v3.js"></script> {{-- Flutterwave --}}
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/booking.js') }}"></script>
@endsection
