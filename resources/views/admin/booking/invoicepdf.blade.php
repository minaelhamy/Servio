<html>

<head>
    <title>{{ helper::appdata($getorderdata->vendor_id)->web_title }}</title>
</head>
<style type="text/css">
    body {
        font-family: 'DejaVu Sans', sans-serif;
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
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $user = App\Models\User::where('id', $vendor_id)->first();

    @endphp
    <div class="head-title">
        <h1 class="text-center m-0 p-0">{{ trans('labels.invoice') }}</h1>
    </div>
    <div class="add-detail mt-10">
        <div class="w-50 float-left mt-10">
            <p class="m-0 pt-5 text-bold w-100">{{ trans('labels.invoice_id') }} - <span
                    class="gray-color">#{{ $getorderdata->id }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">{{ trans('labels.order_id') }} - <span
                    class="gray-color">#{{ $getorderdata->booking_number }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">{{ trans('labels.booking_date') }} - <span
                    class="gray-color">{{ helper::date_formate($getorderdata->created_at, $getorderdata->vendor_id) }}</span>
            </p>
        </div>

        <div style="clear: both;"></div>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">{{ trans('labels.customer_info') }}</th>
                <th class="w-50">{{ trans('labels.address_info') }}</th>
            </tr>
            <tr>
                <td class="w-50">
                    <div class="box-text">
                        <p><i class="fa-regular fa-user"></i> {{ $getorderdata->customer_name }}</p>
                        <p><i class="fa-regular fa-phone"></i> {{ $getorderdata->mobile }} </p>
                        <p><i class="fa-regular fa-envelope"></i> {{ $getorderdata->email }}</p>

                    </div>
                </td>
                <td class="w-50">
                    <div class="box-text">
                        <p> {{ $getorderdata->address }},</p>
                        <p>{{ $getorderdata->landmark }},</p>
                        <p>{{ $getorderdata->postalcode }},</p>
                        <p> {{ $getorderdata->city }},</p>
                        <p> {{ $getorderdata->state }},</p>
                        <p> {{ $getorderdata->country }}.</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">vendor_id
            <tr>
                <th class="w-50">{{ trans('labels.payment_settings') }}</th>
                @if (@helper::checkaddons('subscription'))
                    @if (@helper::checkaddons('employee'))
                        @php
                            $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                ->orderByDesc('id')
                                ->first();

                            if (@$user->allow_without_subscription == 1) {
                                $employee = 1;
                            } else {
                                $employee = @$checkplan->employee;
                            }
                        @endphp
                        @if ($employee == 1)
                            <th class="w-50">{{ trans('labels.staff_member') }}</th>
                        @endif
                    @endif
                @else
                    @if (@helper::checkaddons('employee'))
                        <th class="w-50">{{ trans('labels.staff_member') }}</th>
                    @endif
                @endif
                @if (@helper::checkaddons('vendor_tip'))
                    @if (@helper::otherappdata($vendor_id)->tips_on_off == 1)
                        <th class="w-50">{{ trans('labels.tips') }}</th>
                    @endif
                @endif
            </tr>
            <tr>
                <td class="w-50">
                    {{ @helper::getpayment($getorderdata->transaction_type, $getorderdata->vendor_id)->payment_name }}
                    -
                    {{ $getorderdata->transaction_id }} @if ($getorderdata->transaction_type == 6)
                        : <small><a href="{{ helper::image_path($getorderdata->screenshot) }}" target="_blank"
                                class="text-danger">{{ trans('labels.click_here') }}</a></small>
                    @endif

                </td>
                @if (@helper::checkaddons('subscription'))
                    @if (@helper::checkaddons('employee'))
                        @php
                            $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                ->orderByDesc('id')
                                ->first();

                            if (@$user->allow_without_subscription == 1) {
                                $employee = 1;
                            } else {
                                $employee = @$checkplan->employee;
                            }
                        @endphp
                        @if ($employee == 1)
                            <td class="w-50">
                                {{ @helper::getslug($getorderdata->staff_id)->name }}
                            </td>
                        @endif
                    @endif
                @else
                    @if (@helper::checkaddons('employee'))
                        <td class="w-50">
                            {{ @helper::getslug($getorderdata->staff_id)->name }}
                        </td>
                    @endif
                @endif
                @if (@helper::checkaddons('vendor_tip'))
                    @if (@helper::otherappdata($vendor_id)->tips_on_off == 1)
                        <td>
                            <p class="fs-6 d-flex w-100 justify-content-between align-items-center">
                                {{ trans('labels.tips_pro') }} :
                                <small>{{ helper::currency_formate($getorderdata->tips, $getorderdata->vendor_id) }}</small>
                            </p>
                        </td>
                    @endif
                @endif
            </tr>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tr>
                <th class="w-50">{{ trans('labels.service_name') }}</th>
                <th class="w-50">{{ trans('labels.date_time') }}</th>
                <th class="w-50">{{ trans('labels.sub_total') }}</th>
            </tr>
            <tr align="center">
                <td>{{ $getorderdata->service_name }}
                    @if (@helper::checkaddons('additional_service'))
                        @if ($getorderdata->additional_service_id != null && $getorderdata->additional_service_id != '')
                            @php
                                $additional_service_id = explode('|', $getorderdata->additional_service_id);
                                $additional_service_name = explode('|', $getorderdata->additional_service_name);
                                $additional_service_price = explode('|', $getorderdata->additional_service_price);
                                $addtional_total_price = 0;
                            @endphp
                            <br>
                            @foreach ($additional_service_id as $key => $addons)
                                <small>
                                    <b class="text-muted">{{ $additional_service_name[$key] }}</b> :
                                    {{ helper::currency_formate($additional_service_price[$key], $getorderdata->vendor_id) }}<br>
                                </small>
                                @php
                                    $addtional_total_price += $additional_service_price[$key];

                                @endphp
                            @endforeach
                        @endif
                    @endif
                </td>
                <td>{{ helper::date_formate($getorderdata->booking_date, $getorderdata->vendor_id) }}
                    <small>{{ $getorderdata->booking_time . '-' . $getorderdata->booking_endtime }}</small>
                </td>
                <td> {{ helper::currency_formate($getorderdata->sub_total, $getorderdata->vendor_id) }}
                </td>
            </tr>

            <tr>
                <td colspan="3">
                    <div class="total-part">
                        <div class="total-left w-85 float-left" align="left">
                            <p>{{ trans('labels.sub_total') }}</p>
                            @if (@helper::checkaddons('additional_service'))
                                @if ($getorderdata->additional_service_id != null && $getorderdata->additional_service_id != '')
                                    <p>{{ trans('labels.additional_service') }}</p>
                                @endif
                            @endif
                            @if ($getorderdata->tax != '' && $getorderdata->tax != null)
                                @php
                                    $tax = explode('|', $getorderdata->tax);
                                    $tax_name = explode('|', $getorderdata->tax_name);
                                @endphp

                                @foreach ($tax as $key => $tax_value)
                                    <p>{{ $tax_name[$key] }}</p>
                                @endforeach

                            @endif

                            @if ($getorderdata->offer_amount > 0)
                                <p><strong>{{ trans('labels.discount') }}</strong>{{ $getorderdata->couponcode != '' ? '(' . $getorderdata->couponcode . ')' : '' }}
                                </p>
                            @endif
                            <p>{{ trans('labels.grand_total') }}</p>
                        </div>
                        <div class="total-right w-15 float-left text-bold" align="right">
                            <p>{{ helper::currency_formate($getorderdata->sub_total, $getorderdata->vendor_id) }}</p>
                            @if (@helper::checkaddons('additional_service'))
                                @if ($getorderdata->additional_service_id != null && $getorderdata->additional_service_id != '')
                                    <p>{{ helper::currency_formate($addtional_total_price, $getorderdata->vendor_id) }}
                                    </p>
                                @endif
                            @endif
                            @if ($getorderdata->tax != '' && $getorderdata->tax != null)
                                @foreach ($tax as $key => $tax_value)
                                    <p><strong>{{ helper::currency_formate((float) $tax[$key], $getorderdata->vendor_id) }}</strong>
                                    </p>
                                @endforeach
                            @endif

                            @if ($getorderdata->offer_amount > 0)
                                <p> <strong>{{ helper::currency_formate($getorderdata->offer_amount, $getorderdata->vendor_id) }}</strong>
                                </p>
                            @endif
                            <p> <strong>{{ helper::currency_formate($getorderdata->grand_total, $getorderdata->vendor_id) }}</strong>
                            </p>
                        </div>
                        <div style="clear: both;"></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
