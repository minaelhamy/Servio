@extends('widget.layout.default')
@section('content')
    <form action="{{ URL::to('/' . $vendordata->slug . '/embedded/datetime') }}" method="get">
        <div class="main">
            <div class="header">
                <span class="fw-bold active header-title">{{ trans('labels.select_service') }}</span>
            </div>
            <div class="row g-3 align-items-center justify-content-between main-specing" id="service">
                @foreach ($getservices as $key => $service)
             
                    <div class="col-sm-6 d-flex">
                        <input type="radio" class="chekcard d-none" name="service" id="service{{ $key }}"
                            {{ session()->get('embedded_service') == $service->slug ? 'checked' : '' }}
                            value="{{ $service->slug }}"
                            data-value="{{ URL::to('/' . $vendordata->slug . '/embedded/datetime?service=' . $service->slug) }}" />
                        <label for="service{{ $key }}" class="card-selectlabel h-100">
                            <div class="card h-100 border-0 shadow m-0">
                                <div class="d-flex g-0">
                                    <div class="col-4">
                                        <img src="{{ helper::image_path($service['service_image']->image) }}"
                                            class="w-100 h-100 img-fluid rounded-start" alt="...">
                                    </div>
                                    <div class="col-8">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $service->name }}</h5>
                                            @php
                                            $category = helper::getcategoryinfo($service->category_id, $service->vendor_id);
                                        @endphp
                                            <p class="card-text text-muted cat-name">{{ $category[0]->name }}
                                            </p>
                                            <p class="card-text m-0 fs-7 fw-semibold">
                                                {{ helper::currency_formate($service->price, $vendordata->id) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <!--================================== footer section start ====================================-->
        <div class="footer">
            {{-- <div class="d-flex justify-content-between"> --}}
                <a href="{{ URL::to('/' . $vendordata->slug . '/embedded') }}"
                    class="btn btn-outline-primary px-4 back_button">{{ trans('labels.back') }}</a>
                <button type="submit" class="btn btn-secondary px-4 next_button">{{ trans('labels.next_step') }}</button>
            {{-- </div> --}}
        </div>
        <!--==================================== footer section end ====================================-->
    </form>
@endsection
@section('scripts')
    <script>
        $('input[type=radio][name=service]').on('change', function() {
            "use strict";
            var slug = $(this).val();
            location.href = "{{ URL::to('/' . $vendordata->slug . '/embedded/datetime?service=') }}" + slug;
        });
        $('.next_button').on('click', function() {
            "use strict";
            var select_service = "{{ trans('messages.select_service') }}";
            if ($("input[type='radio'][name='service']:checked").length == 0) {
                toastr.error(select_service);
                return false;
            }
        });
    </script>
@endsection
