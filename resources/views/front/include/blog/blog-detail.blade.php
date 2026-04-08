@extends('front.layout.master')
@section('content')
    <div class="container mb-2">
        <div class="breadcrumb-div pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL::to($vendordata->slug) }}" class="text-primary-color"><i class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2'}}"></i>{{ trans('labels.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active {{ session()->get('direction') == 2  ? 'breadcrumb-item-right' : 'breadcrumb-item-left'}}" aria-current="page">{{ trans('labels.blog-detail') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- new design --}}
    <section class="blog-section">
        <div class="container">
            <h2 class="text-font section-title fw-bold mb-4 fs-3">{{ trans('labels.blog_details') }}</h2>
            <div class="row g-4">
                {{-- image --}}
                <div class="col-12">
                    <img src="{{ helper::image_path($blogdetail->image) }}" class="blog-details-img rounded-4">
                </div>
                <div class="col-11 col-lg-10 mx-auto position-relative mt-n5 mt-sm-n7 mt-md-n8">
                    <div class="card shadow rounded-4 p-4">
                        <div class="col-auto">
                            <span class="text-muted fs-7"><i class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1'}}"></i>{{ helper::date_formate($blogdetail->created_at,$vendordata->id) }}</span>
                            <p class="fw-bold fs-4 m-0 color-changer border-0">{{ $blogdetail->title }}</p>
                            <p class="text-muted fs-15 m-0"> {!! strip_tags(Str::limit($blogdetail->description, 200)) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <div class="col-lg-10 mx-auto cms-section">
                <p class="blog-description-first fs-7">
                    {!! $blogdetail->description !!}
                </p>
            </div>
        </div>
    </section>
    @if ($getblog->count() > 0)
        <section class="latest-post my-5">
            <div class="container">
                <h3 class="text-font fw-bold color-changer">{{ trans('labels.latest-post') }}</h3>
                <div class="row g-3 pt-3">
                    @foreach ($getblog as $blog)
                    <div class="col-md-4">
                        <div class="card border-0 rounded-4 overflow-hidden w-100">
                            <div class="img-overlay rounded-4">
                                <img src="{{ helper::image_path($blog->image) }}" height="250"
                                    class="rounded-4 w-100 object-fit-cover" alt="...">
                            </div>
                            <div class="card-body">
                                <p class="mb-1 fw-normal text-muted fs-7"><i class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1'}}"></i> {{ helper::date_formate($blog->created_at,$vendordata->id) }}</p>
                                <div class="d-flex justify-content-between">
                                    <h5 class="fw-bold"><a class="text-dark color-changer service-cardtitle" href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ $blog->title }}</a></h5>
                                </div>
                                <small class="card-text text-muted m-0 fs-7 blog-description">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>
                            </div>
                            <div class="card-footer border-top-0 bg-transparent">
                                <div class="d-flex justify-content-end fs-7">
                                    <a class="fw-semibold text-primary-color" href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ trans('labels.readmore') }}<span
                                            class="mx-1"><i class="fa-regular fa-arrow-right"></i></span></a>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </section>
    @endif
    <div class="extra-margins"></div>
@endsection
