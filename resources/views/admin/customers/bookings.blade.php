@extends('admin.layout.default')
@section('content')
    <h5 class="text-capitalize fw-600 fs-4 color-changer">
        {{ $userinfo->name }}
    </h5>
    @include('admin.booking.statistics')
    <div class="row ">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    @include('admin.booking.tablecommonview')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/booking.js') }}"></script>
@endsection
