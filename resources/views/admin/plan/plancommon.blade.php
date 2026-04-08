<div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6 col-sm-6" data-id="{{ $plandata->id }}">
    @php
        if (Auth::user()->type == 4 && Auth::user()->vendor_id != 1) {
            $plan = helper::getplantransaction(Auth::user()->vendor_id);
            $plan_id = $plan->plan_id;
        } else {
            $plan_id = Auth::user()->plan_id;
        }
    @endphp
    <div class="card border-0 box-shadow h-100 {{ $plan_id == $plandata->id ? 'plan-card-active' : 'border-0' }} handle">
        <div class="card-header bg-secondary sub-plan">
            <div class="d-flex justify-content-between color-changer">
                <h5 class="text-dark color-changer">{{ $plandata->name }}</h5>
                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                    <a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right"></i></a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3 mt-0">
                <h5 class="mb-1 text-dark color-changer">{{ helper::currency_formate($plandata->price, '') }}
                    <span class="fs-7 text-muted">/
                        @if ($plandata->plan_type == 1)
                            @if ($plandata->duration == 1)
                                {{ trans('labels.one_month') }}
                            @elseif($plandata->duration == 2)
                                {{ trans('labels.three_month') }}
                            @elseif($plandata->duration == 3)
                                {{ trans('labels.six_month') }}
                            @elseif($plandata->duration == 4)
                                {{ trans('labels.one_year') }}
                            @elseif($plandata->duration == 5)
                                {{ trans('labels.lifetime') }}
                            @endif
                        @endif
                        @if ($plandata->plan_type == 2)
                            {{ $plandata->days }}
                            {{ $plandata->days > 1 ? trans('labels.days') : trans('labels.day') }}
                        @endif

                    </span>
                </h5>
                @if ($plandata->tax != null && $plandata->tax != '')
                    <small class="text-danger">{{ trans('labels.exclusive_all_taxes') }}</small><br>
                @else
                    <small class="text-success">{{ trans('labels.inclusive_taxes') }}</small> <br>
                @endif
                <small class="text-muted text-center">{{ Str::limit($plandata->description, 150) }}</small>
            </div>
            <ul class="fs-7">
                @php $features = ($plandata->features == null ? null : explode('|', $plandata->features));@endphp

                <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                    <span class="mx-2 color-changer">
                        {{ $plandata->order_limit == -1 ? trans('labels.unlimited') : $plandata->order_limit }}
                        {{ $plandata->order_limit > 1 || $plandata->order_limit == -1 ? trans('labels.products') : trans('labels.product') }}
                    </span>
                </li>
                <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                    <span class="mx-2 color-changer">
                        {{ $plandata->appointment_limit == -1 ? trans('labels.unlimited') : $plandata->appointment_limit }}
                        {{ $plandata->appointment_limit > 1 || $plandata->appointment_limit == -1 ? trans('labels.orders') : trans('labels.order') }}
                    </span>
                </li>
                @if (@helper::checkaddons('product_shop'))
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">
                            {{ $plandata->product_order_limit == -1 ? trans('labels.unlimited') : $plandata->product_order_limit }}
                            {{ $plandata->product_order_limit > 1 || $plandata->product_order_limit == -1 ? trans('labels.product_s') : trans('labels.product_') }}
                        </span>
                    </li>
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">
                            {{ $plandata->order_appointment_limit == -1 ? trans('labels.unlimited') : $plandata->order_appointment_limit }}
                            {{ $plandata->order_appointment_limit > 1 || $plandata->order_appointment_limit == -1 ? trans('labels.order_s') : trans('labels.order_') }}
                        </span>
                    </li>
                @endif
                @php
                    $themes = [];
                    if ($plandata->themes_id != '' && $plandata->themes_id != null) {
                        $themes = explode('|', $plandata->themes_id);
                } @endphp
                <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                    <span class="mx-2 color-changer">{{ count($themes) }}
                        {{ count($themes) > 1 ? trans('labels.themes') : trans('labels.theme') }}
                        @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                            <a onclick="themeinfo('{{ $plandata->id }}','{{ $plandata->themes_id }}','{{ $plandata->name }}')"
                                tooltip="{{ trans('labels.info') }}" class="cursor-pointer color-changer"> <i
                                    class="fa-regular fa-circle-info"></i> </a>
                        @endif
                    </span>
                </li>
                @if ($plandata->coupons == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.coupons') }}</span>
                    </li>
                @endif
                @if ($plandata->custom_domain == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.custome_domain_available') }}</span>
                    </li>
                @endif
                @if ($plandata->google_analytics == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.google_analytics_available') }}</span>
                    </li>
                @endif
                @if ($plandata->blogs == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.blogs') }}</span>
                    </li>
                @endif
                @if ($plandata->google_login == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.google_login') }}</span>
                    </li>
                @endif
                @if ($plandata->facebook_login == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.facebook_login') }}</span>
                    </li>
                @endif
                @if ($plandata->sound_notification == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.sound_notification') }}</span>
                    </li>
                @endif
                @if ($plandata->whatsapp_message == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.whatsapp_message') }}</span>
                    </li>
                @endif
                @if ($plandata->telegram_message == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.telegram_message') }}</span>
                    </li>
                @endif
                @if ($plandata->vendor_app == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.vendor_app_available') }}</span>
                    </li>
                @endif
                @if ($plandata->customer_app == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.customer_app') }}</span>
                    </li>
                @endif
                @if ($plandata->pwa == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.pwa') }}</span>
                    </li>
                @endif
                @if ($plandata->employee == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.role_management') }}</span>
                    </li>
                @endif
                @if ($plandata->zoom == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.zoom_meeting_available') }}</span>
                    </li>
                @endif
                @if ($plandata->calendar == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.google_calendar_available') }}</span>
                    </li>
                @endif
                @if ($plandata->vendor_calendar == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.vendor_calendar') }}</span>
                    </li>
                @endif
                @if ($plandata->pixel == 1)
                    <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                        <span class="mx-2 color-changer">{{ trans('labels.pixel') }}</span>
                    </li>
                @endif

                @if ($features != null)
                    @foreach ($features as $feature)
                        <li class="mb-2 d-flex"> <i class="fa-regular fa-circle-check text-secondary "></i>
                            <span class="mx-2 color-changer"> {{ $feature }} </span>
                        </li>
                    @endforeach
                @endif
            </ul>

        </div>
        <div class="card-footer bg-transparent border-top-0 pb-3 pt-0 text-center">
            @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    @if ($plandata->is_available == 1)
                        <a tooltip="{{ trans('labels.active') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/plan/status_change-' . $plandata->id . '/2') }}')" @endif
                            class="btn btn-success hov btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_pricing_plan', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"><i
                                class="fas fa-check"></i></a>
                    @elseif ($plandata->is_available == 2)
                        <a tooltip="{{ trans('labels.inactive') }}"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/plan/status_change-' . $plandata->id . '/1') }}')" @endif
                            class="btn btn-danger hov btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_pricing_plan', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"><i
                                class="fas fa-close"></i></a>
                    @endif
                    <a href="{{ URL::to('admin/plan/edit-' . $plandata->id) }}"
                        class="btn btn-info hov btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_pricing_plan', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                        tooltip="{{ trans('labels.edit') }}"> <i class="fa-regular fa-pen-to-square"></i> </a>
                    <a href="javascript:void(0)"
                        class="btn btn-danger hov btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_pricing_plan', Auth::user()->role_id, $vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}"
                        @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/plan/delete-' . $plandata->id) }}')" @endif
                        tooltip="{{ trans('labels.delete') }}">
                        <i class="fa-regular fa-trash"></i></a>
                </div>
            @else
                @php
                    if (Auth::user()->type == 4 && Auth::user()->vendor_id != 1) {
                        $plan = helper::getplantransaction(Auth::user()->vendor_id);
                        $plan_id = $plan->plan_id;
                        $purchase_amount = $plan->amount;
                    } else {
                        $plan_id = Auth::user()->plan_id;
                        $purchase_amount = Auth::user()->purchase_amount;
                    }
                    $check_vendorplan = helper::checkplan($vendor_id, '');
                    $data = json_decode(json_encode($check_vendorplan), true);
                @endphp
                @if ($plan_id == $plandata->id)
                    @if (@$data['original']['status'] == '2')
                        @if ($plandata->price > 0)
                            @if (@$plandata->duration == 5)
                                <small
                                    class="text-success d-block"><span>{{ @$data['original']['plan_message'] }}</span></small>
                            @else
                                @if (@$data['original']['plan_date'] > date('Y-m-d'))
                                    <small class="text-dark d-block">{{ @$data['original']['plan_message'] }}
                                        : <span
                                            class="text-success">{{ $data['original']['plan_date'] != '' ? helper::date_formate($data['original']['plan_date'], $vendor_id) : '' }}</span></small>
                                @else
                                    <small class="text-dark d-block">{{ @$data['original']['plan_message'] }}
                                        : <span
                                            class="text-danger">{{ $data['original']['plan_date'] != '' ? helper::date_formate($data['original']['plan_date'], $vendor_id) : '' }}</span></small>
                                @endif
                            @endif

                            @if (@$data['original']['showclick'] == 1)
                                <a href="{{ URL::to('admin/plan/selectplan-' . $plandata->id) }}"
                                    class="btn btn-sm btn-primary d-block mt-2 {{ Auth::user()->type == 4 ? (helper::check_access('role_pricing_plan', Auth::user()->role_id, $vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.subscribe') }}</a>
                            @endif
                        @else
                            @if (@$data['original']['plan_date'] > date('Y-m-d'))
                                <small class="text-dark d-block">{{ @$data['original']['plan_message'] }}
                                    <span class="text-success">
                                        {{ $data['original']['plan_date'] != '' ? helper::date_formate($data['original']['plan_date'], $vendor_id) : '' }}
                                    </span>
                                </small>
                                <a href="{{ URL::to('admin/plan/selectplan-' . $plandata->id) }}"
                                    class="btn btn-sm btn-primary d-block {{ Auth::user()->type == 4 ? (helper::check_access('role_pricing_plan', Auth::user()->role_id, $vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.subscribe') }}</a>
                            @else
                                <small class="text-dark d-block">{{ @$data['original']['plan_message'] }}
                                    <span class="text-danger">
                                        {{ $data['original']['plan_date'] != '' ? helper::date_formate($data['original']['plan_date'], $vendor_id) : '' }}</span>
                                </small>
                                <a href="{{ URL::to('admin/plan/selectplan-' . $plandata->id) }}"
                                    class="btn btn-sm btn-primary d-block {{ Auth::user()->type == 4 ? (helper::check_access('role_pricing_plan', Auth::user()->role_id, $vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.subscribe') }}</a>
                            @endif
                        @endif
                    @elseif(@$data['original']['status'] == '1')
                        @if (@$plandata->duration == 5)
                            <small class="text-dark color-changer"><span>
                                    {{ @$data['original']['plan_message'] }}
                                </span></small>
                        @else
                            @if ($data['original']['plan_date'] != '')
                                <small class="text-dark color-changer">
                                    {{ @$data['original']['plan_message'] }}: <span
                                        class="text-success">{{ $data['original']['plan_date'] != '' ? helper::date_formate($data['original']['plan_date'], $vendor_id) : '' }}</span>
                                </small>
                                <a href="{{ URL::to('admin/plan/selectplan-' . $plandata->id) }}"
                                    class="btn btn-sm btn-primary d-block mt-1 py-2 {{ Auth::user()->type == 4 ? (helper::check_access('role_pricing_plan', Auth::user()->role_id, $vendor_id, 'manage') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.subscribe') }}</a>
                            @else
                                <small class="text-success">{{ @$data['original']['plan_message'] }}</small>
                                <a href="{{ URL::to('admin/plan/selectplan-' . $plandata->id) }}"
                                    class="btn btn-sm btn-primary d-block mt-1 py-2 {{ Auth::user()->type == 4 ? (helper::check_access('role_pricing_plan', Auth::user()->role_id, $vendor_id, 'manage') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.subscribe') }}</a>
                            @endif
                        @endif
                    @else
                        -
                    @endif
                @else
                    @if ($plandata->price > 0)
                        <a href="{{ URL::to('admin/plan/selectplan-' . $plandata->id) }}"
                            class="btn btn-sm btn-primary d-block py-2 {{ Auth::user()->type == 4 ? (helper::check_access('role_pricing_plan', Auth::user()->role_id, $vendor_id, 'manage') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.subscribe') }}</a>
                    @elseif ((float) $purchase_amount > $plandata->price)
                    @else
                        <a href="{{ URL::to('admin/plan/selectplan-' . $plandata->id) }}"
                            class="btn btn-sm btn-primary d-block py-2 {{ Auth::user()->type == 4 ? (helper::check_access('role_pricing_plan', Auth::user()->role_id, $vendor_id, 'manage') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.subscribe') }}</a>
                    @endif
                @endif
            @endif
        </div>
    </div>
</div>
