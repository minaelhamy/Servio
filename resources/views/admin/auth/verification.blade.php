@extends('admin.layout.auth_default')
@section('content')
<div class="wrapper">
    <section>
        <div class="row justify-content-center align-items-center g-0 w-100 h-100vh">
            <div class="col-xl-4 col-lg-6 col-sm-8 col-auto px-5">
                <div class="card box-shadow overflow-hidden border-0">
                    <div class="bg-primary-light">
                        <div class="row">
                            <div class="col-7 d-flex align-items-center">
                                <div class="text-primary p-4">
                                    <h4>{{ trans('labels.email_verification') }}</h4>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="{{helper::image_path('login-img.png')}}"
                                    class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="mt-3">
                            <p>{{ trans('labels.otp_note') }}</p>
                            <b>{{session()->get('email_verification')}}</b>
                        </div>
                        <form class="my-3" method="POST" action="{{ URL::to('/admin/otpverify') }}">
                            @csrf
                            <div class="form-group">
                                <label for="otp"
                                    class="form-label">{{ trans('labels.otp') }}<span class="text-danger"> * </span></label>
                                <input type="number" class="form-control" name="otp" id="otp"
                                    placeholder="{{ trans('labels.otp') }}">
                                @error('otp')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <button class="btn btn-primary w-100 my-3"
                                type="submit">{{ trans('labels.verify') }}</button>
                            <span
                                class="m-3 d-flex align-content-center align-items-center justify-content-center fw-bold"
                                id="timer"></span>
                            <div class="m-3 d-flex align-content-center align-items-center justify-content-center d-none"
                                id="resend">
                                <p class="fs-7 text-center mb-3 color-changer">{{ trans('labels.didnot_receive_otp') }}
                                    <a href="{{URL::to('/admin/resend_otp')}}"
                                        class="text-primary fw-semibold">{{ trans('labels.resend') }}</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('scripts')
<script src="{{ url(env('ASSETPATHURL').'admin-assets/js/verification.js') }}"></script>
@endsection