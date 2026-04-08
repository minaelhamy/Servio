@extends('front.layout.master')

@section('content')

    <div class="container">

        <div class="breadcrumb-div pt-4">

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item"><a href="{{ URL::to($vendordata->slug) }}" class="text-primary-color"><i
                                class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.home') }}</a>

                    </li>

                    <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">{{ trans('labels.blog') }}</li>

                </ol>

            </nav>

        </div>

    </div>

    @if ($getblog->count() > 0)
        <section class="mb-4 blog-sec">

            <div class="container">

                <h2 class="text-font section-title fw-bold fs-3">{{ trans('labels.latest-post') }}</h2>

                <div class="row py-4 g-3">

                    @foreach ($getblog as $blog)
                        <div class="col-md-4">

                            <div class="card border-0 rounded-4 overflow-hidden w-100 h-100">

                                <div class="img-overlay rounded-4">

                                    <img src="{{ helper::image_path($blog->image) }}" height="250"
                                        class="rounded-4 w-100 object-fit-cover" alt="...">

                                </div>

                                <div class="card-body">
                                    <p class="mb-1 fw-normal text-muted fs-7"><i
                                            class="fa-solid fa-calendar-days {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"></i>
                                        {{ helper::date_formate($blog->created_at, $vendordata->id) }}</p>
                                    <div class="d-flex justify-content-between">
                                        <h5 class="fw-bold">
                                            <a class="text-dark service-cardtitle color-changer"
                                                href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">
                                                {{ $blog->title }}
                                            </a>
                                        </h5>
                                    </div>

                                    <small class="card-text text-muted m-0 blog-description">{!! strip_tags(Str::limit($blog->description, 200)) !!}</small>

                                </div>

                                <div class="card-footer border-top-0 bg-transparent">

                                    <div class="d-flex justify-content-end">

                                        <a class="fw-semibold text-primary-color fs-7"
                                            href="{{ URL::to($vendordata->slug . '/blog-' . $blog->slug) }}">{{ trans('labels.readmore') }}<span
                                                class="mx-1"><i class="fa-regular fa-arrow-right"></i></span></a>

                                    </div>



                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

                <div class="d-flex justify-content-center mt-3">

                    {!! $getblog->links() !!}

                </div>

                <!---------------------------------------------------- subscription popup ---------------------------------------------------->
                @include('front.subscribe.index')
                <!---------------------------------------------------- subscription popup ---------------------------------------------------->

            </div>

        </section>
    @else
        @include('admin.layout.no_data')
    @endif

@endsection
