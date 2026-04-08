@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 mt-2 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/workinghours/edit') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <label class="col-md-2 col-form-label"></label>
                            <label
                                class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block">{{ trans('labels.opening_time') }}</label>
                            <label
                                class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block">{{ trans('labels.break_start') }}</label>
                            <label
                                class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block">{{ trans('labels.break_end') }}</label>
                            <label
                                class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block">{{ trans('labels.closing_time') }}</label>
                            <label
                                class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block">{{ trans('labels.always_closed') }}</label>
                        </div>
                        @foreach ($timingdata as $time)
                            <div class="row my-2">
                                <div class="form-group col-md-2">
                                    <label class="form-label text-center fw-bold">
                                        @if ($time->day == 'Monday')
                                            {{ trans('labels.monday') }}
                                        @endif
                                        @if ($time->day == 'Tuesday')
                                            {{ trans('labels.tuesday') }}
                                        @endif
                                        @if ($time->day == 'Wednesday')
                                            {{ trans('labels.wednesday') }}
                                        @endif
                                        @if ($time->day == 'Thursday')
                                            {{ trans('labels.thursday') }}
                                        @endif
                                        @if ($time->day == 'Friday')
                                            {{ trans('labels.friday') }}
                                        @endif
                                        @if ($time->day == 'Saturday')
                                            {{ trans('labels.saturday') }}
                                        @endif
                                        @if ($time->day == 'Sunday')
                                            {{ trans('labels.sunday') }}
                                        @endif
                                    </label>
                                </div>

                                <input type="hidden" name="day[]" value="{{ $time->day }}">
                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control timepicker"
                                        placeholder="{{ trans('labels.opening_time') }}" id="open{{ $time->day }}"
                                        name="open_time[]"
                                        @if ($time->is_always_close == '2') value="{{ $time->open_time }}" 
                                                @else value="{{ trans('labels.closed') }}" readonly="" @endif>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control timepicker"
                                        placeholder="{{ trans('labels.break_start') }}"
                                        id="break_start{{ $time->day }}" name="break_start[]"
                                        @if ($time->is_always_close == '2') value="{{ $time->break_start }}" 
                                    @else value="{{ trans('labels.closed') }}" readonly="" @endif>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control timepicker"
                                        placeholder="{{ trans('labels.break_end') }}" id="break_end{{ $time->day }}"
                                        name="break_end[]"
                                        @if ($time->is_always_close == '2') value="{{ $time->break_end }}"
                                    @else value="{{ trans('labels.closed') }}" readonly="" @endif>
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control timepicker"
                                        placeholder="{{ trans('labels.closing_time') }}" id="close{{ $time->day }}"
                                        name="close_time[]"
                                        @if ($time->is_always_close == '2') value="{{ $time->close_time }}" 
                                                @else value="{{ trans('labels.closed') }}" readonly="" @endif>
                                </div>
                                <div class="form-group col-md-2">
                                    <select class="form-control form-select" name="is_always_close[]"
                                        id="is_always_close{{ $time->day }}">
                                        <option value="" disabled>{{ trans('labels.select') }}</option>
                                        <option value="1" @if ($time->is_always_close == '1') selected @endif>
                                            {{ trans('messages.yes') }}</option>
                                        <option value="2" @if ($time->is_always_close == '2') selected @endif>
                                            {{ trans('messages.no') }}</option>
                                    </select>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-group col-md-12 text-end">
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4 btn-raised {{Auth::user()->type == 4 ? ((helper::check_access('role_workinghours',Auth::user()->role_id,Auth::user()->vendor_id,'add') == 1 || helper::check_access('role_workinghours',Auth::user()->role_id,Auth::user()->vendor_id,'edit') == 1 ) ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/timepicker/jquery.timepicker.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/workinghours.js') }}"></script>
@endsection
