@extends('admin.layout.default')

@section('content')
    @include('admin.breadcrumb.breadcrumb')
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $user = App\Models\User::where('id', $vendor_id)->first();
    @endphp
    <div class="row mt-3 pb-3">

        <div class="col-12">

            <div class="card border-0 box-shadow">

                <div class="card-body">

                    <form action="{{ URL::to('admin/calendar/save') }}" method="POST">

                        @csrf

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.service') }}<span class="text-danger"> *
                                    </span></label>
                                <select name="service" id="service" class="form-select" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                    @foreach ($allservice as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>


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
                                        <div class="col-md-6 mb-lg-0" id="staff_id">
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.staff_member') }} <span
                                                        class="text-danger">
                                                        * </span></label>
                                                <select class="form-control border selectpicker" name="staff"
                                                    data-live-search="true" id="staff">
                                                    <option value="">{{ trans('labels.select') }}</option>
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
                                    @if ($service->staff_assign == 1)
                                        <div class="col-md-6 mb-lg-0" id="staff_id">
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.staff_member') }} <span
                                                        class="text-danger">
                                                        * </span></label>
                                                <select class="form-control border selectpicker" name="staff"
                                                    data-live-search="true" id="staff">
                                                    <option value="">{{ trans('labels.select') }}</option>
                                                </select>
                                                @error('staff')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endif


                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.booking_date') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="date" class="form-control" name="booking_date"
                                    value="{{ old('booking_date') }}" id="booking_date" required>

                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.booking_time') }}<span class="text-danger">
                                        *
                                    </span></label>
                                <select name="booking_time" class="form-select" id="booking_time" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.customer_name') }}<span class="text-danger">
                                        *
                                    </span></label>
                                <input type="text" class="form-control" name="customer_name" id="customer_name"
                                    value="{{ old('customer_name') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.customer_email') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="email" class="form-control" name="customer_email" id="customer_email"
                                    value="{{ old('customer_email') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.customer_mobile') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control numbers_only" name="customer_mobile"
                                    id="customer_mobile" value="{{ old('customer_mobile') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.address') }}</label>
                                <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.landmark') }}</label>
                                <input type="text" class="form-control" name="landmark"
                                    value="{{ old('landmark') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.postalcode') }}</label>
                                <input type="text" class="form-control" name="postalcode"
                                    value="{{ old('postalcode') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.city') }}</label>
                                <input type="text" class="form-control" name="city" value="{{ old('city') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.state') }}</label>
                                <input type="text" class="form-control" name="state" value="{{ old('city') }}">
                            </div>

                            <div class="form-group col-md-6">
                                {{-- <label for=""></label> --}}
                                <div class="w-100 m-0">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="customer" id="newuser"
                                            checked>
                                        <label class="form-check-label" for="newuser">
                                            {{ trans('labels.new_user') }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="customer" id="registereduser">
                                        <label class="form-check-label" for="registereduser">
                                            {{ trans('labels.register_user') }}
                                        </label>
                                    </div>
                                </div>
                                <div id="customerlist" class="d-none">
                                    <label class="form-label">{{ trans('labels.customers') }}<span class="text-danger">
                                            *
                                        </span></label>
                                    <select name="customers" id="customers" class="form-select" required>
                                        <option value="0">{{ trans('labels.select') }}</option>
                                        @foreach ($getcustomerslist as $customers)
                                            <option value="{{ $customers->id }}">{{ $customers->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.country') }}</label>
                                <input type="text" class="form-control" name="country" value="{{ old('country') }}">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.message') }}</label>
                                <textarea class="form-control" name="message" rows="5"></textarea>
                            </div>
                           
                            <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                                <a href="{{ URL::to('admin/calendar') }}"
                                    class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                                <button
                                    class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_calendar', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var sloturl = "{{ URL::to('/admin/calendar/timeslot') }}";
        var select = "{{ trans('labels.select') }}";
        var customerurl = "{{ URL::to('/admin/calendar/getcustomer') }}";
        var staffurl = "{{ URL::to('/admin/calendar/getstaff') }}";
        var vendor_id = "{{ $vendor_id }}";
        var staff_member = "{{ trans('labels.staff_member') }}";
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/vendorcalendar.js') }}"></script>
@endsection
