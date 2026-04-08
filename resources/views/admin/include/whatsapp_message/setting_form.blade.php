@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12 p-0">
                <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="business-api-tab" data-bs-toggle="tab"
                            data-bs-target="#business-api" type="button" role="tab" aria-controls="message"
                            aria-selected="true">{{ trans('labels.whatsapp_business_api') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="booking-tab" data-bs-toggle="tab" data-bs-target="#booking"
                            type="button" role="tab" aria-controls="labels"
                            aria-selected="false">{{ trans('labels.whatsapp_booking_message') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="booking-status-message-tab" data-bs-toggle="tab"
                            data-bs-target="#booking-status-message" type="button" role="tab" aria-controls="message"
                            aria-selected="false">{{ trans('labels.booking_status_update') }}</button>
                    </li>
                    @if (@helper::checkaddons('product_shop'))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="order-tab" data-bs-toggle="tab" data-bs-target="#order"
                                type="button" role="tab" aria-controls="labels"
                                aria-selected="false">{{ trans('labels.whatsapp_order_message') }}</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="order-status-message-tab" data-bs-toggle="tab"
                                data-bs-target="#order-status-message" type="button" role="tab" aria-controls="message"
                                aria-selected="false">{{ trans('labels.order_status_update') }}</button>
                        </li>
                    @endif
                </ul>
                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="business-api" role="tabpanel"
                        aria-labelledby="business-api-tab">
                        <div class="card border-0 box-shadow">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form action="{{ URL::to('admin/settings/business_api') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ trans('labels.whatsapp_number') }}
                                                        <span class="text-danger"> * </span></label>
                                                    <input type="text" class="form-control numbers_only"
                                                        name="whatsapp_number"
                                                        value="{{ @whatsapp_helper::whatsapp_message_config($vendor_id)->whatsapp_number }}"
                                                        placeholder="{{ trans('labels.whatsapp_number') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ trans('labels.message_type') }}
                                                        <span class="text-danger"> * </span></label>
                                                    <select class="form-select" name="message_type" required>
                                                        <option value="">{{ trans('labels.select') }}</option>
                                                        <option value="1"
                                                            {{ @whatsapp_helper::whatsapp_message_config($vendor_id)->message_type == '1' ? 'selected' : '' }}>
                                                            {{ trans('labels.automatic_using_api') }}</option>
                                                        <option value="2"
                                                            {{ @whatsapp_helper::whatsapp_message_config($vendor_id)->message_type == '2' ? 'selected' : '' }}>
                                                            {{ trans('labels.manually') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label
                                                        class="form-label">{{ trans('labels.whatsapp_phone_number_id') }}
                                                        <span class="text-danger"> * </span></label>
                                                    <input type="text" class="form-control"
                                                        name="whatsapp_phone_number_id"
                                                        value="{{ @whatsapp_helper::whatsapp_message_config($vendor_id)->whatsapp_phone_number_id }}"
                                                        placeholder="{{ trans('labels.whatsapp_phone_number_id') }}"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ trans('labels.whatsapp_access_token') }}
                                                        <span class="text-danger"> * </span></label>
                                                    <input type="text" class="form-control"
                                                        name="whatsapp_access_token"
                                                        value="{{ @whatsapp_helper::whatsapp_message_config($vendor_id)->whatsapp_access_token }}"
                                                        placeholder="{{ trans('labels.whatsapp_access_token') }}"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div
                                                class="form-group {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                                <button
                                                    class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_whatsapp_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="about_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="booking" role="tabpanel" aria-labelledby="booking-tab">
                        <div class="card border-0 box-shadow">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form action="{{ URL::to('admin/settings/order_message_update') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="text-center text-dark color-changer">
                                                    {{ trans('labels.booking_variable') }}
                                                </h5>
                                                <hr class="my-2">
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.booking_no') }} :
                                                    <code>{booking_no}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.service_name') }}
                                                    :
                                                    <code>{service_name}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.subtotal') }}
                                                    :
                                                    <code>{sub_total}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">{{ trans('labels.total') }}
                                                    {{ trans('labels.tax') }} : <code>{total_tax}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.offer_code') }} :
                                                    <code>{offer_code}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.discount') }}
                                                    {{ trans('labels.amount') }} : <code>{discount_amount}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.grand_total') }} :
                                                    <code>{grand_total}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.payment_status') }}:
                                                    <code>{payment_status}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.payment_type') }}:
                                                    <code>{payment_type}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.track_booking_url') }}
                                                    : <code>{track_booking_url}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.website_url') }} :
                                                    <code>{website_url}</code>
                                                </p>
                                            </div>
                                            <div class="col">
                                                <h5 class="text-center text-dark color-changer">
                                                    {{ trans('labels.customer_variable') }}
                                                </h5>
                                                <hr class="my-2">
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.customer_name') }} :
                                                    <code>{customer_name}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.customer_mobile') }} :
                                                    <code>{customer_mobile}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.customer_email') }} :
                                                    <code>{customer_email}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.address') }} :
                                                    <code>{address}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">{{ trans('labels.city') }}
                                                    :
                                                    <code>{city}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">{{ trans('labels.state') }}
                                                    :
                                                    <code>{state}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.country') }} :
                                                    <code>{country}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.landmark') }}
                                                    :
                                                    <code>{landmark}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.postalcode') }} :
                                                    <code>{postal_code}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.booking_date') }} :
                                                    <code>{booking_date}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.booking_time') }} :
                                                    <code>{start_time}-{end_time}</code>
                                                </p>
                                                <p class="mb-1 text-dark color-changer">
                                                    {{ trans('labels.message') }} :
                                                    <code>{message}</code>
                                                </p>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label
                                                        class="form-label fw-bold">{{ trans('labels.whatsapp_messages') }}
                                                        <span class="text-danger"> * </span> </label>
                                                    <textarea class="form-control" required="required" name="whatsapp_message" cols="50" rows="10">{{ @whatsapp_helper::whatsapp_message_config($vendor_id)->whatsapp_message }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="col-form-label"
                                                        for="">{{ trans('labels.booking_created') }}
                                                    </label>
                                                    <input id="booking_created-switch" type="checkbox"
                                                        class="checkbox-switch" name="order_created" value="1"
                                                        {{ @whatsapp_helper::whatsapp_message_config($vendor_id)->order_created == 1 ? 'checked' : '' }}>
                                                    <label for="booking_created-switch" class="switch">
                                                        <span
                                                            class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                class="switch__circle-inner"></span></span>
                                                        <span
                                                            class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                        <span
                                                            class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label class="form-label"
                                                    for="">{{ trans('labels.whatsapp_chat') }}
                                                </label>
                                                <div class="text-center">
                                                    <input id="whatsapp_chat_on_off" type="checkbox"
                                                        class="checkbox-switch" name="whatsapp_chat_on_off"
                                                        value="1"
                                                        {{ @whatsapp_helper::whatsapp_message_config($vendor_id)->whatsapp_chat_on_off == 1 ? 'checked' : '' }}>
                                                    <label for="whatsapp_chat_on_off" class="switch">
                                                        <span
                                                            class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                class="switch__circle-inner"></span></span>
                                                        <span
                                                            class="switch__left {{ session()->get('direction') == 2 ? 'pe-1' : 'ps-1' }}">{{ trans('labels.off') }}</span>
                                                        <span
                                                            class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 form-group">
                                                <label class="form-label"
                                                    for="">{{ trans('labels.mobile_view_display') }}
                                                </label>
                                                <div class="text-center">
                                                    <input id="whatsapp_mobile_view_on_off" type="checkbox"
                                                        class="checkbox-switch" name="whatsapp_mobile_view_on_off"
                                                        value="1"
                                                        {{ @whatsapp_helper::whatsapp_message_config($vendor_id)->whatsapp_mobile_view_on_off == 1 ? 'checked' : '' }}>
                                                    <label for="whatsapp_mobile_view_on_off" class="switch">
                                                        <span
                                                            class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                class="switch__circle-inner"></span></span>
                                                        <span
                                                            class="switch__left {{ session()->get('direction') == 2 ? 'pe-1' : 'ps-1' }}">{{ trans('labels.off') }}</span>
                                                        <span
                                                            class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="col-form-label"
                                                        for="">{{ trans('labels.whatsapp_chat_position') }}
                                                    </label>
                                                    <div class="d-flex">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input me-0" type="radio"
                                                                name="whatsapp_chat_position" id="inlineRadio1"
                                                                value="1"
                                                                {{ @whatsapp_helper::whatsapp_message_config($vendor_id)->whatsapp_chat_position == 1 ? 'checked' : '' }}
                                                                checked>
                                                            <label class="form-check-label"
                                                                for="inlineRadio1">{{ trans('labels.left') }}</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input me-0" type="radio"
                                                                name="whatsapp_chat_position" id="inlineRadio2"
                                                                value="2"
                                                                {{ @whatsapp_helper::whatsapp_message_config($vendor_id)->whatsapp_chat_position == 2 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="inlineRadio2">{{ trans('labels.right') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                                    <button
                                                        class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_whatsapp_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="booking_whatsapp_message" value="1" @endif>{{ trans('labels.save') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="booking-status-message" role="tabpanel"
                        aria-labelledby="booking-status-message-tab">
                        <div class="card border-0 box-shadow">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form action="{{ URL::to('admin/settings/status_message') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="alert alert-danger">
                                            <i class="fa-regular fa-circle-exclamation"></i> Booking status message
                                            will only work if your message type settings are automatic using
                                            whatsapp business API
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label
                                                        class="form-label fw-bold">{{ trans('labels.booking_variable') }}
                                                    </label>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <ul class="list-group list-group-flush">
                                                                <li class="list-group-item px-0 color-changer">
                                                                    {{ trans('labels.booking_no') }} :
                                                                    <code>{booking_no}</code>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul class="list-group list-group-flush">
                                                                <li class="list-group-item px-0 color-changer">
                                                                    {{ trans('labels.customer_name') }}
                                                                    : <code>{customer_name}</code></li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul class="list-group list-group-flush">
                                                                <li class="list-group-item px-0 color-changer">
                                                                    {{ trans('labels.track_booking_url') }} :
                                                                    <code>{track_booking_url}</code>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <ul class="list-group list-group-flush">
                                                                <li class="list-group-item px-0 color-changer">
                                                                    {{ trans('labels.status') }}
                                                                    : <code>{status}</code></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label fw-bold">{{ trans('labels.status_message') }}
                                                        <span class="text-danger"> * </span> </label>
                                                    <textarea class="form-control" required="required" name="status_message" cols="50" rows="10">{{ @whatsapp_helper::whatsapp_message_config($vendor_id)->status_message }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="col-form-label"
                                                        for="">{{ trans('labels.status_change') }}
                                                    </label>
                                                    <input id="status_change-switch" type="checkbox"
                                                        class="checkbox-switch" name="status_change" value="1"
                                                        {{ @whatsapp_helper::whatsapp_message_config($vendor_id)->status_change == 1 ? 'checked' : '' }}>
                                                    <label for="status_change-switch" class="switch">
                                                        <span
                                                            class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                class="switch__circle-inner"></span></span>
                                                        <span
                                                            class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                        <span
                                                            class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div
                                                class="form-group {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                                <button
                                                    class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_whatsapp_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="booking_status_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (@helper::checkaddons('product_shop'))
                        <div class="tab-pane fade" id="order" role="tabpanel" aria-labelledby="order-tab">
                            <div class="card border-0 box-shadow">
                                <div class="card-body">
                                    <div class="form-validation">
                                        <form action="{{ URL::to('admin/settings/order_message_update') }}"
                                            method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-4">
                                                    <h5 class="text-center text-dark color-changer">
                                                        {{ trans('labels.order_variable') }}
                                                    </h5>
                                                    <hr class="my-2">
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.order_no') }} :
                                                        <code>{order_no}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.item_variable') }} :
                                                        <code>{item_variable}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.subtotal') }}
                                                        :
                                                        <code>{sub_total}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">{{ trans('labels.total') }}
                                                        {{ trans('labels.tax') }} : <code>{total_tax}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.delivery_charge') }} :
                                                        <code>{delivery_charge}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.offer_code') }} :
                                                        <code>{offer_code}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.discount_amount') }} :
                                                        <code>{discount_amount}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.grand_total') }} :
                                                        <code>{grand_total}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.payment_status') }}:
                                                        <code>{payment_status}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.payment_type') }}:
                                                        <code>{payment_type}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.store_name') }}:
                                                        <code>{store_name}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.track_order_url') }}
                                                        : <code>{track_order_url}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.website_url') }} :
                                                        <code>{website_url}</code>
                                                    </p>
                                                </div>
                                                <div class="col-4">
                                                    <h5 class="text-center text-dark color-changer">
                                                        {{ trans('labels.customer_variable') }}
                                                    </h5>
                                                    <hr class="my-2">
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.customer_name') }} :
                                                        <code>{customer_name}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.customer_mobile') }} :
                                                        <code>{customer_mobile}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.customer_email') }} :
                                                        <code>{customer_email}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.address') }} :
                                                        <code>{address}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">{{ trans('labels.city') }}
                                                        :
                                                        <code>{city}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">{{ trans('labels.state') }}
                                                        :
                                                        <code>{state}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.country') }} :
                                                        <code>{country}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.landmark') }}
                                                        :
                                                        <code>{landmark}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.postalcode') }} :
                                                        <code>{postal_code}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.notes') }} :
                                                        <code>{notes}</code>
                                                    </p>
                                                </div>
                                                <div class="col-4">
                                                    <h5 class="text-center text-dark color-changer">
                                                        {{ trans('labels.item_variable') }}
                                                    </h5>
                                                    <hr class="my-2">
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.item_name') }} :
                                                        <code>{item_name}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.qty') }} :
                                                        <code>{qty}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.item_price') }} :
                                                        <code>{item_price}</code>
                                                    </p>
                                                    <p class="mb-1 text-dark color-changer">
                                                        {{ trans('labels.total') }} :
                                                        <code>{total}</code>
                                                    </p>
                                                    <input type="text" class="form-control" name="item_message"
                                                        value="{{ @whatsapp_helper::whatsapp_message_config($vendor_id)->item_message }}"
                                                        placeholder="{{ trans('labels.item_message') }}" required>
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <div class="form-group">
                                                        <label
                                                            class="form-label fw-bold">{{ trans('labels.whatsapp_messages') }}
                                                            <span class="text-danger"> * </span> </label>
                                                        <textarea class="form-control" required="required" name="order_whatsapp_message" cols="50" rows="10">{{ @whatsapp_helper::whatsapp_message_config($vendor_id)->order_whatsapp_message }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.order_created') }}
                                                        </label>
                                                        <input id="order_created-switch" type="checkbox"
                                                            class="checkbox-switch" name="product_order_created"
                                                            value="1"
                                                            {{ @whatsapp_helper::whatsapp_message_config($vendor_id)->product_order_created == 1 ? 'checked' : '' }}>
                                                        <label for="order_created-switch" class="switch">
                                                            <span
                                                                class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                    class="switch__circle-inner"></span></span>
                                                            <span
                                                                class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                            <span
                                                                class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div
                                                        class="form-group {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                                        <button
                                                            class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_whatsapp_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="orders_whatsapp_message" value="1" @endif>{{ trans('labels.save') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="order-status-message" role="tabpanel"
                            aria-labelledby="order-status-message-tab">
                            <div class="card border-0 box-shadow">
                                <div class="card-body">
                                    <div class="form-validation">
                                        <form action="{{ URL::to('admin/settings/status_message') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="alert alert-danger">
                                                <i class="fa-regular fa-circle-exclamation"></i> Order status message
                                                will only work if your message type settings are automatic using
                                                whatsapp business API
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="form-label fw-bold">{{ trans('labels.order_variable') }}
                                                        </label>
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <ul class="list-group list-group-flush">
                                                                    <li class="list-group-item px-0 color-changer">
                                                                        {{ trans('labels.order_no') }} :
                                                                        <code>{order_no}</code>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <ul class="list-group list-group-flush">
                                                                    <li class="list-group-item px-0 color-changer">
                                                                        {{ trans('labels.customer_name') }}
                                                                        : <code>{customer_name}</code></li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <ul class="list-group list-group-flush">
                                                                    <li class="list-group-item px-0 color-changer">
                                                                        {{ trans('labels.track_order_url') }} :
                                                                        <code>{track_order_url}</code>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <ul class="list-group list-group-flush">
                                                                    <li class="list-group-item px-0 color-changer">
                                                                        {{ trans('labels.status') }}
                                                                        : <code>{status}</code></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label
                                                            class="form-label fw-bold">{{ trans('labels.status_message') }}
                                                            <span class="text-danger"> * </span> </label>
                                                        <textarea class="form-control" required="required" name="order_status_message" cols="50" rows="10">{{ @whatsapp_helper::whatsapp_message_config($vendor_id)->order_status_message }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.order_status_change') }}
                                                        </label>
                                                        <input id="order_status_change-switch" type="checkbox"
                                                            class="checkbox-switch" name="order_status_change"
                                                            value="1"
                                                            {{ @whatsapp_helper::whatsapp_message_config($vendor_id)->order_status_change == 1 ? 'checked' : '' }}>
                                                        <label for="order_status_change-switch" class="switch">
                                                            <span
                                                                class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                    class="switch__circle-inner"></span></span>
                                                            <span
                                                                class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                            <span
                                                                class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                                    <button
                                                        class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_whatsapp_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="orders_status_update" value="1" @endif>{{ trans('labels.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
