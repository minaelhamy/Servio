<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
</head>

<body>
    <div>
        <div style="background:#ffffff;padding:15px">
            {{-- <p>{{ trans('labels.dear') }} <b>{{ $vendor_name }}</b>,</p>

            <p>{{ trans('labels.admin_subscription_message1') }}</p>

            {{ trans('labels.revenue_with_out_tax') }}: <b>{{ $earning_amt }}</b><br>
            {{ trans('labels.admin_commission') }}: <b>{{ $commission }}</b><br><br>
            {{ trans('labels.requested_amount') }}: <b>{{ $payable_amt }}</b><br><br>

            <p>{{ trans('labels.sincerely') }},</p>
            {{ $admin_name }}<br>
            {{ $admin_email }} --}}
            {!! $adminpayoutmessage !!}
        </div>
    </div>
</body>

</html>
