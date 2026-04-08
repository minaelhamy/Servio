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
                        aria-current="page">{{ trans('landing.faq_section_title') }}</li>
                </ol>
            </nav>
        </div>
    </section>
    <section>
        <div class="container faq-container faq">
            <div class="row mt-3">
                
                <div class="col-lg-7">
                    <div class="accordion" id="accordionExample">
                        @foreach ($allfaqs as $key => $faq)
                            <div class="accordion-item bg-transparent border-0 {{ $key == 0 ? 'pt-0' : 'pt-2' }}">
                                <h2 class="accordion-header border rounded" id="heading-{{ $key }}">
                                    <button
                                        class="{{ session()->get('direction') == 2 ? 'accordion-button-rtl text-end' : 'accordion-button text-start' }} shadow-none faq-btn-bg justify-content-between color-changer rounded m-0 {{ $key == 0 ? '' : 'collapsed' }}"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $key }}"
                                        aria-expanded="true" aria-controls="collapse-{{ $key }}">
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="collapse-{{ $key }}"
                                    class="accordion-collapse border rounded-2 collapse mt-2 {{ $key == 0 ? 'show' : '' }}"
                                    aria-labelledby="heading-{{ $key }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body bg-primary-rgb bg-changer rounded-1">
                                        <p class="faq-accordion-lorem-text color-changer pt-2 fs-7">
                                            {{ $faq->answer }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-5 d-lg-block d-none">
                    <img src="{{ @helper::image_path( helper::landingsettings()->faq_image) }}" alt=""
                        class="w-100 faq-img">
                </div>
            </div>
        </div>
    </section>
    <!-- subscription -->
    @include('landing.newslatter')  
@endsection
