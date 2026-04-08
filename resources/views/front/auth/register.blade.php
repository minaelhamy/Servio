@extends('front.layout.auth_default')
@section('content')
    {{-- new design --}}
    <section class="register">
        <div class="row m-0 vh-100">
            <div class="col-xl-7 col-lg-6 col-md-7 d-none d-lg-block p-0">
                <!------------- register form image ------------->
                <div class="left-side vh-100 d-flex justify-content-center align-items-center">
                    <img src="{{ helper::image_path(helper::appdata(@$vendordata->id)->auth_image) }}"
                        class="w-100 vh-100 object-fit-cover" alt="">
                </div>
                <!------------- register form image ------------->
            </div>
            <div
                class="col-xl-5 col-lg-6 col-md-7 col-12 vh-100 d-flex justify-content-center align-items-center m-auto overflow-y-scroll">
                <div class="right-side vh-100 row justify-content-center align-items-center w-100">
                    <div class="col-xl-7 col-lg-9 col-md-11 col-auto px-3">
                        <!-------------------- register-title -------------------->
                        <div class="register-title">
                            <script>
                                document.addEventListener("DOMContentLoaded", function(event) {
                                    if (localStorage.getItem('theme') === 'dark') {
                                        var logo = "{{ helper::image_path(helper::appdata($vendordata->id)->darklogo) }}";
                                    } else {
                                        var logo = "{{ helper::image_path(helper::appdata($vendordata->id)->logo) }}";
                                    }
                                    $('#logoimage').attr('src', logo);
                                });
                            </script>
                            <a href="{{ URL::to($vendordata->slug) }}" class="logo p-0">
                                <img src="" alt="" class="mb-2 login-imag object-fit-cover" id="logoimage">
                            </a>
                            <h2 class="fw-bold mb-2 color-changer">{{ trans('labels.create_new_account') }}</h2>
                            <p class="text-muted">{{ trans('labels.already_have_an_account') }}
                                <a href="{{ URL::to($vendordata->slug . '/login') }}"
                                    class="text-primary-color fw-semibold">{{ trans('labels.login') }}</a>
                            </p>
                        </div>
                        <!-------------------- register-title -------------------->

                        <!-------------------- register form -------------------->
                        <form class="row my-3" method="POST"
                            action="{{ URL::to($vendordata->slug . '/register_customer') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name" class="form-label text-muted">{{ trans('labels.name') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control input-h" name="name"
                                    value="{{ old('name') }}" id="name" placeholder="{{ trans('labels.name') }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label text-muted">{{ trans('labels.email') }} <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control input-h" name="email"
                                    value="{{ old('email') }}" id="email" placeholder="{{ trans('labels.email') }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="mobile" class="form-label text-muted">{{ trans('labels.mobile') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control input-h" name="mobile"
                                    value="{{ old('mobile') }}" id="mobile" placeholder="{{ trans('labels.mobile') }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label text-muted">{{ trans('labels.password') }} <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control input-h" name="password"
                                    value="{{ old('password') }}" id="password"
                                    placeholder="{{ trans('labels.password') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="referral_code"
                                    class="form-label text-muted">{{ trans('labels.referral_code') }}</label>
                                <input type="text" class="form-control input-h" name="referral_code"
                                    value="{{ @$_GET['referral'] }}" id="referral_code"
                                    placeholder="{{ trans('labels.referral_code_op') }}">
                            </div>
                            <div class="form-group">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked"
                                    checked="">
                                <label class="form-check-label color-changer"
                                    for="flexCheckChecked">{{ trans('labels.i_accept_the') }}
                                    <a href="{{ URL::to('/termscondition') }}"
                                        class="text-primary fw-semibold">{{ trans('labels.terms_condition') }}</a>
                                </label>
                            </div>

                            @include('landing.layout.recaptcha')

                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary w-100 mt-3 btn-submit rounded"
                                    type="submit">{{ trans('labels.register') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
