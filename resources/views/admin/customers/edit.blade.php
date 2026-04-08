@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row">
        <div class="card border-0 box-shadow">
            <div class="card-body">
                <form action="{{ URL::to('admin/customers/update-' . $getuserdata->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 form-group">
                            <input type="hidden" value="{{ $getuserdata->id }}" name="id">
                            <label class="form-label">{{ trans('labels.name') }}
                                <span class="text-danger"> * </span></label>
                            <input type="text" class="form-control" name="name" value="{{ $getuserdata->name }}"
                                id="name" placeholder="{{ trans('labels.name') }}" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form-label">{{ trans('labels.email') }}
                                <span class="text-danger"> * </span></label>
                            <input type="email" class="form-control" name="email" value="{{ $getuserdata->email }}"
                                placeholder="{{ trans('labels.email') }}" required>
                        </div>
                        <div class="col-sm-6 form-group">
                            <div class="form-group">
                                <label class="form-label">{{ trans('labels.mobile') }}
                                    <span class="text-danger"> * </span></label>
                                <input type="text" class="form-control mobile-number" name="mobile"
                                    value="{{ $getuserdata->mobile }}" placeholder="{{ trans('labels.mobile') }}" required>
                            </div>
                        </div>
                        <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                            <a href="{{ URL::to('admin/customers') }}"
                                class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_customers', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
