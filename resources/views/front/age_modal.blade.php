<div class="modal fade age_modal" id="age_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="age_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fw-600 color-changer d-flex align-items-center gap-2" id="age_modalLabel">
                    <span class="number-verification">{{ @helper::getagedetails($vendordata->id)->min_age }}+</span>
                    {{ trans('labels.age_verification') }}
                </h4>
            </div>
            <div class="modal-body">
                <div class="">
                    <div class="alert alert-danger fs-15 fw-500 mb-2" style="display: none;" id="age-alert"
                        role="alert">
                        {{ trans('labels.age_alert') }}
                    </div>
                    <p class="fs-15 color-changer">{{ trans('labels.age_verification_text') }}</p>
                </div>

                <input type="hidden" id="popup_type" value="{{ @helper::getagedetails($vendordata->id)->popup_type }}">
                <input type="hidden" id="min_age" value="{{ @helper::getagedetails($vendordata->id)->min_age }}">
                @if (@helper::getagedetails($vendordata->id)->popup_type == 2)
                    <div class="col-12 mt-2">
                        <div class="row g-3">
                            <div class="col-sm-4">
                                <div class="form-group m-0">
                                    <input type="number" inputmode="numeric" name="dd" id="dd"
                                        placeholder="DD" class="form-control p-3" value="">
                                    <span class="text-danger" id="dd-required"
                                        style="display: none;">{{ trans('labels.required') }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-0">
                                    <input type="number" inputmode="numeric" name="mm" id="mm"
                                        placeholder="MM" class="form-control p-3" value="">
                                    <span class="text-danger" id="mm-required"
                                        style="display: none;">{{ trans('labels.required') }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group m-0">
                                    <input type="number" inputmode="numeric" name="yyyy" id="yyyy"
                                        placeholder="YYYY" class="form-control p-3" value="">
                                    <span class="text-danger" id="yyyy-required"
                                        style="display: none;">{{ trans('labels.required') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (@helper::getagedetails($vendordata->id)->popup_type == 3)
                    <div class="col-md-12 mt-2">
                        <input type="number" inputmode="numeric" name="age" id="age" class="form-control p-3"
                            value="" placeholder="{{ trans('labels.enter_age') }}">
                        <span class="text-danger" id="age-required"
                            style="display: none;">{{ trans('labels.required') }}</span>
                    </div>
                @endif
            </div>
            <div class="modal-footer p-3">
                <div class="col-12 m-0">
                    <div class="row flex-wrap g-3">
                        <div class="col-sm-6 col-12">
                            <button type="button" onclick="ageverificationcancel()"
                                class="btn btn-age-outline m-0 w-100 px-0">{{ trans('labels.cancel') }}</button>
                        </div>
                        <div class="col-sm-6 col-12">
                            <button type="button" onclick="ageverification()" class="btn btn-age m-0 w-100 px-0">
                                @if (@helper::getagedetails($vendordata->id)->popup_type == 1)
                                    {{ trans('labels.yes_i_am') }}
                                    {{ @helper::getagedetails($vendordata->id)->min_age }}
                                @else
                                    {{ trans('labels.yes') }}
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
