@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
    @endphp
    <div class="col-12">
        <div class="card border-0 my-3 box-shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered py-3 zero-configuration w-100">
                        <thead>
                            <tr class="text-capitalize fw-500 fs-15">
                                <td>{{ trans('labels.srno') }}</td>
                                <td>{{ trans('labels.transaction_number') }}</td>
                                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                    <td>{{ trans('labels.name') }}</td>
                                @endif
                                <td>{{ trans('labels.plan_name') }}</td>
                                <td>{{ trans('labels.total') }} {{ trans('labels.amount') }}</td>
                                <td>{{ trans('labels.payment_type') }}</td>
                                <td>{{ trans('labels.purchase_date') }}</td>
                                <td>{{ trans('labels.expire_date') }}</td>
                                <td>{{ trans('labels.status') }}</td>
                                <td>{{ trans('labels.created_date') }}</td>
                                <td>{{ trans('labels.updated_date') }}</td>
                                <td>{{ trans('labels.action') }}</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($transaction as $transaction)
                                <tr class="fs-7 align-middle">
                                    <td>@php echo $i++; @endphp</td>
                                    <td>{{ $transaction->transaction_number }}</td>
                                    @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                        <td>{{ $transaction['vendor_info']->name }}</td>
                                    @endif
                                    <td>{{ $transaction['plan_info']->name }}</td>
                                    <td>{{ helper::currency_formate($transaction->amount, '') }}</td>
                                    <td>
                                        {{ @helper::getpayment($transaction->payment_type, $vendor_id)->payment_name }}
                                        @if ($transaction->payment_type == 6)
                                            : <small>
                                                <a href="{{ helper::image_path($transaction->screenshot) }}" target="_blank"
                                                    class="text-danger">{{ trans('labels.click_here') }}</a>
                                            </small>
                                        @else
                                            : {{ $transaction->payment_id }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($transaction->payment_type == 6 || $transaction->payment_type == 1)
                                            @if ($transaction->status == 2)
                                                <span
                                                    class="badge bg-success">{{ helper::date_formate($transaction->purchase_date, $vendor_id) }}</span>
                                            @else
                                                -
                                            @endif
                                        @else
                                            <span
                                                class="badge bg-success">{{ helper::date_formate($transaction->purchase_date, $vendor_id) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($transaction->payment_type == 6 || $transaction->payment_type == 1)
                                            @if ($transaction->status == 2)
                                                <span
                                                    class="badge bg-danger">{{ $transaction->expire_date != '' ? helper::date_formate($transaction->expire_date, $vendor_id) : '-' }}</span>
                                            @else
                                                -
                                            @endif
                                        @else
                                            <span
                                                class="badge bg-danger">{{ $transaction->expire_date != '' ? helper::date_formate($transaction->expire_date, $vendor_id) : '-' }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($transaction->payment_type == 6 || $transaction->payment_type == 1)
                                            @if ($transaction->status == 1)
                                                <span class="badge bg-warning">{{ trans('labels.pending') }}</span>
                                            @elseif ($transaction->status == 2)
                                                <span class="badge bg-success">{{ trans('labels.accepted') }}</span>
                                            @elseif ($transaction->status == 3)
                                                <span class="badge bg-danger">{{ trans('labels.rejected') }}</span>
                                            @else
                                                -
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ helper::date_formate($transaction->created_at, $vendor_id) }}<br>
                                        {{ helper::time_format($transaction->created_at, $vendor_id) }}
                                    </td>
                                    <td>{{ helper::date_formate($transaction->updated_at, $vendor_id) }}<br>
                                        {{ helper::time_format($transaction->updated_at, $vendor_id) }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                            @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                                @if ($transaction->payment_type == 6 || $transaction->payment_type == 1)
                                                    @if ($transaction->status == 1)
                                                        <a class="btn btn-sm btn-success hov"
                                                            tooltip="{{ trans('labels.active') }}"
                                                            onclick="statusupdate('{{ URL::to('admin/transaction-' . $transaction->id . '-2') }}')"><i
                                                                class="fas fa-check"></i></a>

                                                        <a class="btn btn-sm btn-danger hov"
                                                            tooltip="{{ trans('labels.inactive') }}"
                                                            onclick="statusupdate('{{ URL::to('admin/transaction-' . $transaction->id . '-3') }}')"><i
                                                                class="fas fa-close"></i></a>
                                                    @endif
                                                @endif
                                            @endif
                                            <a class="btn btn-sm btn-secondary hov" tooltip="{{ trans('labels.view') }}"
                                                href="{{ URL::to('admin/transaction/plandetails-' . $transaction->id) }}"><i
                                                    class="fa-regular fa-eye"></i></a>
                                            <a href="{{ URL::to('/admin/transaction/generatepdf-' . $transaction->id) }}"
                                                class="btn btn-sm btn-primary hov"><i class="fa-solid fa-file-pdf"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
