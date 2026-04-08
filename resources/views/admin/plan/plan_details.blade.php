@extends('admin.layout.default')
@php
    if (Auth::user()->type == 4) {
        $vendor_id = Auth::user()->vendor_id;
    } else {
        $vendor_id = Auth::user()->id;
    }
@endphp
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-capitalize color-changer fw-600 fs-4">{{ trans('labels.plan_details') }}</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb m-0">
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/transaction') }}" class="color-changer">{{ trans('labels.transaction') }}</a>
                </li>
                <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-rtl' : '' }}"
                    aria-current="page">{{ trans('labels.plan_details') }}</li>
            </ol>
        </nav>
    </div>
    <div class="row pb-3 g-3">
        <div class="col-md-4 col-sm-6">
            <div class="card border-0 box-shadow">
                <div class="card-header bg-secondary p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="text-dark">{{ $plan->plan_name }}</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h5 class="mb-1 text-dark color-changer">{{ helper::currency_formate($plan->amount, '') }}
                            <span class="fs-7 text-muted">/
                                @if ($plan->duration != null || $plan->duration != '')
                                    @if ($plan->duration == 1)
                                        {{ trans('labels.one_month') }}
                                    @elseif($plan->duration == 2)
                                        {{ trans('labels.three_month') }}
                                    @elseif($plan->duration == 3)
                                        {{ trans('labels.six_month') }}
                                    @elseif($plan->duration == 4)
                                        {{ trans('labels.one_year') }}
                                    @elseif($plan->duration == 5)
                                        {{ trans('labels.lifetime') }}
                                    @endif
                                @else
                                    {{ $plan->days }}
                                    {{ $plan->days > 1 ? trans('labels.days') : trans('labels.day') }}
                                @endif
                            </span>
                        </h5>
                        @if ($plan->tax != null && $plan->tax != '')
                            <small class="text-danger">{{ trans('labels.exclusive_all_taxes') }}</small><br>
                        @else
                            <small class="text-success">{{ trans('labels.inclusive_taxes') }}</small> <br>
                        @endif
                        <small class="text-muted text-center">{{ $plan->description }}</small>
                    </div>
                    <ul class="pb-5 fs-7">
                        @php $features = explode('|', $plan->features); @endphp
                        <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                            <span class="mx-2 color-changer">
                                {{ $plan->service_limit == -1 ? trans('labels.unlimited') : $plan->service_limit }}
                                {{ $plan->service_limit > 1 || $plan->service_limit == -1 ? trans('labels.products') : trans('labels.product') }}
                            </span>
                        </li>
                        <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                            <span class="mx-2 color-changer">
                                {{ $plan->appoinment_limit == -1 ? trans('labels.unlimited') : $plan->appoinment_limit }}
                                {{ $plan->appoinment_limit > 1 || $plan->appoinment_limit == -1 ? trans('labels.orders') : trans('labels.order') }}
                            </span>
                        </li>
                        @if (@helper::checkaddons('product_shop'))
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">
                                    {{ $plan->product_limit == -1 ? trans('labels.unlimited') : $plan->product_limit }}
                                    {{ $plan->product_limit > 1 || $plan->product_limit == -1 ? trans('labels.product_s') : trans('labels.product_') }}
                                </span>
                            </li>
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">
                                    {{ $plan->order_appointment_limit == -1 ? trans('labels.unlimited') : $plan->order_appointment_limit }}
                                    {{ $plan->order_appointment_limit > 1 || $plan->order_appointment_limit == -1 ? trans('labels.order_s') : trans('labels.order_') }}
                                </span>
                            </li>
                        @endif
                        @php
                            $themes = [];
                            if ($plan->themes_id != '' && $plan->themes_id != null) {
                                $themes = explode('|', $plan->themes_id);
                        } @endphp
                        <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                            <span class="mx-2 color-changer">{{ count($themes) }}
                                {{ count($themes) > 1 ? trans('labels.themes') : trans('labels.theme') }} @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    <a onclick="themeinfo('{{ $plan->id }}','{{ $plan->themes_id }}','{{ $plan->plan_name }}')"
                                        tooltip="{{ trans('labels.info') }}" class="cursor-pointer">
                                        <i class="fa-regular fa-circle-info"></i>
                                    </a>
                                @endif
                            </span>
                        </li>
                        @if ($plan->coupons == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.coupons') }}</span>
                            </li>
                        @endif
                        @if ($plan->custom_domain == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.custome_domain_available') }}</span>
                            </li>
                        @endif
                        @if ($plan->google_analytics == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.google_analytics_available') }}</span>
                            </li>
                        @endif
                        @if ($plan->blogs == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.blogs') }}</span>
                            </li>
                        @endif
                        @if ($plan->google_login == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.google_login') }}</span>
                            </li>
                        @endif
                        @if ($plan->facebook_login == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.facebook_login') }}</span>
                            </li>
                        @endif
                        @if ($plan->sound_notification == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.sound_notification') }}</span>
                            </li>
                        @endif
                        @if ($plan->whatsapp_message == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.whatsapp_message') }}</span>
                            </li>
                        @endif
                        @if ($plan->telegram_message == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.telegram_message') }}</span>
                            </li>
                        @endif
                        @if ($plan->vendor_app == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.vendor_app_available') }}</span>
                            </li>
                        @endif
                        @if ($plan->customer_app == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.customer_app') }}</span>
                            </li>
                        @endif
                        @if ($plan->pwa == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.pwa') }}</span>
                            </li>
                        @endif
                        @if ($plan->employee == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.role_management') }}</span>
                            </li>
                        @endif
                        @if ($plan->zoom == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.zoom_meeting_available') }}</span>
                            </li>
                        @endif
                        @if ($plan->calendar == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.google_calendar_available') }}</span>
                            </li>
                        @endif
                        @if ($plan->vendor_calendar == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.vendor_calendar') }}</span>
                            </li>
                        @endif
                        @if ($plan->pixel == 1)
                            <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                <span class="mx-2 color-changer">{{ trans('labels.pixel') }}</span>
                            </li>
                        @endif
                        @foreach ($features as $feature)
                            @if ($feature != '' && $feature != null)
                                <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                                    <span class="mx-2 color-changer"> {{ $feature }} </span>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-6 payments">
            <div class="card border-0 box-shadow">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="card-title mb-0 color-changer">{{ trans('labels.plan_information') }}</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between border-bottom">
                            <p class="fw-500 text-dark fs-15 color-changer">{{ trans('labels.payment_type') }}</p>
                            <p class="fw-600 fs-15 text-muted">
                                @if ($plan->amount == 0)
                                    -
                                @else
                                    {{ @helper::getpayment($plan->payment_type, $vendor_id)->payment_name }}
                                    @if ($plan->payment_type == 6)
                                        <small><a href="{{ helper::image_path($plan->screenshot) }}" target="_blank"
                                                class="text-danger">{{ trans('labels.click_here') }}</a></small>
                                    @else
                                        {{ $plan->payment_id }}
                                    @endif
                                @endif
                            </p>
                        </li>
                        <li class="list-group-item d-flex justify-content-between border-bottom-2">
                            <p class="fw-500 fs-15 text-dark color-changer">{{ trans('labels.purchase_date') }}</p>
                            <p class="fw-600 fs-15 text-muted">{{ helper::date_formate($plan->purchase_date, $vendor_id) }}</p>
                        </li>
                        <li class="list-group-item d-flex justify-content-between border-bottom-2">
                            <p class="fw-500 fs-15 text-dark color-changer">{{ trans('labels.expiry_date') }}</p>
                            <p class="fw-600 fs-15 text-muted">
                                {{ $plan->expire_date != '' ? helper::date_formate($plan->expire_date, $vendor_id) : '-' }}
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card border-0 box-shadow mt-3">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="card-title mb-0 color-changer">{{ trans('labels.Payment_information') }}</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between border-bottom">
                            <p class="fw-500 fs-15 text-dark color-changer">{{ trans('labels.sub_total') }}</p>
                            <p class="fw-600 fs-15 text-muted">{{ helper::currency_formate($plan->amount, '') }}</p>
                        </li>
                        @if ($plan->amount != 0)
                            @if ($plan->tax != null && $plan->tax != '')
                                @php
                                    $tax = explode('|', $plan->tax);
                                    $tax_name = explode('|', $plan->tax_name);
                                @endphp
                                @foreach ($tax as $key => $tax_value)
                                    @if ($tax_value != 0)
                                        <li class="list-group-item d-flex justify-content-between border-bottom-2">
                                            <p class="fw-500 fs-15 text-dark color-changer">{{ $tax_name[$key] }}</p>
                                            <p class="fw-600 fs-15 text-muted">{{ helper::currency_formate(@$tax[$key], '') }}
                                            </p>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endif
                        @if ($plan->offer_code != null && $plan->offer_amount != null)
                            <li class="list-group-item d-flex justify-content-between border-bottom-2">
                                <p class="fw-500 fs-15 text-dark color-changer">{{ trans('labels.discount') }}
                                    ({{ $plan->offer_code }})</p>
                                <p class="fw-600 fs-15 text-muted">-{{ helper::currency_formate($plan->offer_amount, '') }}</p>
                            </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between">
                            <p class="fw-600 fs-16 text-dark color-changer">{{ trans('labels.grand_total') }}</p>
                            <p class="fw-600 fs-16 text-dark color-changer">
                                {{ helper::currency_formate($plan->grand_total, '') }}
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function themeinfo(id, theme_id, plan_name) {
            let string = theme_id;
            let arr = string.split('|');
            $('#themeinfoLabel').text(plan_name);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: "{{ URL::to('admin/themeimages') }}",
                method: 'GET',
                data: {
                    theme_id: arr
                },
                dataType: 'json',
                success: function(data) {
                    $('#theme_modalbody').html(data.output);
                    $('#themeinfo').modal('show');
                }
            })
        }
    </script>
@endsection
