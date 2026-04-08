@extends('admin.layout.default')

@section('content')
    @php

        $module = 'role_employees';

        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }

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
                                        @if($employees->count() > 0)
                                            <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                                        @endif
                                    @endif

                                    <td>{{ trans('labels.srno') }}</td>

                                    <td>{{ trans('labels.image') }}</td>

                                    <td>{{ trans('labels.role') }}</td>

                                    <td>{{ trans('labels.name') }}</td>

                                    <td>{{ trans('labels.email') }}</td>

                                    <td>{{ trans('labels.mobile') }}</td>

                                    <td>{{ trans('labels.status') }}</td>

                                    <td>{{ trans('labels.created_date') }}</td>

                                    <td>{{ trans('labels.updated_date') }}</td>

                                    <td>{{ trans('labels.action') }}</td>



                                </tr>

                            </thead>

                            <tbody id="tabledetails" data-url="{{ url('admin/employees/reorder_employees') }}">

                                @php

                                    $i = 1;

                                @endphp

                                @foreach ($employees as $employee)
                                    <tr class="fs-7 row1 align-middle" id="dataid{{ $employee->id }}"
                                        data-id="{{ $employee->id }}">

                                        <td><a tooltip="{{ trans('labels.move') }}"><i
                                                    class="fa-light fa-up-down-left-right mx-2"></i></a></td>

                                        @if (@helper::checkaddons('bulk_delete'))
                                            <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $employee->id }}"></td>
                                        @endif
                                        <td>@php

                                            echo $i++;

                                        @endphp</td>

                                        <td><img src="{{ @helper::image_path($employee->image) }}" height="50"
                                                width="50" alt="" class="rounded"></td>

                                        <td>{{ @helper::role($employee->role_id)->role }}</td>

                                        <td>{{ $employee->name }}</td>

                                        <td>{{ $employee->email }}</td>

                                        <td>{{ $employee->mobile }}</td>

                                        <td>

                                            @if ($employee->is_available == '1')
                                                <a tooltip="{{ trans('labels.active') }}"
                                                    class="btn btn-sm btn-outline-success hov {{ Auth::user()->type == 4 ? (helper::check_access('role_employees', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                    href="javascript::void(0)"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/employees/status-' . $employee->id . '/2') }}')" @endif><i
                                                        class="fa-regular fa-check"></i>

                                                </a>
                                            @else
                                                <a tooltip="{{ trans('labels.inactive') }}"
                                                    class="btn btn-sm btn-outline-danger hov {{ Auth::user()->type == 4 ? (helper::check_access('role_employees', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                    href="javascript::void(0)"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else  onclick="statusupdate('{{ URL::to('admin/employees/status-' . $employee->id . '/1') }}')" @endif><i
                                                        class="fa-regular fa-xmark "></i>

                                                </a>
                                            @endif

                                        </td>

                                        <td>{{ helper::date_formate($employee->created_at, $vendor_id) }}<br>

                                            {{ helper::time_format($employee->created_at, $vendor_id) }}

                                        </td>

                                        <td>{{ helper::date_formate($employee->updated_at, $vendor_id) }}<br>

                                            {{ helper::time_format($employee->updated_at, $vendor_id) }}

                                        </td>

                                        <td>
                                            <div class="d-flex flex-wrap gap-2">
                                                <a tooltip="{{ trans('labels.edit') }}"
                                                    href="{{ URL::to('admin/employees/edit-' . $employee->id) }}"
                                                    class="btn btn-info hov btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_employees', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">

                                                    <i class="fa-regular fa-pen-to-square"></i>

                                                </a>

                                                <a tooltip="{{ trans('labels.delete') }}" href="javascript:void(0)"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else
    
                                                        onclick="statusupdate('{{ URL::to('/admin/employees/delete-' . $employee->id) }}')" @endif
                                                    class="btn btn-danger hov btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_employees', Auth::user()->role_id, Auth::user()->vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}">

                                                    <i class="fa-regular fa-trash"></i></a>

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
