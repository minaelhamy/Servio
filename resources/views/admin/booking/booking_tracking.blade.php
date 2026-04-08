@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row mt-3">
        @php
            if (Auth::user()->type == 4) {
                $vendor_id = Auth::user()->vendor_id;
            } else {
                $vendor_id = Auth::user()->id;
            }
            $user = App\Models\User::where('id', $vendor_id)->first();
            $module = 'role_bookings';
        @endphp
    </div>
    <div class="row">
        <div class="col-md-12 my-2 d-flex flex-wrap gap-2 justify-content-sm-end justify-content-center">
            @if (@helper::checkaddons('custom_status'))
                @if ($invoice->status_type == 1)
                    @php
                        $color = 'warning';
                    @endphp
                @elseif ($invoice->status_type == 2)
                    @php
                        $color = 'info';
                    @endphp
                @elseif ($invoice->status_type == 3)
                    @php
                        $color = 'success';
                    @endphp
                @elseif ($invoice->status_type == 4)
                    @php
                        $color = 'danger';
                    @endphp
                @endif
                @if ($invoice->status_type == 3 || $invoice->status_type == 4)
                    <label
                        class="text-{{ $color }}">{{ @helper::gettype($invoice->status, $invoice->status_type, $vendor_id, 1)->name == null ? '-' : @helper::gettype($invoice->status, $invoice->status_type, $vendor_id, 1)->name }}</label>
                @else
                    <div class="lag-btn2">
                        <button type="button"
                            class="btn btn-sm btn-primary px-sm-4 col-sm-auto col-12 rounded {{ Auth::user()->type == 4 ? (helper::check_access('role_bookings', Auth::user()->role_id, $vendor_id, 'manage') == 1 ? '' : 'd-none') : '' }} {{ session()->get('direction') == 2 ? 'dropdown-toggle-rtl' : 'dropdown-toggle-ltr' }}"
                            data-bs-toggle="dropdown"
                            {{ Auth::user()->type == 1 ? 'disabled' : '' }}>{{ @helper::gettype($invoice->status, $invoice->status_type, $vendor_id, 1)->name == null ? '-' : @helper::gettype($invoice->status, $invoice->status_type, $vendor_id, 1)->name }}</button>
                        <div
                            class="dropdown-menu bg-body-secondary p-0 border-0 shadow {{ Auth::user()->type == 1 ? 'disabled' : '' }}">
                            @foreach (helper::customstauts($invoice->vendor_id, 1) as $status)
                                <a class="dropdown-item w-auto dropdown-item d-flex align-items-center p-2 {{ $invoice->status == $status->id ? 'fw-600' : '' }} cursor-pointer"
                                    onclick="statusupdate('{{ URL::to('admin/bookings/status_change-' . $invoice->booking_number . '/' . $status->id . '/' . $status->type) }}')">{{ $status->name }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            @if (@helper::checkaddons('subscription'))
                @if (@helper::checkaddons('employee'))
                    @php
                        $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)->orderByDesc('id')->first();

                        if (@$user->allow_without_subscription == 1) {
                            $employee = 1;
                        } else {
                            $employee = @$checkplan->employee;
                        }
                    @endphp
                    @if ($employee == 1)
                        @if ($staff_assign == 1)
                            @if ($invoice->status_type == 1 || $invoice->status_type == 2)
                                <select name="staff" class="btn dropdown-toggle border col-sm-auto col-12 bg-white fs-7"
                                    id="staff_member">
                                    <option value=""
                                        class="text-{{ session()->get('direction') == '2' ? 'end' : 'start' }}">
                                        {{ trans('labels.select') }}</option>
                                    @foreach ($getstaflist as $staff)
                                        <option value="{{ $staff->id }}"
                                            class="text-{{ session()->get('direction') == '2' ? 'end' : 'start' }}"
                                            {{ $invoice->staff_id == $staff->id ? 'selected' : '' }}>{{ $staff->name }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        @endif

                    @endif
                @endif
            @else
                @if (@helper::checkaddons('employee'))
                    @if ($staff_assign == 1)
                        @if ($invoice->status_type == 1 || $invoice->status_type == 2)
                            <select name="staff" class="btn dropdown-toggle border col-sm-auto col-12 bg-white fs-7"
                                id="staff_member">
                                <option value=""
                                    class="text-{{ session()->get('direction') == '2' ? 'end' : 'start' }}">
                                    {{ trans('labels.select') }}</option>
                                @foreach ($getstaflist as $staff)
                                    <option value="{{ $staff->id }}"
                                        class="text-{{ session()->get('direction') == '2' ? 'end' : 'start' }}">
                                        {{ $staff->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    @endif
                @endif
            @endif
            <div class="d-flex gap-2">
                @if (@helper::checkaddons('subscription'))
                    @if (@helper::checkaddons('google_calendar'))
                        @php
                            $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                ->orderByDesc('id')
                                ->first();

                            if (@$user->allow_without_subscription == 1) {
                                $calendar = 1;
                            } else {
                                $calendar = @$checkplan->calendar;
                            }
                        @endphp
                        @if (@$calendar == 1)
                            <td class="text-center">

                                @if ($invoice->status_type == 3 || $invoice->status_type == 4)
                                @else
                                    @if (Auth::user()->type == 4)
                                        @if (helper::check_access('role_bookings', Auth::user()->role_id, $vendor_id, 'manage') == 1)
                                            <a href="{{ URL::to('/admin/bookings/googlesync-' . $invoice->booking_number . '/' . $invoice->vendor_id . '/1') }}"
                                                class="btn btn-secondary header-btn-icon"
                                                tooltip="{{ trans('labels.google_calendar') }}"><i
                                                    class="fa-solid fa-calendar"></i></a>
                                        @else
                                            <a href="javascript:void(0)" class="btn btn-secondary header-btn-icon"
                                                tooltip="{{ trans('labels.google_calendar') }}"><i
                                                    class="fa-solid fa-calendar"></i></a>
                                        @endif
                                    @else
                                        <a href="{{ URL::to('/admin/bookings/googlesync-' . $invoice->booking_number . '/' . $invoice->vendor_id . '/1') }}"
                                            class="btn btn-secondary header-btn-icon"
                                            tooltip="{{ trans('labels.google_calendar') }}"><i
                                                class="fa-solid fa-calendar"></i></a>
                                    @endif
                                @endif
                            </td>
                        @endif
                    @endif
                @else
                    @if (@helper::checkaddons('google_calendar'))
                        <td class="text-center">

                            @if ($invoice->status_type == 3 || $invoice->status_type == 4)
                            @else
                                @if (Auth::user()->type == 4)
                                    @if (helper::check_access('role_bookings', Auth::user()->role_id, $vendor_id, 'manage') == 1)
                                        <a href="{{ URL::to('/admin/bookings/googlesync-' . $invoice->booking_number . '/' . $invoice->vendor_id . '/1') }}"
                                            class="btn btn-secondary header-btn-icon"
                                            tooltip="{{ trans('labels.google_calendar') }}"><i
                                                class="fa-solid fa-calendar"></i></a>
                                    @else
                                        <a href="javascript:void(0)" class="btn btn-secondary header-btn-icon"
                                            tooltip="{{ trans('labels.google_calendar') }}"><i
                                                class="fa-solid fa-calendar"></i></a>
                                    @endif
                                @else
                                    <a href="{{ URL::to('/admin/bookings/googlesync-' . $invoice->booking_number . '/' . $invoice->vendor_id . '/1') }}"
                                        class="btn btn-secondary header-btn-icon"
                                        tooltip="{{ trans('labels.google_calendar') }}"><i
                                            class="fa-solid fa-calendar"></i></a>
                                @endif
                            @endif
                        </td>
                    @endif
                @endif
                @if (@helper::checkaddons('subscription'))
                    @if (@helper::checkaddons('zoom'))
                        @php
                            $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                ->orderByDesc('id')
                                ->first();

                            if (@$user->allow_without_subscription == 1) {
                                $zoom = 1;
                            } else {
                                $zoom = @$checkplan->zoom;
                            }
                        @endphp
                        @if (@$zoom == 1)
                            <td class="text-center">

                                @if ($invoice->status_type == 3 || $invoice->status_type == 4)
                                @else
                                    @if (Auth::user()->type == 4)
                                        @if (helper::check_access('role_bookings', Auth::user()->role_id, $vendor_id, 'manage') == 1)
                                            @if ($invoice->join_url != null || $invoice->join_url != '')
                                                <a href="{{ $invoice->join_url }}"
                                                    class="btn btn-secondary header-btn-icon" target="_blank"
                                                    tooltip="{{ trans('labels.join_meeting') }}"><span class="join-icon"><i
                                                            class="fa-solid fa-plus"></i></span></a>
                                            @else
                                                <a @if (env('Environment') == 'sendbox') onclick="myFunction()" @else href="{{ URL::to('/admin/bookings/zoom-' . $invoice->booking_number . '/' . $invoice->vendor_id) }}" @endif
                                                    class="btn btn-secondary header-btn-icon"
                                                    tooltip="{{ trans('labels.zoom_meeting') }}"> <i
                                                        class="fa-solid fa-video"></i></a>
                                            @endif
                                        @endif
                                    @else
                                        @if ($invoice->join_url != null || $invoice->join_url != '')
                                            <a href="{{ $invoice->join_url }}" class="btn btn-secondary header-btn-icon"
                                                target="_blank" tooltip="{{ trans('labels.join_meeting') }}"><span
                                                    class="join-icon"><i class="fa-solid fa-plus"></i></span></a>
                                        @else
                                            <a @if (env('Environment') == 'sendbox') onclick="myFunction()" @else href="{{ URL::to('/admin/bookings/zoom-' . $invoice->booking_number . '/' . $invoice->vendor_id) }}" @endif
                                                class="btn btn-secondary header-btn-icon"
                                                tooltip="{{ trans('labels.zoom_meeting') }}"> <i
                                                    class="fa-solid fa-video"></i></a>
                                        @endif
                                    @endif
                                @endif
                            </td>
                        @endif
                    @endif
                @else
                    @if (@helper::checkaddons('zoom'))
                        <td class="text-center">
                            @if ($invoice->status_type == 3 || $invoice->status_type == 4)
                            @else
                                @if (Auth::user()->type == 4)
                                    @if (helper::check_access('role_bookings', Auth::user()->role_id, $vendor_id, 'manage') == 1)
                                        @if ($invoice->join_url != null || $invoice->join_url != '')
                                            <a href="{{ $invoice->join_url }}" class="btn btn-secondary header-btn-icon"
                                                target="_blank" tooltip="{{ trans('labels.join_meeting') }}"><span
                                                    class="join-icon"><i class="fa-solid fa-plus"></i></span></a>
                                        @else
                                            <a href="{{ URL::to('/admin/bookings/zoom-' . $invoice->booking_number . '/' . $invoice->vendor_id) }}"
                                                class="btn btn-secondary header-btn-icon"
                                                tooltip="{{ trans('labels.zoom_meeting') }}"> <i
                                                    class="fa-solid fa-video"></i></a>
                                        @endif
                                    @endif
                                @else
                                    @if ($invoice->join_url != null || $invoice->join_url != '')
                                        <a href="{{ $invoice->join_url }}" class="btn btn-secondary header-btn-icon"
                                            target="_blank" tooltip="{{ trans('labels.join_meeting') }}"><span
                                                class="join-icon"><i class="fa-solid fa-plus"></i></span></a>
                                    @else
                                        <a href="{{ URL::to('/admin/bookings/zoom-' . $invoice->booking_number . '/' . $invoice->vendor_id) }}"
                                            class="btn btn-secondary header-btn-icon"
                                            tooltip="{{ trans('labels.zoom_meeting') }}"> <i
                                                class="fa-solid fa-video"></i></a>
                                    @endif
                                @endif
                            @endif
                        </td>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3 pt-2">
            <div class="col">
                <div class="card box-shadow border-0 mb-3 h-100 d-flex">
                    <div
                        class="card-header d-flex align-items-center bg-transparent border-bottom text-dark py-3 justify-content-between">
                        <h6 class="px-2 fw-500 text-dark color-changer"><i class="fa-solid fa-clipboard fs-5"></i>
                            {{ trans('labels.booking_details') }}</h6>
                    </div>
                    <div class="card-body">

                        <div class="basic-list-group">
                            <ul class="list-group list-group-flush justify-content-between">
                                <li
                                    class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between align-items-center">
                                    <p class="color-changer">{{ trans('labels.booking_number') }}</p>
                                    <p class="text-dark color-changer fw-600">{{ $invoice->booking_number }}</p>
                                </li>
                                <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between ">
                                    <p class="color-changer">{{ trans('labels.booking_date') }}</p>
                                    <p class="text-muted">{{ helper::date_formate($invoice->created_at, $vendor_id) }}
                                    </p>
                                </li>

                                <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                    <p class="color-changer">{{ trans('labels.appoinment_date') }}</p>
                                    <p class="text-muted">
                                        {{ helper::date_formate($invoice->booking_date, $vendor_id) }}
                                    </p>
                                </li>
                                <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                    <p class="color-changer">{{ trans('labels.appoinment_time') }}</p>
                                    <p class="text-muted">{{ $invoice->booking_time }} -
                                        {{ $invoice->booking_endtime }}</p>
                                </li>
                                @if (@helper::checkaddons('vendor_tip'))
                                    @if (@helper::otherappdata($vendor_id)->tips_on_off == 1)
                                        <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                            <p class="color-changer">{{ trans('labels.tips_pro') }}</p>
                                            <p class="text-muted">
                                                {{ helper::currency_formate($invoice->tips, $invoice->vendor_id) }}
                                            </p>
                                        </li>
                                    @endif
                                @endif
                                {{-- payment_type = COD : 1,RazorPay : 2, Stripe : 3, Flutterwave : 4, Paystack : 5, Mercado Pago : 7, PayPal : 8, MyFatoorah : 9, toyyibpay : 10 --}}
                                @if ($invoice->transaction_type != '' && $invoice->transaction_type != null)
                                    <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                        <p class="color-changer">{{ trans('labels.payment_type') }}</p>
                                        <span class="text-muted">
                                            @if ($invoice->transaction_type == 6)
                                                {{ @helper::getpayment($invoice->transaction_type, $invoice->vendor_id)->payment_name }}
                                                : <small><a href="{{ helper::image_path($invoice->screenshot) }}"
                                                        target="_blank"
                                                        class="text-danger">{{ trans('labels.click_here') }}</a></small>
                                            @else
                                                {{ @helper::getpayment($invoice->transaction_type, $invoice->vendor_id)->payment_name }}
                                            @endif
                                        </span>
                                    </li>
                                @endif
                                @if (in_array($invoice->transaction_type, [2, 3, 4, 5, 7, 8, 9, 10, 11, 12, 13, 14, 15]))
                                    <li class="list-group-item px-0 fs-7 fw-500">
                                        <p class="color-changer">{{ trans('labels.transaction_id') }}</p>
                                        <p class="text-muted">
                                            {{ $invoice->transaction_id }}
                                        </p>
                                    </li>
                                @endif
                                @if ($invoice->booking_notes != '')
                                    <li class="list-group-item px-0 fs-7 fw-500">
                                        <p class="color-changer">{{ trans('labels.notes') }}</p>
                                        <p class="text-muted">
                                            {{ $invoice->booking_notes }}
                                        </p>
                                    </li>
                                @endif

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
                                            @if ($invoice->staff_id != '' && $invoice->staff_id != null)
                                                <li
                                                    class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                                    <p class="color-changer">{{ trans('labels.staff_member') }}</p>
                                                    <p class="text-muted">
                                                        {{ @helper::getslug($invoice->staff_id)->name }}</p>
                                                </li>
                                            @endif
                                        @endif
                                    @endif
                                @else
                                    @if (@helper::checkaddons('employee'))
                                        @if ($invoice->staff_id != '' && $invoice->staff_id != null)
                                            <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                                <p class="color-changer">{{ trans('labels.staff_member') }}</p>
                                                <p class="text-muted">
                                                    {{ @helper::getslug($invoice->staff_id)->name }}</p>
                                            </li>
                                        @endif
                                    @endif
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card box-shadow border-0 mb-3 h-100 d-flex">
                    <div
                        class="card-header d-flex align-items-center border-bottom bg-transparent text-dark py-3 justify-content-between">
                        <h6 class="px-2 fw-500 text-dark color-changer"><i class="fa-solid fa-user fs-5"></i>
                            {{ trans('labels.customer_info') }}
                        </h6>
                        <p class="text-muted cursor-pointer"
                            onclick="editcustomerdata('{{ $invoice->booking_number }}','{{ $invoice->customer_name }}','{{ $invoice->mobile }}','{{ $invoice->email }}','{{ str_replace(',', '|', $invoice->address) }}','{{ str_replace(',', '|', $invoice->city) }}','{{ str_replace(',', '|', $invoice->state) }}','{{ str_replace(',', '|', $invoice->country) }}','{{ str_replace(',', '|', $invoice->landmark) }}','{{ $invoice->postalcode }}','customer_info')">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <div class="row">
                                <div class="basic-list-group">
                                    <ul class="list-group list-group-flush justify-content-between">

                                        <li
                                            class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between align-items-center">
                                            <p class="color-changer">{{ trans('labels.name') }}</p>
                                            <p class="text-muted"> {{ $invoice->customer_name }}</p>
                                        </li>

                                        @if ($invoice->mobile != null)
                                            <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                                <p class="color-changer">{{ trans('labels.mobile') }}</p>
                                                <p class="text-muted">{{ $invoice->mobile }}</p>
                                            </li>
                                        @endif

                                        @if ($invoice->email != null)
                                            <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                                <p class="color-changer">{{ trans('labels.email') }}</p>
                                                <p class="text-muted">{{ $invoice->email }}</p>
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card box-shadow border-0 mb-3 h-100 d-flex">

                    <div
                        class="card-header d-flex align-items-center border-bottom bg-transparent text-dark py-3 justify-content-between">
                        <h6 class="px-2 fw-500 text-dark color-changer"><i class="fa-solid fa-file-invoice fs-5"></i>
                            {{ trans('labels.bill_to') }}
                        </h6>
                        <p class="text-muted cursor-pointer"
                            onclick="editcustomerdata('{{ $invoice->booking_number }}','{{ $invoice->customer_name }}','{{ $invoice->mobile }}','{{ $invoice->email }}','{{ str_replace(',', '|', $invoice->address) }}','{{ str_replace(',', '|', $invoice->city) }}','{{ str_replace(',', '|', $invoice->state) }}','{{ str_replace(',', '|', $invoice->country) }}','{{ str_replace(',', '|', $invoice->landmark) }}','{{ $invoice->postalcode }}','delivery_info')">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <div class="basic-list-group">
                                        <ul class="list-group list-group-flush justify-content-between">
                                            <li
                                                class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between align-items-center">
                                                <p class="color-changer">{{ trans('labels.address') }}</p>
                                                <p class="text-muted"> {{ $invoice->address }}</p>
                                            </li>
                                            <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                                <p class="color-changer">{{ trans('labels.landmark') }}</p>
                                                <p class="text-muted">{{ $invoice->landmark }}</p>
                                            </li>
                                            <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                                <p class="color-changer">{{ trans('labels.pincode') }}</p>
                                                <p class="text-muted"> {{ $invoice->postalcode }}</p>
                                            </li>
                                            <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                                <p class="color-changer">{{ trans('labels.city') }}</p>
                                                <p class="text-muted">{{ $invoice->city }}</p>
                                            </li>
                                            <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                                <p class="color-changer">{{ trans('labels.state') }}</p>
                                                <p class="text-muted">{{ $invoice->state }}</p>
                                            </li>
                                            <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                                <p class="color-changer">{{ trans('labels.country') }}</p>
                                                <p class="text-muted">{{ $invoice->country }}.</p>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card box-shadow border-0 mb-3 h-100 d-flex">
                    <div
                        class="card-header d-flex align-items-center border-bottom bg-transparent text-dark py-3 justify-content-between">
                        <h6 class="px-2 fw-500 text-dark color-changer"><i class="fa-solid fa-clipboard fs-5"></i>
                            {{ trans('labels.notes') }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <div class="row">
                                <div class="basic-list-group">
                                    @if ($invoice->vendor_note != '')
                                        <div class="alert alert-info" role="alert">
                                            {{ $invoice->vendor_note }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top">
                        <form action="{{ URL::to('admin/bookings/vendor_note') }}" method="POST">
                            @csrf
                            <div class="form-group col-md-12">
                                <label for="note"> {{ trans('labels.notes') }} </label>
                                <div class="controls">
                                    <input type="hidden" name="order_id" class="form-control"
                                        value="{{ $invoice->booking_number }}">
                                    <input type="text" name="vendor_note" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                                <button
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" type="submit" @endif
                                    class="btn btn-primary"> {{ trans('labels.update') }} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 my-3 box-shadow">
                <div
                    class="card-header d-flex border-bottom align-items-center bg-transparent text-dark color-changer py-3">
                    <i class="fa-solid fa-bag-shopping fs-5"></i>
                    <h6 class="px-2 fw-500">{{ trans('labels.bookings') }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="text-capitalize fs-15 fw-500">
                                    <td>{{ trans('labels.service') }}</td>
                                    <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                                        {{ trans('labels.date_time') }}</td>
                                    <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                                        {{ trans('labels.total') }}</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="align-middle fs-7 fw-500">
                                    <td>{{ $invoice->service_name }}
                                        @if (@helper::checkaddons('additional_service'))
                                            @if ($invoice->additional_service_id != null && $invoice->additional_service_id != '')
                                                <p class="text-muted cursor-pointer"
                                                    onclick="custoimze('{{ $invoice->additional_service_name }}','{{ $invoice->additional_service_price }}')">
                                                    {{ trans('labels.customize') }}
                                                </p>
                                            @endif
                                        @endif
                                    </td>

                                    <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                                        {{ helper::date_formate($invoice->booking_date, $vendor_id) }}<br>{{ $invoice->booking_time }}
                                        - {{ $invoice->booking_endtime }}</td>
                                    <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                                        {{ helper::currency_formate($invoice->sub_total, $invoice->vendor_id) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-15 fw-500 p-2"
                                        colspan="2">
                                        {{ trans('labels.subtotal') }}
                                    </td>
                                    <td
                                        class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-16 fw-500 p-2">
                                        {{ helper::currency_formate($invoice->sub_total, $invoice->vendor_id) }}
                                    </td>
                                </tr>
                                @if (@helper::checkaddons('additional_service'))
                                    @if ($invoice->additional_service_price != '' && $invoice->additional_service_price != null)
                                        @php
                                            $add_service_price = 0;
                                            $add_price = explode('|', $invoice->additional_service_price);
                                            foreach ($add_price as $price) {
                                                $add_service_price += (float) $price;
                                            }

                                        @endphp
                                        <tr>
                                            <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-15 fw-500 p-2"
                                                colspan="2">
                                                {{ trans('labels.additional_service') }}
                                            </td>
                                            <td
                                                class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-16 fw-500 p-2">
                                                {{ helper::currency_formate($add_service_price, $invoice->vendor_id) }}
                                            </td>
                                        </tr>
                                    @endif
                                @endif

                                @if ($invoice->tax != '' && $invoice->tax != null)
                                    @php
                                        $tax = explode('|', $invoice->tax);
                                        $tax_name = explode('|', $invoice->tax_name);
                                    @endphp
                                    @foreach ($tax as $key => $tax_value)
                                        <tr>
                                            <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-15 fw-500 p-2"
                                                colspan="2"> {{ $tax_name[$key] }}
                                            </td>
                                            <td
                                                class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-16 fw-500 p-2">
                                                {{ helper::currency_formate((float) $tax[$key], $invoice->vendor_id) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if ($invoice->offer_amount > 0)
                                    <tr>
                                        <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-15 fw-500 p-2"
                                            colspan="2">
                                            {{ trans('labels.discount') }}({{ $invoice->offer_code == '' ? '-' : $invoice->offer_code }})
                                        </td>
                                        <td
                                            class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-16 fw-500 p-2">
                                            -{{ helper::currency_formate($invoice->offer_amount, $invoice->vendor_id) }}
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-16 fw-600 p-2"
                                        colspan="2">
                                        {{ trans('labels.grand_total') }}
                                    </td>
                                    <td
                                        class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-16 fw-600 p-2">
                                        {{ helper::currency_formate($invoice->grand_total, $invoice->vendor_id) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- addtional_service Modal --}}
    <div class="modal fade" id="addtional_service" tabindex="-1" aria-labelledby="addtional_serviceLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h1 class="modal-title fs-5 fw-600 m-0 color-changer" id="addtional_service">
                        {{ trans('labels.additional_service') }}
                    </h1>
                    <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="item-additional_service" class="">
                        <ul class="m-0 ps-2 fs-7">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<div class="modal fade" id="customerinfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <h5 class="modal-title color-changer" id="modalbankdetailsLabel">{{ trans('labels.edit') }}</h5>
                <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                </button>
            </div>
            <form class="m-0 overflow-auto" action="{{ URL::to('admin/bookings/customerinfo') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="order_id" id="modal_order_id" class="form-control" value="">
                    <input type="hidden" name="edit_type" id="edit_type" class="form-control" value="">
                    <div id="customer_info">
                        <div class="form-group col-md-12">
                            <label for="customer_name" class="form-label"> {{ trans('labels.customer_name') }}
                            </label>
                            <div class="controls">
                                <input type="text" name="customer_name" id="customer_name" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="form-group col-md-12" class="form-label">
                            <label for="customer_mobile" class="form-label"> {{ trans('labels.mobile') }} </label>
                            <div class="controls">
                                <input type="text" name="customer_mobile" id="customer_mobile"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="customer_email" class="form-label"> {{ trans('labels.email') }} </label>
                            <div class="controls">
                                <input type="text" name="customer_email" id="customer_email" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div id="delivery_info">
                        <div class="form-group col-md-12">
                            <label for="customer_address" class="form-label"> {{ trans('labels.address') }} </label>
                            <div class="controls">
                                <input type="text" name="customer_address" id="customer_address"
                                    class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="customer_landmark" class="form-label"> {{ trans('labels.landmark') }}
                            </label>
                            <div class="controls">
                                <input type="text" name="customer_landmark" id="customer_landmark"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="customer_pincode" class="form-label"> {{ trans('labels.pincode') }} </label>
                            <div class="controls">
                                <input type="text" name="customer_pincode" id="customer_pincode"
                                    class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="customer_city" class="form-label"> {{ trans('labels.city') }} </label>
                            <div class="controls">
                                <input type="text" name="customer_city" id="customer_city" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="customer_state" class="form-label"> {{ trans('labels.state') }} </label>
                            <div class="controls">
                                <input type="text" name="customer_state" id="customer_state" class="form-control"
                                    required>
                            </div>
                        </div>
                        <div class="form-group col-md-12" class="form-label">
                            <label for="customer_country"> {{ trans('labels.country') }} </label>
                            <div class="controls">
                                <input type="text" name="customer_country" id="customer_country"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger px-sm-4"
                        data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                    <button @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" type="submit" @endif
                        class="btn btn-primary px-sm-4"> {{ trans('labels.save') }} </button>
                </div>
            </form>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        $('#staff_member').on('change', function() {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: "{{ URL::to('admin/staff_member-' . $invoice->booking_number) }}",
                type: "post",
                dataType: "json",
                data: {
                    booking_number: "{{ $invoice->booking_number }}",
                    vendor_id: "{{ $invoice->vendor_id }}",
                    staff_id: $('#staff_member').find(':selected').val(),
                },
                success: function(response) {
                    if (response.status == "1") {
                        location.reload();
                        toastr.success(response.message);

                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        });
    </script>
    <script>
        function editcustomerdata(order_id, customer_name, customer_mobile, customer_email, customer_address, customer_city,
            customer_state, customer_country, customer_landmark, customer_pincode, type) {
            "use strict";
            $('#customerinfo').modal('show');
            $('#modal_order_id').val(order_id);
            if (type == "customer_info") {
                $('#customer_info').show();
                $('#customer_name').val(customer_name);
                $('#customer_mobile').val(customer_mobile);
                $('#customer_email').val(customer_email);
                $('#edit_type').val(type);
                $('#delivery_info').hide();
                $('#customer_address').removeAttr('required');
                $('#customer_city').removeAttr('required');
                $('#customer_state').removeAttr('required');
                $('#customer_country').removeAttr('required');
                $('#customer_landmark').removeAttr('required');
                $('#customer_pincode').removeAttr('required');
            }
            if (type == "delivery_info") {
                $('#delivery_info').show();
                $('#customer_address').val(customer_address.replace(/[|]+/g, ","));
                $('#customer_city').val(customer_city.replace(/[|]+/g, ","));
                $('#customer_landmark').val(customer_landmark.replace(/[|]+/g, ","));
                $('#customer_state').val(customer_state.replace(/[|]+/g, ","));
                $('#customer_country').val(customer_country.replace(/[|]+/g, ","));
                $('#customer_pincode').val(customer_pincode);
                $('#edit_type').val(type);
                $('#customer_info').hide();
                $('#customer_name').removeAttr('required');
                $('#customer_email').removeAttr('required');
                $('#customer_mobile').removeAttr('required');
            }
        }
    </script>
    <script>
        function custoimze(name, price) {

            var price = price.split('|');
            var name = name.split('|');
            // console.log(price);

            var html1 = '';
            if (name != '') {
                html1 += '<ul class="mt-1 {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">';
                for (i in name) {
                    html1 +=
                        '<li class="px-0 fw-500 fs-7 my-1 d-flex color-changer align-items-center justify-content-between">' +
                        name[i] + '<span class="text-dark color-changer fs-7">' +
                        currency_formate(parseFloat(
                            price[i])) + '</span></li>'
                }
                html1 += '</ul>';
            }
            $('#item-additional_service').html(html1);
            $("#addtional_service").modal('show');

        }
    </script>
@endsection
