@extends('admin.layout.default')
@section('content')
@php
if (Auth::user()->type == 4) {
$vendor_id = Auth::user()->vendor_id;
} else {
$vendor_id = Auth::user()->id;
}
$module = 'role_vendors';
@endphp
@include('admin.breadcrumb.breadcrumb')
<div class="row">
    <div class="col-12">
        <div class="card border-0 my-3 box-shadow">
            <div class="card-body">
                <div class="table-responsive">
                    {{-- <table class="table table-striped table-bordered py-3 zero-configuration w-1F00">
                            <thead>
                                <tr class="text-capitalize fw-500 fs-15">
                                    <td>{{ trans('labels.id') }}</td>
                    <td>{{ trans('labels.image') }}</td>
                    <td>{{ trans('labels.name') }}</td>
                    <td>{{ trans('labels.email') }}</td>
                    <td>{{ trans('labels.mobile') }}</td>
                    <td>{{ trans('labels.status') }}</td>
                    <td>{{ trans('labels.created_date') }}</td>
                    <td>{{ trans('labels.updated_date') }}</td>
                    <td>{{ trans('labels.action') }}</td>
                    </tr>
                    </thead>
                    <tbody>

                        @foreach ($users as $user)
                        <tr class="fs-7 align-middle">
                            <td>{{ $user->id }}</td>
                            <td><img src="{{ helper::image_path($user->image) }}" height="50" width="50"
                                    alt=""></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->mobile }}</td>
                            <td>
                                @if ($user->is_available == '1')
                                <a class="btn btn-sm btn-outline-success hov" href="javascript::void(0)"
                                    tooltip="{{ trans('labels.active') }}"
                                    @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/users/status-' . $user->slug . '/2') }}')" @endif>
                                    <i class="fa-regular fa-check"></i>
                                </a>
                                @else
                                <a class="btn btn-sm btn-outline-danger hov" href="javascript::void(0)"
                                    tooltip="{{ trans('labels.inactive') }}"
                                    @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/users/status-' . $user->slug . '/1') }}')" @endif>
                                    <i class="fa-regular fa-xmark "></i>
                                </a>
                                @endif
                            </td>
                            <td>{{ helper::date_formate($user->created_at, $vendor_id) }}<br>
                                {{ helper::time_format($user->created_at, $vendor_id) }}
                            </td>
                            <td>{{ helper::date_formate($user->updated_at, $vendor_id) }}<br>
                                {{ helper::time_format($user->updated_at, $vendor_id) }}
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ URL::to('admin/users/edit-' . $user->id) }}"
                                        tooltip="{{ trans('labels.edit') }}"
                                        class="btn btn-info btn-sm hov {{ Auth::user()->type == 4 ? (helper::check_access($module, Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a class="btn btn-sm btn-dark hov" tooltip="{{ trans('labels.login') }}"
                                        href="{{ URL::to('/admin/users/login-' . $user->id) }}">
                                        <i class="fa-regular fa-arrow-right-to-bracket"></i> </a>
                                    <a class="btn btn-sm btn-secondary hov"
                                        tooltip="{{ trans('labels.view') }}"
                                        href="@if (helper::checkcustomdomain($user->id) == null) {{ URL::to('/' . $user->slug) }}@else {{ '//' . helper::checkcustomdomain($user->id) }} @endif"
                                        target="_blank">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <button type="button" id="btn_password{{ $user->id }}"
                                        tooltip="{{ trans('labels.reset_password') }}"
                                        onclick="myfunction({{ $user->id }})"
                                        title="{{ trans('labels.reset_password') }}"
                                        class="btn btn-sm btn-success hov {{ Auth::user()->type == 4 ? (helper::check_access($module, Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                        data-vendor_id="{{ $user->id }}" data-type="1">
                                        <i class="fa-light fa-key"></i>
                                    </button>
                                    <a href="javascript:void(0)" tooltip="{{ trans('labels.delete') }}"
                                        @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/users/delete-' . $user->id) }}')" @endif
                                        class="btn btn-danger hov btn-sm {{ Auth::user()->type == 4 ? (helper::check_access($module, Auth::user()->role_id, $vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}">
                                        <i class="fa-regular fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    </table> --}}
                </div>
                <div class="row row-cols-xxl-5 row-cols-xl-4 row-cols-lg-2 row-cols-md-2 row-cols-sm-1 row-cols-1 g-3">
                    @foreach ($users as $user)
                    <div class="col">
                        <div class="vendor_card card border bg-change rounded-4 h-100">
                            <div class="card-body p-3">
                                <div
                                    class="d-flex gap-2 mb-3 align-items-center border-bottom pb-2">
                                    <div class="col-auto">
                                        <img src="{{ helper::image_path($user->image) }}" alt="Image"
                                            class="rounded-circle object-fit-cover table-image hw-58">
                                    </div>
                                    <div>
                                        <div class="d-flex gap-2 flex-column w-100 ">
                                            <h6 class="fw-600 color-changer truncate-1">
                                                {{ $user->name }}
                                            </h6>
                                            <p class="fs-7 mt-1 color-changer">
                                                {{ $user->mobile }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <p class="fs-7 mt-1 color-changer">
                                    {{ trans('labels.status') }} :
                                    @if ($user->is_available == '1')
                                    <a class="text-success" href="javascript::void(0)"
                                        @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/users/status-' . $user->id . '/2') }}')" @endif>
                                        <i class="fa-regular fa-check"></i>
                                        {{ trans('labels.active') }}
                                    </a>
                                    @else
                                    <a class="text-danger" href="javascript::void(0)"
                                        @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/users/status-' . $user->id . '/1') }}')" @endif>
                                        <i class="fa-regular fa-xmark "></i>
                                        {{ trans('labels.inactive') }}
                                    </a>
                                    @endif
                                </p>
                                <p class="fs-7 mt-1 color-changer">
                                    {{ trans('labels.email') }} :
                                    {{ $user->email }}
                                </p>
                            </div>
                            <div class="card-footer p-3 border-top bg-change-mode rounded-bottom-4">
                                <div class="d-flex flex-wrap justify-content-center gap-2">
                                    <a href="{{ URL::to('admin/users/edit-' . $user->id) }}"
                                        tooltip="{{ trans('labels.edit') }}"
                                        class="btn btn-info btn-sm hov {{ Auth::user()->type == 4 ? (helper::check_access($module, Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a class="btn btn-sm btn-dark hov" tooltip="{{ trans('labels.login') }}"
                                        href="{{ URL::to('/admin/users/login-' . $user->id) }}">
                                        <i class="fa-regular fa-arrow-right-to-bracket"></i> </a>
                                    <a class="btn btn-sm btn-secondary hov" tooltip="{{ trans('labels.view') }}"
                                        href="@if (helper::checkcustomdomain($vendor_id) == null) {{ URL::to('/' . $user->slug) }}@else {{ '//' . helper::checkcustomdomain($vendor_id) }} @endif"
                                        target="_blank">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                    <button type="button" id="btn_password{{ $user->id }}"
                                        tooltip="{{ trans('labels.reset_password') }}"
                                        onclick="myfunction({{ $user->id }})"
                                        title="{{ trans('labels.reset_password') }}"
                                        class="btn btn-sm btn-success hov {{ Auth::user()->type == 4 ? (helper::check_access($module, Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                        data-vendor_id="{{ $user->id }}" data-type="1">
                                        <i class="fa-light fa-key"></i>
                                    </button>
                                    <a href="javascript:void(0)" tooltip="{{ trans('labels.delete') }}"
                                        @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/users/delete-' . $user->id) }}')" @endif
                                        class="btn btn-danger hov btn-sm {{ Auth::user()->type == 4 ? (helper::check_access($module, Auth::user()->role_id, $vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}">
                                        <i class="fa-regular fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="changepasswordModal" tabindex="-1" aria-labelledby="changepasswordModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ URL::to('/admin/change-password') }}" method="post" class="w-100">
            @csrf
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title color-changer" id="changepasswordModalLabel">
                        {{ trans('labels.change_password') }}
                    </h5>
                    <button type="button" class="bg-transparent border-0 color-changer" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-regular fa-xmark fs-4"></i>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <div class="card p-1 border-0"> --}}
                    <input type="hidden" class="form-control" name="modal_vendor_id" id="modal_vendor_id"
                        value="">
                    <input type="hidden" class="form-control" name="type" id="type" value="1">
                    <div class="form-group">
                        <label for="new_password" class="form-label">{{ trans('labels.new_password') }}</label>
                        <input type="password" class="form-control" name="new_password" required
                            placeholder="{{ trans('labels.new_password') }}">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password"
                            class="form-label">{{ trans('labels.confirm_password') }}</label>
                        <input type="password" class="form-control" name="confirm_password" required
                            placeholder="{{ trans('labels.confirm_password') }}">
                    </div>
                    {{-- </div> --}}
                </div>
                <div class="modal-footer">
                    <button
                        @if (env('Environment')=='sendbox' ) onclick="myFunction()" type="button" @else type="submit" @endif
                        class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function myfunction(id) {
        $('#modal_vendor_id').val($('#btn_password' + id).attr("data-vendor_id"));
        $('#changepasswordModal').modal('show');
    }
</script>
@endsection