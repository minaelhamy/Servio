@extends('front.layout.master')
@section('content')
    <div class="container">
        <div class="breadcrumb-div pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL::to($vendordata->slug) }}" class="text-primary-color"><i
                                class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">{{ trans('labels.service_details') }}</li>
                    <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">{{ trans('labels.review_your_booking') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    @php
        if ($service->top_deals == 1 && @helper::top_deals($vendordata->id) != null) {
            if (@helper::top_deals($vendordata->id)->offer_type == 1) {
                if ($service->price > @helper::top_deals($vendordata->id)->offer_amount) {
                    $price = $service->price - @helper::top_deals($vendordata->id)->offer_amount;
                } else {
                    $price = $service->price;
                }
            } else {
                $price = $service->price - $service->price * (@helper::top_deals($vendordata->id)->offer_amount / 100);
            }
            $original_price = $service->price;
            $off = $original_price > 0 ? number_format(100 - ($price * 100) / $original_price, 1) : 0;
        } else {
            $price = $service->price;
            $original_price = $service->original_price;
            $off = $service->discount_percentage;
        }
    @endphp
    <!---- card-details ---->
    <section class="service-detail">
        <input type="hidden" id="vendor_id" value="{{ $vendordata->id }}">
        <input type="hidden" id="vendor_slug" value="{{ $vendordata->slug }}">
        <input type="hidden" id="service_id" value="{{ $service->id }}">
        <input type="hidden" id="service_image"
            value="{{ $service['service_image'] == null ? 'service.png' : $service['service_image']->image }}">
        <input type="hidden" id="service_name" value="{{ $service->name }}">
        <input type="hidden" id="price" value="{{ $price }}">

        <div class="container">
            <h2 class="section-title fw-bold fs-3">{{ trans('labels.review_your_booking') }}</h2>
            <div class="col-12 mt-4">
                <div class="card border-0 bg-lights rounded-4">
                    <!-- Card body -->
                    <div class="card-body d-flex justify-content-between flex-wrap">
                        <div class="col-12 d-flex">
                            <!-- Title and badge -->
                            <div class="col-12 px-sm-3">
                                <div>
                                    <!-- Badge -->
                                    @php
                                        $category = helper::getcategoryinfo($service->category_id, $service->vendor_id);
                                    @endphp
                                    <div class="badge text-bg-dark">{{ $category[0]->name }}</div>
                                    <!-- Title -->
                                    <h2 class="mt-2 mb-2 fs-4 fw-semibold color-changer">{{ $service->name }}</h2>
                                    @if (@helper::checkaddons('customer_login'))
                                        @if (helper::appdata($vendordata->id)->online_order == 1)
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    @if (@helper::checkaddons('product_reviews'))
                                                        @if (helper::appdata($vendordata->id)->product_ratting_switch == 1)
                                                            <!-- Rating -->
                                                            <ul class="list-inline mb-0">
                                                                <li
                                                                    class="list-inline-item me-1 h6 mb-0 fw-bold fs-7 color-changer">
                                                                    {{ number_format($averagerating, 1) }}
                                                                </li>
                                                                @for ($i = 0; $i < 5; $i++)
                                                                    @if ($i < $averagerating)
                                                                        <li class="list-inline-item me-0 small"><i
                                                                                class="fa-solid fa-star text-warning"></i>
                                                                        </li>
                                                                    @else
                                                                        <li class="list-inline-item me-0 small"><i
                                                                                class="fa-regular fa-star text-warning"></i>
                                                                        </li>
                                                                    @endif
                                                                @endfor
                                                            </ul>
                                                            <a href="#"
                                                                class="mb-0 m-0 fs-7 fw-semibold text-muted">({{ $totalreview }}
                                                                {{ trans('labels.reviews') }})</a>
                                                        @endif
                                                    @endif
                                                </div>

                                                <!-- price -->
                                                <div
                                                    class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                                                    <h4 class="fw-bold mb-0 pro-price color-changer">
                                                        {{ helper::currency_formate($price, $vendordata->id) }}
                                                    </h4>
                                                    @if ($service->tax != '' && $service->tax != null)
                                                        <span
                                                            class="text-success m-0 fs-7 fw-semibold">{{ trans('labels.exclusive_all_taxes') }}</span>
                                                    @else
                                                        <span
                                                            class="text-success m-0 fs-7 fw-semibold">{{ trans('labels.inclusive_all_taxes') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- addtional_service -->
                                            @if (!empty($additional_service) && $additional_service != null)
                                                <div
                                                    class="row g-3 row-cols-xl-4 row-cols-lg-3 row-cols-md-2 row-cols-1 p-2">
                                                    @foreach ($additional_service as $key => $add_service)
                                                        <div
                                                            class="col fw-bolder d-flex align-items-center staff-checked position-relative">
                                                            <input class="form-check-input position-absolute end-10 d-none"
                                                                type="" data-staffname="additional_service"
                                                                id="additional_service_{{ $key }}"
                                                                name="select_additional_service">
                                                            <label for="additional_service_{{ $key }}"
                                                                class="d-flex align-items-center p-2 rounded-3 form-control additional_services_card pointer">
                                                                <div class="d-flex gap-3 w-100 align-items-center fw-500">
                                                                    <img src="{{ helper::image_path($add_service->image) }}"
                                                                        width="70" height="70" class="rounded-3"
                                                                        alt="">
                                                                    <div>
                                                                        <p class="mb-1 fw-600 line-2 color-changer">
                                                                            {{ $add_service->name }}
                                                                        </p>
                                                                        <p
                                                                            class="d-flex align-items-center color-changer flex-wrap fw-500 m-0 gap-2">
                                                                            {{ helper::currency_formate($add_service->price, $vendordata->id) }}

                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!---- card-details ---->
    <!-- service detail section -->
    <section class="py-3 appoinment mb-5">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="wizzard">
                        <div class="wizzard-inner">
                            <!-- Tabs navs -->
                            <ul class="nav nav-tabs border-bottom-0 d-flex align-items-center justify-content-between mb-3"
                                id="pills-tab" role="tablist">
                                <li class="nav-item nav-item-li m-2 text-center" role="presentation">
                                    <a class="nav-link m-auto mb-lg-3 active" id="pills-home-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true" disabled>1</a>
                                    <h6 class="d-none d-lg-block fw-bold color-changer">{{ trans('labels.date_time') }}
                                    </h6>
                                </li>
                                <li class="nav-item nav-item-li new-line" role="presentation">
                                    <h6 class="m-2">
                                        <a class="nav-link m-auto mb-lg-3" id="pills-profile-tab" data-bs-toggle="pill"
                                            data-bs-target="#pills-profile" type="button" role="tab"
                                            aria-controls="pills-profile" aria-selected="false" disabled>2</a>
                                        <span
                                            class="d-none d-lg-block fw-bold color-changer">{{ trans('labels.information') }}</span>
                                    </h6>
                                </li>
                                <li class="nav-item nav-item-li m-2" role="presentation">
                                    <a class="nav-link m-auto mb-lg-3 {{ session()->has('apply') || session()->has('remove_coupen') ? 'active' : '' }}"
                                        id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact"
                                        type="button" role="tab" aria-controls="pills-contact"
                                        aria-selected="false" disabled>3</a>
                                    <h6 class="d-none d-lg-block fw-bold color-changer">
                                        {{ trans('labels.confirm_booking') }}</h6>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="pills-tabContent">
                            {{-- calender tab --}}
                            <div class="tab-pane fade active show" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="card rounded-4 border-0 bg-lights my-4">
                                    <div class="card-body p-4">
                                        <div class="row d-flex justify-content-around align-items-start">
                                            <div class="col-md-6 mb-4 mb-md-0">
                                                <h4 class="fw-semibold mb-4 border-bottom pb-2 color-changer">
                                                    {{ trans('labels.booking_date') }}
                                                </h4>

                                                <div class="card h-100 rounded-2 border-0 bg-white shadow">
                                                    <div class="card-body">
                                                        <div class="sl-appointment-calendar mb-3">
                                                            <div id="sl-calendar"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-md-0 mt-4">
                                                <h4 class="fw-semibold mb-4 border-bottom color-changer pb-2">
                                                    {{ trans('labels.booking_time') }}
                                                </h4>
                                                <div class="sl-appointment-time-holder mb-3 text-center overflow-auto overflow-x-hidden"
                                                    id="timelist">
                                                    <div id="close"><label class="text-danger"></div>
                                                    <div id="date_select_msg">
                                                        <div class="mx-auto"><i
                                                                class="fa-regular fa-clock fs-1 text-muted"></i></div>
                                                        <label class="text-dark color-changer">
                                                            <h5>{{ trans('messages.select_date') }}</h5><label>
                                                    </div>
                                                    <div id="no-slote" style="display: none;">
                                                        <div class="mx-auto"><i
                                                                class="fa-regular fa-clock fs-1 text-muted"></i></div>
                                                        <label class="text-dark color-changer">
                                                            <h5>{{ trans('messages.no_slote') }}</h5><label>
                                                    </div>
                                                    <div class="sl-timeslots overflow-auto" id="timeslote">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if (@helper::checkaddons('subscription'))
                                            @if (@helper::checkaddons('employee'))
                                                @php
                                                    $checkplan = App\Models\Transaction::where(
                                                        'vendor_id',
                                                        $vendordata->id,
                                                    )
                                                        ->orderByDesc('id')
                                                        ->first();
                                                    if (
                                                        helper::getslug($vendordata->id)->allow_without_subscription ==
                                                        1
                                                    ) {
                                                        $employee = 1;
                                                    } else {
                                                        $employee = @$checkplan->employee;
                                                    }
                                                @endphp
                                                @if ($employee == 1 && $service->staff_assign == 1)
                                                    <div class="mt-4">
                                                        <div class="col-12">
                                                            <h4 class="fw-semibold mb-4 border-bottom pb-2 color-changer">
                                                                {{ trans('labels.staff_member') }}
                                                            </h4>
                                                            <div>
                                                                <div class="row g-3">
                                                                    @foreach ($getstaflist as $key => $staff)
                                                                        <div
                                                                            class="col-xl-3 col-lg-4 col-md-6 col-12 fw-bolder d-flex align-items-center staff-checked position-relative">
                                                                            <input
                                                                                class="form-check-input position-absolute {{ session()->get('direction') == 2 ? 'start-10' : 'end-10' }} d-none"
                                                                                type="radio"
                                                                                value="{{ $staff->id }}"
                                                                                data-staffname="{{ $staff->name }}"
                                                                                id="staf{{ $key }}"
                                                                                onclick="getstaffmember(this.id)"
                                                                                name="selectstaf">
                                                                            <label for="staf{{ $key }}"
                                                                                class="d-flex align-items-center p-2 rounded-3 form-control bg-light pointer">
                                                                                <div
                                                                                    class="d-flex align-items-center fw-500">
                                                                                    <img src="{{ helper::image_path($staff->image) }}"
                                                                                        width="50" height="50"
                                                                                        class="rounded-3"
                                                                                        alt=""><span
                                                                                        class="mx-3">{{ $staff->name }}</span>
                                                                                </div>
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                @if (@helper::checkaddons('employee'))
                                                    <div class="mt-4">
                                                        <div class="col-12">
                                                            <h4 class="fw-semibold mb-4 border-bottom pb-2 color-changer">
                                                                {{ trans('labels.staff_member') }}
                                                            </h4>
                                                            <div>
                                                                <div class="row g-3">
                                                                    @foreach ($getstaflist as $key => $staff)
                                                                        <div
                                                                            class="col-xl-3 col-lg-4 col-md-6 col-12 fw-bolder d-flex align-items-center staff-checked position-relative">
                                                                            <input
                                                                                class="form-check-input position-absolute {{ session()->get('direction') == 2 ? 'start-10' : 'end-10' }} d-none"
                                                                                type="radio"
                                                                                value="{{ $staff->id }}"
                                                                                data-staffname="{{ $staff->name }}"
                                                                                id="staf{{ $key }}"
                                                                                onclick="getstaffmember(this.id)"
                                                                                name="selectstaf">
                                                                            <label for="staf{{ $key }}"
                                                                                class="d-flex align-items-center p-2 rounded-3 form-control bg-light pointer">
                                                                                <div
                                                                                    class="d-flex align-items-center fw-500">
                                                                                    <img src="{{ helper::image_path($staff->image) }}"
                                                                                        width="50" height="50"
                                                                                        class="rounded-3"
                                                                                        alt=""><span
                                                                                        class="mx-3">{{ $staff->name }}</span>
                                                                                </div>
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-lg btn-primary btn-submit rounded px-4"
                                        id="first_tab_next_btn">{{ trans('labels.next') }}<i
                                            class="fa-solid fa-arrow-right-long fw-normal mx-1"></i></button>
                                </div>
                            </div>
                            {{-- user information tab --}}
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="card border-0 bg-lights rounded-4 my-4">
                                    <div class="card-body p-4">
                                        <h4 class="fw-semibold mb-4 border-bottom pb-2 color-changer">
                                            {{ trans('labels.booking') }}
                                            {{ trans('labels.information') }}</h4>
                                        <div class="pb-0 info">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label
                                                        class="form-label text-muted">{{ trans('labels.first_name') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="first_name" id="first_name"
                                                        class="form-control mb-3"
                                                        placeholder="{{ trans('labels.first_name') }}">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label
                                                        class="form-label text-muted">{{ trans('labels.last_name') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="last_name" id="last_name"
                                                        class="form-control mb-3"
                                                        placeholder="{{ trans('labels.last_name') }}">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="form-label text-muted">{{ trans('labels.mobile') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"name="mobile" id="mobile"
                                                        class="form-control mobile-number mb-3"
                                                        placeholder="{{ trans('labels.mobile') }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="form-label text-muted">{{ trans('labels.email') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="email" id="email"
                                                        class="form-control mb-3"
                                                        placeholder="{{ trans('labels.email') }}">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label
                                                        class="form-label text-muted">{{ trans('labels.country') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"name="country" id="country"
                                                        class="form-control mb-3"
                                                        placeholder="{{ trans('labels.country') }}">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="form-label text-muted">{{ trans('labels.state') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"name="state" id="state"
                                                        class="form-control mb-3"
                                                        placeholder="{{ trans('labels.state') }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="form-label text-muted">{{ trans('labels.city') }}<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="city" id="city"
                                                        class="form-control mb-3"
                                                        placeholder="{{ trans('labels.city') }}">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label
                                                        class="form-label text-muted">{{ trans('labels.postalcode') }}</label>
                                                    <input type="text"name="postalcode" id="postalcode"
                                                        class="form-control mb-3"
                                                        placeholder="{{ trans('labels.postalcode') }}">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label
                                                        class="form-label text-muted">{{ trans('labels.landmark') }}</label>
                                                    <input type="text" name="landmark" id="landmark"
                                                        class="form-control mb-3"
                                                        placeholder="{{ trans('labels.landmark') }}">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <label
                                                        class="form-label text-muted">{{ trans('labels.address') }}<span
                                                            class="text-danger">*</span></label>
                                                    <textarea class="form-control mb-3" rows="5" name="address" id="address"
                                                        placeholder="{{ trans('labels.address') }}"></textarea>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <label
                                                        class="form-label text-muted">{{ trans('labels.message') }}</label>
                                                    <textarea class="form-control" rows="5" name="message" id="message"
                                                        placeholder="{{ trans('labels.message') }}"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-3">
                                    <button type="button" id="previous_btn_tab_2"
                                        class="btn btn-outline-secondary color-changer btn-submit rounded fw-semibold">{{ trans('labels.previous') }}</button>
                                    <button type="button" class="btn btn-primary fw-semibold btn-submit rounded"
                                        id="second_tab_next_btn">{{ trans('labels.continue') }}</span></button>
                                </div>
                            </div>
                            {{--  booking summary tab --}}
                            <div class="tab-pane fade content-section" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab">
                                <div class="card rounded-4 border-0 bg-lights my-4">
                                    <div class="card-body p-4">
                                        <h5 class="fw-semibold mb-4 border-bottom color-changer pb-2">
                                            {{ trans('labels.confirm_booking') }}
                                        </h5>
                                        <div class="row g-3">
                                            <div class="col-lg-8 col-12">
                                                <div class="row mb-3 g-3">
                                                    <!----- date time ----->
                                                    <div class="col-md-4 date_time">
                                                        <div class="card h-100 rounded-4 border overflow-hidden">
                                                            <div class="card-header p-3 bg-transparent border-bottom">
                                                                <h6 class="fw-600 m-0 color-changer">
                                                                    {{ trans('labels.date_time') }}
                                                                </h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i
                                                                        class="fa-regular fa-calendar-days text-primary-color"></i>
                                                                    <p class="text-muted fs-7 booking_date m-0"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!----- date time ----->

                                                    <!----- date time ----->
                                                    <div class="col-md-4 date_time">
                                                        <div class="card h-100 rounded-4 border overflow-hidden">
                                                            <div class="card-header p-3 bg-transparent border-bottom">
                                                                <h6 class="fw-600 m-0 color-changer">
                                                                    {{ trans('labels.date_time') }}
                                                                </h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <i class="fa-regular fa-clock text-primary-color"></i>
                                                                    <p class="text-muted fs-7 booking_time m-0"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if (@helper::checkaddons('subscription'))
                                                        @if (@helper::checkaddons('employee'))
                                                            @php
                                                                $checkplan = App\Models\Transaction::where(
                                                                    'vendor_id',
                                                                    $vendordata->id,
                                                                )
                                                                    ->orderByDesc('id')
                                                                    ->first();

                                                                if (
                                                                    helper::getslug($vendordata->id)
                                                                        ->allow_without_subscription == 1
                                                                ) {
                                                                    $employee = 1;
                                                                } else {
                                                                    $employee = @$checkplan->employee;
                                                                }
                                                            @endphp
                                                            @if ($employee == 1 && $service->staff_assign == 1)
                                                                <div class="col-md-4" id="staff_member">
                                                                    <div
                                                                        class="card h-100 rounded-4 border overflow-hidden">
                                                                        <div class="card-header p-3 bg-white">
                                                                            <h6 class="fw-600 m-0">
                                                                                {{ trans('labels.staff_member') }}
                                                                            </h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="d-flex align-items-center gap-2">
                                                                                <i
                                                                                    class="fa-regular fa-circle-user text-primary-color"></i>
                                                                                <p
                                                                                    class="text-muted fs-7 m-0 staff_member">
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @else
                                                        @if (@helper::checkaddons('employee'))
                                                            @if ($service->staff_assign == 1)
                                                                <div class="col-md-4">
                                                                    <div
                                                                        class="card h-100 rounded-4 border overflow-hidden">
                                                                        <div class="card-header p-3 bg-white">
                                                                            <h6 class="fw-600 m-0">
                                                                                {{ trans('labels.staff_member') }}
                                                                            </h6>
                                                                        </div>
                                                                        <div class="card-body">
                                                                            <div class="d-flex align-items-center gap-2">
                                                                                <i
                                                                                    class="fa-regular fa-circle-user text-primary-color"></i>
                                                                                <p
                                                                                    class="text-muted fs-7 m-0 staff_member">
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    @endif

                                                    <!----- date time ----->
                                                </div>

                                                <!----- booking information ----->
                                                <div class="card rounded-4 border overflow-hidden">
                                                    <div class="card-header p-3 bg-transparent border-bottom">
                                                        <h6 class="fw-600 m-0 color-changer">
                                                            {{ trans('labels.booking_information') }}
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="date-time-text">
                                                            <div class="row g-2">
                                                                <!-- address and massage -->
                                                                <div class="col-md-6">
                                                                    <div class="d-flex flex-column gap-2">
                                                                        <div class="d-flex gap-2">
                                                                            <p class="summary-text-weight color-changer">
                                                                                {{ trans('labels.name') }} :</p>
                                                                            <span class="text-muted show_first_name"><span>
                                                                        </div>
                                                                        <div class="d-flex gap-2">
                                                                            <p class="summary-text-weight color-changer">
                                                                                {{ trans('labels.mobile') }} :</p>
                                                                            <span class="text-muted show_mobile"></span>
                                                                        </div>
                                                                        <div class="d-flex gap-2">
                                                                            <p class="summary-text-weight color-changer">
                                                                                {{ trans('labels.country') }} :</p>
                                                                            <span class="text-muted show_country"><span>
                                                                        </div>
                                                                        <div class="d-flex gap-2">
                                                                            <p class="summary-text-weight color-changer">
                                                                                {{ trans('labels.city') }} :</p>
                                                                            <span class="text-muted show_city"><span>
                                                                        </div>
                                                                        <div class="d-flex gap-2">
                                                                            <p class="summary-text-weight color-changer">
                                                                                {{ trans('labels.landmark') }} :</p>
                                                                            <span class="text-muted show_landmark"><span>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="d-flex flex-column gap-2">
                                                                        <div class="d-flex gap-2">
                                                                            <p class="summary-text-weight color-changer">
                                                                                {{ trans('labels.last_name') }} :</p>
                                                                            <span class="text-muted show_last_name"><span>
                                                                        </div>
                                                                        <div class="d-flex gap-2">
                                                                            <p class="summary-text-weight color-changer">
                                                                                {{ trans('labels.email') }} :</p>
                                                                            <span class="text-muted show_email"><span>
                                                                        </div>
                                                                        <div class="d-flex gap-2">
                                                                            <p class="summary-text-weight color-changer">
                                                                                {{ trans('labels.state') }} :</p>
                                                                            <span class="text-muted show_state"><span>
                                                                        </div>
                                                                        <div class="d-flex gap-2">
                                                                            <p class="summary-text-weight color-changer">
                                                                                {{ trans('labels.postalcode') }} :</p>
                                                                            <span class="text-muted show_postalcode"><span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- address and massage -->

                                                                <!-- address and massage -->
                                                                <div class="col-md-6">
                                                                    <div class="d-flex gap-2">
                                                                        <p class="summary-text-weight color-changer">
                                                                            {{ trans('labels.address') }}&nbsp;:</p>
                                                                        <span
                                                                            class="text-muted text-align show_address text-truncate-3">
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="d-flex gap-2">
                                                                        <p class="summary-text-weight">
                                                                            {{ trans('labels.message') }}&nbsp;:</p>
                                                                        <span
                                                                            class="text-muted text-align show_message text-truncate-3">
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <!-- address and massage -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!----- booking information ----->
                                                @if (@helper::checkaddons('vendor_tip'))
                                                    @if (@helper::otherappdata($vendordata->id)->tips_on_off == 1)
                                                        <div class="card rounded-4 border overflow-hidden mt-3">
                                                            <div class="card-header p-3 bg-transparent border-bottom">
                                                                <h6 class="fw-600 m-0 color-changer">
                                                                    {{ trans('labels.tips_pro') }}
                                                                </h6>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="col-md-12">
                                                                    <div class="form-group m-0">
                                                                        <label for="tips_amount" class="form-label">
                                                                            {{ trans('labels.add_amount') }}
                                                                        </label>
                                                                        <input type="number" class="form-control"
                                                                            id="tips_amount"
                                                                            placeholder="{{ trans('labels.add_amount_p') }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="col-lg-4 col-12">
                                                <!-- Price Summary -->
                                                <div class="card mb-3 rounded-4 border overflow-hidden">
                                                    <div class="card-header p-3 bg-transparent border-bottom">
                                                        <h6 class="fw-600 m-0 color-changer">
                                                            {{ trans('labels.price_summary') }}</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group list-group-flush">
                                                            <li
                                                                class="list-group-item d-flex fs-15 justify-content-between px-0 py-3 fw-500">
                                                                <p class="text-muted">
                                                                    {{ trans('labels.subtotal') }}
                                                                </p>
                                                                <span
                                                                    class="text-dark color-changer fw-500">{{ helper::currency_formate($price, $vendordata->id) }}</span>
                                                            </li>
                                                            @php

                                                                $add_service_price = 0;
                                                            @endphp
                                                            @if (!empty($additional_service) && $additional_service != null)
                                                                @foreach ($additional_service as $add_service)
                                                                    @php
                                                                        $add_service_price +=
                                                                            (float) $add_service['price'];
                                                                    @endphp
                                                                @endforeach
                                                                <li
                                                                    class="list-group-item d-flex fs-15 justify-content-between px-0 py-3 fw-500">
                                                                    <p class="text-muted">
                                                                        {{ trans('labels.additional_service') }}
                                                                    </p>
                                                                    <span
                                                                        class="text-dark color-changer fw-500">{{ helper::currency_formate($add_service_price, $vendordata->id) }}</span>
                                                                </li>
                                                            @endif
                                                            @php
                                                                $discount = @session()->get('discount_data')[
                                                                    'offer_amount'
                                                                ];
                                                            @endphp
                                                            <li
                                                                class="list-group-item d-flex fs-15 fw-500 justify-content-between px-0 py-3 fw-semibold discount_section d-none">
                                                                <p class="text-muted">
                                                                    {{ trans('labels.discount') }}
                                                                </p>
                                                                <span id="offer_amount"
                                                                    class="text-dark color-changer fw-500"> -
                                                                    {{ helper::currency_formate($discount, $vendordata->id) }}
                                                                </span>
                                                            </li>
                                                            @php
                                                                $taxlist = helper::gettax($service->tax);
                                                                $newtax = [];
                                                                $tax_name = [];
                                                                $totaltax = 0;
                                                            @endphp
                                                            @if ($service->tax != null && $service->tax != '')
                                                                @foreach ($taxlist as $tax)
                                                                    <li
                                                                        class="list-group-item fs-15 fw-500 d-flex justify-content-between px-0 py-3 fw-semibold">
                                                                        <p class="text-muted">{{ $tax->name }}</p>
                                                                        <span class="text-dark color-changer fw-500">
                                                                            {{ $tax->type == 1 ? helper::currency_formate($tax->tax, $vendordata->id) : helper::currency_formate($service->price * ($tax->tax / 100), $vendordata->id) }}
                                                                        </span>
                                                                        @php

                                                                            if ($tax->type == 1) {
                                                                                $newtax[] = $tax->tax;
                                                                            } else {
                                                                                $newtax[] =
                                                                                    $service->price * ($tax->tax / 100);
                                                                            }
                                                                            $tax_name[] = $tax->name;
                                                                        @endphp
                                                                    </li>
                                                                @endforeach
                                                                @foreach ($newtax as $item)
                                                                    @php
                                                                        $totaltax += (float) $item;
                                                                    @endphp
                                                                @endforeach
                                                            @endif
                                                            <input type="hidden" id="tax"
                                                                value="{{ implode('|', $newtax) }}">
                                                            <input type="hidden" value="{{ implode('|', $tax_name) }}"
                                                                id="tax_name">
                                                            <li
                                                                class="list-group-item d-flex justify-content-between px-0 pt-3 fw-600 fs-16 text-success">
                                                                {{ trans('labels.grand_total') }}

                                                                @php

                                                                    $grand_total =
                                                                        $price -
                                                                        $discount +
                                                                        $totaltax +
                                                                        $add_service_price;

                                                                @endphp
                                                                <span id="grand_total"
                                                                    class="fw-600">{{ helper::currency_formate($grand_total, $vendordata->id) }}</span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <!-- Price Summary -->
                                                @include('front.service.sevirce-trued')
                                                <!-- Offer and discount -->
                                                @if (@helper::checkaddons('subscription'))
                                                    @if (@helper::checkaddons('coupon'))
                                                        @php
                                                            $checkplan = App\Models\Transaction::where(
                                                                'vendor_id',
                                                                $vendordata->id,
                                                            )
                                                                ->where('transaction_type', null)
                                                                ->orderByDesc('id')
                                                                ->first();
                                                            if (
                                                                helper::getslug($vendordata->id)
                                                                    ->allow_without_subscription == 1
                                                            ) {
                                                                $coupons = 1;
                                                            } else {
                                                                $coupons = @$checkplan->coupons;
                                                            }
                                                        @endphp
                                                        @if ($coupons == 1)
                                                            <div class="card mb-3 rounded-4 border overflow-hidden">
                                                                <div
                                                                    class="card-header p-3 bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                                                    <h6 class="fw-600 m-0 color-changer">
                                                                        {{ trans('labels.offer_discount') }}</h6>
                                                                    <a href="javascript:void(0)" id="selectPromocode"
                                                                        class="d-none text-success" data-bs-toggle="modal"
                                                                        data-bs-target="#promocodemodal">
                                                                        {{ trans('promocode') }}
                                                                    </a>
                                                                </div>
                                                                <div class="card-body p-3 date-time-text">
                                                                    <div class="promocode-widget">
                                                                        <div class="row g-2 align-items-center">
                                                                            <div class="col-xl-9 col-lg-8 col-md-9 col-12">
                                                                                <input
                                                                                    class="form-control form-control-lg rounded fs-7"
                                                                                    type="text"
                                                                                    value="{{ @Session::get('discount_data')['offer_code'] }}"
                                                                                    name="offer_code" id="offer_code"
                                                                                    placeholder="{{ trans('labels.enter_coupon_code') }}"
                                                                                    readonly>
                                                                            </div>
                                                                            <div class="col-xl-3 col-lg-4 col-md-3 col-12">
                                                                                <button onclick="ApplyCoupon()"
                                                                                    id="btnapply"
                                                                                    class="btn w-100 py-2 px-3 btn-primary mb-0 rounded btn-submit d-flex justify-content-center">{{ trans('labels.apply') }}</button>
                                                                                <button onclick="RemoveCoupon()"
                                                                                    id="btnremove"
                                                                                    class="btn w-100 py-2 px-3 btn-primary mb-0 rounded btn-submit d-flex justify-content-center d-none">{{ trans('labels.remove') }}</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endif
                                                @else
                                                    @if (@helper::checkaddons('coupon'))
                                                        <div class="card mb-3 rounded-4 border overflow-hidden">
                                                            <div
                                                                class="card-header p-3 bg-transparent border-bottom d-flex align-items-center justify-content-between">
                                                                <h6 class="fw-600 m-0 color-changer">
                                                                    {{ trans('labels.offer_discount') }}</h6>
                                                                <a href="javascript:void(0)" id="selectPromocode"
                                                                    class="d-none text-success" data-bs-toggle="modal"
                                                                    data-bs-target="#promocodemodal">
                                                                    {{ trans('promocode') }}
                                                                </a>
                                                            </div>
                                                            <div class="card-body p-3 date-time-text">
                                                                <div class="promocode-widget">
                                                                    <div class="row g-2 align-items-center">
                                                                        <div class="col-xl-9 col-lg-8 col-md-9 col-12">
                                                                            <input
                                                                                class="form-control form-control-lg rounded fs-7"
                                                                                type="text"
                                                                                value="{{ @Session::get('discount_data')['offer_code'] }}"
                                                                                name="offer_code" id="offer_code"
                                                                                placeholder="{{ trans('labels.enter_coupon_code') }}"
                                                                                readonly>
                                                                        </div>
                                                                        <div class="col-xl-3 col-lg-4 col-md-3 col-12">
                                                                            <button onclick="ApplyCoupon()" id="btnapply"
                                                                                class="btn w-100 py-2 px-3 btn-primary mb-0 rounded btn-submit d-flex justify-content-center">{{ trans('labels.apply') }}</button>
                                                                            <button onclick="RemoveCoupon()"
                                                                                id="btnremove"
                                                                                class="btn w-100 py-2 px-3 btn-primary mb-0 rounded btn-submit d-flex justify-content-center d-none">{{ trans('labels.remove') }}</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                                <!-- Offer and discount -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (helper::allpaymentcheckaddons($vendordata->id))
                                    @if (helper::appdata($vendordata->id)->payment_process_options == 3)
                                        <!-- payment option -->
                                        <div class="card border-0 rounded-4 bg-lights mt-4">
                                            <div class="card-body p-4">
                                                <h5 class="fw-semibold mb-3 border-bottom pb-2 color-changer">
                                                    Payment Method
                                                </h5>
                                                <div class="row g-3" id="paynow">
                                                    <div
                                                        class="col-xl-3 col-lg-4 col-md-6 col-12 fw-bolder d-flex align-items-center payment-checked position-relative">
                                                        <input
                                                            class="form-check-input position-absolute {{ session()->get('direction') == 2 ? 'start-10' : 'end-10' }}"
                                                            type="radio" value="1" id="pay_now"
                                                            name="payment_options">
                                                        <label for="pay_now"
                                                            class="d-flex align-items-center py-4 rounded-4 form-control bg-white pointer">
                                                            <div class="payment-gateway d-flex align-items-center fw-500">
                                                                {{ trans('labels.pay_now') }}
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div
                                                        class="col-xl-3 col-lg-4 col-md-6 col-12 fw-bolder d-flex align-items-center payment-checked position-relative">
                                                        <input
                                                            class="form-check-input position-absolute {{ session()->get('direction') == 2 ? 'start-10' : 'end-10' }}"
                                                            type="radio" value="2" id="pay_later"
                                                            name="payment_options">
                                                        <label for="pay_later"
                                                            class="d-flex align-items-center py-4 rounded-4 form-control bg-white pointer">
                                                            <div class="payment-gateway d-flex align-items-center fw-500">
                                                                {{ trans('labels.pay_later') }}
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- payment option -->
                                    @endif
                                @else
                                    <input
                                        class="form-check-input position-absolute d-none {{ session()->get('direction') == 2 ? 'start-10' : 'end-10' }}"
                                        type="radio" checked value="2" id="pay_later" name="payment_options">
                                @endif
                                <!-- payment status -->
                                <div class="card border-0 rounded-4 bg-lights mt-4 payment_methods"
                                    style="display: none;">
                                    <div class="card-body p-4">
                                        <h5 class="fw-semibold mb-3 border-bottom pb-2 color-changer">
                                            {{ trans('labels.payment_type') }}
                                        </h5>
                                        <div class="row g-3" id="paynow">
                                            @foreach ($getpayment as $payment)
                                                @php
                                                    // Check if the current $payment is a system addon and activated
                                                    if (
                                                        $payment->payment_type == '1' ||
                                                        $payment->payment_type == '16'
                                                    ) {
                                                        $systemAddonActivated = true;
                                                    } else {
                                                        $systemAddonActivated = false;
                                                    }
                                                    $addon = App\Models\SystemAddons::where(
                                                        'unique_identifier',
                                                        $payment->unique_identifier,
                                                    )->first();
                                                    if ($addon != null && $addon->activated == 1) {
                                                        $systemAddonActivated = true;
                                                    }
                                                    $payment_type = $payment->payment_type;
                                                @endphp
                                                @if ($systemAddonActivated)
                                                    <div
                                                        class="col-xl-3 col-lg-4 col-md-6 col-12 fw-bolder d-flex align-items-center payment-checked position-relative">
                                                        <input
                                                            class="form-check-input position-absolute {{ session()->get('direction') == 2 ? 'start-10' : 'end-10' }}"
                                                            type="radio" value="{{ $payment->public_key }}"
                                                            id="payment{{ $payment_type }}"
                                                            data-transaction-type="{{ $payment_type }}"
                                                            @if ($payment_type == '6') data-bank-description="{{ $payment->payment_description }}" @endif
                                                            data-currency="{{ $payment->currency }}" name="paymentmode">
                                                        <label for="payment{{ $payment_type }}"
                                                            class="d-flex align-items-center py-4 rounded-4 form-control bg-white pointer">
                                                            <div class="payment-gateway d-flex align-items-center fw-500">
                                                                <img src="{{ helper::image_path($payment->image) }}"
                                                                    width="30" height="30" class="mx-3"alt=""
                                                                    srcset="">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    {{ $payment->payment_name }}
                                                                    @if (Auth::user())
                                                                        @if ($payment_type == 16)
                                                                            <span class="fw-500 text-muted">
                                                                                {{ helper::currency_formate(Auth::user()->wallet, $vendordata->id) }}
                                                                            </span>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </label>
                                                        @if ($payment_type == '3')
                                                            <input type="hidden" name="stripe_public_key"
                                                                id="stripe_public_key"
                                                                value="{{ $payment->public_key }}">
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- payment status -->
                                <div class="d-flex justify-content-between  mt-4">
                                    <a type="button" id="previous_btn_tab_3"
                                        class="btn btn-outline-secondary color-changer btn-md btn-submit rounded">{{ trans('labels.previous') }}</a>

                                    <button id="btnsave"
                                        onclick="createbooking('{{ URL::to($vendordata->slug . '/service/booking') }}')"
                                        class="btn btn-outline-primary bg-primary btn-submit rounded text-white">{{ trans('labels.book_now') }}
                                    </button>
                                    <button id="book_loader" disabled
                                        class="btn btn-lg btn-primary btn-submit rounded px-4 d-none">
                                        <div class="load showload"></div>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Tabs navs -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" value="{{ trans('messages.payment_selection_required') }}" name="paymentmode_message"
        id="paymentmode_message">
    <input type="hidden" value="{{ trans('messages.payment_options_selection_required') }}"
        name="payment_options_message" id="payment_options_message">
    <input type="hidden" id="hidden_grand_total" value="{{ $grand_total }}">
    <input type="hidden" id="timesloturl" value="{{ URL::to($vendordata->slug . '/service/timeslot') }}">
    <input type="hidden" id="slotlimiturl" value="{{ URL::to($vendordata->slug . '/service/slotlimit') }}">
    <input type="hidden" id="stafflimiturl" value="{{ URL::to($vendordata->slug . '/service/stafflimit') }}">
    <input type="hidden" id="booking_url" value="{{ URL::to($vendordata->slug . '/service/booking') }}">
    <input type="hidden" id="staff_name" value="">
    <input type="hidden" id="staff_id" value="">

    <input type="hidden" name="mercado_url" id="mercado_url"
        value="{{ URL::to($vendordata->slug) . '/mercadoorder' }}">

    <input type="hidden" name="mercado_successurl" id="mercado_successurl"
        value="{{ URL::to($vendordata->slug) . '/mercadoordersuccess' }}">

    <input type="hidden" name="paypal_url" id="paypal_url"
        value="{{ URL::to($vendordata->slug) . '/paypalrequest' }}">

    <form action="{{ URL::to($vendordata->slug) . '/paypalrequest' }}" method="post" class="d-none">
        {{ csrf_field() }}
        <input type="hidden" name="return" value="2">
        <input type="submit" class="callpaypal" name="submit">
    </form>

    <input type="hidden" name="myfatoorah_url" id="myfatoorah_url"
        value="{{ URL::to($vendordata->slug) . '/myfatoorahrequest' }}">

    <input type="hidden" name="toyyibpay_url" id="toyyibpay_url"
        value="{{ URL::to($vendordata->slug) . '/toyyibpayrequest' }}">

    <input type="hidden" name="paytab_url" id="paytab_url"
        value="{{ URL::to($vendordata->slug) . '/paytabrequest' }}">

    <input type="hidden" name="phonepe_url" id="phonepe_url"
        value="{{ URL::to($vendordata->slug) . '/phoneperequest' }}">

    <input type="hidden" name="mollie_url" id="mollie_url"
        value="{{ URL::to($vendordata->slug) . '/mollierequest' }}">

    <input type="hidden" name="khalti_url" id="khalti_url"
        value="{{ URL::to($vendordata->slug) . '/khaltirequest' }}">

    <input type="hidden" name="xendit_url" id="xendit_url"
        value="{{ URL::to($vendordata->slug) . '/xenditrequest' }}">
    <div class="extra-marginss"></div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            if ("{{ Session::has('discount_data') }}") {
                $('.discount_section').removeClass('d-none');
                $('#btnremove').removeClass('d-none');
                $('#btnapply').addClass('d-none');
                $('#selectPromocode').addClass('d-none');
            } else {
                $('.discount_section').addClass('d-none');
                $('#btnremove').addClass('d-none');
                $('#btnapply').removeClass('d-none');
                $('#selectPromocode').removeClass('d-none');
            }
        });

        function ApplyCoupon() {
            $('#btnapply').prop("disabled", true);
            $('#btnapply').html('<div class="load"></div>');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ URL::to('/service/apply') }}",
                method: 'POST',
                data: {
                    offer_code: $('#offer_code').val(),
                    price: $('#price').val(),
                    vendor_id: "{{ $vendordata->id }}",
                },
                success: function(response) {
                    $('#btnapply').html("{{ trans('labels.apply') }}");
                    $('#btnapply').prop("disabled", false);
                    if (response.status == 1) {
                        var total = parseFloat($('#price').val());
                        var tax = "{{ @$totaltax }}";
                        var discount = response.data.offer_amount;
                        var grandtotal = parseFloat(total) + parseFloat(tax) - parseFloat(discount);
                        $('.discount_section').removeClass('d-none');
                        $('#offer_amount').text('– ' + currency_formate(parseFloat(discount)));
                        $('#grand_total').text(currency_formate(parseFloat(grandtotal)));
                        $('#hidden_grand_total').val(grandtotal);
                        $('#discount_amount').val(discount);
                        $('#couponcode').val(response.data.offer_code);
                        $('#btnremove').removeClass('d-none');
                        $('#btnapply').addClass('d-none');
                        $('#selectPromocode').addClass('d-none');
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error(wrong);
                    $('#btnapply').html("{{ trans('labels.apply') }}");
                    $('#btnapply').prop("disabled", false);
                }
            });
        }

        function RemoveCoupon() {
            $('#btnremove').prop("disabled", true);
            $('#btnremove').html('<div class="load"></div>');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ URL::to('/service/remove') }}",
                method: 'POST',
                success: function(response) {
                    $('#btnremove').html("{{ trans('labels.remove') }}");
                    $('#btnremove').prop("disabled", false);
                    if (response.status == 1) {
                        var total = $('#price').val();
                        var tax = "{{ @$totaltax }}";
                        var discount = 0;
                        var grandtotal = parseFloat(total) + parseFloat(tax) - parseFloat(discount);
                        $('#offer_amount').text(currency_formate(parseFloat(0)));
                        $('#grand_total').text(currency_formate(parseFloat(grandtotal)));
                        $('#offer_code').val('');
                        $('#hidden_grand_total').val(grandtotal);
                        $('#discount_amount').val(discount);
                        $('#couponcode').val('');
                        $('#btnremove').addClass('d-none');
                        $('#btnapply').removeClass('d-none');
                        $('#selectPromocode').removeClass('d-none');
                        $('.discount_section').addClass('d-none');
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error(wrong);
                    $('#btnremove').html("{{ trans('labels.remove') }}");
                    $('#btnremove').prop("disabled", false);
                }
            });
        }

        var payment_options = "{{ helper::appdata($vendordata->id)->payment_process_options }}";

        $(document).ready(function() {
            if (payment_options == 1) {
                $(".payment_methods").show();
            }
            if (payment_options == 2) {
                $(".payment_methods").hide();
            }
            if (payment_options == 3) {
                $("input[name='payment_options']").click(function() {
                    var selection = $("input[name=payment_options]:checked").val();
                    if (selection == 1) {
                        $(".payment_methods").show();
                    }

                    if (selection == 2) {
                        $(".payment_methods").hide();
                    }
                });
            }
        });
        var sendbox = "{{ env('Environment') }}";
        var is_logedin = "{{ @Auth::user()->type == 3 ? 1 : 2 }}";
        var customer_login = "2";
        @if (@helper::checkaddons('customer_login'))
            customer_login = "1";
        @endif
        var login_required = "{{ helper::appdata($vendordata->id)->checkout_login_required }}";
        var is_checkout_login_required = "{{ helper::appdata($vendordata->id)->is_checkout_login_required }}";
        var name = "{{ @Auth::user()->name }}";
        var email = "{{ @Auth::user()->email }}";
        var store_close = "{{ trans('messages.store_closed') }}";
        var validatetime = "{{ trans('messages.select_time') }}";
        var select_date = "{{ trans('messages.select_date') }}";
        var bookingmessage = "{{ trans('messages.already_booked') }}";
        var staffrequired = "{{ trans('messages.staff_required') }}";
        var staff = "{{ $service->staff_assign }}";
        var loginurl = "{{ URL::to($vendordata->slug . '/login') }}";
        var mercado_url = $("#mercado_url").val();
        var mercado_successurl = $("#mercado_successurl").val();
        var paypal_url = $("#paypal_url").val();
        var myfatoorah_url = $("#myfatoorah_url").val();
        var toyyibpay_url = $("#toyyibpay_url").val();
        var paytab_url = $("#paytab_url").val();
        var phonepe_url = $("#phonepe_url").val();
        var mollie_url = $("#mollie_url").val();
        var khalti_url = $("#khalti_url").val();
        var xendit_url = $("#xendit_url").val();
        var bank_url = $("#bank_url").val();
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/calander/moment.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/calander/fullcalendar.min.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/service.js') }}"></script>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script> {{-- Razorpay --}}
    <script src="https://js.stripe.com/v3/"></script> {{-- Stripe --}}
    <script src="https://js.paystack.co/v1/inline.js"></script> {{--  Paystack --}}
    <script src="https://checkout.flutterwave.com/v3.js"></script> {{-- Flutterwave --}}
@endsection
