@extends('admin.layout.auth_default')
@section('content')
    <section>
        <div class="row align-items-center g-0 w-100 h-100vh position-relative">
            <div class="col-md-5 d-md-block d-none">
                <div class="login-left-content">
                    <img src="{{ helper::image_path(helper::appdata('')->logo) }}" class="logo-img" alt="">
                </div>
            </div>
            <div class="col-md-7 overflow-hidden">
                <div class="login-right-content login-forgot-padding row">
                    <div class="p-0">
                        <div class="text-primary d-flex justify-content-between">
                            <div>
                                <h2 class="fw-600 title-text text-color color-changer">License verification</h2>
                            </div>
                        </div>
                        
                        <form method="POST" class="mt-5 mb-5 login-input" action="{{ route('admin.systemverification') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" required autocomplete="username" autofocus placeholder="Enter Envato username">
                            </div>
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="form-group mb-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" equired autocomplete="email" autofocus placeholder="Email">
                            </div>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <div class="form-group mb-3">
                                <input id="purchase_key" type="text" class="form-control @error('purchase_key') is-invalid @enderror" name="purchase_key" required autocomplete="current-purchase_key" placeholder="Envato purchase key">
                            </div>
                            @error('purchase_key')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            <?php
                            $text = str_replace('verify', '', url()->current());
                            ?>
                            <div class="form-group mb-3">
                                <input id="domain" type="hidden" class="form-control @error('domain') is-invalid @enderror" name="domain" required autocomplete="current-domain" value="{{ $text }}" readonly="">
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary w-100">{{ trans('labels.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection