<table class="table table-striped table-bordered py-3 zero-configuration w-100">

    <thead>

        <tr class="text-capitalize fw-500 fs-15">
            <td>{{ trans('labels.srno') }}</td>
            <td>{{ trans('labels.booking_number') }}</td>
            <td>{{ trans('labels.service') }}</td>
            <td>{{ trans('labels.date') }}</td>
            <td>{{ trans('labels.payment_type') }}</td>
            @if (@helper::checkaddons('google_calendar'))
                <?php
                $checkplan = App\Models\Transaction::where('vendor_id', Auth::user()->id)
                    ->orderByDesc('id')
                    ->first();
                ?>
                @if (@$checkplan->calendar == 1)
                    <td>{{ trans('labels.google_calendar') }}</td>
                @endif
            @endif
            @if (@helper::checkaddons('zoom'))
                <?php
                $checkplan = App\Models\Transaction::where('vendor_id', Auth::user()->id)
                    ->orderByDesc('id')
                    ->first();
                ?>
                @if (@$checkplan->zoom == 1)
                    <td>{{ trans('labels.zoom_meeting') }}</td>
                @endif
            @endif
            <td>{{ trans('labels.status') }}</td>
            <td>{{ trans('labels.action') }}</td>

        </tr>
    </thead>

    <tbody>

        @php $i = 1; @endphp

        @foreach ($transaction as $booking)

            <tr class="fs-7 align-middle">
                <td>@php
                    echo $i++;
                @endphp</td>
                <td>{{ $booking->booking_number }}</td>
                <td>
                    <a href="{{ URL::to('/admin/invoice-' . $booking->booking_number) }} ">
                        <p class="fw-bold">{{ $booking->service_name }}</p>
                    </a>
                </td>
                <td>{{ $booking->booking_date }}<br><small>{{ $booking->booking_time }}</small>
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
                @if (@helper::checkaddons('google_calendar'))
                    <?php
                    $checkplan = App\Models\Transaction::where('vendor_id', Auth::user()->id)
                        ->orderByDesc('id')
                        ->first();
                    ?>
                    @if (@$checkplan->calendar == 1)
                        <td class="text-center">
                            @if ($booking->status == 5)
                                -
                            @else
                                <a href="{{ URL::to('/admin/bookings/googlesync-' . $booking->booking_number . '/' . $booking->vendor_id . '/1') }}"
                                    class="text-success">{{ trans('labels.click_google_event') }}</a>
                            @endif
                        </td>
                    @endif
                @endif

                @if (@helper::checkaddons('zoom'))
                    <?php
                    $checkplan = App\Models\Transaction::where('vendor_id', Auth::user()->id)
                        ->orderByDesc('id')
                        ->first();
                    ?>
                    @if (@$checkplan->zoom == 1)
                        <td>
                            @if ($booking->status == 5)
                                -
                            @else
                                <a href="{{ URL::to('/admin/bookings/zoom-' . $booking->booking_number . '/' . $booking->vendor_id) }}"
                                    class="text-success">
                                    @if ($booking->join_url != null || $booking->join_url != '')
                                        <a href="{{ $booking->join_url }}"
                                            target="_blank">{{ trans('labels.join_meeting') }}</a>
                                    @else
                                        {{ trans('labels.click_zoom') }}
                                    @endif
                                </a>
                            @endif
                        </td>
                    @endif
                @endif
                <td>
                    @if ($booking->status == 1)
                    @php
                        $status = trans('labels.pending');
                        $color = 'warning';
                    @endphp
                @elseif ($booking->status == 2)
                    @php
                        $status = trans('labels.accepted');
                        $color = 'info';
                    @endphp
                @elseif ($booking->status == 3)
                    @php
                        $status = trans('labels.rejected');
                        $color = 'danger';
                    @endphp
                @elseif ($booking->status == 4)
                    @php
                        $status = trans('labels.cancelled');
                        $color = 'danger';
                    @endphp
                @elseif ($booking->status == 5)
                    @php
                        $status = trans('labels.completed');
                        $color = 'success';
                    @endphp
                @endif
                <span class="badge bg-{{ $color }}">{{ $status }}</span></td>
                <td>
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        @if ($booking->status == 5 && $booking->payment_status == 1)
                            <a class="btn btn-sm hov btn-primary" href="javascript:void(0)" tooltip="{{trans('labels.pyment')}}"
                                onclick="payment('{{ $booking->booking_number }}','{{ $booking->grand_total }}')">{{ trans('labels.record_payment') }}</a>
                        @else
                            <a class="btn btn-sm hov btn-primary">{{ trans('labels.record_payment') }}</a>
                        @endif
                        <a class="btn btn-sm hov btn-primary" tooltip="{{trans('labels.view')}}"
                            href="{{ url::to('/admin/invoice-' . $booking->booking_number) }} "><i
                                class="fa-light fa-circle-info"></i></a>
                    </div>
                </td>
            </tr>
        @endforeach

    </tbody>

</table>
