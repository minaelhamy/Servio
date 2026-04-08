<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
</head>
<body>
    <div>
        <div style="background:#ffffff;padding:15px">
            <p>Dear <b>{{ $customer_name }}</b>,</p>
            <p>You have been invited to attend <b>{{$service_name}}</b> to be hold
                on <b>{{ $booking_date }}</b>,which coordinated by <b>{{ "'" . $vendor . "'" }}</b></p>
            <p> You can join the meeting via given link:&nbsp;&nbsp;<a href="{{ $join_url }}">{{ $join_url }}</a></p>

            <p style="margin:0px">Sincerely,</p>
            {{$vendor}}
        </div>
    </div>
</body>
</html>