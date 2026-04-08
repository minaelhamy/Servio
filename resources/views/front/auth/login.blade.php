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
                    <div class="col-xl-7 col-lg-9 col-md-11 col-auto">
                        <!-------------------- login-title -------------------->
                        <div class="login-title">
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
                            <h2 class="fw-bold mb-2 color-changer">{{ trans('labels.welcome_back') }}</h2>
                            <p class="text-muted">{{ trans('labels.dont_have_account') }}
                                <a href="{{ URL::to($vendordata->slug . '/register') }}"
                                    class="text-primary-color fw-semibold">{{ trans('labels.register') }}</a>
                            </p>
                        </div>
                        <!-------------------- login-title -------------------->

                        <!-------------------- login form -------------------->
                        <form class="row my-3" method="POST"
                            action="{{ URL::to($vendordata->slug . '/checklogin-normal') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="form-label text-muted">{{ trans('labels.email') }} <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control input-h" name="email"
                                    placeholder="{{ trans('labels.email') }}" id="email"
                                    @if (env('Environment') == 'sendbox') value="user@yopmail.com" @endif required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label text-muted">{{ trans('labels.password') }}
                                    <span class="text-danger">*</span></label>
                                <input type="password" class="form-control input-h" name="password"
                                    placeholder="{{ trans('labels.password') }}" id="password"
                                    @if (env('Environment') == 'sendbox') value="123456" @endif required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="hidden" class="form-control input-h" name="type" value="user">
                            <div class="mb-3 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                <a href="{{ URL::to($vendordata->slug . '/forgotpassword') }}"
                                    class="text-dark color-changer fs-7 fw-500">
                                    <i class="fa-solid fa-lock mx-2 fs-7"></i>{{ trans('labels.forgot_password') }}
                                </a>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary w-100 btn-submit rounded"
                                    type="submit">{{ trans('labels.login') }}</button>
                            </div>
                        </form>
                        <!-------------------- login form -------------------->

                        <!-------------------- social login -------------------->
                        @if (@helper::checkaddons('subscription'))
                            @if (@helper::checkaddons('google_login'))
                                @php
                                    $checkplan = App\Models\Transaction::where('vendor_id', $vendordata->id)
                                        ->orderByDesc('id')
                                        ->first();

                                    if ($vendordata->allow_without_subscription == 1) {
                                        $google_login = 1;
                                    } else {
                                        $google_login = @$checkplan->google_login;
                                    }

                                @endphp
                                @if ($google_login == 1)
                                    <div class="">
                                        @if (helper::appdata($vendordata->id)->google_mode == 1)
                                            <a @if (env('Environment') == 'sendbox') onclick="myFunction()" @else href="{{ URL::to($vendordata->slug . '/login/google-user') }}" @endif
                                                class="btn btn-light mb-4 rounded"><i
                                                    class="fa-brands fa-google text-google-icon mx-2"></i>{{ trans('labels.sign_in_with_google') }}</a>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        @else
                            @if (@helper::checkaddons('google_login'))
                                <div class="">
                                    @if (helper::appdata($vendordata->id)->google_mode == 1)
                                        <a @if (env('Environment') == 'sendbox') onclick="myFunction()" @else href="{{ URL::to($vendordata->slug . '/login/google-user') }}" @endif
                                            class="btn btn-light mb-4 border"><i
                                                class="fa-brands fa-google text-google-icon mx-2"></i>{{ trans('labels.sign_in_with_google') }}</a>
                                    @endif
                                </div>
                            @endif
                        @endif

                        @if (@helper::checkaddons('subscription'))
                            @if (@helper::checkaddons('facebook_login'))
                                @php
                                    $checkplan = App\Models\Transaction::where('vendor_id', $vendordata->id)
                                        ->orderByDesc('id')
                                        ->first();

                                    if ($vendordata->allow_without_subscription == 1) {
                                        $facebook_login = 1;
                                    } else {
                                        $facebook_login = @$checkplan->facebook_login;
                                    }

                                @endphp
                                @if ($facebook_login == 1)
                                    <div class="">
                                        @if (helper::appdata($vendordata->id)->facebook_mode == 1)
                                            <a @if (env('Environment') == 'sendbox') onclick="myFunction()" @else href="{{ URL::to($vendordata->slug . '/login/facebook-user') }}" @endif
                                                class="btn btn-light rounded"><i
                                                    class="fa-brands fa-facebook-f text-facebook mx-2"></i>{{ trans('labels.sign_in_with_facebook') }}</a>
                                        @endif
                                    </div>
                                @endif
                            @endif
                        @else
                            @if (@helper::checkaddons('facebook_login'))
                                <div class="">
                                    @if (helper::appdata($vendordata->id)->facebook_mode == 1)
                                        <a @if (env('Environment') == 'sendbox') onclick="myFunction()" @else href="{{ URL::to($vendordata->slug . '/login/facebook-user') }}" @endif
                                            class="btn btn-light border"><i
                                                class="fa-brands fa-facebook-f text-facebook mx-2"></i>{{ trans('labels.sign_in_with_facebook') }}</a>
                                    @endif
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
