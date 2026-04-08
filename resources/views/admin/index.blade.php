@extends('admin.layout.default')
@section('content')
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
    @endphp
    @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
        @if (helper::otherappdata(1)->notice_on_off == 1)
            <div class="card mb-3 notice_card border-0 box-shadow">
                <div class="card-body">
                    <div class="d-flex flex-wrap flex-sm-nowrap gap-3">
                        <div class="d-flex justify-content-between col-12 col-sm-auto">
                            <div class="alert-icons rgb-danger-light col-auto">
                                <i class="fa-regular fa-circle-exclamation text-danger"></i>
                            </div>
                            <div class="d-sm-none">
                                <div class="close-button cursor-pointer" id="close-btn3">
                                    <i class="fa-solid fa-xmark text-danger"></i>
                                </div>
                            </div>
                        </div>
                        <div class="w-100">
                            <div class="d-flex gap-2 align-items-center mb-2 justify-content-between">
                                <h6 class="line-2 color-changer fs-17">
                                    {{ helper::otherappdata(1)->notice_title }}
                                </h6>
                                <div class="d-sm-block d-none">
                                    <div class="close-button cursor-pointer" id="close-btn2">
                                        <i class="fa-solid fa-xmark text-danger"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted fs-13 m-0">
                                {{ helper::otherappdata(1)->notice_description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
    <div class="d-flex mb-3">
        <h5 class="text-capitalize fw-600 text-dark fs-4 color-changer">{{ trans('labels.dashboardss') }}</h5>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-xl-6 col-12">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="card border-0 box-shadow rgb-info-light h-100">
                        <div class="card-body">
                            <div class="dashboard-card">
                                <span class="card-icon bg-info box-shadow">
                                    @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                        <i class="fa-regular fa-user fs-5"></i>
                                    @endif
                                    @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                        <i class="fa-brands fa-servicestack fs-5"></i>
                                    @endif
                                </span>
                                <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                    @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                        <p class="text-dark fs-15 fw-500 mb-1 color-changer">{{ trans('labels.vendors') }}
                                        </p>
                                        <h5 class="text-dark fw-600 color-changer">
                                            {{ empty($totalusers) ? 0 : $totalusers }}</h5>
                                    @else
                                        <p class="text-dark fs-15 fw-500 mb-1 color-changer">{{ trans('labels.services') }}
                                        </p>
                                        <h5 class="text-dark fw-600 color-changer">
                                            {{ empty($totalservices) ? 0 : $totalservices }}</h5>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @if (@helper::checkaddons('subscription'))
                    <div class="col-md-6">
                        <div class="card border-0 box-shadow rgb-warning-light h-100">
                            <div class="card-body">
                                <div class="dashboard-card">
                                    <span class="card-icon bg-warning box-shadow">
                                        <i class="fa-regular fa-medal fs-5"></i>
                                    </span>
                                    <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                        @if (Auth::user()->id == 1 || Auth::user()->vendor_id == 1)
                                            <p class="text-dark fs-15 fw-500 mb-1 color-changer">
                                                {{ trans('labels.pricing_plan') }}</p>
                                            <h5 class="text-dark fw-600 color-changer">
                                                {{ empty($totalplans) ? 0 : $totalplans }}</h5>
                                        @else
                                            <p class="text-dark fs-15 fw-500 mb-1 color-changer">
                                                {{ trans('labels.current_plan') }}</p>
                                            @if (!empty($currentplan))
                                                <h5 class="text-dark fw-600 color-changer"> {{ @$currentplan->name }} </h5>
                                            @else
                                                -
                                            @endif
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-6">
                    <div class="card border-0 box-shadow rgb-danger-light h-100">
                        <div class="card-body">
                            <div class="dashboard-card">
                                <span class="card-icon bg-danger box-shadow">
                                    <i class="fa-solid fa-ballot-check fs-5"></i>
                                </span>
                                <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                    <p class="text-dark fs-15 fw-500 mb-1 color-changer">
                                        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                            {{ trans('labels.transactions') }}
                                        @elseif (Auth::user()->type == 2 || Auth::user()->type == 4)
                                            {{ trans('labels.bookings') }}
                                        @endif
                                    </p>
                                    @if (Auth::user()->id == 1 || Auth::user()->vendor_id == 1)
                                        <h5 class="text-dark fw-600 color-changer">
                                            {{ empty($totaladminbookings) ? 0 : $totaladminbookings }}</h5>
                                    @else
                                        <h5 class="text-dark fw-600 color-changer">
                                            {{ empty($totalbookings) ? 0 : $totalbookings }}</h5>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 box-shadow rgb-success-light h-100">
                        <div class="card-body">
                            <div class="dashboard-card">
                                <span class="card-icon bg-success box-shadow">
                                    <i class="fa-regular fa-money-bill-1-wave fs-5"></i>
                                </span>
                                <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                    <p class="text-dark fs-15 fw-500 mb-1 color-changer">{{ trans('labels.revenue') }}
                                    </p>
                                    <h5 class="text-dark fw-600 color-changer">
                                        {{ helper::currency_formate($totalrevenue->total, $vendor_id) }}</h5>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-12">
            <div class="card border-0 box-shadow h-100 fixed-bg-card-changer">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-sm-between justify-content-center gap-2">
                        <div
                            class="col-xxl-8 col-xl-7 col-lg-8 col-md-8 col-sm-7 d-flex flex-column gap-2 justify-content-center align-items-start">
                            <h5 class="text-dark fw-600 d-flex gap-2 align-items-center">
                                <img src="{{ helper::image_path(Auth::user()->image) }}"
                                    class="object border rounded-circle dasbord-img" alt="">
                                <small class="text-dark color-changer">{{ Auth::user()->name }}</small>
                            </h5>
                            <p class="text-muted fs-7 m-0 line-3">{{ trans('labels.dashboards_description') }}</p>
                            <div class="dropdown lag-btn">
                                <a class="btn btn-secondary fs-7 text-light fw-500 dropdown-toggle" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-regular fa-plus"></i> {{ trans('labels.quick_add') }}
                                </a>
                                <ul class="dropdown-menu fw-500 p-0 overflow-hidden bg-body-secondary fs-7 text-dark"
                                    style="">
                                    @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                        <li><a class="dropdown-item p-2"
                                                href="{{ URL::to('/admin/services') }}">{{ trans('labels.products') }}</a>
                                        </li>
                                        <li><a class="dropdown-item p-2"
                                                href="{{ URL::to('/admin/categories') }}">{{ trans('labels.categories') }}
                                            </a></li>
                                        <li><a class="dropdown-item p-2"
                                                href="{{ URL::to('/admin/basic_settings') }}">{{ trans('labels.basic_settings') }}</a>
                                        </li>
                                    @else
                                        <li><a class="dropdown-item p-2"
                                                href="{{ URL::to('admin/users') }}">{{ trans('labels.users') }}</a>
                                        </li>
                                        <li><a class="dropdown-item p-2"
                                                href="{{ URL::to('admin/plan') }}">{{ trans('labels.pricing_plan') }}
                                            </a></li>
                                        <li><a class="dropdown-item p-2"
                                                href="{{ URL::to('/admin/basic_settings') }}">{{ trans('labels.basic_settings') }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                @php
                                    if (helper::checkcustomdomain(Auth::user()->id) == null) {
                                        $url = URL::to('/' . Auth::user()->slug);
                                    } else {
                                        $url = 'https://' . helper::checkcustomdomain(Auth::user()->id);
                                    }
                                @endphp
                            <div
                                class="col-xxl-3 col-xl-4 mt-2 mt-sm-0 col-lg-3 col-md-3 col-sm-5 gap-2 d-flex flex-column justify-content-center align-items-center">
                                <img src=" @if (helper::checkcustomdomain(Auth::user()->id) == null) https://qrcode.tec-it.com/API/QRCode?data={{ $url }}&choe=UTF-8 @else https://qrcode.tec-it.com/API/QRCode?data={{ $url }}&chs=180x180 @endif"
                                    class="object quer-code" alt="">
                                <div class="d-flex mt-sm-2">
                                    <button class="btn btn-primary fw-500 fs-7"
                                        onclick="setClipboard('{{ $url }}')">
                                        <i class="fa-regular fa-clone"></i>
                                        {{ trans('labels.copy') }}
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row g-3 pb-3">
        <div class="col-md-8">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3 border-bottom pb-3 justify-content-between">
                        <h5 class="card-title m-0 color-changer">{{ trans('labels.revenue') }}</h5>
                        <select class="form-select form-select-sm w-auto" name="revenue_year" id="revenue_year">
                            @foreach ($revenue_year_list as $year)
                                <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                    {{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <canvas id="linechart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3 border-bottom pb-3 justify-content-between">
                        <h5 class="card-title m-0 color-changer">
                            {{ Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1) ? trans('labels.vendors') : trans('labels.bookings') }}
                        </h5>
                        <select class="form-select form-select-sm w-auto" name="booking_year" id="booking_year">
                            @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                @foreach ($userchart_year as $year)
                                    <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endforeach
                            @else
                                @foreach ($revenue_year_list as $year)
                                    <option value="{{ $year }}" {{ $year == date('Y') ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="row">
                        <canvas id="piechart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
            @php
                $ran = [
                    'gradient-1',
                    'gradient-2',
                    'gradient-3',
                    'gradient-4',
                    'gradient-5',
                    'gradient-6',
                    'gradient-7',
                    'gradient-8',
                    'gradient-9',
                ];
            @endphp
            <div class="col-xl-6">
                <div class="card border-0 box-shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title pb-3 border-bottom color-changer">{{ trans('labels.top_service') }}</h5>
                        <div class="table-responsive" id="table-items">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="fs-15 fw-500">{{ trans('labels.image') }}</th>
                                        <th class="fs-15 fw-500">{{ trans('labels.item_name') }}</th>
                                        <th class="fs-15 fw-500">{{ trans('labels.category') }}</th>
                                        <th class="fs-15 fw-500">{{ trans('labels.orders') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($topitems) > 0)
                                        @foreach (@$topitems as $row)
                                            <tr class="fs-7 fw-500 text-dark align-middle">
                                                <td>
                                                    <img src="{{ helper::image_path($row['service_image']->image) }}"
                                                        class="rounded hw-50 object" alt="">
                                                </td>
                                                <td>
                                                    <a href="{{ URL::to('admin/services/edit-' . $row->slug) }}"
                                                        class="color-changer">{{ $row->name }}</a>
                                                </td>
                                                <td>{{ @$row['category_info']->name }}</td>
                                                <td>
                                                    @php
                                                        $per =
                                                            $getbookingscount > 0
                                                                ? ($row->service_book_counter * 100) / $getbookingscount
                                                                : 0;
                                                    @endphp
                                                    {{ number_format($per, 2) }}%
                                                    <div class="progress h-10-px">
                                                        <div class="progress-bar gradient-color {{ $ran[array_rand($ran, 1)] }}"
                                                            style="width: {{ $per }}%;" role="progressbar">
                                                            <span class="sr-only">{{ $per }}%
                                                                {{ trans('labels.orders') }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4">
                                                <h6 class="text-center fw-600">
                                                    {{ trans('labels.no_data_found') }}
                                                </h6>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card border-0 box-shadow h-100">
                    <div class="card-body">
                        <h5 class="card-title pb-3 border-bottom color-changer">{{ trans('labels.top_customers') }}</h5>
                        <div class="table-responsive" id="table-users">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="fs-15 fw-500">{{ trans('labels.image') }}</th>
                                        <th class="fs-15 fw-500">{{ trans('labels.name') }}</th>
                                        <th class="fs-15 fw-500">{{ trans('labels.email') }}</th>
                                        <th class="fs-15 fw-500">{{ trans('labels.orders') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($topusers) > 0)
                                        @foreach (@$topusers as $user)
                                            <tr class="fs-7 fw-500 text-dark align-middle">
                                                <td>
                                                    <img src="{{ helper::image_path($user->image) }}"
                                                        class="rounded hw-50 object" alt="">
                                                </td>
                                                <td>
                                                    <div class="fs-7 fw-500">
                                                        <p>{{ $user->name }}</p>
                                                        <p>{{ $user->mobile }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $user->email }}
                                                </td>
                                                <td>
                                                    @php
                                                        $per =
                                                            $getbookingscount > 0
                                                                ? ($user->user_booking_counter * 100) /
                                                                    $getbookingscount
                                                                : 0;
                                                    @endphp
                                                    {{ number_format($per, 2) }}%
                                                    <div class="progress h-10-px">
                                                        <div class="progress-bar gradient-color {{ $ran[array_rand($ran, 1)] }}"
                                                            style="width: {{ $per }}%;" role="progressbar">
                                                            <span class="sr-only">{{ $per }}%
                                                                {{ trans('labels.orders') }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4">
                                                <h6 class="text-center fw-600">
                                                    {{ trans('labels.no_data_found') }}
                                                </h6>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <h5 class="card-title pb-3 border-bottom color-changer">
                        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                            {{ trans('labels.today_transaction') }}
                        @else
                            {{ trans('labels.today_bookings') }}
                        @endif
                    </h5>
                    <div class="table-responsive">
                        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                            @include('admin.admintransaction')
                        @else
                            @include('admin.booking.tablecommonview')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/chartjs/chart_3.9.1.min.js') }}"></script>
    <script>
        var revenue_chart = null;
        var piechart = null;
        var revenue_lables = {{ Js::from($revenue_lables) }};
        var revenue_data = {{ Js::from($revenue_data) }};
        var piechart_lables = {{ Js::from($piechart_lables) }};
        var piechart_data = {{ Js::from($piechart_data) }};
        var secondary_color = '{{ helper::appdata('')->secondary_color }}';
        var secondary_color_light = 'color-mix(in srgb, {{ helper::appdata('')->secondary_color }}, transparent 65%)';
        if (localStorage.getItem('theme') === 'dark') {
            var color = '#aab8c5';
            // var color = '#fff';
        } else {
            var color = '#737373';
            // var color = '#000';
        }

        function setClipboard(value) {
            var tempInput = document.createElement("input");
            tempInput.style = "position: absolute; left: -1000px; top: -1000px";
            tempInput.value = value;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            toastr.success("{{ session('success') }}", "Success");
        }
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/dashboard.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/booking.js') }}"></script>
@endsection
