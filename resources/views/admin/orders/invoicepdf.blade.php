<html>

<head>
    <title>All Type Service | Online Appointment Scheduling</title>
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
</head>


<body>
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
    @endphp
    <div class="head-title">
        <h1 class="text-center m-0 p-0">{{ trans('labels.invoice') }}</h1>
    </div>
    <div class="add-detail mt-10">
        <div class="w-50 float-left mt-10">
            <p class="m-0 pt-5 text-bold w-100">{{ trans('labels.invoice_id') }} - <span
                    class="gray-color">#{{ $getorderdata->id }}</span></p>
            <p class="m-0 pt-5 text-bold w-100">{{ trans('labels.orders_id') }} - <span
                    class="gray-color">{{ $getorderdata->order_number }}</span>
            </p>
            <p class="m-0 pt-5 text-bold w-100">{{ trans('labels.orders_date') }} - <span
                    class="gray-color">{{ helper::date_formate($getorderdata->created_at, $vendor_id) }}</span>
            </p>
        </div>

        <div style="clear: both;"></div>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tbody>
                <tr>
                    <th class="w-50">{{ trans('labels.customer_info') }}</th>
                    <th class="w-50">{{ trans('labels.address_info') }}</th>
                </tr>
                <tr>
                    <td class="w-50">
                        <div class="box-text">
                            <p><i class="fa-regular fa-user"></i>{{ $getorderdata->user_name }}</p>
                            <p><i class="fa-regular fa-phone"></i>{{ $getorderdata->user_mobile }}</p>
                            <p><i class="fa-regular fa-envelope"></i>{{ $getorderdata->user_email }}</p>

                        </div>
                    </td>
                    <td class="w-50">
                        <div class="box-text">
                            <p>{{ $getorderdata->address }},</p>
                            <p>{{ $getorderdata->landmark }},</p>
                            <p>{{ $getorderdata->postal_code }},</p>
                            <p>{{ $getorderdata->city }},</p>
                            <p>{{ $getorderdata->state }},</p>
                            <p>{{ $getorderdata->country }}</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <tbody>
                <tr>
                    <th class="w-50">{{ trans('labels.payment_settings') }}</th>
                    @if (@helper::checkaddons('vendor_tip'))
                        @if (@helper::otherappdata($vendor_id)->tips_on_off == 1)
                            <th class="w-50">{{ trans('labels.tips') }}</th>
                        @endif
                    @endif
                </tr>
                <tr>
                    <td class="w-50">
                        {{ @helper::getpayment($getorderdata->transaction_type, $vendor_id)->payment_name }}
                        @if (in_array($getorderdata->transaction_type, [2, 3, 4, 5, 7, 8, 9, 10, 11, 12, 13, 14, 15]))
                            - {{ $getorderdata->transaction_id }}
                        @endif
                        @if ($getorderdata->transaction_type == 6)
                            : <small>
                                <a href="{{ helper::image_path($getorderdata->screenshot) }}" target="_blank"
                                    class="text-danger">{{ trans('labels.click_here') }}
                                </a>
                            </small>
                        @endif
                    </td>
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
            </tbody>
        </table>
    </div>
    <div class="table-section bill-tbl w-100 mt-10">
        <table class="table w-100 mt-10">
            <thead>
                <tr>
                    <th class="w-50">{{ trans('labels.product_name') }}</th>
                    <th class="w-50">{{ trans('labels.price') }}</th>
                    <th class="w-50">{{ trans('labels.qty') }}</th>
                    <th class="w-50">{{ trans('labels.total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($getorderitemlist as $product)
                    <tr align="center">
                        <td>
                            {{ $product->product_name }}
                        </td>
                        <td>
                            {{ helper::currency_formate($product->product_price, $vendor_id) }}
                        </td>
                        <td>
                            {{ $product->qty }}
                        </td>
                        <td>
                            {{ helper::currency_formate($product->product_price * $product->qty, $vendor_id) }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4">
                        <div class="total-part">
                            <div class="total-left w-85 float-left" align="right">
                                <p>{{ trans('labels.sub_total') }}</p>
                                @if ($getorderdata->offer_amount > 0)
                                    <p>{{ trans('labels.discount') }} ({{ $getorderdata->offer_code }})</p>
                                @endif
                                @if ($getorderdata->tax_name != null && $getorderdata->tax_name != '')
                                    @php
                                        $tax_name = explode('|', $getorderdata->tax_name);
                                    @endphp
                                    @foreach ($tax_name as $key => $tax_value)
                                        <p>{{ $tax_value }}</p>
                                    @endforeach
                                @endif
                                <p>{{ trans('labels.delivery') }}
                                    @if ($getorderdata->shipping_area != '')
                                        ({{ $getorderdata->shipping_area }})
                                    @endif
                                </p>
                                <p><strong>{{ trans('labels.grand_total') }}</strong></p>
                            </div>
                            <div class="total-right w-15 float-left" align="right">
                                <p>{{ helper::currency_formate($getorderdata->sub_total, $vendor_id) }}</p>
                                @if ($getorderdata->offer_amount > 0)
                                    <p>– {{ helper::currency_formate($getorderdata->offer_amount, $vendor_id) }}
                                    </p>
                                @endif
                                @if ($getorderdata->tax_amount != null && $getorderdata->tax_amount != '')
                                    @php
                                        $tax_amount = explode('|', $getorderdata->tax_amount);
                                    @endphp
                                    @foreach ($tax_amount as $key => $tax_value)
                                        <p>{{ helper::currency_formate($tax_value, $vendor_id) }}</p>
                                    @endforeach
                                @endif
                                <p>
                                    @if ($getorderdata->delivery_charge > 0)
                                        {{ helper::currency_formate($getorderdata->delivery_charge, $vendor_id) }}
                                    @else
                                        {{ trans('labels.free') }}
                                    @endif
                                </p>
                                <p><strong>{{ helper::currency_formate($getorderdata->grand_total, $vendor_id) }}</strong>
                                </p>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
