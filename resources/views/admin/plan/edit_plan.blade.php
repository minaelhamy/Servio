@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row pb-3">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('admin/plan/update_plan-' . $editplan->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control" name="plan_name" value="{{ $editplan->name }}"
                                    placeholder="{{ trans('labels.name') }}" required>

                            </div>
                            <div class="col-sm-3 form-group">
                                <label class="form-label">{{ trans('labels.amount') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control numbers_decimal" name="plan_price"
                                    value="{{ $editplan->price }}" placeholder="{{ trans('labels.price') }}" required>

                            </div>
                            <div class="col-sm-3 form-group">
                                <label class="form-label">{{ trans('labels.tax') }}</label>
                                <select name="plan_tax[]" class="form-control selectpicker" multiple
                                    data-live-search="true">
                                    @if (!empty($gettaxlist))
                                        @foreach ($gettaxlist as $tax)
                                            <option value="{{ $tax->id }}"
                                                {{ in_array($tax->id, explode('|', $editplan->tax)) ? 'selected' : '' }}>
                                                {{ $tax->name }} </option>
                                        @endforeach
                                    @endif
                                </select>

                            </div>
                            <div class="form-group col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.duration_type') }}</label>
                                    <select class="form-select type" name="type">
                                        <option value="1" {{ $editplan->plan_type == '1' ? 'selected' : '' }}>
                                            {{ trans('labels.fixed') }}</option>
                                        <option value="2" {{ $editplan->plan_type == '2' ? 'selected' : '' }}>
                                            {{ trans('labels.custom') }}</option>
                                    </select>

                                </div>
                                <div class="form-group 1 selecttype">
                                    <label class="form-label">{{ trans('labels.duration') }}<span class="text-danger"> *
                                        </span></label>
                                    <select class="form-select" name="plan_duration">
                                        <option value="1" {{ $editplan->duration == 1 ? 'selected' : '' }}>
                                            {{ trans('labels.one_month') }}</option>
                                        <option value="2" {{ $editplan->duration == 2 ? 'selected' : '' }}>
                                            {{ trans('labels.three_month') }}</option>
                                        <option value="3" {{ $editplan->duration == 3 ? 'selected' : '' }}>
                                            {{ trans('labels.six_month') }}</option>
                                        <option value="4" {{ $editplan->duration == 4 ? 'selected' : '' }}>
                                            {{ trans('labels.one_year') }}</option>
                                        <option value="5" {{ $editplan->duration == 5 ? 'selected' : '' }}>
                                            {{ trans('labels.lifetime') }}</option>
                                    </select>

                                </div>
                                <div class="form-group 2 selecttype">
                                    <label class="form-label">{{ trans('labels.days') }}
                                        <span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control numbers_only" name="plan_days"
                                        value="{{ $editplan->days }}">

                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.service_limit') }}</label>
                                    <select class="form-select service_limit_type" name="service_limit_type">
                                        <option value="1" {{ $editplan->order_limit != '-1' ? 'selected' : '' }}>
                                            {{ trans('labels.limited') }}</option>
                                        <option value="2" {{ $editplan->order_limit == '-1' ? 'selected' : '' }}>
                                            {{ trans('labels.unlimited') }}</option>
                                    </select>

                                </div>
                                <div class="form-group 1 service-limit">
                                    <label class="form-label">{{ trans('labels.max_business') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control numbers_only" name="plan_max_business"
                                        value="{{ $editplan->order_limit == -1 ? '' : $editplan->order_limit }}"
                                        placeholder="{{ trans('labels.max_business') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.booking_limit') }}</label>
                                    <select class="form-select booking_limit_type" name="booking_limit_type">
                                        <option value="1"
                                            {{ $editplan->appointment_limit != '-1' ? 'selected' : '' }}>
                                            {{ trans('labels.limited') }}</option>
                                        <option value="2"
                                            {{ $editplan->appointment_limit == '-1' ? 'selected' : '' }}>
                                            {{ trans('labels.unlimited') }}</option>
                                    </select>
                                </div>
                                <div class="form-group 1 booking-limit">
                                    <label class="form-label">{{ trans('labels.orders_limit') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control numbers_only" name="plan_appoinment_limit"
                                        value="{{ $editplan->appointment_limit == -1 ? '' : $editplan->appointment_limit }}"
                                        placeholder="{{ trans('labels.orders_limit') }}">
                                </div>
                                <div class="row">
                                    @if (@helper::checkaddons('coupon'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="coupons"
                                                    id="coupons" @if ($editplan->coupons == '1') checked @endif>
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
                                                    id="custom_domain" @if ($editplan->custom_domain == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="custom_domain">{{ trans('labels.custom_domain') }}</label>
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
                                                    id="blogs" @if ($editplan->blogs == '1') checked @endif>
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
                                                    id="google_login" @if ($editplan->google_login == '1') checked @endif>
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
                                                    id="facebook_login" @if ($editplan->facebook_login == '1') checked @endif>
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
                                                    id="sound_notification"
                                                    @if ($editplan->sound_notification == '1') checked @endif>
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
                                                    id="whatsapp_message"
                                                    @if ($editplan->whatsapp_message == '1') checked @endif>
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
                                                    id="telegram_message"
                                                    @if ($editplan->telegram_message == '1') checked @endif>
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
                                                    id="vendor_app" @if ($editplan->vendor_app == '1') checked @endif>
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
                                                    id="customer_app" @if ($editplan->customer_app == '1') checked @endif>
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
                                                    id="pwa" @if ($editplan->pwa == '1') checked @endif>
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
                                                    id="employee" @if ($editplan->employee == '1') checked @endif>
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
                                                    id="zoom" @if ($editplan->zoom == '1') checked @endif>
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
                                                    id="calendar" @if ($editplan->calendar == '1') checked @endif>
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
                                                    id="vendor_calendar"
                                                    @if ($editplan->vendor_calendar == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="vendor_calendar">{{ trans('labels.vendor_calendar') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('pixel'))
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="pixel"
                                                    id="pixel" @if ($editplan->pixel == '1') checked @endif>
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
                            <div class="form-group col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.description') }}</label>
                                    <textarea class="form-control" rows="3" name="plan_description"
                                        placeholder="{{ trans('labels.description') }}">{{ $editplan->description }}</textarea>
                                </div>
                                @if (@helper::checkaddons('product_shop'))
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.product_limit') }}</label>
                                        <select class="form-select product_limit_type" name="product_limit_type">
                                            <option value="1"
                                                {{ $editplan->product_order_limit != '-1' ? 'selected' : '' }}>
                                                {{ trans('labels.limited') }}
                                            </option>
                                            <option value="2"
                                                {{ $editplan->product_order_limit == '-1' ? 'selected' : '' }}>
                                                {{ trans('labels.unlimited') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group 1 product-limit">
                                        <label class="form-label">{{ trans('labels.product_s_count') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control numbers_only"
                                            name="product_plan_max_business"
                                            value="{{ $editplan->product_order_limit == -1 ? '' : $editplan->product_order_limit }}"
                                            placeholder="{{ trans('labels.product_s_count') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.order_limit') }}</label>
                                        <select class="form-select order_limit_type" name="order_limit_type">
                                            <option value="1"
                                                {{ $editplan->order_appointment_limit != '-1' ? 'selected' : '' }}>
                                                {{ trans('labels.limited') }}
                                            </option>
                                            <option value="2"
                                                {{ $editplan->order_appointment_limit == '-1' ? 'selected' : '' }}>
                                                {{ trans('labels.unlimited') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group 1 order-limit">
                                        <label class="form-label">{{ trans('labels.order_count') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control numbers_only"
                                            name="order_plan_appoinment_limit"
                                            value="{{ $editplan->order_appointment_limit == -1 ? '' : $editplan->order_appointment_limit }}"
                                            placeholder="{{ trans('labels.order_count') }}">
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.users') }}</label>
                                    <select class="form-control selectpicker" name="vendors[]" multiple
                                        data-live-search="true">
                                        @if (!empty($vendors))
                                            @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor->id }}"
                                                    {{ in_array($vendor->id, explode('|', $editplan->vendor_id)) ? 'selected' : '' }}>
                                                    {{ $vendor->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>

                                </div>
                                <hr>
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.features') }}</label>
                                    <div id="repeater">
                                        @php
                                            $new_array = [];
                                            if ($editplan->features != ' ') {
                                                $new_array = explode('|', $editplan->features);
                                            }
                                        @endphp
                                        @foreach ($new_array as $key => $features)
                                            <div class="d-flex gap-2 mb-2" id="deletediv{{ $key }}">
                                                <input type="text" class="form-control" name="plan_features[]"
                                                    value="{{ $features }}"
                                                    placeholder="{{ trans('labels.features') }}">
                                                @if ($key == 0)
                                                    <button type="button" class="btn btn-secondary btn-sm"
                                                        id="addfeature">
                                                        <i class="fa-regular fa-plus"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="deletefeature({{ $key }})">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
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
                                        $themes = @helper::availablePlanThemes('theme-');
                                        $selectedThemes = collect(old('themecheckbox', explode('|', $editplan->themes_id)))
                                            ->map(fn($theme) => (string) $theme)
                                            ->all();
                                    @endphp
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <button type="button" class="btn btn-sm btn-outline-primary js-select-all-themes">
                                            Select all themes
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary js-clear-all-themes">
                                            Clear all
                                        </button>
                                    </div>
                                    <ul
                                        class="theme-selection row row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 g-3 flex-wrap">
                                        @foreach ($themes as $item)
                                            <li class="col">
                                                <input type="checkbox" class="js-theme-checkbox" name="themecheckbox[]"
                                                    id="template{{ $item }}" value="{{ $item }}"
                                                    {{ in_array((string) $item, $selectedThemes, true) ? 'checked' : '' }}>
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
                            <a href="{{ URL::to('admin/plan') }}" class="btn btn-danger px-sm-4">Cancel</a>
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
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

        document.querySelectorAll('.js-select-all-themes').forEach((button) => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.js-theme-checkbox').forEach((checkbox) => {
                    checkbox.checked = true;
                });
            });
        });

        document.querySelectorAll('.js-clear-all-themes').forEach((button) => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.js-theme-checkbox').forEach((checkbox) => {
                    checkbox.checked = false;
                });
            });
        });
    </script>
    <script src="{{ url(env('ASSETPATHURL') . '/admin-assets/js/plan.js') }}"></script>
@endsection
