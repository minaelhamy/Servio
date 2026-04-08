<div class="col-12 border p-2">
    <div class="d-flex justify-content-end">
        <button onclick="copy_data(myInput)" class="btn btn-primary px-sm-4 btn-sm">
            <span class="tooltiptext" id="myTooltip">{{ trans('labels.copy') }}</span>
        </button>
        <a href="{{ URL::to('/' . $vendordata->slug . '/embedded') }}" target="_blank"
            class="btn btn-primary px-sm-4 btn-sm mx-2">{{ trans('labels.preview') }}</a>
    </div>

    <div class="form-group col-sm-12 text-muted" id="myInput">
        {{ '<!--embedded code start -->' }}<br>
        {{ '<iframe src="' . URL::to('/' . $vendordata->slug . '/embedded') . '" height="' . $settingdata->frame_height . '" width="' . $settingdata->frame_width . '"></iframe>' }}<br>
        {{ '<!--embedded code end -->' }}
    </div>
</div>
<form action="{{ URL::to('/admin/framesettings') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row mt-3">
        <div class="form-group col-sm-6">
            <label class="form-label">{{ trans('labels.frame_height') }}</label>
            <input type="number" class="form-control" name="frame_height" value="{{ $settingdata->frame_height }}"
                min="1">
        </div>
        <div class="form-group col-sm-6">
            <label class="form-label">{{ trans('labels.frame_width') }}</label>
            <input type="number" class="form-control" name="frame_width" value="{{ $settingdata->frame_width }}"
                min="1">
        </div>
        <div class="form-group col-sm-6">
            <label class="form-label">{{ trans('labels.primary_color') }}</label>
            <input type="color" class="form-control form-control-color w-100 border-0" name="frame_color"
                value="{{ $settingdata->frame_color }}">
        </div>
        <div class="form-group col-sm-6">
            <label class="form-label">{{ trans('labels.secondary_color') }}</label>
            <input type="color" class="form-control form-control-color w-100 border-0" name="frame_secondarycolor"
                value="{{ $settingdata->frame_secondarycolor }}">
        </div>
        <div class="form-group col-sm-6">
            <label class="form-label">{{ trans('labels.logo') }}</label>
            <input type="file" class="form-control" name="frame_logo" value="{{ $settingdata->frame_logo }}">
            <img src="{{ helper::image_path($settingdata->frame_logo) }}" class="img-fluid rounded hw-70 mt-1"
                alt="">
        </div>
        <div class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
            <button @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_general_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
        </div>
    </div>

</form>
