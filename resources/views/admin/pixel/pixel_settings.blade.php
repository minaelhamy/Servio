<div id="pixel_settings">
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-header p-3 bg-secondary">
                    <h5 class="text-capitalize fw-600 text-dark color-changer">{{ trans('labels.pixel_settings') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ URL::to('/admin/pixcel_settings') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="facebook_pixel_id" class="form-label">{{ trans('labels.facebook') }}
                                </label>
                                <input type="text" class="form-control" name="facebook_pixcel_id"
                                    placeholder="{{ trans('labels.facebook_pixel_id') }}"
                                    value="{{ @$pixelsettings->facebook_pixcel_id }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="twitter_pixel_id" class="form-label">{{ trans('labels.twitter') }} </label>
                                <input type="text" class="form-control" name="twitter_pixcel_id"
                                    placeholder="{{ trans('labels.twitter_pixel_id') }}"
                                    value="{{ @$pixelsettings->twitter_pixcel_id }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="linkedin_pixel_id" class="form-label">{{ trans('labels.linkedin') }}
                                </label>
                                <input type="text" placeholder="{{ trans('labels.linkedin_pixel_id') }}"
                                    class="form-control" name="linkedin_pixcel_id"
                                    value="{{ @$pixelsettings->linkedin_pixcel_id }}">
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="googletag_pixel_id" class="form-label">{{ trans('labels.googletag') }}
                                </label>
                                <input type="text" class="form-control"
                                    placeholder="{{ trans('labels.googletag_pixel_id') }}" name="googletag_pixcel_id"
                                    value="{{ @$pixelsettings->google_tag_id }}">
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
