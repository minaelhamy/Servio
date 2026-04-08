@extends('admin.layout.default')
@section('content')
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $module = 'role_custom_status';
    @endphp
    @include('admin.breadcrumb.breadcrumb')
    <div class="row mt-3">

        <div class="col-12">
            <div class="card border-0 my-3 box-shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered py-3 zero-configuration zero-configuration1 w-100">
                            <thead>
                                <tr class="text-capitalize fw-500 fs-15">
                                    <td></td>
                                    <td>{{ trans('labels.srno') }}</td>
                                    <td>{{ trans('labels.status_use') }}</td>
                                    <td>{{ trans('labels.status') }} {{ trans('labels.type') }}</td>
                                    <td>{{ trans('labels.name') }}</td>
                                    <td>{{ trans('labels.status') }}</td>
                                    <td>{{ trans('labels.created_date') }}</td>
                                    <td>{{ trans('labels.updated_date') }}</td>
                                    <td>{{ trans('labels.action') }}</td>
                                </tr>
                            </thead>
                            <tbody id="tabledetails" data-url="{{ url('admin/custom_status/reorder_status') }}">
                                @foreach ($status as $key => $status)
                                    <tr class="fs-7 row1 align-middle" id="dataid{{ $status->id }}"
                                        data-id="{{ $status->id }}">
                                        <td><a tooltip="{{ trans('labels.move') }}">
                                                <i class="fa-light fa-up-down-left-right mx-2"></i>
                                            </a>
                                        </td>
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            @if ($status->status_use == 1)
                                                {{ trans('labels.booking') }}
                                            @elseif($status->status_use == 2)
                                                {{ trans('labels.order_s') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($status->type == 1)
                                                {{ trans('labels.default') }}
                                            @elseif($status->type == 2)
                                                {{ trans('labels.process') }}
                                            @elseif($status->type == 3)
                                                {{ trans('labels.complete') }}
                                            @elseif($status->type == 4)
                                                {{ trans('labels.cancel') }}
                                            @endif
                                        </td>
                                        <td>{{ $status->name }}</td>
                                        <td>
                                            @if ($status->type == 2)
                                                @if ($status->is_available == '1')
                                                    <a @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/custom_status/change_status-' . $status->id . '/2') }}')" @endif
                                                        class="btn btn-sm btn-outline-success hov {{ Auth::user()->type == 4 ? (helper::check_access('role_custom_status', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                        tooltip="{{ trans('labels.active') }}"><i
                                                            class="fa-regular fa-check"></i></a>
                                                @else
                                                    <a @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/custom_status/change_status-' . $status->id . '/1') }}')" @endif
                                                        class="btn btn-sm btn-outline-danger hov {{ Auth::user()->type == 4 ? (helper::check_access('role_custom_status', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                        tooltip="{{ trans('labels.inactive') }}"><i
                                                            class="fa-regular fa-xmark"></i></a>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ helper::date_formate($status->created_at, $vendor_id) }}<br>
                                            {{ helper::time_format($status->created_at, $vendor_id) }}
                                        </td>
                                        <td>{{ helper::date_formate($status->updated_at, $vendor_id) }}<br>
                                            {{ helper::time_format($status->updated_at, $vendor_id) }}
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <a href="{{ URL::to('admin/custom_status/edit-' . $status->id) }}"
                                                    class="btn btn-info hov btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_custom_status', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                    tooltip="{{ trans('labels.edit') }}"> <i
                                                        class="fa-regular fa-pen-to-square"></i></a>
                                                @if ($status->type == 2)
                                                    @if (@helper::checkaddons('custom_status'))
                                                        <a @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/custom_status/delete-' . $status->id) }}')" @endif
                                                            class="btn btn-danger hov btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_custom_status', Auth::user()->role_id, Auth::user()->vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}"
                                                            tooltip="{{ trans('labels.delete') }}"> <i
                                                                class="fa-regular fa-trash"></i></a>
                                                    @endif
                                                @endif
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
    </div>
@endsection
