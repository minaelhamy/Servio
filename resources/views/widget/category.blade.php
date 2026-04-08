@extends('widget.layout.default')
@section('content')
    <!--==================================== Category section start ====================================-->
    <form action="{{ URL::to('/' . $vendordata->slug . '/embedded/services') }}" method="get">
        <div class="category main active">
            <div class="header">
                <span class="fw-bold active header-title">{{ trans('labels.select_category') }}</span>
            </div>
            <div class="row g-3 main-specing">
                @foreach ($getcategories as $key => $category)
                    <div class="col-lg-3 col-md-6 col-6">
                        @php
                            $cat_id ="";
                        @endphp
                        <input type="radio" class="chekcat d-none" name="category" id="cat-{{ $key }}"
                            value="{{ $category->slug }}" {{ session()->get('embedded_category') == $category->slug ? 'checked' : ''}} data-value="{{ URL::to('/' . $vendordata->slug . '/embedded/services?category='. $category->slug) }}"/>
                        <label for="cat-{{ $key }}" class="card-selectlabel">
                            <div class="card h-100 border-0 shadow py-3 m-0">
                                <div class="loc_img m-auto">
                                    <img src="{{ helper::image_path($category->image) }}" alt="" class="w-100">
                                </div>
                                <div class="card-body mt-3 card-flex p-0">
                                    <span class="sub_title fw-500 fs-7 d-block text-center"> {{ $category->name }}</span>
                                    <p class="title text-center m-0 category-sec-p"> {{ trans('labels.services') }}
                                        {{ helper::service_count($category->id) . '+' }}</p>
                                </div>
                            </div>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <!--================================== footer section start ====================================-->
        <div class="footer">
            {{-- <div class="d-flex justify-content-end"> --}}
                <a href="" class="btn btn-outline-primary px-4 back_button d-none">{{ trans('labels.back') }}</a>
                <button type="submit" class="btn btn-secondary px-4 next_button">{{ trans('labels.next_step') }}</button>
            {{-- </div> --}}
        </div>
        <!--==================================== footer section end ====================================-->
    </form>
  
    <!--==================================== Category section start ====================================-->
@endsection
@section('scripts')
    <script>
        $('input[type=radio][name=category]').on('change',function() {
            "use strict";
            var slug = $(this).val();
            location.href = "{{ URL::to('/' . $vendordata->slug . '/embedded/services?category=') }}"+slug;
});
$('.next_button').on('click',function(){
    "use strict";
    var select_category = "{{trans('messages.select_category')}}";
   if($("input[type='radio'][name='category']:checked").length == 0)
   {
        toastr.error(select_category);
        return false;
   } 
});
    </script>
@endsection

