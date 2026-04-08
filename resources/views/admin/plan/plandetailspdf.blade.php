<html>

<head>
    <title>{{ helper::appdata($plan->vendor_id)->web_title }}</title>
</head>
<style type="text/css">
    body {
        font-family: 'Roboto Condensed', sans-serif;
    }

    .m-0 {
        margin: 0px;
    }

    .p-0 {
        padding: 0px;
    }

    .pt-5 {
        padding-top: 5px;
    }

    .mt-10 {
        margin-top: 10px;
    }

    .mt-15 {
        margin-top: 15px;
    }

    .text-center {
        text-align: center !important;
    }

    .w-100 {
        width: 100%;
    }

    .w-50 {
        width: 50%;
    }

    .w-85 {
        width: 85%;
    }

    .w-15 {
        width: 15%;
    }

    .logo img {
        width: 200px;
        height: 60px;
    }

    .gray-color {
        color: #5D5D5D;
    }

    .text-bold {
        font-weight: bold;
    }

    .border {
        border: 1px solid black;
    }

    table tr,
    th,
    td {
        border: 1px solid #d2d2d2;
        border-collapse: collapse;
        padding: 7px 8px;
    }

    table tr th {
        background: #F4F4F4;
        font-size: 15px;
    }

    table tr td {
        font-size: 13px;
    }

    table {
        border-collapse: collapse;
    }

    .box-text p {
        line-height: 10px;
    }

    .float-left {
        float: left;
    }

    .total-part {
        font-size: 16px;
        line-height: 12px;
    }

    .total-right p {
        padding-right: 20px;
    }
</style>

