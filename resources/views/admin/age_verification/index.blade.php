<div id="age_verification">
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <form method="POST" action="{{ URL::to('admin/age_verification') }}">
                    @csrf
                    <div
                        class="d-flex justify-content-between rounded-top align-items-center card-header p-3 bg-secondary">
                        <h5 class="text-capitalize fw-600 text-dark color-changer">
                            {{ trans('labels.age_verification') }}
                        </h5>
                        <div class="d-flex justify-content-end align-items-center">
                            <input id="age_verification-switch" type="checkbox" class="checkbox-switch"
                                name="age_verification_on_off" value="1"
                                {{ @helper::getagedetails($vendor_id)->age_verification_on_off == 1 ? 'checked' : '' }}>
                            <label for="age_verification-switch" class="switch">
                                <span
                                    class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                        class="switch__circle-inner"></span></span>
                                <span
                                    class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                <span
                                    class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="card-body">
                        @php
                            if (Auth::user()->type == 4) {
                                $vendor_id = Auth::user()->vendor_id;
                            } else {
                                $vendor_id = Auth::user()->id;
                            }
                        @endphp
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <p class="form-label">
                                    {{ trans('labels.popup_type') }}
                                </p>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input form-check-input-secondary" type="radio"
                                        name="popup_type" id="radio1" value="1"
                                        {{ @@helper::getagedetails($vendor_id)->popup_type == '1' ? 'checked' : '' }}
                                        required>
                                    <label for="radio1"
                                        class="form-check-label">{{ trans('labels.default') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input form-check-input-secondary" type="radio"
                                        name="popup_type" id="radio2" value="2"
                                        {{ @@helper::getagedetails($vendor_id)->popup_type == '2' ? 'checked' : '' }}
                                        required>
                                    <label for="radio2"
                                        class="form-check-label">{{ trans('labels.enter_dob') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input form-check-input-secondary" type="radio"
                                        name="popup_type" id="radio3" value="3"
                                        {{ @@helper::getagedetails($vendor_id)->popup_type == '3' ? 'checked' : '' }}
                                        required>
                                    <label for="radio3"
                                        class="form-check-label">{{ trans('labels.enter_age') }}</label>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label">{{ trans('labels.min_age') }} <span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control" name="min_age"
                                    value="{{ @helper::getagedetails($vendor_id)->min_age }}"
                                    placeholder="{{ trans('labels.min_age') }}" required>
                            </div>
                        </div>
                        <div class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
