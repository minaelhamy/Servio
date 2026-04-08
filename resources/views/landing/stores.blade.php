@extends('landing.layout.default')
@section('content')
    <!-- BREADCRUMB AREA START -->
    <section class="breadcrumb-sec m-0 bg-light bg-changer">
        <div class="container">
            <nav aria-label="breadcrumb">
                {{-- <h3 class="breadcrumb-title fw-semibold mb-2 text-center">{{ trans('landing.our_stors') }}</h3> --}}
                <ol class="breadcrumb gap-2">
                    <li class="{{ session()->get('direction') == 2 ? 'breadcrumb-item-rtl' : ' breadcrumb-item ' }}"><a
                            class="text-dark color-changer d-flex gap-2" href="{{ URL::to(@$vendordata->slug . '/') }}"><i class="fa-solid fa-house fs-7"></i>{{ trans('labels.home') }}</a>
                    </li>
                    <li class="text-muted d-flex gap-2 {{ session()->get('direction') == 2 ? 'breadcrumb-item-rtl' : ' breadcrumb-item ' }} active"
                        aria-current="page">{{ trans('landing.our_stors') }}</li>
                </ol>
            </nav>
        </div>
    </section>
    {{-- <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="http://192.168.29.166/dhruvildesai/BookingDo/theme-8" class="text-primary-color">Home</a>
        </li>
        <li class="breadcrumb-item active breadcrumb-item-left" aria-current="page">Categories</li>
    </ol> --}}
    <!-- slaider-section start -->
    <section>
        <div class="owl-carousel hotels-slaider owl-theme">
            @foreach ($banners as $banner)
                <a href="{{ URL::to('/' . $banner['vendor_info']->slug) }}" target="_blank">
                    <div class="item item-1">
                        <img src="{{ helper::image_path($banner->image) }}" class="mg-fluid">
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    <!-- slaider-section end -->
    <!--card-section start -->
    <section>
        <div class="container">

            {{-- <form action="{{ URL::to('/stores') }}" method="get">
                <div class="row d-flex justify-content-center align-items-center my-4">
                    <div>

                        <div class="card shadow w-100 p-3 border-0 d-flex">
                            <div class="row">
                            <div class="col-4">
                                    <div class="select-input-box">
                                        <label for="city" class="form-lables mb-1 hotel-label">{{ trans('landing.store_category') }}</label>
                                        <select name="store" class="form-select" id="store">
                                            <option value="">{{ trans('landing.select') }}</option>
                                            @foreach ($storecategory as $store)
                                            <option value="{{$store->name}}"  {{ request()->get('store') == $store->name ? 'selected' : '' }}>{{$store->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label for="country" class="form-lables mb-1 hotel-label">{{ trans('landing.city') }}</label>
                                    <select name="country" class="form-select" id="country">
                                        <option value=""
                                            data-value="{{ URL::to('/stores?country=' . '&city=' . request()->get('city')) }}"
                                            data-id="0" selected>{{ trans('landing.select') }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->name }}"
                                                data-value="{{ URL::to('/stores?country=' . request()->get('country') . '&city=' . request()->get('city')) }}"
                                                data-id={{ $country->id }}
                                                {{ request()->get('country') == $country->name ? 'selected' : '' }}>
                                                {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <div class="select-input-box">
                                        <label for="city" class="form-lables mb-1 hotel-label">{{ trans('landing.area') }}</label>
                                        <select name="city" class="form-select" id="city">
                                            <option value="">{{ trans('landing.select') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mt-4">
                                <label class="form-lables mb-1 hotel-label"></label>
                                <button type="submit" class="btn btn-primary  btn-class">{{ trans('landing.submit') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form> --}}

            <form action="{{ URL::to('/stores') }}" method="get">
                <div class="row d-flex justify-content-center align-items-center my-4">
                    <div>
                        <div class="card bg-changer shadow w-100 p-3 border-0 d-flex">
                            <div class="row g-3">
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="select-input-box">
                                        <label for="city"
                                            class="form-label mb-1 hotel-label">{{ trans('landing.store_category') }}</label>
                                        <select name="store" class="form-select py-2" id="store">
                                            <option value="">{{ trans('landing.select') }}</option>
                                            @foreach ($storecategory as $store)
                                                <option value="{{ $store->name }}"
                                                    {{ request()->get('store') == $store->name ? 'selected' : '' }}>
                                                    {{ $store->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <label for="country"
                                        class="form-label mb-1 hotel-label">{{ trans('landing.city') }}</label>
                                    <select name="country" class="form-select py-2" id="country">
                                        <option value=""
                                            data-value="{{ URL::to('/stores?country=' . '&city=' . request()->get('city')) }}"
                                            data-id="0" selected>{{ trans('landing.select') }}</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->name }}"
                                                data-value="{{ URL::to('/stores?country=' . request()->get('country') . '&city=' . request()->get('city')) }}"
                                                data-id={{ $country->id }}
                                                {{ request()->get('country') == $country->name ? 'selected' : '' }}>
                                                {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="select-input-box">
                                        <label for="city"
                                            class="form-label mb-1 hotel-label">{{ trans('landing.area') }}</label>
                                        <select name="city" class="form-select py-2" id="city">
                                            <option value="">{{ trans('landing.select') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-12 d-flex flex-column justify-content-end">
                                    <label class="form-label mb-1 hotel-label"></label>
                                    <button type="submit"
                                        class="btn btn-secondary py-2 m-0 w-100 btn-class">{{ trans('landing.submit') }}</button>
                                </div>
                            </div>
                            {{-- <div class="d-flex align-items-center justify-content-center mt-4">
                                <label class="form-lables mb-1 hotel-label"></label>
                                
                            </div> --}}
                        </div>
                    </div>
                </div>
            </form>

            @if ($stores->count() > 0)
                <div class="title-restaurant text-center mt-5 mb-5">
                    @if (!empty(request()->get('city')) && request()->get('city') != null)
                        <h5>{{ trans('landing.stores_in') }} {{ @$city_name }}</h5>
                    @endif
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-md-4 g-3">
                    @foreach ($stores as $store)
                        <div class="col">
                            <a href="{{ URL::to('/' . $store->slug) }}" target="_blank">
                                {{-- <div class="card h-100 rounded-2 overflow-hidden view-all-hover">
                                    <img src="{{ helper::image_path(@helper::appdata($store->id)->cover_image) }}"
                                        class="card-img-top rounded-0 object-fit-cover object-fit-cover"
                                        alt="..." height="260">
                                    <div class="card-body px-sm-3 px-2">
                                        <h6 class="card-title fs-6 m-0 fw-semibold hotel-title">
                                            {{ @helper::appdata($store->id)->web_title }}
                                        </h6>
                                    </div>
                                </div> --}}
                                <div class="post-slide h-100 card border-0">
                                    <div class="post-img rounded-3 overflow-hidden">
                                        <span class="over-layer">
                                        </span>
                                        <img src="{{ helper::image_path(@helper::appdata($store->id)->cover_image) }}" alt="">
                                    </div>
                                    <div class="card-body pt-3 p-0">
                                        <h3 class="fs-6 post-title text-capitalize fw-600 line-2 m-0 color-changer">
                                            {{ @helper::appdata($store->id)->web_title }}
                                        </h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-3">

                    {!! $stores->links() !!}

                </div>
            @else
                @include('admin.layout.no_data')
            @endif
        </div>
    </section>
    <!--card-section end-->

    <!-- subscription -->
    @include('landing.newslatter')
@endsection
@section('scripts')
    <script>
        var cityurl = "{{ URL::to('admin/getcity') }}";
        var select = "{{ trans('landing.select') }}";
        var cityname = "{{ request()->get('city') }}";
    </script>
    <script src="{{ url(env('ASSETPATHURL') . '/landing/js/store.js') }}"></script>
@endsection
