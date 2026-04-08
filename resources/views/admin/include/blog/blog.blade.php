@extends('admin.layout.default')
@section('content')
    @php
        $module = 'role_blogs';
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
    @endphp
    @include('admin.breadcrumb.breadcrumb')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 mb-3 box-shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        @include('admin.include.blog.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
