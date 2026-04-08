@extends('admin.layout.default')

@section('content')
    @php

        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $module = 'role_features';
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
                                        @if($features->count() > 0)
                                            <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                                        @endif
                                    @endif

                                    <td>{{ trans('labels.srno') }}</td>

                                    <td>{{ trans('labels.image') }}</td>

                                    <td>{{ trans('labels.title') }}</td>

                                    <td>{{ trans('labels.description') }}</td>

                                    <td>{{ trans('labels.created_date') }}</td>

                                    <td>{{ trans('labels.updated_date') }}</td>

                                    <td>{{ trans('labels.action') }}</td>

                                </tr>

                            </thead>

                            <tbody id="tabledetails" data-url="{{ url('admin/features/reorder_features') }}">

                                @php

                                    $i = 1;

                                @endphp

                                @foreach ($features as $feature)
                                    <tr class="fs-7 row1 align-middle" id="dataid{{ $feature->id }}"
                                        data-id="{{ $feature->id }}">

                                        <td>
                                            <a tooltip="{{ trans('labels.move') }}">
                                                <i class="fa-light fa-up-down-left-right mx-2"></i>
                                            </a>
                                        </td>

                                        @if (@helper::checkaddons('bulk_delete'))
                                            <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $feature->id }}"></td>
                                        @endif 

                                        <td>@php

                                            echo $i++;

                                        @endphp</td>

                                        <td><img src="{{ helper::image_path($feature->image) }}"
                                                class="img-fluid rounded hw-50 bg-white" alt=""></td>

                                        <td>{{ $feature->title }}</td>

                                        <td>{{ $feature->description }}</td>

                                        <td>{{ helper::date_formate($feature->created_at, $vendor_id) }}<br>

                                            {{ helper::time_format($feature->created_at, $vendor_id) }}

                                        </td>

                                        <td>{{ helper::date_formate($feature->updated_at, $vendor_id) }}<br>

                                            {{ helper::time_format($feature->updated_at, $vendor_id) }}

                                        </td>

                                        <td>

                                            <div class="d-flex flex-wrap gap-2">

                                                <a tooltip="{{ trans('labels.edit') }}"
                                                    href="{{ URL::to('/admin/features/edit-' . $feature->id) }}"
                                                    class="btn btn-info btn-sm hov {{ Auth::user()->type == 4 ? (helper::check_access('role_features', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>

                                                <a tooltip="{{ trans('labels.delete') }}" href="javascript:void(0)"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/features/delete-' . $feature->id) }}')" @endif
                                                    class="btn btn-danger btn-sm hov {{ Auth::user()->type == 4 ? (helper::check_access('role_features', Auth::user()->role_id, Auth::user()->vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}">
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
