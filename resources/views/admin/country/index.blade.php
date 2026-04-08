@extends('admin.layout.default')
@section('content')
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $module = 'role_countries';
    @endphp
    @include('admin.breadcrumb.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 my-3 box-shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered py-3 zero-configuration w-100">
                            <thead>
                                <tr class="text-capitalize fw-500 fs-15">
                                    <td></td>
                                    @if (@helper::checkaddons('bulk_delete'))
                                        @if($allcontries->count() > 0)
                                            <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                                        @endif
                                    @endif
                                    <td>{{ trans('labels.srno') }}</td>
                                    <td>{{ trans('labels.country') }}</td>
                                    <td>{{ trans('labels.status') }}</td>
                                    <td>{{ trans('labels.created_date') }}</td>
                                    <td>{{ trans('labels.updated_date') }}</td>
                                    <td>{{ trans('labels.action') }}</td>
                                </tr>
                            </thead>
                            <tbody id="tabledetails" data-url="{{ url('admin/countries/reorder_country') }}">
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($allcontries as $country)
                                    <tr class="fs-7 row1 align-middle" id="dataid{{ $country->id }}"
                                        data-id="{{ $country->id }}">
                                        <td><a tooltip="{{ trans('labels.move') }}"><i
                                                    class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                                        
                                        @if (@helper::checkaddons('bulk_delete'))
                                            <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $country->id }}"></td>
                                        @endif

                                        <td>@php
                                            echo $i++;
                                        @endphp</td>
                                        <td>{{ $country->name }}</td>
                                        <td>
                                            @if ($country->is_available == '1')
                                                <a href="javascript:void(0)" tooltip="{{ trans('labels.active') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('/admin/countries/change_status-' . $country->id . '/2') }}')" @endif
                                                    class="btn btn-sm btn-outline-success hov {{ Auth::user()->type == 4 ? (helper::check_access('role_countries', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                    <i class="fa-regular fa-check"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0)" tooltip="{{ trans('labels.inactive') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('/admin/countries/change_status-' . $country->id . '/1') }}')" @endif
                                                    class="btn btn-sm btn-outline-danger hov {{ Auth::user()->type == 4 ? (helper::check_access('role_countries', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                    <i class="fa-regular fa-xmark"></i>
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{ helper::date_formate($country->created_at, $vendor_id) }}<br>
                                            {{ helper::time_format($country->created_at, $vendor_id) }}
                                        </td>
                                        <td>{{ helper::date_formate($country->updated_at, $vendor_id) }}<br>
                                            {{ helper::time_format($country->updated_at, $vendor_id) }}
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <a href="{{ URL::to('admin/countries/edit-' . $country->id) }}"
                                                    tooltip="{{ trans('labels.edit') }}"
                                                    class="btn btn-info hov btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_countries', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>
                                                <a tooltip="{{ trans('labels.delete') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else  onclick="statusupdate('{{ URL::to('admin/countries/delete-' . $country->id) }}')" @endif
                                                    class="btn btn-danger hov btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_countries', Auth::user()->role_id, $vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}">
                                                    <i class="fa-regular fa-trash"></i>
                                                </a>
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
