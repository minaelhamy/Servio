@extends('front.layout.master')
@section('content')
    <div class="container">
        <div class="breadcrumb-div pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item "><a class="text-primary-color" href="{{ URL::to($vendordata->slug) }}"><i
                                class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.home') }}</a>
                    </li>
                    <li class="breadcrumb-item  active {{ session()->get('direction') == 2 ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">{{ trans('labels.terms_condition') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container">
        <h1 class="text-font section-title m-0 fw-bold fs-3">{{ trans('labels.terms_condition') }}</h1>
        @if (!empty($gettermscondition))
            <div class="cms-section py-4">
                {!! $gettermscondition !!}
            </div>
        @else
            @include('admin.layout.no_data')
        @endif
        <!-- question box start -->
        @include('front.contact.index')
        <!-- question box end -->
    </div>
@endsection
