@extends('admin.layout.default')
@section('content')
@php
    $module = "role_calendar";
@endphp
    @include('admin.breadcrumb.breadcrumb')
    <div class="row mt-3">
        <div class="container">
            <div id='calendar'></div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/calendar/moment.min.js') }}"></script>
<script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/calendar/fullcalendar.js') }}"></script> 
<script>
$(document).ready(function() {
    var bookings = @json($events);
    console.log(bookings);
    $('#calendar').fullCalendar({
       
        events: bookings,
        selectable:true,
        selcetHelper:true,
        displayEventTime: false,
        editable:true,
        eventDrop:function(event)
        {
            console.log(event);
        },
        select:function(start,end,allDays)
        {
            console.log('dgdfgdfg');
        },
        eventClick : function(event)
        {
            var booking_number = event.booking_number;
            var vendor_id = {{Auth::user()->id }};
            if({{Auth::user()->type }}== 2 || ({{Auth::user()->type }}== 4 &&  {{helper::check_access('role_calendar',Auth::user()->role_id,Auth::user()->vendor_id,'edit')}} == 1))
            {
                location.href = "{{URL::to('/admin/invoice-')}}"+ vendor_id + '-' +booking_number;
            }
        }
    })
});
</script>

@endsection
