@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')

    <div class="row pb-3">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('admin/plan/save_plan') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger">
                                        *</span></label>
                                <input type="text" class="form-control" name="plan_name" value="{{ old('plan_name') }}"
                                    placeholder="{{ trans('labels.name') }}" required>

                            </div>
                            <div class="col-sm-3 form-group">
                                <label class="form-label">{{ trans('labels.amount') }}<span class="text-danger">
                                        *</span></label>
                                <input type="text" class="form-control numbers_decimal" name="plan_price"
                                    value="{{ old('plan_price') }}" placeholder="{{ trans('labels.amount') }}" required>

                            </div>
                            <div class="col-sm-3 form-group">
                                <label class="form-label">{{ trans('labels.tax') }}</label>
                                <select name="plan_tax[]" class="form-control selectpicker" multiple
                                    data-live-search="true">
                                    @if (!empty($gettaxlist))
                                        @foreach ($gettaxlist as $tax)
                                            <option value="{{ $tax->id }}"> {{ $tax->name }} </option>
                                        @endforeach
                                    @endif
                                </select>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.duration_type') }}</label>
                                    <select class="form-select type" name="type">
                                        <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>
                                            {{ trans('labels.fixed') }}
                                        </option>
                                        <option value="2" {{ old('type') == '2' ? 'selected' : '' }}>
                                            {{ trans('labels.custom') }}
                                        </option>
                                    </select>

                                </div>
                                <div class="form-group 1 selecttype">
                                    <label class="form-label">{{ trans('labels.duration') }}<span class="text-danger"> *
                                        </span></label>
                                    <select class="form-select" name="plan_duration">
                                        <option value="1">{{ trans('labels.one_month') }}</option>
                                        <option value="2">{{ trans('labels.three_month') }}</option>
                                        <option value="3">{{ trans('labels.six_month') }}</option>
                                        <option value="4">{{ trans('labels.one_year') }}</option>
                                        <option value="5">{{ trans('labels.lifetime') }}</option>
                                    </select>

                                </div>
                                <div class="form-group 2 selecttype">
                                    <label class="form-label">{{ trans('labels.days') }}
                                        <span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control numbers_only" name="plan_days" value=""
                                        placeholder="{{ trans('labels.days') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.service_limit') }}</label>
                                    <select class="form-select service_limit_type" name="service_limit_type">
                                        <option value="1" {{ old('service_limit_type') == '1' ? 'selected' : '' }}>
                                            {{ trans('labels.limited') }}
                                        </option>
                                        <option value="2" {{ old('service_limit_type') == '2' ? 'selected' : '' }}>
                                            {{ trans('labels.unlimited') }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group 1 service-limit">
                                    <label class="form-label">{{ trans('labels.service_count') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control numbers_only" name="plan_max_business"
                                        value="{{ old('plan_max_business') }}"
                                        placeholder="{{ trans('labels.service_count') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.booking_limit') }}</label>
                                    <select class="form-select booking_limit_type" name="booking_limit_type">
                                        <option value="1" {{ old('booking_limit_type') == '1' ? 'selected' : '' }}>
                                            {{ trans('labels.limited') }}
                                        </option>
                                        <option value="2" {{ old('booking_limit_type') == '2' ? 'selected' : '' }}>
                                            {{ trans('labels.unlimited') }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group 1 booking-limit">
                                    <label class="form-label">{{ trans('labels.booking_count') }}<span class="text-danger">
                                            *</span></label>
                                    <input type="text" class="form-control numbers_only" name="plan_appoinment_limit"
                                        value="{{ old('plan_appoinment_limit') }}"
                                        placeholder="{{ trans('labels.booking_count') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.users') }}</label>
                                    <select class="form-control selectpicker" name="vendors[]" multiple
                                        data-live-search="true">
                                        @if (!empty($vendors))
                                            @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor->id }}"
                                                    {{ old('vendor') == $vendor->id ? 'selected' : '' }}>
                                                    {{ $vendor->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.description') }}</label>
                                    <textarea class="form-control" rows="5" name="plan_description" placeholder="{{ trans('labels.description') }}">{{ old('plan_description') }}</textarea>
                                </div>
                                @if (@helper::checkaddons('product_shop'))
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.product_limit') }}</label>
                                        <select class="form-select product_limit_type" name="product_limit_type">
                                            <option value="1"
                                                {{ old('product_limit_type') == '1' ? 'selected' : '' }}>
                                                {{ trans('labels.limited') }}
                                            </option>
                                            <option value="2"
                                                {{ old('product_limit_type') == '2' ? 'selected' : '' }}>
                                                {{ trans('labels.unlimited') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group 1 product-limit">
                                        <label class="form-label">{{ trans('labels.product_s_count') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control numbers_only"
                                            name="product_plan_max_business" value="{{ old('plan_max_business') }}"
                                            placeholder="{{ trans('labels.product_s_count') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.order_limit') }}</label>
                                        <select class="form-select order_limit_type" name="order_limit_type">
                                            <option value="1" {{ old('order_limit_type') == '1' ? 'selected' : '' }}>
                                                {{ trans('labels.limited') }}
                                            </option>
                                            <option value="2" {{ old('order_limit_type') == '2' ? 'selected' : '' }}>
                                                {{ trans('labels.unlimited') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group 1 order-limit">
                                        <label class="form-label">{{ trans('labels.order_count') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control numbers_only"
                                            name="order_plan_appoinment_limit" value="{{ old('plan_appoinment_limit') }}"
                                            placeholder="{{ trans('labels.order_count') }}">
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.features') }}</label>
                                    <div id="repeater">
                                        <div class="d-flex gap-2 mb-2">
                                            <input type="text" class="form-control" name="plan_features[]"
                                                value="{{ old('plan_features[]') }}"
                                                placeholder="{{ trans('labels.features') }}">
                                            <button type="button" class="btn btn-secondary btn-sm" id="addfeature">
                                                <i class="fa-regular fa-plus"></i>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    @if (@helper::checkaddons('coupon'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="coupons"
                                                    id="coupons">
                                                <label class="form-check-label"
                                                    for="coupons">{{ trans('labels.coupons') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('custom_domain'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="custom_domain"
                                                    id="custom_domain">
                                                <label class="form-check-label"
                                                    for="custom_domain">{{ trans('labels.custome_domain_available') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('blog'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="blogs"
                                                    id="blogs">
                                                <label class="form-check-label"
                                                    for="blogs">{{ trans('labels.blogs') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('google_login'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="google_login"
                                                    id="google_login">
                                                <label class="form-check-label"
                                                    for="google_login">{{ trans('labels.google_login') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('facebook_login'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="facebook_login"
                                                    id="facebook_login">
                                                <label class="form-check-label"
                                                    for="facebook_login">{{ trans('labels.facebook_login') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('notification'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="sound_notification"
                                                    id="sound_notification">
                                                <label class="form-check-label"
                                                    for="sound_notification">{{ trans('labels.sound_notification') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('whatsapp_message'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="whatsapp_message"
                                                    id="whatsapp_message">
                                                <label class="form-check-label"
                                                    for="whatsapp_message">{{ trans('labels.whatsapp_message') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('telegram_message'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="telegram_message"
                                                    id="telegram_message">
                                                <label class="form-check-label"
                                                    for="telegram_message">{{ trans('labels.telegram_message') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('vendor_app'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="vendor_app"
                                                    id="vendor_app">
                                                <label class="form-check-label"
                                                    for="vendor_app">{{ trans('labels.vendor_app_available') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('user_app'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="customer_app"
                                                    id="customer_app">
                                                <label class="form-check-label"
                                                    for="customer_app">{{ trans('labels.customer_app') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('pwa'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="pwa"
                                                    id="pwa">
                                                <label class="form-check-label"
                                                    for="pwa">{{ trans('labels.pwa') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('employee'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="employee"
                                                    id="employee">
                                                <label class="form-check-label"
                                                    for="employee">{{ trans('labels.role_management') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('zoom'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="zoom"
                                                    id="zoom">
                                                <label class="form-check-label"
                                                    for="zoom">{{ trans('labels.zoom_meeting_available') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('google_calendar'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="calendar"
                                                    id="calendar">
                                                <label class="form-check-label"
                                                    for="calendar">{{ trans('labels.google_calendar_available') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('vendor_calendar'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="vendor_calendar"
                                                    id="vendor_calendar">
                                                <label class="form-check-label"
                                                    for="vendor_calendar">{{ trans('labels.vendor_calendar') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('subscription'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="pixel"
                                                    id="pixel">
                                                <label class="form-check-label"
                                                    for="pixel">{{ trans('labels.pixel') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.themes') }}
                                        <span class="text-danger"> * </span> </label>
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                    @endif
                                    @php
                                        $checktheme = @helper::checkthemeaddons('theme_');
                                        $themes = [];
                                        foreach ($checktheme as $ttlthemes) {
                                            array_push(
                                                $themes,
                                                str_replace('theme_', '', $ttlthemes->unique_identifier),
                                            );
                                        }
                                    @endphp
                                    <ul
                                        class="theme-selection row row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 g-3 flex-wrap">
                                        @foreach ($themes as $key => $item)
                                            <li class="col">
                                                <input type="checkbox" name="themecheckbox[]"
                                                    id="template{{ $item }}" value="{{ $item }}"
                                                    {{ $key == 0 ? 'checked' : '' }}>
                                                <label for="template{{ $item }}" class="p-0">
                                                    <img src="{{ helper::image_path('theme-' . $item . '.webp') }}">
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                            <a href="{{ URL::to('admin/plan') }}"
                                class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_pricing_plan', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
    <script src="{{ url(env('ASSETPATHURL') . '/admin-assets/js/plan.js') }}"></script>
@endsection
