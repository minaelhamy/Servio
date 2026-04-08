<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
</head>

<body>
    <div>
        <div style="background:#ffffff;padding:15px">
            {{-- <p>{{ trans('labels.dear') }} <b>{{ $vendor_name }}</b>,</p>

            <p>{{ trans('labels.subscription_message1') }}</p>

            <p>{{ trans('labels.subscription_message2') }}</p>

            <p>{{ trans('labels.subscription_message3') }}</p>

            {{ trans('labels.revenue_with_out_tax') }}: <b>{{ $earning_amt }}</b><br>
            {{ trans('labels.admin_commission') }}: <b>{{ $commission }}</b><br><br>
            {{ trans('labels.requested_amount') }}: <b>{{ $payable_amt }}</b><br><br>

            <p>{{ trans('labels.subscription_message4') }}</p>
            <p>{{ trans('labels.subscription_message5') }}</p>
            <p>{{ trans('labels.sincerely') }},</p>
            {{ $admin_name }}<br>
            {{ $admin_email }} --}}
            {!! $vendorpayoutmessage !!}
        </div>
    </div>
</body>

</html>
