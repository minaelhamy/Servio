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
                        aria-current="page">{{ trans('labels.faqs') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!---------------------------------------------------- FAQ section start ---------------------------------------------------->
    <section class="faq">
        <div class="container">
            <!-- faq section -->
            <h2 class="section-title fw-bold fs-3">{{ trans('labels.frequently_asked_question') }}</h2>
            @if ($faqs->count() > 0)
                <div class="accordion accordion-icon accordion-bg-light py-4" id="accordionExample2">
                    @foreach ($faqs as $key => $faq)
                        <!-- Item -->
                        <div class="accordion-item bg-transparent border-0 mb-3">
                            <h6 class="accordion-header font-base color-changer" id="heading-{{ $key }}">
                                <button class="accordion-button border shadow-none faq_color_changer {{ session()->get('direction') == 2 ? 'rtl text-end' : 'text-start' }} fw-semibold rounded d-inline-block" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse-{{ $key }}"
                                    aria-expanded="false" aria-controls="collapse-{{ $key }}">
                                    {{ $faq->question }}
                                </button>
                            </h6>
                            <!-- Body -->
                            <div id="collapse-{{ $key }}" class="accordion-collapse collapse"
                                aria-labelledby="heading-{{ $key }}" data-bs-parent="#accordionExample2">
                                <div class="accordion-body bg-primary-rgb rounded text-muted mt-3">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                @include('admin.layout.no_data')
            @endif
            <!-- question box start -->
            @include('front.contact.index')
            <!-- question box end -->
        </div>
    </section>
    <!----------------------------------------------------- FAQ section end ----------------------------------------------------->
@endsection