<body>
    <div class="head-title">
        <h1 class="text-center m-0 p-0">{{ trans('labels.transaction_invoice') }}</h1>
    </div>
    <div class="add-detail mt-10">
        <div class="w-50 float-left mt-10">
            <p class="m-0 pt-5 text-bold w-100">{{ trans('labels.transaction_number') }} : <span
                    class="gray-color">{{ $plan->transaction_number }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">{{ trans('labels.purchase_date') }} : <span
                    class="gray-color">{{ helper::date_formate($plan->created_at, $plan->vendor_id) }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">{{ trans('labels.expire_date') }} : <span
                    class="gray-color">{{ $plan->expire_date != '' ? helper::date_formate($plan->expire_date, $plan->vendor_id) : '-' }}</span>
            </p>
        </div>
        <div style="clear: both;"></div>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">{{ trans('labels.vendor_info') }}</th>
                <th class="w-50">{{ trans('labels.Payment_information') }}</th>
            </tr>
            <tr>
                <td>
                    <div class="box-text">
                        <p><i class="fa-regular fa-user"></i> {{ $user->name }}</p>
                        <p><i class="fa-regular fa-phone"></i> {{ $user->mobile }} </p>
                        <p><i class="fa-regular fa-envelope"></i> {{ $user->email }}</p>
                    </div>
                </td>
                <td>
                    <p>{{ trans('labels.sub_total') }} : {{ helper::currency_formate($plan->amount, '') }}</p>
                    @if ($plan->amount != 0)
                        @php
                            $tax = explode('|', $plan->tax);
                            $tax_name = explode('|', $plan->tax_name);
                        @endphp
                        @if ($plan->tax != null && $plan->tax != '')
                            @foreach ($tax as $key => $tax_value)
                                <p>{{ $tax_name[$key] }} :
                                    {{ helper::currency_formate(@$tax[$key], '') }}</p>
                            @endforeach
                        @endif
                    @endif
                    @if ($plan->offer_amount != '' && $plan->offer_amount != null)
                        <p>{{ trans('labels.discount') }} : -{{ helper::currency_formate($plan->offer_amount, '') }}
                        </p>
                    @endif
                    <p>{{ trans('labels.total') }} {{ trans('labels.amount') }} :
                        {{ helper::currency_formate($plan->grand_total, '') }}</p>
                    <div class="box-text">
                        @if ($plan->payment_type == 6)
                            {{ @helper::getpayment($plan->payment_type, 1)->payment_name }}
                            : <small><a href="{{ helper::image_path($plan->screenshot) }}" target="_blank"
                                    class="text-danger">{{ trans('labels.click_here') }}</a></small>
                        @elseif(in_array($plan->payment_type, [2, 3, 4, 5, 7, 8, 9, 10, 11, 12, 13, 14, 15]))
                            {{ @helper::getpayment($plan->payment_type, 1)->payment_name }}
                            : {{ $plan->payment_id }}
                        @elseif($plan->payment_type == 6)
                            {{ @helper::getpayment($plan->payment_type, 1)->payment_name }}
                        @elseif($plan->payment_type == 0)
                            {{ trans('labels.manual') }}
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">{{ trans('labels.plan_information') }}</th>
            </tr>
            <tr>
                <td>
                    <div class="box-text">
                        <h1>{{ $plan->plan_name }}</h1>
                        <h2 class="mb-1">{{ helper::currency_formate($plan->amount, '') }}
                            <span class="fs-7 text-muted">/
                                @if ($plan->duration != null || $plan->duration != '')
                                    @if ($plan->duration == 1)
                                        {{ trans('labels.one_month') }}
                                    @elseif($plan->duration == 2)
                                        {{ trans('labels.three_month') }}
                                    @elseif($plan->duration == 3)
                                        {{ trans('labels.six_month') }}
                                    @elseif($plan->duration == 4)
                                        {{ trans('labels.one_year') }}
                                    @elseif($plan->duration == 5)
                                        {{ trans('labels.lifetime') }}
                                    @endif
                                @else
                                    {{ $plan->days }}
                                    {{ $plan->days > 1 ? trans('labels.days') : trans('labels.day') }}
                                @endif
                            </span>
                        </h2>
                        @if ($plan->tax != null && $plan->tax != '')
                            <small class="text-danger">{{ trans('labels.exclusive_all_taxes') }}</small><br>
                        @else
                            <small class="text-success">{{ trans('labels.inclusive_taxes') }}</small> <br>
                        @endif
                        <small class="text-muted text-center">{{ $plan->description }}</small>
                        <ul class="pb-5">
                            @php $features = ($plan->features == null ? null : explode('|', $plan->features));@endphp
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2">
                                    {{ $plan->service_limit == -1 ? trans('labels.unlimited') : $plan->service_limit }}
                                    {{ $plan->service_limit > 1 || $plan->service_limit == -1 ? trans('labels.products') : trans('labels.product') }}
                                </span>
                            </li>
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2">
                                    {{ $plan->appoinment_limit == -1 ? trans('labels.unlimited') : $plan->appoinment_limit }}
                                    {{ $plan->appoinment_limit > 1 || $plan->appoinment_limit == -1 ? trans('labels.orders') : trans('labels.order') }}
                                </span>
                            </li>
                            @if (@helper::checkaddons('product_shop'))
                                <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                    <span class="mx-2">
                                        {{ $plan->product_limit == -1 ? trans('labels.unlimited') : $plan->product_limit }}
                                        {{ $plan->product_limit > 1 || $plan->product_limit == -1 ? trans('labels.product_s') : trans('labels.product_') }}
                                    </span>
                                </li>
                                <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                    <span class="mx-2">
                                        {{ $plan->order_appointment_limit == -1 ? trans('labels.unlimited') : $plan->order_appointment_limit }}
                                        {{ $plan->order_appointment_limit > 1 || $plan->order_appointment_limit == -1 ? trans('labels.order_s') : trans('labels.order_') }}
                                    </span>
                                </li>
                            @endif
                            @php
                                $themes = [];
                                if ($plan->themes_id != '' && $plan->themes_id != null) {
                                    $themes = explode('|', $plan->themes_id);
                            } @endphp
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2">{{ count($themes) }}
                                    {{ count($themes) > 1 ? trans('labels.themes') : trans('labels.theme') }}</span>
                            </li>
                            @if (@helper::checkaddons('coupon'))
                                @if ($plan->coupons == 1)
                                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                        <span class="mx-2">{{ trans('labels.coupons') }}</span>
                                    </li>
                                @endif
                            @endif
                            @if (@helper::checkaddons('custom_domain'))
                                @if ($plan->custom_domain == 1)
                                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                        <span class="mx-2">{{ trans('labels.custom_domain_available') }}</span>
                                    </li>
                                @endif
                            @endif
                            @if (@helper::checkaddons('blog'))
                                @if ($plan->blogs == 1)
                                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                        <span class="mx-2">{{ trans('labels.blogs') }}</span>
                                    </li>
                                @endif
                            @endif
                            @if (@helper::checkaddons('google_login'))
                                @if ($plan->google_login == 1)
                                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                        <span class="mx-2">{{ trans('labels.google_login') }}</span>
                                    </li>
                                @endif
                            @endif
                            @if (@helper::checkaddons('facebook_login'))
                                @if ($plan->facebook_login == 1)
                                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                        <span class="mx-2">{{ trans('labels.facebook_login') }}</span>
                                    </li>
                                @endif
                            @endif
                            @if (@helper::checkaddons('notification'))
                                @if ($plan->sound_notification == 1)
                                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                        <span class="mx-2">{{ trans('labels.sound_notification') }}</span>
                                    </li>
                                @endif
                            @endif
                            @if (@helper::checkaddons('whatsapp_message'))
                                @if ($plan->whatsapp_message == 1)
                                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                        <span class="mx-2">{{ trans('labels.whatsapp_message') }}</span>
                                    </li>
                                @endif
                            @endif
                            @if (@helper::checkaddons('telegram_message'))
                                @if ($plan->telegram_message == 1)
                                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                        <span class="mx-2">{{ trans('labels.telegram_message') }}</span>
                                    </li>
                                @endif
                            @endif
                            @if (@helper::checkaddons('vendor_app'))
                                @if ($plan->vendor_app == 1)
                                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                        <span class="mx-2">{{ trans('labels.vendor_app_available') }}</span>
                                    </li>
                                @endif
                            @endif
                            @if (@helper::checkaddons('user_app'))
                                @if ($plan->customer_app == 1)
                                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                        <span class="mx-2">{{ trans('labels.customer_app') }}</span>
                                    </li>
                                @endif
                            @endif
                            @if (@helper::checkaddons('pwa'))
                                @if ($plan->pwa == 1)
                                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                        <span class="mx-2">{{ trans('labels.pwa') }}</span>
                                    </li>
                                @endif
                            @endif
                            @if (@helper::checkaddons('employee'))
                                @if ($plan->role_management == 1)
                                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                        <span class="mx-2">{{ trans('labels.role_management') }}</span>
                                    </li>
                                @endif
                            @endif
                            @if (@helper::checkaddons('pixel'))
                                @if ($plan->pixel == 1)
                                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                        <span class="mx-2">{{ trans('labels.pixel') }}</span>
                                    </li>
                                @endif
                            @endif
                            @if ($features != '')
                                @foreach ($features as $feature)
                                    @if ($feature != '' && $feature != null)
                                        <li class="mb-2 d-flex"> <i
                                                class="fa-regular fa-circle-check text-secondary "></i>
                                            <span class="mx-2"> {{ $feature }} </span>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="mt-15 text-center bg-white fixed-bottom border-top">
        <span>{{ helper::appdata('')->copyright }}</span>
    </div>
</body>

</html>
