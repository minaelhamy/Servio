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
                        aria-current="page">{{ trans('labels.categories') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- service listing section -->
    <section class="categorylist">
        <div class="container">
            <h2 class="section-title fw-bold fs-3">{{ trans('labels.see_all_category') }}</h2>
            @if ($categories->count() > 0)
                <!-- dropdown div -->
                <div class="contain py-4">
                    <div class="row g-3 category-carousel category-slide">
                        @foreach ($categories as $category)
                            <div class="col-xl-2 col-md-3 responsive-col">
                                <a
                                    href="{{ URL::to($vendordata->slug . '/services?category=' . $category->slug . '&search_input=') }}">
                                    <div
                                        class="card shadow border-0 rounded-4 h-100 text-center align-items-center">
                                        <div class="card-body">
                                            <div class="icon-xl rounded-circle mb-2 mx-auto">
                                                <img src="{{ helper::image_path($category->image) }}" class="card-img-top"
                                                    alt="">
                                            </div>
                                            <div class="mt-2">
                                                <p class="mb-1 text-center text-dark color-changer fw-bold line-1">
                                                    {{ $category->name }}</p>
                                            </div>
                                            <P class="text-center fs-7 text-primary-color m-0">
                                                {{ trans('labels.services') }}
                                                {{ helper::service_count($category->id) . '+' }} </P>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!---------------------------------------------------- subscription popup ---------------------------------------------------->
                @include('front.subscribe.index')
                <div class="extra-margins"></div>
                <!---------------------------------------------------- subscription popup ---------------------------------------------------->
            @else
                @include('admin.layout.no_data')
            @endif
        </div>
    </section>
    <!-- service listing section -->
@endsection
