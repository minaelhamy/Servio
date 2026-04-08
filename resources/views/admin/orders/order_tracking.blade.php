@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $user = App\Models\User::where('id', $vendor_id)->first();
        $module = 'role_orders';
    @endphp
    <div class="row">
        <div class="col-md-12 my-2 d-flex flex-wrap align-items-center gap-2 justify-content-end">
            @if (@helper::checkaddons('custom_status'))
                @php
                    if ($getorderdata->status_type == 3) {
                        $color = 'success';
                    } elseif ($getorderdata->status_type == 4) {
                        $color = 'danger';
                    }
                @endphp
                @if ($getorderdata->status_type == 3 || $getorderdata->status_type == 4)
                    <label
                        class="text-{{ $color }}">{{ @helper::gettype($getorderdata->status, $getorderdata->status_type, $vendor_id, 2)->name == null ? '-' : @helper::gettype($getorderdata->status, $getorderdata->status_type, $vendor_id, 2)->name }}</label>
                @else
                    <div class="lag-btn2">
                        <button type="button"
                            class="btn btn-sm btn-primary px-sm-4 col-sm-auto col-12 rounded {{ Auth::user()->type == 4 ? (helper::check_access('role_orders', Auth::user()->role_id, $vendor_id, 'manage') == 1 ? '' : 'd-none') : '' }} {{ session()->get('direction') == 2 ? 'dropdown-toggle-rtl' : 'dropdown-toggle-ltr' }}"
                            data-bs-toggle="dropdown"
                            {{ Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1) ? 'disabled' : '' }}>{{ @helper::gettype($getorderdata->status, $getorderdata->status_type, $vendor_id, 2)->name == null ? '-' : @helper::gettype($getorderdata->status, $getorderdata->status_type, $vendor_id, 2)->name }}
                        </button>
                        <div
                            class="dropdown-menu bg-body-secondary p-0 border-0 shadow {{ Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1) ? 'disabled' : '' }}">
                            @foreach (helper::customstauts($getorderdata->vendor_id, 2) as $status)
                                <a class="dropdown-item w-auto dropdown-item d-flex align-items-center p-2 {{ $getorderdata->status == $status->id ? 'fw-600' : '' }} cursor-pointer"
                                    onclick="statusupdate('{{ URL::to('admin/orders/status_change-' . $getorderdata->order_number . '/' . $status->id . '/' . $status->type) }}')">
                                    {{ $status->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
            <a href="{{ URL::to('admin/orders/print/' . $getorderdata->order_number) }}"
                class="btn btn-secondary header-btn-icon" tooltip="Print">
                <i class="fa-solid fa-print"></i>
            </a>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row row-cols-xxl-4 row-cols-xl-3 row-cols-lg-2 row-cols-md-2 row-cols-sm-2 row-cols-1 g-3 pt-2">
            <div class="col">
                <div class="card box-shadow border-0 mb-3 h-100 d-flex">
                    <div
                        class="card-header border-bottom d-flex align-items-center bg-transparent text-dark py-3 justify-content-between">
                        <h6 class="px-2 fw-500 text-dark color-changer">
                            <i class="fa-solid fa-clipboard fs-5"></i>
                            {{ trans('labels.order_detail') }}
                        </h6>
                    </div>
                    <div class="card-body">

                        <div class="basic-list-group">
                            <ul class="list-group list-group-flush justify-content-between">
                                <li
                                    class="list-group-item px-0 fs-7 flex-wrap fw-500 d-flex justify-content-between align-items-center">
                                    <p class="color-changer">{{ trans('labels.order_num') }}</p>
                                    <p class="text-dark color-changer fw-600">{{ $getorderdata->order_number }}</p>
                                </li>
                                <li class="list-group-item px-0 fs-7 flex-wrap fw-500 d-flex justify-content-between">
                                    <p class="color-changer">{{ trans('labels.orders_date') }}</p>
                                    <p class="text-muted">{{ helper::date_formate($getorderdata->created_at, $vendor_id) }}
                                    </p>
                                </li>
                                <li class="list-group-item px-0 fs-7 flex-wrap fw-500 d-flex justify-content-between">
                                    <p class="color-changer">{{ trans('labels.payment_type') }}</p>
                                    <span class="text-muted">
                                        {{ @helper::getpayment($getorderdata->transaction_type, $getorderdata->vendor_id)->payment_name }}
                                        @if ($getorderdata->transaction_type == 6)
                                            : <small>
                                                <a href="{{ helper::image_path($getorderdata->screenshot) }}"
                                                    target="_blank" class="text-danger">{{ trans('labels.click_here') }}
                                                </a>
                                            </small>
                                        @endif
                                    </span>
                                </li>
                                @if (@helper::checkaddons('vendor_tip'))
                                    @if (@helper::otherappdata($vendor_id)->tips_on_off == 1)
                                        <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                            <p class="color-changer">{{ trans('labels.tips_pro') }}</p>
                                            <p class="text-muted">
                                                {{ helper::currency_formate($getorderdata->tips, $vendor_id) }}
                                            </p>
                                        </li>
                                    @endif
                                @endif
                                @if (in_array($getorderdata->transaction_type, [2, 3, 4, 5, 7, 8, 9, 10, 11, 12, 13, 14, 15]))
                                    <li class="list-group-item px-0 fs-7 fw-500 d-flex flex-wrap justify-content-between">
                                        <p class="color-changer">{{ trans('labels.transaction_id') }}</p>
                                        <p class="text-muted">
                                            {{ $getorderdata->transaction_id }}
                                        </p>
                                    </li>
                                @endif
                                @if ($getorderdata->notes != '')
                                    <li class="list-group-item px-0 fs-7 fw-500">
                                        <p class="color-changer">{{ trans('labels.notes') }}</p>
                                        <p class="text-muted">
                                            {{ $getorderdata->notes }}
                                        </p>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card box-shadow border-0 mb-3 h-100 d-flex">
                    <div
                        class="card-header border-bottom d-flex align-items-center bg-transparent text-dark py-3 justify-content-between">
                        <h6 class="px-2 fw-500 text-dark color-changer"><i class="fa-solid fa-user fs-5"></i>
                            {{ trans('labels.customer_info') }}
                        </h6>
                        <p class="text-muted cursor-pointer"
                            onclick="editcustomerdata('{{ $getorderdata->order_number }}','{{ $getorderdata->user_name }}','{{ $getorderdata->user_mobile }}','{{ $getorderdata->user_email }}','{{ str_replace(',', '|', $getorderdata->address) }}','{{ str_replace(',', '|', $getorderdata->city) }}','{{ str_replace(',', '|', $getorderdata->state) }}','{{ str_replace(',', '|', $getorderdata->country) }}','{{ str_replace(',', '|', $getorderdata->landmark) }}','{{ $getorderdata->postal_code }}','customer_info')">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <div class="row">
                                <div class="basic-list-group">
                                    <ul class="list-group list-group-flush justify-content-between">

                                        <li
                                            class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between align-items-center">
                                            <p class="color-changer">{{ trans('labels.name') }}</p>
                                            <p class="text-muted">{{ $getorderdata->user_name }}</p>
                                        </li>

                                        <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                            <p class="color-changer">{{ trans('labels.email') }}</p>
                                            <p class="text-muted">{{ $getorderdata->user_email }}</p>
                                        </li>

                                        <li class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between">
                                            <p class="color-changer">{{ trans('labels.mobile') }}</p>
                                            <p class="text-muted">{{ $getorderdata->user_mobile }}</p>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card box-shadow border-0 mb-3 h-100 d-flex">

                    <div
                        class="card-header border-bottom d-flex align-items-center bg-transparent text-dark py-3 justify-content-between">
                        <h6 class="px-2 fw-500 text-dark color-changer"><i class="fa-solid fa-file-invoice fs-5"></i>
                            {{ trans('labels.billing_address') }}
                        </h6>
                        <p class="text-muted cursor-pointer"
                            onclick="editcustomerdata('{{ $getorderdata->order_number }}','{{ $getorderdata->user_name }}','{{ $getorderdata->user_mobile }}','{{ $getorderdata->user_email }}','{{ str_replace(',', '|', $getorderdata->address) }}','{{ str_replace(',', '|', $getorderdata->city) }}','{{ str_replace(',', '|', $getorderdata->state) }}','{{ str_replace(',', '|', $getorderdata->country) }}','{{ str_replace(',', '|', $getorderdata->landmark) }}','{{ $getorderdata->postal_code }}','delivery_info')">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <div class="basic-list-group">
                                        <ul class="list-group list-group-flush justify-content-between">
                                            <li
                                                class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between flex-wrap align-items-center">
                                                <p class="color-changer">{{ trans('labels.address') }}</p>
                                                <p class="text-muted">{{ $getorderdata->address }}</p>
                                            </li>
                                            <li
                                                class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between flex-wrap">
                                                <p class="color-changer">{{ trans('labels.landmark') }}</p>
                                                <p class="text-muted">{{ $getorderdata->landmark }}</p>
                                            </li>
                                            <li
                                                class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between flex-wrap">
                                                <p class="color-changer">{{ trans('labels.postalcode') }}</p>
                                                <p class="text-muted">{{ $getorderdata->postal_code }}</p>
                                            </li>
                                            <li
                                                class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between flex-wrap">
                                                <p class="color-changer">{{ trans('labels.city') }}</p>
                                                <p class="text-muted">{{ $getorderdata->city }}</p>
                                            </li>
                                            <li
                                                class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between flex-wrap">
                                                <p class="color-changer">{{ trans('labels.state') }}</p>
                                                <p class="text-muted">{{ $getorderdata->state }}</p>
                                            </li>
                                            <li
                                                class="list-group-item px-0 fs-7 fw-500 d-flex justify-content-between flex-wrap">
                                                <p class="color-changer">{{ trans('labels.country') }}</p>
                                                <p class="text-muted">{{ $getorderdata->country }}</p>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card box-shadow border-0 mb-3 h-100 d-flex">
                    <div
                        class="card-header d-flex border-bottom align-items-center bg-transparent text-dark py-3 justify-content-between">
                        <h6 class="px-2 fw-500 text-dark color-changer"><i class="fa-solid fa-clipboard fs-5"></i>
                            {{ trans('labels.notes') }}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="basic-list-group">
                            <div class="row">
                                <div class="basic-list-group">
                                    @if ($getorderdata->vendor_note != '')
                                        <div class="alert alert-info" role="alert">
                                            {{ $getorderdata->vendor_note }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top">
                        <form action="{{ URL::to('admin/orders/vendor_note') }}" method="POST">
                            @csrf
                            <div class="form-group col-md-12">
                                <label for="note">{{ trans('labels.notes') }}</label>
                                <div class="controls">
                                    <input type="hidden" name="order_number" value="{{ $getorderdata->order_number }}">
                                    <input type="text" name="vendor_note" class="form-control" required="">
                                </div>
                            </div>
                            <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                                <button
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" type="submit" @endif
                                    class="btn btn-primary">{{ trans('labels.update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 my-3 box-shadow">
                <div
                    class="card-header color-changer border-bottom d-flex align-items-center bg-transparent text-dark py-3">
                    <i class="fa-solid fa-bag-shopping fs-5"></i>
                    <h6 class="px-2 fw-500 text-dark color-changer">{{ trans('labels.order_s') }}</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive p-0">
                        <table class="table m-0">
                            <thead>
                                <tr class="text-capitalize fs-15 fw-500">
                                    <td>{{ trans('labels.product_name') }}</td>
                                    <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                                        {{ trans('labels.price') }}
                                    </td>
                                    <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                                        {{ trans('labels.qty') }}
                                    </td>
                                    <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                                        {{ trans('labels.total') }}
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($getorderitemlist as $product)
                                    <tr class="align-middle fs-7 fw-500">
                                        <td>
                                            <div class="d-flex gap-3">
                                                <img src="{{ helper::image_path($product->product_image) }}"
                                                    alt="item-image" class="img-fluid rounded hw-50">
                                                <div class="d-flex align-items-center">
                                                    <h5 class="fw-500 line-2 m-0 fs-6">
                                                        {{ $product->product_name }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                                            {{ helper::currency_formate($product->product_price, $vendor_id) }}
                                        </td>
                                        <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                                            {{ $product->qty }}
                                        </td>
                                        <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                                            {{ helper::currency_formate($product->product_price * $product->qty, $vendor_id) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-15 fw-500 p-2"
                                        colspan="3">
                                        {{ trans('labels.subtotal') }}
                                    </td>
                                    <td
                                        class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-16 fw-500 p-2">
                                        {{ helper::currency_formate($getorderdata->sub_total, $vendor_id) }}
                                    </td>
                                </tr>
                                @if ($getorderdata->offer_amount > 0)
                                    <tr>
                                        <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-15 fw-500 p-2"
                                            colspan="3">
                                            {{ trans('labels.discount') }} ({{ $getorderdata->offer_code }})
                                        </td>
                                        <td
                                            class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-16 fw-500 p-2">
                                            –
                                            {{ helper::currency_formate($getorderdata->offer_amount, $vendor_id) }}
                                        </td>
                                    </tr>
                                @endif
                                @if ($getorderdata->tax_amount != null && $getorderdata->tax_amount != '')
                                    @php
                                        $tax_amount = explode('|', $getorderdata->tax_amount);
                                        $tax_name = explode('|', $getorderdata->tax_name);
                                    @endphp
                                    @foreach ($tax_amount as $key => $tax_value)
                                        <tr>
                                            <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-15 fw-500 p-2"
                                                colspan="3">{{ $tax_name[$key] }}
                                            </td>
                                            <td
                                                class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-16 fw-500 p-2">
                                                {{ helper::currency_formate($tax_value, $vendor_id) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                <tr>
                                    <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-15 fw-500 p-2"
                                        colspan="3"> {{ trans('labels.delivery') }}
                                        @if ($getorderdata->shipping_area != '')
                                            ({{ $getorderdata->shipping_area }})
                                        @endif
                                    </td>
                                    <td
                                        class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-16 fw-500 p-2">
                                        @if ($getorderdata->delivery_charge > 0)
                                            {{ helper::currency_formate($getorderdata->delivery_charge, $vendor_id) }}
                                        @else
                                            {{ trans('labels.free') }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-16 fw-600 p-2"
                                        colspan="3">
                                        {{ trans('labels.grand_total') }}
                                    </td>
                                    <td
                                        class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} fs-16 fw-600 p-2">
                                        {{ helper::currency_formate($getorderdata->grand_total, $vendor_id) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<div class="modal fade" id="customerinfo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <h5 class="modal-title color-changer" id="customerinfoLabel">{{ trans('labels.edit') }}</h5>
                <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                </button>
            </div>
            <form class="m-0 overflow-auto" action="{{ URL::to('admin/orders/customerinfo') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="order_number" id="modal_order_number" value="">
                    <input type="hidden" name="edit_type" id="edit_type" value="">
                    <div id="customer_info">
                        <div class="form-group col-md-12">
                            <label for="customer_name"
                                class="form-label">{{ trans('labels.customer_name') }}</label>
                            <div class="controls">
                                <input type="text" name="customer_name" id="customer_name" class="form-control"
                                    required="">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="customer_mobile"
                                class="form-label">{{ trans('labels.customer_mobile') }}</label>
                            <div class="controls">
                                <input type="text" name="customer_mobile" id="customer_mobile"
                                    class="form-control" required="">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="customer_email"
                                class="form-label">{{ trans('labels.customer_email') }}</label>
                            <div class="controls">
                                <input type="text" name="customer_email" id="customer_email" class="form-control"
                                    required="">
                            </div>
                        </div>
                    </div>

                    <div id="delivery_info">
                        <div class="form-group col-md-12">
                            <label for="customer_address" class="form-label">{{ trans('labels.address') }}</label>
                            <div class="controls">
                                <input type="text" name="customer_address" id="customer_address"
                                    class="form-control" required="">
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="customer_landmark" class="form-label">{{ trans('labels.landmark') }}</label>
                            <div class="controls">
                                <input type="text" name="customer_landmark" id="customer_landmark"
                                    class="form-control" required="">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="customer_pincode" class="form-label">{{ trans('labels.pincode') }}</label>
                            <div class="controls">
                                <input type="text" name="customer_pincode" id="customer_pincode"
                                    class="form-control" required="">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="customer_city" class="form-label">{{ trans('labels.city') }}</label>
                            <div class="controls">
                                <input type="text" name="customer_city" id="customer_city" class="form-control"
                                    required="">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="customer_state" class="form-label">{{ trans('labels.state') }}</label>
                            <div class="controls">
                                <input type="text" name="customer_state" id="customer_state" class="form-control"
                                    required="">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="customer_country">{{ trans('labels.country') }}</label>
                            <div class="controls">
                                <input type="text" name="customer_country" id="customer_country"
                                    class="form-control" required="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger px-sm-4"
                        data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                    <button class="btn btn-primary px-sm-4" type="submit">{{ trans('labels.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@section('scripts')
    <script>
        function editcustomerdata(order_id, customer_name, customer_mobile, customer_email, customer_address, customer_city,
            customer_state, customer_country, customer_landmark, customer_pincode, type) {
            "use strict";
            $('#modal_order_number').val(order_id);
            if (type == "customer_info") {
                $('#customer_info').show();
                $('#customer_name').val(customer_name);
                $('#customer_mobile').val(customer_mobile);
                $('#customer_email').val(customer_email);
                $('#edit_type').val(type);
                $('#delivery_info').hide();
                $('#customer_name').prop('required', true);
                $('#customer_email').prop('required', true);
                $('#customer_mobile').prop('required', true);
                $('#customer_address').prop('required', false);
                $('#customer_city').prop('required', false);
                $('#customer_state').prop('required', false);
                $('#customer_country').prop('required', false);
                $('#customer_landmark').prop('required', false);
                $('#customer_pincode').prop('required', false);
            }
            if (type == "delivery_info") {
                $('#delivery_info').show();
                $('#customer_address').val(customer_address.replace(/[|]+/g, ","));
                $('#customer_city').val(customer_city.replace(/[|]+/g, ","));
                $('#customer_landmark').val(customer_landmark.replace(/[|]+/g, ","));
                $('#customer_state').val(customer_state.replace(/[|]+/g, ","));
                $('#customer_country').val(customer_country.replace(/[|]+/g, ","));
                $('#customer_pincode').val(customer_pincode);
                $('#edit_type').val(type);
                $('#customer_info').hide();
                $('#customer_address').prop('required', true);
                $('#customer_city').prop('required', true);
                $('#customer_state').prop('required', true);
                $('#customer_country').prop('required', true);
                $('#customer_landmark').prop('required', true);
                $('#customer_pincode').prop('required', true);
                $('#customer_name').prop('required', false);
                $('#customer_email').prop('required', false);
                $('#customer_mobile').prop('required', false);
            }
            $('#customerinfo').modal('show');
        }
    </script>
@endsection
