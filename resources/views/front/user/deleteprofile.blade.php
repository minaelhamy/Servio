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
                        aria-current="page">{{ trans('labels.delete_account') }}</li>
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
                    <div class="col-xl-9 col-lg-8 col-xxl-9 col-12 deleteprofile">
                        <div class="card w-100 rounded-4 overflow-hidden">
                            <!-- Card header -->
                            <div
                                class="card-header bg-transparent color-changer border-bottom p-3 d-flex gap-3 align-items-center">
                                <i class="fa-solid fa-trash-can fs-4"></i>
                                <h5 class="title m-0 fw-500">{{ trans('labels.delete_account') }}</h5>
                            </div>
                            <!-- Card body START -->
                            <div class="card-body">
                                <h6 class="fw-600 color-changer">
                                    {{ trans('labels.before_go') }}
                                </h6>
                                <ol>
                                    <li class="text-muted">
                                        {{ trans('labels.take_backup') }}
                                        <a href="#" class="text-danger">
                                            {{ trans('labels.here') }}
                                        </a>
                                    </li>
                                    <li class="text-muted">
                                        {{ trans('labels.delete_message') }}
                                    </li>
                                </ol>
                                <div class="form-check form-check-md my-4 text-muted">
                                    <input class="form-check-input" type="checkbox" value="" id="delete_account"
                                        required>
                                    <label class="form-check-label" for="delete_account">
                                        {{ trans('labels.want_delete_account') }}
                                    </label>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0)"
                                        onclick="deleteaccount('{{ URL::to($vendordata->slug . '/deleteuseraccount-' . Auth::user()->id) }}')"
                                        class="col-sm-auto px-sm-4 col-12 btn rounded-3 fw-600 py-2 btn-danger btn-sm mb-0">
                                        {{ trans('labels.delete_my_account') }}
                                    </a>
                                </div>
                            </div>
                            <!-- Card body END -->
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
    <script>
        function deleteaccount(nexturl) {
            var deleted = document.getElementById("delete_account").checked;
            if (deleted == true) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-1',
                        cancelButton: 'btn btn-danger mx-1'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: are_you_sure,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: yes,
                    cancelButtonText: no,
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = nexturl;
                    } else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                })
            } else {
                toastr.error("{{ trans('messages.checkbox_delete_account') }}");
            }
        }
    </script>
@endsection
