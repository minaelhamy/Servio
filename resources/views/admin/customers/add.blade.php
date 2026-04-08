@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('admin/customers/save') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name" class="form-label">{{ trans('labels.name') }}<span class="text-danger">
                                        * </span></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    id="name" placeholder="{{ trans('labels.name') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="form-label">{{ trans('labels.email') }}<span
                                        class="text-danger"> * </span></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    id="email" placeholder="{{ trans('labels.email') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mobile" class="form-label">{{ trans('labels.mobile') }}<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control mobile-number" name="mobile"
                                    value="{{ old('mobile') }}" id="mobile" placeholder="{{ trans('labels.mobile') }}"
                                    required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password" class="form-label">{{ trans('labels.password') }}<span
                                        class="text-danger"> * </span></label>
                                <input type="password" class="form-control" name="password" value="{{ old('password') }}"
                                    id="password" placeholder="{{ trans('labels.password') }}" required>
                            </div>
                        </div>
                        <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                            <a href="{{ URL::to('admin/customers') }}"
                                class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                            <button
                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_customers', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}"
                                @if (env('Environment') == 'sendbox') type="button"
                            onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
