@extends('front.layout.master')
@section('content')
    <div class="container">
        <div class="breadcrumb-div pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ URL::to($vendordata->slug) }}" class="text-primary-color">
                            <i
                                class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.home') }}
                        </a>
                    </li>
                    <li class="breadcrumb-item  active {{ session()->get('direction') == '2' ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">{{ trans('labels.change_password') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="product-prev-sec product-list-sec">
        <div class="container">
            <h2 class="section-title fw-600">{{ trans('labels.account_details') }}</h2>
            <div class="user-bg-color mb-4">
                <div class="row g-3">
                    @include('front.user.commonmenu')
                    <div class="col-xl-9 col-lg-8 col-xxl-9 col-12 changepassword">
                        <div class="card h-100 w-100 rounded-4 overflow-hidden">
                            <!------ Card header ------>
                            <div class="card-header bg-transparent border-bottom color-changer p-3 d-flex gap-3 align-items-center">
                                <i class="fa fa-key fw-normal fs-4"></i>
                                <h5 class="title m-0 fw-500">{{ trans('labels.change_password') }}</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ URL::to($vendordata->slug . '/updatepassword') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label text-muted"
                                                for="current_password">{{ trans('labels.current_password') }}</label>
                                            <input type="password" class="form-control" name="current_password"
                                                placeholder="{{ trans('labels.current_password') }}" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label text-muted"
                                                for="new_password">{{ trans('labels.new_password') }}</label>
                                            <input type="password" class="form-control" name="new_password"
                                                placeholder="{{ trans('labels.new_password') }}" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label text-muted"
                                                for="confirm_password">{{ trans('labels.confirm_password') }}</label>
                                            <input type="password" class="form-control" name="confirm_password"
                                                placeholder="{{ trans('labels.confirm_password') }}" required>
                                        </div>

                                    </div>
                                    <button class="btn btn-primary btn-submit rounded"
                                        type="submit">{{ trans('labels.submit') }}</button>
                                </form>
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
