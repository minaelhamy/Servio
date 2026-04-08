<div id="mobile_section">
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 box-shadow rounded overflow-hidden">
                <form action="{{ URL::to('admin/mobile_section/save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header p-3 bg-secondary">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="text-capitalize fw-600 text-dark color-changer">{{ trans('labels.mobile_section') }}</h5>
                            <div>
                                <input id="mobile_app-switch" type="checkbox" class="checkbox-switch"
                                    name="mobile_app_on_off" value="1"
                                    {{ @$appsettings->mobile_app_on_off == 1 ? 'checked' : '' }}>
                                <label for="mobile_app-switch" class="switch">
                                    <span
                                        class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                            class="switch__circle-inner"></span></span>
                                    <span
                                        class="switch__left {{ session()->get('direction') == 2 ? 'pe-1' : 'ps-1' }}">{{ trans('labels.off') }}</span>
                                    <span
                                        class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if (Auth::user()->type == 1)
                                @if (@helper::checkaddons('vendor_app'))
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.firebase_server_key') }}</label>
                                        @if (env('Environment') == 'sendbox')
                                            <span
                                                class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                                        @endif
                                        <input type="text" class="form-control" name="firebase_server_key"
                                            value="{{ @$settingdata->firebase }}"
                                            placeholder="{{ trans('labels.firebase_server_key') }}" required>
                                        @error('firebase_server_key')
                                            <small class="text-danger">{{ $message }}</small> <br>
                                        @enderror
                                    </div>
                                @endif
                            @endif
                            @if (Auth::user()->type == 2 || Auth::user()->type == 4)
                                @if (@helper::checkaddons('user_app'))
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.firebase_server_key') }}</label>
                                        @if (env('Environment') == 'sendbox')
                                            <span
                                                class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                                        @endif
                                        <input type="text" class="form-control" name="firebase_server_key"
                                            value="{{ @$settingdata->firebase }}"
                                            placeholder="{{ trans('labels.firebase_server_key') }}" required>
                                        @error('firebase_server_key')
                                            <small class="text-danger">{{ $message }}</small> <br>
                                        @enderror
                                    </div>
                                @endif
                                <div class="col-md-6 mb-lg-0">
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.title') }}<span class="text-danger">
                                                *
                                            </span></label>
                                        <input type="text"
                                            class="form-control {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                            name="title" placeholder="{{ trans('labels.title') }}"
                                            value="{{ @$appsettings->title }}" required>


                                    </div>
                                </div>
                                <div class="col-md-6 mb-lg-0">
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.subtitle') }}<span
                                                class="text-danger"> *
                                            </span></label>
                                        <input type="text"
                                            class="form-control {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                            name="subtitle" placeholder="{{ trans('labels.subtitle') }}"
                                            value="{{ @$appsettings->subtitle }}" required>

                                    </div>
                                </div>
                            @endif
                            <div class="col-md-6 mb-lg-0">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.android_link') }}<span
                                            class="text-danger"> *
                                        </span></label>
                                    <input type="text"
                                        class="form-control {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                        name="android_link" placeholder="{{ trans('labels.android_link') }}"
                                        value="{{ @$appsettings->android_link }}">

                                </div>
                            </div>
                            <div class="col-md-6 mb-lg-0">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.ios_link') }}<span class="text-danger">
                                            *
                                        </span></label>
                                    <input type="text"
                                        class="form-control {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                        name="ios_link" placeholder="{{ trans('labels.ios_link') }}"
                                        value="{{ @$appsettings->ios_link }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-lg-0">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.image') }}<span class="text-danger"> *
                                        </span></label>
                                    <input type="file" class="form-control" name="image">
                                </div>
                                <img src="{{ helper::image_path(@$appsettings->image) }}"
                                    class="img-fluid rounded hw-70" alt="">
                            </div>
                            <div class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                                <button
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                    class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
