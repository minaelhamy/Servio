@extends('admin.layout.default')
@section('content')
    @php
        $module = 'role_services';
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
    @endphp
    @include('admin.breadcrumb.breadcrumb')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 box-shadow mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">
                            <thead>
                                <tr class="text-capitalize fw-500 fs-15">
                                    <td></td>
                                    @if (@helper::checkaddons('bulk_delete'))
                                        @if($service->count() > 0)
                                            <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                                        @endif
                                    @endif
                                    <td>{{ trans('labels.srno') }}</td>
                                    <td>{{ trans('labels.image') }}</td>
                                    <td>{{ trans('labels.category') }}</td>
                                    <td>{{ trans('labels.name') }}</td>
                                    <td>{{ trans('labels.amount') }}</td>
                                    <td>{{ trans('labels.status') }}</td>
                                    <td>{{ trans('labels.created_date') }}</td>
                                    <td>{{ trans('labels.updated_date') }}</td>
                                    <td>{{ trans('labels.action') }}</td>
                                </tr>
                            </thead>
                            <tbody id="tabledetails" data-url="{{ url('admin/services/reorder_service') }}">
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($service as $item)
                                    <tr class="fs-7 row1 align-middle" id="dataid{{ $item->id }}"
                                        data-id="{{ $item->id }}">
                                        <td><a tooltip="{{ trans('labels.move') }}"><i
                                                    class="fa-light fa-up-down-left-right mx-2"></i></a></td>

                                         @if (@helper::checkaddons('bulk_delete'))
                                            <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $item->id }}"></td>
                                        @endif

                                        <td>@php
                                            echo $i++;
                                        @endphp</td>
                                        <td>
                                            @if ($item['service_image'] == null)
                                                <img src="{{ @helper::image_path('service.png') }}"
                                                    class="img-fluid rounded hw-50" alt="">
                                            @else
                                                <img src="{{ @helper::image_path($item['service_image']->image) }}"
                                                    class="img-fluid rounded hw-50" alt="">
                                            @endif
                                        </td>
                                        @php
                                            $category = helper::getcategoryinfo($item->category_id, $item->vendor_id);
                                        @endphp
                                        <td>
                                            @foreach ($category as $cat)
                                                {{ $cat->name }} <br>
                                            @endforeach
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ helper::currency_formate($item->price, $vendor_id) }}</td>
                                        <td>
                                            @if ($item->is_available == '1')
                                                <a href="javascript:void(0)" tooltip="{{ trans('labels.active') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ Url::to('admin/services/status_change-' . $item->slug . '/2') }}')" @endif
                                                    class="btn btn-sm btn-outline-success hov {{ Auth::user()->type == 4 ? (helper::check_access('role_services', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"><i
                                                        class="fa-regular fa-check"></i></a>
                                            @else
                                                <a href="javascript:void(0)" tooltip="{{ trans('labels.inactive') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else
                                                        onclick="statusupdate('{{ URL::to('admin/services/status_change-' . $item->slug . '/1') }}')" @endif
                                                    class="btn btn-sm btn-outline-danger hov {{ Auth::user()->type == 4 ? (helper::check_access('role_services', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"><i
                                                        class="fa-regular fa-xmark"></i></a>
                                            @endif
                                        </td>
                                        <td>{{ helper::date_formate($item->created_at, $vendor_id) }}<br>
                                            {{ helper::time_format($item->created_at, $vendor_id) }}
                                        </td>
                                        <td>{{ helper::date_formate($item->updated_at, $vendor_id) }}<br>
                                            {{ helper::time_format($item->updated_at, $vendor_id) }}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{ URL::to('admin/services/edit-' . $item->slug) }}"
                                                    tooltip="{{ trans('labels.edit') }}"
                                                    class="btn btn-info btn-sm hov {{ Auth::user()->type == 4 ? (helper::check_access('role_services', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                    <i class="fa-regular fa-pen-to-square"></i></a>
                                                <a href="javascript:void(0)" tooltip="{{ trans('labels.delete') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else
                                                            onclick="statusupdate('{{ URL::to('/admin/services/delete-' . $item->slug) }}')" @endif
                                                    class="btn btn-danger btn-sm hov {{ Auth::user()->type == 4 ? (helper::check_access('role_services', Auth::user()->role_id, Auth::user()->vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}">
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
