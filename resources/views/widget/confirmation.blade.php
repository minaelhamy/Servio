@extends('widget.layout.default')
@section('content')
    <!--==================================== Confirmation section end ====================================-->

    <div class="main">
        <div class="header">
            <span class="fw-bold active header-title">{{ trans('labels.select_confirmation') }}</span>
        </div>
        <div class="row main-specing">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h3 class="fs-5 m-0 mb-4 text-center">{{ trans('labels.confirm_booking') }}</h3>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5 class="fs-16 d-inline-block border-bottom border-1 border-dark pb-1">
                            {{ trans('labels.date_time') }}</h5>
                        <div class="d-flex">
                            <p class="text-muted date-time-text booking_date fs-7 mb-4">
                                {{ session()->get('embedded_date') }}</p>
                            <p class="text-muted date-time-text mx-2 booking_time fs-7 mb-4">
                                {{ session()->get('embedded_time') }}</p>
                        </div>
                        @if (session()->has('embedded_staffname'))
                            <h5 class="fs-16 d-inline-block border-bottom border-1 border-dark pb-1">
                                {{ trans('labels.staff') }}</h5>
                            <div class="d-flex">
                                <p class="text-muted date-time-text booking_date fs-7 mb-4">
                                    {{ session()->get('embedded_staffname') }}</p>
                            </div>
                        @endif

                        <h5 class="fs-16 d-inline-block border-bottom border-1 border-dark pb-1">
                            {{ trans('labels.booking_information') }}</h5>
                        <div class="d-flex">
                            <p class="fw-medium fs-7">{{ trans('labels.name') }} :</p>
                            <span class="mx-2 text-muted show_first_name">{{ session()->get('embedded_name') }}</span>
                        </div>
                        <div class="d-flex">
                            <p class="fw-medium fs-7">{{ trans('labels.email') }} :</p>
                            <span class="mx-2 text-muted show_email">{{ session()->get('embedded_email') }}</span>
                        </div>
                        <div class="d-flex">
                            <p class="fw-medium fs-7">{{ trans('labels.mobile') }} :</p>
                            <span class="mx-2 text-muted show_mobile">{{ session()->get('embedded_mobile') }}</span>
                        </div>
                        <div class="d-flex mb-2">
                            <p class="fw-medium fs-7 m-0">{{ trans('labels.address') }}&nbsp;:</p>
                            <span
                                class="text-muted text-align mx-2 show_address">{{ session()->get('embedded_address') }}</span>
                        </div>
                        <div class="d-flex">
                            <p class="fw-medium fs-7">{{ trans('labels.landmark') }} :</p>
                            <span class="mx-2 text-muted show_landmark">{{ session()->get('embedded_landmark') }}</span>
                        </div>
                        <div class="d-flex">
                            <p class="fw-medium fs-7">{{ trans('labels.postal_code') }} :</p>
                            <span
                                class="mx-2 text-muted show_postalcode">{{ session()->get('embedded_postalcode') }}</span>
                        </div>
                        <div class="d-flex">
                            <p class="fw-medium fs-7">{{ trans('labels.city') }} :</p>
                            <span class="mx-2 text-muted show_city">{{ session()->get('embedded_city') }}</span>
                        </div>
                        <div class="d-flex">
                            <p class="fw-medium fs-7">{{ trans('labels.state') }} :</p>
                            <span class="mx-2 text-muted show_state">{{ session()->get('embedded_state') }}</span>
                        </div>
                        <div class="d-flex">
                            <p class="fw-medium fs-7">{{ trans('labels.country') }} :</p>
                            <span class="mx-2 text-muted show_country">{{ session()->get('embedded_country') }}</span>
                        </div>
                        <div class="d-flex">
                            <p class="fw-medium fs-7 m-0">{{ trans('labels.message') }}&nbsp;:</p>
                            <span
                                class="text-muted text-align mx-2 show_message">{{ session()->get('embedded_message') == '' ? '-' : session()->get('embedded_message') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 ">
                <h3 class="fs-5 m-0 mb-4 text-center">{{ trans('labels.payment_summary') }}</h3>
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex fw-medium justify-content-between px-0 fs-7">
                                {{ trans('labels.subtotal') }}
                                <span
                                    class="fw-bold">{{ helper::currency_formate((float) session()->get('embedded_price'), $vendordata->id) }}</span>
                            </li>
                            @php
                                $taxlist = helper::gettax($service->tax);
                                $newtax = [];
                                $tax_name = [];
                                $totaltax = 0;
                            @endphp
                            @if ($service->tax != null && $service->tax != '')
                                @foreach ($taxlist as $tax)
                                    <li class="list-group-item d-flex fw-medium justify-content-between px-0 fs-7">

                                        {{ $tax->name }}
                                        <span class="fw-bold">
                                            {{ $tax->type == 1 ? helper::currency_formate($tax->tax, $vendordata->id) : helper::currency_formate($service->price * ($tax->tax / 100), $vendordata->id) }}
                                        </span>
                                        @php
                                            if ($tax->type == 1) {
                                                $newtax[] = $tax->tax;
                                            } else {
                                                $newtax[] = $service->price * ($tax->tax / 100);
                                            }
                                            $tax_name[] = $tax->name;
                                            session()->put('embedded_tax', implode('|', $newtax));
                                            session()->put('embedded_taxname', implode('|', $tax_name));
                                        @endphp
                                    </li>
                                @endforeach
                                @foreach ($newtax as $item)
                                    @php
                                        $totaltax += (float) $item;
                                        session()->put('embedded_totaltax', $totaltax);
                                    @endphp
                                @endforeach
                            @endif

                            {{-- <li class="list-group-item d-flex fw-medium justify-content-between px-0 fs-7">
                                {{ trans('labels.tax') }}(%)<span
                                    class="fw-bold">{{ helper::currency_formate((float)session()->get('embedded_tax'), $vendordata->id) }}</span>
                            </li> --}}
                            <li class="list-group-item d-flex fw-medium justify-content-between px-0 fs-7 text-success">
                                {{ trans('labels.grand_total') }}
                                @php
                                    $grand_total = (float) session()->get('embedded_price') + (float) $totaltax;
                                @endphp
                                <span id="grand_total"
                                    class="fw-bold">{{ helper::currency_formate((float) $grand_total, $vendordata->id) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==================================== Confirmation section end ====================================-->
    <!--================================== footer section start ====================================-->
    <div class="footer">
        {{-- <div class="d-flex justify-content-between"> --}}
            <a href="{{ URL::to('/' . $vendordata->slug . '/embedded/information') }}"
                class="btn btn-outline-primary px-4 back_button">{{ trans('labels.back') }}</a>
            <a href="{{ URL::to('/' . $vendordata->slug . '/embedded/success') }}"
                class="btn btn-secondary px-4 next_button">{{ trans('labels.book_now') }}</a>
        {{-- </div> --}}
    </div>
    <!--==================================== footer section end ====================================-->
@endsection
