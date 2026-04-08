@extends('landing.layout.default')

@section('content')
<!-- BREADCRUMB AREA START -->
<section class="breadcrumb-sec bg-light bg-changer">
    <div class="container">
        <nav aria-label="breadcrumb">
            {{-- <h3 class="breadcrumb-title fw-semibold mb-2 text-center">{{ trans('landing.our_stors') }}</h3> --}}
            <ol class="breadcrumb gap-2">
                <li class="{{ session()->get('direction') == 2 ? 'breadcrumb-item-rtl' : ' breadcrumb-item ' }}"><a
                        class="text-dark color-changer d-flex gap-2" href="{{ URL::to(@$vendordata->slug . '/') }}"><i class="fa-solid fa-house fs-7"></i>{{ trans('labels.home') }}</a>
                </li>
                <li class="text-muted d-flex gap-2 {{ session()->get('direction') == 2 ? 'breadcrumb-item-rtl' : ' breadcrumb-item ' }} active"
                    aria-current="page">{{ trans('landing.blog_details') }}</li>
            </ol>
        </nav>
    </div>
</section>
    <section>
        <div class="container">
            <div class="details-text">
                
                <img src="{{ helper::image_path($getblog->image) }}" class="img-fluid blog-details-img " alt="...">
                <div class="d-flex align-items-baseline pt-3">
                    <i class="fa-solid fa-calendar-days card-date"></i>
                    <p class="card-date px-2">{{ helper::date_formate($getblog->created_at,@$vendordata->id) }}</p>
                </div>
                <h6 class="blog-details-title fw-600 pb-3 pt-2 color-changer">
                    {{ $getblog->title }}
                </h6>
                <div class="cms-section">
                    <p class="details-footer text-muted fs-7 m-0" data-aos="fade-up" data-aos-darution="1000" data-aos-delay="100">
                        {!! $getblog->description !!}
                    </p>
                </div>

                <h5 class="recent-blogs-titel pt-5 pb-4 color-changer">{{ trans('landing.related_blogs') }}</h5>
            </div>
            <div class="owl-carousel blogs-slaider owl-theme pb-5">
                @include('landing.blogcommonview')
            </div>
            <div class="d-flex justify-content-center view-all-btn">
                <a href="{{URL::to('/blogs')}}" class="btn-secondary rounded-2">{{ trans('landing.view_all') }}
                </a>
            </div>
        </div>
    </section>
        <!-- subscription -->
        @include('landing.newslatter')
@endsection
