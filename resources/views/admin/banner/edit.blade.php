@php

    if (request()->is('admin/bannersection-1*')) {

        $section = 1;

        $title = trans('labels.section-1');

        $url = 'bannersection-1';

        $table_url = URL::to('admin/bannersection-1/');

    } elseif (request()->is('admin/bannersection-2*')) {

        $section = 2;

        $title = trans('labels.section-2');

        $url = 'bannersection-2';

        $table_url = URL::to('admin/bannersection-2/');

    } else {

        $section = 3;

        $title = trans('labels.section-3');

        $url = 'bannersection-3';

        $table_url = URL::to('admin/bannersection-3/');

    }

@endphp

@extends('admin.layout.default')

@section('content')

    @include('admin.breadcrumb.breadcrumb')

    <div class="row">

        <div class="col-12">

            <div class="card border-0 box-shadow">

                <div class="card-body">

                    <form action="{{ URL::to('admin/' . $url . '/update-' . $banner->id) }} " method="POST"

                        enctype="multipart/form-data">

                        @csrf

                        @if (str_contains(request()->url(), 'bannersection-1'))

                            <input type="hidden" name="section" value="1">

                        @endif

                        @if (str_contains(request()->url(), 'bannersection-2'))

                            <input type="hidden" name="section" value="2">

                        @endif

                        @if (str_contains(request()->url(), 'bannersection-3'))

                            <input type="hidden" name="section" value="3">

                        @endif

                      

                        <div class="row">

                            <div class="col-sm-6 form-group">

                                <label class="form-label">{{ trans('labels.type') }} <span class="text-danger"> *

                                    </span></label>

                                <select class="form-select type" name="type" required>

                                    <option value="0">{{ trans('labels.select') }} </option>

                                    <option value="1" {{ $banner->type == '1' ? 'selected' : '' }}>

                                        {{ trans('labels.category') }}</option>

                                    <option value="2" {{ $banner->type == '2' ? 'selected' : '' }}>

                                        {{ trans('labels.service') }}</option>

                                </select>

                               

                            </div>
                            
                            <div class="col-sm-6 form-group">
    
                                <label class="form-label">{{ trans('labels.image') }} <span class="text-danger">
    
                                        * </span></label>
    
                                <input type="file" class="form-control" name="image">
    
                                <img src="{{ helper::image_path($banner->image) }}" class="img-fluid rounded hw-50 mt-1"
    
                                    alt="">
    
                            </div>
                        </div>
                        {{-- <div class="row">


                        </div> --}}

                        <div class="row">

                            <div class="col-sm-6 form-group 1 selecttype">

                                <label class="form-label">{{ trans('labels.category') }}<span class="text-danger">

                                        *

                                    </span></label>

                                <select class="form-select" name="category" id="category">

                                    <option value="" selected>{{ trans('labels.select') }} </option>

                                    @foreach ($category as $item)

                                        <option

                                            value="{{ $item->id }}"{{ $item->id == $banner->category_id ? 'selected' : '' }}>

                                            {{ $item->name }} </option>

                                    @endforeach

                                </select>

                               

                            </div>

                            <div class="col-sm-6 form-group 2 selecttype">

                                <label class="form-label">{{ trans('labels.service') }}<span class="text-danger"> *

                                    </span></label>

                                <select class="form-select" name="service" id="service">

                                    <option value="" selected>{{ trans('labels.select') }} </option>

                                    @foreach ($service as $item)

                                        <option value="{{ $item->id }}"

                                            {{ $item->id == $banner->service_id ? 'selected' : '' }}>

                                            {{ $item->name }}</option>

                                    @endforeach

                                </select>

                               

                            </div>

                        </div>

                        

                        <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">

                            <a href="{{ URL::to('admin/' . $url) }}"

                                class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>

                            <button

                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif

                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_banners', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>

                        </div>

                </div>

                </form>

            </div>

        </div>

    </div>

@endsection

@section('scripts')

<script>

    @if (count($errors) > 0)

        @foreach ($errors->all() as $error)

            toastr.error("{{ $error }}");

        @endforeach

    @endif

</script>

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/banner.js') }}"></script>

@endsection

