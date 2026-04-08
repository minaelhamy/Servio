<div id="google_calendar">
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-header p-3 bg-secondary">

                    <h5 class="text-capitalize fw-600 text-dark color-changer">{{ trans('labels.google_calendar') }}
                    </h5>

                </div>
                <div class="card-body">

                    <form action="{{ Url::to('/admin/google_calendar') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label class="form-label">{{ trans('labels.client_id') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control" name="client_id"
                                    value="{{ $settingdata->client_id }}" placeholder="{{ trans('labels.client_id') }}"
                                    required>
                                @error('client_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label">{{ trans('labels.client_secret') }}<span class="text-danger">
                                        * </span></label>
                                <input type="text" class="form-control" name="client_secret"
                                    value="{{ $settingdata->client_secret }}"
                                    placeholder="{{ trans('labels.client_secret') }}" required>
                                @error('client_secret')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label">{{ trans('labels.redirect_uri') }}<span class="text-danger">
                                        * </span></label>
                                <input type="text" class="form-control" name="redirect_uri"
                                    value="{{ $settingdata->redirect_uri }}"
                                    placeholder="{{ trans('labels.redirect_uri') }}">
                                @error('redirect_uri')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                        <div class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_general_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
