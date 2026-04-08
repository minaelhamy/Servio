@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
    @endphp
    <div class="row g-3 mt-3">
        @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
            <div class="row">
                <div class="col-12 ml-sm-auto">
                    <div class="alert alert-warning" role="alert">
                        {{ trans('messages.commission_message') }} @if (@helper::getslug($vendor_id)->commission_type == 1)
                            {{ helper::currency_formate(@helper::getslug($vendor_id)->commission_amount, $vendor_id) }}
                        @else
                            {{ @helper::getslug($vendor_id)->commission_amount }}%
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="col-xl-3 col-sm-6">
            <div class="card rgb-info-light border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon bg-info">
                            <i class="fa-regular fa-money-bill-1-wave fs-5"></i>
                        </span>
                        <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                            <p class="text-dark fw-500 fs-15 mb-1 color-changer">
                                {{ trans('labels.total_revenue') }}
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="@if (Auth::user()->type == 1) {{ trans('labels.total_revenue_including_all_providers_booking') }} @else {{ trans('labels.total_revenue_excluding_tax') }} @endif "><i
                                        class="fa-solid fa-circle-info"></i> </span>
                            </p>

                            <h5 class="fw-600 text-dark color-changer">
                                {{ helper::currency_formate($totalrevenue->total, $vendor_id) }}
                            </h5>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if (Auth::user()->type == 2)
            <div class="col-xl-3 col-sm-6">
                <div class="card border-0 box-shadow rgb-danger-light h-100">
                    <div class="card-body">
                        <div class="dashboard-card">
                            <span class="card-icon bg-danger">
                                <i class="fa-regular fa-money-bill-1-wave fs-5"></i>
                            </span>
                            <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                <p class="text-dark fs-15 fw-500 mb-1 color-changer">
                                    {{ trans('labels.total_tax') }}
                                    <span class="" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ trans('labels.total_tax_refund_from_admin') }}"><i
                                            class="fa-solid fa-circle-info"></i> </span>
                                </p>
                                <h5 class="fw-600 text-dark color-changer">
                                    {{ helper::currency_formate($totaltax->tax, $vendor_id) }}
                                </h5>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 box-shadow rgb-secondary-light h-100">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon bg-secondary">
                            <i class="fa-regular fa-money-bill-1-wave fs-5"></i>
                        </span>
                        <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                            <p class="text-dark fs-500 fs-15 mb-1 color-changer">
                                {{ trans('labels.total_commission') }}
                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="@if (Auth::user()->type == 1) {{ trans('labels.total_commission_admin_get') }} @else {{ trans('labels.total_commission_you_pay_to_admin') }} @endif "><i
                                        class="fa-solid fa-circle-info"></i> </span>
                            </p>
                            <h5 class="fw-600 text-dark color-changer">
                                {{ helper::currency_formate($totalcommission->commission, $vendor_id) }}</h5>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
            <div class="col-xl-3 col-sm-6">
                <div class="card border-0 box-shadow rgb-warning-light h-100">
                    <div class="card-body">
                        <div class="dashboard-card">
                            <span class="card-icon bg-warning">
                                <i class="fa-regular fa-money-bill-1-wave fs-5"></i>
                            </span>
                            <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                <p class="text-dark fw-500 fs-15 mb-1 color-changer">
                                    {{ trans('labels.pending_payout') }}
                                    <span class="" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ trans('labels.total_pending_payout_for_admin') }}"><i
                                            class="fa-solid fa-circle-info"></i> </span>
                                </p>
                                <h5 class="fw-600 text-dark color-changer">
                                    {{ helper::currency_formate(@$totalpendingpayout, $vendor_id) }}</h5>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card border-0 box-shadow rgb-success-light h-100">
                    <div class="card-body">
                        <div class="dashboard-card">
                            <span class="card-icon bg-success">
                                <i class="fa-regular fa-money-bill-1-wave fs-5"></i>
                            </span>
                            <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                <p class="text-dark fs-15 fw-500 mb-1 color-changer">
                                    {{ trans('labels.completed_payout') }}
                                    <span class="" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ trans('labels.total_completed_payout_for_admin') }}"><i
                                            class="fa-solid fa-circle-info"></i> </span>
                                </p>
                                <h5 class="fw-600 text-dark color-changer">
                                    {{ helper::currency_formate(@$totalcompletedpayout->payable_amt, $vendor_id) }}</h5>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (Auth::user()->type == 2)
            <div class="col-xl-3 col-sm-6">
                <div class="card border-0 box-shadow rgb-warning-light h-100">
                    <div class="card-body">
                        <div class="dashboard-card">
                            <span class="card-icon bg-warning">
                                <i class="fa-regular fa-money-bill-1-wave fs-5"></i>
                            </span>
                            <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                <p class="text-dark fs-15 fw-500 mb-1 color-changer">
                                    {{ trans('labels.total_earnings') }}
                                    <span class="" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ trans('labels.total_earning_provider') }}"><i
                                            class="fa-solid fa-circle-info"></i> </span>
                                </p>
                                <h5 class="fw-600 text-dark color-changer">
                                    {{ helper::currency_formate($totalrevenue->total - $totalcommission->commission, $vendor_id) }}
                                </h5>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6">
                <div class="card border-0 box-shadow rgb-primary-light h-100">
                    <div class="card-body">
                        <div class="dashboard-card">
                            <span class="card-icon bg-primary">
                                <i class="fa-regular fa-money-bill-1-wave fs-5"></i>
                            </span>
                            <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                <p class="text-dark fw-500 fs-15 mb-1 color-changer">
                                    {{ trans('labels.last_payout') }}
                                    <span class="" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ trans('labels.last_payout_provider') }}"><i
                                            class="fa-solid fa-circle-info"></i> </span>
                                </p>
                                <h5 class="fw-600 text-dark color-changer">
                                    {{ helper::currency_formate(@$last_payout->payable_amt, $vendor_id) }}</h5>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 ">
                <div class="card border-0 box-shadow rgb-success-light h-100">
                    <div class="card-body">
                        <div class="dashboard-card">
                            <span class="card-icon bg-success">
                                <i class="fa-regular fa-money-bill-1-wave fs-5"></i>
                            </span>
                            <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                <p class="text-dark fw-500 fs-15 mb-1 color-changer">
                                    {{ trans('labels.current_balance') }}
                                    <span class="" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{ trans('labels.current_balance_provider') }}"><i
                                            class="fa-solid fa-circle-info"></i> </span>
                                </p>
                                <h5 class="fw-600 text-dark color-changer">
                                    {{ helper::currency_formate(@helper::getslug($vendor_id)->wallet, $vendor_id) }}</h5>
                            </span>
                        </div>
                    </div>
                    <a href="{{ URL::to('/admin/payout/request-' . @helper::getslug($vendor_id)->wallet . '/' . @helper::getslug($vendor_id)->commission . '/' . @helper::getslug($vendor_id)->wallet + @helper::getslug($vendor_id)->commission) }}"
                        class="btn btn-secondary rounded-top-0 px-sm-4 d-flex">
                        <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.request_payout') }}</a>
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 my-3 box-shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered py-3 zero-configuration w-100">
                            <thead>
                                <tr class="text-capitalize fw-500 fs-15">
                                    <td>{{ trans('labels.srno') }}</td>
                                    @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                        <td>{{ trans('labels.vendor_name') }}</td>
                                    @endif
                                    <td>{{ trans('labels.amount') }}</td>
                                    <td>{{ trans('labels.status') }}</td>
                                    <td>{{ trans('labels.created_date') }}</td>
                                    @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                        <td>{{ trans('labels.action') }}</td>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($payout as $payout)
                                    <tr class="fs-7 row1 align-middle">
                                        <td>@php
                                            echo $i++;
                                        @endphp</td>
                                        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                            <td>{{ helper::getslug($payout->vendor_id)->name }}</td>
                                        @endif
                                        <td>
                                            {{ trans('labels.payout_amount') }} : <b
                                                class="text-success">{{ helper::currency_formate($payout->payable_amt, $vendor_id) }}</b><br>
                                            {{ trans('labels.admin_commission') }} : - <b
                                                class="text-danger">{{ helper::currency_formate($payout->commission, $vendor_id) }}</b>
                                        </td>
                                        <td>
                                            @if ($payout->status == '1')
                                                <span
                                                    class="badge badge bg-warning float-right mr-1 mt-1">{{ trans('labels.pending') }}</span>
                                            @endif
                                            @if ($payout->status == '2')
                                                <span
                                                    class="badge badge bg-success float-right mr-1 mt-1">{{ trans('labels.approved') }}</span>
                                            @endif
                                            @if ($payout->status == '3')
                                                <span
                                                    class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.rejected') }}</span>

                                                <span class="" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $payout->reason }}">
                                                    <i class="fa-solid fa-circle-info"></i> </span>
                                            @endif
                                        </td>
                                        <td>{{ helper::date_formate($payout->created_at, $vendor_id) }}<br>
                                            {{ helper::time_format($payout->created_at, $vendor_id) }}</td>
                                        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                            <td>
                                                @if ($payout->status == 1)
                                                    <div
                                                        class="d-flex gap-2 flex-wrap {{ Auth::user()->type == 4 ? (helper::check_access('role_payout', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                        <a class="btn btn-sm btn-success pay_now" href="javascrip:void(0)"
                                                            data-request-id="{{ @$payout->id }}"
                                                            data-request-amount="{{ $payout->request_balance }}"
                                                            data-commission="{{ $payout->commission }}"
                                                            data-payable-amt="{{ $payout->payable_amt }}"
                                                            data-vendor-name="{{ helper::getslug($payout->vendor_id)->name }}"
                                                            data-bank-name="{{ helper::bank_details($payout->vendor_id)->name }}"
                                                            data-account-number="{{ helper::bank_details($payout->vendor_id)->bank_account_number }}"
                                                            data-account-email="{{ helper::bank_details($payout->vendor_id)->email }}"
                                                            data-account-type="{{ helper::bank_details($payout->vendor_id)->type_of_account }}">{{ trans('labels.pay') }}</a>

                                                        <a class="btn btn-sm btn-danger pay_reject"
                                                            href="javascrip:void(0)"
                                                            data-request-id="{{ @$payout->id }}">{{ trans('labels.reject') }}</a>
                                                    </div>
                                                @else
                                                    -
                                                @endif

                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- payout modal -->
    <div class="modal fade text-left" id="payout_modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h4 class="modal-title color-changer" id="exampleModalScrollableTitle">{{ trans('labels.payout_request') }}
                    </h4>
                    <button type="button" class="bg-transparent border-0 color-changer" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-regular fa-xmark fs-4"></i>
                    </button>
                </div>
                <form action="{{ URL::to('/admin/payout/change_status/2') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="row">
                                <input type="hidden" class="form-control" id="request_id" name="request_id"
                                    value="" readonly>
                                <div class="col-md-6 col-lg-4">
                                    <label class="form-label">{{ trans('labels.bank_name') }}</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="bank_name" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <label class="form-label">{{ trans('labels.type_of_account') }}</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="account_type" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <label class="form-label">{{ trans('labels.account_number') }}</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="account_number" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <label class="form-label">{{ trans('labels.email') }}</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="account_email" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <label class="form-label">{{ trans('labels.vendor_name') }}</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="vendor_name" id="vendor_name" disabled>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">{{ trans('labels.commission') }} </label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="commission" id="commission"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">{{ trans('labels.requested_amount') }}</label>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="payable_amt" id="payable_amt"
                                        disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger px-sm-4"
                            data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                        <input type="submit" class="btn btn-primary px-sm-4" value="{{ trans('labels.pay') }}">
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- payout reject modal -->
    <div class="modal fade text-left" id="payout_reject_modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h4 class="modal-title color-changer" id="exampleModalScrollableTitle">{{ trans('labels.payout_reject') }}
                    </h4>
                    <button type="button" class="bg-transparent border-0 color-changer" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-regular fa-xmark fs-4"></i>
                    </button>
                </div>
                <form action="{{ URL::to('/admin/payout/change_status/3') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="row">
                                <input type="hidden" class="form-control" id="_request_id" name="request_id"
                                    value="" readonly>
                                <div class="col-md-12 col-lg-12">
                                    <label class="form-label">{{ trans('labels.reason') }}</label>
                                    <div class="form-group">
                                        <textarea name="reason" class="form-control" placeholder="{{ trans('labels.reason') }}" rows="5"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger px-sm-4"
                            data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                        <input type="submit" class="btn btn-primary px-sm-4" value="{{ trans('labels.reject') }}">
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(".pay_now").on("click", function() {
            $("#request_id").val($(this).attr('data-request-id'));
            $("#vendor_name").val($(this).attr('data-vendor-name'));
            $("#request_amount").val($(this).attr('data-request-amount'));
            $("#commission").val($(this).attr('data-commission'));
            $("#payable_amt").val($(this).attr('data-payable-amt'));
            $("#bank_name").val($(this).attr('data-bank-name'));
            $("#account_type").val($(this).attr('data-account-type'));
            $("#account_number").val($(this).attr('data-account-number'));
            $("#account_email").val($(this).attr('data-account-email'));
            $('#payout_modal').modal('show');
        });

        $(".pay_reject").on("click", function() {
            $("#_request_id").val($(this).attr('data-request-id'));
            $('#payout_reject_modal').modal('show');
        });
    </script>
@endsection
