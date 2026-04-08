@php
    if (Auth::user()->type == 4) {
        $vendor_id = Auth::user()->vendor_id;
    } else {
        $vendor_id = Auth::user()->id;
    }
    $user = App\Models\User::where('id', $vendor_id)->first();
    if (request()->is('admin/bookings')) {
        $module = 'role_bookings';
    } elseif (request()->is('admin/reports')) {
        $module = 'role_reports';
    } elseif (request()->is('admin/dashboard')) {
        $module = 'role_dashboard';
    } elseif (str_contains(request()->url(), 'customers')) {
        $module = 'role_customers';
    }
@endphp
<div class="table-responsive">
    <table class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">
        <thead>
            <tr class="text-capitalize fw-500 fs-15">
                <td>{{ trans('labels.srno') }}</td>
                @if (request()->is('admin/customers*') && Auth::user()->type == 1)
                    <td>{{ trans('labels.vendor_title') }}</td>
                @endif
                <td>{{ trans('labels.booking_number') }}</td>
                <td>{{ trans('labels.date_time') }}</td>
                <td>{{ trans('labels.grand_total') }}</td>
                @if (@helper::checkaddons('custom_status'))
                    <td>{{ trans('labels.status') }}</td>
                @endif
                <td>{{ trans('labels.created_date') }}</td>
                <td>{{ trans('labels.updated_date') }}</td>
                <td>{{ trans('labels.action') }}</td>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($getbookings as $booking)
                <tr class="fs-7 align-middle">
                    <td>@php
                        echo $i++;
                    @endphp</td>
                    @if (request()->is('admin/customers*') && Auth::user()->type == 1)
                        <td>{{ $booking['vendorinfo']->name }}</td>
                    @endif
                    <td>
                        <div class="d-flex justify-content-between">
                            <a href="{{ URL::to('/admin/invoice-' . $booking->vendor_id . '-' . $booking->booking_number) }}"
                                class="color-changer">{{ $booking->booking_number }}</a>
                            @if ($booking->vendor_note != '')
                                <a href="javascript:void(0)" class="btn btn-primary btn-sm hov"
                                    tooltip="{{ $booking->vendor_note }}">
                                    <i class="fa-solid fa-clipboard"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                    <td>{{ helper::date_formate($booking->booking_date, $vendor_id) }}<br><small>{{ $booking->booking_time }}
                            -
                            {{ $booking->booking_endtime }}</small>
                    </td>
                    <td>{{ helper::currency_formate($booking->grand_total, $booking->vendor_id) }}
                        <br>
                        @if ($booking->payment_status == 1)
                            <small class="text-danger"><i class="far fa-clock"></i>
                                {{ trans('labels.unpaid') }}</small>
                        @else
                            <small class="text-success"><i class="far fa-clock"></i>
                                {{ trans('labels.paid') }}</small>
                        @endif
                    </td>
                    @if (@helper::checkaddons('custom_status'))
                        <td>
                            @if ($booking->status_type == '1')
                                <span
                                    class="badge bg-warning">{{ @helper::gettype($booking->status, $booking->status_type, $vendor_id, 1)->name == null ? '-' : @helper::gettype($booking->status, $booking->status_type, $vendor_id, 1)->name }}</span>
                            @elseif($booking->status_type == '2')
                                <span
                                    class="badge bg-info">{{ @helper::gettype($booking->status, $booking->status_type, $vendor_id, 1)->name == null ? '-' : @helper::gettype($booking->status, $booking->status_type, $vendor_id, 1)->name }}</span>
                            @elseif($booking->status_type == '3')
                                <span
                                    class="badge bg-success">{{ @helper::gettype($booking->status, $booking->status_type, $vendor_id, 1)->name == null ? '-' : @helper::gettype($booking->status, $booking->status_type, $vendor_id, 1)->name }}</span>
                            @elseif($booking->status_type == '4')
                                <span
                                    class="badge bg-danger">{{ @helper::gettype($booking->status, $booking->status_type, $vendor_id, 1)->name == null ? '-' : @helper::gettype($booking->status, $booking->status_type, $vendor_id, 1)->name }}</span>
                            @else
                                --
                            @endif
                        </td>
                    @endif
                    <td>{{ helper::date_formate($booking->created_at, $vendor_id) }}<br>
                        {{ helper::time_format($booking->created_at, $vendor_id) }}
                    </td>
                    <td>{{ helper::date_formate($booking->updated_at, $vendor_id) }}<br>
                        {{ helper::time_format($booking->updated_at, $vendor_id) }}
                    </td>
                    <td>
                        <div class="d-flex gap-2 flex-wrap align-items-center">
                            <a class="btn btn-sm hov btn-secondary" tooltip="{{ trans('labels.view') }}"
                                href="{{ Auth::user()->type == 4 ? (helper::check_access($module, Auth::user()->role_id, $vendor_id, 'manage') == 1 ? URL::to('/admin/invoice-' . $booking->vendor_id . '-' . $booking->booking_number) : '#') : URL::to('/admin/invoice-' . $booking->vendor_id . '-' . $booking->booking_number) }}">
                                <i class="fa-regular fa-eye"></i>
                            </a>
                            @if (Auth::user()->type == 2 || Auth::user()->type == 4)
                                @if (
                                    ($booking->transaction_type == '' || $booking->transaction_type == 6 || $booking->transaction_type == 1) &&
                                        ($booking->payment_status == 1 && $booking->status_type != '4' && $booking->status_type == '3'))
                                    <a class="btn btn-sm hov btn-primary {{ Auth::user()->type == 4 ? (helper::check_access($module, Auth::user()->role_id, $vendor_id, 'manage') == 1 ? '' : 'd-none') : '' }}"
                                        href="javascript:void(0)" tooltip="{{ trans('labels.payments') }}"
                                        onclick="payment('{{ $booking->booking_number }}','{{ $booking->grand_total }}','{{ $booking->transaction_type }}','{{ helper::image_path($booking->screenshot) }}')">
                                        <i class="fa-solid fa-dollar-sign"></i>
                                    </a>
                                @endif
                            @endif
                            <a href="{{ URL::to('/admin/bookings/generatepdf/' . $booking->vendor_id . '/' . $booking->booking_number) }}"
                                class="btn btn-danger cursor-pointer hov" tooltip="{{ trans('labels.pdf') }}">
                                <i class="fa-solid fa-file-pdf"></i></a>
                        </div>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- cod transfer modal --}}
