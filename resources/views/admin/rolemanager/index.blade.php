@extends('admin.layout.default')

@section('content')
    @php

        $module = 'role_roles';

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

                                     @if (@helper::checkaddons('bulk_delete'))
                                        @if($getroles->count() > 0)
                                            <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                                        @endif
                                    @endif

                                    <td>{{ trans('labels.srno') }}</td>

                                    <td>{{ trans('labels.role') }}</td>

                                    <td>{{ trans('labels.system_modules') }}</td>

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

                                @foreach ($getroles as $role)
                                    <tr class="fs-7 align-middle">

                                        @if (@helper::checkaddons('bulk_delete'))
                                            <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $role->id }}"></td>
                                        @endif
                                        <td>@php

                                            echo $i++;

                                        @endphp</td>

                                        <td>{{ $role->role }}</td>

                                        @php

                                            $modules = explode('|', $role->module);

                                        @endphp

                                        <td>

                                            @foreach ($modules as $module)
                                                <span
                                                    class="badge rounded-pill bg-light text-dark">{{ $module }}</span>
                                            @endforeach

                                        </td>

                                        <td>

                                            @if ($role->is_available == '1')
                                                <a href="javascript:void(0)" tooltip="{{ trans('labels.active') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('/admin/roles/change_status-' . $role->id . '/2') }}')" @endif
                                                    class="btn btn-sm btn-outline-success hov {{ Auth::user()->type == 4 ? (helper::check_access('role_roles', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"><i
                                                        class="fa-regular fa-check"></i></a>
                                            @else
                                                <a href="javascript:void(0)" tooltip="{{ trans('labels.inactive') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('/admin/roles/change_status-' . $role->id . '/1') }}')" @endif
                                                    class="btn btn-sm btn-outline-danger hov {{ Auth::user()->type == 4 ? (helper::check_access('role_roles', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"><i
                                                        class="fa-regular fa-xmark"></i></a>
                                            @endif

                                        </td>

                                        <td>{{ helper::date_formate($role->created_at, $vendor_id) }}<br>

                                            {{ helper::time_format($role->created_at, $vendor_id) }}

                                        </td>

                                        <td>{{ helper::date_formate($role->updated_at, $vendor_id) }}<br>

                                            {{ helper::time_format($role->updated_at, $vendor_id) }}

                                        </td>

                                        <td>

                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{ URL::to('admin/roles/edit-' . $role->id) }}"
                                                    tooltip="{{ trans('labels.edit') }}"
                                                    class="btn btn-info btn-sm hov {{ Auth::user()->type == 4 ? (helper::check_access('role_roles', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">

                                                    <i class="fa-regular fa-pen-to-square"></i></a>

                                                <a href="javascript:void(0)" tooltip="{{ trans('labels.delete') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else
    
                                                        onclick="statusupdate('{{ URL::to('/admin/roles/delete-' . $role->id) }}')" @endif
                                                    class="btn btn-danger btn-sm hov {{ Auth::user()->type == 4 ? (helper::check_access('role_roles', Auth::user()->role_id, Auth::user()->vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}">

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
