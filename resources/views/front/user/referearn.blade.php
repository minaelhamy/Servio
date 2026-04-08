@extends('front.layout.master')
@section('content')
    <link rel="stylesheet" href="{{ url(env('ASSETPATHURL') . 'front/social-sharing/css/socialsharing.css') }}">
    <!------ breadcrumb ------>
    <section class="breadcrumb-div pt-4">

        <div class="container">

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item text-dark">
                        <a class="text-primary-color" href="{{ URL::to($vendordata->slug . '/') }}">
                            <i class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>
                            {{ trans('labels.home') }}
                        </a>
                    </li>

                    <li class="breadcrumb-item  active {{ session()->get('direction') == '2' ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}" aria-current="page">
                        {{ trans('labels.refer_earn') }}
                    </li>

                </ol>

            </nav>

        </div>

    </section>
    <!------ breadcrumb ------>
    <section class="product-prev-sec product-list-sec">
        <div class="container">
            <h2 class="section-title fw-600">{{ trans('labels.account_details') }}</h2>
            <div class="user-bg-color mb-4">
                <div class="row g-3">
                    @include('front.user.commonmenu')
                    <div class="col-xl-9 col-lg-8 col-xxl-9 col-12">
                        <div class="card h-100 w-100 rounded-4 overflow-hidden">
                            <!------ Card header ------>
                            <div class="card-header bg-transparent color-changer border-bottom p-3 d-flex gap-3 align-items-center">
                                <i class="fa-regular fa-share-nodes fs-4"></i>
                                <h5 class="title m-0 fw-500">{{ trans('labels.refer_earn') }}</h5>
                            </div>
                            <div class="card-body user-content-wrapper">
                                <div class="d-flex flex-column align-items-center w-100">
                                    <img class="mb-4 refer-img w-100"
                                        src="{{ helper::image_path(helper::appdata($vendordata->id)->referral_image) }}">
                                    <h5 class="text-uppercase color-changer">{{ trans('labels.refer_earn') }}</h5>
                                    <p class="fs-7 text-center text-muted">{{ trans('labels.refer_note_1') }}
                                        {{ helper::currency_formate(@helper::appdata($vendordata->id)->referral_amount, $vendordata->id) }}
                                        {{ trans('labels.refer_note_2') }}</p>
                                    <div class="col-sm-9 col-12">
                                        <input type="url" class="form-control my-3 ref-padding bg-body-secondary"
                                            id="data"
                                            value="{{ URL::to($vendordata->slug . '/register?referral=' . Auth::user()->referral_code) }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="sharing-section d-flex align-items-center justify-content-center"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- newsletter -->
            @include('front.contact.index')
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ url(env('ASSETPATHURL') . 'front/social-sharing/js/socialsharing.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/referearn.js') }}"></script>
@endsection
