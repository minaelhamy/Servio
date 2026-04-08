@extends('admin.layout.default')
@section('content')
    @php

        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $module = 'role_coupons';
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
                                     @if (@helper::checkaddons('bulk_delete'))
                                        @if($promocodes->count() > 0)
                                            <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                                        @endif
                                    @endif
                                    <td>{{ trans('labels.srno') }}</td>
                                    <td>{{ trans('labels.coupon_name') }}</td>
                                    <td>{{ trans('labels.coupon_code') }}</td>
                                    <td>{{ trans('labels.discount') }}</td>
                                    <td>{{ trans('labels.start_date') }}</td>
                                    <td>{{ trans('labels.end_date') }}</td>
                                    <td>{{ trans('labels.status') }}</td>
                                    <td>{{ trans('labels.action') }}</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($promocodes as $promocode)
                                    <tr class="fs-7 align-middle">
                                        @if (@helper::checkaddons('bulk_delete'))
                                            <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $promocode->id }}"></td>
                                        @endif
                                        <td>@php
                                            echo $i++;
                                        @endphp</td>
                                        <td>{{ $promocode->offer_name }}</td>
                                        <td>{{ $promocode->offer_code }}</td>
                                        <td>{{ $promocode->offer_type == 1 ? helper::currency_formate($promocode->offer_amount, $vendor_id) : $promocode->offer_amount . '%' }}
                                        </td>

                                        <td><span
                                                class="badge bg-success">{{ helper::date_formate($promocode->start_date, $promocode->vendor_id) }}</span>
                                        </td>
                                        <td><span
                                                class="badge bg-danger mx-2">{{ helper::date_formate($promocode->exp_date, $promocode->vendor_id) }}</span>
                                        </td>
                                        <td>
                                            @if ($promocode->is_available == '1')
                                                <a href="javascript:void(0)" tooltip="{{ trans('labels.active') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ Url::to('admin/promocode/status_change-' . $promocode->id . '/2') }}')" @endif
                                                    class="btn btn-sm btn-outline-success hov {{ Auth::user()->type == 4 ? (helper::check_access('role_coupons', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 || helper::check_access('role_coupons', Auth::user()->role_id, Auth::user()->vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}"><i
                                                        class="fa-regular fa-check"></i></a>
                                            @else
                                                <a href="javascript:void(0)" tooltip="{{ trans('labels.inactive') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ Url::to('admin/promocode/status_change-' . $promocode->id . '/1') }}')" @endif
                                                    class="btn btn-sm btn-outline-danger hov {{ Auth::user()->type == 4 ? (helper::check_access('role_coupons', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 || helper::check_access('role_coupons', Auth::user()->role_id, Auth::user()->vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}"><i
                                                        class="fa-regular fa-xmark"></i></a>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{ url::to('admin/promocode/edit-' . $promocode->id) }}"
                                                    tooltip="{{ trans('labels.edit') }}"
                                                    class="btn btn-info btn-sm hov {{ Auth::user()->type == 4 ? (helper::check_access('role_coupons', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                    <i class="fa-regular fa-pen-to-square"></i></a>
                                                <a href="javascript:void(0)" tooltip="{{ trans('labels.delete') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else
                                                            onclick="statusupdate('{{ URL::to('/admin/promocode/delete-' . $promocode->id) }}')" @endif
                                                    class="btn btn-danger btn-sm hov {{ Auth::user()->type == 4 ? (helper::check_access('role_coupons', Auth::user()->role_id, Auth::user()->vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}">
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
