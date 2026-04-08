<div class="row mb-5">
    <div class="col-12">
        <div class="card border-0 box-shadow">
            <div class="card-header p-3 bg-secondary">
                <h5 class="text-capitalize text-dark fw-600 m-0 color-changer">
                    {{ trans('labels.tips_settings') }}
                </h5>
            </div>
            <div class="card-body">
                <form class="form-body" action="{{ URL::to('admin/tips_update') }}" method="post">
                    @csrf
                    <div class="col-md-6 box-shadow rounded border">
                        <div class="d-flex align-items-center justify-content-between p-3">
                            <p class="fs-6 fw-500 color-changer">{{ trans('labels.tips_pro') }}
                            </p>
                            <div c lass="d-flex justify-content-end align-items-center">
                                <input id="tips_on_off" type="checkbox" class="checkbox-switch" name="tips_on_off"
                                    value="1" {{ @$othersettingdata->tips_on_off == 1 ? 'checked' : '' }}>
                                <label for="tips_on_off" class="switch">
                                    <span
                                        class="{{ session()->get('direction') == '2' ? 'switch__circle-rtl' : 'switch__circle' }} switch__circle"><span
                                            class="switch__circle-inner"></span></span>
                                    <span
                                        class="switch__left {{ session()->get('direction') == '2' ? ' pe-2' : ' ps-2' }}">{{ trans('labels.off') }}</span>
                                    <span
                                        class="switch__right {{ session()->get('direction') == '2' ? ' ps-2' : ' pe-2' }}">{{ trans('labels.on') }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions mt-3 text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                        <button
                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                            class="btn btn-primary px-sm-4">
                            {{ trans('labels.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
