<div id="google_analytics">
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="text-capitalize ">{{ trans('labels.google_analytics') }}
                        </h5>
                    </div>
                    <form method="POST" action="{{ URL::to('admin/google_analytics/save') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.tracking_id') }}
                                        <span class="text-danger"> * </span> </label>
                                    <input type="text" class="form-control"
                                        name="tracking_id" required
                                        value="{{ @$settingdata->tracking_id }}">
                                    @error('tracking_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.view_id') }}
                                        <span class="text-danger"> * </span> </label>
                                    <input type="text" class="form-control" name="view_id"
                                        required value="{{ @$settingdata->view_id }}">
                                    @error('view_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                                <button class="btn btn-primary px-sm-4"
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="updatetrackinginfo" value="1" @endif>{{ trans('labels.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>