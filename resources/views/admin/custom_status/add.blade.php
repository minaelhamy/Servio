@extends('admin.layout.default')

@section('content')
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
    @endphp

    @include('admin.breadcrumb.breadcrumb')

    <div class="row mt-3">

        <div class="col-12">

            <div class="card border-0 box-shadow">

                <div class="card-body">

                    <form action="{{ URL::to('admin/custom_status/save') }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <div class="row">

                            <div class="form-group col-md-6">

                                <label class="form-label">{{ trans('labels.status_use') }}
                                    <span class="text-danger"> * </span></label>

                                <select name="status_use" class="form-select" required>

                                    <option value="">{{ trans('labels.select') }}</option>

                                    <option value="1">{{ trans('labels.booking') }}</option>
                                    @if (@helper::checkaddons('product_shop'))
                                        <option value="2">{{ trans('labels.order_s') }}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="form-group col-md-6">

                                <label class="form-label">{{ trans('labels.status') }} {{ trans('labels.type') }}
                                    <span class="text-danger"> * </span></label>

                                <select name="status_type" class="form-select" required>

                                    <option value="">{{ trans('labels.select') }}</option>

                                    <option value="2">{{ trans('labels.process') }}</option>

                                </select>

                            </div>

                            <div class="form-group col-md-6">

                                <label class="form-label">{{ trans('labels.name') }}
                                    <span class="text-danger"> * </span></label>

                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    placeholder="{{ trans('labels.name') }}" required>

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">

                                <a href="{{ URL::to('admin/custom_status') }}"
                                    class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>

                                <button
                                    class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_custom_status', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}"
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection
