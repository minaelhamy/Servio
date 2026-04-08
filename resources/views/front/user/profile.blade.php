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
                        aria-current="page">{{ trans('labels.edit_profile') }}</li>

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
                    <div class="col-xl-9 col-lg-8 col-xxl-9 col-12 profile">

                        <div class="card h-100 w-100 rounded-4 overflow-hidden">
                            <!------ Card header ------>
                            <div class="card-header bg-transparent border-bottom p-3 color-changer d-flex gap-3 align-items-center">
                                <i class="fa-regular fa-user fs-4"></i>
                                <h5 class="title m-0 fw-500">{{ trans('labels.my_profile') }}</h5>
                            </div>
                            <!------ Card body ------>
                            <!------------ form ------------>
                            <form action="{{ URL::to($vendordata->slug . '/editprofile') }}" method="post"
                                enctype="multipart/form-data">

                                <div class="card-body">
                                    <!-- Profile photo -->
                                    <div class="col-12 mb-3">
                                        <label class="form-label text-muted">{{ trans('labels.upload_profile_photo') }}<span
                                                class="text-danger">*</span></label>
                                        <div class="d-flex align-items-center">
                                            <!-- Avatar place holder -->
                                            <span class="avatar avatar-xl mx-3">
                                                <img class="avatar-img rounded-circle border border-white border-3 shadow"
                                                    src="{{ helper::image_path($getprofile->image) }}" alt="">
                                            </span>
                                            <!-- Upload button -->
                                            <label class="btn btn-sm btn-primary-rgb mb-0 btn-submit py-1 px-2 rounded-3"
                                                for="profileimage">{{ trans('labels.change') }}</label>
                                            <input id="profileimage" name="profileimage" class="form-control d-none"
                                                type="file">
                                        </div>
                                    </div>

                                    @csrf

                                    <div class="row">

                                        <div class="col-md-12 mb-3">

                                            <input type="hidden" value="{{ $getprofile->id }}" name="id">

                                            <label for="name"
                                                class="form-label text-muted">{{ trans('labels.name') }}<span
                                                    class="text-danger">*</span></label>

                                            <input type="text" class="form-control" name="name"
                                                placeholder="{{ trans('labels.name') }}" value="{{ $getprofile->name }}">

                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>

                                        <div class="col-md-12 mb-3">

                                            <label for="email"
                                                class="form-label text-muted">{{ trans('labels.email') }}<span
                                                    class="text-danger">*</span></label>

                                            <input type="text" class="form-control" name="email"
                                                placeholder="{{ trans('labels.email') }}" value="{{ $getprofile->email }}"
                                                readonly>

                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>

                                        <div class="col-md-12 mb-3">

                                            <label for="mobile"
                                                class="form-label text-muted">{{ trans('labels.mobile') }}<span
                                                    class="text-danger">*</span></label>

                                            <input type="text" class="form-control" name="mobile"
                                                placeholder="{{ trans('labels.mobile') }}"
                                                value="{{ $getprofile->mobile }}">

                                            @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>

                                    </div>
                                    <button class="btn btn-primary btn-submit rounded"
                                        type="submit">{{ trans('labels.save_changes') }}</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!-- newsletter -->
            @include('front.contact.index')
        </div>
    </section>
@endsection