<div class="modal fade" id="cod_payment_modal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <h5 class="modal-title text-dark color-changer" id="paymentModalLabel">{{ trans('labels.record_payment') }}</h5>
                <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                </button>
            </div>
            <form action="{{ URL::to('admin/bookings/payment_status-2') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="booking_number" name="booking_number" value="">
                    <input type="hidden" id="payment_type" name="payment_type" value="">
                    <div id="cod_payment">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="modal_total_amount" class="form-label">
                                    {{ trans('labels.total') }} {{ trans('labels.amount') }}
                                </label>
                                <input type="text" class="form-control numbers_only" name="modal_total_amount"
                                    id="modal_total_amount" disabled value="">
                            </div>
                            <div class="col-12">
                                <label for="modal_amount" class="form-label">
                                    {{ trans('labels.cash_received') }}
                                </label>
                                <input type="text" class="form-control numbers_only" name="modal_amount"
                                    id="modal_amount" value="" onkeyup="validation($(this).val())" required>
                            </div>
                            <div class="col-12">
                                <label for="modal_amount" class="form-label">
                                    {{ trans('labels.change_amount') }}
                                </label>
                                <input type="number" class="form-control" name="ramin_amount" id="ramin_amount"
                                    value="" readonly>
                            </div>
                        </div>
                    </div>
                    <div id="bank_payment">
                        <img src='' id="bank_detail" class="w-100 h-100" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger px-sm-4" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary px-sm-4">{{ trans('labels.submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
