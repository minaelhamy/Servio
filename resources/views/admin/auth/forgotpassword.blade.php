@extends('admin.layout.auth_default')
@section('content')

    <section>
        <div class="row align-items-center g-0 h-100vh position-relative">
            <div class="col-xl-7 col-lg-6 col-md-6 d-md-block d-none">
                <img src="{{ helper::image_path(helper::appdata('')->admin_auth_image) }}" class="object h-100vh w-100"
                    alt="">
            </div>
            <div class="col-xl-5 col-lg-6 col-md-6 overflow-hidden">
                <div class="d-flex h-100 justify-content-center align-items-center">
                    <div class="col-xl-8">
                        <div class="login-right-content h-100">
                            <div class="p-3">
                                <div class="text-primary d-flex justify-content-between">
                                    <div>
                                        <h2 class="fw-600 title-text text-color mb-2 color-changer">{{ trans('labels.forgotpassword') }}
                                        </h2>
                                        <p class="text-color color-changer">{{ trans('labels.forgot_sub_title') }}</p>
                                    </div>
                                    <!-- FOR SMALL DEVICE TOP CATEGORIES -->
                                    @if (@helper::checkaddons('language'))
                                        <div class="lag-btn dropdown border-0 shadow-none login-lang">
                                            <button class="border-0 bg-transparent language-dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <img src="{{ helper::image_path(session()->get('flag')) }}" alt=""
                                                    class="lag-img rounded-circle w-25">
                                            </button>
                                            <ul
                                                class="dropdown-menu rounded-1 mt-1 p-0 bg-body-secondary shadow border-0 rounded-3 overflow-hidden">
                                                @foreach (helper::listoflanguage() as $languagelist)
                                                    <li>
                                                        <a class="dropdown-item text-dark d-flex align-items-center px-2 gap-2 py-2"
                                                            href="{{ URL::to('/lang/change?lang=' . $languagelist->code) }}">
                                                            <img src="{{ helper::image_path($languagelist->image) }}"
                                                                alt="" class="img-fluid lag-img w-25">
                                                            {{ $languagelist->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <form class="mt-4" method="POST" action="{{ URL::to('/admin/send_password') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email" class="form-label fs-7 text-color">{{ trans('labels.email') }}
                                            <span class="text-danger"> * </span></label>
                                        <input type="email" class="form-control extra-padding text-color" name="email"
                                            value="" id="email" placeholder="{{ trans('labels.email') }}"
                                            required>
                                    </div>
                                    <button class="btn btn-primary padding w-100 my-3"
                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.submit') }}</button>
                                    <p class="fs-6 text-center mt-1 text-color color-changer">{{ trans('labels.remember_password') }}
                                        <a href="{{ URL::to('/admin') }}"
                                            class="text-secondary text-decoration fw-semibold">{{ trans('labels.sign_in') }}</a>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (env('Environment') == 'sendbox')
        <!-- themelabel trigar button -->
        <div data-bs-toggle="offcanvas" href="#themelabel" role="button" aria-controls="offcanvasExample">
            <div class="theme-label">
                <i class="fa-light fa-badge-percent text-white"></i>
                <div class="theme-label-name">theme</div>
            </div>
        </div>

        <!-- themelabel -->
        <div class="offcanvas {{ session()->get('direction') == 2 ? 'offcanvas-start' : 'offcanvas-end' }}" tabindex="-1"
            id="themelabel" aria-labelledby="offcanvasExampleLabel" data-bs-backdrop="false">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title text-capitalize" id="offcanvasExampleLabel">theme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="row px-3">
                    <a href="https://bookingdo.paponapps.co.in/theme-1" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/theme/theme-1.webp') }}"
                            class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center color-changer">Theme - 1</h5>
                        </div>
                    </a>

                    <a href="https://bookingdo.paponapps.co.in/theme-2" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/theme/theme-2.webp') }}"
                            class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center color-changer">Theme - 2</h5>
                        </div>
                    </a>

                    <a href="https://bookingdo.paponapps.co.in/theme-3" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/theme/theme-3.webp') }}"
                            class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center color-changer">Theme - 3</h5>
                        </div>
                    </a>

                    <a href="https://bookingdo.paponapps.co.in/theme-4" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/theme/theme-4.webp') }}"
                            class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center color-changer">Theme - 4</h5>
                        </div>
                    </a>

                    <a href="https://bookingdo.paponapps.co.in/theme-5" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/theme/theme-5.webp') }}"
                            class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center color-changer">Theme - 5</h5>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    @endif
@endsection
@section('scripts')
    <script>
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
@endsection
