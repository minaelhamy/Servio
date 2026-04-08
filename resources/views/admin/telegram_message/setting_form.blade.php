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
                            aria-selected="true">{{ trans('labels.telegram_business_api') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="booking-tab" data-bs-toggle="tab" data-bs-target="#booking"
                            type="button" role="tab" aria-controls="labels"
                            aria-selected="false">{{ trans('labels.telegram_booking_message') }}</button>
                    </li>
                    @if (@helper::checkaddons('product_shop'))
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="order-tab" data-bs-toggle="tab" data-bs-target="#order"
                                type="button" role="tab" aria-controls="labels"
                                aria-selected="false">{{ trans('labels.telegram_order_message') }}</button>
                        </li>
                    @endif
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="business-api" role="tabpanel"
                        aria-labelledby="business-api-tab">
                        <div class="card border-0 box-shadow">
                            <div class="card-body">
                                <div class="form-validation">
                                    <form action="{{ URL::to('admin/telegrammessage/business_api') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ trans('labels.telegram_chat_id') }}
                                                        <span class="text-danger"> * </span></label>
                                                    <input type="text" class="form-control" name="telegram_chat_id"
                                                        value="{{ @$telegramdata->telegram_chat_id }}"
                                                        placeholder="{{ trans('labels.telegram_chat_id') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ trans('labels.telegram_access_token') }}
                                                        <span class="text-danger"> * </span></label>
                                                    <input type="text" class="form-control" name="telegram_access_token"
                                                        value="{{ @$telegramdata->telegram_access_token }}"
                                                        placeholder="{{ trans('labels.telegram_access_token') }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div
                                                class="form-group {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                                <button
                                                    class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_telegram_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
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
                                    <form action="{{ URL::to('admin/telegrammessage/order_message_update') }}"
                                        method="post" enctype="multipart/form-data">
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
                                                        class="form-label fw-bold">{{ trans('labels.telegram_messages') }}
                                                        <span class="text-danger"> * </span> </label>
                                                    <textarea class="form-control" required="required" name="telegram_message" cols="50" rows="10">{{ @$telegramdata->telegram_message }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="col-form-label"
                                                        for="">{{ trans('labels.booking_created') }}
                                                    </label>
                                                    <input id="booking_created-switch" type="checkbox"
                                                        class="checkbox-switch" name="order_created" value="1"
                                                        {{ @$telegramdata->order_created == 1 ? 'checked' : '' }}>
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
                                            <div class="row">
                                                <div
                                                    class="form-group {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                                    <button
                                                        class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_telegram_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="booking_telegram_message" value="1" @endif>{{ trans('labels.save') }}</button>
                                                </div>
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
                                        <form action="{{ URL::to('admin/telegrammessage/order_message_update') }}"
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
                                                        value="{{ @$telegramdata->item_message }}"
                                                        placeholder="{{ trans('labels.item_message') }}" required>
                                                </div>
                                                <div class="col-md-12 mt-2">
                                                    <div class="form-group">
                                                        <label
                                                            class="form-label fw-bold">{{ trans('labels.telegram_messages') }}
                                                            <span class="text-danger"> * </span> </label>
                                                        <textarea class="form-control" required="required" name="order_telegram_message" cols="50" rows="10">{{ @$telegramdata->order_telegram_message }}</textarea>
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
                                                            {{ @$telegramdata->product_order_created == 1 ? 'checked' : '' }}>
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
                                                            class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_telegram_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="orders_telegram_message" value="1" @endif>{{ trans('labels.save') }}</button>
                                                    </div>
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
