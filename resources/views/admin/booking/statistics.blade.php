@php
    if (Auth::user()->type == 4) {
        $vendor_id = Auth::user()->vendor_id;
    } else {
        $vendor_id = Auth::user()->id;
    }
@endphp

<div class="row pt-3 mb-3 g-3">
    <div class="col-xxl-3 col-md-6">
        <div class="card box-shadow rgb-info-light h-100 {{ request()->get('type') == '' ? 'border border-primary' : 'border-0' }}">
            @if (request()->is('admin/reports') && helper::check_menu(Auth::user()->role_id, 'role_reports') == 1)
                <a
                    href="{{ URL::to(request()->url() . '?customer_id=' . request()->get('customer_id') . '&type=&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                @elseif(request()->is('admin/bookings') && helper::check_menu(Auth::user()->role_id, 'role_bookings') == 1)
                    <a href="{{ URL::to('admin/bookings?type=') }}">
                    @elseif(request()->is('admin/customers/bookings*') && helper::check_menu(Auth::user()->role_id, 'role_customers') == 1)
                        <a href="{{ URL::to('admin/customers/bookings-' . @$userinfo->id . '?type=') }}">
            @endif
            <div class="card-body">
                <div class="dashboard-card">
                    <span class="card-icon bg-info">
                        <i class="fa fa-book-user"></i>
                    </span>
                    <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                        <p class="text-dark fw-500 fs-15 mb-1 color-changer">{{ trans('labels.total_bookings') }}</p>
                        <h5 class="text-dark fw-600 color-changer">{{ $totalbooking }}</h5>
                    </span>
                </div>
            </div>
            </a>
        </div>

    </div>
    <div class="col-xxl-3 col-md-6">
        <div
            class="card box-shadow rgb-warning-light h-100 {{ request()->get('type') == 'processing' ? 'border border-primary' : 'border-0' }}">
            @if (request()->is('admin/reports') && helper::check_menu(Auth::user()->role_id, 'role_reports') == 1)
                <a
                    href="{{ URL::to(request()->url() . '?customer_id=' . request()->get('customer_id') . '&type=processing&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                @elseif(request()->is('admin/bookings') && helper::check_menu(Auth::user()->role_id, 'role_bookings') == 1)
                    <a href="{{ URL::to('admin/bookings?type=processing') }}">
                    @elseif(request()->is('admin/customers/bookings*') && helper::check_menu(Auth::user()->role_id, 'role_customers') == 1)
                        <a href="{{ URL::to('admin/customers/bookings-' . @$userinfo->id . '?type=processing') }}">
            @endif
            <div class="card-body">
                <div class="dashboard-card">
                    <span class="card-icon bg-warning">
                        <i class="fa fa-hourglass"></i>
                    </span>
                    <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                        <p class="text-dark fw-500 fs-15 mb-1 color-changer">{{ trans('labels.processing') }}</p>
                        <h5 class="text-dark fw-600 color-changer">{{ $totalprocessing }}</h5>
                    </span>
                </div>
            </div>
            </a>
        </div>

    </div>
    <div class="col-xxl-3 col-md-6">
        <div
            class="card box-shadow rgb-success-light h-100 {{ request()->get('type') == 'completed' ? 'border border-primary' : 'border-0' }}">
            @if (request()->is('admin/reports') && helper::check_menu(Auth::user()->role_id, 'role_reports') == 1)
                <a
                    href="{{ URL::to(request()->url() . '?customer_id=' . request()->get('customer_id') . '&type=completed&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                @elseif(request()->is('admin/bookings') && helper::check_menu(Auth::user()->role_id, 'role_bookings') == 1)
                    <a href="{{ URL::to('admin/bookings?type=completed') }}">
                    @elseif(request()->is('admin/customers/bookings*') && helper::check_menu(Auth::user()->role_id, 'role_customers') == 1)
                        <a href="{{ URL::to('admin/customers/bookings-' . @$userinfo->id . '?type=completed') }}">
            @endif
            <div class="card-body">
                <div class="dashboard-card">
                    <span class="card-icon bg-success">
                        <i class="fa fa-check"></i>
                    </span>
                    <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                        <p class="text-dark fw-500 fs-15 mb-1 color-changer">{{ trans('labels.completed') }}</p>
                        <h5 class="text-dark fw-600 color-changer">{{ $totalcompleted }}</h5>
                    </span>
                </div>
            </div>
            </a>
        </div>
    </div>
    <div class="col-xxl-3 col-md-6">
        <div
            class="card box-shadow h-100 rgb-danger-light {{ request()->get('type') == 'canceled' ? 'border border-primary' : 'border-0' }}">
            @if (request()->is('admin/reports') && helper::check_menu(Auth::user()->role_id, 'role_reports') == 1)
                <a
                    href="{{ URL::to(request()->url() . '?customer_id=' . request()->get('customer_id') . '&type=canceled&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                @elseif(request()->is('admin/bookings') && helper::check_menu(Auth::user()->role_id, 'role_bookings') == 1)
                    <a href="{{ URL::to('admin/bookings?type=canceled') }}">
                    @elseif(request()->is('admin/customers/bookings*') && helper::check_menu(Auth::user()->role_id, 'role_customers') == 1)
                        <a href="{{ URL::to('admin/customers/bookings-' . @$userinfo->id . '?type=canceled') }}">
            @endif
            <div class="card-body">
                <div class="dashboard-card">
                    <span class="card-icon bg-danger">
                        <i class="fa fa-close"></i>
                    </span>
                    <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                        <p class="text-dark fw-500 fs-15 mb-1 color-changer">{{ trans('labels.canceled') }}</p>
                        <h5 class="text-dark fw-600 color-changer">{{ $totalcanceled }}</h5>
                    </span>
                </div>
            </div>
            </a>
        </div>
    </div>
</div>
