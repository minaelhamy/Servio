@extends('widget.layout.default')
@section('content')
    <div class="main">

        <div class="header">
            <span class="fw-bold active header-title">{{ trans('labels.select_datetime') }}</span>

        </div>
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
                @if ($employee == 1 && @$service->staff_assign == 1)
                    <div class="d-flex justify-content-end p-2">
                        <div>
                            <label class="form-label">{{ trans('labels.staff_member') }}
                                <span class="text-danger">
                                    * </span></label>
                            <select class="form-control selectpicker" name="staff" id="staff" data-live-search="true"
                                required>
                                <option value="">{{ trans('labels.select') }}
                                </option>
                                @if (!empty(@$getstaflist))
                                    @foreach ($getstaflist as $staff)
                                        <option value="{{ @$staff->id }}"
                                            {{ old('staff') == @$staff->id ? 'selected' : '' }}
                                            data-id="{{ @$staff->id }}">
                                            {{ @$staff->name }} </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('staff')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                @endif
            @endif
        @else
            @if (@helper::checkaddons('employee'))
                @if (@$service->staff_assign == 1)
                    <div class="d-flex justify-content-end p-2">
                        <div>
                            <label class="form-label">{{ trans('labels.staff_member') }}
                                <span class="text-danger">
                                    * </span></label>
                            <select class="form-control selectpicker" name="staff" id="staff" data-live-search="true"
                                required>
                                <option value="">{{ trans('labels.select') }}
                                </option>
                                @if (!empty(@$getstaflist))
                                    @foreach ($getstaflist as $staff)
                                        <option value="{{ @$staff->id }}" data-id="{{ @$staff->id }}">
                                            {{ @$staff->name }} </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('staff')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                @endif
            @endif
        @endif
        <div class="row justify-content-between main-specing">
            <div class="sl-appointment-calendar col-md-6 mb-3">
                <div id="sl-calendar"></div>
            </div>

            <div class="sl-appointment-time-holder col-md-6 mb-3  text-center overflow-auto" id="timelist">
                <div id="close"><label class="text-danger"></div>
                <div id="date_select_msg"><label class="text-danger">
                        <h5>{{ trans('messages.select_date') }}</h5><label></div>
                <div class="sl-timeslots" id="timeslote">
                </div>
            </div>


        </div>
    </div>
    <input type="hidden" id="timesloturl" value="{{ URL::to($vendordata->slug . '/embedded/timeslot') }}">
    <input type="hidden" id="vendor_id" value="{{ $vendordata->id }}">

    <input type="hidden" id="service_id"
        value="{{ session()->get('embedded_serviceid') ? session()->get('embedded_serviceid') : '' }}">

    <!--================================== footer section start ====================================-->
    <div class="footer">
        {{-- <div class="d-flex justify-content-between"> --}}
            <a href="{{ URL::to('/' . $vendordata->slug . '/embedded/services?category=' . session()->get('embedded_category')) }}"
                class="btn btn-outline-primary px-4 back_button">{{ trans('labels.back') }}</a>
            <form
                action="{{ URL::to('/' . $vendordata->slug . '/embedded/information?selecteddate=' . session()->get('embedded_date') . '&selectedtime=' . session()->get('embedded_time')) }}"
                method="get">
                <input type="hidden" name="selecteddate"
                    value="{{ session()->get('embedded_date') ? session()->get('embedded_date') : '' }}" id="selecteddate">
                <input type="hidden" name="selectedtime"
                    value="{{ session()->get('embedded_time') ? session()->get('embedded_time') : '' }}" id="selectedtime">
                <input type="hidden"name="staff"
                    id="staff_id"value="{{ session()->get('embedded_staff') ? session()->get('embedded_staff') : '' }}">
                <input type="hidden"name="staff_name"
                    id="staff_name"value="{{ session()->get('embedded_staffname') ? session()->get('embedded_staffname') : '' }}">
                <button type="submit" class="btn btn-secondary px-4 next_button"
                    id="cnext_button">{{ trans('labels.next_step') }}</button>
            </form>

        {{-- </div> --}}
    </div>
    <!--==================================== footer section end ====================================-->
@endsection
@section('scripts')
    <script>
        var store_close = "{{ trans('messages.store_closed') }}";
        var validatetime = "{{ trans('messages.select_time') }}";
        var select_date = "{{ trans('messages.select_date') }}";
        var sessiondate = "{{ session()->get('embedded_date') != '' ? session()->get('embedded_date') : '' }}";
        var sessiontime = "{{ session()->get('embedded_time') != '' ? session()->get('embedded_time') : '' }}";
        var bookingmessage = "{{ trans('messages.already_booked') }}";
        var nextpageurl = "{{ URL::to('/' . $vendordata->slug . '/embedded/information') }}";
        var slotlimiturl = "{{ URL::to('/' . $vendordata->slug . '/embedded/slotlimit') }}";
        $('#staff').on('change', function() {
            "use strict";
            $('#staff_id').val($("#staff option:selected").val());
            $('#staff_name').val($("#staff option:selected").text());
        });
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'widget_asstes/js/index.js') }}"></script>
@endsection
