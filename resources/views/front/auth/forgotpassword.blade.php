@extends('front.layout.auth_default')
@section('content')
    {{-- new design --}}
    <section class="forget-password">
        <div class="row m-0 vh-100">
            <div class="col-xl-7 col-lg-6 col-md-7 d-none d-lg-block p-0">
                <!------------- forget password form image ------------->
                <div class="left-side vh-100 d-flex justify-content-center align-items-center">
                    <img src="{{ helper::image_path(helper::appdata(@$vendordata->id)->auth_image) }}"
                        class="w-100 vh-100 object-fit-cover" alt="">
                </div>
                <!------------- forget password form image ------------->
            </div>
            <div class="col-xl-5 col-lg-6 col-md-7 col-12 vh-100 d-flex justify-content-center align-items-center m-auto">
                <div class="right-side row justify-content-center align-items-center w-100">
                    <div class="col-xl-7 col-lg-9 col-md-11 col-auto">
                        <!-------------------- forget password-title -------------------->
                        <div class="forget-password-title">
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
                            <h2 class="fw-bold mb-2 color-changer">{{ trans('labels.forgot_password') }}</h2>
                            <p class="text-muted">{{ trans('labels.remember_password') }}
                                <a href="{{ URL::to($vendordata->slug . '/login') }}"
                                    class="text-primary-color fw-semibold">{{ trans('labels.login') }}</a>
                            </p>
                        </div>
                        <!-------------------- forget password-title -------------------->
                        <form class="row my-3" method="POST" action="{{ URL::to($vendordata->slug . '/send_password') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email" class="form-label text-muted">{{ trans('labels.email') }} <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control input-h" name="email"
                                    placeholder="{{ trans('labels.email') }}" id="email" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <input type="hidden" class="form-control input-h" name="type" value="user">
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-primary w-100 btn-submit rounded"
                                    type="submit">{{ trans('labels.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        function AdminFill(email, password) {
            $('#email').val(email);
            $('#password').val(password);
        }
    </script>
@endsection
