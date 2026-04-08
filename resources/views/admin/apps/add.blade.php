@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form method="post" action="{{ URL::to('admin/systemaddons/store') }}" name="about" id="about"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-sm-3 col-md-12">
                                <div class="form-group mb-3">
                                    <label for="addon_zip" class="col-form-label">{{ trans('labels.zip_file') }}<span
                                        class="text-danger"> * </span></label>
                                    <input type="file" class="form-control" name="addon_zip" id="addon_zip"
                                        required="">
                                </div>
                            </div>
                        </div>
                        <div class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                            @if (env('Environment') == 'sendbox')
                                <button type="button" class="btn btn-secondary"
                                    onclick="myFunction()">{{ trans('labels.install') }}</button>
                            @else
                                <button type="submit" class="btn btn-secondary">{{ trans('labels.install') }}</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
