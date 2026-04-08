@extends('front.layout.master')
@section('content')
    <div class="container">
        <div class="breadcrumb-div pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to($vendordata->slug) }}" class="text-primary-color">
                            <i
                                class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item  active {{ session()->get('direction') == '2' ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">{{ trans('labels.order_list') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="product-prev-sec product-list-sec">
        <div class="container">
            <h2 class="section-title fw-600">{{ trans('labels.account_details') }}</h2>
            <div class="user-bg-color mb-4">
                <div class="row g-3">
                    @include('front.user.commonmenu')
                    <div class="col-xl-9 col-lg-8 col-xxl-9 col-12">
                        <div class="card h-100 w-100 rounded-4 overflow-hidden">
                            <!------ Card header ------>
                            <div class="card-header bg-transparent color-changer border-bottom p-3 d-flex gap-2 align-items-center">
                                <i class="fs-4 fa fa-bag-shopping"></i>
                                <h5 class="title m-0 fw-500">
                                    {{ trans('labels.order_list') }}
                                </h5>
                            </div>
                            <ul class="nav nav-tabs nav-bottom-line p-3 nav-responsive nav-justified pb-0 mb-4"
                                role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mb-0 text-warning {{ request()->get('type') == 'processing' ? 'active' : '' }}"
                                        href="{{ URL::to($vendordata->slug . '/myorders?type=processing') }}">
                                        <div
                                            class="icon-sm d-inline-block bg-warning bg-opacity-10 text-warning rounded-circle mx-2">
                                            <i class="fa-solid fa-hourglass-empty mx-2"></i>
                                        </div>
                                        {{ trans('labels.processing') }}&nbsp;({{ $totalprocessingorder }})
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mb-0 text-success {{ request()->get('type') == 'completed' ? 'active' : '' }}"
                                        href="{{ URL::to($vendordata->slug . '/myorders?type=completed') }}">
                                        <div
                                            class="icon-sm d-inline-block bg-success bg-opacity-10 text-success rounded-circle mx-2">
                                            <i class="fa-solid fa-check mx-2"></i>
                                        </div>{{ trans('labels.completed') }}&nbsp;({{ $totalcompletedorder }})
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mb-0 text-danger {{ request()->get('type') == 'cancelled' ? 'active' : '' }}"
                                        href="{{ URL::to($vendordata->slug . '/myorders?type=cancelled') }}">
                                        <div
                                            class="icon-sm d-inline-block bg-danger bg-opacity-10 text-danger rounded-circle mx-2">
                                            <i class="fa-solid fa-xmark mx-2"></i>
                                        </div>{{ trans('labels.cancelled') }}&nbsp;({{ $totalcancelledorder }})
                                    </a>
                                </li>
                            </ul>
                            <div class="card-body">
                                <!-- new detail list -->
                                @if (count($orders) > 0)
                                    @foreach ($orders as $order)
                                        <div class="card border-0 shadow rounded-4 p-2 mb-3">
                                            <div class="row g-0">
                                                <div class="col-12">
                                                    <div class="card-body py-md-2 d-flex flex-column">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <span
                                                                class="booking-id badge text-bg-dark">{{ $order->order_number }}</span>
                                                            @if ($order->status_type == 1)
                                                                <span class="text-warning fw-semibold">
                                                                    <i class="fa-solid fa-hourglass-empty mx-1"></i>
                                                                    {{ @helper::gettype($order->status, $order->status_type, $order->vendor_id, 2)->name == null ? '-' : @helper::gettype($order->status, $order->status_type, $order->vendor_id, 2)->name }}</span>
                                                            @endif
                                                            @if ($order->status_type == 2)
                                                                <span class="text-success fw-semibold">
                                                                    <i class="fa-solid fa-check  mx-1"></i>
                                                                    {{ @helper::gettype($order->status, $order->status_type, $order->vendor_id, 2)->name == null ? '-' : @helper::gettype($order->status, $order->status_type, $order->vendor_id, 2)->name }}</span>
                                                            @endif
                                                            @if ($order->status_type == 4)
                                                                <span class="text-danger fw-semibold">
                                                                    <i class="fa-solid fa-xmark mx-1"></i>
                                                                    {{ @helper::gettype($order->status, $order->status_type, $order->vendor_id, 2)->name == null ? '-' : @helper::gettype($order->status, $order->status_type, $order->vendor_id, 2)->name }}</span>
                                                            @endif
                                                            @if ($order->status_type == 3)
                                                                <span class="text-success fw-semibold">
                                                                    <i class="fa-solid fa-check mx-1"></i>
                                                                    {{ @helper::gettype($order->status, $order->status_type, $order->vendor_id, 2)->name == null ? '-' : @helper::gettype($order->status, $order->status_type, $order->vendor_id, 2)->name }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h4 class="mt-2 mb-2 fs-6 fw-600 color-changer">
                                                                {{ trans('labels.grand_total') }} :
                                                                {{ helper::currency_formate($order->grand_total, $order->vendor_id) }}
                                                            </h4>
                                                            <small
                                                                class="text-muted fw-500">{{ helper::date_formate($order->created_at, $order->vendor_id) }}</small>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between mt-2">
                                                            <div class="d-flex flex-wrap gap-2 align-items-end">
                                                                <h6 class="m-0 fw-500 color-changer">
                                                                    <span>{{ trans('labels.payment_type') }}
                                                                        :</span>
                                                                    {{ @helper::getpayment($order->transaction_type, $vendordata->id)->payment_name }}
                                                                </h6>
                                                            </div>
                                                            <a href="{{ URL::to($vendordata->slug . '/order/' . $order->order_number) }}"
                                                                title="View"
                                                                class="btn btn-primary btn-submit text-white px-3 py-2 rounded">View</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    @include('admin.layout.no_data')
                                @endif
                                <div class="d-flex justify-content-center">
                                    {{ $orders->links() }}
                                </div>
                                <!-- new detail list -->
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
