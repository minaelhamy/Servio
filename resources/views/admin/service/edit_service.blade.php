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
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow mb-3">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/services/update-' . $service->slug) }}" method="POST"
                        enctype="multipart/form-data">
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
                                                {{ in_array($category_name->id, explode('|', $service->category_id)) ? 'selected' : '' }}>
                                                {{ $category_name->name }}</option>
                                        @endforeach
                                    @endif
                                </select>

                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control" name="service_name" value="{{ $service->name }}"
                                    placeholder="{{ trans('labels.name') }}" required>

                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.price') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="number" class="form-control" name="price" value="{{ $service->price }}"
                                    placeholder="{{ trans('labels.price') }}" required>

                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.original_price') }}</label>
                                <input type="number" class="form-control" name="original_price"
                                    value="{{ $service->original_price }}"
                                    placeholder="{{ trans('labels.original_price') }}">

                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.tax') }}</label>
                                <select name="tax[]" class="form-control selectpicker" multiple data-live-search="true">
                                    @if (!empty($gettaxlist))
                                        @foreach ($gettaxlist as $tax)
                                            <option value="{{ $tax->id }}"
                                                {{ in_array($tax->id, explode('|', $service->tax)) ? 'selected' : '' }}>
                                                {{ $tax->name }} </option>
                                        @endforeach
                                    @endif
                                </select>

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
                                            value="{{ $service->interval_time }}" aria-describedby="button-addon2"
                                            required>
                                        <select name="interval_type"
                                            class="border border-muted {{ session()->get('direction') == 2 ? 'rounded-start' : 'rounded-end' }}"
                                            id="">
                                            <option value="1" {{ $service->interval_type == 1 ? 'selected' : '' }}>
                                                {{ trans('labels.minute') }}</option>
                                            <option value="2" {{ $service->interval_type == 2 ? 'selected' : '' }}>
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
                                        value="{{ $service->per_slot_limit }}" required>

                                </div>
                            </div>
                            <div class="col-md-6 mb-lg-0">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.video_url') }}</label>
                                    <input type="text" class="form-control" name="video_url"
                                        placeholder="{{ trans('labels.video_url') }}" value="{{ $service->video_url }}">
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
                                                <label class="form-label">{{ trans('labels.staff_member') }} <span
                                                        class="text-danger">
                                                        * </span></label>
                                                <select class="form-control selectpicker" id="staff" name="staff[]"
                                                    multiple data-live-search="true" title="{{ trans('labels.select') }}">
                                                    @if (!empty($getstaflist))
                                                        @foreach ($getstaflist as $staff)
                                                            <option value="{{ $staff->id }}"
                                                                {{ in_array($staff->id, explode('|', $service->staff_id)) ? 'selected' : '' }}
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
                                                name="staff_assign" value="1"
                                                {{ $service->staff_assign == 1 ? 'checked' : '' }}>
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
                                            <select class="form-control selectpicker" id="staff" name="staff[]"
                                                multiple data-live-search="true" title="{{ trans('labels.select') }}">
                                                <option value="">{{ trans('labels.select') }}</option>
                                                @if (!empty($getstaflist))
                                                    @foreach ($getstaflist as $staff)
                                                        <option value="{{ $staff->id }}"
                                                            {{ in_array($staff->id, explode('|', $service->staff_id)) ? 'selected' : '' }}
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
                                            name="staff_assign" value="1"
                                            {{ $service->staff_assign == 1 ? 'checked' : '' }}>
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
                                <div class="row p-0 m-0">
                                    <div class="col-md-12 d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ trans('labels.addition_services') }} <span
                                                    class="text-danger">*</span> </label>
                                            <div class="col-md-12">
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_extras" type="radio"
                                                        name="additional_services" id="additional_no" value="2"
                                                        checked @if ($service->additional_services == 2) checked @endif>
                                                    <label class="form-check-label"
                                                        for="additional_no">{{ trans('labels.no') }}</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_extras" type="radio"
                                                        name="additional_services" id="additional_yes" value="1"
                                                        @if ($service->additional_services == 1) checked @endif>
                                                    <label class="form-check-label"
                                                        for="additional_yes">{{ trans('labels.yes') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-primary" type="button" id="add_additional_service"
                                                onclick="more_editadditional_service_fields('{{ trans('labels.name') }}','{{ trans('labels.price') }}')">
                                                <i class="fa-sharp fa-solid fa-plus"></i> </button>
                                        </div>
                                    </div>
                                    <div id="extras">
                                        @foreach ($service['additional_service'] as $key => $additional_service)
                                            <div class="col-12 m-0">
                                                <input type="hidden" class="form-control" name="additional_service_id[]"
                                                    value="{{ $additional_service->id }}">

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            @if ($key == 0)
                                                                <label class="col-form-label">{{ trans('labels.name') }}
                                                                    <span class="text-danger"> * </span></label>
                                                            @endif
                                                            <input type="text"
                                                                class="form-control additional_service_name"
                                                                name="additional_service_name[]"
                                                                value="{{ $additional_service->name }}"
                                                                placeholder="{{ trans('labels.name') }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            @if ($key == 0)
                                                                <label class="col-form-label">{{ trans('labels.price') }}
                                                                    <span class="text-danger"> * </span></label>
                                                            @endif
                                                            <input type="text"
                                                                class="form-control numbers_only additional_service_price"
                                                                name="additional_service_price[]"
                                                                value="{{ $additional_service->price }}"
                                                                placeholder="{{ trans('labels.price') }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            @if ($key == 0)
                                                                <label class="col-form-label">{{ trans('labels.image') }}
                                                                    <span class="text-danger"> * </span></label>
                                                            @endif
                                                            <div class="d-flex gap-2">
                                                                <input type="file" class="form-control numbers_only "
                                                                    name="additional_service_image[]" value="">

                                                                @if (count($service['additional_service']) > 1)
                                                                    <button class="btn btn-danger" type="button"
                                                                        @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="deleteadditional('{{ URL::to('/admin/services/deleteadditional-' . $additional_service->id) }}')" @endif>
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                            <div class="p-2">
                                                                <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/additional_service/' . $additional_service->image) }}"
                                                                    class="img-fluid" width="70" height="70">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="hiddenextrascount d-none">{{ $key }}</span>
                                        @endforeach

                                        <div id="more_editadditional_service_fields"></div>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group col-md-12">
                                <label class="form-label">{{ trans('labels.description') }}</label>
                                <textarea name="description" class="form-control" id="ckeditor" placeholder="{{ trans('labels.description') }}">{{ $service->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-end">

                            <a href="{{ URL::to('admin/services') }}"
                                class="btn btn-danger px-sm-4 mx-2">{{ trans('labels.cancel') }}</a>
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>

                        </div>
                    </form>
                </div>
            </div>

            @if ($service['multi_image']->count() > 0)
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card border-0 box-shadow mb-3">
                            <div class="card-body">
                                <div class="row g-3 sort_menu"
                                    data-url="{{ url('admin/services/reorder_image-' . $service->id) }}"
                                    id="carddetails">
                                    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center mb-2">
                                        <h5 class="text-capitalize fw-600 text-dark color-changer">
                                            {{ trans('labels.product_images') }}
                                        </h5>
                                        <a href="javascript:void(0)" onclick="addimage('{{ $service->id }}')"
                                            class="btn btn-primary mt-2 mt-sm-0 col-sm-auto col-12 px-sm-4">
                                            <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add_new') }}
                                        </a>


                                    </div>
                                    @foreach ($service['multi_image'] as $serviceimage)
                                        <div class="col-xl-2 col-lg-3 col-md-4 col-6" data-id="{{ $serviceimage->id }}">
                                            <div class="card h-100 border-0 handle">
                                                <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/service/' . $serviceimage->image_name) }}"
                                                    class="img-fluid service-image rounded-3 w-100 object">
                                                <div class="d-flex gap-1 my-2 justify-content-center">
                                                    <a tooltip="{{ trans('labels.move') }}"
                                                        class="btn btn-secondary hov btn-sm"><i
                                                            class="fa-light fa-up-down-left-right"></i></a>
                                                    <a href="javascript:void(0)" class="btn btn-info hov btn-sm"
                                                        onclick="imageview('{{ $serviceimage->id }}','{{ $serviceimage->image_name }}')"><i
                                                            class="fa-regular fa-pen-to-square"></i></a>
                                                    <a href="javascript:void(0)"
                                                        onclick="statusupdate('{{ URL::to('/admin/services/delete_image-' . $serviceimage->id . '/' . $serviceimage->service_id) }}')"
                                                        class="btn btn-danger hov btn-sm @if ($service['multi_image']->count() == 1) d-none @else '' @endif"><i
                                                            class="fa-regular fa-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif

            @if ($timingdata->count() > 0)
                <div class="card border-0 mb-3 box-shadow">
                    <div class="card-body">
                        <form action="{{ URL::to('/admin/services/update_working_hours') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <label class="col-md-2 col-form-label"></label>
                                <label
                                    class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block text-dark fw-500 fs-15 color-changer">{{ trans('labels.opening_time') }}</label>
                                <label
                                    class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block text-dark fw-500 fs-15 color-changer">{{ trans('labels.break_start') }}</label>
                                <label
                                    class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block text-dark fw-500 fs-15 color-changer">{{ trans('labels.break_end') }}</label>
                                <label
                                    class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block text-dark fw-500 fs-15 color-changer">{{ trans('labels.closing_time') }}</label>
                                <label
                                    class="col-md-2 text-center mb-0 d-none d-lg-block d-xl-block d-xxl-block text-dark fw-500 fs-15 color-changer">{{ trans('labels.always_closed') }}</label>
                            </div>
                            @foreach ($timingdata as $time)
                                <div class="row my-2">
                                    <div class="form-group col-md-2">
                                        <label class="form-label text-center fw-600 fs-15">
                                            @if ($time->day == 'Monday')
                                                {{ trans('labels.monday') }}
                                            @endif
                                            @if ($time->day == 'Tuesday')
                                                {{ trans('labels.tuesday') }}
                                            @endif
                                            @if ($time->day == 'Wednesday')
                                                {{ trans('labels.wednesday') }}
                                            @endif
                                            @if ($time->day == 'Thursday')
                                                {{ trans('labels.thursday') }}
                                            @endif
                                            @if ($time->day == 'Friday')
                                                {{ trans('labels.friday') }}
                                            @endif
                                            @if ($time->day == 'Saturday')
                                                {{ trans('labels.saturday') }}
                                            @endif
                                            @if ($time->day == 'Sunday')
                                                {{ trans('labels.sunday') }}
                                            @endif
                                        </label>
                                    </div>

                                    <input type="hidden" name="day[]" value="{{ $time->day }}">
                                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                                    <div class="form-group col-md-2">
                                        <input type="text" class="form-control timepicker"
                                            placeholder="{{ trans('labels.opening_time') }}"
                                            id="open{{ $time->day }}" name="open_time[]"
                                            @if ($time->is_always_close == '2') value="{{ $time->open_time }}" 
                                                @else value="{{ trans('labels.closed') }}" readonly="" @endif>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <input type="text" class="form-control timepicker"
                                            placeholder="{{ trans('labels.break_start') }}"
                                            id="break_start{{ $time->day }}" name="break_start[]"
                                            @if ($time->is_always_close == '2') value="{{ $time->break_start }}" 
                                    @else value="{{ trans('labels.closed') }}" readonly="" @endif>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <input type="text" class="form-control timepicker"
                                            placeholder="{{ trans('labels.break_end') }}"
                                            id="break_end{{ $time->day }}" name="break_end[]"
                                            @if ($time->is_always_close == '2') value="{{ $time->break_end }}"
                                    @else value="{{ trans('labels.closed') }}" readonly="" @endif>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <input type="text" class="form-control timepicker"
                                            placeholder="{{ trans('labels.closing_time') }}"
                                            id="close{{ $time->day }}" name="close_time[]"
                                            @if ($time->is_always_close == '2') value="{{ $time->close_time }}" 
                                                @else value="{{ trans('labels.closed') }}" readonly="" @endif>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <select class="form-control form-select" name="is_always_close[]"
                                            id="is_always_close{{ $time->day }}">
                                            <option value="" disabled>{{ trans('labels.select') }}</option>
                                            <option value="1" @if ($time->is_always_close == '1') selected @endif>
                                                {{ trans('messages.yes') }}</option>
                                            <option value="2" @if ($time->is_always_close == '2') selected @endif>
                                                {{ trans('messages.no') }}</option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                            <div
                                class="form-group col-md-12 text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                                <button
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                    class="btn btn-primary px-sm-4 btn-raised {{ Auth::user()->type == 4 ? (helper::check_access('role_services', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 || helper::check_access('role_workinghours', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif


            <div class="card border-0 mb-3 box-shadow">
                <div class="card-body">
                    <div class="table-responsive p-0">
                        <table
                            class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">
                            <thead>
                                <tr class="text-capitalize fw-500 fs-15">
                                    <td>{{ trans('labels.srno') }}</td>
                                    <td>{{ trans('labels.image') }}</td>
                                    <td>{{ trans('labels.name') }}</td>
                                    <td>{{ trans('labels.description') }}</td>
                                    <td>{{ trans('labels.ratting') }}</td>
                                    <td>{{ trans('labels.action') }}</td>
                                </tr>
                            </thead>
                            <tbody id="tabledetails" data-url="{{ url('admin/services/reorder_category') }}">
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($servicereview as $item)
                                    <tr class="fs-7 row1 align-middle" id="dataid{{ $item->id }}"
                                        data-id="{{ $item->id }}">
                                        <td>@php
                                            echo $i++;
                                        @endphp</td>
                                        <td>
                                            <img src="{{ @helper::image_path($item->user_info->image) }}"
                                                class="img-fluid rounded hw-50" alt="">
                                        </td>
                                        <td>{{ @$item->user_info->name }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->star }} </td>
                                        <td>
                                            <a href="javascript:void(0)"
                                                @if (env('Environment') == 'sendbox') onclick="myFunction()" @else
                                                        onclick="statusupdate('{{ URL::to('/admin/services/review/delete-' . $item->id) }}')" @endif
                                                class="btn btn-danger btn-sm hov {{ Auth::user()->type == 4 ? (helper::check_access('role_services', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                <i class="fa-regular fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- add Modal --}}
    <div class="modal modal-fade-transform" id="addModal" tabindex="-1" aria-labelledby="addModallable"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title" id="addModallable">
                        <span class="color-changer">
                            {{ trans('labels.image') }}
                        </span>
                        <span class="text-danger"> * </span>
                    </h5>
                    <button type="button" class="bg-transparent border-0 color-changer" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-regular fa-xmark fs-4"></i>
                    </button>
                </div>
                <form action=" {{ URL::to('/admin/services/add_image') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="service_id" name="service_id">
                        <input type="file" name="image[]" multiple="" class="form-control" id="">
                    </div>
                    <div class="modal-footer">
                        <button
                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- edit Modal --}}
    <div class="modal modal-fade-transform" id="editModal" tabindex="-1" aria-labelledby="editModallable"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title" id="editModallable">
                        <span class="color-changer">
                            {{ trans('labels.image') }}
                        </span>
                        <span class="text-danger"> * </span>
                    </h5>
                    <button type="button" class="bg-transparent border-0 color-changer" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-regular fa-xmark fs-4"></i>
                    </button>
                </div>
                <form action=" {{ URL::to('/admin/services/update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="img_id" name="id">
                        <input type="hidden" id="img_name" name="image">
                        <input type="file" name="service_image" class="form-control" id="">
                    </div>
                    <div class="modal-footer">
                        <button
                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/editor.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/timepicker/jquery.timepicker.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/workinghours.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/service.js') }}"></script>
@endsection
