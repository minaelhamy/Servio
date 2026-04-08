@extends('front.layout.master')
@section('content')
    <!------ breadcrumb ------>
    <section class="breadcrumb-div pt-4">

        <div class="container">

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item text-dark">
                        <a href="{{ URL::to($vendordata->slug . '/') }}" class="text-primary-color">
                            <i class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>
                            {{ trans('labels.home') }}
                        </a>
                    </li>

                    <li class="breadcrumb-item  active {{ session()->get('direction') == '2' ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">
                        {{ trans('labels.wallet') }}
                    </li>

                </ol>

            </nav>

        </div>

    </section>

    <section class="product-prev-sec product-list-sec">
        <div class="container">
            <h2 class="section-title fw-600">{{ trans('labels.account_details') }}</h2>
            <div class="user-bg-color mb-4">
                <div class="row g-3">
                    @include('front.user.commonmenu')
                    <div class="col-xl-9 col-lg-8 col-xxl-9 col-12">
                        <div class="card p-0 border rounded-4 user-form">
                            <div class="settings-box">
                                <div class="settings-box-header gap-3 flex-wrap border-bottom p-3">
                                    <div class="mb-0 d-flex align-items-center gap-3">
                                        <i class="fa-light fa-wallet fs-4 color-changer"></i>
                                        <div>
                                            <span class="fs-5 fw-500 color-changer">
                                                {{ trans('labels.wallet_balance') }}
                                            </span>
                                            <p class="text-success fs-6 fw-600">
                                                {{ helper::currency_formate(Auth::user()->wallet, $vendordata->id) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto col-12">
                                        <a href="{{ URL::to($vendordata->slug . '/addmoneywallet') }}"
                                            class="w-100 btn-primary btn-submit rounded btn align-items-center fs-15 fw-500 justify-content-center d-flex gap-2">
                                            <i class="fa-regular fa-plus"></i>
                                            {{ trans('labels.add_money') }}
                                        </a>
                                    </div>
                                </div>
                                <div class="settings-box-body p-3 dashboard-section">
                                    <div class="table-responsive">
                                        <table class="table table-striped align-middle table-hover">
                                            <thead class="table-primary">
                                                <tr class="fs-7 fw-600">
                                                    <th class="col text-white">{{ trans('labels.date') }}</th>
                                                    <th class="col text-white"> {{ trans('labels.amount') }} </th>
                                                    <th class="col text-white">{{ trans('labels.remark') }}</th>
                                                    <th class="col text-white">{{ trans('labels.status') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($gettransactions as $row)
                                                    <tr class="fs-7">
                                                        <td class="color-changer">{{ helper::date_formate($row->created_at, $vendordata->id) }}<br>
                                                            {{ helper::time_format($row->created_at, $vendordata->id) }}
                                                        </td>
                                                        <td class="color-changer">{{ helper::currency_formate($row->amount, $vendordata->id) }}
                                                        </td>
                                                        <td class="color-changer">
                                                            @if ($row->transaction_type == 2)
                                                                @if ($row->product_type == 1)
                                                                    {{ trans('labels.booking_placed') }}
                                                                @elseif ($row->product_type == 2)
                                                                    {{ trans('labels.order_placed') }}
                                                                @endif
                                                                <span class="fw-500">{{ $row->order_number }} </span>
                                                            @elseif ($row->transaction_type == 3)
                                                                @if ($row->product_type == 1)
                                                                    {{ trans('labels.booking_cancel') }}
                                                                @elseif ($row->product_type == 2)
                                                                    {{ trans('labels.order_cancel') }}
                                                                @endif
                                                                <span class="fw-500">{{ $row->order_number }} </span>
                                                            @elseif ($row->transaction_type == 4)
                                                                {{ trans('labels.referral_earning') }}
                                                                <span>{{ $row->username }}</span>
                                                            @else
                                                                {{ trans('labels.wallet_recharge') }}
                                                                <span>{{ @helper::getpayment($row->payment_type, $vendordata->id)->payment_name }}</span>
                                                                <span>{{ $row->payment_id }}</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($row->transaction_type == 2)
                                                                <div
                                                                    class="badge bg-debit custom-badge bg-cancelled rounded-0">
                                                                    <span> {{ trans('labels.debit') }}</span>
                                                                </div>
                                                            @else
                                                                <div
                                                                    class="badge bg-debit custom-badge rounded-0 bg-completed">
                                                                    <span> {{ trans('labels.credit') }}</span>
                                                                </div>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $gettransactions->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- newsletter -->
            @include('front.contact.index')
        </div>
    </section>
@endsection
