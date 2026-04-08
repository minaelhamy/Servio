<div id="whatsapp">
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-header p-3 bg-secondary">
                    <h5 class="text-capitalize fw-600 text-dark color-changer">
                        {{ trans('labels.whatsapp_message_settings') }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ URL::to('admin/settings/order_message_update') }}" method="POST">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label class="form-label"
                                        for="whatsapp_number">{{ trans('labels.whatsapp_number') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="number" name="whatsapp_number" id="whatsapp_number"
                                        class="form-control" placeholder="{{ trans('labels.whatsapp_number') }}"
                                        value="{{ @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number }}"
                                        required>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label class="form-label" for="">{{ trans('labels.whatsapp_chat') }}</label>
                                    <div class="text-center">
                                        <input id="whatsapp_chat_on_off" type="checkbox" class="checkbox-switch"
                                            name="whatsapp_chat_on_off" value="1"
                                            {{ @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_chat_on_off == 1 ? 'checked' : '' }}>
                                        <label for="whatsapp_chat_on_off" class="switch">
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
                                <div class="col-md-3 form-group">
                                    <label class="form-label" for="">{{ trans('labels.mobile_view_display') }}
                                    </label>
                                    <div class="text-center">
                                        <input id="whatsapp_mobile_view_on_off" type="checkbox" class="checkbox-switch"
                                            name="whatsapp_mobile_view_on_off" value="1"
                                            {{ @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_mobile_view_on_off == 1 ? 'checked' : '' }}>
                                        <label for="whatsapp_mobile_view_on_off" class="switch">
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
                                <div class="col-md-3 form-group">
                                    <p class="form-label">
                                        {{ trans('labels.whatsapp_chat_position') }}
                                    </p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input form-check-input-secondary" type="radio"
                                            name="whatsapp_chat_position" id="chatradio" value="1" required
                                            {{ @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_chat_position == '1' ? 'checked' : '' }}>
                                        <label for="chatradio"
                                            class="form-check-label">{{ trans('labels.left') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input form-check-input-secondary" type="radio"
                                            name="whatsapp_chat_position" id="chatradio1" value="2" required
                                            {{ @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_chat_position == '2' ? 'checked' : '' }}>
                                        <label for="chatradio1"
                                            class="form-check-label">{{ trans('labels.right') }}</label>
                                    </div>
                                </div>
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
