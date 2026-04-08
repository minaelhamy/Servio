@extends('front.layout.master')
@section('content')
    <div class="container">
        <div class="breadcrumb-div pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a class="text-primary-color" href="{{ URL::to($vendordata->slug) }}"><i
                                class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.home') }}</a>
                    </li>
                    <li class="breadcrumb-item  active {{ session()->get('direction') == 2 ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">{{ trans('labels.help_contact') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container contact-us">
        <!---------------------------- contact title ---------------------------->
        <h2 class="section-title fw-bold fs-3">{{ trans('labels.help_contact') }}</h2>
        <!---------------------------- contact title ---------------------------->

        <!---------------------------- contact info ---------------------------->
        <div class="row py-4 g-4">
            <div class="col-xl-4 col-lg-6 col-sm-6">
                <a class="text-dark" href="mailto:{{ $contactinfo->email }}">
                    <div class="card border-0 box-shadow rounded p-3 h-100 text-center">
                        <div class="icon-lg bg-info bg-opacity-10 text-info rounded-circle mb-3 mx-auto"><i
                                class="fa-solid fa-envelope fs-5"></i></div>
                        <h5 class="fw-bold color-changer">{{ trans('labels.email') }}</h5>
                        <p class="mb-0"><a href="mailto:{{ $contactinfo->email }}"
                                class="text-muted">{{ $contactinfo->email }}</a></p>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6 col-sm-6">
                <a class="text-dark" href="tel:{{ $contactinfo->mobile }}">
                    <div class="card border-0 box-shadow rounded p-3 h-100 text-center">
                        <div class="icon-lg bg-danger bg-opacity-10 text-danger rounded-circle mb-3 mx-auto"><i
                                class="fa-solid fa-phone fs-5"></i></div>
                        <h5 class="fw-bold color-changer"><span class="text-primary-color me-2"></span>{{ trans('labels.mobile') }}</h5>
                        <p class="mb-0"><a href="tel:{{ $contactinfo->mobile }}"
                                class="text-muted">{{ $contactinfo->mobile }}</a></p>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-lg-6 col-sm-6">
                <div class="card border-0 box-shadow rounded p-3 h-100 text-center">
                    <div class="icon-lg bg-warning bg-opacity-10 text-warning rounded-circle mb-3 mx-auto"><i
                            class="fa-solid fa-location-dot fs-5"></i></div>
                    <h5 class="fw-bold color-changer"><span class="text-primary-color me-2"></span>{{ trans('labels.address') }}</h5>
                    <p class="mb-0 text-muted">
                        {{ empty($contactinfo->address) ? '-' : $contactinfo->address }}
                    </p>
                </div>
            </div>
           
        </div>
        <!---------------------------- contact info ---------------------------->
        <!--------- contact details --------->
        <div class="row g-4 g-lg-5 align-items-center py-lg-5 py-0">
            <div class="col-lg-6 order-2 order-lg-0">
                <div class="card border-0 rounded shadow-sm bg-lights p-4 mb-3">
                    <form method="POST" action="{{ URL::to($vendordata->slug . '/submit') }}">
                        @csrf
                        <div class="row">
                            <h2 class="fw-bold fs-3 color-changer">{{ trans('labels.send_us_message') }}</h2>
                        </div>
                        <div class="row">
                            <input type="hidden" name="vendor_id" value="{{ $vendordata->id }}">
                            <div class="col-md-6 form-group">
                                <label class="form-label text-muted">{{ trans('labels.first_name') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="fname"
                                    placeholder="{{ trans('labels.first_name') }}" required>
                                @error('fname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label text-muted">{{ trans('labels.last_name') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="lname"
                                    placeholder="{{ trans('labels.last_name') }}" required>
                                @error('lname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label text-muted">{{ trans('labels.email') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="email"
                                    placeholder="{{ trans('labels.email') }}" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="form-label text-muted">{{ trans('labels.mobile') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control mobile-number" name="mobile"
                                    placeholder="{{ trans('labels.mobile') }}" required>
                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label text-muted">{{ trans('labels.message') }}</label>
                                <textarea class="form-control" rows="3" name="message" placeholder="{{ trans('labels.message') }}"></textarea>
                                @error('message')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @include('landing.layout.recaptcha')
                        <div class="d-flex">
                            <button type="submit" name="submit"
                                class="btn btn-primary w-100 mt-3 btn-submit rounded">{{ trans('labels.send_message') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{helper::image_path(helper::appdata($vendordata->id)->contact_image)}}"
                    alt="" class="w-100 object-fit-cover">
            </div>
        </div>
        <!--------- contact details --------->

        <!---------------------------------------------------- subscription popup ---------------------------------------------------->
        
        <!---------------------------------------------------- subscription popup ---------------------------------------------------->
    </div>
    @include('front.subscribe.index')
    <div class="extra-margins"></div>
@endsection
@section('scripts')
    <!-- IF VERSION 2  -->
    @if (helper::appdata('')->recaptcha_version == 'v2')
        <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif
    <!-- IF VERSION 3  -->
    @if (helper::appdata('')->recaptcha_version == 'v3')
        {!! RecaptchaV3::initJs() !!}
    @endif
@endsection
