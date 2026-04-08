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
                        aria-current="page">{{ trans('landing.terms_conditions') }}</li>
                </ol>
            </nav>
        </div>
    </section>
<section>
    <div class="about-us-bg-color">
        <div class="container">
            <div class="about-us-main">
                @if (!empty($terms->terms_content))
                    <div class="cms-section my-3">

                        {!! $terms->terms_content !!}

                    </div>
                @else
                    @include('admin.layout.no_data')
                @endif
            </div>
        </div>
    </div>
</section>

    <!-- subscription -->
    @include('landing.newslatter')
@endsection
