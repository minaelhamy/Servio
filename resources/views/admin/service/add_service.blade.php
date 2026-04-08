@extends('admin.layout.default')
@section('content')
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $user = App\Models\User::where('id', $vendor_id)->first();
    @endphp
    @include('admin.breadcrumb.breadcrumb')
    <div class="row pb-3">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/services/save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.category') }}<span class="text-danger"> *
                                    </span></label>
                                <select class="form-control selectpicker" name="category_name[]" multiple
                                    data-live-search="true" id="categry" required>
                                    @if (!empty($category))
                                        @foreach ($category as $category_name)
                                            <option value="{{ $category_name->id }}"
                                                {{ old('category_name') == $category_name->id ? 'selected' : '' }}>
                                                {{ $category_name->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>

                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control" name="service_name"
                                    value="{{ old('service_name') }}" placeholder="{{ trans('labels.name') }}" required>

                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.price') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control numbers_decimal" name="price"
                                    value="{{ old('price') }}" placeholder="{{ trans('labels.price') }}" required>

                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.original_price') }}</label>
                                <input type="text" class="form-control numbers_decimal" name="original_price"
                                    value="{{ old('original_price') }}"
                                    placeholder="{{ trans('labels.original_price') }}">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.tax') }}</label>
                                <select name="tax[]" class="form-control selectpicker" multiple data-live-search="true">
                                    @if (!empty($gettaxlist))
                                        @foreach ($gettaxlist as $tax)
                                            <option value="{{ $tax->id }}"> {{ $tax->name }} </option>
                                        @endforeach
                                    @endif
                                </select>

                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.image') }}<span class="text-danger">
                                        * </span></label>
                                <input type="file" class="form-control" name="service_image[]" multiple="" required>

                            </div>
                            <div class="col-md-6 mb-lg-0">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.time_interval') }}<span class="text-danger">
                                            *
                                        </span></label>
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                            name="interval_time" placeholder="{{ trans('labels.time_interval') }}"
                                            aria-describedby="button-addon2" required>
                                        <select name="interval_type"
                                            class="border border-muted {{ session()->get('direction') == 2 ? 'rounded-start' : 'rounded-end' }}"
                                            id="">
                                            <option value="1" {{ old('interval_type') == 1 ? 'selected' : '' }}>
                                                {{ trans('labels.minute') }}</option>
                                            <option value="2" {{ old('interval_type') == 2 ? 'selected' : '' }}>
                                                {{ trans('labels.hour') }}</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6 mb-lg-0">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.perslot_booking_limit') }}<span
                                            class="text-danger">
                                            * </span></label>
                                    <input type="number" class="form-control" name="slot_limit"
                                        placeholder="{{ trans('labels.perslot_booking_limit') }}"
                                        value="{{ old('slot_limit') }}" required>

                                </div>
                            </div>
                            <div class="col-md-6 mb-lg-0">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.video_url') }}</label>
                                    <input type="text" class="form-control" name="video_url"
                                        placeholder="{{ trans('labels.video_url') }}" value="{{ old('video_url') }}">

                                </div>
                            </div>
                            @if (@helper::checkaddons('subscription'))
                                @if (@helper::checkaddons('employee'))
                                    @php
                                        $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                            ->orderByDesc('id')
                                            ->first();
                                        if (@$user->allow_without_subscription == 1) {
                                            $employee = 1;
                                        } else {
                                            $employee = @$checkplan->employee;
                                        }
                                    @endphp
                                    @if ($employee == 1)
                                        <div class="col-md-3 mb-lg-0">
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.staff_member') }}</label>
                                                <select class="form-control selectpicker" name="staff[]" multiple
                                                    data-live-search="true" id="staff">
                                                    @if (!empty($getstaflist))
                                                        @foreach ($getstaflist as $staff)
                                                            <option value="{{ $staff->id }}"
                                                                data-id="{{ $staff->id }}">
                                                                {{ $staff->name }} </option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                            </div>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label class="form-label" for="">{{ trans('labels.staff_assign') }}
                                            </label>
                                            <input id="staff-switch" type="checkbox" class="checkbox-switch"
                                                name="staff_assign" value="1">
                                            <label for="staff-switch" class="switch">
                                                <span
                                                    class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                        class="switch__circle-inner"></span></span>
                                                <span
                                                    class="switch__left {{ session()->get('direction') == 2 ? 'pe-1' : 'ps-1' }}">{{ trans('labels.off') }}</span>
                                                <span
                                                    class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                            </label>
                                        </div>
                                    @endif
                                @endif
                            @else
                                @if (@helper::checkaddons('employee'))
                                    <div class="col-md-3 mb-lg-0">
                                        <div class="form-group">
                                            <label class="form-label">{{ trans('labels.staff_member') }} <span
                                                    class="text-danger">
                                                    * </span></label>
                                            <select class="form-control selectpicker" name="staff[]" multiple
                                                data-live-search="true" id="editcat_id" required>
                                                @if (!empty($getstaflist))
                                                    @foreach ($getstaflist as $staff)
                                                        <option value="{{ $staff->id }}"
                                                            data-id="{{ $staff->id }}">
                                                            {{ $staff->name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group col-sm-3">
                                        <label class="form-label" for="">{{ trans('labels.staff_assign') }}
                                        </label>
                                        <input id="staff-switch" type="checkbox" class="checkbox-switch"
                                            name="staff_assign" value="1">
                                        <label for="staff-switch" class="switch">
                                            <span
                                                class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                    class="switch__circle-inner"></span></span>
                                            <span
                                                class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                            <span
                                                class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                        </label>
                                    </div>
                                @endif
                            @endif
                            @if (@helper::checkaddons('additional_service'))
                                <div class="row m-0 p-0">
                                    <div class="col-md-12 d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ trans('labels.addition_services') }}</label>
                                            <div class="col-md-12">
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_extras" type="radio"
                                                        name="additional_services" id="additional_no" value="2"
                                                        checked @if (old('additional_services') == 2) checked @endif>
                                                    <label class="form-check-label"
                                                        for="additional_no">{{ trans('labels.no') }}</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_extras" type="radio"
                                                        name="additional_services" id="additional_yes" value="1"
                                                        @if (old('additional_services') == 1) checked @endif>
                                                    <label class="form-check-label"
                                                        for="additional_yes">{{ trans('labels.yes') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <button class="btn btn-primary" type="button" id="add_additional_service"
                                                onclick="additional_service_fields('{{ trans('labels.name') }}','{{ trans('labels.price') }}')">
                                                <i class="fa-sharp fa-solid fa-plus"></i> </button>
                                        </div>
                                    </div>
                                    <div id="extras">
                                        <div id="more_additional_service_fields"></div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-12 form-group">
                                <label class="form-label">{{ trans('labels.description') }}</label>
                                <textarea name="description" class="form-control" id="ckeditor" placeholder="{{ trans('labels.description') }}">{{ old('description') }}</textarea>

                            </div>
                        </div>
                        <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                            <a href="{{ URL::to('admin/services') }}"
                                class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_services', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/editor.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/service.js') }}"></script>
@endsection
