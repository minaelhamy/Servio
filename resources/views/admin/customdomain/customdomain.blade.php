@extends('admin.layout.default')
@section('content')
    @php
        $module = 'role_custom_domains';
    @endphp
    @include('admin.breadcrumb.breadcrumb')
    <div class="row mt-3">
        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
            @if (@helper::checkaddons('custom_domain'))
                @include('admin.customdomain.setting_form')
            @endif
        @endif
        <div class="col-12">
            <div class="card border-0 mb-3 box-shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                            @include('admin.customdomain.customdomain_table')
                        @endif
                        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                            @include('admin.customdomain.listcustomdomain_table')
                        @endif
                    </div>
                    @if (Auth::user()->type == 2)
                        <div class="card mt-4">
                            <div class="card-header color-changer border-bottom">
                                {{ $setting->cname_title }}
                            </div>
                            <div class="card-body">
                                <p class="card-text text-muted"> {!! $setting->cname_text !!}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
