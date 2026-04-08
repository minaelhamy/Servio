@extends('admin.layout.default')

@section('content')
    @php

        $module = 'role_products_categories';

        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }

    @endphp

    @include('admin.breadcrumb.breadcrumb')

    <div class="row mt-3">

        <div class="col-12">

            <div class="card border-0 mb-3 box-shadow">

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">

                            <thead>

                                <tr class="text-capitalize fw-500 fs-15">

                                    <td></td>

                                    
                                    @if (@helper::checkaddons('bulk_delete'))
                                        @if($allcategories->count() > 0)
                                            <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                                        @endif
                                    @endif
                                    
                                    <td>{{ trans('labels.srno') }}</td>

                                    <td>{{ trans('labels.category') }}</td>

                                    <td>{{ trans('labels.status') }}</td>

                                    <td>{{ trans('labels.created_date') }}</td>

                                    <td>{{ trans('labels.updated_date') }}</td>

                                    <td>{{ trans('labels.action') }}</td>

                                </tr>

                            </thead>

                            <tbody id="tabledetails" data-url="{{ url('admin/product-category/reorder_category') }}">
                                @foreach ($allcategories as $key => $category)
                                    <tr class="fs-7 row1 align-middle" id="dataid{{ $category->id }}"
                                        data-id="{{ $category->id }}">

                                        <td><a tooltip="{{ trans('labels.move') }}">
                                                <i class="fa-light fa-up-down-left-right mx-2"></i>
                                            </a>
                                        </td>

                                        @if (@helper::checkaddons('bulk_delete'))
                                            <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $category->id }}"></td>
                                        @endif
                                        <td>{{ ++$key }}</td>

                                        <td>{{ $category->name }}</td>

                                        <td>

                                            @if ($category->is_available == '1')
                                                <a href="javascript:void(0)" tooltip="{{ trans('labels.active') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('/admin/product-category/change_status-' . $category->slug . '/2') }}')" @endif
                                                    class="btn btn-sm hov btn-outline-success {{ Auth::user()->type == 4 ? (helper::check_access('role_products_categories', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                    <i class="fa-regular fa-check"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0)" tooltip="{{ trans('labels.inactive') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('/admin/product-category/change_status-' . $category->slug . '/1') }}')" @endif
                                                    class="btn btn-sm btn-outline-danger hov {{ Auth::user()->type == 4 ? (helper::check_access('role_products_categories', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                    <i class="fa-regular fa-xmark"></i>
                                                </a>
                                            @endif

                                        </td>

                                        <td>{{ helper::date_formate($category->created_at, $vendor_id) }}<br>

                                            {{ helper::time_format($category->created_at, $vendor_id) }}

                                        </td>

                                        <td>{{ helper::date_formate($category->updated_at, $vendor_id) }}<br>

                                            {{ helper::time_format($category->updated_at, $vendor_id) }}

                                        </td>

                                        <td>

                                            <div class="d-flex gap-2 flex-wrap">
                                                <a href="{{ URL::to('/admin/product-category/edit-' . $category->slug) }}"
                                                    tooltip="{{ trans('labels.edit') }}"
                                                    class="btn btn-info hov btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_products_categories', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>

                                                <a href="javascript:void(0)" tooltip="{{ trans('labels.delete') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('/admin/product-category/delete-' . $category->slug) }}')" @endif
                                                    class="btn btn-danger hov btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_products_categories', Auth::user()->role_id, Auth::user()->vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}">
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
