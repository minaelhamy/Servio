@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/shipping/save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.area_name') }}
                                    <span class="text-danger"> * </span></label>
                                <input type="text" class="form-control" name="area_name" value="{{ old('area_name') }}"
                                    placeholder="{{ trans('labels.area_name') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.delivery_charge') }}
                                    <span class="text-danger"> * </span></label>
                                <input type="text" class="form-control" name="delivery_charge"
                                    value="{{ old('delivery_charge') }}" placeholder="{{ trans('labels.delivery_charge') }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                            <a href="{{ URL::to('admin/shipping') }}"
                                class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_shipping_management', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
